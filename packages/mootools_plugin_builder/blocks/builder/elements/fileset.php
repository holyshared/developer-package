<?php foreach($filesets as $fileset) : ?>
<!--
	mootools_plugin_dependences
	mootools_plugin_license
	mootools_plugin_authors
-->

	<h4><?php echo $fileset->name ?></h4>
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
				<td><input type="checkbox" name="module" value="<?php echo $file->name ?>" class="<?php echo join(" ", $modules); ?>" /></td>
				<td><?php echo $file->name ?></td>
				<td><?php echo $file->description ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

<?php endforeach; ?>
