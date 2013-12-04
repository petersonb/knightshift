<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Main Controller
 *
 * Handles all activity for non logged in users
 *
 * @author brett
 *
 */
class Shifts extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->employee_id = $this->session->userdata('employee_id');
    $this->admin_id = $this->session->userdata('admin_id');
    $this->department_id = $this->session->userdata('department_id');
    $this->department_context = $this->session->userdata('department_context');

    $this->menu_data = $this->menu_system->get_menu_data();
  }

  public function add()
  {
    // Security
    //    You must be an admin or an employee to use this page
    //      (not a department)
    if (!$this->employee_id && !$this->admin_id)
      {
	redirect('main');
      }
    if (! $this->department_context)
      {
	redirect('main');
      }
    
    $this->load->library('form_validation');
    $this->load->helper('date');

    $d = new Department($this->department_context);

    if ($this->form_validation->run('shift_add'))
      {
	// Retrieve post data from page
	$day_of_week = $this->input->post('day_of_week');

	$hour_in = $this->input->post('hour_in');
	$minute_in = $this->input->post('minute_in');
	$day_in = $this->input->post('day_in');

	$hour_out = $this->input->post('hour_out');
	$minute_out = $this->input->post('minute_out');
	$day_out = $this->input->post('day_out');

	if (!$this->employee_id)
	  {
	    $emp_id = $this->input->post('employee_id');
	  }
	else
	  {
	    $emp_id = $this->employee_id;
	  }
	
	// Convert time to mysql format
	$time_in = date_twelve_to_24("$hour_in:$minute_in $day_in");
	$time_out = date_twelve_to_24("$hour_out:$minute_out $day_out");

	// TODO: Should be asserting the time in and out is chronologically correct
	
	// Get Employee
	$e = new Employee($emp_id);

	// Create shift
	$s = new Shift();
	$s->day = $day_of_week;
	$s->time_in = $time_in;
	$s->time_out = $time_out;
	$s->save($d);
	$s->save($e);

	redirect('shifts/view_all');
      }
    
    $data['department'] = array(
				'name'=>$d->name
				);
    
    if (!$this->employee_id)
      {
	$emps = $d->employee->get();
	foreach($emps as $e)
	  {
	    $data['employees'][$e->firstname] = array(
						      'firstname'=>$e->firstname,
						      'lastname'=>$e->lastname,
						      'id'=>$e->id,
						      );
	  }
			
	sort($data['employees']);
      }
    
    $data['title'] = 'Add Shift';
    $data['content'] = 'shifts/add';
    $this->load->view('master',$data);
  }
  
  public function view()
  {
    $data['title'] = 'View Shift';
    $data['content'] = 'shifts/view';
    $this->load->view('master',$data);
  }


  public function confirm($sid = null)
  {
    // Security
    if (!$sid)
      {
	redirect('main');
      }

    if ($this->employee_id && $this->department_context)
      {
	$e = new Employee($this->employee_id);
	$shr = $e->shift_hour;
	$shr->where('id',$sid)->get();
	$d = new Department($this->department_context);
      }

    elseif ($this->department_id)
      {
	$d = new Department($this->department_id);
	$shr = $d->shift_hour;
	$shr->where('id',$sid)->get();
	$e = $shr->employee;
	$e->get();
      }
    else
      {
	redirect('main');
      }


    if (!$shr->exists() or !$e->exists() or !$d->exists()) 
      {
	redirect('main');
      }

    $date = date('Y-m-d');
    $tin  = $shr->time_in;
    $tout = $shr->time_out;

    $h = new Hour();
    $h->date = $date;
    $h->time_in = $tin;
    $h->time_out = $tout;
    $h->save(array($d,$e));

    $shr->delete();
    redirect('hours/view_all');
  }


  public function deny($sid = null)
  {
    // Security
    if (!$sid)
      {
	redirect('main');
      }

    if ($this->employee_id && $this->department_context)
      {
	$e = new Employee($this->employee_id);
	$shr = $e->shift_hour;
	$shr->where('id',$sid)->get();
	$d = new Department($this->department_context);
      }

    elseif ($this->department_id)
      {
	$d = new Department($this->department_id);
	$shr = $d->shift_hour;
	$shr->where('id',$sid)->get();
	$e = $shr->employee;
	$e->get();
      }
    else
      {
	redirect('main');
      }


    if (!$shr->exists() or !$e->exists() or !$d->exists()) 
      {
	redirect('main');
      }

    $shr->delete();
    redirect('shifts/today');
  }

  public function delete($sid = null)
  {
    // Security
    if (!$sid || !$this->department_context)
      {
	redirect('main');
      }
    
    // TODO: Security for employees (can't edit other emps stuff)
      
    // Get department through context
    $d = new Department($this->department_context);

    $s = $d->shift;
    $s->where('id',$sid)->get();

    // Security cont...
    // Check shift exists
    if (!$s->exists()) 
      redirect('main');
    
    // Load libs
    $this->load->helper(array('form','date'));

    if ($this->input->post())
      {
	if ($this->input->post('confirm'))
	  {
	    $s->delete();
	    redirect('shifts/view_all');
	  }
      }

    $data['shift'] = array(
			   'id'=>$s->id,
			   'day'=>$s->day,
			   'time_in'=>date_24_to_twelve($s->time_in),
			   'time_out'=>date_24_to_twelve($s->time_out),
			   );

    $data['content'] = 'shifts/delete';
    $this->load->view('master',$data);
  }

  public function edit($sid = null)
  {
    // Security
    if (!$sid || !$this->department_context)
      {
	redirect('main');
      }
    
    // TODO: Security for employees (can't edit other emps stuff)
      
    // Get department through context
    $d = new Department($this->department_context);

    $s = $d->shift;
    $s->where('id',$sid)->get();

    // Security cont...
    // Check shift exists
    if (!$s->exists()) 
      redirect('main');

    $this->load->library('form_validation');
    $this->load->helper('date');

    $this->form_validation->set_rules('day_of_week',"Day",'required');
    if ($this->form_validation->run())
      {
	$hour_in = $this->input->post('hour_in');
	$hour_out = $this->input->post('hour_out');

	$min_in = $this->input->post('minute_in');
	$min_out = $this->input->post('minute_out');
	
	$pm_in = $this->input->post('pm_in');
	$pm_out = $this->input->post('pm_out');


	$itime = date_twelve_to_24("$hour_in:$min_in $pm_in");
	$otime = date_twelve_to_24("$hour_out:$min_out $pm_out");

	$day = $this->input->post('day_of_week');

	$s->time_in = $itime;
	$s->time_out = $otime;
	$s->day = $day;

	$s->save();
	redirect('shifts/view_all');
      }


    $data['shift'] = array(
			   'id'=>$s->id,
			   'day'=>$s->day
			   );

    $in_split = preg_split('/[\s,:]+/',date_24_to_twelve($s->time_in));
    $data['time_in'] = array(
			     'hour'=>$in_split[0],
			     'minute'=>$in_split[1],
			     'period'=>$in_split[2]
			     );
    
    $out_split = preg_split('/[\s,:]+/',date_24_to_twelve($s->time_out));
    $data['time_out'] = array(
			      'hour'=>$out_split[0],
			      'minute'=>$out_split[1],
			      'period'=>$out_split[2]
			      );
    
    $data['content'] = 'shifts/edit';
    $this->load->view('master',$data);
  }

  public function today()
  {
    // Security
    if (!$this->department_context and !$this->department_id)
      {
	redirect('main');
      }

    $data['title'] = 'Shifts Today';
    $data['content'] = 'shifts/today';
    $data['javascript'] = array(
				'datatables/media/js/jquery',
				'datatables/media/js/jquery.dataTables',
				'shifts/today'
				);
    $data['css'] = 'dataTables/jquery.dataTables';
    $this->load->view('master',$data);
    
  }


  public function update_day()
  {
    // Delete all old shift_hours
    $shrs = new Shift_hour();
    $shrs->get();
    $shrs->delete_all();


    // Create hours for today
    $day = strtolower(substr(date('l'),0,3));
    echo $day;
    echo '<hr>';
    $employees = new Employee();
    $employees->get();
    foreach ($employees as $e)
      {
	echo $e->firstname;
	$shifts = $e->shift;
	$shifts->where('day',$day)->get();
	foreach ($shifts as $s)
	  {
	    $d = $s->department;
	    $d->get();
	    echo $s->day. '<br />';
	    $sh = new Shift_hour();
	    $sh->time_in = $s->time_in;
	    $sh->time_out = $s->time_out;
	    $sh->save(array($e,$d));
	  }
      }
  }

  public function view_all()
  {
    // Security
    //   Must have department context

    if (!$this->department_context) {
      redirect('main');
    }

    $data['title'] = 'View All Shifts';
    $data['content'] = 'shifts/view_all';
    $data['javascript'] = array(
				'datatables/media/js/jquery',
				'datatables/media/js/jquery.dataTables',
				'shifts/view_all'
				);
    $data['css'] = 'dataTables/jquery.dataTables';
    $this->load->view('master',$data);
  }


  public function department_shifts()
  {
    // Security
    if (!$this->department_context) {
      echo "No Department Context";
      return;
    }
    $this->load->helper('date');

    if ($this->admin_id)
      {
	$d = new Department($this->department_context);
	$shifts = $d->shift;
      }
    elseif ($this->employee_id)
      {
	$e = new Employee($this->employee_id);
	$shifts = $e->shifts;
      }
    $shifts->where('department_id',$this->department_context);
    $shifts->get();

    $data = array();
    foreach ($shifts as $s)
      {
	$e = $s->employee->get();
	array_push($data,
		   array(
			 $e->firstname,
			 $e->lastname,
			 $s->day,
			 date_24_to_twelve($s->time_in),
			 date_24_to_twelve($s->time_out),
			 "<a href='".base_url('shifts/edit/'.$s->id)."'><img src='".base_url('/css/icons/edit.png')."'/></a><a href='".base_url('shifts/delete/'.$s->id)."'><img src='".base_url('/css/icons/delete.png')."'/></a"
				 
			 )
		   );
      }

    echo json_encode(array('aaData'=>$data));
  }

  public function todays_shifts()
  {
    // Security
    if (!$this->department_context and !$this->department_id)
      {
	echo "No department";
      }
    if ($this->department_id)
      {
	$d = new Department($this->department_id);
      }

    $this->load->helper('date');

    $data = array();
    
    $shrs = $d->shift_hour;
    $shrs->get();

    foreach ($shrs as $h)
      {
	$e = $h->employee;
	$e->get();
	array_push($data,array(
			       $e->firstname,
			       $e->lastname,
			       date_24_to_twelve($h->time_in),
			       date_24_to_twelve($h->time_out),
			       "<a href='".base_url('shifts/confirm/'.$h->id)."'><img src='".base_url('/css/icons/checkmark.png')."'/></a><a href='".base_url('shifts/deny/'.$h->id)."'><img src='".base_url('/css/icons/delete.png')."'/></a"
			       )
		   );
      }

    echo json_encode(array('aaData'=>$data));
  }
}

/* End of file shifts.php */
/* Location: ./application/controllers/shifts.php */