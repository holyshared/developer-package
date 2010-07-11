<?php foreach ($filesets as $key => $files) : ?>

<div id="<?php echo $key; ?>" class="package">
	<h3><?php echo $key; ?></h3>
	<table>
		<thead>
			<tr>
				<th class="no">no.</th>
				<th class="name"><?php echo t("name") ?></th>
				<th class="authors"><?php echo t("authors") ?></th>
				<th class="license"><?php echo t("license") ?></th>
				<th><?php echo t("dependences") ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($files as $no => $file) : ?>
			<?php
				$version = $file->getVersion();
				$at = $version->getAttributeList();

				$values = array();
				$depos = $at->getAttribute(MOOTOOLS_PLUGIN_DEPENDENCES);
				if (!empty($depos)) {
					if ($depos instanceof SelectAttributeTypeOptionList) {
						while($depos->valid()) {
							$current = $depos->current();
							$values[] = $current->getSelectAttributeOptionValue();
							$depos->next();
						}
					} else {
						$values[] = $depos->getSelectAttributeOptionValue();
					}
				}
			?>
			<tr>
				<td><span class="no"><?php echo $no + 1; ?></span><input type="hidden" name="fID[]" value="<?php echo $file->getFileID(); ?>" /></td>
				<td><?php echo $file->getFileName(); ?></td>
				<td><?php echo $at->getAttribute(MOOTOOLS_PLUGIN_AUTHORS); ?></td>
				<td><?php echo $at->getAttribute(MOOTOOLS_PLUGIN_LICENSE); ?></td>
				<td><?php echo join(", ", $values) ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php endforeach; ?>
