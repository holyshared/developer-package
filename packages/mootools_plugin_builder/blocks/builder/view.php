<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $form = Loader::helper('form'); ?>
<?php $token = Loader::helper('validation/token'); ?>
<div class="mod">
	<div class="inner">
		<div class="hd"><h3><?php echo $name ?></h3></div>
		<div class="bd">
			<form method="post" action="<?php echo $this->action('publish'); ?>">
				<?php echo $token->output("publish"); ?>
				<?php $this->inc('elements/fileset.php'); ?>
				<?php echo $form->submit('download-'.$bID, 'download'); ?>
			</form>
		</div>
	</div>
</div>
