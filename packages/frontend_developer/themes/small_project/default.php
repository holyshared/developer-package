<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $this->inc('elements/header.php'); ?>
<div class="body gs960">
	<div class="main">
		<?php 
			$main = new Area('Main');
			$main->display($c);
		?>
		<div class="gline">
			<div class="unit size3of4">
				<?php 
					$extra1 = new Area('Extra1');
					$extra1->display($c);
				?>
			</div>

			<div class="unit lastUnit size1of4">
				<?php 
					$extra2 = new Area('Extra2');
					$extra2->display($c);
				?>
			</div>
		</div>
	</div>
</div>
<?php  $this->inc('elements/footer.php'); ?>