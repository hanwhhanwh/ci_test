<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product controller class
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		hanwh
 * @email		hbesthee@naver.com
 * 
 * @file		Product.php
 * @version		1.0.0
 * @date		2018-11-01
 */
 
// --------------------------------------------------------------------------

class Product extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('product_model');
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

		$data['page_title'] = "상품 추가";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$data['all_groups'] = $this->product_model->getAllGroups();

		$this->load->view('main_header', $data);
		$this->load->view('product_add', $data);
		$this->load->view('main_footer', $data);
	}


	function delete()
	{
		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$product_no = $this->_setParamFromUri($data, $arrUri, "product_no");
		$this->product_model->deleteProduct($product_no);

		$strRedirect = "/product/list";
		if (isset($name))
			$strRedirect .= "/name/{$name}";
		if (isset($page))
			$strRedirect .= "/page/{$page}";

		// 상품 삭제 후, 목록 페이지로 이동
		redirect( $strRedirect );
	}


    function do_upload(&$arrData)
    {
        $config['upload_path']          = './images/products/'; // "./"로 시작하는 경로 지정. DOCUMENT_ROOT 부터 상대 경로임
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100; // 업로드 파일의 최대 크기 (KB)
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['overwirte']            = TRUE;

        $this->load->library("upload");
        // Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
        $this->upload->initialize($config);

        if ( $this->upload->do_upload('product_image') )
        {
            $arrData['product_image'] = $this->upload->data();
            print_r($arrData);
            return TRUE;
        }
        print_r( $this->upload->data() );
        return FALSE;
    }


    function edit()
	{
		$this->load->library("form_validation");

		$data['page_title'] = "상품 수정";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$product_no = $this->_setParamFromUri($data, $arrUri, "product_no");
		$data['product'] = $this->product_model->getProduct($product_no);
		$data['all_groups'] = $this->product_model->getAllGroups();

		$this->load->view('main_header', $data);
		$this->load->view('product_edit', $data);
		$this->load->view('main_footer', $data);
	}


	function find()
	{
		$data['page_title'] = "상품 검색";

		$arrUri = $this->uri->uri_to_assoc();
		if ($name = $this->_setParamFromUri($data, $arrUri, "name"))
		{
			$config['base_url'] = "/product/find/name/{$name}/page/";
			$config['uri_segment'] = 6;
		}
		else
		{
			$config['base_url'] = '/product/find/page/';
			$config['uri_segment'] = 4;
		}
		$page = $this->_setParamFromUri($data, $arrUri, "page");

		$data['products'] = $this->product_model->getProducts($name, $page);
		$config['total_rows'] = $this->product_model->getProductsCount($name);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('main_header_only', $data);
		$this->load->view('find_product_list', $data);
		$this->load->view('main_footer', $data);
	}


	function index()
	{
		$this->list();
	}


	function insert()
	{
        $this->load->library("form_validation");

		$this->form_validation->set_rules("product_name", "상품명", "required|max_length[20]");
		$this->form_validation->set_rules("group_no", "상품종류", "required|max_length[20]");
		$this->form_validation->set_rules("per_price", "단가", "required|max_length[20]");

		$arrUri = $this->uri->uri_to_assoc();
		$name = $this->_setParamFromUri($data, $arrUri, "name");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['all_groups'] = $this->product_model->getAllGroups();

			$data['page_title'] = "상품 추가";
			$this->load->view('main_header', $data);
			$this->load->view('product_add', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$product = array(
				'product_name' => $this->input->post_get("product_name", true)
				, 'group_no' => $this->input->post_get("group_no", true)
				, 'per_price' => $this->input->post_get("per_price", true)
				, 'stock_count' => $this->input->post_get("stock_count", true)
            );
            
            if ($this->do_upload($data))
            {
				$product['product_image_path'] = $data["upload_data"]["file_name"];
            }
            else
                $product['product_image_path'] = null;

			$this->product_model->insertProduct($product);

			$strRedirect = "/product/list";
			if (isset($name))
				$strRedirect .= "/name/{$name}";
			if (isset($page))
				$strRedirect .= "/page/{$page}";
	
			// 상품 추가 후, 목록 페이지로 이동
			//redirect( $strRedirect );
		}
	}


	function list()
	{
		$data['page_title'] = "상품 목록";

		$arrUri = $this->uri->uri_to_assoc();
		if ($name = $this->_setParamFromUri($data, $arrUri, "name"))
		{
			$config['base_url'] = "/product/list/name/{$name}/page/";
			$config['uri_segment'] = 6;
		}
		else
		{
			$config['base_url'] = '/product/list/page/';
			$config['uri_segment'] = 4;
		}
		$page = $this->_setParamFromUri($data, $arrUri, "page");

		$data['products'] = $this->product_model->getProducts($name, $page);
		$config['total_rows'] = $this->product_model->getProductsCount($name);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('main_header', $data);
		$this->load->view('product_list', $data);
		$this->load->view('main_footer', $data);
	}


	function view()
	{
		$data['page_title'] = "상품 정보";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$product_no = $this->_setParamFromUri($data, $arrUri, "product_no");
		$data['product'] = $this->product_model->getProduct($product_no);

		$this->load->view('main_header', $data);
		$this->load->view('product_view', $data);
		$this->load->view('main_footer', $data);
	}


	function update()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules("product_name", "상품명", "required|max_length[20]");
		$this->form_validation->set_rules("group_no", "상품종류", "required|max_length[20]");
		$this->form_validation->set_rules("per_price", "단가", "required|max_length[20]");

		$data['page_title'] = "상품 수정";
		$arrUri = $this->uri->uri_to_assoc();
		$product_no = $this->_setParamFromUri($data, $arrUri, "product_no");
		$name = $this->_setParamFromUri($data, $arrUri, "name");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['product'] = $this->product_model->getProduct($product_no);
			$data['all_groups'] = $this->product_model->getAllGroups();

			$this->load->view('main_header', $data);
			$this->load->view('product_edit', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$product = array(
				'product_name' => $this->input->post_get("product_name", true)
				, 'group_no' => $this->input->post_get("group_no", true)
				, 'per_price' => $this->input->post_get("per_price", true)
				, 'stock_count' => $this->input->post_get("stock_count", true)
				, 'product_image_path' => $this->input->post_get("product_image_path", true)
			);

			$this->product_model->updateProduct($product_no, $product);

			$strUri = "/product/list";
			if (isset($name))
			  $strUri .= "/name/{$name}";
			if (isset($page))
			  $strUri .= "/page/{$page}";

			  // 상품 추가 후, 목록 페이지로 이동
			redirect( $strUri );
		}
	}
}
?>