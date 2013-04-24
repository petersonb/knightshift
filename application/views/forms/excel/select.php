<?php
for ($i = 1; $i < 13; $i++)
{
	$dval = mktime('0','0','0',strval($i),date('d'),date('Y'));
	$months[$i] = array('val'=>date('m',$dval),'name'=>date('F',$dval));
}
?>

<?php form_open('excel/admin_generated'); ?>
<select>
	<?php foreach ($months as $m): ?>
	<option value="<?php echo $m['val']; ?>">
		<?php echo $m['name']; ?>
	</option>
	<?php endforeach; ?>
</select>
<br />
<input type="submit" value="submit" />
</form>
