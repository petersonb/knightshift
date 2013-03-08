<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends CI_Controller {

  public function index()
  {
    $data['title'] = 'Administrator Main';
    $this->load->view('master',$data);
  }

  public function change_password()
  {
    $this->load->helper('form');
    $this->load->library('form_validation');
    
    $this->form_validation->set_rules('current','Current Password', 'required');
    $this->form_validation->set_rules('new','New Password','required');
    $this->form_validation->set_rules('confirm','Confirm Password','required');

    if ($this->form_validation->run())
      {
	$curr = new Admin($this->session->userdata('admin_id'));
	$a = new Admin();
	$a->email = $curr->email;
	$a->password = $this->input->post('current');
	if ($a->login())
	  {
	    $curr->password = $this->input->post('new');
	    $curr->save();
	  }
      }
    $data['title'] = 'Change Password';
    $data['content'] = 'admins/change_password';
    $this->load->view('master',$data);
  }

  public function edit_profile()
  {
    $this->load->library('form_validation');
    $this->load->helper('form');
    
    $this->form_validation->set_rules('firstname', 'First Name', 'required');
    $this->form_validation->set_rules('lastname', 'Last Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');

    $a = new Admin($this->session->userdata('admin_id'));

    if ($this->form_validation->run())
      {
	$a->title = $this->input->post('title');
	$a->firstname = $this->input->post('firstname');
	$a->lastname= $this->input->post('lastname');
	$a->email = $this->input->post('email');
	$a->save();
      }
    
    $data['admin'] = $a;
    
    $data['title'] = 'Edit Profile';
    $data['content'] = 'admins/edit_profile';
    $this->load->view('master',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */