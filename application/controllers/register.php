<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

  public function index()
  {
    $data['content'] = 'register/main';
    $this->load->view('master', $data);
  }

  public function admin() 
  {
    $this->load->helper('form');
    $this->load->library(array('form_validation'));

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('firstname', 'First Name', 'required');
    $this->form_validation->set_rules('lastname', 'Last Name' , 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password','Password','required');
    $this->form_validation->set_rules('confirm','Confirm','required|matches[password]');

    if ($this->form_validation->run())
      {
	$admin = new Admin();
	$admin->title     = $this->input->post('title');
	$admin->firstname = $this->input->post('firstname');
	$admin->lastname  = $this->input->post('lastname');
	$admin->email     = $this->input->post('email');
	$admin->password  = $this->input->post('password');
	$admin->save();
	
	redirect('main');
      }


    $data['content'] = 'register/admin.php';
    
    $this->load->view('master', $data);
    
  }

  public function employee() 
  {
    $this->load->helper('form');
    $this->load->library(array('form_validation'));

    $this->form_validation->set_rules('firstname', 'First Name', 'required');

    if ($this->form_validation->run())
      {
	$emp = new Employee();
	$emp->firstname = $this->input->post('firstname');
	$emp->lastname = $this->input->post('lastname');
	$emp->email = $this->input->post('email');
	$emp->password = $this->input->post('password');
	$emp->save();

	redirect('main');
      }

    $data['content'] = 'register/employee.php';
    
    $this->load->view('master', $data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */