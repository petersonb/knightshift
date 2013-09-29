<?php echo validation_errors(); ?>
<?php echo form_open('shifts/add'); ?>
<table>
  <tr>
    <td>Day of week: </td>
    <td>
      <select name="day_of_week">
	<option value="mon">Monday</option>
	<option value="tue">Tuesday</option>
	<option value="wed">Wednesday</option>
	<option value="thu">Thursday</option>
	<option value="fri">Friday</option>
	<option value="sat">Saturday</option>
	<option value="sun">Sunday</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>Time in: </td>
    <td>
      <select name="hour_in">
	<?php for ($i = 1; $i < 13; $i++):?>
	      <?php if ($i < 10) $i="0".$i; ?>
		    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		    <?php endfor;?>
      </select>
      :
      <select name="minute_in">
	<?php for ($i = 0; $i < 60; $i+=15):?>
	      <?php if ($i < 10) $i = "0".$i; ?>
		    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		    <?php endfor; ?>
      </select>
    <select name="day_in">
      <option value="am">AM</option>
      <option value="pm">PM</option>
    </select>
</select>
</td>
</tr>
<tr>
  <td>Time out: </td>
  <td>
    <select name="hour_out">
      <?php for ($i = 1; $i < 13; $i++):?>
	    <?php if ($i < 10) $i="0".$i; ?>
		  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		  <?php endfor;?>
    </select>
    :
    <select name="minute_out">
      <?php for ($i = 0; $i < 60; $i+=15):?>
	    <?php if ($i < 10) $i = "0".$i; ?>
		  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		  <?php endfor; ?>
    </select>
    <select name="day_out">
      <option value="am">AM</option>
      <option value="pm">PM</option>
    </select>
</select>
</td>
</tr>

</table>
<input type="submit" value="Add Shift" />
</form>
