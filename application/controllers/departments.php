<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->admin_id = $this->session->userdata('admin_id');
		$this->employee_id = $this->session->userdata('employee_id');
		$this->department_id = $this->session->userdata('department_id');
		$this->department_context = $this->session->userdata('department_context');
	}

	public function index ()
	{
		redirect('hours/log_time');
		if ($this->session->userdata('department_context'))
		{
			redirect('departments/employee_panel');
		}
		$d = new Department($this->session->userdata('department_id'));
		$data['title'] = $d->name;
		$this->load->view('master',$data);
	}

	public function add_employee ()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->form_validation->set_rules('employee_id', 'Employee Id', 'required');
		$this->form_validation->set_message('required','You must select an employee from the table.');

		if ($this->form_validation->run())
		{
			$eid = $this->input->post('employee_id');
			$did = $this->department_context;
			$e = new Employee($eid);
			$d = new Department($did);
			$r = new Rate();
			
			$r->hourly = $this->input->post('hourly');
			
			$r->save($e);
			$r->save($d);
// 			$d->save($e);
		}

		$data['base_rate']=7.25;
		
		$data['title'] = "Add Employee";
		$data['content'] = 'departments/add_employee';
		$data['javascript'] = array(
				"datatables/media/js/jquery",
				"datatables/media/js/jquery.dataTables",
				"departments/find_employee"
		);
		$data['css'] = 'dataTables/jquery.dataTables';
		$this->load->view('master',$data);
	}

	public function create ()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		if (! $this->is_admin())
			redirect('main');

		$this->form_validation->set_rules('name', 'Department Name', 'required');

		if ($this->form_validation->run())
		{
			$a = new Admin($this->session->userdata('admin_id'));

			$dept = new Department();
			$dept->name = $this->input->post('name');
			$dept->login_name = $this->input->post('login_name');
			$dept->dept_id = $this->input->post('id');
			$dept->password = $this->input->post('password');
			$dept->save($a);
		}


		$data['title'] = 'Create Department';
		$data['content'] = 'departments/create';
		$this->load->view('master',$data);
	}

	public function employee_panel()
	{
		$data['title'] = 'Employee Panel';
		$data['context'] = 'departments/employee_panel';
		$this->load->view('master',$data);
	}

	public function set_context($id = NULL)
	{
		if ($id)
		{
			$this->session->set_userdata('department_context',$id);
			redirect('employees');
		}

		else
			redirect('main');
	}

	public function unset_context()
	{
		$this->session->unset_userdata('department_context');
		if ($this->session->userdata('employee_id'))
			redirect('employees');
		if ($this->session->userdata('admin_id'))
			redirect('admins');
		else
			redirect('main');
	}

	private function is_admin($id = NULL)
	{
		if ($this->session->userdata('admin_id'))
		{
			if ($id && $id !== $this->session->userdata('admin_id'))
	  {
	  	return FALSE;
	  }
	  else
	  {
	  	return TRUE;
	  }
		}

		return FALSE;
	}
}

/* End of file departments.php */
/* Location: ./application/controllers/departments.php */