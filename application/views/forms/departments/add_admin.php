<?php echo validation_errors()?>
<?php echo form_open('departments/add_admin'); ?>
<input type="hidden"
	name="admin_id" id="aid" />
<table cellpadding="0" cellspacing="0" border="0" class="display"
	id="admins">
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
<input type="submit" value="add admin" />
</form>

