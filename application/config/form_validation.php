<?php
$config = array (
		 'employee_registration' => array(
						  array(
							'field' => 'firstname',
							'label' => 'First name',
							'rules' => 'required'
							),
						  array(
							'field' => 'lastname',
							'label' => 'Last name',
							'rules' => 'required'
							),
						  array(
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'required|is_unique[employees.email]|is_unique[admins.email]|valid_email'
							),
						  array(
							'field' => 'student_id',
							'label' => 'Student Id',
							'rules' => 'required'
							),
						  array(
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'required|matches[confirm]'
							)
						  ),

		 'admin_registration' => array(
					       array(
						     'field' => 'title',
						     'label' => 'Title',
						     'rules' => ''
						     ),
					       array(
						     'field' => 'firstname',
						     'label' => 'First name',
						     'rules' => 'required'
						     ),
					       array(
						     'field' => 'lastname',
						     'label' => 'Last name',
						     'rules' => 'required'
						     ),
					       array(
						     'field' => 'email',
						     'label' => 'Email',
						     'rules' => 'required|is_unique[employees.email]|is_unique[admins.email]|valid_email'
						     ),
					       array(
						     'field' => 'password',
						     'label' => 'Password',
						     'rules' => 'required|matches[confirm]'
						     ),
					       array(
						     'field' => 'confirm',
						     'label' => 'Confirm',
						     'rules' => 'required'
						     ),
					       array(
						     'field' => 'valid',
						     'label' => 'Valid registration',
						     'rules' => 'required'
						     )

					       ),

		 // Additional Level of rules in controller to make sure email unique OR belongs to current user
		 'admin_edit_profile' => array(
					       array(
						     'title' => 'title',
						     'label' => 'Title',
						     'rules' => ''
						     ),
					       array(
						     'field' => 'firstname',
						     'label' => 'First name',
						     'rules' => 'required'
						     ),
					       array(
						     'field' => 'lastname',
						     'label' => 'Last name',
						     'rules' => 'required'
						     ),
					       array(
						     'field' => 'email',
						     'label' => 'Email',
						     'rules' => 'required|valid_email'
						     )
					       ),

		 // Additional Level of rules in controller to make sure email unique OR belongs to current user
		 'employee_edit_profile' => array(
						  array(
							'field' => 'firstname',
							'label' => 'First name',
							'rules' => 'required'
							),
						  array(
							'field' => 'lastname',
							'label' => 'Last name',
							'rules' => 'required'
							),
						  array(
							'field' => 'email',
							'label' => 'Email',							'rules' => 'required|valid_email'
							)
						  ),

		 'departments_create' => array(
					       array(
						     'field'=>'login_name',
						     'label'=>'Login name',
						     'rules'=>'required|is_unique[departments.login_name]'
						     )
					       ),
		 'departments_edit' => array(
					     array(
						   'field'=>'login_name',
						   'label'=>'Login name',
						   'rules'=>'required'
						   )
					     ),
		 'departments_notify_employees' => array(
							 array(
							       'field'=>'message',
							       'label'=>'Message',
							       'rules'=>'required',
							       ),
							 array(
							       'field'=>'priority',
							       'label'=>'Priority',
							       'rules'=>'required'
							       )
							 ),
		 'main_forgot_password' => array(
						 array(
						       'field'=>'email',
						       'label'=>'Email',
						       'rules'=>'required'
						       ),
						 ),
		 'main_password_reset' => array(
						array(
						      'field' => 'new',
						      'label' => 'New Password',
						      'rules' => 'required|matches[confirm]'
						      ),
						array(
						      'field' => 'confirm',
						      'label' => 'Confirm Password',
						      'rules' => 'required'
						      ),
						),

		 // TODO ADD MORE RULES
		 'shift_add' => array(
				      array(
					    'field' => 'day_of_week',
					    'label' => 'Day of Week',
					    'rules' => 'required',
					    ),
				      ),
		 );