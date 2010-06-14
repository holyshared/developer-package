<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php

class GithubTagsBlockController extends BlockController {

	protected $btTable = 'btGithubTags';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";

	public function getBlockTypeDescription() {
		return t("Tag list of github repository");
	}

	public function getBlockTypeName() {
		return t("Github Tags");
	}

	public function getJavaScriptStrings() {
		return array(
			"title"	=> "Please input a title.",
			"repos"	=> "Please select the repository.",
			"display-count"	=> "Please select the display number."
		);
	}

	public function view() {
		$this->set("tags", $this->getUserRepositoryTags());
	}

	public function add() {
		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$this->set("userName", $userName);
		$this->set("repositories", $this->getUserRepositories());
	}

	public function edit() {
		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$this->set("userName", $userName);
		$this->set("repositories", $this->getUserRepositories());
	}

	public function delete() {
		parent::delete();
	}

	public function save($data) {
		parent::save($data);
	}

	protected function getUserRepositories() {
		Loader::library("3rdparty/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos($userName);

		return $repositories;
	}

	protected function getUserRepositoryTags() {
		Loader::library("3rdparty/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$tags = $api->getRepoTags($userName, $this->repos);

		return $tags;
	}
	
}

?>