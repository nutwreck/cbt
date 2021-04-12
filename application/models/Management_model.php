<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management_model extends CI_Model{

    public function get_lembaga(){
        return $this->db->order_by('lembaga_id ASC')
                    ->get('v_lembaga')->result();
    }

    public function get_kota_kab(){
        return $this->db->order_by('id ASC')
                    ->get_where('kota_kab', array('is_enable' => 1))->result();
    }

    public function get_type_lembaga(){
        return $this->db->order_by('id ASC')
                    ->get_where('lembaga_type', array('is_enable' => 1))->result();
    }
}