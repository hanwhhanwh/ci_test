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


use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


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


	function donut()
	{
		$data['page_title'] = "구분별 분포도";

        $arrUri = $this->uri->uri_to_assoc();
        $start_date = $this->_setParamFromUri($data, $arrUri, "start_date");
        $end_date = $this->_setParamFromUri($data, $arrUri, "end_date");
		if ( !isset($start_date) )
		{
			$start_date = date("Y-m-d", strtotime(" -15 day"));
			$data['start_date'] = $start_date;
		}
		if ( !isset($end_date) )
		{
			$end_date = date("Y-m-d");
			$data['end_date'] = $end_date;
		}

		$data['ledgers'] = $this->ledger_model->getDonutLedgers($start_date, $end_date);

		$this->load->view('main_header', $data);
		$this->load->view('ledger_donut', $data);
		$this->load->view('main_footer', $data);
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


	function excel()
	{
        $arrUri = $this->uri->uri_to_assoc();
        $date = $this->_setParamFromUri($data, $arrUri, "date");
        $class = $this->_setParamFromUri($data, $arrUri, "class");
		$page_title = "장부 목록";
        if ( isset($class) && (($class > 0) && ($class <= 2)) )
		{
			if ($class == 1)
				$page_title = "장부 목록 - 매입";
			else
				$page_title = "장부 목록 - 매출";
		}

		$ledgers = $this->ledger_model->getLedgers($class, $date);

		require 'vendor/autoload.php';
		
		$helper = new Sample();
		if ($helper->isCli()) {
			$helper->log('This example should only be run from a Web Browser' . PHP_EOL);
		
			return;
		}
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		
		// Set document properties
		$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
			->setLastModifiedBy('Maarten Balliauw')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
			->setKeywords('office 2007 openxml php')
			->setCategory('Test result file');
		
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);

		$spreadsheet->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A2:J2')->getFill()->getStartColor()->setARGB(Color::COLOR_YELLOW);

		// Header row
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', $page_title)
			->setCellValue('A2', '번호')
			->setCellValue('B2', '구분')
			->setCellValue('C2', '날짜')
			->setCellValue('D2', '상품명')
			->setCellValue('E2', '단가')
			->setCellValue('F2', '매입수량')
			->setCellValue('G2', '매입금액')
			->setCellValue('H2', '매출수량')
			->setCellValue('I2', '매출금액')
			->setCellValue('J2', '비고');
		
		// 
		$row_index = 3;
		while ( $ledgers && ( $ledger = $ledgers->unbuffered_row() ) )
		{
			if ( $ledger->class == 1 )
				$class_name = "매입";
			else
				$class_name = "매출";

			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue("A{$row_index}", "{$ledger->ledger_no}")
				->setCellValue("B{$row_index}", "{$class_name}")
				->setCellValue("C{$row_index}", "{$ledger->ledger_date}")
				->setCellValue("D{$row_index}", "{$ledger->product_name}")
				->setCellValue("E{$row_index}", "{$ledger->per_price}")
				->setCellValue("F{$row_index}", "{$ledger->buy_count}")
				->setCellValue("G{$row_index}", "{$ledger->buy_price}")
				->setCellValue("H{$row_index}", "{$ledger->sale_count}")
				->setCellValue("I{$row_index}", "{$ledger->sale_price}")
				->setCellValue("J{$row_index}", "{$ledger->note}");
			$row_index ++;
		}
		
		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('장부 목록');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ledger.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
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


	function month()
	{
		$data['page_title'] = "월별제품별 매출현황";

        $arrUri = $this->uri->uri_to_assoc();
        $base_url = "/ledger/month";
        $uri_segment = 4;
        $year = $this->_setParamFromUri($data, $arrUri, "year");
        if ( isset($year) )
        {
			$base_url .= "/year/{$year}";
            $uri_segment += 2;
		}
		$page = $this->_setParamFromUri($data, $arrUri, "page");
    	$base_url .= "/page";
        $config['base_url'] = $base_url;
        $config['uri_segment'] = $uri_segment;

		$data['ledgers'] = $this->ledger_model->getMonthlyLedgers($year, $page);
		$config['total_rows'] = $this->ledger_model->getMonthlyLedgersCount($year);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('main_header', $data);
		$this->load->view('ledger_month', $data);
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