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
            $sql = "SELECT product_no, group_no, product_name, `per_price`, `stock_count`, `product_image_path`, mod_date FROM `PRODUCT` WHERE product_name LIKE '%{$name}%' ORDER BY product_no LIMIT {$start}, {$per_page};";
        else
		    $sql = "SELECT product_no, group_no, product_name, `per_price`, `stock_count`, `product_image_path`, mod_date FROM `PRODUCT` ORDER BY product_no LIMIT {$start}, {$per_page};";
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