<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class status {

  public function __construct()
  {
    $CI =& get_instance();
    $this->admin_id = $CI->session->userdata('admin_id');
    $this->employee_id = $CI->session->userdata('employee_id');
    $this->department_id = $CI->session->userdata('department_id');
    $this->department_context = $CI->session->userdata('department_context');
  }
	
  public function get()
  {
    $data = array();
    if ($this->admin_id)
      {
	$a = new Admin($this->admin_id);
	$data['name'] = "{$a->firstname} {$a->lastname}";
      }
    elseif ($this->employee_id)
      {
	$e = new Employee($this->employee_id);
	$data['name'] = "{$e->firstname} {$e->lastname}";
      }
    elseif ($this->department_id)
      {
	$d = new Department($this->department_id);
	$data['name'] = $d->name;
      }
		
    if ($this->department_context)
      {
	$d = new Department($this->department_context);
	$data['context'] = $d->name;
      }
		
    return $data;
  }

}