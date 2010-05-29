<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php foreach($filesets as $fileset) : ?>
<h3>ID:<?php echo $fileset->id ?> - <?php echo $fileset->name ?></h3>
<table>
	<tr>
		<th>name</th>
		<th>description</th>
		<th>author</th>
		<th>tags</th>
	</tr>
	<?php foreach($fileset->files as $file) : ?>
	<tr>
		<td><?php echo $file->name ?></td>
		<td><?php echo $file->description ?></td>
		<td><?php echo $file->author ?></td>
		<td><?php echo $file->tags ?></td>
		<td>
		<?php //var_dump($file->attributes); ?>
			<?php foreach($file->attributes as $key => $attribute) : ?>

				<?php echo $key ?> - <?php echo $attribute ?><br />

			<?php endforeach; ?>
		
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endforeach; ?>
