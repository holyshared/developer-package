<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('mootools/attribute', MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

class DashboardMootoolsPluginController extends Controller {

	public function view() {
		Loader::library("3rdparty/github/phpGitHubApi", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$handle = MootoolsPluginBuilderPackage::PACKAGE_HANDLE;
		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('style.css', $handle));

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$username = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$rows = array();
		if (!empty($username)) {
			$github = new phpGitHubApi();
			$api = $github->getRepoApi();
			$repositories = $api->getUserRepos($username);

			foreach ($repositories as $repos) {
				$key = $repos["name"];
				$rows[$key] = $repos;
			}
		}
		$this->set("uID", $u->getUserID());
		$this->set("username", $username);
		$this->set("repos", $rows);
	}

}

?>