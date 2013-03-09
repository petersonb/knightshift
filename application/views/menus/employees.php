<?php
$menu_items = array(
		    array('base'=>'employees',
			  'name'=>'Home'),
		    array('base'=>'hours/view_all',
			  'name'=>'View Hours'));

$context = $this->session->userdata('department_context');
if ($context)
  array_push($menu_items,array('base'=>'hours/log_time',
			       'name'=>'Log Time'));
?>
<ul>
  <?php foreach ($menu_items as $item):?>
  <li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?></a></li>
  <?php endforeach; ?>
</ul>
