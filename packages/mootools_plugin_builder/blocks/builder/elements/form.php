<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$packages = array();
	foreach($filesets as $key => $fileset) {
		$packages[$fileset->fsID] = $fileset->fsName;
	}
	$json = json_encode($packages);
?>
<?php $form = Loader::helper('form'); ?>
<?php $ah = Loader::helper('concrete/interface'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getBlockURL() ?>/style.css" media="screen" />
<script type="text/javascript">var PluginPackages = <?php echo $json; ?>;</script>

<fieldset>
	<dl>
		<dt>title</dt>
		<dd><?php echo $form->text("title", $title, array("size" => 30)); ?></dd>
		<dt>description</dt>
		<dd><?php echo $form->text("description", $description, array("size" => 30)); ?></dd>
		<dt>javascript</dt>
		<dd><?php echo $form->text("javascript", $javascript, array("size" => 30)); ?>.js</dd>
	</dl>
</fieldset>

<ul id="packageList" class="packageList">

<?php foreach($packages as $key => $value) : ?>

<li class="r<?php echo $key; ?> <?php echo (in_array($key, $current)) ? "selected" : "" ?>">
<p><a class="delete" href="#<?php echo $key; ?>"><?php echo $value; ?></a><input type="hidden" name="fsID[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $current)) ? "" : "disabled='disabled'" ?> /></p>
</li>

<?php endforeach; ?>
</ul>
