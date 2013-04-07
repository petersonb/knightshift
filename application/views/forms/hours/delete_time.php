
<?php echo validation_errors(); ?>
<?php echo form_open('hours/delete_time/'.$hour['id']); ?>
<h3>Are you sure you want to delete this hour?</h3>
<table>
	<tr>
		<td>Department:</td>
		<td><?php echo $hour['department'];?>
	
	</tr>
	<tr>
		<td>Date:</td>
		<td><?php echo $hour['date']; ?>
	
	</tr>
	<tr>
		<td>Time In:</td>
		<td><?php echo $hour['time_in']; ?></td>
	</tr>
	<tr>
		<td>Time Out:</td>
		<td><?php echo $hour['time_out']; ?></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="confirm" /></td>
		<td>Yes, I am sure I want to delete this hour.</td>
	</tr>
	<tr>
		<td><?php echo form_submit('submit','Confirm'); ?>
	</tr>
</table>
</form>
