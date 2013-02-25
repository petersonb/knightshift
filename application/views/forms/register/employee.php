<?php echo validation_errors(); ?>
<?php echo form_open('register/employee'); ?>

First Name: <input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" />
<br />
Last Name: <input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>" />
<br />
email: <input type="text" name="email" value="<?php echo set_value('email'); ?>" />
<br />
password: <input type="password" name="password" />
<br />
confirm: <input type="password" name="confirm" />
<br />
<input type="submit" value="submit" />

</form>
