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

$menu_items = array(
		array('base'=>'admins',
				'name'=>'Home',
				'dropdown_items' => array(),
		),
		array('base'=>'admins',
				'name'=>'Profile',
				'dropdown_items' => array(

						array('base'=>'admins/edit_profile',
								'name'=>'Edit Profile',
								'dropdown_items' => array()
						),
						array('base'=>'admins/change_password',
								'name'=>'Change Password',
								'dropdown_items' => array()
						)
				)
		)
);
?>

<ul class="dropdown">
	<?php foreach ($menu_items as $top_item): ?>
	<li><a href="<?php echo base_url($top_item['base']); ?>"><?php echo $top_item['name']; ?>
	<?php if (count($top_item['dropdown_items']) > 0): ?>
	<ul>
	</a> 
	<?php foreach ($top_item['dropdown_items'] as $dropdown_item): ?>
			<li><a href="<?php echo base_url($dropdown_item['base']); ?>"><?php echo $dropdown_item['name']; ?>
			</a></li>
	<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
<div style="clear: both;"></div>
