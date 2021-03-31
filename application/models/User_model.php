<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

    public function get_user_lembaga(){
        return $this->db->order_by('user_id ASC')
                    ->get('v_lembaga_user')->result();
    }

    public function get_lembaga_by_id($lembaga_id){
        return $this->db->select('lembaga_id, lembaga_name, is_verify')
                    ->get_where('v_lembaga', array('lembaga_id' => $lembaga_id))->row();
    }

    public function get_group_peserta_enable($lembaga_id){
        return $this->db->select('id, lembaga_id, name')
                    ->get_where('group_peserta', array('lembaga_id' => $lembaga_id, 'is_enable' => 1))->result();
    }

    public function get_group_peserta_by_id($participants_group_id){
        return $this->db->select('id, lembaga_id, name')
                    ->get_where('group_peserta', array('id' => $participants_group_id, 'is_enable' => 1))->row();
    }

    public function get_group_peserta_selected($participants_group_id){
        return $this->db->select('id, lembaga_id, name')
                    ->get_where('group_peserta', array('id !=' => $participants_group_id, 'is_enable' => 1))->row();
    }

    public function get_user_by_email($email){
        return $this->db->select('email')
                    ->get_where('lembaga_user', array('email' => $email))->result();
    }

    public function get_peserta_by_lembaga($lembaga_id){
        return $this->db->order_by('user_id DESC')->get_where('v_peserta', array('lembaga_id' => $lembaga_id))->result();
    }

    public function get_checking_username($username){
        return $this->db->get_where('user', array('username' => $username))->result();
    }

    public function get_peserta_by_id($peserta_id, $user_id){
        return $this->db->order_by('user_id DESC')
                    ->get_where('v_peserta', array('peserta_id' => $peserta_id, 'user_id' => $user_id))->row();
    }

    public function input_lembaga_user($data_user_lembaga, $data_user){
        $data_user_id = [];
        $this->db->trans_start();
        $user = $this->db->insert('user', $data_user);
        $user_id = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else {
            $data_user_id = array(
                'user_id' => $user_id
            );
            $data_merge = array_merge($data_user_lembaga, $data_user_id); //merge dengan data user id dari proses insert user

            $lembaga_user = $this->db->insert('lembaga_user', $data_merge);

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return null;
            } else {
                $this->db->trans_commit();
			    return $lembaga_user;
            }
		}
    }

    public function disable_lembaga_user($lembaga_user_id, $user_id, $data){
        $data_user_id = [];
        $this->db->trans_start();
        $user = $this->db->where('id', $user_id)->update('user', $data);
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else {
            $lembaga_user = $this->db->where('id', $lembaga_user_id)->update('lembaga_user', $data);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return null;
            } else {
                $this->db->trans_commit();
			    return $lembaga_user;
            }
		}
    }

    public function input_peserta_tes($data_user, $data_peserta){
        $data_user_id = [];
        $this->db->trans_start();
        $user = $this->db->insert('user', $data_user);
        $user_id = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else {
            $data_user_id = array(
                'user_id' => $user_id
            );
            $data_merge = array_merge($data_peserta, $data_user_id); //merge dengan data user id dari proses insert user

            $peserta = $this->db->insert('peserta', $data_merge);

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return null;
            } else {
                $this->db->trans_commit();
			    return $peserta;
            }
		}
    }

}