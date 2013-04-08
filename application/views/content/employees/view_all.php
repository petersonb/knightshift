<h1>View All Employees</h1>

<table id="all_employees">
	<thead>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			
			<?php if ($this->admin_id):?>
			<th>Hourly</th>
			<th width="10px">Edit</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
