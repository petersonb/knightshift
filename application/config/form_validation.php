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
				)

		),
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
						'rules' => 'required|is_unique[employees.email]|is_unique[admins.email]|valid_email'
				)
		),
		
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
						'label' => 'Email',
						'rules' => 'required|is_unique[employees.email]|is_unique[admins.email]|valid_email'
				      )
						 ),
		
		'departments_create' => array(
					      array(
						    'field'=>'login_name',
						    'label'=>'Login name',
						    'rules'=>'required|is_unique[departments.login_name]'
						    )
					      )
		 );