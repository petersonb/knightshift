<?php echo validation_errors(); ?>
<?php echo form_open('hours/log_time'); ?>
<?php if ($no_eid): ?>
Employee Id: <input type="text" name="employee_id" />
<br />
<?php endif; ?>
Date: <input type="text" name="date" /> <br />
Time-in: <input type="text" name="time_in" /> <br />
Time-out: <input type="text" name="time_out" /> <br />
<input type="submit" value="Log Time" />
</form>
