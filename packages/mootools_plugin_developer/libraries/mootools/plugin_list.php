<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php

class MootoolsPluginList {

	public function getMootoolsPluginPackage() {
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

	public function getMootoolsPluginFiles($fs) {
		Loader::model('file_set');
		Loader::model('file_list');

		$u = new User();
		$fl = new FileList();
		$fl->filterByMootoolsPlugin(true);
		$fl->filterByExtension("js");
		$fl->filter('u.uID', $u->getUserID(), '=');
		$fl->sortByAttributeKey("ak_".MOOTOOLS_PLUGIN_DISPLAY_ORDER);
		$fl->filterBySet($fs);
		$files = $fl->get();
		return $files;
	}

}

?>