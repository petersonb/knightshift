<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Register
 *
 * @author Brett Peterson
 *
 * Handles registration of users
 */
class Register extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->menu_data = $this->menu_system->get_menu_data();
  }
	
  public function index()
  {
    $data['content'] = 'register/main';
    $this->load->view('master', $data);
  }


  /**
   * Admin registration
   *
   * Regist new administrator
   *
   * Redirect to admins pages
   */
  public function admin()
  {
    $this->load->helper('form');
    $this->load->library(array('form_validation'));
    $this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');
		
    if ($this->form_validation->run('admin_registration'))
      {
	$admin = new Admin();
	$admin->title     = $this->input->post('title');
	$admin->firstname = $this->input->post('firstname');
	$admin->lastname  = $this->input->post('lastname');
	$admin->email     = $this->input->post('email');
	$admin->password  = $this->input->post('password');
	$admin->save();
			
	$a = new Admin();
	$a->email = $admin->email;
	$a->password = $this->input->post('password');
	if ($a->login())
	  {
	    $this->session->set_userdata('admin_id',$a->id);
	    redirect('admins');
	  }
      }


    $data['content'] = 'register/admin';

    $this->load->view('master', $data);

  }

  /**
   * Register Employee
   *
   * Register a new Employee
   */
  public function employee()
  {
    $this->load->helper('form');
    $this->load->library(array('form_validation'));
    $this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

    if ($this->form_validation->run('employee_registration'))
      {
	$email = $this->input->post('email');
			
	$emp = new Employee();
	$emp->firstname = $this->input->post('firstname');
	$emp->lastname = $this->input->post('lastname');
	$emp->email = $this->input->post('email');
	$emp->student_id = $this->input->post('student_id');
	$emp->password = $this->input->post('password');
	$emp->save();

	redirect('employees');
      }

    $data['content'] = 'register/employee';

    $this->load->view('master', $data);
  }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */