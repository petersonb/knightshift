<?php echo validation_errors(); ?>
<?php echo form_open('hours/edit_time/'.$hour->id); ?>
Date: <input type="text" value="<?php echo $hour->date; ?>" name="date" />
<br />
Time In: <input type="text" name="time_in" value="<?php echo $hour->time_in; ?>" />
<br />
Time Out: <input type="text" name="time_out" value="<?php echo $hour->time_out; ?>" />
<br />
<input type="submit" value="change hour" />
</form>
