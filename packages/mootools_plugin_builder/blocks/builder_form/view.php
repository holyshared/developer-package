<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $f = Loader::helper('form'); ?>
<?php $t = Loader::helper('text'); ?>
<?php $v = Loader::helper('validation/token'); ?>
<div class="mod packages">
	<div class="inner">
		<div class="hd"><h3><?php echo $t->entities($title); ?></h3></div>
		<div class="bd">
			<p><?php echo $t->entities($description); ?></p>
			<form method="post" action="<?php echo $this->action('publish'); ?>">
				<?php $this->inc('elements/fileset.php'); ?>
				<ul class="packtypeList">
					<li><label class="compression"><input type="radio" name="packType" value="1" />&nbsp;YUI Compressor</label><br />Uses YUI Compressor by Julien Lecomte, to clean whitespace and rename internal variables to shorter values. Highest compression ratio.</li>
					<li><label class="compression"><input type="radio" name="packType" value="2" />&nbsp;JsMin Compression</label><br />Uses JSMin by Douglas Crockford. Cleans comments and whitespace.</li>
					<li><label class="compression"><input type="radio" name="packType" value="3" />&nbsp;No Compression</label><br />Uncompressed source. Recommended in testing phase.</li>
				</ul>
				<p class="control"><?php echo $f->submit('download-'.$bID, 'download'); ?></p>
			</form>
		</div>
	</div>
</div>
