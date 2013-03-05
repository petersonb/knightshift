<html>
<head>
<style type="text/css" >
<?php if ($this->session->userdata('employee_id')): ?>
body {
    background : lightblue;
}
<?php elseif ($this->session->userdata('admin_id')): ?>
body {
    background : lightgreen;
}
<?php elseif ($this->session->userdata('department_id')): ?>
body {
    background : pink;
}
<?php endif; ?>
</style>

<title><?php if (isset($title)) echo $title; ?></title>
</head>
<body>
  <?php
    if (isset($content))
      {
	if (is_array($content))
	  {
	    foreach ($content as $c_view)
	      {
		$this->load->view('content/'.$c_view);
	      }
	  }
	else
	  {
	    $this->load->view('content/'.$content);
	  }
      }
  ?>
</body>
</html>
