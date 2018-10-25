<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{
	function index()
	{
		$this->load->model('main_model');

		//$data['result'] = $this->helloworld_model->getData();
		$data['page_title'] = "사용자 목록";

		$this->load->view('main_header', $data);
		$this->load->view('main_footer', $data);
	}
	
	function test()
	{
		echo "Test function called.";
	}	
}
?>