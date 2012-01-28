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
		$this->addHeaderItem($html->css('form.css', FRONTEND_DEVELOPER_PACKAGE_HANDLE));
	}	
	
	public function view() {
		$displayCount = 0;
		$displayTags = array();

		$tags = $this->getUserRepositoryTags();

		foreach($tags as $key => $value){
			if ($displayCount > $this->displayCount - 1){
				break;
			}
			$displayTags[$key] = $value;
			$displayCount++;
		}

		$this->set("tags", $displayTags);
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
		Loader::library("3rdparty/github3/Github/Autoloader", FRONTEND_DEVELOPER_PACKAGE_HANDLE);

		Github_Autoloader::register();

		$username = $this->getUserName();
		if (empty($username)) {
			return null;
		}

		$github = new Github_Client();

		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos($username);
		return $repositories;
	}

	protected function getUserRepositoryTags() {
		Loader::library("3rdparty/github3/Github/Autoloader", FRONTEND_DEVELOPER_PACKAGE_HANDLE);

		Github_Autoloader::register();

		$tags = array();
		$username = $this->getUserName();

		if (!empty($username)) {
			$github = new Github_Client();
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