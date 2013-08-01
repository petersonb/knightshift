<div class="statusBar">
	<?php if (isset($name)):?>
	<h5 style="float: left;">
		Logged in as :
		<?php echo $name;?>
	</h5>
	<?php if (isset($context)): ?>
	<h5 style="float: right;">
		Context :
		<?php echo $context; ?>
	</h5>
	<?php endif; ?>
	<?php endif;?>
	<div style="clear: both;"></div>
</div>
