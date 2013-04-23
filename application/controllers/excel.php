<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->admin_id = $this->session->userdata('admin_id');
		$this->employee_id = $this->session->userdata('employee_id');
		$this->department_id = $this->session->userdata('department_id');
		$this->department_context = $this->session->userdata('department_context');
	}

	public function index ()
	{
		$this->initial_auth();

		if ($this->admin_id)
		{
			$user = new Admin($this->admin_id);
		}
		elseif($this->emplopyee_id)
		{
			$user = new Employee($this->employee_id);
		}

		$depts = $user->department->get();
		
		foreach ($depts as $d)
		{
			$data['departments'][$d->id] = array(
					'id'=>$d->id,
					'name'=>$d->name
			);
		}

		$data['content'] = 'excel/main';
		$data['title'] = 'Excel Handling';
		$this->load->view('master',$data);
	}
	
	public function admin ()
	{
		$this->load->helper('form');
		$data['content'] = 'excel/admin';
		$this->load->view('master',$data);
	}

	private function initial_auth()
	{
		if ($this->admin_id && $this->department_context)
		{
			redirect('excel/admin');
		}
		elseif ($this->employee_id && $this->departemtn_context)
		{
			redirect('excel/employee');
		}
		elseif (!$this->admin_id && !$this->employee_id)
		{
			redirect('main');
		}
	}

}

/* End of file excel.php */
/* Location: ./application/controllers/excel.php */