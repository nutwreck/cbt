<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General extends CI_Model
{

	public function get_all_data($tbl)
	{
		return $this->db->get($tbl)->result();
	}
	public function get_data_by_id($tbl, $id)
	{
		return $this->db->get_where($tbl, array('id' => $id))->row();
	}
	public function get_data_by_id_multi($tbl, $ids)
	{
		return $this->db->get_where($tbl, $ids)->row();
	}
	public function input_data($tbl, $datas)
	{
		$this->db->trans_start();
		$query = $this->db->insert($tbl, $datas);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function input_data_id($tbl, $datas)
	{
		$this->db->trans_start();
		$query = $this->db->insert($tbl, $datas);
		$id = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $id;
		}
	}
	public function input_batch($tbl, $data)
	{
		$this->db->trans_start();
		$query = $this->db->insert_batch($tbl, $data);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function update_data($tbl, $data, $id)
	{
		$this->db->trans_start();
		$this->db->where('id', $id);
		$query = $this->db->update($tbl, $data);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function update_batch($tbl, $data, $id)
	{
		$this->db->trans_start();
		$query = $this->db->update_batch($tbl, $data, $id);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function delete_data($tbl, $id)
	{
		$this->db->trans_start();
		$this->db->set('is_enable', 0);
		$this->db->where('id', $id);
		$query = $this->db->update($tbl);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function delete_hard_data($tbl, $column, $id)
	{
		$this->db->trans_start();
		$this->db->where_in($column, $id);
		$query = $this->db->delete($tbl);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function active_data($tbl, $id)
	{
		$this->db->trans_start();
		$this->db->set('is_enable', 1);
		$this->db->where('id', $id);
		$query = $this->db->update($tbl);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function exam_order($paket_soal_id)
	{
		$this->db->trans_start();
		$this->db->query("SET @r=0;");
		$query = $this->db->query("UPDATE (SELECT id FROM bank_soal ORDER BY id ASC) A
                                    LEFT JOIN bank_soal B USING (id) 
                                        SET B.id = B.id,B.no_soal = @r:= (@r+1)
                                    WHERE B.paket_soal_id = " . $paket_soal_id . "
                                        AND B.is_enable = 1;");
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}
	public function answer_order($bank_soal_id)
	{
		$this->db->trans_start();
		$this->db->query("SET @r=0;");
		$query = $this->db->query("UPDATE (SELECT id FROM jawaban ORDER BY id ASC) A
                                            LEFT JOIN jawaban B USING (id)
                                            SET B.id = B.id,B.order = @r:= (@r+1)
                                            WHERE B.bank_soal_id = " . $bank_soal_id . "
                                            AND B.is_enable = 1
                                        ;");
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}

	function login_admin($data)
	{
		$query = $this->db->query("
            SELECT  user_id,
                    username,
                    password,
                    is_login,
                    lembaga_user_id,
                    lembaga_id,
                    lembaga_name,
                    lembaga_type_name,
                    lembaga_user_name,
                    lembaga_user_email
                FROM v_lembaga_user
                WHERE username = '" . $data['username'] . "'
				");
		$num = $query->num_rows();
		if ($num > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function login_user($data)
	{
		$query = $this->db->query("
            SELECT  user_id,
                    username,
                    password,
                    is_login,
                    peserta_name,
                    no_peserta,
                    group_peserta_id,
                    group_peserta_name,
                    role_user_id
                FROM v_users
                WHERE username = '" . $data['username'] . "'
				");
		$num = $query->num_rows();
		if ($num > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}
