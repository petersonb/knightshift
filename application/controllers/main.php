<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    echo $this->session->userdata('admin');
  }

  public function index()
  {
    $this->load->helper(array('form'));

    $data['content'] = array('main/home.php');

    $this->load->view('master',$data);
  }

  public function login()
  {
    $this->load->helper(array('url'));
    $this->session->set_userdata('admin',TRUE);
    redirect(base_url('main'));
  }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */