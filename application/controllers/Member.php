<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('member_model');
		$this->load->helper(array("date", "url"));
	}


	function add()
	{
		$data['page_title'] = "사용자 추가";
		$this->load->view('main_header', $data);
		$this->load->view('member_add', $data);
		$this->load->view('main_footer', $data);
	}


	function delete()
	{
		$num = $this->uri->segment(4);
		$this->member_model->deleteMember($num);

		// 사용자 삭제 후, 목록 페이지로 이동
		redirect("/member");
	}


	function edit()
	{
		$num = $this->uri->segment(4);
		$data['page_title'] = "사용자 수정";
		$data['member'] = $this->member_model->getMember($num);

		$this->load->view('main_header', $data);
		$this->load->view('member_edit', $data);
		$this->load->view('main_footer', $data);
	}


	function index()
	{
		$this->list();
	}


	function insert()
	{
		$tel = sprintf("%-3s%-4s%-4s"
			, $this->input->post("tel1", true)
			, $this->input->post("tel2", true)
			, $this->input->post("tel3", true) );

		$member = array(
			'user_name' => $this->input->post("user_name", true)
			, 'user_id' => $this->input->post("user_id", true)
			, 'passwd' => $this->input->post("user_id", true)
			, 'tel' => $tel
			, 'rank' => $this->input->post("rank", true)
		);

		$this->member_model->insertMember($member);

		// 사용자 추가 후, 목록 페이지로 이동
		redirect("/member");
	}


	function list()
	{
		$data['page_title'] = "사용자 목록";
		$data['members'] = $this->member_model->getMembers();

		$this->load->view('main_header', $data);
		$this->load->view('member_list', $data);
		$this->load->view('main_footer', $data);
	}


	function view()
	{
		$num = $this->uri->segment(4);
		$data['page_title'] = "사용자 정보";
		$data['member'] = $this->member_model->getMember($num);

		$this->load->view('main_header', $data);
		$this->load->view('member_view', $data);
		$this->load->view('main_footer', $data);
	}


	function test()
	{
		echo "Test function called.";
	}	


	function update()
	{
		$tel = sprint("%-3s%-4s%-4s"
			, $this->input->post("tel1", true)
			, $this->input->post("tel2", true)
			, $this->input->post("tel3", true) );
		$member = array(
			'user_name' => $this->input->post("user_name", true)
			, 'user_id' => $this->input->post("user_id", true)
			, 'passwd' => $this->input->post("user_id", true)
			, 'tel' => $tel
			, 'rank' => $this->input->post("rank", true)
		);

		$this->member_model->updateMember($member);
	}
}
?>