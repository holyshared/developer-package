<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php

Loader::library('mootools/attribute', MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

class GithubRepositoryBlockController extends BlockController {

	protected $btTable = 'btGithubRepository';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";

	public function getBlockTypeDescription() {
		return t("Tag list of github repository");
	}

	public function getBlockTypeName() {
		return t("Github Repository");
	}

	public function getJavaScriptStrings() {
		return array(
			"title"	=> "Please input a title.",
			"repos"	=> "Please select the repository.",
			"display-count"	=> "Please select the display number."
		);
	}

	public function view() {
		$this->set("repositories", $this->getUserRepositories());
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
		$db = Loader::db();
		$db->query("DELETE FROM btGithubRepositories WHERE bID = ?", array(intval($this->bID)));
		parent::delete();
	}

	public function save($values) {
		$repository = array(
			"title"	=> $values["title"],
			"user"	=> $values["user"]
		);
		
		$db = Loader::db();
		$db->query("DELETE FROM btGithubRepositories WHERE bID = ?", array(intval($this->bID)));
		$repos = $values["repos"];
		foreach ($repos as $key => $rp) {
			$db->query("INSERT INTO btGithubRepositories (bID, repos) VALUES (?, ?)", array($this->bID, $rp));
		}

		parent::save($repository);
	}

	protected function getUserRepositories() {
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$userName = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos($userName);

		return $repositories;
	}

}

?>