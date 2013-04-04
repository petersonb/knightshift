<?php

/**
 * For Input Bank
 * 
 * Takes array of form_input data and returns
 * table rows for input.
 * 
 * @param array $inputs
 * 	- array of form_input data
 */
function form_input_bank($inputs)
{
	foreach ($inputs as $i):
	?>
<tr>
	<td><?php echo $i['label']; ?>:</td>
	<td><?php echo form_input($i); ?></td>
</tr>
<?php 
endforeach;
}

/**
 * Form Password Bank
 *
 * Takes array of form_password data and returns
 * table rows for password input.
 *
 * @param array $passwords
 * 	- array of form_password data
 */
function form_password_bank($passwords)
{
	foreach ($passwords as $p):
	?>
<tr>
	<td><?php echo $p['label']; ?>:</td>
	<td><?php echo form_input($p); ?></td>
</tr>
<?php 
endforeach;
}