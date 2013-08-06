<?php echo validation_errors(); ?>
<?php echo form_open('departments/notify_employees'); ?>
<table>
	<tr>
		<td style="float: left">Message:</td>
		<td><textarea name="message"
				style="resize: none; width: 25em; height: 6em;"></textarea>
		</td>
	</tr>
	<tr>
		<td>Priority:</td>
		<td><select name="priority">
				<option value="3">Low</option>
				<option value="2">Medium</option>
				<option value="1">High</option>
		</select>
		</td>
	</tr>
	<tr>
		<td><?php echo form_submit('submit','Submit'); ?>
		</td>
	</tr>
</table>
</form>
