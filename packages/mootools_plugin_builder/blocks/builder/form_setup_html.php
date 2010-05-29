<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $form = Loader::helper('form'); ?>
<fieldset>
	<dl>
		<dt>name</dt>
		<dd><?php echo $form->text("name", $name); ?></dd>
		<dt>description</dt>
		<dd><?php echo $form->text("description", $description); ?></dd>
	</dl>
</fieldset>

<fieldset>
	<dl>
		<dt>Packages</dt>
		<dd>
			<?php
	$packages = array();
	foreach($this->filesets as $key => $fileset) {
		$packages[$fileset->fsID] = $fileset->fsName;
	}
	echo $form->select("package", $packages, null, array("tabindex" => "0"));			?>
		</dd>
	</dl>
</fieldset>