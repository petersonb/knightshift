<?php

class Hour extends DataMapper {
  
  var $has_one = array(
		       'department' => array('join_table'=>'hour_relations'),
		       'employee' => array('join_table'=>'hour_relations')
			);

  function __construct($id = NULL)
  {
    parent::__construct($id);
  }

}

/* End of file hour.php */
/* Location: ./application/models/hour.php */
