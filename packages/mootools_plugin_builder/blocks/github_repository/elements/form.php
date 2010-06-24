<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
//	$html = Loader::helper("html");
//	$this->addHeaderItem($html->css("style.css", MootoolsPluginBuilderPackage::PACKAGE_HANDLE));
	$t = Loader::helper('text');
	$f = Loader::helper('form');

	$userRepos = array();
	foreach ($repositories as $key => $repo) {
		$userRepos[$repo["name"]] = $repo["name"];
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
<fieldset>
	<legend>general</legend>
	<p>General setting</p>
	<dl>
		<dt>Title of tag list&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->text("title", $title, array("id" => "title", "size" => 60)); ?></dd>

		<dt>User name of github&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->text("user", $userName, array("id" => "user", "size" => 60)); ?></dd>

		<dt>Repository of github&nbsp;<em class="required">required</em></dt>
		<dd><?php echo $f->select("repos[]", $userRepos, $repos, array("multiple" => "multiple")); ?></dd>
	</dl>
</fieldset>