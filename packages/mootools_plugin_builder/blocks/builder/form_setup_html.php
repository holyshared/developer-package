<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
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
	padding: 5px 10px;
	border-top: 1px solid #cccccc;
	border-left: 1px solid #cccccc;
	border-right: 1px solid #cccccc;
	overflow: hidden;
}

.packageList li p {
	float: left;
	width: 80%;
}

.packageList li:last-child {
	border-bottom: 1px solid #cccccc;
}
.pageUpDown {
	width: 19%;
	float: right;
}
.pageUpDown li {
	border: none;
}


</style>

<?php $form = Loader::helper('form'); ?>
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
			<?php
				$packages = array();
				foreach($filesets as $key => $fileset) {
					$packages[$fileset->fsID] = $fileset->fsName;
				}
				echo $form->select("package", $packages, 0, array("id" => "package", "tabindex" => "0"));
			?>
		</dd>
	</dl>
</fieldset>

<ul class="packageList">
	<li><p><strong>Gradually</strong><br />Gradually.js</p>
		<ul class="pageUpDown">
			<li><a href="#">↑</a></li>
		</ul>
	</li>
	<li><p><strong>Exhibition</strong><br />Exhibition.js, Exhibition.Holizonaljs, Exhibition.version.js</p>
		<ul>
			<li><a href="#">↑</a></li>
			<li><a href="#">↓</a></li>
		</ul>
	</li>
	<li><p><strong>MMap</strong><br />MMap.js, MMap.Overlay, MMap.Marker, MMap.Marker.Image, MMap.Marker.Images</p>
		<ul>
			<li><a href="#">↓</a></li>
		</ul>
	</li>
</ul>

