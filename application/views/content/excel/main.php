<h1>Excel Handling</h1>
<p>Please select the depeartment you would like to generate excel sheets
	for.</p>

<ul>
	<?php foreach ($departments as $d): ?>
	<li><a
		href="<?php echo base_url('departments/set_context/'.$d['id']); ?>"><?php echo $d['name']; ?>
	</a></li>
	<?php endforeach; ?>
</ul>
