<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php 

class BuilderBlockController extends BlockController {
	
	protected $btTable = 'btBuilder';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	public function getBlockTypeDescription() {
		return t("Mootools Plugin Builder Block");
	}

	public function getBlockTypeName() {
		return t("Mootools Plugin Builder Block");
	}

	public function getJavaScriptStrings() {
		return array("aaa" => "aaa");
	}
	
	function delete(){
		parent::delete();
	}
	
	function loadBlockInformation() {
	}
	
	function view() {
	}

	function add() {
	}
	
	function edit() {
	}

	function save($data) {
		parent::save($data);
	}

}

?>