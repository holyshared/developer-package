<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php Loader::library('mootools/attribute', FRONTEND_DEVELOPER_PACKAGE_HANDLE); ?>
<?php $f = Loader::helper('form'); ?>
<?php $t = Loader::helper('text'); ?>
<?php $v = Loader::helper('validation/token'); ?>
<?php
exec("java -version 2>&1", $output);
$version = str_replace(array("java version", "\""), "", array_shift($output));
$runtime = array_shift($output);

$isYUICompressorCRequirement = false;
if (version_compare($version, "1.4.", "<")
 && strpos($runtime, "Java(TM) SE Runtime Environment") !== false) {
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
					<li><label class="compression"><input type="radio" name="packType" value="1" checked="checked" />&nbsp;<?php echo t("YUI Compressor") ?></label><br /><?php echo t("Uses YUI Compressor by Julien Lecomte, to clean whitespace and rename internal variables to shorter values. Highest compression ratio.") ?></li>
					<?php endif; ?>
					<li><label class="compression"><input type="radio" name="packType" value="2" <?php echo ($isYUICompressorCRequirement) ? "" : "checked=\"checked\"" ?> />&nbsp;<?php echo t("JsMin Compression") ?></label><br /><?php echo t("Uses JSMin by Douglas Crockford. Cleans comments and whitespace.") ?></li>
					<li><label class="compression"><input type="radio" name="packType" value="3" />&nbsp;<?php echo t("No Compression") ?></label><br /><?php echo t("Uncompressed source. Recommended in testing phase.") ?></li>
				</ul>
				<p class="control"><input id="download-.<?php echo $bID ?>" type="image" name="download" src="<?php echo $url->getPackageURL($pkg) ?>/images/img_download.jpg" /></p>
			</form>
		</div>
	</div>
</div>
