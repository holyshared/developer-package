<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
//	$html = Loader::helper("html");
//	$this->addHeaderItem($html->css("style.css", MootoolsPluginBuilderPackage::PACKAGE_HANDLE));
	$t = Loader::helper('text');
	$f = Loader::helper('form');

	$items = array();
	foreach ($repositories as $key => $repo) {
		$items[$repo["name"]] = $repo["name"];
	}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getBlockURL() ?>/style.css" media="screen" />

<?php if (empty($userName)) : ?>
	<p><em>Please input the name of the user for your github.</em></p>
<?php else: ?>
	<p>It tries to register the content of the repository list of <em class="username"><?php echo $userName ?></em>.<br />
	Please correct it from the change screen of user information when differing if you register.</p>
<?php endif; ?>

<p>Please input a necessary item.</p>
<?php echo $f->hidden("user", (empty($user)) ? $userName : $user); ?>
<fieldset>
	<legend>general</legend>
	<p>General setting</p>
	<dl>
		<dt>Title of tag list&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->text("title", $title, array("id" => "title", "size" => 60)); ?></dd>
		<dt>Repository of github&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->select("repos", $items, $repos, array("repos" => "title")); ?></dd>
		<dt>Number of displayed tag&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->text("displayCount", $displayCount, array("id" => "displayCount", "size" => 5)); ?></dd>
	</dl>
</fieldset>