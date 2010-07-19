<?php

Loader::library("3rdparty/spyc", MootoolsPluginDeveloperPackage::PACKAGE_HANDLE);

class MootoolsPluginParser {

	private $meta;

	public function parse($file) {
		$contents = file_get_contents($file);
		preg_match_all('#(?m)/\*\s*(^---(\s*$.*?)^\.\.\.)\s*#sm', $contents, $comment);
		if (!isset($comment[2]) || !isset($comment[2][0]) || !$comment[2][0]){
			throw new ForgeJSParserException('Couldn\'t find required YAML header in JS file.');
		}
		$yaml = preg_replace('/$([\s]+)-/m', '$1 -', trim($comment[2][0]));
		$this->meta = Spyc::YAMLLoadString($yaml);
		return $this->meta;
	}

	public function getMeta() {
		return $this->meta;
	}
	
}

?>