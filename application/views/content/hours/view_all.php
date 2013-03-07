<h1>View All Hours</h1>
<?php
foreach ($department as $dept): 
$dept->hour->where('employee_id',$employee->id);
$hours = $dept->hour->get();
?>
<hr />
<h1><?php echo $dept->name; ?></h1>
<table>
  <tr>
    <th>id</th>
    <th>Date</th>
    <th>Time In</th>
    <th>Time Out</th>
  </tr>
  <?php foreach ($hours as $hour): ?>
  <tr>
    <td><?php echo $hour->id; ?></td>
    <td><?php echo $hour->date; ?></td>
    <td><?php echo $hour->time_in; ?> </td>
    <td><?php echo $hour->time_out; ?> </td>
  </tr>
    <?php endforeach; ?>
</table>
<?php endforeach; ?>
