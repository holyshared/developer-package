<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $t = Loader::helper('text'); ?>
<div class="mod">
	<div class="inner">
		<div class="hd"><h3><?php echo $t->entities($title); ?></h3></div>
		<div class="bd">
			<ul>
				<?php foreach($tags as $key => $tag) : ?>
				<?php
					$baseURL = "http://github.com/holyshared/MMap/";
					$tgz = $baseURL."tarball/".$key;
					$zip = $baseURL."zipball/".$key;
				?>
					<li><?php echo $key ?><br /><a title="<?php echo $key; ?> download(.tgz)" href="<?php echo $tgz; ?>">tgz</a> | <a title="<?php echo $key; ?> download(.zip)" href="<?php echo $zip; ?>">zip</a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
