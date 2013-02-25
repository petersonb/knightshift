<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends CI_Controller {

  public function index()
  {
    $data = array();
    $this->load->view('master',$data);
  }

  public function create()
  {
    $this->load->helper('form');

    if (! $this->is_admin())
      redirect('main');
    

    $data['content'] = 'department/create';
    $this->load->view('master',$data);
  }

  private function is_admin($id = NULL)
  {
    if ($this->session->userdata('admin_id'))
      {
	if ($id && $id !== $this->session->userdata('admin_id'))
	  {
	    return FALSE;
	  }
	else
	  {
	    return TRUE;
	  }
      }
    
    return FALSE;
  }
}

/* End of file department.php */
/* Location: ./application/controllers/department.php */