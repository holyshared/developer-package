<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $t = Loader::helper('text'); ?>
<div class="mod corner aside">

	<div class="inner">
		<div class="hd issues">
			<h3 class="h4"><?php echo $t->entities($title); ?></h3>
		</div>
		<div class="bd">
			<ul class="nav separator taskList">
<?php
	foreach($issues as $key => $issue) :
		$url  = "http://www.gravatar.com/avatar/";
		$url .= $issue["gravatar_id"];
		$url .= "?s=30";
?>

<li><a href="http://github.com/<?php echo $t->entities($user) ?>/"><img src="<?php echo $t->entities($url) ?>" alt="<?php echo $t->entities($user) ?>" class="image" /></a><a href="http://github.com/holyshared/MMap/issues"><?php echo $t->entities($issue["title"]) ?></a>
<br /><?php echo $t->entities($issue["updated_at"]) ?></li>

<?php endforeach; ?>

			</ul>
		</div>
	</div>

</div>