<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php 

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
			"form-title"	=> "Please input a form title.",
			"download-file"	=> "Please input the file name when it downloads it."
		);
	}

	public function loadBlockInformation() {
	}

	public function view() {
		$this->set("bID", $this->bID);
		$this->set("filesets", $this->getBuildFileSets());
	}

	public function add() {
		$this->set("current", $this->getLoadFileSet());
		$this->set("filesets", $this->getLoadUserFileSet());
	}

	public function edit() {
		$this->set("current", $this->getLoadFileSet());
		$this->set("filesets", $this->getLoadUserFileSet());
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
			$db->query("INSERT INTO btBuilderPackage VALUES (?, ?, ?)", array($fsID, $this->bID, $key));
		}
		parent::save($data);
	}

	public function action_publish() {
		$filesets = $this->post("module");

		Loader::model('file_list');

		$u = new User();
		$fl = new FileList();
		$fl->filterByMootoolsPlugin(true);
		$fl->filterByExtension("js");
		$fl->filter('u.uID', $u->getUserID(), '=');
		$fl->filter('f.fID', $filesets, '=');
		$files = $fl->get();

		$output = "";
		foreach ($files as $key => $file)  {
			$output .= file_get_contents($file->getPath())."\n";
		}

		$file = $this->javascript.".js";
		header("Content-disposition: attachment; filename=".$file);
		header("Content-type: application/octet-stream; name=".$file);
		echo $output;
		exit;
	}

	protected function getBuildFileSets() {
		Loader::model('file_set');
		Loader::model('file_list');

		$rows = array();
		$fsets = $this->getLoadFileSet();
		foreach($fsets as $key => $fsID) {
			$fs = FileSet::getByID($fsID);

			$fileset = new stdClass();
			$fileset->id = $fs->fsID;
			$fileset->name = $fs->fsName;
			$fileset->files = $this->getFilesetFiles($fs);
			$rows[$fileset->id] = $fileset;
		}
		return $rows;
	}

	private function getFilesetFiles($fs) {
		$fl = new FileList();
		$fl->filterBySet($fs);
		$fl->filterByExtension("js");
		$files = $fl->get();

		$rows = array();
		foreach ($files as $file) {
			$attributes = array();
			$fv = $file->getVersion();
			$fa = $fv->getAttributeList();
			while ($fa->valid()) {
				$attribute = $fa->current();
				$attributes[$fa->key()] = $attribute;
				$fa->next();
			}

			$f = new stdClass();
			$f->id = $fv->getFileID();
			$f->name = $fv->getFileName();
			$f->title = $fv->getTitle();
			$f->tags = $fv->getTags();
			$f->author = $fv->getAuthorName();
			$f->dateAdded = $fv->getDateAdded();
			$f->description = $fv->getDescription();
			$f->attributes = $attributes;
			$rows[] = $f;
		}
		return $rows;
	}

	protected function getLoadUserFileSet() {
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

	protected function getLoadFileSet() {
		$db = Loader::db();
		$result = $db->getAll("SELECT fsID FROM btBuilderPackage WHERE bID = ? order by orderNumber", array(intval($this->bID)));
		$fsets = array();
		foreach($result as $fs) {
			$fsets[] = $fs["fsID"];
		}
		return $fsets;
	}
	
}

?>