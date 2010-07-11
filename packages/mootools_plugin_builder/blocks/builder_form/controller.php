<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php 

Loader::library('mootools/plugin_list', MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

class BuilderFormBlockController extends BlockController {
	
	protected $btTable = 'btBuilderForm';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	public function getBlockTypeDescription() {
		return t("The form that does the plugin of Mootools in the packaging is offered.");
	}

	public function getBlockTypeName() {
		return t("Mootools Plugin Builder Form");
	}

	public function getJavaScriptStrings() {
		return array(
			"form-title"	=> t("Please input a form title."),
			"download-file"	=> t("Please input the file name when it downloads it.")
		);
	}

	public function on_start() {
		Loader::model('package');
		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('form.css', MootoolsPluginBuilderPackage::PACKAGE_HANDLE));	
	}

	public function view() {
		$urls = Loader::helper('concrete/urls');
		$pkg = Package::getByHandle(MootoolsPluginBuilderPackage::PACKAGE_HANDLE);
		$this->set("pkg", $pkg);
		$this->set("url", $urls);
		$this->set("bID", $this->bID);
		$this->set("filesets", $this->getBuildFileSets());
	}
	
	public function add() {
		$pl = new MootoolsPluginList();
		$filesets = $pl->getMootoolsPluginPackage();

		$this->set("current", $this->getLoadFileSet());
		$this->set("filesets", $filesets);
	}

	public function edit() {
		$this->add();
	}

	public function delete(){
		$db = Loader::db();
		$db->query("DELETE FROM btBuilderPackage WHERE bID = ?", array(intval($this->bID)));
		parent::delete();
	}

	public function save($data) {
		$db = Loader::db();
		$db->query("DELETE FROM btBuilderPackage WHERE bID = ?", array(intval($this->bID)));
		$fsIDs = $this->post("fsID");
		foreach ($fsIDs as $key => $fsID) {
			$db->query("INSERT INTO btBuilderPackage VALUES (?, ?, ?)", array($this->bID, $fsID, $key));
		}

		$u = new User();
		$data["uID"] = $u->getUserID();

		parent::save($data);
	}

	public function action_publish() {
		
		$ip = Loader::helper('validation/ip');
		if (!$ip->check()) {
			$e = Loader::helper('validation/error');
			$e->add($ip->getErrorMessage());
			$this->set("error", $e);			
			return;
		}

		$v = Loader::helper("validation/form");
		$v->setData($this->post());
		$v->addRequired("module", t("Please select a necessary module."));
		$v->addRequired("packType", t("Please select the compressed method."));
		if (!$v->test()) {
			$this->set("error", $v->getError());
			return;
		}

		$t = Loader::helper("validation/token");
		if (!$t->validate()) {
			$e = Loader::helper('validation/error');
			$e->add($t->getErrorMessage());
			$this->set("error", $e);			
			return;
		}
		$this->buildScript();
	}

	protected function getBuildFileSets() {
		Loader::model('file_set');
		Loader::model('file_list');

		$pl = new MootoolsPluginList();
		
		$rows = array();
		$fsets = $this->getLoadFileSet();
		foreach($fsets as $key => $fsID) {
			$fs = FileSet::getByID($fsID);
			$name = $fs->getFileSetName();
			
			$files = $pl->getMootoolsPluginFiles($fs);
			$rows[$name] = $files;

		}
		return $rows;
	}

	protected function getLoadFileSet() {
		$db = Loader::db();
		$result = $db->getAll("SELECT fsID FROM btBuilderPackage WHERE bID = ? order by orderNumber", array(intval($this->bID)));
		$fsets = array();
		foreach($result as $fs) {
			$fsets[] = $fs["fsID"];
		}
		return $fsets;
	}

	protected function buildScript() {

		$pkgHandle = MootoolsPluginBuilderPackage::PACKAGE_HANDLE;
		
		Loader::library("3rdparty/jsminify/JSMin", $pkgHandle);
		Loader::library("3rdparty/jsminify/Minify/YUICompressor", $pkgHandle);
		Loader::model('file_list');
		$fh = Loader::helper('file');

		$files = $this->post("module");
		$packType = $this->post("packType");

		$output = "";
		$pl = new MootoolsPluginList();
		foreach ($files as $key => $fID) {
			$file = File::getByID($fID);
			$output .= file_get_contents($file->getPath())."\n";
		}

		switch($packType) {
			case 2: $output = JSMin::minify($output); break;
			case 3: break;
			case 1:
			default:
				$yui = DIR_PACKAGES.'/'.$pkgHandle.'/'.DIRNAME_LIBRARIES.'/'.'3rdparty/yui/yuicompressor-2.4.2.jar';
				$tmp = $fh->getTemporaryDirectory().'/';

				Minify_YUICompressor::$jarFile = $yui;
				Minify_YUICompressor::$tempDir = $tmp;
				$output = Minify_YUICompressor::minifyJs($output); 			
		}

		$file = $this->javascript.".js";
		header("Content-disposition: attachment; filename=".$file);
		header("Content-type: application/octet-stream; name=".$file);
		echo $output;
		exit;
	}

}

?>