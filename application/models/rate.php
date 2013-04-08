<?php

class Rate extends DataMapper {
  
  var $has_one = array(
		       'department' => array('join_table'=>'employees_departments'),
		       'employee' => array('join_table'=>'employees_departments')
			);

  function __construct($id = NULL)
  {
    parent::__construct($id);
  }

}

/* End of file hour.php */
/* Location: ./application/models/hour.php */
