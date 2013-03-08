<?php echo validation_errors(); ?>
<?php echo form_open('admins/change_password'); ?>
Current Password: <input type="password" name="current" />
<br />
New Password: <input type="password" name="new" />
<br />
Confirm Password: <input type="password" name="confirm" />
<br />
<input type="submit" value="change password" />
</form>
