<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {

  public function index()
  {
    $data = array();
    $this->load->view('master',$data);
  }

}

/* End of file employee.php */
/* Location: ./application/controllers/employee.php */