<?php 
	defined('C5_EXECUTE') or die(_("Access Denied."));
	$content = $controller->getContent();
?>
<div class="mod">
	<div class="inner">
		<?php print $content; ?>
	</div>
</div>
