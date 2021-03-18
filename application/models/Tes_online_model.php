<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes_online_model extends CI_Model{

    public function get_materi(){
        return $this->db->order_by('is_enable DESC', 'id DESC')
                    ->get('materi')->result();
    }

    public function get_materi_by_id($id_materi){
        return $this->db->get_where('materi', array('id' => $id_materi, 'is_enable' => 1))->result();
    }
}