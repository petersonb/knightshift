<?php 
$inputs = array(
		array(
				'label'=>'First Name',
				'name'=>'firstname',
				'value'=>$employee['firstname']
		),
		array(
				'label'=>'Last Name',
				'name'=>'lastname',
				'value'=>$employee['lastname']
		),
		array(
				'label'=>'Email',
				'name'=>'email',
				'value'=>$employee['email']
		)
);
?>

<?Php echo validation_errors(); ?>
<?php echo form_open('employees/edit_profile'); ?>
<table>
	<?php form_input_bank($inputs); ?>
	<tr>
		<td><?php echo form_submit('submit','Save Changes'); ?></td>
	</tr>
</table>