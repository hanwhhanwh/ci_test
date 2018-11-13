<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ledger model class ; 장부 정보
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		hanwh
 * @email		hbesthee@naver.com
 * 
 * @file		Ledger_model.php
 * @version		1.0.0
 * @date		2018-11-05
 */
 
// --------------------------------------------------------------------------

class Ledger_model extends CI_Model {

    public function __construct()
    {
        // 모델 생성자 호출
        parent::__construct();
    }


	function deleteLedger($ledger_no)
    {
		$sql = "
DELETE FROM `LEDGER`
WHERE 1 = 1
    AND ledger_no = {$ledger_no}
;";
		$this->db->query($sql);
    }


    function getAllProducts()
    {
        $sql = "
SELECT
    product_no, product_name, group_no, per_price
FROM `PRODUCT`
ORDER BY product_name
;";
		$result = $this->db->query($sql);
        
        return $result;
    }


    function getDonutLedgers($start_date, $end_date)
    {
        $date_condition = "";
        if (isset($start_date) && (trim($start_date) != ""))
            $date_condition = "AND ledger_date BETWEEN '{$start_date}' AND '{$end_date}'";

        $sql = "
SELECT
    L.ledger_no, P.product_name, COUNT(sale_count) AS total_sale_number, SUM(sale_count) AS total_sale_count, SUM(sale_price) AS total_sale_price
FROM `LEDGER` AS L
	JOIN `PRODUCT` AS P ON P.product_no = L.product_no
WHERE 1 = 1
	AND L.`class` = 2
    {$date_condition}
GROUP BY L.product_no, P.product_name
ORDER BY 3 DESC, 5 DESC, 4 DESC
;";

        $result = $this->db->query($sql);
        return $result;
    }


    function getMonthlyLedgers($year, $page = 1)
    {
        if (isset($page) && ($page > 0))
            $start = ($page - 1) * PG_PER_PAGE;
        else
            $start = 0;
        $per_page = PG_PER_PAGE;
        $year_condition = ""; $current_year = (int)date("Y");
		if ( !( isset($year) && ($year > 1950) && ($year <= $current_year) ) )
			$year = $current_year;
		$year_condition = "AND ledger_date BETWEEN '{$year}-01-01' AND '{$year}-12-31'";

        $sql = "
SELECT
	P.product_name
	, L.*
FROM (
		SELECT
			product_no
			, COUNT(sale_count) AS total_sale_number, SUM(sale_count) AS total_sale_count, SUM(sale_price) AS total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 1 , sale_count, NULL)) AS m1_sale_number, SUM(IF(MONTH(ledger_date) = 1,  sale_count, 0)) AS m1_total_sale_count, SUM(IF(MONTH(ledger_date) = 1,  sale_price, 0)) AS m1_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 2 , sale_count, NULL)) AS m2_sale_number, SUM(IF(MONTH(ledger_date) = 2,  sale_count, 0)) AS m2_total_sale_count, SUM(IF(MONTH(ledger_date) = 2,  sale_price, 0)) AS m2_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 3 , sale_count, NULL)) AS m3_sale_number, SUM(IF(MONTH(ledger_date) = 3,  sale_count, 0)) AS m3_total_sale_count, SUM(IF(MONTH(ledger_date) = 3,  sale_price, 0)) AS m3_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 4 , sale_count, NULL)) AS m4_sale_number, SUM(IF(MONTH(ledger_date) = 4,  sale_count, 0)) AS m4_total_sale_count, SUM(IF(MONTH(ledger_date) = 4,  sale_price, 0)) AS m4_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 5 , sale_count, NULL)) AS m5_sale_number, SUM(IF(MONTH(ledger_date) = 5,  sale_count, 0)) AS m5_total_sale_count, SUM(IF(MONTH(ledger_date) = 5,  sale_price, 0)) AS m5_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 6 , sale_count, NULL)) AS m6_sale_number, SUM(IF(MONTH(ledger_date) = 6,  sale_count, 0)) AS m6_total_sale_count, SUM(IF(MONTH(ledger_date) = 6,  sale_price, 0)) AS m6_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 7 , sale_count, NULL)) AS m7_sale_number, SUM(IF(MONTH(ledger_date) = 7,  sale_count, 0)) AS m7_total_sale_count, SUM(IF(MONTH(ledger_date) = 7,  sale_price, 0)) AS m7_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 8 , sale_count, NULL)) AS m8_sale_number, SUM(IF(MONTH(ledger_date) = 8,  sale_count, 0)) AS m8_total_sale_count, SUM(IF(MONTH(ledger_date) = 8,  sale_price, 0)) AS m8_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 9 , sale_count, NULL)) AS m9_sale_number, SUM(IF(MONTH(ledger_date) = 9,  sale_count, 0)) AS m9_total_sale_count, SUM(IF(MONTH(ledger_date) = 9,  sale_price, 0)) AS m9_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 10, sale_count, NULL)) AS m10_sale_number, SUM(IF(MONTH(ledger_date) = 10, sale_count, 0)) AS m10_total_sale_count, SUM(IF(MONTH(ledger_date) = 10, sale_price, 0)) AS m10_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 11, sale_count, NULL)) AS m11_sale_number, SUM(IF(MONTH(ledger_date) = 11, sale_count, 0)) AS m11_total_sale_count, SUM(IF(MONTH(ledger_date) = 11, sale_price, 0)) AS m11_total_sale_price
			, COUNT(IF(MONTH(ledger_date) = 12, sale_count, NULL)) AS m12_sale_number, SUM(IF(MONTH(ledger_date) = 12, sale_count, 0)) AS m12_total_sale_count, SUM(IF(MONTH(ledger_date) = 12, sale_price, 0)) AS m12_total_sale_price
		FROM `LEDGER` AS L
		WHERE 1 = 1
			{$year_condition}
		GROUP BY product_no
		HAVING total_sale_number IS NOT NULL
	) AS L
	INNER JOIN `PRODUCT` AS P ON P.product_no = L.product_no
