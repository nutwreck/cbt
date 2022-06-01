<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

	public function get_user_lembaga()
	{
		return $this->db->order_by('user_id ASC')
			->get('v_lembaga_user')->result();
	}

	public function get_user_lembaga_by_id($lembaga_user_id, $user_id)
	{
		return $this->db->get_where('v_lembaga_user', array('lembaga_user_id' => $lembaga_user_id, 'user_id' => $user_id))->row();
	}

	public function get_id_by_username($id)
	{
		return $this->db->select('id')
			->get_where('user', array('username' => $id, 'is_enable' => 1))->row();
	}

	public function get_data_user_by_id($id)
	{
		return $this->db->select('user_id AS id, peserta_id, username, password, no_peserta, no_telp, peserta_name')
			->get_where('v_users', array('user_id' => $id, 'is_lock' => 0))->row();
	}

	public function get_lembaga_by_id($lembaga_id)
	{
		return $this->db->select('lembaga_id, lembaga_name, is_verify')
			->get_where('v_lembaga', array('lembaga_id' => $lembaga_id))->row();
	}

	public function get_group_peserta_enable($lembaga_id)
	{
		return $this->db->select('id, lembaga_id, name')
			->get_where('group_peserta', array('lembaga_id' => $lembaga_id, 'is_enable' => 1))->result();
	}

	public function get_group_peserta_by_id($participants_group_id)
	{
		return $this->db->select('id, lembaga_id, name')
			->get_where('group_peserta', array('id' => $participants_group_id, 'is_enable' => 1))->row();
	}

	public function get_group_peserta_selected($participants_group_id)
	{
		return $this->db->select('id, lembaga_id, name')
			->get_where('group_peserta', array('id !=' => $participants_group_id, 'is_enable' => 1))->result();
	}

	public function get_peserta_by_username($username)
	{
		$query = $this->db->select('*')
			->get_where('v_peserta', array('username' => $username))->row();

		if ($query) {
			return $query;
		} else {
			return null;
		}
	}

	public function update_data_peserta_excel($data, $user_id)
	{
		$this->db->trans_start();
		$this->db->where('user_id', $user_id);
		$query = $this->db->update('peserta', $data);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$this->db->trans_commit();
			return $query;
		}
	}

	public function get_user_by_email($email)
	{
		return $this->db->select('email')
			->get_where('lembaga_user', array('email' => $email))->result();
	}

	public function get_peserta_by_lembaga($lembaga_id)
	{
		return $this->db->order_by('user_id DESC')->get_where('v_peserta', array('lembaga_id' => $lembaga_id))->result();
	}

	public function get_peserta_filter_data($lembaga_id, $group_kelompok_peserta, $nomor_peserta, $nama_peserta, $username_peserta)
	{
		$this->db->select("*");
		$this->db->from('v_peserta');
		$this->db->where('lembaga_id', $lembaga_id);

		if ($group_kelompok_peserta != 'all_group') {
			$this->db->where('group_peserta_id', $group_kelompok_peserta);
		}

		if ($nomor_peserta != '') {
			$this->db->where('no_peserta', $nomor_peserta);
		}

		if ($nama_peserta != '') {
			$this->db->where("peserta_name like '%".$nama_peserta."%' ");
		}

		if ($username_peserta != '') {
			$this->db->where("username like '%".$username_peserta."%' ");
		}
		
		$this->db->order_by('user_id DESC');
		return $this->db->get()->result();
	}

	public function get_checking_username($username)
	{
		return $this->db->get_where('user', array('username' => $username))->result();
	}

	public function get_peserta_by_id($peserta_id, $user_id)
	{
		return $this->db->order_by('user_id DESC')
			->get_where('v_peserta', array('peserta_id' => $peserta_id, 'user_id' => $user_id))->row();
	}

	public function get_pengaturan_universal_id($name, $detail)
	{
		return $this->db->order_by('id, name, detail, param')
			->get_where('pengaturan_universal', array('name' => $name, 'detail' => $detail, 'is_enable' => 1))->row();
	}

	public function checking_group_peserta($lembaga_id, $row)
	{
		$query = $this->db->select('id')
			->get_where('group_peserta', array('lembaga_id' => $lembaga_id, 'name' => $row, 'is_enable' => 1))->row();

		if ($query) {
			return $query;
		} else {
			return null;
		}
	}

	public function checking_user_peserta($role_user_id, $username)
	{
		$query = $this->db->select('id')
			->get_where('user', array('role_user_id' => $role_user_id, 'username' => $username, 'is_enable' => 1))->row();

		if ($query) {
			return $query;
		} else {
			return null;
		}
	}

	public function checking_nomor_peserta($no_preserta)
	{
		$query = $this->db->select('id')
			->get_where('peserta', array('no_peserta' => $no_preserta, 'is_enable' => 1))->row();

		if ($query) {
			return $query;
		} else {
			return null;
		}
	}

	public function checking_peserta($lembaga_id, $user_id)
	{
		$query = $this->db->select('id')
			->get_where('peserta', array('lembaga_id' => $lembaga_id, 'user_id' => $user_id, 'is_enable' => 1))->row();

		if ($query) {
			return $query;
		} else {
			return null;
		}
	}

	public function input_lembaga_user($data_user_lembaga, $data_user)
	{
		$data_user_id = [];
		$this->db->trans_start();
		$user = $this->db->insert('user', $data_user);
		$user_id = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$data_user_id = array(
				'user_id' => $user_id
			);
			$data_merge = array_merge($data_user_lembaga, $data_user_id); //merge dengan data user id dari proses insert user

			$lembaga_user = $this->db->insert('lembaga_user', $data_merge);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return null;
			} else {
				$this->db->trans_commit();
				return $lembaga_user;
			}
		}
	}

	public function update_lembaga_user($id_user_lembaga, $data_user_lembaga, $id_user, $data_user)
	{
		$data_user_id = [];
		$this->db->trans_start();
		$user = $this->db->where('id', $id_user)->update('user', $data_user);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$lembaga_user = $this->db->where('id', $id_user_lembaga)->update('lembaga_user', $data_user_lembaga);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return null;
			} else {
				$this->db->trans_commit();
				return $lembaga_user;
			}
		}
	}

	public function disable_lembaga_user($lembaga_user_id, $user_id, $data)
	{
		$this->db->trans_start();
		$user = $this->db->where('id', $user_id)->update('user', $data);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$lembaga_user = $this->db->where('id', $lembaga_user_id)->update('lembaga_user', $data);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return null;
			} else {
				$this->db->trans_commit();
				return $lembaga_user;
			}
		}
	}

	public function input_peserta_tes($data_user, $data_peserta)
	{
		$data_user_id = [];
		$this->db->trans_start();
		$user = $this->db->insert('user', $data_user);
		$user_id = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$data_user_id = array(
				'user_id' => $user_id
			);
			$data_merge = array_merge($data_peserta, $data_user_id); //merge dengan data user id dari proses insert user

			$peserta = $this->db->insert('peserta', $data_merge);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return null;
			} else {
				$this->db->trans_commit();
				return $peserta;
			}
		}
	}

	public function update_peserta_tes($data_user, $id_user, $data_peserta, $id_peserta)
	{
		$data_user_id = [];
		$this->db->trans_start();
		$user = $this->db->where('id', $id_user)->update('user', $data_user);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$peserta = $this->db->where('id', $id_peserta)->update('peserta', $data_peserta);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return null;
			} else {
				$this->db->trans_commit();
				return $peserta;
			}
		}
	}

	public function disable_peserta_user($peserta_id, $user_id, $data)
	{
		$this->db->trans_start();
		$user = $this->db->where('id', $user_id)->update('user', $data);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$peserta = $this->db->where('id', $peserta_id)->update('peserta', $data);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return null;
			} else {
				$this->db->trans_commit();
				return $peserta;
			}
		}
	}

	public function disable_all_peserta_user($data)
	{
		$this->db->trans_start();
		$user = $this->db->update('user', $data);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return null;
		} else {
			$peserta = $this->db->update('peserta', $data);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return null;
			} else {
				$this->db->trans_commit();
				return $peserta;
			}
		}
	}
}
