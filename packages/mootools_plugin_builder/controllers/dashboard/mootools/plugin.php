<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('mootools/attribute', MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

class DashboardMootoolsPluginController extends Controller {

	public function view() {
		$handle = MootoolsPluginBuilderPackage::PACKAGE_HANDLE;

		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('style.css', $handle));

		$u = new User();
		$ui = UserInfo::getByID($u->getUserID());
		$username = $ui->getAttribute(MOOTOOLS_GITHUB_USER);

		$this->set("uID", $u->getUserID());
		$this->set("username", $username);
		$this->set("pkgHandle", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);
		$this->set("plugins", $this->getMootoolsPluginPackage());

		$this->set("filesets", $this->getMootoolsPluginFiles());
	}

	private function getMootoolsPluginPackage() {
		Loader::model('file_set');
		Loader::model('file_list');

		$u = new User();
		$fl = new FileList();
		$fl->filterByMootoolsPlugin(true);
		$fl->filterByExtension("js");
		$fl->filter('u.uID', $u->getUserID(), '=');
		$files = $fl->get();

		$ufsets = array();
		foreach($files as $file) {
			$fsets = $file->getFileSets();
			foreach ($fsets as $fset) {
				$ufsets[$fset->getFileSetID()] = $fset;
			}
		}
		return $ufsets;
	}

	
	private function getMootoolsPluginFiles() {
		Loader::model('file_set');
		Loader::model('file_list');

		$u = new User();
		$fl = new FileList();
		$fl->filterByMootoolsPlugin(true);
		$fl->filterByExtension("js");
		$fl->filter('u.uID', $u->getUserID(), '=');
		$files = $fl->get();

		$ufsets = array();
		foreach($files as $file) {
			$fsets = $file->getFileSets();
			foreach ($fsets as $fset) {
				$name = $fset->getFileSetName();
				if (!is_array($ufsets[$name])) {
					$ufsets[$name] = array();
				}
				$ufsets[$name][] = $file;
			}
		}
		return $ufsets;
	}
	
}

?>