WHERE 1 = 1
ORDER BY 3 DESC, 5 DESC, 4 DESC LIMIT {$start}, {$per_page};";

        $result = $this->db->query($sql);
        return $result;
    }


    function getMonthlyLedgersCount($year)
    {
        $year_condition = "";
        if ( isset($year) && ($year > 1950) )
			$year_condition = "AND ledger_date BETWEEN '{$year}-01-01' AND '{$year}-12-31'";
		else
			return null;

        $sql = "
SELECT
	COUNT(product_no) AS ledger_count
FROM (
	SELECT
		product_no, SUM(sale_count) AS total_sale_count
	FROM `LEDGER` AS L
	WHERE 1 = 1
		{$year_condition}
	GROUP BY product_no
	HAVING total_sale_count IS NOT NULL
	) L
;";

        $result = $this->db->query($sql);
        $row = $result->unbuffered_row();
        if (isset($row))
            return $row->ledger_count;
		else
            return 0;
    }


    function getLedger($ledger_no)
    {
		$sql = "
SELECT
    ledger_no, L.ledger_date, `class`, L.product_no, P.product_name
    , L.`per_price`, buy_count, `sale_count`, buy_price, sale_price
    , note, L.mod_date
FROM `LEDGER` AS L
    JOIN `PRODUCT` AS P ON P.product_no = L.product_no
WHERE 1 = 1
    AND ledger_no = {$ledger_no}
;";
		$result = $this->db->query($sql);
        
        return $result->unbuffered_row();
    }


    function getLedgers($class, $date, $page = 1)
    {
        if (isset($page) && ($page > 0))
            $start = ($page - 1) * PG_PER_PAGE;
        else
            $start = 0;
        $per_page = PG_PER_PAGE;
        $class_condition = ""; $date_condition = "";
        if (isset($class) && ( ($class > 0) && ($class <= 2) ) )
            $class_condition = "AND `class` = {$class}";
        if (isset($date) && (trim($date) != ""))
            $date_condition = "AND ledger_date LIKE '{$date}'";

        $sql = "
SELECT
    ledger_no, L.ledger_date, `class`, L.product_no, product_name
    , L.`per_price`, buy_count, `sale_count`, buy_price, sale_price
    , note
FROM `LEDGER` AS L
    JOIN `PRODUCT` AS P ON P.product_no = L.product_no
WHERE 1 = 1
    {$class_condition}
    {$date_condition}
ORDER BY ledger_date, ledger_no LIMIT {$start}, {$per_page}
;";

        $result = $this->db->query($sql);
        return $result;
    }


    function getLedgersCount($class, $date)
    {
        $class_condition = ""; $date_condition = "";
        if (isset($class) && ( ($class > 0) && ($class <= 2) ) )
            $class_condition = "AND `class` = {$class}";
        if (isset($date) && (trim($date) != ""))
            $date_condition = "AND ledger_date LIKE '{$date}'";

        $sql = "
SELECT
    COUNT(1) AS ledger_count
FROM `LEDGER` AS L
WHERE 1 = 1
    {$class_condition}
    {$date_condition}
;";

        $result = $this->db->query($sql);
        $row = $result->unbuffered_row();
        if (isset($row))
            return $row->ledger_count;
		else
            return 0;
    }


    function getProductName($product_no) 
    {
		$sql = "
SELECT
    P.product_name
FROM `PRODUCT` AS P
WHERE 1 = 1
    AND product_no = {$product_no}
;";
		$result = $this->db->query($sql);

        if ($result)
            return $result->unbuffered_row()->product_name;
        else
            return "";
    }


    function insertInLedger($ledger)
    {
		$sql = "
INSERT INTO `LEDGER` 
	( `class`, ledger_date, product_no, `per_price`, `buy_count`, `buy_price`, sale_count, sale_price, note )
VALUES
    ( 1, '{$ledger["ledger_date"]}', {$ledger["product_no"]}, {$ledger["per_price"]}, {$ledger["buy_count"]}, {$ledger["buy_price"]}, NULL, NULL, '{$ledger["note"]}' )
;";

		$this->db->query($sql);
    }


	function insertOutLedger($ledger)
    {
		$sql = "
INSERT INTO `LEDGER` 
	( class, ledger_date, product_no, `per_price`, sale_count, sale_price, `buy_count`, `buy_price`, note )
VALUES
    ( 2, '{$ledger["ledger_date"]}', {$ledger["product_no"]}, {$ledger["per_price"]}, {$ledger["sale_count"]}, {$ledger["sale_price"]}, NULL, NULL, '{$ledger["note"]}' )
;";

		$this->db->query($sql);
    }


    function searchLedgers($class, $start_date, $end_date, $product_no, $page = 1)
    {
        if (isset($page) && ($page > 0))
            $start = ($page - 1) * PG_PER_PAGE;
        else
            $start = 0;
        $per_page = PG_PER_PAGE;
        $class_condition = ""; $date_condition = ""; $product_condition = "";
        if (isset($class) && ( ($class > 0) && ($class <= 2) ) )
            $class_condition = "AND `class` = {$class}";
        if (isset($start_date) && (trim($start_date) != ""))
            $date_condition = "AND ledger_date BETWEEN '{$start_date}' AND '{$end_date}'";
        if (isset($product_no) && (trim($product_no) != ""))
            $product_condition = "AND L.product_no  = {$product_no}";

        $sql = "
SELECT
    ledger_no, L.ledger_date, `class`, L.product_no, product_name
    , L.`per_price`, buy_count, `sale_count`, buy_price, sale_price
    , note
FROM `LEDGER` AS L
    JOIN `PRODUCT` AS P ON P.product_no = L.product_no
WHERE 1 = 1
    {$class_condition}
    {$date_condition}
    {$product_condition}
ORDER BY ledger_date, ledger_no LIMIT {$start}, {$per_page}
;";

        $result = $this->db->query($sql);
        return $result;
    }


    function searchLedgersCount($class, $start_date, $end_date, $product_no)
    {
        $class_condition = ""; $date_condition = ""; $product_condition = "";
        if (isset($class) && ( ($class > 0) && ($class <= 2) ) )
            $class_condition = "AND `class` = {$class}";
        if (isset($start_date) && (trim($start_date) != ""))
            $date_condition = "AND ledger_date BETWEEN '{$start_date}' AND '{$end_date}'";
        if (isset($product_no) && (trim($product_no) != ""))
            $product_condition = "AND L.product_no  = {$product_no}";

        $sql = "
SELECT
    COUNT(1) AS ledger_count
FROM `LEDGER` AS L
WHERE 1 = 1
    {$class_condition}
    {$date_condition}
    {$product_condition}
;";

        $result = $this->db->query($sql);
        $row = $result->unbuffered_row();
        if (isset($row))
            return $row->ledger_count;
		else
            return 0;
    }


	function updateInLedger($ledger_no, $ledger)
    {
		$sql = "
UPDATE `LEDGER` SET 
	`class` = 1
	, ledger_date = '{$ledger["ledger_date"]}'
	, product_no = {$ledger["product_no"]}
	, per_price = {$ledger["per_price"]}
	, `buy_count` = {$ledger["buy_count"]}
    , `buy_price` = {$ledger["buy_price"]}
    , sale_price = NULL, sale_count = NULL
	, note = '{$ledger["note"]}'
    , mod_date = CURRENT_TIMESTAMP
WHERE 1 = 1
    AND ledger_no = {$ledger_no}
;";

		$this->db->query($sql);
    }


    function updateOutLedger($ledger_no, $ledger)
    {
		$sql = "
UPDATE `LEDGER` SET 
	`class` = 2
	, ledger_date = '{$ledger["ledger_date"]}'
	, product_no = {$ledger["product_no"]}
	, per_price = {$ledger["per_price"]}
	, `sale_price` = {$ledger["sale_price"]}
    , `sale_count` = {$ledger["sale_count"]}
    , buy_count = NULL, buy_price = NULL
	, note = '{$ledger["note"]}'
    , mod_date = CURRENT_TIMESTAMP
WHERE 1 = 1
    AND ledger_no = {$ledger_no}
;";

		$this->db->query($sql);
    }
}
?>