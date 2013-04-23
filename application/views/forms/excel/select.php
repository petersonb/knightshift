<?php
foreach(range(1,12) as $mval)
{
	echo date('F',intval($mval));
	$months[$mval] = date('F',5);
} 
var_dump($months);
?>

<?php form_open('excel/admin'); ?>
</form>