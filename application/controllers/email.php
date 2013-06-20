<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Email Controller
 *
 * Handles all email activities.
 *
 * @author brett
 *
*/
class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('email');

		$this->employee_id = $this->session->userdata('employee_id');
		$this->admin_id = $this->session->userdata('admin_id');
		$this->department_id = $this->session->userdata('department_id');
	}

	public function index ()
	{
		$this->email->from('brett@petersonb.com', 'Brett Peterson');
		$this->email->to('bepeterson14@gmail.com');
		$this->email->subject('Test');
		$this->email->message('<h1>Super test!</h1>');
		$this->email->send();
		echo $this->email->print_debugger();
	}

	private function admin_department_to_employees($department_id, $employee_ids, $subject,$message)
	{
		$admin = new Admin($this->admin_id);
		
		$this->email->from($admin->email, "{$admin->firstname} {$admin->lastname}");
		$this->email->subject($subject);
		$this->email->message($message);
	}
}

/* End of file email.php */
/* Location: ./application/controllers/email.php */