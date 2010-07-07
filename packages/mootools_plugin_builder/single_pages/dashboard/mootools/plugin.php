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
</script>
<?php $fp = FilePermissions::getGlobal(); ?>
<?php if ($fp->canSearchFiles()) : ?>

	<h1><span>Mootools Plugin Manager</span></h1>
	<div id="main" class="ccm-dashboard-inner">

		<div class="repositories">
			<div class="ccm-search-advanced-fields"> 
				<h2><?php echo t("Your Plugin") ?></h2> 
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

		<div class="importer">

			<?php
				//The name of the user of github is confirmed.  
				if (empty($username)) : ?>
					<div class="warnMessage">
					<p>
						<strong class="warning">
							<?php echo t("The name of the user of github is not input.") ?><br />
							<?php echo t("Please input the name of the user of github by user's edit display.") ?>
						</strong>
					</p>
					<?php $url = $this->url("dashboard/users/search?uID=".$uID); ?>
					<p><a title="<?php echo t("It moves to user's profile page") ?>" href="<?php echo $url ?>"><?php echo t("It moves to user's profile page &gt;&gt;") ?></a></p>
					</div>
			<?php
				//
				elseif (!in_array("js", $fileTypes)) : ?>
					<div class="warnMessage">
					<p>
					<strong class="warning">
					<?php echo t("There is no taking permission of the javascript file.") ?><br />
					<?php echo t("Please permit taking the javascript file by setting file management.") ?>
					</strong>
					</p>
					<p><a title="<?php echo t("It moves to the file management page.") ?>" href="<?php echo $this->url("dashboard/files/access") ?>"><?php echo t("It moves to the file management page. &gt;&gt;") ?></a></p>
				</div>
			<?php else: ?>
				<h3><?php echo t('Plugin importing of mootools')?>:</h3>
				<p>
					<?php echo t("Please input repository URL of github, and click the import button.") ?><br />
					<?php echo t("The plugin of the latest version is taken from the repository.") ?>
				</p>

			<?php endif; ?>
		</div>
	</div>

<?php else: ?>
	<div class="ccm-dashboard-inner">
		<?php echo t('Unable to access file manager.'); ?>
	</div>
<?php endif; ?>
