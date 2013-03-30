<ul>
  <?php if (isset($departments)): ?>
  <?php foreach ($departments as $d): ?>
  <li>
    <a href="<?php echo base_url('departments/set_context/'.$d['id']); ?>"><?php echo $d['name']; ?></a><br />
  </li>
  <?php endforeach; ?>
  <?php else: ?>
  <p>You do not have any departments. Click <a href="<?php echo base_url('departments/create'); ?>">here</a> to create a department</p>
  <?php endif; ?>
</ul>
