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

		$data['admin'] = array(
				'title' => $a->title,
				'firstname' => $a->firstname,
				'lastname' => $a->lastname,
				'email' => $a->email
		);

		$data['title'] = 'Administrator Main';
		$data['content'] = 'admins/view_profile';
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
			$curr = new Admin($this->admin_id);
			$a = new Admin();
			$a->email = $curr->email;
			$a->password = $this->input->post('current');
			if ($a->login())
			{
				$curr = new Admin($this->admin_id);
				$curr->password = $this->input->post('new');
				$curr->save();
			}
			else 
			{
				echo "BLOW";
			}
// 			redirect('admins');
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

		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$a = new Admin($this->admin_id);

		if ($this->form_validation->run('admin_edit_profile'))
		{
			$email = $this->input->post('email');
			if ($a->email != $email) {
				$this->form_validation->set_rules('email','Email','is_unique[employees.email]|is_unique[admins.email]');
					
				if ($this->form_validation->run())
				{
					$a->title = $this->input->post('title');
					$a->firstname = $this->input->post('firstname');
					$a->lastname= $this->input->post('lastname');
					$a->email = $this->input->post('email');
					$a->save();
					redirect('admins');
				}
			}
			else
			{
				$a->title = $this->input->post('title');
				$a->firstname = $this->input->post('firstname');
				$a->lastname= $this->input->post('lastname');
				$a->save();
				redirect('admins');
			}
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

	public function view_all()
	{
		// Security
		if (!$this->admin_id && !$this->department_id && !$this->employee_id) {
			redirect('main');
		}
		$data['title'] = 'View All Admins';
		$data['content'] = 'admins/view_all';
		$data['css'] = 'dataTables/jquery.dataTables';
		$data['javascript'] = array(
				'datatables/media/js/jquery',
				'datatables/media/js/jquery.dataTables',
				'admins/view_all'
		);
		$this->load->view('master',$data);
	}

	public function get_all_admins() {
		$admins = new Admin();
		$admins->get();


		$aaData = array();

		foreach ($admins as $a)
		{
			array_push($aaData,
			array(
			$a->firstname,
			$a->lastname,
			$a->email
			)
			);
		}

		echo json_encode(array('aaData'=>$aaData));
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */