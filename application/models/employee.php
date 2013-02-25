<?php

class Employee extends DataMapper {

  var $validation = array (
			   array(
				 'field' => 'password',
				 'label' => 'Password',
				 'rules' => array('encrypt'),
				 'type'  => 'password'
				 )
			   );
    

  function __construct($id = NULL)
  {
    parent::__construct($id);
  }

  function login() 
  {
    $email = $this->email;

    $e = new Employee();

    $e->where('email',$email)->get();
    $pass = $e->password;
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

/* End of file employee.php */
/* Location: ./application/models/employee.php */
