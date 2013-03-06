<h1><?php echo $department->name; ?></h1>
<h3>View All Hours</h3>

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
