<?php echo validation_errors() ?>
<?php
$form_string = 'employees/admin_manage/'.$employee['id'];
if(!$this->department_context) $form_string = $formstring.'/'.$eid;
?>
<?php echo form_open($form_string); ?>
<table>
	<tr>
		<td>Hourly Wage:</td>
		<td><input type="text" name="hourly" value="<?php echo $current_rate; ?>" />
		</td>
	</tr>
</table>
<input type="submit" value="change rate" />
</form>
