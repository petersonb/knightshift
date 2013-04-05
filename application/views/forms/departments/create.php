<?php 
$inputs = array(
		array(
				'label'=>'Department Name',
				'name'=>'name',
				'value'=>set_value('name')
		),
		array(
				'label'=>'Login Name',
				'name'=>'login_name',
				'value'=>set_value('login_name')
		),
		array(
				'label'=>'Department Id',
				'name'=>'id',
				'value'=>set_value('id')
		)
);

$passwords = array (
		array(
				'label'=>'Password',
				'name'=>'password'
		),
		array(
				'label'=>'Confirm Password',
				'name'=>'confirm'
		)
);
?>

<?php echo validation_errors(); ?>
<?php echo form_open('departments/create'); ?>
<table>
	<?php form_input_bank($inputs); ?>
	<?php form_password_bank($passwords); ?>
	<tr>
		<td><?php echo form_submit('submit','Create Department'); ?>
		</td>
	</tr>
</table>
</form>
