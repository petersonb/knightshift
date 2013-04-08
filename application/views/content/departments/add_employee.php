<h1>Add Employee</h1>
<p>Select an existing from an employee in the table below.</p>
<p>
	If the employee does not exist, you can create their account <a
		href="<?php echo base_url("register/employee"); ?>">here.</a>
</p>
<?php $this->load->view('forms/departments/add_employee'); ?>