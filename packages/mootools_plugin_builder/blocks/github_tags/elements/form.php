<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
//	$html = Loader::helper("html");
//	$this->addHeaderItem($html->css("style.css", MootoolsPluginBuilderPackage::PACKAGE_HANDLE));
	$t = Loader::helper('text');
	$f = Loader::helper('form');

	$userRepos = array();
	foreach ($repositories as $key => $repo) {
		$userRepos[] = $repo["name"];
	}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getBlockURL() ?>/style.css" media="screen" />
<fieldset>
	<legend>general</legend>
	<p>General setting</p>
	<dl>
		<dt>title&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->text("title", $title, array("id" => "title", "size" => 60)); ?></dd>
		<dt>repogitory&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->select("repos", $userRepos, $repos, array("repos" => "title")); ?></dd>
		<dt>display count<em class="required">required</em></dt>
		<dd><?php echo $f->text("displayCount", $title, array("id" => "displayCount", "size" => 20)); ?></dd>
	</dl>
</fieldset>