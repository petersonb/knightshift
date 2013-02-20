<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

  public function index()
  {
    $this->load->helper(array('form'));
    $data['content'] = array('main/home.php');
    $this->load->view('master',$data);
  }

  public function login()
  {
    echo 'Hello, Sweetie';
  }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */