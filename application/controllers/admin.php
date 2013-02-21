<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

  public function index()
  {
    $data = array();
    $this->load->view('master',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */