<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$t = Loader::helper('text');
	$f = Loader::helper('form');

	$selectOptions = array();
	foreach ($repositories as $key => $repo) {
		$selectOptions[$key] = $repo["name"];
	}

	$values = array();
	if ($items) {
		foreach ($items as $key => $item) {
			$values[] = $item["repos"];
		}
	}
?>
<link rel="stylesheet" type="text/css" href="<?php echo $t->entities($this->getBlockURL()) ?>/style.css" media="screen" />

<?php if (empty($userName)) : ?>
	<p><em>Please input the name of the user for your github.</em></p>
<?php else: ?>
	<p>It tries to register the content of the repository list of <em class="username"><?php echo $t->entities($userName) ?></em>.<br />
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
		<dd>
			<select name="repos[]" multiple="multiple">
				<?php foreach ($selectOptions as $key => $value) : ?>
					<?php $selected = (in_array($value, $values)) ? "selected=\"selected\"" : ""; ?>
					<option value="<?php echo $t->entities($key) ?>"<?php echo $t->entities($selected) ?>><?php echo $t->entities($value) ?></option>
				<?php endforeach; ?>
			</select>
		</dd>
	</dl>
</fieldset>