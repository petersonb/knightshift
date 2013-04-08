<?php 
$passwords = array(
		array(
				'label'=>'Current Password',
				'name'=>'current',
		),
		array(
				'label'=>'New Password',
				'name'=>'new',
		),
		array(
				'label'=>'Confirm New',
				'name'=>'confirm'
		),
);
?>

<?php echo validation_errors(); ?>
<?php
if ($this->employee_id)
{
	echo form_open('employees/change_password');
}
else
{
	echo form_open('admins/change_password');
}
?>

<table>
	<?php form_password_bank($passwords); ?>
	<tr>
		<td><?php echo form_submit('submit','Change Password'); ?>
		</td>
	</tr>
</table>
</form>
