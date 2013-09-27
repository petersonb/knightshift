<?php echo validation_errors(); ?>
<?php echo form_open('shifts/add'); ?>
<input type="text" name="day_of_week" value="mon" />
<input type="submit" value="Add Shift" />
</form>