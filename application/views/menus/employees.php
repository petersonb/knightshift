<?php
$menu_items = array(
		    array('base'=>'employees',
			  'name'=>'Home'),
		    array('base'=>'hours/view_all',
			  'name'=>'View Hours'),
		    array('base'=>'employees/edit_profile',
			  'name'=>'Edit Profile'),
		    array('base'=>'employees/change_password',
			  'name'=>'Change Password')
		    );

$context = $this->session->userdata('department_context');
if ($context)
  $context_items = array(
			 array('base'=>'hours/log_time',
			       'name'=>'Log Time')
			 );
?>
<ul>
  <?php foreach ($menu_items as $item):?>
  <li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?></a></li>
  <?php endforeach; ?>
</ul>

<?php if ($context): ?>
<ul class="context_nav">
  <?php foreach ($context_items as $item):?>
  <li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?></a></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>
