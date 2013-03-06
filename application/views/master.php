<html>
<head>
<link href="<?php echo base_url("css/style.css"); ?>" type="text/css" rel="stylesheet" />
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
  <div id="container">
    <a href="<?php echo base_url('main/logout') ?>">Logout</a>
    <?php if ($this->session->userdata('department_context')): ?>
    <a href="<?php echo base_url('departments/unset_context'); ?>">Unset Context</a>
    <?php endif; ?>
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
  </div>
</body>
</html>
