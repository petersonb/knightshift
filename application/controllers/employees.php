<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->admin_id = $this->session->userdata('admin_id');
		$this->employee_id = $this->session->userdata('employee_id');
		$this->department_id = $this->session->userdata('department_id');
		$this->department_context = $this->session->userdata('department_context');
	}

	public function index()
	{
		// Security
		if (!$this->employee_id)
			redirect('main');
		if ($this->department_context)
			redirect('departments');
		else
		{
			$e = new Employee($this->employee_id);
			$depts = $e->department->get();

			foreach ($depts as $d)
	  {
	  	$ds[$d->id] = array(
	  			'id'=>$d->id,
	  			'name'=>$d->name
	  	);
	  }

	  $data['departments'] = $ds;
	  $data['title'] = 'Employee Main';
	  $data['content'] = 'employees/main';
	  $this->load->view('master',$data);
		}
	}

	public function view_all()
	{
		// Security
		if (!$this->department_context && !$this->department_id)
			redirect('main');

		$data['content'] = 'employees/view_all';
		$data['javascript'] = array(
				'datatables/media/js/jquery',
				'datatables/media/js/jquery.dataTables',
				'employees/admin_table'
		);
		$data['css'] = 'dataTables/jquery.dataTables';
		$this->load->view('master',$data);
	}

	public function change_password()
	{
		// Security
		if (!$this->employee_id)
			redirect('main');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$this->form_validation->set_rules('current','Current Password', 'required');
		$this->form_validation->set_rules('new','New Password','required');
		$this->form_validation->set_rules('confirm','Confirm Password','required|matches[new]');

		if ($this->form_validation->run())
		{
			$curr = new Employee($this->employee_id);
			$e = new Employee();
			$e->email = $curr->email;
			$e->password = $this->input->post('current');
			if ($e->login())
			{
				$curr->password = $this->input->post('new');
				$curr->save();
			}
		}
		$data['title'] = 'Change Password';
		$data['content'] = 'employees/change_password';
		$this->load->view('master',$data);
	}

	public function admin_manage($eid = Null)
	{
		// Security
		if (!$eid)
		{
			redirect('admins');
		}
		if(!$this->admin_id)
		{
			redirect('main');
		}
		if(!$this->department_context)
			redirect('main');

		$d = new Department($this->department_context);
		$e = $d->employee->where('id',$eid)->get();
		if (!$e->exists())
			redirect('main');

		$a = $d->admin->where('id',$this->admin_id)->get();
		if (!$a->exists())
			redirect('main');


		// Load
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$e = new Employee($eid);
		$r = $e->rate->where('department_id',$this->department_context)->get();

		$this->form_validation->set_rules('hourly','Hourly wage', 'required');

		if ($this->form_validation->run())
		{
			$r->hourly = $this->input->post('hourly');
			$r->save();
			redirect('employees/view_all');
		}

		$data['current_rate'] = $r->hourly;
		$data['employee'] = array(
				'id'=>$e->id
		);

		$data['title'] = 'Manage Employee';
		$data['content'] = 'employees/admin_manage';
		$this->load->view('master',$data);
	}

	public function edit_profile()
	{
		// Security
		if (!$this->employee_id)
			redirect('main');

		// Load
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');

		$this->load->helper('form');

		$e = new Employee($this->employee_id);

		if ($this->form_validation->run('employee_edit_profile'))
		{
			$e->firstname = $this->input->post('firstname');
			$e->lastname= $this->input->post('lastname');
			$e->email = $this->input->post('email');
			$e->save();
		}

		$data['employee'] = array(
				'firstname'=>$e->firstname,
				'lastname'=>$e->lastname,
				'email'=>$e->email
		);

		$data['title'] = 'Edit Profile';
		$data['content'] = 'employees/edit_profile';
		$this->load->view('master',$data);
	}

	/**
	 * Department Employees
	 *
	 * Supplies json for tables when dealing in department
	 * context or deptartment.
	 */
	public function department_employees()
	{
		if ($this->department_context)
		{
			$d = new Department($this->department_context);
		}
		elseif ($this->department_id)
		{
			$d = new Department($this->department_id);
		}
		else
		{
			redirect('main');
		}
		$emps = $d->employee->get();
		$aaData = array();

		if ($this->admin_id)
		{
			foreach ($emps as $e)
			{
				$r = $e->rate->where('department_id',$d->id)->get();
				array_push($aaData,
				array(
				$e->firstname,
				$e->lastname,
				$e->email,
				$r->hourly,
				"<a href='".base_url('employees/admin_manage/'.$e->id)."'><img src='".base_url('/css/icons/edit.png')."'/></a>"
						)
				);
			}
		}
		else
		{
			foreach ($emps as $e)
			{
				array_push($aaData,
				array(
				$e->firstname,
				$e->lastname,
				$e->email,
				)
				);
			}
		}

		echo json_encode(array('aaData'=>$aaData));
	}

	/**
	 * All Employees
	 *
	 * Json for employee information
	 */
	public function all_employees()
	{
		if (!$this->department_context)
			redirect('main');
		$d = new Department($this->department_context);
		$existing_emps = $d->employee->get();

		$ids = array();
		foreach($existing_emps as $emp)
		{
			array_push($ids,$emp->id);
		}

		$emps = new Employee();
		$emps->where_not_in('id',$ids)->get();

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
}

/* End of file employee.php */
/* Location: ./application/controllers/employee.php */
