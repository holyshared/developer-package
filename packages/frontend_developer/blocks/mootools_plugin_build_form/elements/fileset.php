<?php $t = Loader::helper('text'); ?>

<?php foreach($filesets as $name => $files) : ?>

	<h4><?php echo $t->entities($name); ?></h4>
	<table class="moduleList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>name</th>
				<th>description</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($files as $file) : ?>
				<?php
					$fv = $file->getVersion();
					$fa = $fv->getAttributeList();

					$dependences = $fa->getAttribute(MOOTOOLS_PLUGIN_DEPENDENCES);	

					$modules = $options = array();
					if (is_a($dependences, 'SelectAttributeTypeOption')) {
						$options[] = $dependences->getSelectAttributeOptionValue();
					} else if (is_a($dependences, 'SelectAttributeTypeOptionList')) {
						while ($dependences->valid()) {
							$current = $dependences->current();
							$options[] = $current->getSelectAttributeOptionValue();
							$dependences->next();
						}
					}
					foreach ($options as $module) {
						$modules[] = str_replace(".", "_", $module);
					}
					$name = str_replace(".", "_", $fv->getFileName());
				?>
				<tr>
					<td class="check"><input id="<?php echo $name; ?>" type="checkbox" name="module[]" value="<?php echo $t->entities($file->getFileID()) ?>" class="<?php echo $t->entities(join(" ", $modules)); ?>" /></td>
					<td class="name"><?php echo $t->entities($fv->getFileName()); ?></td>
					<td class="description"><?php echo $t->entities($fv->getDescription()); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

<?php endforeach; ?>
