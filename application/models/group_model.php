<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Group model class
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		hanwh
 * @email		hbesthee@naver.com
 * 
 * @file		Group_model.php
 * @version		1.0.0
 * @date		2018-11-01
 */
 
// --------------------------------------------------------------------------

class Group_model extends CI_Model {

    public function __construct()
    {
        // 모델 생성자 호출
        parent::__construct();
    }


	function deleteGroup($group_no)
    {
		$sql = "DELETE FROM `GROUP` WHERE group_no = {$group_no};";
		$this->db->query($sql);
    }


	function getGroup($group_no)
    {
		$sql = "SELECT group_no, group_name, parent_no, `level`, order_no, mod_date FROM `GROUP` WHERE group_no = {$group_no};";
		$result = $this->db->query($sql);
        
        return $result->unbuffered_row();
    }


    function getGroups($name, $page = 1)
    {
        if (isset($page) && ($page > 0))
            $start = ($page - 1) * PG_PER_PAGE;
        else
            $start = 0;
        $per_page = PG_PER_PAGE;
        if (isset($name) && (trim($name) != ""))
            $sql = "SELECT group_no, group_name, parent_no, `level`, order_no, mod_date FROM `GROUP` WHERE group_name LIKE '%{$name}%' ORDER BY group_no LIMIT {$start}, {$per_page};";
        else
		    $sql = "SELECT group_no, group_name, parent_no, `level`, order_no, mod_date FROM `GROUP` ORDER BY group_no LIMIT {$start}, {$per_page};";
		$result = $this->db->query($sql);
        
        if ($result->num_rows() > 0)
        {
            return $result;
        }
		else
		{
            show_error('Group is empty!');
        }
    }


    function getGroupsCount($name)
    {
        if (isset($name) && (trim($name) != ""))
            $sql = "SELECT COUNT(1) AS group_count FROM `GROUP` WHERE group_name LIKE '%{$name}%';";
        else
		    $sql = "SELECT COUNT(1) AS group_count FROM `GROUP`;";
		$result = $this->db->query($sql);
        $row = $result->unbuffered_row();
        if (isset($row))
            return $row->group_count;
		else
            return 0;
    }


	function insertGroup($group)
    {
		$sql = "INSERT INTO `GROUP` 
	( `group_name`, `parent_no`, `level`, `order_no` )
VALUES
	( '{$group["group_name"]}', {$group["parent_no"]}, {$group["level"]}, {$group["order_no"]} );";

		$this->db->query($sql);
    }


	function updateGroup($group_no, $group)
    {
		$sql = "UPDATE `GROUP` SET 
	group_name = '{$group["group_name"]}'
	, parent_no = {$group["parent_no"]}
	, `level` = {$group["level"]}
	, order_no = {$group["order_no"]}
    , mod_date = CURRENT_TIMESTAMP
WHERE group_no = {$group_no};";

		$this->db->query($sql);
    }


}
?>