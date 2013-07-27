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
	 * Forgot Password
	 *
	 * Page for sending out email for forgotten passwords
	 *
	 * Related to:
	 * 	email/forgot_password.php
	 *
	 * Loads success or failure page at end
	 */
	public function forgot_password()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		if ($this->form_validation->run('main_forgot_password'))
		{
			$email = $this->input->post('email');
			$a = new Admin();
			$a->where('email',$email)->get();

			$success = TRUE;
			if (!$a->exists())
			{
				$e = new Employee();
				$e->where('email',$email)->get();

				if (!$e->exists())
				{
					$success = FALSE;
					$data['content'] = 'main/forgot_password_fail';
				}
				else
				{
					$user = $e;
					$pwc = new Password_change_request();
					$code = md5(uniqid(mt_rand(), true));
					echo $code;
					$pwc->code = $code;
					$pwc->save($e);
					$data['content'] = 'main/forgot_password_success';
				}
			}
			else
			{
				$user = $a;
				$data['email'] = $email;
				$pwc = new Password_change_request();
				$code = md5(uniqid(mt_rand(), true));
				$pwc->code = $code;
				$pwc->save($a);
				$data['content'] = 'main/forgot_password_success';


			}
			// Email the user
			if ($success)
			{
				$message = "<p>Dear {$user->firstname},</p><br />";
				$message .= "<p>You have requested to have your password reset. Please clicke the link below.</p><br />";
				$message .= "<a href=\"".base_url('main/reset_password')."?pwrc=".$code."\">Click here.</a>";
				$this->email->from('brett@petersonb.com', 'Brett Peterson');
				$this->email->to($email);
				$this->email->subject('Password Reset');
				$this->email->message($message);
				$this->email->send();
			}
		}
		else
		{
			$data['content'] = 'main/forgot_password';
		}

		$data['title'] = 'Forgot Password';
		$this->load->view('master',$data);
	}

	public function password_reset()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$code = $this->input->get("pwrc");
		$pcr = new Password_change_request();
		$pcr->where('code',$code)->get();

		if ($pcr->exists())
		{
			$type=null;
			$a = $pcr->admin->get();
			if ($a->exists())
			{
				$type="admin";
				$user = $a;
			}
			else
			{
				$e = $pcr->employee->get();
				if ($e->exists())
				{
					$type="employee";
					$user = $e;
				}
				else
				{
					redirect('main');
				}
			}
			if ($this->form_validation->run('main_password_reset'))
			{
				$password = $this->input->post('new');
				$user->password = $password;
				$user->save();
				$pcr->delete();
				if ($type=="admin")
				{
					$this->session->set_userdata('admin_id',$user->id);
					redirect('admins');
				}
				elseif($type=="employee")
				{
					$this->session->set_userdata('employee_id',$user->id);
					redirect('employees');
				}
				else
				{
					redirect('main');
				}
			}
			$this->load->helper('form');
		}
		else
		{
			redirect('main');
		}
		$data['firstname'] = $user->firstname;
		$data['lastname'] = $user->lastname;
		$data['email'] = $user->email;
		$data['code'] = $code;

		$data['title'] = "Password Reset";
		$data['content'] = "main/password_reset";
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