<?php

Loader::library("3rdparty/spyc", FRONTEND_DEVELOPER_PACKAGE_HANDLE);

class MootoolsPluginImporter {

	private $_exists = array();
	private $_fileset = null;
	private $_components = array();

	public function __construct($fs) {
		$this->_fileset = $fs;
		$this->_prepare($fs);
	}

	private function _prepare($fs) {
		$fl = new FileList();
		$fl->filterByExtension("js");
		$fl->filterBySet($fs);
		$files = $fl->get();

		$setFiles = array();
		foreach($files as $f) {
			$fv = $f->getRecentVersion();
			$fn = $fv->getFileName();
			$this->_exists[$fn] = $f;
		}
	}

	public function getExistFile($file) {
		if (array_key_exists($file, $this->_exists)) {
			return $this->_exists[$file];
		} else {
			return false;
		}
	}

	public function canImport($file) {
		$cf = Loader::helper("file");

		$fp = FilePermissions::getGlobal();
		if (!$fp->canAddFiles()) {
			$message = FileImporter::getErrorMessage(FileImporter::E_PHP_FILE_ERROR_DEFAULT);
			return $message;
		}

		if (!$fp->canAddFileType($cf->getExtension($file))) {
			$message = FileImporter::getErrorMessage(FileImporter::E_FILE_INVALID_EXTENSION);
			return $message;
		}
		return true;
	}

	public function getComponentFiles($dir) {
		$this->_components = array();
		$this->_traverseDirectory($dir);
		return $this->_components;
	}

	private function _traverseDirectory($dir) {
		$dh = opendir($dir);
		if ($dh === false) {
			return false;
		}

		$files = array();
		while (($file = readdir($dh)) !== false) {
			$fileOrDir = $dir . '/' . $file;
			if ($file == '.' || $file == '..') {
				continue;
			}
			switch(filetype($fileOrDir)) {
				case 'file':
					$this->_components[$file] = $fileOrDir;
					break;
				case 'dir':
					$this->_traverseDirectory($fileOrDir);
					break;
			}
		}
		closedir($dh);
	}
	
	public function addFile($file) {
		Loader::library("file/importer");
		Loader::library("mootools/plugin_parser", FRONTEND_DEVELOPER_PACKAGE_HANDLE);

		$fi = new FileImporter();
		$fv = $fi->import($file, basename($file), $this->getExistFile(basename($file)));
		if (!($fv instanceof FileVersion)) {
			$message = FileImporter::getErrorMessage($result);
			return $message;
		}

		$parser = new MootoolsPluginParser();
		$meta = $parser->parse($file);

		$requireValues = array();
		if (is_array($meta["requires"]))  {
			$requires = $meta["requires"];
			foreach($requires as $module) {
				$option = SelectAttributeTypeOption::getByValue($module);
				if (empty($option)) {
					$ak = FileAttributeKey::getByHandle(MOOTOOLS_PLUGIN_DEPENDENCES);
					$type = SelectAttributeTypeOption::add($ak, $module, true);
					$value = $type->getSelectAttributeOptionValue();
				} else {
					$value = $option->getSelectAttributeOptionValue();
				}
				$requireValues[$value] = $value;
			}
		}

		$namespaces = explode('.', $meta['name']);
		$packageName = array_shift($namespaces);
		$moduleName = str_replace('.js', '', basename($file));

		$componentName = $packageName . '/' . $moduleName;
		$authors = (is_array($meta["authors"])) ? join(",", $meta["authors"]) : $meta["authors"];
		$license = (is_array($meta["license"])) ? join(",", $meta["license"]) : $meta["license"];

		$fv->setAttribute(MOOTOOLS_PLUGIN, true);
		$fv->setAttribute(MOOTOOLS_COMPONENT_NAME, $componentName);
		$fv->setAttribute(MOOTOOLS_PLUGIN_LICENSE, $license);
		$fv->setAttribute(MOOTOOLS_PLUGIN_AUTHORS, $authors);
		$fv->setAttribute(MOOTOOLS_PLUGIN_DEPENDENCES, $requireValues);
		$fv->setAttribute(MOOTOOLS_PLUGIN_DISPLAY_ORDER, 0);
		$fv->updateDescription($meta["description"]);
		$fv->updateTags("mootools\nplugin");

		$this->_fileset->addFileToSet($fv);
		
		return $fv;
	}

}