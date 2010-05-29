<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('archive');
Loader::library('mootools/attribute', MootoolsPluginBuilderPackage::PACKAGE_HANDLE);

class PluginArchive extends Archive {

	private $_pluginPackageYAMLFile = "package.yml";
	private $_pluginSourceDirectory = "Source";

	public function __construct() {
		parent::__construct();
		$this->targetDirectory = DIR_APP_UPDATES;
	}

	public function install($file) {
		$dirBase = parent::install($file, true);
		return $this->targetDirectory.'/'.$dirBase;
	}
}


class JSONResponse {

	private $message = "";
	private $status	= true;
	private $parameters = array();

	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function setMessage($value) {
		$this->message = $value;
	}

	public function setParameter($name, $value) {
		$this->parameters[$name] = $value;
	}

	public function setParameters($parameters) {
		foreach($parameters as $key => $value) {
			$this->setParameter($key, $value);
		}
	}

	private function send() {
		$result = array(
			"status" => $this->status,
			"message" => $this->message,
			"parameters" => $this->parameters
		);
		$response = array("response" => $result);
		echo @json_encode($response);
		exit;
	}

	public function flush($message = null, $parameters = null, $status = null) {
		if (!empty($status)) $this->setStatus($status);
		if (!empty($message)) $this->setMessage($message);
		if (!empty($parameters)) $this->setParameters($parameters);
		$this->send();
	}

}


class DashboardMootoolsImporterController extends Controller {

	const GITHUB_URL = "http://github.com/";

	public function view() {
		$handle = MootoolsPluginBuilderPackage::PACKAGE_HANDLE;
		$html  = Loader::helper('html');
		$this->addHeaderItem($html->css('style.css', $handle));
		$this->addHeaderItem($html->javascript("jquery.importWizard.js", $handle));
		$this->addHeaderItem($html->javascript("jquery.progressbar.js", $handle));
	}

	public function step1() {
		$url	= $this->post("repository");

		$response = new JSONResponse();
		$response->setStatus(false);

		$query	= str_replace(DashboardMootoolsImporterController::GITHUB_URL, "", $url);

		$query	= explode("/", $query);
		$user	= array_shift($query);
		$repos	= array_shift($query);

		$result = array();
		if (empty($url)) {
			$response->setMessage("URL is not effective. Please confirm it.");
			$response->flush();
		}
		$response->setMessage("URL is effective.");
		$response->setParameters(array("user" => $user, "repos" => $repos));
		$response->setStatus(true);
		$response->flush();
	}

	public function step2() {
		$user	= $this->post("user");
		$repos	= $this->post("repos");

		$response = new JSONResponse();
		$response->setStatus(false);

		$url = sprintf(DashboardMootoolsImporterController::GITHUB_URL."api/v2/json/repos/show/%s/%s", $user, $repos);
		$json = file_get_contents($url);
		if ($json === false) {
			$response->setMessage("The repository was not able to be confirmed. Please confirm whether the repository exists.");
			$response->flush();
		}
		$response->setMessage("The repository was able to be confirmed.");
		$response->setParameters(array("user" => $user, "repos" => $repos));
		$response->setStatus(true);
		$response->flush();
	}

	public function step3() {
		$user	= $this->post("user");
		$repos	= $this->post("repos");

		$url = sprintf(DashboardMootoolsImporterController::GITHUB_URL."api/v2/json/repos/show/%s/%s/tags", $user, $repos);
		$contents = file_get_contents($url);
		$json = @json_decode($contents);

		$response = new JSONResponse();
		$response->setStatus(false);

		if (!$json) {
			$response->setMessage("Bad GitHub response. Try again later.");
			$response->flush();
		}

		$tags = array_keys((array) $json->tags);
		usort($tags, 'version_compare');
		
		if (empty($tags)) {
			$response->setMessage("GitHub repository has no tags. At least one tag is required.");
			$response->flush();
		}

		$response->setMessage("Tag was able to be confirmed.");
		$response->setParameters(array("user" => $user, "repos" => $repos,
			"tag" => array_shift($tags)));
		$response->setStatus(true);
		$response->flush();
	}

