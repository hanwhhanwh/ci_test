<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

    public function __construct()
    {
        // 모델 생성자 호출
        parent::__construct();
    }


	function deleteMember($num)
    {
		$sql = "DELETE FROM `MEMBER` WHERE num = {$num};";
		$this->db->query($sql);
    }


	function getMember($num)
    {
		$sql = "SELECT num, user_name, user_id, passwd, tel, rank FROM member WHERE num = {$num};";
		$result = $this->db->query($sql);
        
        return $result->unbuffered_row();
    }


    function getMembers($name, $page = 1)
    {
        if (isset($page) && ($page > 0))
            $start = ($page - 1) * PG_PER_PAGE;
        else
            $start = 0;
        $per_page = PG_PER_PAGE;
        if (isset($name) && (trim($name) != ""))
            $sql = "SELECT num, user_name, user_id, passwd, tel, rank FROM member WHERE user_name LIKE '%{$name}%' ORDER BY num LIMIT {$start}, {$per_page};";
        else
		    $sql = "SELECT num, user_name, user_id, passwd, tel, rank FROM member ORDER BY num LIMIT {$start}, {$per_page};";
		$result = $this->db->query($sql);
        
        if ($result->num_rows() > 0)
        {
            return $result;
        }
		else
		{
            show_error('Member is empty!');
        }
    }


    function getMembersCount($name)
    {
        if (isset($name) && (trim($name) != ""))
            $sql = "SELECT COUNT(1) AS member_count FROM member WHERE user_name LIKE '%{$name}%';";
        else
		    $sql = "SELECT COUNT(1) FROM member;";
		$result = $this->db->query($sql);
        $row = $result->unbuffered_row();
        if (isset($row))
        {
            foreach($row as $key => $value)
            {
                return $value;
            }
        }
		else
            return 0;
    }


	function insertMember($member)
    {
		$sql = "INSERT INTO `MEMBER` 
	(user_name, user_id, passwd, tel, rank)
VALUES
	('{$member["user_name"]}', '{$member["user_id"]}', password('{$member["passwd"]}'), '{$member["tel"]}', {$member["rank"]});";

		$this->db->query($sql);
    }


	function updateMember($num, $member)
    {
		$sql = "UPDATE `MEMBER` SET 
	user_name = '{$member["user_name"]}'
	, user_id = '{$member["user_id"]}'
	, passwd = password('{$member["passwd"]}')
	, tel = '{$member["tel"]}'
	, rank = {$member["rank"]}
WHERE num = {$num};";

		$this->db->query($sql);
    }


}
?>