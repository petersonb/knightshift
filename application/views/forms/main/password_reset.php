<?php echo form_open('main/password_reset?pwrc='.$code); ?>
New Password: <input type="password" name="new" />
<br />
Confirm Password: <input type="password" name="confirm" />
<br />
<input type="submit" value="change password" />
</form>