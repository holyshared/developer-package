<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $t = Loader::helper('text'); ?>
<div class="mod corner aside">
	<div class="inner">
		<div class="hd download">
			<h3 class="h4"><?php echo $t->entities($title); ?></h3>
		</div>
		<div class="bd">

<?php if (!empty($tags)) : ?>

	<ul class="nav separator versionList">
	
		<?php foreach($tags as $key => $tag) : ?>
			<?php
				$baseURL = "http://github.com/holyshared/".$repos."/";
				$tgz = $baseURL."tarball/".$key;
				$zip = $baseURL."zipball/".$key;
			?>
			<li><em><?php echo $key ?></em>&nbsp;<span class="aFiles"><a href="<?php echo $tgz ?>">tgz file</a> | <a href="<?php echo $zip ?>">zip file</a></span></li>
		<?php endforeach; ?>
	
	</ul>

<?php else: ?>

	<p><?php echo t("There is no tag yet.") ?></p>

<?php endif; ?>

		</div>
	</div>
</div>