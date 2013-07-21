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

$date_value = date('m');
?>

<?php echo form_open('excel/admin_generate'); ?>
<p>Select the month and year of the hours you wish to generate excel sheets for this department.</p>
<hr />
<table>
	<tr>
		<td>Month:</td>
		<td><select name="month">
				<?php foreach ($months as $m): ?>
				<option
				<?php if ($m['val'] == $date_value) echo "selected=selected"; ?>
					value="<?php echo $m['val']; ?>">
					<?php echo $m['name']; ?>
				</option>
				<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Year:</td>
		<td><select name="year">
				<?php foreach ($years as $y): ?>
				<option value="<?php echo $y; ?>">
					<?php echo $y; ?>
				</option>
				<?php endforeach; ?>
		</select>
		</td>
	</tr>
</table>
<hr/>
<input type="submit" value="Generate Excel Sheets" />
</form>
