<h1>Employees</h1>
<hr />
<h3>Departments</h3>
<?php foreach ($departments as $d): ?>
<a href="<?php echo base_url('departments/set_context/'.$d->id); ?>"><?php echo $d->name; ?></a><br />
<?php endforeach; ?>
