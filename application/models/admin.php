<?php

class Admin extends DataMapper {

  var $validation = array (
			   array(
				 'field' => 'firstname',
				 'label' => 'Firstname',
				 'rules' => array('required','trim')
				 ),
			   array(
				 'field' => 'lastname',
				 'label' => 'Lastname',
				 'rules' => array('required','trim')
				 ),
			   array('field' => 'password',
				 'label' => 'Password',
				 'rules' => array('required','trim', 'min_length' => 6, 'encrypt')
				 )
			   );
    

  function __construct($id = NULL)
  {
    parent::__construct($id);
  }

  function _encrypt($field)
  {
    if (!empty($this->{$field}))
      {
	$this->salt = md5(uniqid(rand(), true));
      }

    $this->{$field} = sha1($this->salt . $this->{$field});
  }
}

/* End of file template.php */
/* Location: ./application/models/template.php */
