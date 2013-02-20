<html>
<head>
<title></title>
</head>
<body>
  <?php
    if (isset($content))
      {
	foreach ($content as $c_view)
	  {
	    $this->load->view('content/'.$c_view);
	  }
      }
  ?>
</body>
</html>
