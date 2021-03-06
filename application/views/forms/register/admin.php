<?php 
$inputs = array(
		array(
				'label'=>'Title',
				'name'=>'title',
				'value'=>set_value('title'),
		),
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
				'value'=>set_value('email'),
		)
);

$passwords = array(
		array(
				'label'=>'Password',
				'name'=>'password'
		),
		array(
				'label'=>'Confirm',
				'name'=>'confirm'
		)
)
?>

<?php echo validation_errors(); ?>
<?php echo form_open('register/admin'); ?>


<table>
	<?php form_input_bank($inputs); ?>
	<?php form_password_bank($passwords); ?>
	<tr>
		<td><input type="checkbox" name="valid" />
		</td>
		<td>I am not a student at Wartburg College, but work there in a
			position to keep track of student hours.</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo form_submit('submit','Submit');?>
		</td>
	</tr>
</table>
</form>
