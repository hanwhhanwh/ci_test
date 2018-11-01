<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Group controller class
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		hanwh
 * @email		hbesthee@naver.com
 * 
 * @file		Group.php
 * @version		1.0.0
 * @date		2018-11-01
 */
 
// --------------------------------------------------------------------------

class Group extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('group_model');
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

		$data['page_title'] = "구분 추가";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");

		$this->load->view('main_header', $data);
		$this->load->view('group_add', $data);
		$this->load->view('main_footer', $data);
	}


	function delete()
	{
		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$group_no = $this->_setParamFromUri($data, $arrUri, "group_no");
		$this->group_model->deleteGroup($group_no);

		$strRedirect = "/group/list";
		if (isset($name))
			$strRedirect .= "/name/{$name}";
		if (isset($page))
			$strRedirect .= "/page/{$page}";

		// 구분 삭제 후, 목록 페이지로 이동
		redirect( $strRedirect );
	}


	function edit()
	{
		$this->load->library("form_validation");

		$data['page_title'] = "구분 수정";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$group_no = $this->_setParamFromUri($data, $arrUri, "group_no");
		$data['group'] = $this->group_model->getGroup($group_no);

		$this->load->view('main_header', $data);
		$this->load->view('group_edit', $data);
		$this->load->view('main_footer', $data);
	}


	function index()
	{
		$this->list();
	}


	function insert()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules("group_name", "이름", "required|max_length[20]");
		$this->form_validation->set_rules("parent_no", "상위번호", "required|max_length[20]");
		$this->form_validation->set_rules("level", "단계", "required|max_length[20]");

		$arrUri = $this->uri->uri_to_assoc();
		$name = $this->_setParamFromUri($data, $arrUri, "name");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "구분 추가";
			$this->load->view('main_header', $data);
			$this->load->view('group_add', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$group = array(
				'group_name' => $this->input->post_get("group_name", true)
				, 'parent_no' => $this->input->post_get("parent_no", true)
				, 'level' => $this->input->post_get("level", true)
				, 'order_no' => $this->input->post_get("order_no", true)
			);

			$this->group_model->insertGroup($group);

			$strRedirect = "/group/list";
			if (isset($name))
				$strRedirect .= "/name/{$name}";
			if (isset($page))
				$strRedirect .= "/page/{$page}";
	
			// 구분 추가 후, 목록 페이지로 이동
			redirect( $strRedirect );
		}
	}


	function list()
	{
		$data['page_title'] = "구분 목록";

		$arrUri = $this->uri->uri_to_assoc();
		if ($name = $this->_setParamFromUri($data, $arrUri, "name"))
		{
			$config['base_url'] = "/group/list/name/{$name}/page/";
			$config['uri_segment'] = 6;
		}
		else
		{
			$config['base_url'] = '/group/list/page/';
			$config['uri_segment'] = 4;
		}
		$page = $this->_setParamFromUri($data, $arrUri, "page");

		$data['groups'] = $this->group_model->getGroups($name, $page);
		$config['total_rows'] = $this->group_model->getGroupsCount($name);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('main_header', $data);
		$this->load->view('group_list', $data);
		$this->load->view('main_footer', $data);
	}


	function view()
	{
		$data['page_title'] = "구분 정보";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$group_no = $this->_setParamFromUri($data, $arrUri, "group_no");
		$data['group'] = $this->group_model->getGroup($group_no);

		$this->load->view('main_header', $data);
		$this->load->view('group_view', $data);
		$this->load->view('main_footer', $data);
	}


	function update()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules("group_name", "이름", "required|max_length[20]");
		$this->form_validation->set_rules("parent_no", "상위번호", "required|max_length[20]");
		$this->form_validation->set_rules("level", "단계", "required|max_length[20]");

		$data['page_title'] = "구분 수정";
		$arrUri = $this->uri->uri_to_assoc();
		$group_no = $this->_setParamFromUri($data, $arrUri, "group_no");
		$name = $this->_setParamFromUri($data, $arrUri, "name");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['group'] = $this->group_model->getGroup($group_no);

			$this->load->view('main_header', $data);
			$this->load->view('group_edit', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$group = array(
				'group_name' => $this->input->post_get("group_name", true)
				, 'parent_no' => $this->input->post_get("parent_no", true)
				, 'level' => $this->input->post_get("level", true)
				, 'order_no' => $this->input->post_get("order_no", true)
			);

			$this->group_model->updateGroup($group_no, $group);

			$strUri = "/group/list";
			if (isset($name))
			  $strUri .= "/name/{$name}";
			if (isset($page))
			  $strUri .= "/page/{$page}";

			  // 구분 추가 후, 목록 페이지로 이동
			redirect( $strUri );
		}
	}
}
?>