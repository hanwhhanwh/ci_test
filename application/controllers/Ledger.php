<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ledger controller class ; 매입/매출 장부 클래스
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		hanwh
 * @email		hbesthee@naver.com
 * 
 * @file		Ledger.php
 * @version		1.0.0
 * @date		2018-11-05
 */
 
// --------------------------------------------------------------------------

class Ledger extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('ledger_model');
		$this->load->helper(array("date", "url"));
        $this->load->library("pagination");
        date_default_timezone_set("Asia/Seoul");
        $today = date("Y-m-d");
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

		$data['page_title'] = "장부 추가";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "class");
		$this->_setParamFromUri($data, $arrUri, "date");
		$this->_setParamFromUri($data, $arrUri, "page");
        $data['all_products'] = $this->ledger_model->getAllProducts();

		$this->load->view('main_header', $data);
		$this->load->view('ledger_add', $data);
		$this->load->view('main_footer', $data);
	}


	function delete()
	{
		$arrUri = $this->uri->uri_to_assoc();
		$class = $this->_setParamFromUri($data, $arrUri, "class");
		$date = $this->_setParamFromUri($data, $arrUri, "date");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
		$ledger_no = $this->_setParamFromUri($data, $arrUri, "ledger_no");
		$this->ledger_model->deleteLedger($ledger_no);

		$strRedirect = "/ledger/list";
		if (isset($date))
			$strRedirect .= "/date/{$date}";
		if (isset($page))
			$strRedirect .= "/page/{$page}";

		// 장부 삭제 후, 목록 페이지로 이동
		redirect( $strRedirect );
	}


    function do_upload(&$arrData)
    {
        $config['upload_path']          = './images/ledgers/'; // "./"로 시작하는 경로 지정. DOCUMENT_ROOT 부터 상대 경로임
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100; // 업로드 파일의 최대 크기 (KB)
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['overwirte']            = TRUE;

        $this->load->library("upload");
        // Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
        $this->upload->initialize($config);

        if ( $this->upload->do_upload('ledger_image') )
        {
            $arrData['ledger_image'] = $this->upload->data();
            print_r($arrData);
            return TRUE;
        }
        print_r( $this->upload->data() );
        return FALSE;
    }


    function edit()
	{
		$this->load->library("form_validation");

		$data['page_title'] = "장부 수정";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "date");
		$this->_setParamFromUri($data, $arrUri, "page");
		$ledger_no = $this->_setParamFromUri($data, $arrUri, "ledger_no");
		$data['ledger'] = $this->ledger_model->getLedger($ledger_no);
		$data['all_products'] = $this->ledger_model->getAllProducts();

		$this->load->view('main_header', $data);
		$this->load->view('ledger_edit', $data);
		$this->load->view('main_footer', $data);
	}


	function index()
	{
		$this->list();
	}


	function insert()
	{
        $this->load->library("form_validation");

		$this->form_validation->set_rules("product_no", "상품명", "required|max_length[20]");
		$this->form_validation->set_rules("per_price", "단가", "required|max_length[20]");

		$arrUri = $this->uri->uri_to_assoc();
		$class = $this->_setParamFromUri($data, $arrUri, "class");
		$date = $this->_setParamFromUri($data, $arrUri, "date");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
        $data['class'] = $class;
        $data['date'] = $date;
        $data['page'] = $page;
        if ($this->form_validation->run() == FALSE)
		{
			$data['all_products'] = $this->ledger_model->getAllProducts();

			$data['page_title'] = "장부 추가";

            $this->load->view('main_header', $data);
			$this->load->view('ledger_add', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$ledger = array(
				'ledger_date' => $this->input->post_get("ledger_date", true)
				, 'class' => $this->input->post_get("class", true)
				, 'product_no' => $this->input->post_get("product_no", true)
				, 'per_price' => $this->input->post_get("per_price", true)
				, 'buy_count' => $this->input->post_get("buy_count", true)
				, 'buy_price' => $this->input->post_get("buy_price", true)
				, 'sale_count' => $this->input->post_get("sale_count", true)
				, 'sale_price' => $this->input->post_get("sale_price", true)
				, 'note' => $this->input->post_get("note", true)
            );
            
            if ( $ledger["class"] == 1 )
                $this->ledger_model->insertInLedger($ledger);
            else
                $this->ledger_model->insertOutLedger($ledger);

			$strRedirect = "/ledger/list";
            if ( isset($class) && (($class > 0) && ($class <= 2)) )
                $strRedirect .= "/class/{$class}";
            if (isset($date))
				$strRedirect .= "/date/{$date}";
			if (isset($page))
				$strRedirect .= "/page/{$page}";
	
			// 장부 추가 후, 목록 페이지로 이동
			redirect( $strRedirect );
		}
	}


	function list()
	{
		$data['page_title'] = "장부 목록";

        $arrUri = $this->uri->uri_to_assoc();
        $base_url = "/ledger/list";
        $uri_segment = 4;
        $date = $this->_setParamFromUri($data, $arrUri, "date");
        $class = $this->_setParamFromUri($data, $arrUri, "class");
        if ( isset($date) )
        {
			$base_url .= "/date/{$date}";
            $uri_segment += 2;
		}
        if ( isset($class) )
		{
            if ( (($class > 0) && ($class <= 2)) )
            {
                $base_url .= "/class/{$class}";
                if ($class == 1)
                    $data['page_title'] = "장부 목록 - 매입";
                else
                    $data['page_title'] = "장부 목록 - 매출";
            }
            $uri_segment += 2;
		}
		$page = $this->_setParamFromUri($data, $arrUri, "page");
    	$base_url .= "/page";
        $config['base_url'] = $base_url;
        $config['uri_segment'] = $uri_segment;

		$data['ledgers'] = $this->ledger_model->getLedgers($class, $date, $page);
		$config['total_rows'] = $this->ledger_model->getLedgersCount($class, $date);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('main_header', $data);
		$this->load->view('ledger_list', $data);
		$this->load->view('main_footer', $data);
	}


	function search()
	{
		$data['page_title'] = "장부 기간조회 목록";

        $arrUri = $this->uri->uri_to_assoc();
        $base_url = "/ledger/search";
        $uri_segment = 4;
        $start_date = $this->_setParamFromUri($data, $arrUri, "start_date");
        $end_date = $this->_setParamFromUri($data, $arrUri, "end_date");
        $product_no = $this->_setParamFromUri($data, $arrUri, "product_no");
        $class = $this->_setParamFromUri($data, $arrUri, "class");
        if ( isset($start_date) )
        {
			$base_url .= "/start_date/{$start_date}";
            $uri_segment += 2;
		}
        if ( isset($end_date) )
        {
			$base_url .= "/end_date/{$end_date}";
            $uri_segment += 2;
		}
        if ( isset($product_no) )
        {
            $data["product_name"] = $this->ledger_model->getProductName($product_no);
		}
        if ( isset($class) )
		{
            if ( (($class > 0) && ($class <= 2)) )
            {
                $base_url .= "/class/{$class}";
                if ($class == 1)
                    $data['page_title'] = "장부 기간조회 목록 - 매입";
                else
                    $data['page_title'] = "장부 기간조회 목록 - 매출";
            }
            $uri_segment += 2;
		}
		$page = $this->_setParamFromUri($data, $arrUri, "page");
    	$base_url .= "/page";
        $config['base_url'] = $base_url;
        $config['uri_segment'] = $uri_segment;

		$data['ledgers'] = $this->ledger_model->searchLedgers($class, $start_date, $end_date, $product_no, $page);
		$config['total_rows'] = $this->ledger_model->searchLedgersCount($class, $start_date, $end_date, $product_no);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('main_header', $data);
		$this->load->view('ledger_search', $data);
		$this->load->view('main_footer', $data);
	}


	function update()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules("product_no", "상품명", "required|max_length[20]");
		$this->form_validation->set_rules("per_price", "단가", "required|max_length[20]");

		$data['page_title'] = "장부 수정";
		$arrUri = $this->uri->uri_to_assoc();
		$ledger_no = $this->_setParamFromUri($data, $arrUri, "ledger_no");
		$class = $this->_setParamFromUri($data, $arrUri, "class");
		$date = $this->_setParamFromUri($data, $arrUri, "date");
		$page = $this->_setParamFromUri($data, $arrUri, "page");
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['ledger'] = $this->ledger_model->getLedger($ledger_no);
			$data['all_products'] = $this->ledger_model->getAllProducts();

			$this->load->view('main_header', $data);
			$this->load->view('ledger_edit', $data);
			$this->load->view('main_footer', $data);
		}
		else
		{
			$ledger = array(
				'ledger_date' => $this->input->post_get("ledger_date", true)
				, 'class' => $this->input->post_get("class", true)
				, 'product_no' => $this->input->post_get("product_no", true)
				, 'per_price' => $this->input->post_get("per_price", true)
				, 'buy_count' => $this->input->post_get("buy_count", true)
				, 'buy_price' => $this->input->post_get("buy_price", true)
				, 'sale_count' => $this->input->post_get("sale_count", true)
				, 'sale_price' => $this->input->post_get("sale_price", true)
				, 'note' => $this->input->post_get("note", true)
			);

            if ($ledger["class"] == 1)
                $this->ledger_model->updateInLedger($ledger_no, $ledger);
            else
                $this->ledger_model->updateOutLedger($ledger_no, $ledger);

			$strUri = "/ledger/list";
            if (isset($class))
			    $strUri .= "/class/{$class}";
			if (isset($date))
			    $strUri .= "/date/{$date}";
			if (isset($page))
			    $strUri .= "/page/{$page}";

			  // 장부 추가 후, 목록 페이지로 이동
			redirect( $strUri );
		}
	}


    function view()
	{
		$data['page_title'] = "장부";

		$arrUri = $this->uri->uri_to_assoc();
		$this->_setParamFromUri($data, $arrUri, "name");
		$this->_setParamFromUri($data, $arrUri, "page");
		$ledger_no = $this->_setParamFromUri($data, $arrUri, "ledger_no");
		$data['ledger'] = $this->ledger_model->getLedger($ledger_no);

		$this->load->view('main_header', $data);
		$this->load->view('ledger_view', $data);
		$this->load->view('main_footer', $data);
	}
}
?>