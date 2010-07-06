<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php

Loader::library('mootools/attribute', MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

class GithubRepositoryBlockController extends BlockController {

	protected $btTable = 'btGithubRepository';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";

	public function getBlockTypeDescription() {
		return t("The repository list of github is displayed. ");
	}

	public function getBlockTypeName() {
		return t("Github Repository");
	}

	public function getJavaScriptStrings() {
		return array(
			"title"	=> t("Please input a title."),
			"repos"	=> t("Please select the repository.")
		);
	}

	public function on_start(){
		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('style.css', "github_repository"));	
	}
	
	public function view() {
		$this->set("items", $this->loadRepositories());
		$this->set("repositories", $this->getUserRepositories());
	}

	public function add() {
		$this->set("userName", $this->getUserName());
		$this->set("repositories", $this->getUserRepositories());
	}

	public function edit() {
		$this->set("userName", $this->getUserName());
		$this->set("items", $this->loadRepositories());
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

	protected function loadRepositories() {
		$db = Loader::db();
		$sql = "SELECT * FROM btGithubRepositories WHERE bID = ?";
		$repositories = $db->getAll($sql, array(intval($this->bID))); 
		return $repositories;
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