<?php echo validation_errors()?>
<?php echo form_open('departments/remove_employee'); ?>
<input type="hidden" name="employee_id"
	id="eid" />
<table cellpadding="0" cellspacing="0" border="0" class="display"
	id="employees">
	<thead>
		<tr>
			<th>Id</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<div style="clear: both;"></div>
<hr />
<input type="submit" value="Remove Employee" />
</form>

