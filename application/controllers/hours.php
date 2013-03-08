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
    $this->load->helper('form');
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

    $this->form_validation->set_rules('date','Date','required');
    $this->form_validation->set_rules('time_in','Time-in','required');
    $this->form_validation->set_rules('time_out','Time-out','required');
    if ($this->form_validation->run())
      {
	$h = new Hour();

	if (!$eid)
	  $e = new Employee($this->input->post('employee_id'));
	else
	  $e = new Employee($eid);

	$h->date = $this->input->post('date');
	$h->time_in = $this->input->post('time_in');
	$h->time_out = $this->input->post('time_out');
	$h->save($e);
	$h->save($d);
      }

    $data['title'] = 'Log Time';
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
    $data['content'] = 'hours/view_all';
    $this->load->view('master',$data);
  }
  
}

/* End of file hours.php */
/* Location: ./application/controllers/hours.php */