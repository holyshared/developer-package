<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php

class GithubIssuesBlockController extends BlockController {

	protected $btTable = 'btGithubIssues';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";

	public function getBlockTypeDescription() {
		return t("Tag list of github repository");
	}

	public function getBlockTypeName() {
		return t("Github Issues");
	}

	public function getJavaScriptStrings() {
		return array(
			"title"	=> "Please input a title.",
			"repos"	=> "Please select the repository.",
			"display-count"	=> "Please select the display number."
		);
	}

	public function view() {
		$this->set("issues", $this->getUserRepositoryIssues());
	}

	public function add() {
		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$this->set("repositories", $this->getUserRepositories());
		$this->set("userName", $userName);
	}

	public function edit() {
		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$this->set("repositories", $this->getUserRepositories());
		$this->set("userName", $userName);
	}

	public function delete() {
		parent::delete();
	}

	public function save($data) {
		parent::save($data);
	}

	
	protected function getUserRepositoryIssues() {
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$github = new phpGitHubApi();
		$api = $github->getIssueApi();
		$issues = $api->getList($this->user, $this->repos);

		return $issues;
	}
	
	
	
	protected function getUserRepositories() {
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos($userName);

		$rows = array();
		foreach ($repositories as $repos) {
			$key = $repos["name"];
			$rows[$key] = $repos;
		}
		return $rows;
	}
	
	
	
	
	
	
}

?>