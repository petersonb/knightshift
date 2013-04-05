<?php
$menu_items = array(
		array('base'=>'admins',
				'name'=>'Home'),
		array('base'=>'admins/edit_profile',
				'name'=>'Edit Profile'),
		array('base'=>'admins/change_password',
				'name'=>'Change Password')
);

$context = $this->session->userdata('department_context');

if ($context)
	$context_items = array(
			array('base'=>'hours/view_all',
					'name'=>'View Hours'),
			array('base'=>'departments/add_employee',
					'name'=>'Add Employee'),
			array('base'=>'departments/create',
					'name'=>'Create Department'),
			array('base'=>'employees/view_all',
					'name'=>'View Employees')
	);
?>
<ul>
	<?php foreach ($menu_items as $item):?>
	<li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?>
	</a></li>
	<?php endforeach; ?>
</ul>

<?php if($context): ?>
<ul class="context_nav">
	<?php foreach ($context_items as $item):?>
	<li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?>
	</a></li>
	<?php endforeach; ?>

</ul>
<?php endif; ?>
