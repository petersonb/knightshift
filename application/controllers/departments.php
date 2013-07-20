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
		// Security
		if ($this->admin_id)
		{
			$user = new Admin($this->admin_id);
		}
		elseif ($this->employee_id)
		{
			$user = new Employee($this->employee_id);
		}
		elseif ($this->department_id)
		{
			redirect('hours/log_time');
		}
		if ($this->department_context)
		{
			redirect('employees/view_all');
		}

		$depts = $user->department->get();

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

	public function add_admin()
	{
		// Security
		if (!$this->admin_id && !$this->department_context)
			redirect('main');

		// Load
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$this->load->helper('form');

		$this->form_validation->set_rules('admin_id', 'Admin Id', 'required');
		$this->form_validation->set_message('required','You must select an admin from the table.');

		if ($this->form_validation->run())
		{
			$eid = $this->input->post('admin_id');
			$did = $this->department_context;
			$a = new Admin($eid);
			$d = new Department($this->department_context);

			$a->save($d);
		}

		$data['title'] = "Add Administrator";
		$data['content'] = 'departments/add_admin';
		$data['javascript'] = array(
				"datatables/media/js/jquery",
				"datatables/media/js/jquery.dataTables",
				"departments/find_administrators"
		);
		$data['css'] = 'dataTables/jquery.dataTables';
		$this->load->view('master',$data);
	}

	public function add_employee ()
	{
		// Security
		if (!$this->admin_id && !$this->department_context)
			redirect('main');

		// Load
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

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

	public function remove_employee()
	{
		// Security
		if (!$this->admin_id && !$this->department_context)
			redirect('main');

		// Load
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$this->load->helper('form');

		$this->form_validation->set_rules('employee_id', 'Employee Id', 'required');
		$this->form_validation->set_message('required','You must select an employee from the table.');

		if ($this->form_validation->run())
		{
			$eid = $this->input->post('employee_id');
			$did = $this->department_context;
			$e = new Employee($eid);
			$d = new Department($did);

			$d->delete($e);
		}

		$data['title'] = "Remove Employee";
		$data['content'] = 'departments/remove_employee';
		$data['javascript'] = array(
				"datatables/media/js/jquery",
				"datatables/media/js/jquery.dataTables",
				"departments/related_employee"
		);
		$data['css'] = 'dataTables/jquery.dataTables';
		$this->load->view('master',$data);
	}

	public function create ()
	{
		// Security
		if (!$this->admin_id)
			redirect('main');

		// Load
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$this->load->helper('form');

		if ($this->form_validation->run('departments_create'))
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
		// Security
		if (!$this->employee_id)
			rediect('main');

		$data['title'] = 'Employee Panel';
		$data['context'] = 'departments/employee_panel';
		$this->load->view('master',$data);
	}


	public function set_context($id = NULL)
	{
		// Security
		// No id, no go
		if (!$id)
			redirect('main');

		// The user must belong to the department.
		$d = new Department($id);
		if ($this->employee_id)
		{
			$e = $d->employee->where('id',$this->employee_id)->get();
			if (!$e->exists())
				redirect('main');
		}
		elseif ($this->admin_id)
		{
			$a = $d->admin->where('id', $this->admin_id)->get();
			if (!$a->exists())
				redirect('main');
		}
		else
			redirect('main');

		$this->session->set_userdata('department_context',$id);
		if ($this->employee_id)
		{
			redirect('hours/log_time');
		}
		else
		{
			redirect('hours/view_all');
		}
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

	public function all_related_employees()
	{
		if (!$this->department_context)
			redirect('main');

		$d = new Department($this->department_context);
		$related_emps = $d->employee->get();

		$aaData = array();

		foreach ($related_emps as $e)
		{
			array_push($aaData,
			array(
			$e->id,
			$e->firstname,
			$e->lastname,
			$e->email
			)
			);
		}

		echo json_encode(array('aaData'=>$aaData));
	}

	/**
	 * All Employees
	 *
	 * Json for employee information
	 */
	public function all_unrelated_employees()
	{
		if (!$this->department_context)
			redirect('main');
		$d = new Department($this->department_context);
		$existing_emps = $d->employee->get();



		$emps = new Employee();
		if ($existing_emps->count() > 0)
		{
			$ids = array();
			foreach($existing_emps as $emp)
			{
				array_push($ids,$emp->id);
			}
			$emps->where_not_in('id',$ids)->get();
		}
		else
		{
			$emps->get();
		}

		$aaData = array();

		foreach ($emps as $e)
		{
			array_push($aaData,
			array(
			$e->id,
			$e->firstname,
			$e->lastname,
			$e->email
			)
			);
		}

		echo json_encode(array('aaData'=>$aaData));
	}

	public function all_unrelated_admins()
	{
		if (!$this->department_context)
			redirect('main');
		$d = new Department($this->department_context);
		$existing_admins = $d->admin->get();



		$admins = new Admin();
		if ($existing_admins->count() > 0)
		{
			$ids = array();
			foreach($existing_admins as $admin)
			{
				array_push($ids,$admin->id);
			}
			$admins->where_not_in('id',$ids)->get();
		}
		else
		{
			$admins->get();
		}

		$aaData = array();

		foreach ($admins as $a)
		{
			array_push($aaData,
			array(
			$a->id,
			$a->firstname,
			$a->lastname,
			$a->email
			)
			);
		}

		echo json_encode(array('aaData'=>$aaData));
	}
}

/* End of file departments.php */
/* Location: ./application/controllers/departments.php */