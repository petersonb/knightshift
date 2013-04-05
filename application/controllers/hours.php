<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Hours Controller
 *
 * @author Brett Peterson
 *
 * Handles everything to do with the hours
*/
class Hours extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->admin_id = $this->session->userdata('admin_id');
		$this->employee_id = $this->session->userdata('employee_id');
		$this->department_id = $this->session->userdata('department_id');
		$this->department_context = $this->session->userdata('department_context');
	}

	/**
	 * Hours
	 *
	 * Doesn't do anything yet :D
	 */
	public function index()
	{
		$data['title'] = 'Hours';
		$this->load->view('master',$data);
	}

	/**
	 * Edit Time
	 *
	 * Allows editing of a time that has already been logged.
	 *
	 * @param string $id
	 * 	- Hour ID
	 */
	public function edit_time($id = NULL)
	{
		// TODO NEEDS SECURITY
		if (!$id and !$this->input->post())
		{
			redirect('main');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		// TODO MORE RULES
		$this->form_validation->set_rules('date','Date','required');
		$this->form_validation->set_rules('time_in','Time In', 'required');
		$this->form_validation->set_rules('time_out','Time Out','required');

		if ($this->form_validation->run())
		{
			$h = new Hour($id);
			$h->date = $this->input->post('date');
			$h->time_in = $this->input->post('time_in');
			$h->time_out = $this->input->post('time_out');
			$h->save();
			redirect('hours/view_all');
		}
		$h = new Hour($id);
		$h->department->get();

		$data['hour'] = $h;
		$data['title'] = 'Edit Time';
		$data['content'] = 'hours/edit_time';
		$this->load->view('master',$data);
	}

	/**
	 * Log Time
	 *
	 * Allows employees or departments to log time to the database
	 * for their departments.
	 */
	public function log_time()
	{
		$this->load->helper(array('form','date'));
		$this->load->library('form_validation');

		// If logging hour as department
		if ($this->department_id)
		{
			$d = new Department($this->department_id);
			$emp = $d->employee->get();
			foreach($emp as $e)
			{
				$data['employees'][$e->id] = array(
						'id'=>$e->id,
						'firstname'=>$e->firstname,
						'lastname'=>$e->lastname
				);
			}
		}

		// If not a department, must have department context
		elseif($this->department_context)
		{
			$d = new Department($this->department_context);
		}

		$data['department']['name'] = $d->name;

		if (!$this->employee_id)
		{
			$data['no_eid'] = TRUE;
		}
		else
		{
			$data['no_eid'] = FALSE;
		}

		// TODO MORE RULES
		$this->form_validation->set_rules('date','Date','required');

		if ($this->form_validation->run())
		{
			$h = new Hour();

			if (!$this->employee_id)
			{
				$e = new Employee($this->input->post('employee_id'));
			}
			else
			{
				$e = new Employee($this->employee_id);
			}

			$h->date = date_std_mysql($this->input->post('date'));


			// TODO better time input handling

			$ihour = $this->input->post('hour_in');
			$imin  = $this->input->post('minute_in');
			$ipm    = $this->input->post('pm_in');

			$ohour = $this->input->post('hour_out');
			$omin  = $this->input->post('minute_out');
			$opm   = $this->input->post('pm_out');

			if ($ipm)
				$ihour = $ihour + 12;
			if (!$ipm && $ihour == 12)
				$ihour = "00";

			$itime = $ihour.':'.$imin.':00';

			if ($opm)
				$ohour = $ohour + 12;
			if (!$opm && $ohour == 12)
				$ohour = "00";

			$otime = $ohour.':'.$omin.':00';

			$h->time_in = $itime;
			$h->time_out = $otime;
			$h->save($e);
			$h->save($d);
		}
		
		$data['date'] = date('m/d/Y');

		$data['title'] = 'Log Time';
		$data['css'] = 'calendar_widget/jquery-ui';
		$data['javascript'] = array('jquery','jquery-ui','hours/date');
		$data['content'] = 'hours/log_time';
		$this->load->view('master',$data);
	}


	/**
	 * View All Hours
	 *
	 * Allows All hours to be viewed. Varies depending on type of access.
	 */
	public function view_all ()
	{

		if ($this->employee_id)
		{
			$js = 'emp_hours';
		}
		else
		{
			$js = 'dept_hours';
		}

		$data['javascript'] = array(
				'datatables/media/js/jquery',
				'datatables/media/js/jquery.dataTables',
				'hours/'.$js
		);

		$data['title'] = 'View All Hours';
		$data['content'] = 'hours/view_all';
		$data['css'] = 'dataTables/jquery.dataTables';
		$this->load->view('master',$data);
	}


	public function employee_hours()
	{
		$this->load->helper('date');
		$e = new Employee($this->employee_id);

		if ($this->department_context)
		{
			$hours = $e->hour->where("department_id",$this->department_context)->get();
		}
		else
		{
			$hour = $e->hour->get();
		}


		$aaData = array();

		if ($this->department_context)
		{
			foreach ($e->hour as $h)
			{
				array_push($aaData,
				array(
				date_mysql_std($h->date),
				$h->time_in,
				$h->time_out
				)
				);
			}
		}
		else
		{
			foreach ($e->hour as $h)
			{
				$d = $h->department->get();
				array_push($aaData,
				array(
				$d->name,
				date_mysql_std($h->date),
				$h->time_in,
				$h->time_out)
				);
			}
		}

		echo json_encode(array('aaData'=>$aaData));
	}

	public function department_hours()
	{
		$this->load->helper('date');

		$aaData = array();

		if ($this->department_context)
		{
			$depts = new Department($this->department_context);
		}
		elseif ($this->department_id)
		{
			$depts = new Department($this->department_id);
		}
		elseif ($this->admin_id)
		{
			$a = new Admin($this->admin_id);
			$depts = $a->department->get();
		}

		foreach ($depts as $d)
		{
			$hours = $d->hour->get();
			if ($this->department_context || $this->department_id)
			{
				foreach ($hours as $h)
				{
					$e = $h->employee->get();
					array_push($aaData,
					array(
					$e->firstname . ' ' . $e->lastname,
					date_mysql_std($h->date),
					$h->time_in,
					$h->time_out
					)
					);
				}
			}
			elseif ($this->admin_id)
			{
				foreach ($hours as $h)
				{
					$e = $h->employee->get();
					array_push($aaData,
					array(
					$d->name,
					$e->firstname . ' ' . $e->lastname,
					date_mysql_std($h->date),
					$h->time_in,
					$h->time_out
					)
					);
				}
			}
			else
			{
				foreach ($hours as $h)
				{
					array_push($aaData,
					array(
					$d->name,
					date_mysql_std($h->date),
					$h->time_in,
					$h->time_out
					)
					);
				}
			}
		}

		$data=array('aaData'=>$aaData);

		echo json_encode($data);
	}

}

/* End of file hours.php */
/* Location: ./application/controllers/hours.php */