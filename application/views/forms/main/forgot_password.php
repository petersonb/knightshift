<?php 
	$input = array(
			'label'=>'Email',
			'name'=>'email',
			'value'=>''
	);
?>

<?php echo form_open('main/forgot_password'); ?>
<h3>Email</h3>
<p>An email will be sent to this email with a reset code.</p>
<?php echo form_input($input); ?>
<br />
<?php echo form_submit('submit','Submit'); ?>
</form>