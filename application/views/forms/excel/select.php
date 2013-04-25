<?php
for ($i = 1; $i < 13; $i++)
{
	$dval = mktime('0','0','0',strval($i),date('d'),date('Y'));
	$months[$i] = array('val'=>date('m',$dval),'name'=>date('F',$dval));
}

$years = array();
for ($y = 2013; $y <= date('Y'); $y++)
{
	array_push($years, $y);
}
?>

<?php echo form_open('excel/admin_generate'); ?>
<select name="month">
	<?php foreach ($months as $m): ?>
	<option value="<?php echo $m['val']; ?>">
		<?php echo $m['name']; ?>
	</option>
	<?php endforeach; ?>
</select>
<select name="year">
	<?php foreach ($years as $y): ?>
	<option value="<?php echo $y; ?>">
		<?php echo $y; ?>
	</option>
	<?php endforeach; ?>
</select>
<br />
<input type="submit"
	value="submit" />
</form>
