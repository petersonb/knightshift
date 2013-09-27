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

    if ($this->form_validation->run('shift_add'))
      {
	$day_of_week = $this->input->post('day_of_week');
	$emp_id = '1';
	$dep_id = '1';
	$s = new Shift();

	$e = new Employee($emp_id);
	$d = new Department($dep_id);

	$s->day = $day_of_week;
	$s->save($d);
	$s->save($e);
      }
      else
	{
	  echo 'FORM VALIDATION DID NOT RUN';
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