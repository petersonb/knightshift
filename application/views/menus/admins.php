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
			array('base'=>'employees/view_all',
					'name'=>'View Employees'),
			array('base'=>'hours/view_all',
					'name'=>'View Hours'),
			array('base'=>'hours/log_time',
					'name'=>'Log Time'),
			array('base'=>'departments/add_employee',
					'name'=>'Add Employee'),
			array('base'=>'departments/create',
					'name'=>'Create Department'),
			array('base'=>'excel',
					'name'=>'Excel Handling'),
	);
else
{
	array_push($menu_items,array('base'=>'hours/view_all','name'=>'View All Hours'));
}
?>
<ul>
	<?php foreach ($menu_items as $item):?>
	<li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?>
	</a></li>
	<?php endforeach; ?>
	<li class="logout"><a href="<?php echo base_url('main/logout'); ?>">Logout</a>
	</li>
	<?php if($context): ?>
	<li class="logout"><a
		href="<?php echo base_url('departments/unset_context'); ?>">Unset
			Context</a>
	</li>
	<?php endif; ?>
</ul>

<?php if($context): ?>
<ul class="context_nav">
	<?php foreach ($context_items as $item):?>
	<li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?>
	</a></li>
	<?php endforeach; ?>

</ul>
<?php endif; ?>
