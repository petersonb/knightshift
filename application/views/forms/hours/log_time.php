<?php echo validation_errors(); ?>
<?php 
if (uri_string() == "hours/log_time")
{
	echo form_open('hours/log_time');
}
else
{
	echo form_open('hours/edit_time/'.$hour['id']);
}
?>


<table>
	<tr>
		<?php if (isset($no_eid) && $no_eid): ?>
		<td>
			<table>
				<tr>
					<td style="float:left;">Employee:</td>
					<td><select name="employee_id" size="6">
							<?php foreach ($employees as $emp): ?>
							<option value="<?php echo $emp['id'] ; ?>">
								<?php echo $emp['firstname']. ' ' . $emp['lastname']; ?>
							</option>
							<?php endforeach;?>
					</select>
					</td>
				</tr>
			</table>
		</td>
		<?php endif; ?>

		<td>
			<table style="float:right">
				<tr>
					<td>Date:</td>
					<td><input id="datepicker" type="text" value="<?php echo $date; ?>"
						name="date" /></td>
					<br />
				</tr>
				<tr>
					<td>Time-in :</td>
					<td>
						<table>
							<tr>
								<td><select name="hour_in">
										<?php for ($i = 1; $i < 13; $i++):?>
										<?php if ($i < 10) $i = "0".$i; ?>
										<option value="<?php echo $i; ?>"
										<?php if ($time_in['hour'] == $i) echo 'selected = "selected"'; ?>>
											<?php echo $i; ?>
										</option>
										<?php endfor; ?>
								</select></td>
								<td>:</td>
								<td><select name="minute_in">
										<?php for ($i = 0; $i < 60; $i+=15):?>
										<?php if ($i == 0) $i = "00"; ?>
										<option value="<?php echo $i; ?>"
										<?php if ($time_in['minute'] == $i) echo 'selected="selected"'; ?>>
											<?php echo $i; ?>
										</option>
										<?php endfor; ?>
								</select></td>
								<td><select name="pm_in"><option value="am"
								<?php if ($time_in['period'] == "am") echo 'selected="selected"'; ?>>AM</option>
										<option value="pm"
										<?php if ($time_in['period'] == "pm") echo 'selected="selected"'; ?>>PM</option>
								</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>Time-out :</td>
					<td>
						<table>
							<tr>
								<td><select name="hour_out">
										<?php for ($i = 1; $i < 13; $i++):?>
										<?php if ($i < 10) $i = "0".$i; ?>
										<option value="<?php echo $i; ?>"
										<?php if ($time_out['hour'] == $i) echo 'selected = "selected"'; ?>>
											<?php echo $i; ?>
										</option>
										<?php endfor; ?>
								</select></td>
								<td>:</td>
								<td><select name="minute_out">
										<?php for ($i = 0; $i < 60; $i+=15): ?>
										<?php if ($i == 0) $i = "00"; ?>
										<option value="<?php echo $i; ?>"
										<?php if ($time_out['minute'] == $i) echo 'selected = "selected"'; ?>>
											<?php echo $i; ?>
										</option>
										<?php endfor; ?>
								</select></td>
								<td><select name="pm_out"><option value="am"
								<?php if ($time_out['period'] == "am") echo 'selected = "selected"'; ?>>AM</option>
										<option value="pm"
										<?php if ($time_out['period'] == 'pm') echo 'selected = "selected"'; ?>>PM</option>
								</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>

		<table>
			<tr>
				<td><input type="submit" value="Log Time" />
				</td>
			</tr>
		</table>
		</form>