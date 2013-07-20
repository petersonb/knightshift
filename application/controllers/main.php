<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Main Controller
 *
 * Handles all activity for non logged in users
 *
 * @author brett
 *
*/
class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->employee_id = $this->session->userdata('employee_id');
		$this->admin_id = $this->session->userdata('admin_id');
		$this->department_id = $this->session->userdata('department_id');
	}

	/**
	 * Main
	 *
	 * Page for loggin in.
	 *
	 * Redirects if already has session data
	 */
	public function index()
	{
		if ($this->employee_id)
		{
			redirect('employees');
		}
		elseif ($this->admin_id)
		{
			redirect('admins');
		}
		elseif ($this->department_id)
		{
			redirect('hours/log_time');
		}

		$this->load->helper('form');

		$data['title'] = 'KnightShift';
		$data['content'] = 'main/home';
		$this->load->view('master',$data);
	}


	/**
	 * Login
	 *
	 * This function handles login requests from the main/index page.
	 *
	 * Checks Employee
	 *
	 * Checks Admin
	 *
	 * Checks Department
	 *
	 * if any valid login defined by model, sets userdata and redirects successfully logging in the user
	 */
	public function login()
	{
		// If user is already logged in, redirect to main, where they will be appropriately redirected.
		if ($this->admin_id || $this->employee_id || $this->department_id)
		{
			redirect('main');
		}

		// Check Employee Login
		$e = new Employee();

		$e->email = $this->input->post('email');
		$e->password = $this->input->post('password');

		if ($e->login())
		{
			$this->session->set_userdata('employee_id', $e->id);
			redirect('employees');
		}
		
		// Check Admin Login
		$a = new Admin();

		$a->email = $this->input->post('email');
		$a->password = $this->input->post('password');

		if ($a->login())
		{
			$this->session->set_userdata('admin_id',$a->id);
			redirect('admins');
		}
		
		// Check Department Login
		$d = new Department();

		$d->login_name = $this->input->post('email');
		$d->password = $this->input->post('password');
		if ($d->login())
		{
			$this->session->set_userdata('department_id', $d->id);
			redirect('departments');
		}
		// Redirect to main if no successful logins
		redirect('main');
	}

	/**
	 * Logout
	 * 
	 * Unset all user data and redirect to main.
	 */
	public function logout()
	{
		$this->session->unset_userdata('employee_id');
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('department_id');

		$this->session->unset_userdata('department_context');
		redirect('main');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */