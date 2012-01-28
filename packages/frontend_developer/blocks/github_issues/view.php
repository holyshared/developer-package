<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $t = Loader::helper('text'); ?>
<div class="mod corner aside">

	<div class="inner">
		<div class="hd issues">
			<h3 class="h4"><?php echo $t->entities($title); ?></h3>
		</div>
		<div class="bd">

<?php if (!empty($issues)) : ?>
	<ul class="nav separator taskList">
		<?php foreach($issues as $key => $issue) : ?>
	
			<?php
				$url  = "http://www.gravatar.com/avatar/";
				$url .= $issue["gravatar_id"];
				$url .= "?s=30";
					
				$ticket  = "http://github.com/".$t->entities($user) . "/" . $t->entities($repos);
				$ticket .= "/issues/" . $t->entities($issue["position"]);

				$updateAt = date("Y-m-d H:i", strtotime($issue["updated_at"]));
			?>
			<li><a href="http://github.com/<?php echo $t->entities($user) ?>/"><img src="<?php echo $t->entities($url) ?>" alt="<?php echo $t->entities($user) ?>" class="image" /></a><a href="<?php echo $ticket ?>"><?php echo $t->entities($issue["title"]) ?></a>
			<br /><?php echo $t->entities($updateAt) ?></li>

		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p><?php echo t("There is no ticket."); ?></p>
<?php endif; ?>
		</div>
	</div>

</div>