<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php Loader::library('mootools/attribute', FrontendDeveloperPackage::PACKAGE_HANDLE); ?>
<?php $f = Loader::helper('form'); ?>
<?php $t = Loader::helper('text'); ?>
<?php $v = Loader::helper('validation/token'); ?>
<?php
exec("java -version 2>&1", $output);
$line = array_shift($output);
$version = str_replace(array("java version", "\""), "", $line);
$isYUICompressorCRequirement = false;
if (version_compare($version, "1.4.", "<")) {
	$isYUICompressorCRequirement = true;
}
?>
<div class="mod packages">
	<div class="inner">
		<div class="hd"><h3><?php echo $t->entities($title); ?></h3></div>
		<div class="bd">
			<p><?php echo $t->entities($description); ?></p>
			<?php echo ($error) ? $error->output() : ""; ?>
 			<form method="post" action="<?php echo $this->action('publish'); ?>">
				<?php $v->output(''); ?>
				<?php $this->inc('elements/fileset.php'); ?>
				<ul class="packtypeList">
					<?php if ($isYUICompressorCRequirement) : ?>
					<li><label class="compression"><input type="radio" name="packType" value="1" checked="checked" />&nbsp;YUI Compressor</label><br />Uses YUI Compressor by Julien Lecomte, to clean whitespace and rename internal variables to shorter values. Highest compression ratio.</li>
					<?php endif; ?>
					<li><label class="compression"><input type="radio" name="packType" value="2" />&nbsp;JsMin Compression</label><br />Uses JSMin by Douglas Crockford. Cleans comments and whitespace.</li>
					<li><label class="compression"><input type="radio" name="packType" value="3" />&nbsp;No Compression</label><br />Uncompressed source. Recommended in testing phase.</li>
				</ul>
				<p class="control"><input id="download-.<?php echo $bID ?>" type="image" name="download" src="<?php echo $url->getPackageURL($pkg) ?>/images/img_download.jpg" /></p>
			</form>
		</div>
	</div>
</div>
