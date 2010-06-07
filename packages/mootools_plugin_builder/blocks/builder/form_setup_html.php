<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$packages = array();
	foreach($filesets as $key => $fileset) {
		$packages[$fileset->fsID] = $fileset->fsName;
	}
	$json = json_encode($packages);
?>
<?php $form = Loader::helper('form'); ?>
<?php $ah = Loader::helper('concrete/interface'); ?>
<script type="text/javascript">var PluginPackages = <?php echo $json; ?>;</script>
<style type="text/css">

fieldset {
	padding: 10px;
	border: 1px solid #cccccc;
	margin-bottom: 15px;
}

dl dt, dl dd {
	margin-bottom: 10px;
}

dl dt {
	float: left;
	clear: both;
	width: 100px;
}

dl dd {
	margin-left: 100px;
}

.packageList {
}

.packageList li {
	padding: 5px 10px 5px 5px;
	border-top: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	border-right: 1px solid #cccccc;
	overflow: hidden;
}

.packageList li p {
	float: left;
	width: 100px;
	margin: 0px;
	padding: 0px;
}

.packageList li:last-child {
	border-bottom: 1px solid #cccccc;
}

.packageList .pageUpDown  {
	width: 70px;
	float: right;
	overflow: hidden;
	border: none;
}


.packageList .pageUpDown li {
	border: none;
	float: left;
	width: 20px;
	padding: 0px;
}

.packageList li a.delete {
	width: 10px;
}

.packageList li a.delete,
.packageList .pageUpDown li a.up,
.packageList .pageUpDown li a.down {
	display: block;
	padding: 5px;
	text-indent: -9999px;
	height: 10px;
}

.packageList li a.delete {
	float: left;
}

.packageList li a.delete {
	background: url(<?php echo $this->getBlockURL() ?>/images/img_delete.gif) no-repeat center center;
}

.pageUpDown li a.up {
	background: url(<?php echo $this->getBlockURL() ?>/images/img_up.gif) no-repeat center center;
}
.pageUpDown li a.down {
	background: url(<?php echo $this->getBlockURL() ?>/images/img_down.gif) no-repeat center center;
}
</style>

<fieldset>
	<dl>
		<dt>name <em>optional</em></dt>
		<dd><?php echo $form->text("name", $name, array("size" => 30)); ?></dd>
		<dt>description <em>optional</em></dt>
		<dd><?php echo $form->text("description", $description, array("size" => 30)); ?></dd>
	</dl>
</fieldset>

<fieldset>
	<dl>
		<dt>Packages</dt>
		<dd>
			<?php echo $form->select("package", $packages, 0, array("id" => "package", "tabindex" => "0")); ?>
			<?php echo $ah->button(t('Add Fileset'), '', null, null, array("id" => "addFileset")); ?>
		</dd>
	</dl>
</fieldset>

<ul id="packageList" class="packageList">
<?php foreach($packages as $key => $value) : ?>
	<li>
		<p><a class="delete" href="#<?php echo $key; ?>">delete</a>&nbsp;<strong><?php echo $value; ?></strong></p>
		<ul class="pageUpDown">
		<?php if ($key == 1) { ?>
			<li><a class="down" href="#">down</a></li>
		<?php } else if (count($packages) >= $key) { ?>
			<li><a class="up" href="#">up</a></li>
		<?php } else { ?>
			<li><a class="up" href="#">up</a></li>
			<li><a class="down" href="#">down</a></li>
		<?php } ?>
		</ul>
	</li>

<?php endforeach; ?>
<!--
	<li><p><strong>Gradually</strong><br />Gradually.js</p>
		<ul class="pageUpDown">
			<li><a href="#">↑</a></li>
		</ul>
	</li>
	<li><p><strong>Exhibition</strong></p>
		<ul>
			<li><a href="#">↑</a></li>
			<li><a href="#">↓</a></li>
		</ul>
	</li>
	<li><p><strong>MMap</strong></p>
		<ul>
			<li><a href="#">↓</a></li>
		</ul>
	</li>
-->
</ul>
