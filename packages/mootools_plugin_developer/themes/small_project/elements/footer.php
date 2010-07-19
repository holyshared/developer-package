<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div class="foot">
	<div class="inner gs960">
		<?php
			$footer = new Area('Footer');
			$footer->display($c);			
		?>

		<div class="mod credit">
			<div class="inner">
				<div class="hd"><h4>credit</h4></div>
				<div class="bd">
					<p class="copyright">
						<span class="powered-by"><a href="http://www.concrete5.org" title="<?php echo t('concrete5 open source CMS')?>"><?php echo t('concrete5 Content Management')?></a></span>
						&copy; <?php echo date('Y')?> <a href="<?php echo DIR_REL?>/"><?php echo SITE?></a>.
						&nbsp;&nbsp;
						<?php echo t('All rights reserved.')?>
					</p>
	
					<p class="signin">
						<?php 
							$u = new User();
							if ($u->isRegistered()) :
								if (Config::get("ENABLE_USER_PROFILES")) {
									$userName = '<a href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
								} else {
									$userName = $u->getUserName();
								}
						?>
							<span class="sign-in"><?php echo t('Currently logged in as <strong>%s</strong>.', $userName)?> <a href="<?php echo $this->url('/login', 'logout')?>"><?php echo t('Sign Out')?></a></span>
						<?php else: ?>
							<span class="sign-in"><a href="<?php echo $this->url('/login')?>"><?php echo t('Sign In to Edit this Site')?></a></span>
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
		<?php Loader::element('footer_required'); ?>
	</div>
</div>
<!-- /foot -->

		</div>
	</body>
</html>