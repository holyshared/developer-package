<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php
	$pageVersion = $c->vObj;
	$block = Block::getByName('My_Site_Name');
	$description = $pageVersion->cvDescription;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php Loader::element('header_required'); ?>
		<meta http-equiv="Content-Language" content="ja" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
<!--		<link rel="stylesheet" href="<?php echo $this->getStyleSheet('style.css'); ?>" type="text/css" media="screen" /> -->
		<link rel="stylesheet" href="/packages/mootools_plugin_builder/themes/script_builder/style.css" type="text/css" media="screen" />
	</head>
	<body>
		<div class="page gs960">
			<div class="head">
				<h1 class="logo"><a href="<?php echo DIR_REL?>/"><?php echo ($block && $block->bID) ? $block->display() : SITE; ?></a></h1>
				<p class="description"><?php echo $description; ?></p>
				<?php
					$ah = new Area('Header');
					$ah->display($c);			
				?>
				<div class="nav">
					<?php
						$nav = new Area('Header Nav');
						$nav->display($c);
					?>
				</div>
			</div>
