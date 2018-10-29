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
		$this->load->library("form_validation");
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
		redirect("/member/");
	}


	function edit()
	{
		$this->load->library("form_validation");
		$num = $this->uri->segment(4);
		$data['page_title'] = "사용자 수정";
		$data['num'] = $num;
		$data['member'] = $this->member_model->getMember($num);

		$this->load->view('main_header', $data);
		$this->load->view('member_edit', $data);
		$this->load->view('main_footer', $data);
	}


	function find()
	{
		$user_name = trim($this->input->get_post("user_name", true));

		$this->list($user_name);
	}


	function index()
	{
		$this->list();
	}


	function insert()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules("user_name", "이름", "required|max_length[20]");
		$this->form_validation->set_rules("user_id", "아이디", "required|max_length[20]");
		$this->form_validation->set_rules("passwd", "암호", "required|max_length[20]");

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "사용자 추가";
			$this->load->view('main_header', $data);
			$this->load->view('member_add', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$tel = sprintf("%-3s%-4s%-4s"
			, $this->input->post("tel1", true)
			, $this->input->post("tel2", true)
			, $this->input->post("tel3", true) );

			$member = array(
				'user_name' => $this->input->post("user_name", true)
				, 'user_id' => $this->input->post("user_id", true)
				, 'passwd' => $this->input->post("passwd", true)
				, 'tel' => $tel
				, 'rank' => $this->input->post("rank", true)
			);

			$this->member_model->insertMember($member);

			// 사용자 추가 후, 목록 페이지로 이동
			redirect("/member");
		}
	}


	function list($user_name = null)
	{
		$data['page_title'] = "사용자 목록";
		if (isset($user_name))
			$data['user_name'] = $user_name;
		$data['members'] = $this->member_model->getMembers($user_name);

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
		$this->load->library("form_validation");

		$this->form_validation->set_rules("user_name", "이름", "required|max_length[20]");
		$this->form_validation->set_rules("user_id", "아이디", "required|max_length[20]");
		$this->form_validation->set_rules("passwd", "암호", "required|max_length[20]");

		$num = $this->uri->segment(4);
		$data['page_title'] = "사용자 수정";
		$data['num'] = $num;
		if ($this->form_validation->run() == FALSE)
		{
			$data['member'] = $this->member_model->getMember($num);

			$this->load->view('main_header', $data);
			$this->load->view('member_edit', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$tel = sprintf("%-3s%-4s%-4s"
				, $this->input->post_get("tel1", true)
				, $this->input->post_get("tel2", true)
				, $this->input->post_get("tel3", true) );
			$member = array(
				'user_name' => $this->input->post_get("user_name", true)
				, 'user_id' => $this->input->post_get("user_id", true)
				, 'passwd' => $this->input->post_get("passwd", true)
				, 'tel' => $tel
				, 'rank' => $this->input->post_get("rank", true)
			);

			$this->member_model->updateMember($num, $member);

			// 사용자 추가 후, 목록 페이지로 이동
			redirect("/member/");
		}
	}
}
?>