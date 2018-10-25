<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {

    public function __construct()
    {
        // 모델 생성자 호출
        parent::__construct();
    }

    function getData()
    {
        // data테이블의 모든 레코드를 불러 옴.
        $query = $this->db->get('data');
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }else{
            show_error('Database is empty!');
        }
    }
}
?>