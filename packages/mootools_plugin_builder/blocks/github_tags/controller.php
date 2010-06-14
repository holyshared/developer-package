<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php

class GithubTagsBlockController extends BlockController {

	protected $btTable = 'btGithubTags';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";

	public function getBlockTypeDescription() {
		return t("The form that does the plugin of Mootools in the packaging is offered.");
	}

	public function getBlockTypeName() {
		return t("Github Tags");
	}

	public function getJavaScriptStrings() {
		return array(
			"form-title"	=> "Please input a form title.",
			"download-file"	=> "Please input the file name when it downloads it."
		);
	}

	public function view() {
		Loader::library("3rdparty/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);
		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		//$tags = $api->getRepoTags("holyshared", $this->repos);
		$tags = $api->getRepoTags("holyshared", "MMap");
		$this->set("tags", $tags);
	}

	public function add() {
		Loader::library("3rdparty/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);
		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos("holyshared");
		$this->set("repositories", $repositories);
	}

	public function edit() {
		Loader::library("3rdparty/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);
		$github = new phpGitHubApi();
		$api = $github->getRepoApi();
		$repositories = $api->getUserRepos("holyshared");
		$this->set("repositories", $repositories);
	}

	public function delete(){
		parent::delete();
	}

	public function save($data) {
		parent::save($data);
	}

}

?>