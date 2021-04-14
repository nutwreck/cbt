<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_buku_model extends CI_Model{

    public function get_materi(){
        return $this->db->order_by('is_enable DESC', 'id DESC')
                    ->get('konversi_skor')->result();
    }

    public function get_buku_config(){
        return $this->db->select('b.id,b.name,cb.free_paket,cb.price,b.created_datetime,b.updated_datetime')
                    ->join ('config_buku as cb','cb.buku_id = b.id')
                   // ->get_where('konversi_skor', array('is_enable' => 1))->result();
                    ->where('b.is_enable','1' )
                   ->get('buku as b')->result();

                }

    public function get_detail_buku_by_buku($bukuid){
                    return $this->db->order_by('id ASC')
                        ->get_where('buku_detail', array('buku_id' => $bukuid, 'is_enable' => 1))->result();
                }           
    public function get_materi_user(){
        return $this->db->select('T1.*, T2.name AS user_created_name, T3.name AS user_edited_name', FALSE)
                    ->join('lembaga_user AS T2', 'T2.user_id = T1.created_by')
                    ->join('lembaga_user AS T3', 'T1.updated_by = T3.user_id', 'left')
                    ->order_by('T1.is_enable DESC', 'T1.id DESC')
                    ->get('materi AS T1')->result();
    }
    public function get_konversi_id($id){
        return $this->db->get_where('konversi_skor', array('id' => $id, 'is_enable' => 1))->result();

    }
    public function get_konversi_detail_id($id){
        return $this->db->get_where('detail_konversi_skor', array('konversi_skor_id' => $id, 'is_enable' => 1))->result();

    }
    public function get_pengaturan_konversi_id($name, $detail){
        return $this->db->order_by('id, name, detail, param')
                    ->get_where('pengaturan_universal', array('name' => $name, 'detail' => $detail, 'is_enable' => 1))->row();
    }
    
    public function checking_group_konversi($lembaga_id, $row){
        $query = $this->db->select('id')
                        ->get_where('konversi_skor', array('id' => $lembaga_id, 'name' => $row, 'is_enable' => 1))->row();
        
        if($query){
            return $query;
        } else {
            return null;
        }
    }
   
}