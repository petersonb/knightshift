<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hours extends CI_Controller {

  public function index()
  {
    $data['title'] = 'Hours';
    $this->load->view('master',$data);
  }

  public function log_time()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');

    
    $d = new Department($this->session->userdata('department_context'));
    $data['department'] = $d;
    $e = new Employee($this->session->userdata('employee_id'));
    $data['employee'] = $e;

    $this->form_validation->set_rules('date','Date','required');
    $this->form_validation->set_rules('time_in','Time-in','required');
    $this->form_validation->set_rules('time_out','Time-out','required');
    if ($this->form_validation->run())
      {
	$h = new Hour();
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
    $did = $this->session->userdata('department_context');
    $e = new Employee($eid);
    $d = new Department($did);
    $data['department'] = $d;
    $dhours = $e->hour->where('department_id',$d->id);
    $data['hours'] = $dhours->get();
    $data['title'] = 'View All Hours';
    $data['content'] = 'hours/view_all';
    $this->load->view('master',$data);
  }
  
}

/* End of file hours.php */
/* Location: ./application/controllers/hours.php */