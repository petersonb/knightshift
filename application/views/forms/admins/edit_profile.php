<?Php echo validation_errors(); ?>
<?php echo form_open('admins/edit_profile'); ?>
Title: <input type="text" name="title" value="<?php echo $admin->title; ?>" />
<br />
First Name*: <input type="text" name="firstname" value="<?php echo $admin->firstname; ?>" />
<br />
Last Name*: <input type="text" name="lastname" value="<?php echo $admin->lastname; ?>" />
<br />
Email*: <input type="text" name="email" value="<?php echo $admin->email; ?>" />
<br />
<input type="submit" value="save changes" />
</form>
