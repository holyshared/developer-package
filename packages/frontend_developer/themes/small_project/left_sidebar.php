<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $this->inc('elements/header.php'); ?>
<div class="body multi gs960">
	<div class="leftCol yahoo">
		<?php 
			$sidebar = new Area('Sidebar');
			$sidebar->display($c);
		?>
	</div>
	<div class="main mBuilder">
		<?php 
			$main = new Area('Main');
			$main->display($c);
		?>
	</div>
</div>
<?php  $this->inc('elements/footer.php'); ?>