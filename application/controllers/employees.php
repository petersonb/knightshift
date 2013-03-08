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

  public function change_password()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');

    $this->form_validation->set_rules('current','Current Password', 'required');
    $this->form_validation->set_rules('new','New Password','required');
    $this->form_validation->set_rules('confirm','Confirm Password','required');

    if ($this->form_validation->run())
      {
	$curr = new Employee($this->session->userdata('employee_id'));
	$e = new Employee();
	$e->email = $curr->email;
	$e->password = $this->input->post('current');
	if ($e->login())
	  {
	    $curr->password = $this->input->post('new');
	    $curr->save();
	  }
      }
    $data['title'] = 'Change Password';
    $data['content'] = 'employees/change_password';
    $this->load->view('master',$data);    
  }

  public function edit_profile()
  {
    $this->load->library('form_validation');
    $this->load->helper('form');
    
    $this->form_validation->set_rules('firstname', 'First Name', 'required');
    $this->form_validation->set_rules('lastname', 'Last Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');

    $e = new Employee($this->session->userdata('employee_id'));

    if ($this->form_validation->run())
      {
	$e->firstname = $this->input->post('firstname');
	$e->lastname= $this->input->post('lastname');
	$e->email = $this->input->post('email');
	$e->save();
      }
    
    $data['employee'] = $e;
    
    $data['title'] = 'Edit Profile';
    $data['content'] = 'employees/edit_profile';
    $this->load->view('master',$data);
  }

  
}

/* End of file employee.php */
/* Location: ./application/controllers/employee.php */