<?php
	defined('C5_EXECUTE') or die(_('Access Denied.'));
	$form  = Loader::helper('form');
	$token = Loader::helper('validation/token');
?>
<script type="text/javascript">
$(document.body).ready(function() {
	var progressbar = $.fn.progressbar($('#progressbar'));
	var progress = function(event, step) {
		var persent = step * (100 / 5);
		progressbar.set(persent);
	}

	$("#startImport").click(function(event) {
		event.preventDefault();
		var wizard = $.fn.importWizard($('#importer'), {"step" : 5, "progress": progress});
		wizard.start();
	});
});
</script>
<h1><span>Mootools Plugin Manager</span></h1>
<?php $fp = FilePermissions::getGlobal(); ?>
<?php if ($fp->canSearchFiles()) : ?>
	<div class="ccm-dashboard-inner">
		<h3><?php echo t('Import gihub repogitory.')?>:</h3>
		<form id="importer" method="post" action="<?php echo $form->action('dashboard/mootools/importer/step1'); ?>" class="ccm-file-manager-submit-single">
			<?php echo $token->output('import'); ?>
			<?php echo $form->text('repository', 'http://github.com/holyshared/Exhibition', array("size" => "80")); ?>
			<input id="startImport" type="button" name="import" value="import" />
		</form>
		<p id="message"></p>
		<p id="progressbar"></p>
	</div>
<?php else: ?>
	<div class="ccm-dashboard-inner">
		<?php echo t('Unable to access file manager.'); ?>
	</div>
<?php endif; ?>
