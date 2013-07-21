<?php


class About extends CI_Controller {

	/**
	 * Constructor
	 *
	 * Initialize session variables
	 */
	public function __construct() {
		parent::__construct();

		$this->admin_id = $this->session->userdata('admin_id');
		$this->employee_id = $this->session->userdata('employee_id');
		$this->department_id = $this->session->userdata('department_id');
		$this->department_context = $this->session->userdata('department_context');
	}
	
	public function index()
	{
		$data['title'] = 'About';
		$data['content'] = 'about/main';
		$this->load->view('master',$data);
	}
	
	public function admin_walkthrough()
	{
		$data['title'] = 'Admin Walkthrough';
		$data['content'] = 'about/admin_walkthrough';
		$this->load->view('master',$data);
	}
}