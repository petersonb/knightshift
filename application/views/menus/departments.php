<?php
$menu_items = array(
		array('base'=>'departments',
				'name'=>'Home'),
		array('base'=>'hours/log_time',
				'name'=>'Log Time'),
		array('base'=>'hours/view_all',
				'name'=>'View Hours'),
		array('base'=>'employees/view_all',
				'name'=>'View Employees')
);
?>
<ul>
	<?php foreach ($menu_items as $item):?>
	<li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?>
	</a></li>
	<?php endforeach; ?>
	<li class="logout"><a href="<?php echo base_url('main/logout'); ?>">Logout</a>
	</li>
</ul>
