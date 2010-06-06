<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php foreach($filesets as $fileset) : ?>

<div class="mod">

<div class="inner">

<div class="hd">
<h3><?php echo $fileset->name ?></h3>
</div>

<div class="bd">

<!--
mootools_plugin_dependences
mootools_plugin_license
mootools_plugin_authors
-->

<table>
	<tr>
		<th></th>
		<th>name</th>
		<th>description</th>
	</tr>
	<?php foreach($fileset->files as $file) : ?>
	<?php 	$attributes = $file->attributes; ?>
	<?php
		$modules = array();
		$dependences = $attributes["mootools_plugin_dependences"];
		if (is_a($dependences, 'SelectAttributeTypeOption')) {
			$modules[] = $dependences->getSelectAttributeOptionValue();
		} else if (is_a($dependences, 'SelectAttributeTypeOptionList')) {
			while ($dependences->valid()) {
				$current = $dependences->current();
				$modules[] = $current->getSelectAttributeOptionValue();
				$dependences->next();
			}
		}
	?>

	<tr>
		<td><input type="checkbox" name="module" value="<?php echo $file->name ?>" class="<?php echo join(" ", $modules); ?>" /></td>
		<td><?php echo $file->name ?></td>
		<td><?php echo $file->description ?></td>
	</tr>
	<?php endforeach; ?>
</table>
</div>
</div>
</div>

<?php endforeach; ?>
