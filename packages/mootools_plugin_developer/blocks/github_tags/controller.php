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
			"title"	=> t("Please input a title."),
			"repos"	=> t("Please select the repository."),
			"display-count"	=> t("Please select the display number.")
		);
	}

	public function on_start() {
		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('form.css', MootoolsPluginDeveloperPackage::PACKAGE_HANDLE));
	}	
	
	public function view() {
		$this->set("tags", $this->getUserRepositoryTags());
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
	
	protected function getUserRepositories() {
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginDeveloperPackage::PACKAGE_HANDLE);
		$username = $this->getUserName();

		if (empty($username)) {
			return null;
		}

		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos($username);
		return $repositories;
	}

	protected function getUserRepositoryTags() {
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginDeveloperPackage::PACKAGE_HANDLE);

		$tags = array();
		$username = $this->getUserName();

		if (!empty($username)) {
			$github = new phpGitHubApi();
			$api = $github->getRepoApi();
			$tags = $api->getRepoTags($username, $this->repos);
		}
		return $tags;
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