<?php 

defined('C5_EXECUTE') or die(_('Access Denied.'));

class FrontendDeveloperPackage extends Package {

	const PACKAGE_HANDLE = 'frontend_developer';

	protected $pkgHandle = FrontendDeveloperPackage::PACKAGE_HANDLE;
	protected $appVersionRequired = '5.4.0';
	protected $pkgVersion = '1.0';

	public function getPackageName() {
		return t('Frontend Developer Package');
	}
	
	public function getPackageDescription() { 
		return t('Add-on package for Frontend Developer');
	}

	public function install() {

		Loader::library('mootools/attribute', FrontendDeveloperPackage::PACKAGE_HANDLE);

		$pkg = parent::install();

		Loader::model('single_page');
		Loader::model('attribute/categories/user');
		Loader::model('attribute/categories/file');

		$singlePages = array(
			"/dashboard/mootools" => array(
				'cName' => 'Mootools Plugin Developer',
				'cDescription'	=> 'Management of mootools plugin'
			),
			"/dashboard/mootools/plugin" => array(
				'cName' => 'plugin',
				'cDescription'	=> 'Management of Mootools Plugin that does import'
			),
			"/dashboard/mootools/importer" => array(
				'cName' => 'import',
				'cDescription'	=> 'Import from repository'
			)
		);
		foreach ($singlePages as $key => $page) {
			$collection = SinglePage::add($key, $pkg);
			if (!empty($collection)) {
	        	$collection->update($page);
			}
		}

		//The name of the user of github is added to the attribute.
		$values = array(
			"akHandle" => MOOTOOLS_GITHUB_USER, "akName" => "Name of user of github",
			"akIsSearchable" => true, "akIsSearchableIndexed" => true, "akIsAutoCreated" => true, "akIsEditable" => true
		);
		$key = UserAttributeKey::add("text", $values, $pkg);

		
		$fileAttributes = array(
			array(
				"type" => "boolean",
				"values" => array(
					"akHandle" => MOOTOOLS_PLUGIN,
					"akName" => "This file is a plugin of mootools",
					"akIsSearchable" => true,
					"akIsSearchableIndexed" => true,
					"akIsAutoCreated" => true,
					"akIsEditable" => true
				)
			),
			array(
				"type" => "text",
				"values" => array(
					"akHandle" => MOOTOOLS_PLUGIN_LICENSE,
					"akName" => "License of Mootools plugin",
					"akIsSearchable" => true,
					"akIsSearchableIndexed" => true,
					"akIsAutoCreated" => true,
					"akIsEditable" => true
				)
			),
			array(
				"type" => "text",
				"values" => array(
					"akHandle" => MOOTOOLS_PLUGIN_AUTHORS,
					"akName" => "Authors of Mootools plugin",
					"akIsSearchable" => true,
					"akIsSearchableIndexed" => true,
					"akIsAutoCreated" => true,
					"akIsEditable" => true
				)
			),
			array(
				"type" => "select",
				"values" => array(
					"akHandle" => MOOTOOLS_PLUGIN_DEPENDENCES,
					"akName" => "Dependence of mootools plugin",
					"akIsSearchable" => true,
					"akIsSearchableIndexed" => true,
					"akIsAutoCreated" => true,
					"akIsEditable" => true
				)
			),
			array(
				"type" => "number",
				"values" => array(
					"akHandle" => MOOTOOLS_PLUGIN_DISPLAY_ORDER,
					"akName" => "The order of display of mootools plugin",
					"akIsSearchable" => true,
					"akIsSearchableIndexed" => true,
					"akIsAutoCreated" => true,
					"akIsEditable" => true
				)
			)
		);

		$attributesKeys = array();
		foreach ($fileAttributes as $key => $attr) {
			$type = $attr["type"];
			$values = $attr["values"];
			$handle = $values["akHandle"];
			$attributesKeys[$handle] =	FileAttributeKey::add($type, $values, $pkg);	
		}

		if (!empty($attributesKeys[MOOTOOLS_PLUGIN_DEPENDENCES])) {
			$key = $attributesKeys[MOOTOOLS_PLUGIN_DEPENDENCES];
			$db = Loader::db();
			$db->Replace('atSelectSettings', array(
				'akID' => $key->getAttributeKeyID(),
				'akSelectAllowMultipleValues' => true
			), array('akID'), true);
		}

		BlockType::installBlockTypeFromPackage("mootools_plugin_build_form", $pkg);
		BlockType::installBlockTypeFromPackage("github_tags", $pkg);
		BlockType::installBlockTypeFromPackage("github_issues", $pkg);
		BlockType::installBlockTypeFromPackage("github_repository", $pkg);

		PageTheme::add('small_project', $pkg);
	}

	public function uninstall() {
		parent::uninstall();
	}
}