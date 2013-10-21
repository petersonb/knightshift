<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_system {

  public function __construct()
  {
    $CI =& get_instance();
    $this->admin_id = $CI->session->userdata('admin_id');
    $this->employee_id = $CI->session->userdata('employee_id');
    $this->department_id = $CI->session->userdata('department_id');
    $this->department_context = $CI->session->userdata('department_context');
  }

  public function get_menu_data()
  {
    if ($this->admin_id)
      {
	return $this->get_admin_menu_data();
      }
    if ($this->employee_id)
      {
	return $this->get_employee_menu_data();
      }
    if ($this->department_id)
      {
	return $this->get_department_menu_data();
      }
    return $this->get_main_menu_data();
  }

  private function get_main_menu_data()
  {
    $data = array(
		  array(
			'base' => 'main',
			'name' => 'Home',
			),
		  array(
			'base' => 'register',
			'name' => 'Register'
			),
		  array(
			'base' => 'about',
			'name' => 'About',
			)
		  );

    return $data;
  }

  private function get_admin_menu_data()
  {
    $data = array(
		  array('base'=>'admins',
			'name'=>'Home',
			),

		  'departments' => array('base'=>'departments',
					 'name'=>'Departments',
					 'dropdown' => array(
							     array('base'=>'departments/create',
								   'name'=>'Create',
								   ),

							     )
					 ),
		  'hours' => array('base'=>'hours',
				   'name'=>'Hours',
				   'dropdown' => array(
						       array('base'=>'hours/view_all',
							     'name'=>'View All',
							     ),
						       )
				   ),
		  'admins' => array('base'=>'admins',
				    'name'=>'Profile',
				    'dropdown' => array(

							array('base'=>'admins/edit_profile',
							      'name'=>'Edit Profile',
							      ),
							array('base'=>'admins/change_password',
							      'name'=>'Change Password',
							      ),
							array('base'=>'main/logout',
							      'name'=>'Logout',
							      )
							)
				    ),

		  );

    if ($this->department_context)
      {

	$employees = array('base'=>'employees/view_all',
			   'name'=>'Employees',
			   'dropdown' => array(
					       array('base'=>'employees/view_all',
						     'name'=>'View All',
						     'context'=>'yes'
						     ),
					       ),
			   );

	$excel = array(
		       'base'=>'excel',
		       'name'=>'Excel'
		       );

	$departments = array(
			     array('base'=>'departments/add_employee',
				   'name'=>'Add Employee',
				   ),
			     array('base'=>'departments/add_admin',
				   'name'=>'Add Admin',
				   ),
			     array('base'=>'departments/remove_employee',
				   'name'=>'Remove Employee',
				   ),
			     array('base'=>'departments/edit',
				   'name'=>'Edit Department',
				   ),
			     array('base'=>'departments/notify_employees',
				   'name'=>'Notify Employees'
				   )
			     );

	$hours = array (
			array('base'=>'hours/log_time',
			      'name'=>'Log Time',
			      ),
			);

	$unset = array('base'=>'departments/unset_context',
		       'name'=>'Unset Context',
		       'dropdown' => array()
		       );

	$shifts = array('base'=>'shifts/view_all',
			'name'=>'Shifts',
			'dropdown' => array(
					    array('base'=>'shifts/add',
						  'name'=>'Add Shift',
						  ),
					    array('base'=>'shifts/view_all',
						  'name'=>'View All',
						  ),
					    ),
			);

	array_splice($data,1,0,array($employees));
	array_splice($data['departments']['dropdown'],-1,0,$departments);
	array_splice($data['hours']['dropdown'],0,0,$hours);
	array_splice($data,-1,0,array($shifts));
	array_splice($data,-1,0,array($excel));
	array_splice($data,count($data),0,array($unset));
      }

    return $data;
  }

  private function get_employee_menu_data()
  {
    $data = array(
		  'hours' => array('base'=>'hours',
				   'name'=>'Hours',
				   'dropdown' => array(

						       array('base'=>'hours/view_all',
							     'name'=>'View All',
							     'context'=>'no'
							     ),
						       )
				   ),
		  'departments' => array('base'=>'departments',
					 'name'=>'Departments',
					 'dropdown'=>array(),
					 ),
		  'employees' => array('base'=>'employees',
				       'name'=>'Profile',
				       'dropdown' => array(
							   array('base'=>'employees/edit_profile',
								 'name'=>'Edit Profile',
								 'context'=>'no',
								 ),
							   array('base'=>'employees/change_password',
								 'name'=>'Change Password',
								 'context'=>'no'
								 ),
							   array('base'=>'main/logout',
								 'name'=>'Logout',
								 'context'=>'no'
								 ),
							   ),
				       ),

		  );

    if ($this->department_context)
      {
	$hours = array('base'=>'hours/log_time',
		       'name'=>'Log Time',
		       'context'=>'yes'
		       );

	$unset = array('base'=>'departments/unset_context',
		       'name'=>'Unset Context',
		       'dropdown'=>array(),
		       );

	array_splice($data['hours']['dropdown'],0,0,array($hours));
	array_splice($data,count($data),0,array($unset));
      }

    return $data;
  }

  private function get_department_menu_data ()
  {
    $data = array(
		  array('base'=>'departments',
			'name'=>'Home'),
		  array('base'=>'hours/log_time',
			'name'=>'Log Time'),
		  array('base'=>'hours/view_all',
			'name'=>'View Hours'),
		  array('base'=>'employees/view_all',
			'name'=>'View Employees'),
		  array('base'=>'main/logout',
			'name'=>'Logout'
			)
		  );
    return $data;
  }

}