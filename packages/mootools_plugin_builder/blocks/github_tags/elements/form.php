<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$t = Loader::helper('text');
	$f = Loader::helper('form');
?>

<?php if (empty($userName)) : ?>

<p>
	<strong class="warning">
		<?php echo t("The name of the user of github is not input.") ?><br />
		<?php echo t("Please input the name of the user of github by user's edit display.") ?>
	</strong>
</p>
<?php $url = $this->url("dashboard/users/search?uID=".$uID); ?>
<p><a title="<?php echo t("It moves to user's profile page") ?>" href="<?php echo $url ?>"><?php echo t("It moves to user's profile page. &gt;&gt;") ?></a></p>

<?php else: ?>

<p><?php echo t("It tries to register the content of the repository list of ") ?><em class="username"><?php echo $userName ?></em>.<br />
<?php echo t("Please correct it from the change screen of user information when differing if you register.") ?></p>
	
<?php
	$userRepos = array();
	foreach ($repositories as $key => $repo) {
		$userRepos[$repo["name"]] = $repo["name"];
	}
?>
	
<p><?php echo t("Please input a necessary item.") ?></p>
<?php echo $f->hidden("user", (empty($user)) ? $userName : $user); ?>
<fieldset>
	<legend><?php echo t("General setting") ?></legend>
	<dl>
		<dt><?php echo t("Title of tag list") ?>&nbsp;<em class="required"><?php echo t("required") ?></em></dt>
		<dd><?php echo $f->text("title", $title, array("id" => "title", "size" => 60)); ?></dd>
		<dt><?php echo t("Repository of github") ?>&nbsp;<em class="required"><?php echo t("required") ?></em></dt>
		<dd><?php echo $f->select("repos", $userRepos, $repos, array("repos" => "title")); ?></dd>
		<dt><?php echo t("Number of displayed tag") ?>&nbsp;<em class="required"><?php echo t("required") ?></em></dt>
		<dd><?php echo $f->text("displayCount", $displayCount, array("id" => "displayCount", "size" => 5)); ?></dd>
	</dl>
</fieldset>

<?php endif; ?>

