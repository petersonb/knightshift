<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_system {

	public function __construct()
	{
		$CI =& get_instance();
		$this->admin_id = $CI->session->userdata('admin_id');
	}

	public function get_menu_data()
	{
		return $this->get_main_menu_data();
	}

	private function get_main_menu_data()
	{
		$data = array(
				array(
						'base' => 'main',
						'name' => 'Home',
				),
				array(
						'base' => 'register',
						'name' => 'Register'
				),
				array(
						'base' => 'about',
						'name' => 'About',
				)
		);
		
		return $data;
	}

}