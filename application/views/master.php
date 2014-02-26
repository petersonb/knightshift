<html>
<head>
<link href="<?php echo base_url("css/style.css"); ?>" type="text/css"
	rel="stylesheet" />
<link href="<?php echo base_url("css/dropdown.css"); ?>" type="text/css"
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

<title><?php if (isset($title)) echo $title; ?>
</title>

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
    <div style="position:fixed; top:30px; left:30px; z-index:-100">
	<img style="width : 200px" src="/images/birds/lemon.png" alt="ad" />
    </div>
    <div style="position:fixed; top:30px; right:30px; z-index:-100">
	<img style="width : 200px" src="/images/birds/obey.png" alt="ad" />
    </div>
    
	<div id="wrapper">
		<div class="header">
			<?php $this->load->view('main/header'); ?>
		</div>
		

		<?php $this->load->view('main/status_bar',$this->status->get()); ?>
		<div class="nav">
			<?php $this->load->view('menus/main'); ?>
		</div>
		<div class="body">
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
		<div class="footer">
			<?php $this->load->view('main/footer')?>
		</div>
	</div>
</body>
</html>
