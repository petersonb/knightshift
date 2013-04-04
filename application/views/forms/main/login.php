<?php
$input = array(
		'label'=>'Email or Department Login Name',
		'name'=>'email',
		'value'=>set_value('email')
);
$pass = array(
		'label'=>'Password',
		'name'=>'password'
);
?>

<?php echo validation_errors(); ?>
<?php echo form_open('main/login'); ?>

<h3>Email or Department Login Name</h3>
<?php echo form_input($input); ?>

<h3>Password</h3>
<?php echo form_password($pass); ?>

<br />
<?php echo form_submit('submit','Login'); ?>
</form>
