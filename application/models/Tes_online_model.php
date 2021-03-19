<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes_online_model extends CI_Model{

    public function get_materi(){
        return $this->db->order_by('is_enable DESC', 'id DESC')
                    ->get('materi')->result();
    }

    public function get_materi_enable(){
        return $this->db->select('id, name')
                    ->order_by('id DESC')
                    ->get_where('materi', array('is_enable' => 1))->result();
    }

    public function get_materi_by_id($id_materi){
        return $this->db->get_where('materi', array('id' => $id_materi, 'is_enable' => 1))->result();
    }

    public function get_kelas_enable(){
        return $this->db->select('kelas_id, description')
                    ->order_by('kelas_id DESC')
                    ->get_where('v_kelas', array('is_enable_kelas' => 1, 'is_enable_groupkelas' => 1))->result();
    }

    public function get_paket_soal(){
        return $this->db->select('paket_soal_id, nama_paket_soal, materi_name, kelas_name, created_datetime, updated_datetime, status_paket_soal')
                    ->order_by('is_enable DESC', 'id DESC')
                    ->get('v_paket_soal')->result();
    }

}