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