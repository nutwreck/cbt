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

    public function get_konversi(){
        return $this->db->order_by('id DESC')
                    ->get_where('konversi_skor', array('is_enable' => 1))->result();
    }

    public function get_konversi_by_id($konversi_skor){
        return $this->db->get_where('konversi_skor', array('id' => $konversi_skor, 'is_enable' => 1))->row();
    }

    public function get_detail_konversi_by_konversi($konversi_skor){
        return $this->db->order_by('id ASC')
            ->get_where('detail_konversi_skor', array('konversi_skor_id' => $konversi_skor, 'is_enable' => 1))->result();
    }

    public function get_detail_konversi_by_id($detail_konversi_id){
        return $this->db->get_where('detail_konversi_skor', array('id' => $detail_konversi_id, 'is_enable' => 1))->row();
    }

    public function get_pengaturan_universal_id($name, $detail){
        return $this->db->order_by('id, name, detail, param')
                    ->get_where('pengaturan_universal', array('name' => $name, 'detail' => $detail, 'is_enable' => 1))->row();
    }

    public function get_pembayaran_master(){
        return $this->db->order_by('id ASC')->get_where('payment_method', array('is_enable' => 1))->result();
    }

    public function get_pembayaran_master_by_id($pembayaran_master_id){
        return $this->db->order_by('id DESC')->get_where('payment_method_detail', array('payment_method_id' => $pembayaran_master_id, 'is_enable' => 1))->result();
    }

    public function get_detail_master_pembayaran($pembayaran_detail_master_id){
        return $this->db->get_where('payment_method_detail', array('id' => $pembayaran_detail_master_id, 'is_enable' => 1))->row();
    }

    public function get_buku_config(){
        return $this->db->select('b.id, b.name, cb.free_paket, cb.price, b.created_datetime, b.updated_datetime')
            ->join('config_buku as cb', 'cb.buku_id = b.id')
            ->where('b.is_enable', '1')
            ->get('buku as b')->result();
    }

    public function get_detail_buku_by_buku($buku_id){
        return $this->db->select('T1.*, T2.name AS buku_name')
            ->join('buku AS T2', 'T1.buku_id = T2.id')
            ->order_by('T1.id DESC')
            ->get_where('config_buku_detail AS T1', array('T1.buku_id' => $buku_id, 'T1.is_enable' => 1, 'T2.is_enable' => 1))->result();
    }   
}