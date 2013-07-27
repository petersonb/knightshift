<h1>Password Reset</h1>
<p>Hello <?php echo $firstname; ?> <?php echo $lastname; ?>,</p>
<p>This reset request was sent to <?php echo $email; ?>.</p>
<p>If this is correct, please provide a new password for your account.</p>
<?php echo validation_errors(); ?>
<?php $this->load->view('forms/main/password_reset'); ?>