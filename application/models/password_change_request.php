<?php

class Password_change_request extends DataMapper {
	
	var $code;
	
	var $has_one = array('admin','employee');
	
	function __construct ($id = null)
	{
		parent::__construct($id);
	}
}

/* End of file admin.php */
/* Location: ./application/models/password_change_request.php */
