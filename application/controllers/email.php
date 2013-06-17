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

		$this->employee_id = $this->session->userdata('employee_id');
		$this->admin_id = $this->session->userdata('admin_id');
		$this->department_id = $this->session->userdata('department_id');
	}

	public function index ()
	{
		$this->load->library('email');

		$this->email->from('brett@petersonb.com', 'Brett Peterson');
		$this->email->to('bepeterson14@gmail.com');
		$this->email->subject('Test');
		$this->email->message('<h1>Super test!</h1>');
		$this->email->send();
		echo $this->email->print_debugger();
	}
}

/* End of file email.php */
/* Location: ./application/controllers/email.php */