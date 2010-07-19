<?php
	defined('C5_EXECUTE') or die(_('Access Denied.'));
	$f = Loader::helper('form');
	$t = Loader::helper('validation/token');
	$fl = Loader::helper('concrete/file');

	$fileTypes = UPLOAD_FILE_EXTENSIONS_ALLOWED;
	$fileTypes = (!$fileTypes)
	? $fl->unserializeUploadFileExtensions(UPLOAD_FILE_EXTENSIONS_ALLOWED)
	: $fileTypes = $fl->unserializeUploadFileExtensions($fileTypes);
?>
<script type="text/javascript">
$(document.body).ready(function() {
	var progressbar = $.fn.progressbar($('#progressbar'));
	var progress = function(event, step) {
		var persent = step * (100 / 5);
		progressbar.set(persent);
	}

	var complete = function() {
		alert("complete");
	}

	$("#startImport").click(function(event) {
		event.preventDefault();
		progressbar.reset();
		var wizard = $.fn.importWizard($('#importer'), {
			"step" : 5,
			"progress": progress,
			"complete": complete
		});
		wizard.start();
	});

	$("#yourRepos").click(function(event) {
		event.preventDefault();
		var href = $(event.target).attr("href").replace("#", "");
		$("#repository").val(href);
	});

});
</script>
<?php $fp = FilePermissions::getGlobal(); ?>
<?php if ($fp->canSearchFiles()) : ?>

	<h1><span>Plugin Import</span></h1>
	<div class="ccm-dashboard-inner mainCol">

		<div class="leftCol">
			<div class="ccm-search-advanced-fields"> 
				<h2><?php echo t("Your Repository") ?></h2> 
				<div class="ccm-search-field">
					<?php if ($repos) : ?>
						<ul id="yourRepos" class="userRepository">
							<?php foreach($repos as $rp) : ?>
								<li><a title="<?php echo $rp["name"]; ?>" href="#<?php echo $rp["name"]; ?>"><?php echo $rp["name"]; ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<p><?php echo t("There is no repository of you.") ?></p>
					<?php endif; ?>
				</div> 
			</div>
		</div>

		<div class="rightCol">
			<?php if (empty($username)) : ?>
				<?php echo Loader::packageElement("username_empty", $pkgHandle, array("uID" => $uID)) ?>
			<?php elseif (!in_array("js", $fileTypes)) : ?>
				<?php echo Loader::packageElement("javascript_permission", $pkgHandle, array("uID" => $uID)) ?>
			<?php else: ?>
				<h3><?php echo t('Plugin importing of mootools')?>:</h3>
				<p>
					<?php echo t("Please input repository URL of github, and click the import button.") ?><br />
					<?php echo t("The plugin of the latest version is taken from the repository.") ?>
				</p>

				<h4><?php echo t('repository URL')?>:</h4>
				<form id="importer" method="post" action="<?php echo $f->action('dashboard/mootools/importer/step1'); ?>" class="ccm-file-manager-submit-single">
					<?php echo $t->output('import'); ?>
					<p>
						<?php //echo $f->text('repository', 'http://github.com/holyshared/Exhibition', array("size" => "80")); ?>
						http://github.com/<strong class="username">holyshared</strong>/&nbsp;&nbsp;<?php echo $f->text('repository', '', array("size" => "20")); ?>
						<input id="startImport" type="button" name="import" value="import" />
					</p>
				</form>
				<p id="message"></p>
				<p id="progressbar"></p>
			<?php endif; ?>
		</div>
	</div>

<?php else: ?>
	<div class="ccm-dashboard-inner">
		<?php echo t('Unable to access file manager.'); ?>
	</div>
<?php endif; ?>
