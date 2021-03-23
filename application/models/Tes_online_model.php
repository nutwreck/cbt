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
                    ->order_by('group_kelas_id ASC')
                    ->get_where('v_kelas', array('is_enable_kelas' => 1, 'is_enable_groupkelas' => 1))->result();
    }

    public function get_mode_jawaban_enable(){
        return $this->db->select('id, name')
                    ->order_by('id ASC')
                    ->get_where('detail_mode_jawaban', array('is_enable' => 1))->result();
    }

    public function get_jenis_soal_enable(){
        return $this->db->select('id, name')
                    ->order_by('id ASC')
                    ->get_where('group_mode_jawaban', array('is_enable' => 1))->result();
    }

    public function get_tipe_kesulitan_enable(){
        return $this->db->select('id, name')
                    ->order_by('id ASC')
                    ->get_where('tipe_kesulitan', array('is_enable' => 1))->result();
    }

    public function get_skala_nilai_enable(){
        return $this->db->select('id, detail')
                    ->order_by('id ASC')
                    ->get_where('pengaturan_universal', array('name' => 'SKALA NILAI', 'is_enable' => 1))->result();
    }

    public function get_paket_soal(){
        return $this->db->select('paket_soal_id, nama_paket_soal, materi_name, kelas_name, created_datetime, updated_datetime, status_paket_soal, petunjuk')
                    ->order_by('is_enable DESC', 'id DESC')
                    ->get('v_paket_soal')->result();
    }

    public function get_paket_soal_by_id($paket_data_id){
        return $this->db->select('paket_soal_id, nama_paket_soal, materi_name, kelas_name, total_soal, petunjuk, is_acak_soal, is_acak_jawaban')
                    ->get_where('v_paket_soal', array('paket_soal_id' => $paket_data_id))->row();
    }

    public function get_total_mode_jwb($paket_soal_id){
        return $this->db->select('count_pilgan')
                    ->get_where('v_paket_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->row();
    }

    public function get_total_soal($paket_soal_id){
        return $this->db->select('total_soal')
                    ->get_where('v_paket_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->row();
    }

    public function get_all_soal_by_id($paket_soal_id){
        /* $config_acakan_soal = $this->get_paket_soal_by_id($paket_soal_id);
        $order = $config_acakan_soal->is_acak_soal==1 ? 'rand()' : 'id ASC'; */
        $order = 'id ASC';
        return $this->db->select('id, RANK() OVER ( ORDER BY '.$order.' ) no_soal', FALSE)
                    ->order_by($order)
                    ->get_where('bank_soal', array('paket_soal_id' => $paket_soal_id))->result();
    }

    public function get_soal_by_id($paket_soal_id, $bank_soal_id){
        return $this->db->select('bank_soal_id, paket_soal_id, group_mode_jwb_id, group_mode_jwb_name, is_acak_soal, acak_soal
                                , is_acak_jawaban, acak_jawaban, no_soal, bank_soal_name, kata_kunci, tipe_kesulitan_id
                                , tipe_kesulitan_name')
                    ->limit(1)
                    ->get_where('v_bank_soal', array('paket_soal_id' => $paket_soal_id, 'bank_soal_id' => $bank_soal_id))->row();
    }

    public function get_jawaban_by_id($bank_soal_id, $paket_soal_id){
        /* $config_acakan_jwb = $this->get_paket_soal_by_id($paket_soal_id);
        $order = $config_acakan_jwb->is_acak_jawaban==1 ? 'rand()' : 'order ASC, id ASC'; */
        $order = 'order ASC, id ASC';
        return $this->db->select('id, bank_soal_id, order, name, score, is_key')
                    ->order_by($order)
                    ->get_where('jawaban', array('bank_soal_id' => $bank_soal_id))->result();
    }

    public function save_soal($data){
        $this->db->trans_start();
        $query = $this->db->insert('bank_soal', $data);
        $id_insert = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else{
			$this->db->trans_commit();
			return $id_insert;
		}
    }

    public function save_jawaban($datas){
        $this->db->trans_start();
        $query = $this->db->insert_batch('jawaban',$datas);
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else{
			$this->db->trans_commit();
			return $query;
		}
    }

    /* SET @r=0;
UPDATE (SELECT id FROM bank_soal ORDER BY id ASC) A
    LEFT JOIN bank_soal B USING (id)
    SET B.id = B.id,B.no_soal = @r:= (@r+1)
    WHERE B.paket_soal_id = 6
    AND B.is_enable = 1
; */ //UPDATE URUTAN NO SOAL/JAWABAN JIKA NANTINYA DIBUTUHKAN

}