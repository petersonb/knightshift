<?php

class Shift_hour extends DataMapper {
  
  var $has_one = array(
		       'department' => array('join_table'=>'shift_hour_relations'),
		       'employee' => array('join_table'=>'shift_hour_relations')
			);

  function __construct($id = NULL)
  {
    parent::__construct($id);
  }

}

/* End of file shift.php */
/* Location: ./application/models/shift.php */
