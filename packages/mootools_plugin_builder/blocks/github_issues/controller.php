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
		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('style.css', "github_issues"));	
	}	
	
	public function view() {
		$this->set("issues", $this->getUserRepositoryIssues());
	}

	public function add() {
		$this->set("userName", $this->getUserName());
		$this->set("repositories", $this->getUserRepositories());
	}

	public function edit() {
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
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$username = $this->getUserName();

		$github = new phpGitHubApi();
		$api = $github->getIssueApi();
		$issues = $api->getList($username, $this->repos);

		return $issues;
	}
	
	protected function getUserRepositories() {
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$username = $this->getUserName();

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