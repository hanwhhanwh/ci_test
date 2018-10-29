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


    function getMembers($user_name)
    {
        // member 테이블의 모든 레코드를 불러 옴.
        //$query = $this->db->get('member');
        if (isset($user_name))
            $sql = "SELECT num, user_name, user_id, passwd, tel, rank FROM member WHERE user_name LIKE '%{$user_name}%' ORDER BY num;";
        else
		    $sql = "SELECT num, user_name, user_id, passwd, tel, rank FROM member ORDER BY num;";
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