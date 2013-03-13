<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Development extends CI_Controller {

  public function index()
  {
    if ($this->is_empty())
      {
	$this->create_admins();
	$this->create_departments();
	$this->create_employees();
	$this->log_hours();
      }
    else
      echo 'Database already populated';
  }

  private function is_empty()
  {
    $a = new Admin();
    $a->get_iterated();
    if ($a->exists())
      return FALSE;
    $d = new Department();
    $d->get_iterated();
    if ($d->exists())
      return FALSE;
    $e = new Employee();
    $e->get_iterated();
    if ($e->exists())
      return FALSE;
    $h = new Hour();
    $h->get_iterated();
    if ($h->exists())
      return FALSE;
    return TRUE;
  }

  private function create_admins()
  {
    $a = new Admin();
    $a->firstname = 'First';
    $a->lastname = 'Lastname';
    $a->password = 'pass';
    $a->email = 'admin0';
    $a->phone = '000-000-0000';
    $a->save();

    echo 'Created Admin0';

    $a1 = new Admin();
    $a1->firstname = 'Second';
    $a1->lastname = 'Admin';
    $a1->password = 'pass';
    $a1->email = 'admin1';
    $a1->phone = '111-111-1111';
    $a1->save();

    echo 'Created Admin1';
  }

  private function create_departments()
  {
    $this->create_department(array(1),'Department 0');
    $this->create_department(array(1,2),'Department 1');
    $this->create_department(array(1,2),'Department 2');
    $this->create_department(array(2),'Department 3');
  }

  private function create_department($id,$name)
  {
    $d = new Department();
    $d->name = $name;
    $d->password = 'pass';

    foreach ($id as $aid)
      {
	$a = new Admin($aid);
	$d->save($a);
      }
    echo 'Created department '.$name;
  }

  private function create_employees()
  {
    $this->create_employee(array(1,2),'emp');
    $this->create_employee(array(1),'emp1');
    $this->create_employee(array(2),'emp2');
  }

  private function create_employee($id,$email)
  {
    $e = new Employee();
    $e->email = $email;
    $e->firstname = $email;
    $e->lastname = $email;
    $e->password = 'pass';
    foreach ($id as $did)
      {
	$d = new Department($did);
	$e->save($d);
      }
    echo "Created employee ".$email;
  }

  private function log_hours()
  {
    $this->log_hour(1,1,'2013/01/02','00:00:00','01:00:00');
    $this->log_hour(1,1,'2013/01/02','00:15:00','01:15:00');
    $this->log_hour(1,2,'2013/01/02','00:30:00','01:30:00');
    $this->log_hour(1,2,'2013/01/02','00:45:00','01:45:00');

    $this->log_hour(2,1,'2013/02/01','00:00:00','01:00:00');
    $this->log_hour(2,1,'2013/02/01','00:15:00','01:15:00');
    $this->log_hour(2,1,'2013/02/01','00:30:00','01:30:00');
    $this->log_hour(2,1,'2013/02/01','00:45:00','01:45:00');

    $this->log_hour(3,2,'2013/03/02','00:00:00','01:00:00');
    $this->log_hour(3,2,'2013/03/02','00:15:00','01:15:00');
    $this->log_hour(3,2,'2013/03/02','00:30:00','01:30:00');
    $this->log_hour(3,2,'2013/03/02','00:45:00','01:45:00');
  }

  private function log_hour($eid,$did,$date,$in,$out)
  {
    $e = new Employee($eid);
    $d = new Department($did);

    $h = new Hour();
    $h->date = $date;
    $h->time_in = $in;
    $h->time_out = $out;
    $h->save($e);
    $h->save($d);
      
    echo "Created hour for emplouee ".$e->firstname. ' ' . $e->lastname;
  }

}

/* End of file development.php */
/* Location: ./application/controllers/development.php */