<?php 
$inputs = array(
		array(
				'label'=>'First Name',
				'name'=>'firstname',
				'value'=>set_value('firstname')
		),
		array(
				'label'=>'Last Name',
				'name'=>'lastname',
				'value'=>set_value('lastname')
		),
		array(
				'label'=>'Email',
				'name'=>'email',
				'value'=>set_value('email')
		),
		array(
				'label'=>'Student Id',
				'name'=>'student_id',
				'value'=>set_value('student_id')
		)
);

$passwords = array(
		array(
				'label'=>'Password',
				'name'=>'password',
		),
		array(
				'label'=>'Confirm',
				'name'=>'confirm',
		)
)
?>

<?php echo validation_errors(); ?>
<?php echo form_open('register/employee'); ?>

<table>
	<?php form_input_bank($inputs);?>
	<?php form_password_bank($passwords);?>
	<tr>
		<td colspan="2"><?php echo form_submit('submit','Submit');?>
		</td>
	</tr>
</table>
</form>
