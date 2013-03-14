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
  array_push($menu_items,array('base'=>'departments/add_employee',
			       'name'=>'Add Employee'));
?>
<ul>
  <?php foreach ($menu_items as $item):?>
  <li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?></a></li>
  <?php endforeach; ?>
</ul>
