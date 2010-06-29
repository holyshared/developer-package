<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $t = Loader::helper('text'); ?>
<div class="mod corner aside">
	<div class="inner">
		<div class="hd repos">
			<h3 class="h4"><?php echo $t->entities($title); ?></h3>
		</div>
		<div class="bd">
			<ul class="nav separator">
<?php
foreach($items as $key => $rp) {
	$name = $rp["repos"];
	$current = $repositories[$name];
?>
	<li>
<a title="<?php echo $t->entities($current["description"]); ?>" href="<?php echo $t->entities($current["url"]); ?>">github@<?php echo $t->entities($current["name"]); ?></a><br />
<em><?php echo $t->entities(date("Y-m-d H:i", strtotime($current["pushed_at"]))); ?></em>
	</li>
<?php } ?>
			</ul>
		</div>
	</div>
</div>