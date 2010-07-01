<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$t = Loader::helper('text');
	$f = Loader::helper('form');

	$items = array();
	foreach ($repositories as $key => $repo) {
		$items[$repo["name"]] = $repo["name"];
	}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->getBlockURL() ?>/style.css" media="screen" />

<?php if (empty($userName)) : ?>
	<p><em><?php echo t("Please input the name of the user for your github.") ?></em></p>
<?php else: ?>
	<p><?php echo t("It tries to register the content of the repository list of ") ?><em class="username"><?php echo $userName ?></em>.<br />
	<?php echo t("Please correct it from the change screen of user information when differing if you register.") ?></p>
<?php endif; ?>

<p><?php echo t("Please input a necessary item.") ?></p>
<?php echo $f->hidden("user", (empty($user)) ? $userName : $user); ?>
<fieldset>
	<legend><?php echo t("General setting") ?></legend>
	<dl>
		<dt><?php echo t("Title of tag list") ?>&nbsp;<em class="required"><?php echo t("required") ?></em></dt>
		<dd><?php echo $f->text("title", $title, array("id" => "title", "size" => 60)); ?></dd>
		<dt><?php echo t("Repository of github") ?>&nbsp;<em class="required"><?php echo t("required") ?></em></dt>
		<dd><?php echo $f->select("repos", $items, $repos, array("repos" => "title")); ?></dd>
		<dt><?php echo t("Number of displayed tag") ?>&nbsp;<em class="required"><?php echo t("required") ?></em></dt>
		<dd><?php echo $f->text("displayCount", $displayCount, array("id" => "displayCount", "size" => 5)); ?></dd>
	</dl>
</fieldset>