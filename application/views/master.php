<html>
<head>
<link href="<?php echo base_url("css/style.css"); ?>" type="text/css"
	rel="stylesheet" />

<?php
if (isset($css))
{
	if (is_array($css))
	{
		foreach ($css as $style):
		?>
<link href="<?php echo base_url("css/".$style.".css"); ?>"
	type="text/css" rel="stylesheet" />
<?php endforeach;
	}
	else
	{
		?>
<link href="<?php echo base_url("css/".$css.".css"); ?>" type="text/css"
	rel="stylesheet" />
<?php  }
}?>

<title><?php if (isset($title)) echo $title; ?></title>

<?php 
if (isset($javascript)):
if (is_array($javascript)):
foreach ($javascript as $js_file):
?>
<script type="text/javascript"
	src="<?php echo base_url('javascript/'.$js_file.'.js'); ?>"></script>
<?php 
endforeach;
else:
?>
<script type="text/javascript"
	src="<?php echo base_url('javascript/'.$javascript.'.js'); ?>"</script>
<?php 
endif;
endif;
?>


</head>
<body>
	<div id="wrapper">

		<div class="nav">
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

		<div class="content">
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
	</div>
</body>
</html>
