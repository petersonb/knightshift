<?php

class Admin extends DataMapper {

	var $validation = array (
			array(
				 'field' => 'password',
				 'label' => 'Password',
				 'rules' => array('encrypt'),
				 'type'  => 'password'
			)
	);

	var $has_one = array('password_change_request');
	var $has_many = array(
			'department'=>array('join_table'=>'admins_departments'),
			'notification'=>array('join_table'=>'notification_relations')	
	);

	function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	function login()
	{
		$email = $this->email;

		$a = new Admin();

		$a->where('email',$email)->get();
		$pass = $a->password;
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

/* End of file admin.php */
/* Location: ./application/models/admin.php */
