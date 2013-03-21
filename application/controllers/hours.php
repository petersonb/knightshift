<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hours extends CI_Controller {

  public function index()
  {
    $data['title'] = 'Hours';
    $this->load->view('master',$data);
  }

  public function edit_time($id = NULL)
  {
    if (!$id and !$this->input->post())
      redirect('main');
    else
      {
	$this->load->helper('form');
	$this->load->library('form_validation');
	
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
  }

  public function log_time()
  {
    $this->load->helper(array('form','date'));
    $this->load->library('form_validation');

    $did = $this->session->userdata('department_id');
    $dct = $this->session->userdata('department_context');
    if ($did)
      $d = new Department($did);
    elseif($dct)
      $d = new Department($dct);

    $data['department']['name'] = $d->name;
    
    $eid = $this->session->userdata('employee_id');
    if (!$eid)
      $data['no_eid'] = TRUE;
    else
      $data['no_eid'] = FALSE;

    $this->form_validation->set_rules('date','Date','requ red');
    $this->form_validation->set_rules('time_in','Time-in','required');
    $this->form_validation->set_rules('time_out','Time-out','required');
    if ($this->form_validation->run())
      {
	$h = new Hour();

	if (!$eid)
	  $e = new Employee($this->input->post('employee_id'));
	else
	  $e = new Employee($eid);

	$h->date = date_std_mysql($this->input->post('date'));
	$h->time_in = $this->input->post('time_in');
	$h->time_out = $this->input->post('time_out');
	$h->save($e);
	$h->save($d);
      }

    $data['title'] = 'Log Time';
    $data['css'] = 'calendar_widget/jquery-ui';
    $data['javascript'] = array('jquery','jquery-ui','hours/date');
    $data['content'] = 'hours/log_time';
    $this->load->view('master',$data);
  }

  public function view_all()
  {
    $eid = $this->session->userdata('employee_id');
    $aid = $this->session->userdata('admin_id');
    $dct = $this->session->userdata('department_context');
    $did = $this->session->userdata('department_id');
    if ($dct)
      $d = new Department($dct);
    elseif ($did)
      $d = new Department($did);
    elseif ($eid)
      {
	$e = new Employee($eid);
	$data['employee'] = array('id'=>$e->id);
	$d = $e->department->get();
      }
    elseif ($aid)
      {
	$a = new Admin($aid);
	$d = $a->department->get();
      }
    
    foreach ($d as $dept)
      {
	if ($eid)
	  $dept->hour->where('employee_id',$eid);
	$data['department'][$dept->id] = array('name'=>$dept->name,
					       'hours'=>$dept->hour->get());
      }

    $data['title'] = 'View All Hours';
    $data['css'] = array('slickgrid/slick.grid',
			 'slickgrid/css/smoothness/jquery-ui-1.8.16.custom'
			 );
    $data['javascript'] = array('slickgrid/lib/jquery-1.7.min',
				'slickgrid/lib/jquery.event.drag-2.0.min',
				'slickgrid/slick.core',
				'slickgrid/slick.grid',
				'hours/emp_hours'
				);
    $data['content'] = 'hours/view_all';
    $this->load->view('master',$data);
  }

  public function employee_hours($id)
  {
    $this->load->helper('date');
    $e = new Employee($id);
    $e->hour->get();
    
    $data = array();
    foreach ($e->hour as $h)
      {
	array_push($data,array('id'=>$h->id,
			       'date'=>date_mysql_std($h->date),
			       'time_in'=>$h->time_in,
			       'time_out'=>$h->time_out));
	
      }
    
    echo json_encode($data);
  }
  
}

/* End of file hours.php */
/* Location: ./application/controllers/hours.php */