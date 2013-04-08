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
		if ($this->session->userdata('department_context'))
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
		$this->load->helper('form');
		$this->load->library('form_validation');

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

	public function admin_manage($eid = Null,$did = Null)
	{
		if (!$eid)
		{
			redirect('admins');
		}
		elseif(!$this->admin_id)
		{
			redirect('main');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$e = new Employee($eid);
		if ($did)
		{
			$r = $e->rate->where('department_id',$this->$did)->get();
		}
		else
		{
			$r = $e->rate->where('department_id',$this->department_context)->get();
		}

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
		$this->load->library('form_validation');
		$this->load->helper('form');

		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		$e = new Employee($this->session->userdata('employee_id'));

		if ($this->form_validation->run())
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
	 * Ajax Source for employee information
	 */
	public function all_employees()
	{

		$emps = new Employee();
		$emps->get();

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