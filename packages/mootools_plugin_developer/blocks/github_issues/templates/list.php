<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $t = Loader::helper('text'); ?>
<div class="mod">

	<div class="inner">
		<div class="hd">
			<h3><?php echo $t->entities($title); ?></h3>
		</div>
		<div class="bd">

<?php

foreach($issues as $key => $issue) :

$url  = "http://www.gravatar.com/avatar/";
$url .= $issue["gravatar_id"];
$url .= "?s=50";

$ticket  = "http://github.com/".$t->entities($user)."/".$t->entities($repos);
$ticket .= "/issues#issue/".$t->entities($issue["position"]);

$updateAt = date("Y-m-d H:i", strtotime($issue["updated_at"]));
$createAt = date("Y-m-d H:i", strtotime($issue["created_at"]));

?>

<div class="ticket">
	<p class="avater"><a href="http://github.com/<?php echo $t->entities($user) ?>/"><img src="<?php echo $t->entities($url) ?>" alt="<?php echo $t->entities($user) ?>" class="image" /></a></p>
	<h4><a href="<?php echo $ticket ?>"><?php echo $t->entities($issue["title"]) ?></a></h4>
	<p><?php echo $t->entities($issue["body"]) ?></p>
	<p>update at: <?php echo $t->entities($updateAt) ?> | create at: <?php echo $t->entities($createAt) ?> | user: <a href="http://github.com/<?php echo $t->entities($user) ?>/"><?php echo $t->entities($issue["user"]) ?></a></p>
</div>

<?php endforeach; ?>

		</div>
	</div>

</div>