<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$html = Loader::helper("html");
	$this->addHeaderItem($html->css("style.css", MootoolsPluginBuilderPackage::PACKAGE_HANDLE));

	$t = Loader::helper('text');
	$f = Loader::helper('form');

	$packages = array();
	foreach($filesets as $key => $fileset) {
		$packages[$fileset->fsID] = $fileset->fsName;
	}
	$json = json_encode($packages);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getBlockURL() ?>/css/style.css" media="screen" />
<script type="text/javascript">var PluginPackages = <?php echo $json; ?>;</script>

<?php if (count($packages) <= 0) : ?>
<p><em class="warning">The plugin was not found. <br />
Please do the plugin from the repository of github importing.</em></p>
<p><a href="<?php echo $this->url("dashboard/mootools/importer") ?>">It moves to the import page.</a></p>
<?php endif; ?>

<p>Please select the plug-in name displayed in the list of the form.</p>
<fieldset>
	<legend>general</legend>
	<p>General setting</p>
	<dl>
		<dt>form title&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->text("title", $title, array("size" => 60)); ?></dd>
		<dt>description of form</dt>
		<dd><?php echo $f->text("description", $description, array("size" => 80)); ?></dd>
		<dt>Download file name&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->text("javascript", $javascript, array("size" => 20)); ?>.js</dd>
	</dl>
</fieldset>

<fieldset>
	<legend>plugins</legend>
	<p>Plugin displayed in form</p>
	<ul id="packageList" class="packageList">
		<?php foreach($packages as $key => $value) : ?>
			<li class="r<?php echo $key; ?> <?php echo (in_array($key, $current)) ? "selected" : "" ?>">
			<p><a class="delete" href="#<?php echo $t->entities($key); ?>"><?php echo $t->entities($value); ?></a><input type="hidden" name="fsID[]" value="<?php echo $t->entities($key); ?>" <?php echo (in_array($key, $current)) ? "" : "disabled='disabled'" ?> /></p>
			</li>
		<?php endforeach; ?>
	</ul>
</fieldset>