<?php $t = Loader::helper('text'); ?>

<?php foreach($filesets as $name => $files) : ?>

	<h4><?php echo $t->entities($name); ?></h4>
	<table>
		<tr>
			<th>&nbsp;</th>
			<th>name</th>
			<th>description</th>
		</tr>
		<?php foreach($files as $file) : ?>
			<?php
				$fv = $file->getVersion();
				$fa = $fv->getAttributeList();
				$dependences = $fa->getAttribute(MOOTOOLS_PLUGIN_DEPENDENCES);	
				
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
				<td class="check"><input type="checkbox" name="module[]" value="<?php echo $t->entities($file->getFileID()) ?>" class="<?php echo $t->entities(join(" ", $modules)); ?>" /></td>
				<td class="name"><?php echo $t->entities($fv->getFileName()); ?></td>
				<td class="description"><?php echo $t->entities($fv->getDescription()); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

<?php endforeach; ?>
