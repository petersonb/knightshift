<?php echo validation_errors(); ?>
<?php echo form_open('shifts/edit/'.$shift['id']); ?>
<table>
  <tr>
    <td>Day: </td>
    <td>
      <select name="day_of_week">
	<option <?php if ($shift['day'] == 'mon'): ?>selected="selected" <?php endif; ?> value="mon">Monday</option>
	<option <?php if ($shift['day'] == 'tue'): ?>selected="selected" <?php endif; ?> value="tue">Tuesday</option>
	<option <?php if ($shift['day'] == 'wed'): ?>selected="selected" <?php endif; ?> value="wed">Wednesday</option>
	<option <?php if ($shift['day'] == 'thu'): ?>selected="selected" <?php endif; ?> value="thu">Thursday</option>
	<option <?php if ($shift['day'] == 'fri'): ?>selected="selected" <?php endif; ?> value="fri">Friday</option>
	<option <?php if ($shift['day'] == 'sat'): ?>selected="selected" <?php endif; ?> value="sat">Saturday</option>
	<option <?php if ($shift['day'] == 'sun'): ?>selected="selected" <?php endif; ?> value="sun">Sunday</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>Time in: </td>
    <td>
      <select name="hour_in">
	<?php for ($i = 1; $i < 13; $i++):?>
	      <?php if ($i < 10) $i = "0".$i; ?>
		    <option value="<?php echo $i; ?>"
			    <?php if ($time_in['hour'] == $i) echo 'selected = "selected"'; ?>>
		      <?php echo $i; ?>
		    </option>
		    <?php endfor; ?>
      </select>
      :
      <select name="minute_in">
	<?php for ($i = 0; $i < 60; $i+=15):?>
	      <?php if ($i == 0) $i = "00"; ?>
	<option value="<?php echo $i; ?>"
		<?php if ($time_in['minute'] == $i) echo 'selected="selected"'; ?>>
	  <?php echo $i; ?>
	</option>
	<?php endfor; ?>
      </select>
      <select name="pm_in"><option value="am"
				   <?php if ($time_in['period'] == "am") echo 'selected="selected"'; ?>>AM</option>
	<option value="pm"
		<?php if ($time_in['period'] == "pm") echo 'selected="selected"'; ?>>PM</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>Time Out: </td>
    <td>
      <select name="hour_out">
	<?php for ($i = 1; $i < 13; $i++):?>
	      <?php if ($i < 10) $i = "0".$i; ?>
		    <option value="<?php echo $i; ?>"
			    <?php if ($time_out['hour'] == $i) echo 'selected = "selected"'; ?>>
		      <?php echo $i; ?>
		    </option>
		    <?php endfor; ?>
      </select>
      :
      <select name="minute_out">
	<?php for ($i = 0; $i < 60; $i+=15): ?>
	      <?php if ($i == 0) $i = "00"; ?>
	<option value="<?php echo $i; ?>"
		<?php if ($time_out['minute'] == $i) echo 'selected = "selected"'; ?>>
	  <?php echo $i; ?>
	</option>
	<?php endfor; ?>
      </select>
      <select name="pm_out"><option value="am"
				    <?php if ($time_out['period'] == "am") echo 'selected = "selected"'; ?>>AM</option>
	<option value="pm"
		<?php if ($time_out['period'] == 'pm') echo 'selected = "selected"'; ?>>PM</option>
      </select>
    </td>
  </tr>
</table>
<input type="submit" value="Save Changes" />
</form>
