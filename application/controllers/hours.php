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
    if (!$this->admin_id && !$this->employee_id && !$this->department_id)
      {
	redirect('main');
      }
    $this->menu_data = $this->menu_system->get_menu_data();
  }

  /**
   * Hours
   *
   * Doesn't do anything yet :D
   */
  public function index()
  {
    if ($this->admin_id || $this->employee_id) 
      {
	redirect('hours/view_all');	
      }
    redirect('main');
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
    if (!$id)
      {
	redirect('main');
      }

    $this->load->helper(array('form','date'));
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');
		

    // TODO MORE RULES
    $this->form_validation->set_rules('date','Date','required');

    if ($this->form_validation->run())
      {
	$ihour = $this->input->post('hour_in');
	$imin  = $this->input->post('minute_in');
	$ipm    = $this->input->post('pm_in');

	$ohour = $this->input->post('hour_out');
	$omin  = $this->input->post('minute_out');
	$opm   = $this->input->post('pm_out');

	$itime = date_twelve_to_24("$ihour:$imin $ipm");
	$otime = date_twelve_to_24("$ohour:$omin $opm");

	$h = new Hour($id);
	$h->date = date_std_mysql($this->input->post('date'));
	$h->time_in = $itime;
	$h->time_out = $otime;
	$succ = $h->save();
	redirect('hours/view_all');
      }
    else
      {
	$data['edit'] = true;

	$h = new Hour($id);
	$h->department->get();

	$data['date'] = date_mysql_std($h->date);

	$in_split = preg_split('/[\s,:]+/',date_24_to_twelve($h->time_in));
	$data['time_in'] = array(
				 'hour'=>$in_split[0],
				 'minute'=>$in_split[1],
				 'period'=>$in_split[2]
				 );

	$out_split = preg_split('/[\s,:]+/',date_24_to_twelve($h->time_out));
	$data['time_out'] = array(
				  'hour'=>$out_split[0],
				  'minute'=>$out_split[1],
				  'period'=>$out_split[2]
				  );

	$data['hour'] = array(
			      'id'=>$h->id,
			      );
	$data['title'] = 'Edit Time';
	$data['content'] = 'hours/edit_time';
	$data['css'] = 'calendar_widget/jquery-ui';
	$data['javascript'] = array('jquery','jquery-ui','hours/date');
	$this->load->view('master',$data);
      }
  }

  public function delete_time($id = null)
  {
    if (!$id)
      {
	redirect('hours/view_all');
      }

    $this->load->helper(array('form','date'));

    if ($this->input->post())
      {
	if ($this->input->post('confirm'))
	  {
	    $h = new Hour($id);
	    $h->delete();
	    redirect('hours/view_all');
	  }
      }

    $h = new Hour($id);
    $data['hour']= array(
			 'id'=>$h->id,
			 'date'=>date_mysql_std($h->date),
			 'time_in'=>date_24_to_twelve($h->time_in),
			 'time_out'=>date_24_to_twelve($h->time_out),
			 'department'=>$h->department->get()->name
			 );
    $data['content'] = 'hours/delete_time';
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
    $this->form_validation->set_error_delimiters('<div class="error"><p>','</p></div>');
		
    if (!$this->department_id && !$this->department_context) {
      redirect('main');
    }
		

    // If logging hour as department
    if ($this->department_id || ($this->admin_id && $this->department_context))
      {
	if ($this->department_id)
	  {
	    $d = new Department($this->department_id);
	  }
	elseif($this->department_context)
	  {
	    $d = new Department($this->department_context);
	  }
	$emp = $d->employee->get();
	foreach($emp as $e)
	  {
	    $data['employees'][$e->firstname] = array(
						      'firstname'=>$e->firstname,
						      'lastname'=>$e->lastname,
						      'id'=>$e->id,
						      );
	  }
			
	sort($data['employees']);
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
    if (!$this->employee_id)
      $this->form_validation->set_rules('employee_id','Employee','required');

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


	$ihour = $this->input->post('hour_in');
	$imin  = $this->input->post('minute_in');
	$ipm    = $this->input->post('pm_in');

	$ohour = $this->input->post('hour_out');
	$omin  = $this->input->post('minute_out');
	$opm   = $this->input->post('pm_out');

	$itime = date_twelve_to_24("$ihour:$imin $ipm");
	$otime = date_twelve_to_24("$ohour:$omin $opm");

	$h->time_in = $itime;
	$h->time_out = $otime;
	$h->save($e);
	$h->save($d);

	redirect('hours/view_all');
      }

    $curr_time = preg_split('/[\s,:]+/',date('g:i a'));
    $minute = (int) ($curr_time[1]/15)*15;
    $time = array(
		  'hour'=>$curr_time[0],
		  'minute'=>$minute,
		  'period'=>$curr_time[2]
		  );

    $data['time_in']=$time;
    $data['time_out']=$time;

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


  public function employee_hours($limit = null)
  {
		if (!$limit)
		{
			$limit = 100;
		}
    $this->load->helper('date');
    $e = new Employee($this->employee_id);

    if ($this->department_context)
      {
	$hours = $e->hour->where("department_id",$this->department_context);
			$hours->limit($limit);
			$hours->get();
      }
    else
      {
	$hour = $e->hour;
			$hour->limit($limit);
			$hour->get();
      }


    $aaData = array();

    if ($this->department_context)
      {
	foreach ($e->hour as $h)
	  {
	    array_push($aaData,
		       array(
			     date_mysql_std($h->date),
			     date_24_to_twelve($h->time_in),
			     date_24_to_twelve($h->time_out),
			     "<a href='".base_url('hours/edit_time/'.$h->id)."'><img src='".base_url('/css/icons/edit.png')."'/></a><a href='".base_url('hours/delete_time/'.$h->id)."'><img src='".base_url('/css/icons/delete.png')."'/></a"
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
			     date_24_to_twelve($h->time_in),
			     date_24_to_twelve($h->time_out),
			     "<a href='".base_url('hours/edit_time/'.$h->id)."'><img src='".base_url('/css/icons/edit.png')."'/></a><a href='".base_url('hours/delete_time/'.$h->id)."'><img src='".base_url('/css/icons/delete.png')."'/></a"
			     )
		       );
	  }
      }

    echo json_encode(array('aaData'=>$aaData));
  }

  public function department_hours($limit = null)
  {
		if (!$limit)
		{
			$limit = 100;
		}
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
	$hours = $d->hour;
			$hours->limit($limit);
			$hours->get();
	if ($this->department_id)
	  {
	    foreach ($hours as $h)
	      {
		$e = $h->employee->get();
		array_push($aaData,
			   array(
				 $e->firstname . ' ' . $e->lastname,
				 date_mysql_std($h->date),
				 date_24_to_twelve($h->time_in),
				 date_24_to_twelve($h->time_out)
				 )
			   );
	      }
	  }

	elseif ($this->department_context)
	  {
	    $hours = $d->hour;
				$hours->limit($limit);
				$hours->get();
	    foreach ($hours as $h)
	      {
		$e = $h->employee->get();
		array_push($aaData,
			   array(
				 $e->firstname . ' ' . $e->lastname,
				 date_mysql_std($h->date),
				 date_24_to_twelve($h->time_in),
				 date_24_to_twelve($h->time_out),
				 "<a href='".base_url('hours/edit_time/'.$h->id)."'><img src='".base_url('/css/icons/edit.png')."'/></a><a href='".base_url('hours/delete_time/'.$h->id)."'><img src='".base_url('/css/icons/delete.png')."'/></a"
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
				 date_24_to_twelve($h->time_in),
				 date_24_to_twelve($h->time_out),
				 "<a href='".base_url('hours/edit_time/'.$h->id)."'><img src='".base_url('/css/icons/edit.png')."'/></a><a href='".base_url('hours/delete_time/'.$h->id)."'><img src='".base_url('/css/icons/delete.png')."'/></a"
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
				 date_24_to_twelve($h->time_in),
				 date_24_to_twelve($h->time_out)
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
