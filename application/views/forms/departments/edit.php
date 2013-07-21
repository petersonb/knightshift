<?php 
$inputs = array(
		array(
				'label'=>'Department Name',
				'name'=>'name',
				'value'=>$department['name']
		),
		array(
				'label'=>'Login Name',
				'name'=>'login_name',
				'value'=>$department['login_name']
		),
		array(
				'label'=>'Department Id',
				'name'=>'id',
				'value'=>$department['id']
		),
		array(
				'label'=>'Supervisors',
				'name'=>'supervisors',
				'value'=>$department['supervisors']
		)
);
?>

<?php echo validation_errors(); ?>
<?php echo form_open('departments/edit'); ?>
<table>
	<?php form_input_bank($inputs); ?>
	<tr>
		<td><?php echo form_submit('submit','Create Department'); ?>
		</td>
	</tr>
</table>
</form>
