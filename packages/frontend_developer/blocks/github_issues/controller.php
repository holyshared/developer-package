<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php

class GithubIssuesBlockController extends BlockController {

	protected $btTable = 'btGithubIssues';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";

	public function getBlockTypeDescription() {
		return t("The ticket of the github repository is displayed.");
	}

	public function getBlockTypeName() {
		return t("Github Issues");
	}

	public function getJavaScriptStrings() {
		return array(
			"title"	=> t("Please input a title."),
			"repos"	=> t("Please select the repository."),
			"display-count"	=> t("Please select the display number.")
		);
	}

	public function on_start() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->css('form.css', FRONTEND_DEVELOPER_PACKAGE_HANDLE));	
	}	
	
	public function view() {
		$diplayCount = 0;
		$displayIssues = array();

		$issues = $this->getUserRepositoryIssues();

		foreach($issues as $key => $issue){
			if ($diplayCount > $this->displayCount - 1){
				break;
			}
			$displayIssues[$key] = $issue;
			$diplayCount++;
		}
		$this->set("issues", $displayIssues);
	}

	public function add() {
		$u = new User();
		$this->set("uID", $u->getUserID());
		$this->set("userName", $this->getUserName());
		$this->set("repositories", $this->getUserRepositories());
	}

	public function edit() {
		$u = new User();
		$this->set("uID", $u->getUserID());
		$this->set("userName", $this->getUserName());
		$this->set("repositories", $this->getUserRepositories());
	}

	public function delete() {
		parent::delete();
	}

	public function save($data) {
		parent::save($data);
	}

	protected function getUserRepositoryIssues() {
		Loader::library("3rdparty/github/phpGitHubApi", FRONTEND_DEVELOPER_PACKAGE_HANDLE);

		$username = $this->getUserName();

		$github = new phpGitHubApi();
		$api = $github->getIssueApi();
		$issues = $api->getList($username, $this->repos);

		return $issues;
	}
	
	protected function getUserRepositories() {
		Loader::library("3rdparty/github/phpGitHubApi", FRONTEND_DEVELOPER_PACKAGE_HANDLE);

		$username = $this->getUserName();
		if (empty($username)) {
			return null;
		}

		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos($username);

		$rows = array();
		foreach ($repositories as $repos) {
			$key = $repos["name"];
			$rows[$key] = $repos;
		}
		return $rows;
	}
	
	protected function getUserName() {
		$username = $this->user;
		if (User::isLoggedIn()) {
			$u = new User();
			$ui = UserInfo::getByID($u->getUserID());
			$username = $ui->getAttribute(MOOTOOLS_GITHUB_USER);
		}
		return $username;
	}
	
}

?>