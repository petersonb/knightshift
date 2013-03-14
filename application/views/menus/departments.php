<?php
$menu_items = array(
		    array('base'=>'employees',
			  'name'=>'Home'),
		    array('base'=>'hours/view_all',
			  'name'=>'View Hours'));
?>
<ul>
  <?php foreach ($menu_items as $item):?>
  <li><a href="<?php echo base_url($item['base']); ?>"><?php echo $item['name']; ?></a></li>
  <?php endforeach; ?>
</ul>
