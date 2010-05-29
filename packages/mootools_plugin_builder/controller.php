<?php 

defined('C5_EXECUTE') or die(_('Access Denied.'));

class MootoolsPluginBuilderPackage extends Package {

	const PACKAGE_HANDLE = 'mootools_plugin_builder';

	protected $pkgHandle = MootoolsPluginBuilderPackage::PACKAGE_HANDLE;
	protected $appVersionRequired = '5.4.0';
	protected $pkgVersion = '1.0';

	public function getPackageDescription() { 
		return t('Mootools Plugin Builder Package');
	}
	
	public function getPackageName() {
		return t('Mootools Plugin Builder Package');
	}
	
	public function install() {

		Loader::library('mootools/attribute', MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

		$pkg = parent::install();

		Loader::model('single_page');
		Loader::model('attribute/categories/file');
		$collection = SinglePage::add("/dashboard/mootools", $pkg);
		if (!empty($collection)) {
        	$collection->update(array('cName' => 'Mootools Plugin Manager', 'cDescription'	=> 'Management of mootools plugin'));
		}
		$collection = SinglePage::add("/dashboard/mootools/importer", $pkg);
		if (!empty($collection)){
        	$collection->update(array('cName' => 'import', 'cDescription'	=> 'Importing of repository'));
		}

		$values = array(
			"akHandle" => MOOTOOLS_PLUGIN, "akName" => "This file is a plugin of mootools.",
			"akIsSearchable" => true, "akIsSearchableIndexed" => true, "akIsAutoCreated" => true, "akIsEditable" => true
		);
		$key = FileAttributeKey::add("boolean", $values, $pkg);		

		$values = array(
			"akHandle" => MOOTOOLS_PLUGIN_LICENSE, "akName" => "license.",
			"akIsSearchable" => true, "akIsSearchableIndexed" => true, "akIsAutoCreated" => true, "akIsEditable" => true
		);
		$key = FileAttributeKey::add("text", $values, $pkg);

		$values = array(
			"akHandle" => MOOTOOLS_PLUGIN_AUTHORS, "akName" => "authors.",
			"akIsSearchable" => true, "akIsSearchableIndexed" => true, "akIsAutoCreated" => true, "akIsEditable" => true
		);
		$key = FileAttributeKey::add("text", $values, $pkg);

		$values = array(
			"akHandle" => MOOTOOLS_PLUGIN_DEPENDENCES, "akName" => "Dependence of mootools plugin",
			"akIsSearchable" => true, "akIsSearchableIndexed" => true, "akIsAutoCreated" => true, "akIsEditable" => true
		);
		$key = FileAttributeKey::add("select", $values, $pkg);

		$db = Loader::db();
		$db->Replace('atSelectSettings', array('akID' => $key->getAttributeKeyID(), 'akSelectAllowMultipleValues' => true), array('akID'), true);

		BlockType::installBlockTypeFromPackage("builder", $pkg);

		PageTheme::add('script_builder', $pkg);
	}

	public function uninstall() {
		parent::uninstall();
	}
}