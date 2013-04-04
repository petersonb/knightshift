<?php 
$inputs = array(
		array(
				'label'=>'Title',
				'name'=>'title',
				'value'=>$admin['title']
		),
		array(
				'label'=>'First Name',
				'name'=>'firstname',
				'value'=>$admin['firstname']
		),
		array(
				'label'=>'Last Name',
				'name'=>'lastname',
				'value'=>$admin['lastname']
		),
		array(
				'label'=>'Email',
				'name'=>'email',
				'value'=>$admin['email']
		)
);
?>

<?Php echo validation_errors(); ?>
<?php echo form_open('admins/edit_profile'); ?>

<table>
	<?php form_input_bank($inputs); ?>
	<tr>
		<td><?php echo form_submit('submit','Save Changes'); ?></td>
	</tr>
</table>
</form>
