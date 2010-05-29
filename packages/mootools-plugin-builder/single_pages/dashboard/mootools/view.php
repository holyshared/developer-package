<?php
	defined('C5_EXECUTE') or die(_("Access Denied."));
	$form = Loader::helper('form');
	$validationToken = Loader::helper('validation/token');
?>
<h1><span>Mootools Plugin Manager</span></h1>

<?php $fp = FilePermissions::getGlobal(); ?>

<?php if ($fp->canSearchFiles()) : ?>
	<div class="ccm-dashboard-inner">
		<h3><?php echo t('Import gihub repogitory.')?>:</h3>
		<form method="post" action="<?php echo $form->action('dashboard/mootools/import'); ?>" class="ccm-file-manager-submit-single">
			<?php echo $validationToken->output('import'); ?>
			<?php echo $form->text('repository', 'http://github.com/holyshared/Exhibition/', array("size" => "80")); ?>
			<?php echo $form->submit('import', 'import'); ?>
		</form>

		<?php if ($pluginFiles) : ?>
			<ul>
				<?php foreach($pluginFiles as $file) : ?>
					<li><?php echo $file; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

<?php else: ?>
	<div class="ccm-dashboard-inner">
		<?php echo t('Unable to access file manager.'); ?>
	</div>
<?php endif; ?>
