<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php 

class BuilderBlockController extends BlockController {
	
	protected $btTable = 'btBuilder';
	protected $btInterfaceWidth = "550";
	protected $btInterfaceHeight = "400";
	
	public function getBlockTypeDescription() {
		return t("Mootools Plugin Builder Form");
	}

	public function getBlockTypeName() {
		return t("Mootools Plugin Builder Form");
	}

	public function getJavaScriptStrings() {
		return array("aaa" => "aaa");
	}

	public function loadBlockInformation() {
	}

	public function on_before_render() {
//		$this->addHeaderItem($item);
	}

	public function view() {
		Loader::model('file_set');
		Loader::model('file_list');

		$fssets = array();

		$fs = new FileSet();
		$userFilesets = $fs->getMySets();
		foreach ($userFilesets as $fileset) {
			$fl = new FileList();
			$fl->filterBySet($fileset);
			$fl->filterByExtension("js");
			$files = $fl->get();

			$flist = array();
			foreach ($files as $file) {
				
				$attributes = array();
				$fv = $file->getVersion();
				$fa = $fv->getAttributeList();
//				$fa = FileAttributeKey::getAttributes($file->fID, $fv->getFileVersionID());
				while ($fa->valid()) {
					$attribute = $fa->current();
					$attributes[$fa->key()] = $attribute;
					$fa->next();
				}

				$f = new stdClass();
/*				foreach ($fv as $key => $value) {
					$f->{$key} = $value;
				}
				*/
				$f->id = $fv->getFileID();
				$f->name = $fv->getFileName();
				$f->title = $fv->getTitle();
				$f->tags = $fv->getTags();
				$f->author = $fv->getAuthorName();
				$f->dateAdded = $fv->getDateAdded();
				$f->description = $fv->getDescription();
				
/*
	public function getFileID() {return $this->fID;}
	public function getFileVersionID() {return $this->fvID;}
	public function getPrefix() {return $this->fvPrefix;}
	public function getFileName() {return $this->fvFilename;}
	public function getTitle() {return $this->fvTitle;}
	public function getTags() {return $this->fvTags;} 
	public function getDescription() {return $this->fvDescription;}
	public function isApproved() {return $this->fvIsApproved;}
	*/			
				
				$f->attributes = $attributes;
				$flist[] = $f;
			}

			$fs = new stdClass();
			$fs->id = $fileset->fsID;
			$fs->name = $fileset->fsName;
			$fs->files = $flist;

			$fssets[$fileset->fsID] = $fs;
		}
		$this->set("filesets", $fssets);
	}

	public function add() {
/*		Loader::model('file_set');
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
*/
		$this->set("filesets", $this->getLoadUserFileSet());
	}

	public function edit() {
		$this->set("filesets", $this->getLoadUserFileSet());
	}

	public function delete(){
		parent::delete();
	}
	
	public function save($data) {
		$db = Loader::db();
		$db->query("DELETE FROM btBuilderPackage WHERE bID=".intval($this->bID));

		
		
		
		
		parent::save($data);
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
	
}

?>