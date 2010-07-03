<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $f = Loader::helper('form'); ?>
<?php $t = Loader::helper('text'); ?>
<?php $v = Loader::helper('validation/token'); ?>
<div class="mod packages">
	<div class="inner">
		<div class="hd"><h3><?php echo $t->entities($title); ?></h3></div>
		<div class="bd">
			<p><?php echo $t->entities($description); ?></p>
			<form method="post" action="<?php echo $this->action('publish'); ?>">
				<?php $this->inc('elements/fileset.php'); ?>
				<p class="control"><?php echo $f->submit('download-'.$bID, 'download'); ?></p>
			</form>
		</div>
	</div>
</div>
