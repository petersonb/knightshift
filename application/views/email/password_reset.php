<h3>Dear <?php echo $firstname; ?>,</h3>
<p>You have requested to have your password reset. Please click the
	following link.</p>
<br />
<a
	href="<?php echo base_url('main/password_reset'); ?>?pwrc=<?php echo $code; ?>">Click
	here to reset your password.</a>
<p>If you did not request a password change, please contact KnightShift
	Support at support@knightshift-track.com</p>
<br />
<p>
	Thanks,<br />KnightShift Support
</p>
