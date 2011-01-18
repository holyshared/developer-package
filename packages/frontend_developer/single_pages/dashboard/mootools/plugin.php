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
$(function(){
	$("#fileList tbody").sortable({
		'update': function(event, ui) {
			var rows = $("#fileList tbody tr").get();
			$(rows).each(function(key, row) {
				var no = $(row).find('.no');
				no.html(key + 1);
			});
		}
	}).disableSelection();

	$("#yourRepos").click(function(event) {
		var fs = $(event.target).attr("href").replace('#', '');
		$.post('<?php echo $this->action("package") ?>', {'package': fs}, function(response) {
			$("#fileList").html(response);
			$("#fileList tbody").sortable().disableSelection();
		});
	});

	$(".pluginEdit").live("click", function(event) {
		event.preventDefault();
		var trriger = $(event.target);
		var url = CCM_TOOLS_PATH + trriger.attr("href");
		jQuery.fn.dialog.open({
			width: 630,
			height: 450,
			modal: false,
			href: url,
			title: ccmi18n.properties				
		});
	});
});
</script>

<style type="text/css">

table {
	border: 1px solid #cccccc;
}

table th,
table td {
	border: 1px solid #cccccc;
}

</style>

<?php $fp = FilePermissions::getGlobal(); ?>
<?php if ($fp->canSearchFiles()) : ?>

	<h1><span><?php echo t("Plugin Manager") ?></span></h1>
	<div class="ccm-dashboard-inner mainCol">

		<div class="leftCol">
			<div class="ccm-search-advanced-fields"> 
				<h2><?php echo t("Your Plugins") ?></h2> 
				<div class="ccm-search-field">

<?php if ($plugins) : ?>
	<ul id="yourRepos" class="userRepository">
		<?php foreach($plugins as $plugin) : ?>
			<li><a title="<?php echo $plugin->getFileSetName() ?>" href="#<?php echo $plugin->getFileSetName() ?>"><?php echo $plugin->getFileSetName() ?></a></li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p><?php echo t("There is no plugin of you.") ?></p>
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
				<h3><?php echo t('Plugin list that does import')?></h3>
				<p>
<?php echo t("A plugin file that does the import is displayed.") ?><br />
<?php echo t("Please permute the file in drag and drop.") ?><br />
<?php echo t("When the javascript file is downloaded by a form builder, it is output as shown in this order of the row.") ?>
				</p>
				<?php if (!empty($filesets)) : ?>
					<form action="<?php echo $this->action("update") ?>" method="post">
						<div id="fileList">
							<?php echo Loader::packageElement("plugin_files", $pkgHandle, array("filesets" => $filesets, "searchInstance" => $searchInstance)) ?>
						</div>
					<?php echo $f->submit("send", t("Update")); ?>
					</form>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>

<?php else: ?>

	<div class="ccm-dashboard-inner">
		<?php echo t('Unable to access file manager.'); ?>
	</div>

<?php endif; ?>
