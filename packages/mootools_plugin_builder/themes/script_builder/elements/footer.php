<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
		<div class="foot">
			<p>
				<span class="powered-by"><a href="http://www.concrete5.org" title="<?php echo t('concrete5 open source CMS')?>"><?php echo t('concrete5 Content Management')?></a></span>
				&copy; <?php echo date('Y')?> <a href="<?php echo DIR_REL?>/"><?php echo SITE?></a>.
				&nbsp;&nbsp;
				<?php echo t('All rights reserved.')?>
			</p>
			<?php Loader::element('footer_required'); ?>
		</div>
	</div>
</body>
</html>