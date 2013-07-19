<?php

$menu_items = array(
		array('base'=>'hours',
				'name'=>'Hours',
				'context'=>'no',
				'dropdown_items' => array(
						array('base'=>'hours/log_time',
								'name'=>'Log Time',
								'context'=>'yes'
						),
						array('base'=>'hours/view_all',
								'name'=>'View All',
								'context'=>'no'
						),
				)
		),
		array('base'=>'departments',
				'name'=>'Departments',
				'context'=>'no',
				'dropdown_items'=>array(),
		),
		array('base'=>'employees',
				'name'=>'Profile',
				'context'=>'no',
				'dropdown_items' => array(
						array('base'=>'employees/edit_profile',
								'name'=>'Edit Profile',
								'context'=>'no',
						),
						array('base'=>'employees/change_password',
								'name'=>'Change Password',
								'context'=>'no'
						),
						array('base'=>'main/logout',
								'name'=>'Logout',
								'context'=>'no'
						),
				),
		),
		array('base'=>'departments/unset_context',
				'name'=>'Unset Context',
				'context'=>'yes',
				'dropdown_items'=>array(),
		)
);

$context = $this->session->userdata('department_context');
?>


<ul>
	<?php foreach ($menu_items as $top_item): ?>
	<?php if ( $top_item['context'] == 'no' || ($top_item['context'] == 'yes' && $context)): ?>
	<li><a href="<?php echo base_url($top_item['base']); ?>"><?php echo $top_item['name']; ?>
	</a> <?php if (count($top_item['dropdown_items']) > 0): ?>
		<ul>
			<?php foreach ($top_item['dropdown_items'] as $dropdown_item): ?>
			<?php if ( $dropdown_item['context'] == 'no' || ($dropdown_item['context'] == 'yes' && $context)): ?>
			<li><a href="<?php echo base_url($dropdown_item['base']); ?>"><?php echo $dropdown_item['name']; ?>
			</a></li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul> <?php endif; ?>
	</li>
	<?php endif;?>
	<?php endforeach; ?>
</ul>
<div style="clear: both;"></div>
