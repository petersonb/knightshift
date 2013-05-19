<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->admin_id = $this->session->userdata('admin_id');
		$this->employee_id = $this->session->userdata('employee_id');
		$this->department_id = $this->session->userdata('department_id');
		$this->department_context = $this->session->userdata('department_context');
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
		$this->load->helper('form');
		$data['content'] = 'excel/admin';
		$this->load->view('master',$data);
	}

	public function admin_generate()
	{
		$this->load->library('excel');

		$mval = $this->input->post('month');
		$yval = $this->input->post('year');
		$time = mktime('0','0','0',$mval,'1',$yval);
		$month = date('F',$time);
		$year = date('Y',$time);

		$d = new Department($this->department_context);

		$filepath = 'excelsheets/'.$d->id . '/' . $year . '/' . $month . '/';
		$this->check_filepath($filepath);

		$emps = $d->employee->get();

		foreach ($emps as $e)
		{
				
			$name = $e->firstname . ' ' . $e->lastname;
				
			$r = $e->rate->where('department_id',$this->department_context)->get();
			$template = "excelsheets/template.xlsx";
			$excel = PHPExcel_IOFactory::load($template);
				
			$excel->setActiveSheetIndex(0)
			->setCellValue('F2',$month)
			->setCellValue('C5',$name)
			->setCellValue('C7',$e->student_id)
			->setCellValue('H5',$d->name)
			->setCellValue('H7',$d->dept_id)
			->setCellValue('H9','supervisor name')
			->setCellValue('G47',$r->hourly);
				
				
				
				
				
			$hrs = $e->hour->get();
				
				
				
				
				

			echo '<hr />'.$e->firstname.'<br />---------------------------<br />';
			$total = new DateTime("01-00-0000 00:00");
			foreach ($hrs as $h)
			{
				$in = new DateTime($h->time_in);
				$out = new DateTime($h->time_out);
				$diff = $in->diff($out);
				echo '('.$this->decimal_time($diff).')';
				$total = $total->add($diff);
				echo '<br />';
				echo $total->format("d.H.i").'<br />';
				echo $h->time_in;
				echo ' : '.$h->time_out.'<br />';
				echo $diff->format("%H.%i") . '<br />';

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

				$excel->setActiveSheetIndex(0)
				->setCellValue(chr($x).$yval,$h->time_in)
				->setCellValue(chr($x+1).$yval,$h->time_out);


			}
			$writer = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
			$name = str_replace(' ', '', $name);
			$t = floatval($total->format("H.i")).'<br />';
			$day = intval($total->format('d'))-1;
			$fintotal = $t + (24*$day);
			$excel->setActiveSheetIndex(0)
			->setCellValue('G44',$fintotal);
			$writer->save($filepath.$month.$name.'.xlsx');
		}
		$opt = shell_exec("zip -r excelsheets/zips/{$mval} excelsheets/1/");
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