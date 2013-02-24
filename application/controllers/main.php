<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
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
    $a = new Admin();

    $a->email = $this->input->post('email');
    $a->password = $this->input->post('password');
    if ($a->login())
      {
	$this->session->set_userdata('admin_id',$a->id);
	redirect('admin');
      }
    redirect('main');
  }

  public function logout()
  {
    $this->session->sess_destroy();
  }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */