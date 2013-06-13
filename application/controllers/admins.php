<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admins Controller
 *
 * @author Brett Peterson
 *
 * Controls everything relating to admin functionality
 *
*/
class Admins extends CI_Controller {

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

	/**
	 * Admins
	 *
	 * The admin home page.
	 *
	 * The admin home page has a list of departments used to set the department context.
	 */
	public function index()
	{
		// Security
		if (!$this->admin_id)
			redirect('main');
		
		$a = new Admin($this->admin_id);
		$depts = $a->department->get();

		// Load departments used for listing owned departments
		// TODO Create a private function for this???
		foreach ($depts as $d)
		{
			$data['departments'][$d->id] = array(
					'id'=>$d->id,
					'name'=>$d->name
			);
		}

		$data['title'] = 'Administrator Main';
		$data['content'] = 'admins/main.php';
		$this->load->view('master',$data);
	}

	/**
	 * Change Password
	 *
	 * Allows the admin to change their password.
	 *
	 * Redirect to admins on success.
	 */
	public function change_password()
	{
		// Security
		if (!$this->admin_id)
			redirect('main');
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		// TODO MAKE SOME GORAM RULES
		$this->form_validation->set_rules('current','Current Password', 'required');
		$this->form_validation->set_rules('new','New Password','required');
		$this->form_validation->set_rules('confirm','Confirm Password','required');

		if ($this->form_validation->run())
		{
			// Check password
			// TODO when recovering password, do not require this step
			$a = new Admin();
			$a->email = $curr->email;
			$a->password = $this->input->post('current');
			if ($a->login())
			{
				$curr = new Admin($this->admin_id);
				$curr->password = $this->input->post('new');
				$curr->save();
			}
			redirect('admins');
		}
		$data['title'] = 'Change Password';
		$data['content'] = 'admins/change_password';
		$this->load->view('master',$data);
	}

	/**
	 * Admin Edit Profile
	 *
	 * Allows admin to edit their profile information
	 *
	 * Redirect to admins on save
	 */
	public function edit_profile()
	{
		// Security
		if (!$this->admin_id)
			redirect('main');
		
		// Load
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		$a = new Admin($this->admin_id);

		if ($this->form_validation->run())
		{
			$a->title = $this->input->post('title');
			$a->firstname = $this->input->post('firstname');
			$a->lastname= $this->input->post('lastname');
			$a->email = $this->input->post('email');
			$a->save();
			redirect('admins');
		}

		$data['admin'] = array(
				'id'=>$a->id,
				'title'=>$a->title,
				'firstname'=>$a->firstname,
				'lastname'=>$a->lastname,
				'email'=>$a->email
		);

		$data['title'] = 'Edit Profile';
		$data['content'] = 'admins/edit_profile';
		$this->load->view('master',$data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */