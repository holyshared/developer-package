<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$fp = Loader::helper("feed");
	$feed = $fp->load($url); 
	$feed->set_item_limit(intval($itemsToDisplay));
	$feed->init();
	$feed->handle_content_type();
?>
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
		<ul class="hfeed simpleList">
			<?php foreach ($posts as $itemNumber => $item) : ?>
				<?php if (intval($itemNumber) >= intval($rssObj->itemsToDisplay)) : ?>
					<?php break; ?>
				<?php endif; ?>
				<li class="hentry">
					<h4 class="entry-title"><a href="<?php echo $item->get_permalink(); ?>" rel="bookmark"><?php echo  $item->get_title(); ?></a></h4>
					<p class="meta">published: <abbr class="published" title="<?php echo $item->get_date(); ?>"><?php echo $item->get_date($dateFormat); ?></abbr> | author: <span class="vcard author"><a class="fn url" href="<?php echo $feed->get_link(); ?>"><?php echo $item->get_author()->get_name(); ?></a></span></p>
					<p class="entry-content">
						<?php
							if ($rssObj->showSummary) {
								echo $textHelper->shortText( strip_tags($item->get_description()) );
							}
						?>
					</p>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		</div>
	</div>
</div>