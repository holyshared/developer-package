<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $this->inc('elements/header.php'); ?>
<div class="body">
	<div class="main">
		<?php 
			$main = new Area('Main');
			$main->display($c);
		?>
	</div>
</div>
<?php $this->inc('elements/footer.php'); ?>