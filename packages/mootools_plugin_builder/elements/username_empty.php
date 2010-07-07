<div class="warnMessage">
	<p>
		<strong class="warning">
			<?php echo t("The name of the user of github is not input.") ?><br />
			<?php echo t("Please input the name of the user of github by user's edit display.") ?>
		</strong>
	</p>
	<?php $url = $this->url("dashboard/users/search?uID=".$uID); ?>
	<p><a title="<?php echo t("It moves to user's profile page") ?>" href="<?php echo $url ?>"><?php echo t("It moves to user's profile page &gt;&gt;") ?></a></p>
</div>