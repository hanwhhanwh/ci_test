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
		$this->load->library("pagination");
	}


	function _setParamFromUri(&$arrData, &$arrUri, $strParamName)
	{
		if (array_key_exists($strParamName, $arrUri))
		{
			$value = trim(urldecode($arrUri[$strParamName]));
			$arrData[$strParamName] = $value;
			return $value;
		}
		return null;
	}


	function add()
	{
		$this->load->library("form_validation");

		$data['page_title'] = "사용자 추가";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");

		$this->load->view('main_header', $data);
		$this->load->view('member_add', $data);
		$this->load->view('main_footer', $data);
	}


	function delete()
	{
		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$num = $this->_setParamFromUri($data, $arrUri, "num");
		$this->member_model->deleteMember($num);

		$strRedirect = "/member/list";
		if (isset($name))
			$strRedirect .= "/name/{$name}";
		if (isset($page))
			$strRedirect .= "/page/{$page}";

		// 사용자 삭제 후, 목록 페이지로 이동
		redirect( $strRedirect );
	}


	function edit()
	{
		$this->load->library("form_validation");

		$data['page_title'] = "사용자 수정";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$num = $this->_setParamFromUri($data, $arrUri, "num");
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
		$this->load->library("form_validation");

		$this->form_validation->set_rules("user_name", "이름", "required|max_length[20]");
		$this->form_validation->set_rules("user_id", "아이디", "required|max_length[20]");
		$this->form_validation->set_rules("passwd", "암호", "required|max_length[20]");

		$arrUri = $this->uri->uri_to_assoc();
		$name = $this->_setParamFromUri($data, $arrUri, "name");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
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

			$strRedirect = "/member/list";
			if (isset($name))
				$strRedirect .= "/name/{$name}";
			if (isset($page))
				$strRedirect .= "/page/{$page}";
	
			// 사용자 추가 후, 목록 페이지로 이동
			redirect( $strRedirect );
		}
	}


	function list()
	{
		$data['page_title'] = "사용자 목록";

		$arrUri = $this->uri->uri_to_assoc();
		if ($name = $this->_setParamFromUri($data, $arrUri, "name"))
		// if (array_key_exists("name", $arrUri))
		{
			$config['base_url'] = "/member/list/name/{$name}/page/";
			$config['uri_segment'] = 6;
		}
		else
		{
			$config['base_url'] = '/member/list/page/';
			$config['uri_segment'] = 4;
		}
		$page = $this->_setParamFromUri($data, $arrUri, "page");

		$data['members'] = $this->member_model->getMembers($name, $page);
		$config['total_rows'] = $this->member_model->getMembersCount($name);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('main_header', $data);
		$this->load->view('member_list', $data);
		$this->load->view('main_footer', $data);
	}


	function view()
	{
		$data['page_title'] = "사용자 정보";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$num = $this->_setParamFromUri($data, $arrUri, "num");
		$data['member'] = $this->member_model->getMember($num);

		$this->load->view('main_header', $data);
		$this->load->view('member_view', $data);
		$this->load->view('main_footer', $data);
	}


	function update()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules("user_name", "이름", "required|max_length[20]");
		$this->form_validation->set_rules("user_id", "아이디", "required|max_length[20]");
		$this->form_validation->set_rules("passwd", "암호", "required|max_length[20]");

		$data['page_title'] = "사용자 수정";
		$arrUri = $this->uri->uri_to_assoc();
		$num = $this->_setParamFromUri($data, $arrUri, "num");
		$name = $this->_setParamFromUri($data, $arrUri, "name");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
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

			$strUri = "/member/list";
			if (isset($name))
			  $strUri .= "/name/{$name}";
			if (isset($page))
			  $strUri .= "/page/{$page}";

			  // 사용자 추가 후, 목록 페이지로 이동
			redirect( $strUri );
		}
	}
}
?>