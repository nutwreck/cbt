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
        return $this->db->select('cb.id, b.id as buku_id, b.name, cb.free_paket, cb.price, b.created_datetime, b.updated_datetime')
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

    public function get_buku($buku_id){
        return $this->db->select('name as buku_name')
                    ->get_where('buku', array('id' => $buku_id, 'is_enable' => 1))->row();
    }
    
    public function get_detail_jurusan(){
        return $this->db->order_by('id ASC')
                    ->get_where('detail_buku', array('is_enable' => 1))->result();
    }

    public function get_detail_jurusan_selected($detail_buku_id){
        return $this->db->select('id, name')
                    ->order_by('id ASC')
                    ->get_where('detail_buku', array('id !=' => $detail_buku_id, 'is_enable' => 1))->result();
    }

    public function get_buku_config_by_id($config_buku_id){
        return $this->db->get_where('config_buku', array('id' => $config_buku_id, 'is_enable' => 1))->row();
    }

    public function get_invoice_all(){
        return $this->db->get('v_invoice_all')->result();
    }

    public function get_invoice_confirm(){
        return $this->db->get('v_invoice_confirm')->result();
    }

    public function get_invoice_success(){
        return $this->db->get('v_invoice_success')->result();
    }

    public function get_invoice_expired(){
        return $this->db->get('v_invoice_expired')->result();
    }

    public function get_user_status_buku($buku_id, $user_id){
        return $this->db->get_where('user_pembelian_buku', array('buku_id' => $buku_id, 'user_id' => $user_id, 'is_enable' => 1))->row();
    }

    public function get_config_buku_by_buku($buku_id){
        return $this->db->select('T1.*, T2.name AS buku_name')
            ->join('buku AS T2', 'T2.id = T1.buku_id')
            ->get_where('config_buku AS T1', array('T1.buku_id' => $buku_id, 'T1.is_enable' => 1))->row();
    }

    public function checking_nomor_invoice($no_invoice){
        $query = $this->db->select('id')
                        ->get_where('invoice', array('invoice_number' => $no_invoice, 'is_enable' => 1))->row();
                        
        if($query){
            return $query;
        } else {
            return null;
        }
    }

    public function get_kode_unik(){
        $query = $this->db->select('number')
                        ->get('kode_unik')->row();
                        
        if($query){
            return $query->number;
        } else {
            return null;
        }
    }

    public function get_id_qris($payment_method_id){
        $query = $this->db->select('id')
                    ->limit(1)
                    ->get_where('payment_method_detail', array('payment_method_id' => $payment_method_id))->row();
                        
        if($query){
            return $query->id;
        } else {
            return null;
        }
    }

    public function get_img_qris(){
        $query = $this->db->select('image_payment')
                    ->limit(1)
                    ->get_where('payment_method_detail', array('payment_method_id' => 2))->row();
                        
        if($query){
            return $query->image_payment;
        } else {
            return null;
        }
    }

    public function get_invoice_by_user_id($user_id){
        return $this->db->order_by('id_invoice DESC')
            ->get_where('v_invoice_all', array('user_id' => $user_id))->result();
    }

    public function get_invoice_by_id($invoice_id){
        return $this->db->get_where('v_invoice_all', array('id_invoice' => $invoice_id))->row();
    }

    public function get_voucher(){
        return $this->db->get('voucher')->result();
    }

    public function get_voucher_by_id($id_voucher){
        return $this->db->get_where('voucher', array('id' => $id_voucher))->row();
    }

    public function get_voucher_by_name($voucher){
        return $this->db->get_where('voucher', array('name' => $voucher))->row();
    }
    
}