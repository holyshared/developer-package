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

			User::getByUserID(1);




		?>
		<?php if (strlen($errorMsg) > 0) : ?>
			<?php echo $errorMsg; ?>
		<?php else: ?>
		<ul class="hfeed">
			<?php foreach ($posts as $itemNumber => $item) : ?>
				<?php if (intval($itemNumber) >= intval($rssObj->itemsToDisplay)) : ?>
					<?php break; ?>
				<?php endif; ?>
				<li class="hentry">
					<h4 class="h5 entry-title"><a href="<?php echo $item->get_permalink(); ?>" rel="bookmark"><?php echo  $item->get_title(); ?></a></h4>
					<p class="entry-content">
						<?php
							if ($rssObj->showSummary) {
								echo $textHelper->shortText( strip_tags($item->get_description()) );
							}
						?>
					</p>
					<p><addr class="published" title="<?php echo $item->get_date(); ?>"><?php echo $item->get_date($dateFormat); ?></addr> | <span class="vcard author"><a class="fn url" href="http://sharedhat.com">holyshared</a></span></p>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		</div>
	</div>
</div>