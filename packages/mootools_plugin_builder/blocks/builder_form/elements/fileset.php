<?php $t = Loader::helper('text'); ?>

<?php foreach($filesets as $fileset) : ?>

	<h4><?php echo $t->entities($fileset->name); ?></h4>
	<table>
		<tr>
			<th></th>
			<th>name</th>
			<th>description</th>
		</tr>
		<?php foreach($fileset->files as $file) : ?>
			<?php
				$attributes = $file->attributes;
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
				<td><input type="checkbox" name="module[]" value="<?php echo $t->entities($file->id) ?>" class="<?php echo $t->entities(join(" ", $modules)); ?>" /></td>
				<td><?php echo $t->entities($file->name); ?></td>
				<td><?php echo $t->entities($file->description); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

<?php endforeach; ?>
