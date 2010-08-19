<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<div class="mod">
	<div class="inner">
		<?php if (strlen($title) > 0) : ?>
			<div class="hd">
				<h3><?php echo $title; ?></h3>
			</div>
		<?php endif; ?>

		<div class="bd">
		<?php  
			$rssObj = $controller;
			$textHelper = Loader::helper("text"); 
		
			if (!$dateFormat) {
				$dateFormat = t('F jS');
			}
		?>
			
		<?php if (strlen($errorMsg) > 0) : ?>
			<?php echo $errorMsg; ?>
		<?php else: ?>
		<ul>
			<?php foreach ($posts as $itemNumber => $item) : ?>
				<?php if (intval($itemNumber) >= intval($rssObj->itemsToDisplay)) break; ?>
					<li><h4><?php echo $item->get_date($dateFormat); ?> - <a href="<?php echo $item->get_permalink(); ?>"><?php echo  $item->get_title(); ?></a></h4>
						<p><?php 
							if ($rssObj->showSummary) {
								echo $textHelper->shortText( strip_tags($item->get_description()) );
							}
							?>
						</p>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		</div>
	</div>
</div>