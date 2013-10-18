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

	//redirect('shifts/view_all');
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

  public function view_all()
  {
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
    $d = new Department($this->department_context);
    $shifts = $d->shift;
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
			 $s->time_in,
			 $s->time_out,
			 )
		   );
      }

    echo json_encode(array('aaData'=>$data));
  }    
}

/* End of file shifts.php */
/* Location: ./application/controllers/shifts.php */