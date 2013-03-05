<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    if ($this->session->userdata('employee_id'))
      redirect('employees');
    elseif ($this->session->userdata('admin_id'))
      redirect('admins');
    elseif ($this->session->userdata('department_id'))
      redirect('departments');
    else 
      {
	$this->load->helper(array('form'));
	
	$data['content'] = array('main/home.php');
	
	$this->load->view('master',$data);
      }
  }

  public function login()
  {
    $this->load->helper(array('url'));
    
    $e = new Employee();
    
    $e->email = $this->input->post('email');
    $e->password = $this->input->post('password');
    
    if ($e->login())
      {
	$this->session->set_userdata('employee_id', $e->id);
	redirect('employees');
      }
    else 
      {
	$a = new Admin();
	
	$a->email = $this->input->post('email');
	$a->password = $this->input->post('password');
	if ($a->login())
	  {
	    $this->session->set_userdata('admin_id',$a->id);
	    redirect('admins');
	  }
	else 
	  {
	    $d = new Department();
	    
	    $d->name = $this->input->post('email');
	    $d->password = $this->input->post('password');
	    if ($d->login())
	      {
		$this->session->set_userdata('department_id', $d->id);
		redirect('departments');
	      }
	  }
	
	
    }
    redirect('main');
  }

  public function logout()
  {
    $this->session->unset_userdata('employee_id');
    $this->session->unset_userdata('admin_id');
    $this->session->unset_userdata('department_id');

    $this->session->unset_userdata('deptartment_context');
    redirect('main');
  }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */