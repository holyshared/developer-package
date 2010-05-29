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