<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->admin_id = $this->session->userdata('admin_id');
    $this->employee_id = $this->session->userdata('employee_id');
    $this->department_id = $this->session->userdata('department_id');
    $this->department_context = $this->session->userdata('department_context');
    $this->menu_data = $this->menu_system->get_menu_data();
  }

  public function index ()
  {
    $this->initial_auth();

    if ($this->admin_id)
      {
	$user = new Admin($this->admin_id);
      }
    elseif($this->emplopyee_id)
      {
	$user = new Employee($this->employee_id);
      }

    $depts = $user->department->get();

    foreach ($depts as $d)
      {
	$data['departments'][$d->id] = array(
					     'id'=>$d->id,
					     'name'=>$d->name
					     );
      }

    $data['content'] = 'excel/main';
    $data['title'] = 'Excel Handling';
    $this->load->view('master',$data);
  }

  public function admin ()
  {
    // Security
    if (!$this->admin_id)
      redirect('main');
		
    $this->load->helper('form');
    $data['content'] = 'excel/admin';
    $this->load->view('master',$data);
  }

  public function admin_generate()
  {
    // Security
    if (!$this->admin_id || !$this->department_context)
      redirect('main');
		
    $this->load->library('excel');
    $this->load->helper('date');

    $template = "excelsheets/template.xlsx";

    $MONTH_FIELD = 'F2';
    $EMP_NAME_FIELD = 'C5';
    $EMP_ID_FIELD = 'C7';
    $DEP_NAME_FIELD = 'H5';
    $DEP_ID_FIELD = 'H7';
    $SUPERVISORS_FIELD = 'H9';
    $RATE_FIELD = 'G47';

    $HOUR_TOTAL_FIELD = 'G44';
    $PAY_TOTAL_FIELD = 'G49';

    $mval = $this->input->post('month');
    $yval = $this->input->post('year');
    $time = mktime('0','0','0',$mval,'1',$yval);
    $month = date('F',$time);
    $year = date('Y',$time);



    $d = new Department($this->department_context);
    $filepath = 'excelsheets/'.$d->id . '/' . $year . '/' . $month . '/';
    $this->clean_filepath($filepath);
    $this->check_filepath($filepath);

    $start_day = "'$yval-$mval-01'";
    $end_day = "'$yval-$mval-31'";
    $emps = $d->employee->get();

    foreach ($emps as $e)
      {

	$name = $e->firstname . ' ' . $e->lastname;

	$r = $e->rate->where('department_id',$this->department_context)->get();
	$excel = PHPExcel_IOFactory::load($template);

	$excel->setActiveSheetIndex(0)
	  ->setCellValue($MONTH_FIELD,$month)
	  ->setCellValue($EMP_NAME_FIELD,$name)
	  ->setCellValue($EMP_ID_FIELD,$e->student_id)
	  ->setCellValue($DEP_NAME_FIELD,$d->name)
	  ->setCellValue($DEP_ID_FIELD,$d->dept_id)
	  ->setCellValue($SUPERVISORS_FIELD,$d->supervisors)
	  ->setCellValue($RATE_FIELD,$r->hourly);
				
				
	$hrs = $e->hour;
	$hrs->where_between("date","$start_day","$end_day")->get();
	$total = 0.0;
	foreach ($hrs as $h)
	  {
	    $in = new DateTime($h->time_in);
	    $out = new DateTime($h->time_out);
	    $diff = $in->diff($out);
	    $diff = $this->decimal_time($diff);
	    $floatdiff = $diff;
	    $total += $floatdiff;


	    $sdate = preg_split('/-/', $h->date);
	    $day = $sdate[2];
	    $yval = $day + 12;
	    $x = 66;
	    $checkx = $excel->setActiveSheetIndex(0)->getCell('B'.$yval);
	    if ($checkx != '')
	      {
		$checkx = $excel->setActiveSheetIndex(0)->getCell('D'.$yval);
		if ($checkx != '')
		  {
		    $x = 70;
		  }
		else
		  {
		    $x=68;
		  }
	      }

	    $c_day_subtotal = $excel->setActiveSheetIndex(0)->getCell('H'.$yval)->getValue();
	    if ($c_day_subtotal != '')
	      {
		$c_day_total = floatval($c_day_subtotal) + $diff;
	      }
	    else 
	      {
		$c_day_total = $diff;
	      }
	    $excel->setActiveSheetIndex(0)
	      ->setCellValue('H'.$yval,$c_day_total);

	    $excel->setActiveSheetIndex(0)
	      ->setCellValue(chr($x).$yval,date_24_to_twelve($h->time_in))
	      ->setCellValue(chr($x+1).$yval,date_24_to_twelve($h->time_out));

	  }
	$writer = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
	$name = str_replace(' ', '', $name);
	$excel->setActiveSheetIndex(0)
	  ->setCellValue($HOUR_TOTAL_FIELD,$total)
	  ->setCellValue($PAY_TOTAL_FIELD,$r->hourly*$total);
	$writer->save($filepath.$month.$name.'.xlsx');
      }
    $zip_path = "$filepath../$month";
    $opt = shell_exec("zip -r $zip_path {$filepath}");
		
    $data['zip_path'] = '/'.$zip_path.'.zip';
		
    $data['content'] = 'excel/download';
    $this->load->view('master',$data);
  }
	
  private function decimal_time($time)
  {
    $t = $time->format("%H.%i");
    $ts = explode('.',$t);
    if ($ts[1]!=0)
      {
	$min = $ts[1]/60. * 100;
      }
    else
      {
	$min = 0;
      }
    return $ts[0].'.'.$min;
  }

  private function check_filepath($filepath)
  {
    if (!file_exists($filepath))
      {
	$fpa = explode('/',$filepath);
	if (!file_exists($fpa[0]))
	  {
	    shell_exec("mkdir ". $fpa[0]);
	  }

	if (!file_exists("$fpa[0]/$fpa[1]"))
	  {
	    shell_exec("mkdir " . "$fpa[0]/$fpa[1]");
	  }

	if (!file_exists("$fpa[0]/$fpa[1]/$fpa[2]"))
	  {
	    shell_exec("mkdir " . "$fpa[0]/$fpa[1]/$fpa[2]");
	  }

	if (!file_exists("$fpa[0]/$fpa[1]/$fpa[2]/$fpa[3]"))
	  {
	    shell_exec("mkdir " . "$fpa[0]/$fpa[1]/$fpa[2]/$fpa[3]");
	  }
      }
  }
	
  public function clean_filepath($filepath)
  {
    if (file_exists($filepath))
      {
	shell_exec("rm -rf " . $filepath);
      }
  }

  private function initial_auth()
  {
    if ($this->admin_id && $this->department_context)
      {
	redirect('excel/admin');
      }
    elseif ($this->employee_id && $this->departemtn_context)
      {
	redirect('excel/employee');
      }
    elseif (!$this->admin_id && !$this->employee_id)
      {
	redirect('main');
      }
  }

}

/* End of file excel.php */
/* Location: ./application/controllers/excel.php */
