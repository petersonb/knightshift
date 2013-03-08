<?Php echo validation_errors(); ?>
<?php echo form_open('employees/edit_profile'); ?>
First Name*: <input type="text" name="firstname" value="<?php echo $employee->firstname; ?>" />
<br />
Last Name*: <input type="text" name="lastname" value="<?php echo $employee->lastname; ?>" />
<br />
Email*: <input type="text" name="email" value="<?php echo $employee->email; ?>" />
<br />
<input type="submit" value="save changes" />
</form>
