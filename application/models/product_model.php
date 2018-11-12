<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product model class
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		hanwh
 * @email		hbesthee@naver.com
 * 
 * @file		Product_model.php
 * @version		1.0.0
 * @date		2018-11-01
 */
 
// --------------------------------------------------------------------------

class Product_model extends CI_Model {

    public function __construct()
    {
        // 모델 생성자 호출
        parent::__construct();
    }


	function deleteProduct($product_no)
    {
		$sql = "DELETE FROM `PRODUCT` WHERE product_no = {$product_no};";
		$this->db->query($sql);
    }


    function getAllGroups()
    {
        $sql = "SELECT group_no, group_name, parent_no, `level`, order_no, mod_date FROM `GROUP` ORDER BY group_no;";
		$result = $this->db->query($sql);
        
        return $result;
    }


    function getBestProducts($start_date, $end_date, $page = 1)
    {
        if (isset($page) && ($page > 0))
            $start = ($page - 1) * PG_PER_PAGE;
        else
            $start = 0;
        $per_page = PG_PER_PAGE;

        $term_condition = "";
        if ( isset($start_date) && ($start_date != "") && isset($end_date) && ($end_date != "") )
            $term_condition = "AND L.ledger_date BETWEEN '{$start_date}' AND '{$end_date}'";
        $sql = "
SELECT
    L.product_no, P.product_name, L.total_sale_count, L.total_sale_price, L.sales_count
--    , G.group_name, P.`per_price`, P.`stock_count`, P.`product_image_path`, P.mod_date
--    , P.group_no
FROM (
        SELECT
            L.product_no, SUM(sale_count) AS total_sale_count, SUM(sale_price) AS total_sale_price, COUNT(sale_count) AS sales_count
        FROM `LEDGER` AS L
        WHERE 1 = 1
            AND L.sale_count > 0
            {$term_condition}
        GROUP BY L.product_no
    ) AS L
    INNER JOIN `PRODUCT` AS P ON P.product_no = L.product_no
    INNER JOIN `GROUP` AS G ON G.group_no = P.group_no
ORDER BY 5 DESC, 4 DESC LIMIT {$start}, {$per_page};";
		$result = $this->db->query($sql);
        
        return $result;
    }


    function getBestProductsCount($start_date, $end_date)
    {
        $term_condition = "";
        if ( isset($start_date) && ($start_date != "") && isset($end_date) && ($end_date != "") )
            $term_condition = "AND L.ledger_date BETWEEN '{$start_date}' AND '{$end_date}'";
        $sql = "
SELECT
    COUNT(1) AS best_products_count
FROM (
        SELECT
            L.product_no
        FROM `LEDGER` AS L
        WHERE 1 = 1
            AND L.sale_count > 0
            {$term_condition}
        GROUP BY L.product_no
    ) AS L;";
		$result = $this->db->query($sql);
        
        if ( $result )
        {
            $row = $result->unbuffered_row();
            return $row->best_products_count;
        }
        else
            return 0;
    }


    function getProduct($product_no)
    {
		$sql = "SELECT product_no, group_no, product_name, `per_price`, `stock_count`, `product_image_path`, mod_date FROM `PRODUCT` WHERE product_no = {$product_no};";
		$result = $this->db->query($sql);
        
        return $result->unbuffered_row();
    }


    function getProducts($name, $page = 1)
    {
        if (isset($page) && ($page > 0))
            $start = ($page - 1) * PG_PER_PAGE;
        else
            $start = 0;
        $per_page = PG_PER_PAGE;
        if (isset($name) && (trim($name) != ""))
            $sql = "
SELECT
    product_no, G.group_name, product_name, `per_price`, `stock_count`
    , `product_image_path`, P.mod_date, P.group_no
FROM `PRODUCT` AS P
    JOIN `GROUP` AS G
        ON G.group_no = P.group_no
WHERE 1 = 1
    AND product_name LIKE '%{$name}%'
ORDER BY product_no LIMIT {$start}, {$per_page};";
        else
		    $sql = "
SELECT
    product_no, group_name, product_name, `per_price`, `stock_count`
    , `product_image_path`, P.mod_date, P.group_no
FROM `PRODUCT` AS P
    JOIN `GROUP` AS G
        ON G.group_no = P.group_no
ORDER BY product_no LIMIT {$start}, {$per_page};";
		$result = $this->db->query($sql);
        
        if ($result->num_rows() > 0)
        {
            return $result;
        }
		else
		{
            show_error('Product is empty!');
        }
    }


    function getProductsCount($name)
    {
        if (isset($name) && (trim($name) != ""))
            $sql = "SELECT COUNT(1) AS product_count FROM `PRODUCT` WHERE product_name LIKE '%{$name}%';";
        else
		    $sql = "SELECT COUNT(1) AS product_count FROM `PRODUCT`;";
		$result = $this->db->query($sql);
        $row = $result->unbuffered_row();
        if (isset($row))
            return $row->product_count;
		else
            return 0;
    }


	function insertProduct($product)
    {
		$sql = "INSERT INTO `PRODUCT` 
	( group_no, product_name, `per_price`, `stock_count`, `product_image_path` )
VALUES
	( {$product["group_no"]}, '{$product["product_name"]}', {$product["per_price"]}, {$product["stock_count"]}, '{$product["product_image_path"]}' );";

		$this->db->query($sql);
    }


	function updateProduct($product_no, $product)
    {
		$sql = "UPDATE `PRODUCT` SET 
	group_no = {$product["group_no"]}
	, product_name = '{$product["product_name"]}'
	, per_price = {$product["per_price"]}
	, `stock_count` = {$product["stock_count"]}
	, product_image_path = '{$product["product_image_path"]}'
    , mod_date = CURRENT_TIMESTAMP
WHERE product_no = {$product_no};";

		$this->db->query($sql);
    }
}
?>