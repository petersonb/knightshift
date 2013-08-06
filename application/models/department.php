<?php

class Department extends DataMapper {
	
	var $validation = array (
			array(
				 'field' => 'password',
				 'label' => 'Password',
				 'rules' => array('encrypt'),
				 'type'  => 'password'
			)
	);

	var $has_many = array(
			'admin' => array('join_table' => 'admins_departments'),
			'employee' => array('join_table' => 'employees_departments'),
			'rate'=>array('join_table'=>'employees_departments'),
			'hour' => array('join_table' => 'hour_relations'),
			'notification'=>array('join_table'=>'hour_relations')
	);

	function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	function login()
	{
		$name = $this->login_name;

		$d = new Department();

		$d->where('login_name',$name)->get();
		$pass = $d->password;
		$passFrag = explode(':',$pass);
		$this->salt = $passFrag[0];
		$this->validate()->get();

		if ($this->exists())
			return TRUE;
		else
			return FALSE;
	}

	function _encrypt($field)
	{
		if (!empty($this->{$field}))
		{
			if (empty($this->salt))
	  {
	  	$this->salt = uniqid();
	  }
	  $this->{$field} = $this->salt . ':' . hash('sha256', $this->salt . $this->{$field});
		}
	}
}

/* End of file department.php */
/* Location: ./application/models/department.php */
