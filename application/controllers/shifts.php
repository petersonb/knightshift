<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Main Controller
 *
 * Handles all activity for non logged in users
 *
 * @author brett
 *
 */
class Shifts extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->employee_id = $this->session->userdata('employee_id');
    $this->admin_id = $this->session->userdata('admin_id');
    $this->department_id = $this->session->userdata('department_id');
		
    $this->menu_data = $this->menu_system->get_menu_data();
  }

  public function add()
  {
    $this->load->library('form_validation');

    if ($this->form_validation->run('shifts_add'))
      {
	echo 'FORM VALIDATION RUN';
      }
      else
	{
	  
	}
    
      $data['title'] = 'Add Shift';
      $data['content'] = 'shifts/add';
      $this->load->view('master',$data);
      }

    public function view()
    {
      $data['title'] = 'View Shift';
      $data['content'] = 'shifts/view';
      $this->load->view('master',$data);
    }
  }

  /* End of file shifts.php */
  /* Location: ./application/controllers/shifts.php */