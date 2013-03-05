<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

  public function index()
  {
    if ($this->session->userdata('department_context'))
      redirect('departments');
    else
      {
	$e = new Employee($this->session->userdata('employee_id'));
	$ds = $e->department->get();
	
	$data['departments'] = $ds;
	$data['title'] = 'Employee Main';
	$data['content'] = 'employees/main';
	$this->load->view('master',$data);
      }
  }
  
}

/* End of file employee.php */
/* Location: ./application/controllers/employee.php */