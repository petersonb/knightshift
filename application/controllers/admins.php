<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends CI_Controller {

  public function index()
  {
    $data['title'] = 'Administrator Main';
    $this->load->view('master',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */