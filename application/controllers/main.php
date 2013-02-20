<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

  public function index()
  {
    $data['content'] = array('main/home.php');
    $this->load->view('master',$data);
  }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */