<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('mootools/attribute', FrontendDeveloperPackage::PACKAGE_HANDLE);
Loader::library('mootools/plugin_list', FrontendDeveloperPackage::PACKAGE_HANDLE);

class DashboardMootoolsPluginController extends Controller {

	public function view() {
		$handle = FrontendDeveloperPackage::PACKAGE_HANDLE;
		$pl = new MootoolsPluginList();

		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('style.css', $handle));

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$username = $ui->getAttribute(MOOTOOLS_GITHUB_USER);
		$plugins = $pl->getMootoolsPluginPackage();

		if (is_array($plugins) && count($plugins) > 0) {
			$fs = array_slice($plugins, 0, 1);
			$fs = array_shift($fs);
			$files = $pl->getMootoolsPluginFiles($fs);
			$filesets[$fs->getFileSetName()] = $files;
		}
		$this->set("uID", $u->getUserID());
		$this->set("username", $username);
		$this->set("pkgHandle", FrontendDeveloperPackage::PACKAGE_HANDLE);
		$this->set("plugins", $plugins);
		$this->set("filesets", $filesets);
		$this->set("searchInstance", 'file'.time());
	}

	public function package() {
		Loader::model('file_set');

		$pl = new MootoolsPluginList();

		$package = $this->post("package");
		$fs = Fileset::getByName($package);

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$username = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$pkgHandle = FrontendDeveloperPackage::PACKAGE_HANDLE;
		$uID = $u->getUserID();

		$files = $pl->getMootoolsPluginFiles($fs);
		$filesets[$fs->getFileSetName()] = $files;

		$package = Package::getByHandle($pkgHandle);
		$path = $package->getPackagePath();
		include($path."/elements/plugin_files.php");
		exit;
	}

	public function update() {
		Loader::model('file');
		Loader::model('attribute/categories/file');
		
		$fIDs = $this->post("fID");
		foreach ($fIDs as $key => $id) {
			$f = File::getByID($id);
			$fv = $f->getRecentVersion();
			$fv->setAttribute(MOOTOOLS_PLUGIN_DISPLAY_ORDER, $key);
		}
		$this->view();
	}

}

?>