	public function step4() {
		$user	= $this->post("user");
		$repos	= $this->post("repos");
		$tag	= $this->post("tag");

		$response = new JSONResponse();
		$response->setStatus(false);

		$zipURL = sprintf(DashboardMootoolsImporterController::GITHUB_URL."%s/%s/zipball/%s", $user, $repos, $tag);
		$fh = Loader::helper('file');
		$pkg = $fh->getContents($zipURL);
		if (empty($pkg)) {
			$response->setMessage(Package::E_PACKAGE_DOWNLOAD);
			$response->flush();
		}

		$file = time();
		$tmpFile = $fh->getTemporaryDirectory().'/'.$file.'.zip';
		$fp = fopen($tmpFile, "wb");
		if ($fp) {
			fwrite($fp, $pkg);
			fclose($fp);
		} else {
			$response->setMessage(Package::E_PACKAGE_SAVE);
			$response->flush();
		}

		$response->setMessage("The archive was able to be downloaded.");
		$response->setParameters(array("user" => $user, "repos" => $repos,
			"file" => $file));
		$response->setStatus(true);
		$response->flush();
	}

	public function step5() {
		Loader::model('file_set');
		Loader::model('file_list');

		$response = new JSONResponse();
		$response->setStatus(false);

		$user	= $this->post("user");
		$repos	= $this->post("repos");
		$file	= $this->post("file");

/*
		$user	= "holyshared";
		$repos	= "Gradually";
		$file	= "1275149949";
*/

		$u = new User();
		$fs = FileSet::createAndGetSet($repos, 1, $u->getUserID());
		
		$existsFiles = $this->_getExistsFilesByFileset($fs);
		$result = $this->_importByArchive($fs, $file, $existsFiles);

		$response->setMessage("Plugin taking was completed.");
		$response->setParameter("files", $result);
		$response->setStatus(true);
		$response->flush();
	}

	private function _getExistsFilesByFileset($fs) {
		$fl = new FileList();
		$fl->filterByExtension("js");
		$fl->filterBySet($fs);
		$files = $fl->get();

		$setFiles = array();
		foreach($files as $f) {
			$fv = $f->getRecentVersion();
			$setFiles[$fv->getFileName()] = $f;
		}
		return $setFiles;
	}
	
	private function _importByArchive($fs, $archive, $existsFiles) {
		$plugin = new PluginArchive();
		$pluginDir = $plugin->install($archive);
		if ($pluginDir) {
			$dir = $pluginDir."/Source/";
			if ($dh = opendir($dir)) {
				$files = array();
				while (($file = readdir($dh)) !== false) {
					if (filetype($dir.$file) == 'file') {
						if (array_key_exists($file, $existsFiles)) {
							$fv = $this->_addFile($dir.$file, $setFiles[$file]);
						} else {
							$fv = $this->_addFile($dir.$file);
						}
						$fs->addFileToSet($fv);
						$files[$file] = $file;
					}
			    }
				closedir($dh);
			}
		}
		return $files;
	}

	private function _addFile($file, $fr = false) {
		Loader::library("file/importer");
		Loader::library("mootools/plugin_parser", MootoolsPluginBuilderPackage::PACKAGE_HANDLE);
		//$jsh = Loader::helper("json");
		$cf = Loader::helper("file");
		//$valt = Loader::helper('validation/token');

		$parser = new MootoolsPluginParser();
		$meta = $parser->parse($dir.$file);
		
		$fp = FilePermissions::getGlobal();
		if (!$fp->canAddFiles()) {
			$error = FileImporter::getErrorMessage(FileImporter::E_PHP_FILE_ERROR_DEFAULT);
			return $error;
		}

		$u = new User();
		if (!$fp->canAddFileType($cf->getExtension($file))) {
			$message = FileImporter::getErrorMessage(FileImporter::E_FILE_INVALID_EXTENSION);
			return $message;
		}
			
		$fi = new FileImporter();
		$fv = $fi->import($file, basename($file), $fr);
		if (!($fv instanceof FileVersion)) {
			$message = FileImporter::getErrorMessage($result);
			return $message;
		}

		$option = SelectAttributeTypeOption::getByValue(basename($file));
		if (empty($option)) {
			$ak = FileAttributeKey::getByHandle(MOOTOOLS_PLUGIN_DEPENDENCES);
			SelectAttributeTypeOption::add($ak, basename($file), true);
		}

		$authors = (is_array($meta["authors"])) ? join(",", $meta["authors"]) : $meta["authors"];
		$license = (is_array($meta["license"])) ? join(",", $meta["license"]) : $meta["license"];

		$fv->setAttribute(MOOTOOLS_PLUGIN, true);
		$fv->setAttribute(MOOTOOLS_PLUGIN_LICENSE, $license);
		$fv->setAttribute(MOOTOOLS_PLUGIN_AUTHORS, $authors);
		$fv->setAttribute(MOOTOOLS_PLUGIN_DEPENDENCES, null);
		$fv->updateDescription($meta["description"]);
		$fv->updateTags("mootools\nplugin");

		return $fv;
	}

}

?>