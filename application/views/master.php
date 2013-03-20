<html>
<head>
<link href="<?php echo base_url("css/style.css"); ?>" type="text/css" rel="stylesheet" />

<?php
   if (isset($css))
     {
       if (is_array($css))
	 {
	   foreach ($css as $style):
?>
<link href="<?php echo base_url("css/".$style.".css"); ?>" type="text/css" rel="stylesheet" />
<?php endforeach;
	 }
       else
	 {
?>
<link href="<?php echo base_url("css/".$css.".css"); ?>" type="text/css" rel="stylesheet" />
<?php  }}?>

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

<?php 
if (isset($javascript)):
  if (is_array($javascript)):
    foreach ($javascript as $js_file): 
?>
<script type="text/javascript" src="<?php echo base_url('javascript/'.$js_file.'.js'); ?>"></script>
<?php 
endforeach;
else: 
?>
<script type="text/javascript" src="<?php echo base_url('javascript/'.$javascript.'.js'); ?>"</script>
<?php 
endif;
endif;
?>


</head>
<body>
  <div id="container">
    <a href="<?php echo base_url('main/logout') ?>">Logout</a>
    <?php if ($this->session->userdata('department_context')): ?>
    <a href="<?php echo base_url('departments/unset_context'); ?>">Unset Context</a>
    <?php endif; ?>
    
    <div class="nav" id="navbar">
      <?php
	if ($this->session->userdata('employee_id'))
	  {
	    $this->load->view('menus/employees');
	  }
	  elseif ($this->session->userdata('admin_id'))
	    {
	      $this->load->view('menus/admins');
	    }
	    elseif ($this->session->userdata('department_id'))
	      {
		$this->load->view('menus/departments');
	      }
	    else
	      {
		$this->load->view('menus/main');
	      }
	    ?>
    </div>
      
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
