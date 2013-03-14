<ul>
  <?php foreach ($departments as $d): ?>
  <li>
    <a href="<?php echo base_url('departments/set_context/'.$d['id']); ?>"><?php echo $d['name']; ?></a><br />
  </li>
  <?php endforeach; ?>
</ul>
