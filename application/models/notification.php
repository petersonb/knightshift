<?php

class Notification extends DataMapper {

	var $has_many = array(
			'department' => array('join_table'=>'notification_relations'),
			'employee' =>array('join_table'=>'notification_relations'),
			'admin'=>array('join_table'=>'notification_relations')
	);

	function __construct($id = NULL)
	{
		parent::__construct($id);
		$this->priority = 3;
	}

}

/* End of file hour.php */
/* Location: ./application/models/hour.php */
