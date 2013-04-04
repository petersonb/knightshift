<?php echo validation_errors(); ?>
<?php echo form_open('hours/log_time'); ?>
<?php if ($no_eid): ?>
Employee Id:
<input type="text" name="employee_id" />
<br />
<?php endif; ?>
Date:
<input id="datepicker"
	type="text" name="date" />
<br />
<table>
	<tr>
		<td>Time-in :</td>
		<td><select name="hour_in">
				<?php for ($i = 1; $i < 13; $i++):?>
				<?php if ($i < 10) $i = "0".$i; ?>
				<option value="<?php echo $i; ?>">
					<?php echo $i; ?>
				</option>
				<?php endfor; ?>
		</select></td>
		<td>:</td>
		<td><select name="minute_in">
				<?php for ($i = 0; $i < 60; $i+=15): ?>
				<?php if ($i == 0) $i = "00"; ?>
				<option value="<?php echo $i; ?>">
					<?php echo $i; ?>
				</option>
				<?php endfor; ?>
		</select></td>
		<td><select name="pm_in"><option value="0">AM</option>
				<option value="1">PM</option>
		</select>
		</td>
	</tr>
</table>
<br />
<table>
	<tr>
		<td>Time-out :</td>
		<td><select name="hour_out">
				<?php for ($i = 1; $i < 13; $i++):?>
				<?php if ($i < 10) $i = "0".$i; ?>
				<option value="<?php echo $i; ?>">
					<?php echo $i; ?>
				</option>
				<?php endfor; ?>
		</select></td>
		<td>:</td>
		<td><select name="minute_out">
				<?php for ($i = 0; $i < 60; $i+=15): ?>
				<?php if ($i == 0) $i = "00"; ?>
				<option value="<?php echo $i; ?>">
					<?php echo $i; ?>
				</option>
				<?php endfor; ?>
		</select></td>
		<td><select name="pm_out"><option value="0">AM</option>
				<option value="1">PM</option>
		</select>
		</td>
	</tr>
</table>
<input type="submit" value="Log Time" />
</form>
