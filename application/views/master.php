<html>
<head>
<title></title>
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
