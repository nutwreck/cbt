<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tes_online_model extends CI_Model
{

    public function get_materi()
    {
        return $this->db->order_by('is_enable DESC', 'id DESC')
            ->get('materi')->result();
    }

    public function get_materi_user()
    {
        return $this->db->select('T1.*, T2.name AS user_created_name, T3.name AS user_edited_name', FALSE)
            ->join('lembaga_user AS T2', 'T2.user_id = T1.created_by')
            ->join('lembaga_user AS T3', 'T1.updated_by = T3.user_id', 'left')
            ->order_by('T1.is_enable DESC', 'T1.id DESC')
            ->get('materi AS T1')->result();
    }

    public function get_materi_enable()
    {
        return $this->db->select('id, name')
            ->order_by('id DESC')
            ->get_where('materi', array('is_enable' => 1))->result();
    }

    public function get_materi_selected($materi_id)
    {
        return $this->db->select('id, name')
            ->order_by('id DESC')
            ->get_where('materi', array('id !=' => $materi_id, 'is_enable' => 1))->result();
    }

    public function get_materi_by_id($id_materi)
    {
        return $this->db->get_where('materi', array('id' => $id_materi, 'is_enable' => 1))->result();
    }

    public function get_kelas_enable()
    {
        return $this->db->select('kelas_id, description')
            ->order_by('group_kelas_id ASC')
            ->get_where('v_kelas', array('is_enable_kelas' => 1, 'is_enable_groupkelas' => 1))->result();
    }

    public function get_kelas_selected($kelas_id)
    {
        return $this->db->select('kelas_id, description')
            ->order_by('group_kelas_id ASC')
            ->get_where('v_kelas', array('kelas_id !=' => $kelas_id, 'is_enable_kelas' => 1, 'is_enable_groupkelas' => 1))->result();
    }

    public function get_type_paket()
    {
        return $this->db->order_by('id ASC')
            ->get_where('type_paket', array('is_enable' => 1))->result();
    }

    public function get_type_paket_selected($type_paket_id)
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('type_paket', array('id !=' => $type_paket_id, 'is_enable' => 1))->result();
    }

    public function get_detail_buku()
    {
        return $this->db->order_by('id ASC')
            ->get_where('detail_buku', array('is_enable' => 1))->result();
    }

    public function get_detail_buku_selected($detail_buku_id)
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('detail_buku', array('id !=' => $detail_buku_id, 'is_enable' => 1))->result();
    }

    public function get_mode_jawaban_enable()
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('detail_mode_jawaban', array('group_mode_jwb_id' => 1, 'is_enable' => 1))->result();
    }

    public function get_mode_jawaban_selected($detail_mode_jwb_id)
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('detail_mode_jawaban', array('id !=' => $detail_mode_jwb_id, 'group_mode_jwb_id' => 1, 'is_enable' => 1))->result();
    }

    public function get_jenis_soal_enable()
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('group_mode_jawaban', array('is_enable' => 1))->result();
    }

    public function get_tipe_kesulitan_enable()
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('tipe_kesulitan', array('is_enable' => 1))->result();
    }

    public function get_skala_nilai_enable()
    {
        return $this->db->select('id, detail')
            ->order_by('id ASC')
            ->get_where('pengaturan_universal', array('name' => 'SKALA NILAI', 'is_enable' => 1))->result();
    }

    public function get_skala_nilai_selected($universal_id)
    {
        return $this->db->select('id, detail')
            ->order_by('id ASC')
            ->get_where('pengaturan_universal', array('id !=' => $universal_id, 'name' => 'SKALA NILAI', 'is_enable' => 1))->result();
    }

    public function get_buku_enable()
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('buku', array('is_enable' => 1))->result();
    }

    public function get_buku_selected($buku_id)
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('buku', array('id !=' => $buku_id, 'is_enable' => 1))->result();
    }

    public function get_paket_soal()
    {
        return $this->db->select('T1.paket_soal_id, T1.nama_paket_soal, T1.materi_name, T1.kelas_id, kelas_name, T1.created_datetime, T1.updated_datetime, T1.status_paket_soal, T1.petunjuk, T1.is_enable, T2.name AS user_created_name, T3.name AS user_edited_name, T1.total_soal', FALSE)
            ->join('lembaga_user AS T2', 'T2.user_id = T1.created_by')
            ->join('lembaga_user AS T3', 'T1.updated_by = T3.user_id', 'left')
            ->order_by('T1.paket_soal_id DESC', 'T1.is_enable DESC')
            ->get('v_paket_soal AS T1')->result();
    }

    public function get_paket_soal_by_id($paket_data_id)
    {
        return $this->db->select('*')
            ->get_where('v_paket_soal', array('paket_soal_id' => $paket_data_id, 'is_enable' => 1))->row();
    }

    public function get_total_mode_jwb($paket_soal_id)
    {
        return $this->db->select('count_pilgan')
            ->get_where('v_paket_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->row();
    }

    public function get_all_group_by_paketid($paket_soal_id)
    {
        return $this->db->select('id_group_soal, name_group_soal')
            ->get_where('v_group_soal', array('paket_soal_id' => $paket_soal_id))->result();
    }

    public function get_total_soal($paket_soal_id)
    {
        return $this->db->select('total_soal')
            ->get_where('v_paket_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->row();
    }

    public function get_pengaturan_universal_id($name, $detail)
    {
        return $this->db->order_by('id, name, detail, param')
            ->get_where('pengaturan_universal', array('name' => $name, 'detail' => $detail, 'is_enable' => 1))->row();
    }

    public function get_group_soal_by_kode($kode_group, $paket_soal_id)
    {
        return $this->db->get_where('v_group_soal', array('kode_group' => $kode_group, 'paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->row();
    }

    public function get_bacaan_soal_by_kode($kode_bacaan, $paket_soal_id)
    {
        return $this->db->get_where('bacaan_soal', array('kode_bacaan' => $kode_bacaan, 'paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->row();
    }

    public function get_sesi_pelaksanaan()
    {
        return $this->db->get('v_sesi_pelaksanaan')->result();
    }

    public function get_sesi_pelaksanaan_by_id($sesi_pelaksana_id)
    {
        return $this->db->select('sesi_pelaksanaan_id,sesi_pelaksanaan_name,status_sesi_pelakasanaan,paket_soal_id')
            ->get_where('v_sesi_pelaksanaan', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id, 'is_enable_sesi' => 1))->row();
    }

    public function get_sesi_pelaksanaan_existing($user_id)
    {
        $query = $this->db->query("
            SELECT
                T1.*, T3.id AS check_status_ujian, T3.tgl_selesai AS tgl_selesai_user, T3.status AS status_ujian
            FROM v_sesi_pelaksanaan AS T1
            JOIN sesi_pelaksanaan_user AS T2 ON T1.sesi_pelaksanaan_id = T2.sesi_pelaksanaan_id
                AND T2.is_enable = 1
                AND T2.user_id = '" . $user_id . "'
            LEFT OUTER JOIN ujian AS T3 ON T1.sesi_pelaksanaan_id = T3.sesi_pelaksanaan_id
                AND T3.user_id = '" . $user_id . "'
                AND T3.is_enable = 1
            WHERE T1.batas_pengerjaan >= NOW()
            ORDER BY T1.waktu_mulai ASC");
        return $query->result();
    }

    public function get_sesi_pelaksanaan_past($user_id)
    {
        $query = $this->db->query("
            SELECT
                T1.*, T3.id AS check_status_ujian, T3.tgl_selesai AS tgl_selesai_user, T3.status AS status_ujian
            FROM v_sesi_pelaksanaan AS T1
            JOIN sesi_pelaksanaan_user AS T2 ON T1.sesi_pelaksanaan_id = T2.sesi_pelaksanaan_id
                AND T2.is_enable = 1
                AND T2.user_id = '" . $user_id . "'
            JOIN ujian AS T3 ON T1.sesi_pelaksanaan_id = T3.sesi_pelaksanaan_id
                AND T3.user_id = '" . $user_id . "'
                AND T3.is_enable = 1
                AND T3.status = 1
            WHERE T1.batas_pengerjaan <= NOW() OR 
            T3.tgl_selesai >= NOW()
            ORDER BY T3.id DESC");
        return $query->result();
    }

    public function get_sesi_pelaksanaan_all_past()
    {
        $query = $this->db->query("
            SELECT
                T1.*, T3.id AS check_status_ujian, T3.tgl_selesai AS tgl_selesai_user, T3.status AS status_ujian
            FROM v_sesi_pelaksanaan AS T1
            JOIN sesi_pelaksanaan_user AS T2 ON T1.sesi_pelaksanaan_id = T2.sesi_pelaksanaan_id
                AND T2.is_enable = 1
            JOIN ujian AS T3 ON T1.sesi_pelaksanaan_id = T3.sesi_pelaksanaan_id
                AND T3.is_enable = 1
                AND T3.status = 1
            WHERE T1.batas_pengerjaan <= NOW()
            ORDER BY T3.id DESC");
        return $query->result();
    }

    public function get_sesi_pelaksanaan_selected($sesi_pelaksana_id)
    {
        $now = date('Y-m-d H:i:s');
        return $this->db->order_by('waktu_mulai ASC')
            ->get_where('v_sesi_pelaksanaan', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id, 'batas_pengerjaan >=' => $now))->row();
    }

    public function get_sesi_pelaksanaan_pembahasan($sesi_pelaksana_id)
    {
        return $this->db->order_by('waktu_mulai ASC')
            ->get_where('v_sesi_pelaksanaan', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id))->row();
    }

    public function get_paket_soal_sesi()
    {
        return $this->db->order_by('paket_soal_id DESC')
            ->get_where('v_paket_soal', array('type_paket_id !=' => 2,  'is_enable' => 1))->result();
    }

    public function get_paket_soal_sesi_selected($paket_soal_id)
    {
        return $this->db->get_where('v_paket_soal', array('paket_soal_id' => $paket_soal_id, 'type_paket_id !=' => 2,  'is_enable' => 1))->row();
    }

    public function get_paket_soal_sesi_by_id($paket_soal_id)
    {
        return $this->db->get_where('v_paket_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->row();
    }

    public function get_group_peserta()
    {
        return $this->db->get('v_group_peserta')->result();
    }

    public function get_komposisi_soal($paket_soal_id)
    {
        return $this->db->get_where('v_komposisi_soal', array('paket_soal_id' => $paket_soal_id))->result();
    }

    public function get_peserta_by_group($group_peserta_id)
    {
        return $this->db->select('user_id')
            ->get_where('peserta', array('group_peserta_id' => $group_peserta_id, 'is_enable' => 1, 'is_lock' => 0))->result();
    }

    public function get_sesi_pelaksana_by_id($sesi_pelaksana_id)
    {
        return $this->db->get_where('v_sesi_pelaksanaan', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id))->row();
    }

    public function get_ujian_header()
    {
        $now = date('Y-m-d H:i:s');
        return $this->db->get_where('v_ujian_header', array('tgl_selesai_sesi <=' => $now))->result();
    }

    public function get_ujian_header_filter_data($group_kelompok_peserta, $sesi_pelaksanaan, $paket_soal)
    {
        $now = date('Y-m-d H:i:s');

        $this->db->select("*");
        $this->db->from('v_ujian_header');
        $this->db->where('tgl_selesai_sesi <=', $now);

        if ($group_kelompok_peserta != 'all_group') {
            if ($group_kelompok_peserta == 'manual_input') {
                $this->db->where('group_peserta_name', NULL);
            } else {
                $this->db->where("group_peserta_name like '%" . $group_kelompok_peserta . "%' ");
            }
        }

        if ($sesi_pelaksanaan != '') {
            $this->db->where("sesi_pelaksanaan_name like '%" . $sesi_pelaksanaan . "%' ");
        }

        if ($paket_soal != '') {
            $this->db->where("paket_soal_name like '%" . $paket_soal . "%' ");
        }

        return $this->db->get()->result();
    }

    public function get_ujian_header_by_id($sesi_pelaksana_id, $paket_soal_id)
    {
        $now = date('Y-m-d H:i:s');
        return $this->db->get_where('v_ujian_header', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id, 'paket_soal_id' => $paket_soal_id, 'tgl_selesai_sesi <=' => $now))->row();
    }

    public function get_ujian_detail($sesi_pelaksana_id, $paket_soal_id)
    {
        $now = date('Y-m-d H:i:s');
        return $this->db->get_where('v_ujian_detail', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id, 'paket_soal_id' => $paket_soal_id, 'tgl_selesai_sesi <=' => $now, 'status' => 1))->result();
    }

    public function get_buku_header()
    {
        return $this->db->get('v_buku_header')->result();
    }

    public function get_buku_detail($paket_soal_id, $buku_id)
    {
        return $this->db->get_where('v_buku_detail', array('paket_soal_id' => $paket_soal_id, 'buku_id' => $buku_id))->result();
    }

    public function get_buku_header_by_id($paket_soal_id, $buku_id)
    {
        return $this->db->get_where('v_buku_header', array('paket_soal_id' => $paket_soal_id, 'buku_id' => $buku_id))->row();
    }

    public function get_komposisi_soal_by_id($sesi_pelaksana_id, $paket_soal_id)
    {
        $query = $this->db->query("SELECT
                T1.*,
                T2.id AS sesi_pelaksanaan_komposisi_id,
                T2.sesi_pelaksanaan_id,
                T2.total_soal
            FROM v_komposisi_soal AS T1
            JOIN sesi_pelaksanaan_komposisi AS T2 ON T2.group_soal_id = T1.id_group_soal
            WHERE T2.sesi_pelaksanaan_id = '" . $sesi_pelaksana_id . "' AND
			T1.paket_soal_id = '" . $paket_soal_id . "'
            AND T2.is_enable = 1");
        return $query->result();
    }

    public function get_komposisi_soal_by_paket($paket_soal_id)
    {
        $query = $this->db->query("SELECT
            paket_soal_id,
            group_soal_id AS id_group_soal,
            group_soal_name
        FROM v_bank_soal AS T1
        WHERE paket_soal_id = '" . $paket_soal_id . "' AND 
        is_enable = 1
        GROUP BY paket_soal_id, group_soal_id
        ORDER BY group_soal_id");
        return $query->result();
    }

    public function getUsers($searchTerm = "")
    {

        // Fetch users
        $this->db->select('*');
        $this->db->where("name like '%" . $searchTerm . "%' ");
        $this->db->where('is_enable', 1);
        $this->db->where('is_lock', 0);
        $fetched_records = $this->db->get('peserta');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['user_id'], "text" => $user['no_peserta'] . ' ' . $user['name']);
        }
        return $data;
    }

    public function get_all_soal_by_paketid($paket_soal_id)
    {
        /*  $config_acakan_soal = $this->get_paket_soal_by_id($paket_soal_id);
        $order = $config_acakan_soal->is_acak_soal == 1 ? "CASE WHEN is_acak_soal = 1 THEN 1 ELSE 0 END, CASE WHEN is_acak_soal = 0 THEN id END, RAND()" : 'id ASC'; */
        //Nanti acakan buat user saja
        //RANK() OVER ( ORDER BY id ASC )
        //@curRank := @curRank + 1 //select
        //bank_soal p, (SELECT @curRank := 0) r //get
        return $this->db->select('id, @curRank := @curRank + 1 AS no_soal, is_opsi_jawaban', FALSE)
            ->order_by('group_soal_id ASC, id ASC')
            ->get_where('bank_soal p, (SELECT @curRank := 0) r', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1), FALSE)->result();
    }

    public function get_all_soal_by_search($paket_soal_id, $group_soal_id, $kata_kunci_soal)
    {
        /*  $config_acakan_soal = $this->get_paket_soal_by_id($paket_soal_id);
        $order = $config_acakan_soal->is_acak_soal == 1 ? "CASE WHEN is_acak_soal = 1 THEN 1 ELSE 0 END, CASE WHEN is_acak_soal = 0 THEN id END, RAND()" : 'id ASC'; */
        //Nanti acakan buat user saja
        //RANK() OVER ( ORDER BY id ASC )
        //@curRank := @curRank + 1 //select
        //bank_soal p, (SELECT @curRank := 0) r //get
        if (($group_soal_id && $kata_kunci_soal) || ($group_soal_id !== "" && $kata_kunci_soal !== "")) { //jika keduanya ada
            return $this->db->select('id, @curRank := @curRank + 1 AS no_soal', FALSE)
                ->order_by('group_soal_id ASC, id ASC')
                ->where('paket_soal_id', $paket_soal_id)
                ->where('is_enable', 1)
                ->where('group_soal_id', $group_soal_id === "no_group" ? 0 : $group_soal_id)
                ->like('name', $kata_kunci_soal)
                ->get('bank_soal p, (SELECT @curRank := 0) r', FALSE)
                ->result();
        } elseif ($group_soal_id || $group_soal_id !== "") {
            return $this->db->select('id, @curRank := @curRank + 1 AS no_soal', FALSE)
                ->order_by('group_soal_id ASC, id ASC')
                ->where('paket_soal_id', $paket_soal_id)
                ->where('is_enable', 1)
                ->where('group_soal_id', $group_soal_id === "no_group" ? 0 : $group_soal_id)
                ->get('bank_soal p, (SELECT @curRank := 0) r', FALSE)
                ->result();
        } elseif ($kata_kunci_soal || $kata_kunci_soal !== "") {
            return $this->db->select('id, @curRank := @curRank + 1 AS no_soal', FALSE)
                ->order_by('group_soal_id ASC, id ASC')
                ->where('paket_soal_id', $paket_soal_id)
                ->where('is_enable', 1)
                ->like('name', $kata_kunci_soal)
                ->get('bank_soal p, (SELECT @curRank := 0) r', FALSE)
                ->result();
        } else { //jika tidak ada keduanya
            $this->get_all_soal_by_paketid($paket_soal_id);
        }
    }

    public function get_soal_by_id($paket_soal_id, $bank_soal_id)
    {
        return $this->db->select('bank_soal_id, paket_soal_id, group_mode_jwb_id, group_mode_jwb_name, is_acak_soal, acak_soal
                                ,is_acak_jawaban, acak_jawaban, is_opsi_jawaban, tipe_opsi_jawaban, no_soal, bank_soal_name, kata_kunci, tipe_kesulitan_id
                                ,tipe_kesulitan_name, file, tipe_file, group_soal_id, bacaan_soal_id, isi_bacaan_soal, 
                                group_soal_name, group_soal_petunjuk, bacaan_soal_name, group_soal_audio, group_soal_tipe_audio
                                ,url_pembahasan, pembahasan, timer')
            ->get_where('v_bank_soal', array('paket_soal_id' => $paket_soal_id, 'bank_soal_id' => $bank_soal_id, 'is_enable' => 1))->row();
    }

    public function get_jawaban_by_id($bank_soal_id, $paket_soal_id)
    {
        /* $paket_acakan_jwb = $this->get_paket_soal_by_id($paket_soal_id);
        $soal_acakan_jwb = $this->get_soal_by_id($paket_soal_id, $bank_soal_id); 
        $order = $paket_acakan_jwb->is_acak_jawaban == 1 && $soal_acakan_jwb->is_acak_jawaban == 1 ? 'RAND()' : 'order ASC, id ASC';
        */ //Nanti buat acakan pas user
        return $this->db->select('id, bank_soal_id, order, name, score, is_key')
            ->order_by('order ASC, id ASC')
            ->get_where('jawaban', array('bank_soal_id' => $bank_soal_id, 'is_enable' => 1))->result();
    }

    public function get_jawaban_by_id_user($bank_soal_id, $paket_soal_id)
    {
        $paket_acakan_jwb = $this->get_paket_soal_by_id($paket_soal_id);
        $soal_acakan_jwb = $this->get_soal_by_id($paket_soal_id, $bank_soal_id);
        $order = $paket_acakan_jwb->is_acak_jawaban == 1 && $soal_acakan_jwb->is_acak_jawaban == 1 ? 'RAND()' : 'order ASC, id ASC';
        return $this->db->select('id, bank_soal_id, order, name, score, is_key')
            ->order_by($order)
            ->get_where('jawaban', array('bank_soal_id' => $bank_soal_id, 'is_enable' => 1))->result();
    }

    public function get_jawaban_by_id_pembahasan($bank_soal_id, $paket_soal_id)
    {
        return $this->db->select('id, bank_soal_id, order, name, score, is_key')
            ->order_by('order ASC, id ASC')
            ->get_where('jawaban', array('bank_soal_id' => $bank_soal_id, 'is_enable' => 1))->result();
    }

    public function get_jawaban_by_id_benar($bank_soal_id, $paket_soal_id)
    {
        return $this->db->select('order')
            ->get_where('jawaban', array('bank_soal_id' => $bank_soal_id, 'is_key' => 1, 'is_enable' => 1))->row()->order;
    }

    public function get_jawaban_detail($bank_soal_id)
    {
        return $this->db->select('id, bank_soal_id, order, name, score, is_key')
            ->order_by('order ASC, id ASC')
            ->get_where('jawaban', array('bank_soal_id' => $bank_soal_id, 'is_enable' => 1))->result();
    }

    public function get_jawaban_ujian($ujian_id)
    {
        /* , 'status' => $status */
        return $this->db->select('list_jawaban')
            ->get_where('ujian', array('id' => $ujian_id, 'is_enable' => 1))->row()->list_jawaban;
    }

    public function get_jawaban_soal($bank_soal_id)
    {
        return $this->db->select('order')
            ->where('bank_soal_id', $bank_soal_id)
            ->where('is_enable', 1)
            ->where('is_key', 1)
            ->get('jawaban')->row()->order;
    }

    public function get_jawaban_score_soal($bank_soal_id)
    {
        return $this->db->select('SUM(CASE WHEN score IS NULL THEN 0 ELSE score END) AS score', FALSE)
            ->where('bank_soal_id', $bank_soal_id)
            ->where('is_enable', 1)
            ->where('is_key', 1)
            ->group_by('bank_soal_id')
            ->get('jawaban')->row()->score;
    }

    public function get_opsi_jawaban($bank_soal_id)
    {
        return $this->db->select('is_opsi_jawaban') //1 single 2 multiple
            ->where('id', $bank_soal_id)
            ->where('is_enable', 1)
            ->get('bank_soal')->row()->is_opsi_jawaban;
    }

    public function get_jenis_soal_selected($group_mode_jwb_id)
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('group_mode_jawaban', array('id !=' => $group_mode_jwb_id, 'is_enable' => 1))->result();
    }

    public function get_tipe_kesulitan_selected($tipe_kesulitan_id)
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('tipe_kesulitan', array('id !=' => $tipe_kesulitan_id, 'is_enable' => 1))->result();
    }

    public function get_bacaan_soal($paket_soal_id)
    {
        return $this->db->select('*')
            ->order_by('id DESC')
            ->get_where('bacaan_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->result();
    }

    public function get_bacaan_soal_selected($paket_soal_id, $bacaan_soal_id)
    {
        return $this->db->select('*')
            ->order_by('id DESC')
            ->get_where('bacaan_soal', array('paket_soal_id' => $paket_soal_id, 'id !=' => $bacaan_soal_id, 'is_enable' => 1))->result();
    }

    public function get_bacaan_soal_by_id($bacaan_soal_id)
    {
        return $this->db->get_where('bacaan_soal', array('id' => $bacaan_soal_id, 'is_enable' => 1))->row();
    }

    public function get_group_soal($paket_soal_id)
    {
        return $this->db->select('*')
            ->order_by('id_group_soal DESC')
            ->get_where('v_group_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->result();
    }

    public function get_group_soal_selected($paket_soal_id, $group_soal_id)
    {
        return $this->db->select('*')
            ->order_by('id_group_soal DESC')
            ->get_where('v_group_soal', array('paket_soal_id' => $paket_soal_id, 'id_group_soal !=' => $group_soal_id, 'is_enable' => 1))->result();
    }

    public function get_group_soal_by_id($group_soal_id)
    {
        return $this->db->get_where('v_group_soal', array('id_group_soal' => $group_soal_id, 'is_enable' => 1))->row();
    }

    public function get_petunjuk_by_id($group_soal_id)
    {
        return $this->db->select('name, petunjuk')
            ->get_where('group_soal', array('id' => $group_soal_id, 'is_enable' => 1))->row();
    }

    public function get_konversi_skor_enable()
    {
        return $this->db->order_by('id ASC')->get_where('konversi_skor', array('is_enable' => 1))->result();
    }

    public function get_konversi_skor_selected($konversi_skor_id)
    {
        return $this->db->select('id, name')
            ->order_by('id ASC')
            ->get_where('konversi_skor', array('id !=' => $konversi_skor_id, 'is_enable' => 1))->result();
    }

    public function report_ujian_by_user($sesi_pelaksana_id, $paket_soal_id, $user_id)
    {
        return $this->db->select('hasil_jawaban, str_jawaban')
            ->get_where('v_ujian_report', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id, 'paket_soal_id' => $paket_soal_id, 'user_id' => $user_id))->result();
    }

    public function report_ujian_by_st($sesi_pelaksana_id, $paket_soal_id, $column_take)
    {
        return $this->db->select('no_soal, ' . $column_take . ' bank_soal_id')
            ->get_where('v_ujian_report_st', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id, 'paket_soal_id' => $paket_soal_id))->result();
    }

    public function get_buku_count_free($buku_id)
    {
        $query = $this->db->select('COUNT(id) as count_free', FALSE)
            ->get_where('paket_soal', array('buku_id' => $buku_id, 'is_free' => 1, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->row()->count_free;
        } else {
            return 0;
        }
    }

    public function get_buku_config_free($buku_id)
    {
        $query = $this->db->select('free_paket')
            ->get_where('config_buku', array('buku_id' => $buku_id, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->row()->free_paket;
        } else {
            return 0;
        }
    }

    public function get_group_soal_ujian($group_soal_id)
    {
        $query = $this->db->select('konversi_skor_id')
            ->get_where('group_soal', array('id' => $group_soal_id, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->row()->konversi_skor_id;
        } else {
            return null;
        }
    }

    public function get_paket_soal_by_tes($tes_id)
    {
        $query = $this->db->select('paket_soal_id')
            ->get_where('ujian', array('id' => $tes_id, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->row()->paket_soal_id;
        } else {
            return null;
        }
    }

    public function get_user_id_by_tes($tes_id)
    {
        $query = $this->db->select('user_id')
            ->get_where('ujian', array('id' => $tes_id, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->row()->user_id;
        } else {
            return null;
        }
    }

    public function check_report_ujian($sesi_pelaksanaan_id, $paket_soal_id, $user_id)
    {
        $available = 1;
        $query = $this->db->select('id')
            ->get_where('ujian_report', array('sesi_pelaksanaan_id' => $sesi_pelaksanaan_id, 'paket_soal_id' => $paket_soal_id, 'user_id' => $user_id, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $available;
        } else {
            return null;
        }
    }

    public function get_konversi_skor($konversi_id, $skor_asal)
    {
        $query = $this->db->select('skor_konversi')
            ->get_where('detail_konversi_skor', array('konversi_skor_id' => $konversi_id, 'skor_asal' => $skor_asal, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->row()->skor_konversi;
        } else {
            return null;
        }
    }

    public function get_ujian_skor_detail($id_tes)
    {
        $query = $this->db->select('id')
            ->get_where('ujian_skor', array('ujian_id' => $id_tes, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_ujian_skor_all($id_tes)
    {
        $query = $this->db->select('SUM(skor_konversi) AS total_skor', FALSE)
            ->get_where('ujian_skor', array('ujian_id' => $id_tes, 'is_enable' => 1));

        $num = $query->num_rows();
        if ($num > 0) {
            return $query->row()->total_skor;
        } else {
            return null;
        }
    }

    public function get_parent_group($paket_soal_id)
    {
        return $this->db->select('id, name')
            ->order_by('id DESC')
            ->get_where('group_soal', array('paket_soal_id' => $paket_soal_id, 'is_enable' => 1))->result();
    }

    public function get_parent_group_selected($paket_soal_id, $parent_id)
    {
        return $this->db->select('id, name')
            ->order_by('id DESC')
            ->get_where('group_soal', array('paket_soal_id' => $paket_soal_id, 'id !=' => $parent_id, 'is_enable' => 1))->result();
    }

    public function get_pembahasan($bank_soal_id)
    {
        return $this->db->select('id, url, pembahasan')
            ->get_where('pembahasan', array('bank_soal_id' => $bank_soal_id, 'is_enable' => 1))->row();
    }

    public function get_total_paket_soal()
    {
        return $this->db->select('COUNT(paket_soal_id) AS total_paket_soal', FALSE)
            ->get('v_paket_soal', array('is_enable' => 1))->row();
    }

    public function get_total_peserta()
    {
        return $this->db->select('COUNT(peserta_id) AS total_peserta', FALSE)
            ->get('v_peserta', array('is_enable' => 1))->row();
    }

    public function get_checking_ujian_non_buku($sesi_pelaksana_id, $paket_soal_id, $user_id)
    {
        $query = $this->db->select('id, user_id, user_no, user_name, user_email, list_soal, list_jawaban, tgl_mulai, tgl_selesai, status')
            ->get_where('ujian', array('sesi_pelaksanaan_id' => $sesi_pelaksana_id, 'paket_soal_id' => $paket_soal_id, 'user_id' => $user_id, 'status' => 0, 'is_enable' => 1))->row();

        if ($query) {
            return $query;
        } else {
            return null;
        }
    }

    public function get_checking_ujian($paket_soal_id, $user_id)
    {
        $query = $this->db->select('id, user_id, user_no, user_name, user_email, list_soal, list_jawaban, tgl_mulai, tgl_selesai, status')
            ->get_where('ujian', array('paket_soal_id' => $paket_soal_id, 'user_id' => $user_id, 'status' => 0, 'is_enable' => 1))->row();

        if ($query) {
            return $query;
        } else {
            return null;
        }
    }

    public function get_checking_ujian_by_id($ujian_id)
    {
        $query = $this->db->select('id, sesi_pelaksanaan_id, paket_soal_id, user_id, user_no, user_name, user_email, list_soal, list_jawaban, tgl_mulai, tgl_selesai, status, jml_benar, jml_salah, jml_ragu, jml_kosong, skor')
            ->get_where('ujian', array('id' => $ujian_id, 'status' => 1, 'is_enable' => 1))->row();

        if ($query) {
            return $query;
        } else {
            return null;
        }
    }

    public function get_total_user_ujian($sesi_pelaksanaan_id, $paket_soal_id)
    {
        $query = $this->db->select('COUNT(user_id) AS total_user_ujian')
            ->get_where('ujian', array('sesi_pelaksanaan_id' => $sesi_pelaksanaan_id, 'paket_soal_id' => $paket_soal_id, 'status' => 1, 'is_enable' => 1))->row();

        if ($query) {
            return $query;
        } else {
            return null;
        }
    }

    public function get_list_peserta_sesi($sesi_pelaksanaan_id)
    {
        return $this->db->get_where('v_peserta_sesi', array('sesi_pelaksanaan_id' => $sesi_pelaksanaan_id))->result();
    }

    public function get_ranking_ujian_user($ujian_id)
    {
        $query = $this->db->select('ranking')
            ->get_where('v_ujian_ranking', array('id' => $ujian_id))->row();

        if ($query) {
            return $query;
        } else {
            return null;
        }
    }

    public function get_ujian_by_id($ujian_id)
    {
        $query = $this->db->select('sesi_pelaksanaan_id')
            ->get_where('ujian', array('id' => $ujian_id))->row();

        if ($query) {
            return $query;
        } else {
            return null;
        }
    }

    public function get_bank_soal_ujian($paket_soal_id, $group_soal_id, $total_soal)
    {
        $config_acakan_soal = $this->get_paket_soal_by_id($paket_soal_id);
        $order = $config_acakan_soal->is_acak_soal == 1 ? "CASE WHEN is_acak_soal = 1 THEN 1 ELSE 0 END, CASE WHEN is_acak_soal = 0 THEN bank_soal_id END, RAND()" : 'bank_soal_id ASC';
        $query = $this->db->query("
                    SELECT `bank_soal_id` 
                    FROM `v_bank_soal` 
                    WHERE `paket_soal_id` = '" . $paket_soal_id . "' 
                    AND `group_soal_id` = '" . $group_soal_id . "' 
                    AND `is_enable` = 1 
                    ORDER BY " . $order . " 
                    LIMIT " . $total_soal . "
                ");
        $check = $query->result_array();
        if ($check > 0) {
            return $check;
        } else {
            return false;
        }
    }

    public function get_bank_soal_ujian_buku($paket_soal_id, $group_soal_id)
    {
        $config_acakan_soal = $this->get_paket_soal_by_id($paket_soal_id);
        $order = $config_acakan_soal->is_acak_soal == 1 ? "CASE WHEN is_acak_soal = 1 THEN 1 ELSE 0 END, CASE WHEN is_acak_soal = 0 THEN bank_soal_id END, RAND()" : 'bank_soal_id ASC';
        $query = $this->db->query("
                    SELECT `bank_soal_id` 
                    FROM `v_bank_soal` 
                    WHERE `paket_soal_id` = '" . $paket_soal_id . "' 
                    AND `group_soal_id` = '" . $group_soal_id . "' 
                    AND `is_enable` = 1
                    ORDER BY " . $order . "
                ");
        $check = $query->result_array();
        if ($check > 0) {
            return $check;
        } else {
            return false;
        }
    }

    public function get_ujian_list_user($pc_urut_soal_jwb, $pc_urut_soal_id, $paket_soal_id)
    {
        $this->db->select("*, {$pc_urut_soal_jwb} AS jawaban");
        $this->db->from('v_bank_soal');
        $this->db->where('bank_soal_id', $pc_urut_soal_id);
        $this->db->where('paket_soal_id', $paket_soal_id);
        $this->db->where('is_enable', 1);
        return $this->db->get()->row();
    }

    public function get_paket_soal_buku($buku_id, $detail_buku_id)
    {
        $this->db->select("*");
        $this->db->from('v_paket_soal_buku');
        $this->db->where('buku_id', $buku_id);
        if (!empty($detail_buku_id)) {
            $this->db->where('detail_buku_id', $detail_buku_id);
        } else {
        }
        $this->db->order_by('is_free DESC');
        return $this->db->get()->result();
    }

    public function save_soal($data)
    {
        $this->db->trans_start();
        $this->db->insert('bank_soal', $data);
        $id_insert = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $id_insert;
        }
    }

    public function save_jawaban($datas)
    {
        $this->db->trans_start();
        $query = $this->db->insert_batch('jawaban', $datas);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function save_jawaban_single($datas)
    {
        $this->db->trans_start();
        $query = $this->db->insert('jawaban', $datas);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function save_pembahasan($pembahasan)
    {
        $this->db->trans_start();
        $query = $this->db->insert('pembahasan', $pembahasan);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }
    public function update_pembahasan($bank_soal_id, $datas)
    {
        $this->db->trans_start();
        $this->db->where('bank_soal_id', $bank_soal_id);
        $query = $this->db->update('pembahasan', $datas);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function update_soal($id, $data)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $query = $this->db->update('bank_soal', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function update_jawaban($datas)
    {
        $this->db->trans_start();
        $query = $this->db->insert_batch('jawaban', $datas);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function disable_jawaban($bank_soal_id)
    {
        $now = date('Y-m-d H:i:s');
        $this->db->trans_start();
        $this->db->set('is_enable', 0);
        $this->db->set('updated_datetime', $now);
        $this->db->where('bank_soal_id', $bank_soal_id);
        $query = $this->db->update('jawaban');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function disable_soal($paket_soal_id, $bank_soal_id)
    {
        $now = date('Y-m-d H:i:s');
        $this->db->trans_start();
        $this->db->set('is_enable', 0);
        $this->db->set('updated_datetime', $now);
        $this->db->where('paket_soal_id', $paket_soal_id);
        $this->db->where('id', $bank_soal_id);
        $query = $this->db->update('bank_soal');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $disable_jawaban = $this->disable_jawaban($bank_soal_id); //Disable soal = Disable Jawaban juga
            if (!empty($disable_jawaban)) {
                $this->db->trans_commit();
                return $query;
            } else {
                $this->db->trans_rollback();
                return null;
            }
        }
    }

    public function disable_all_soal($paket_soal_id, $get_all_soal_id)
    {
        $now = date('Y-m-d H:i:s');
        $this->db->trans_start();
        $this->db->set('is_enable', 0);
        $this->db->set('updated_datetime', $now);
        $this->db->where('paket_soal_id', $paket_soal_id);
        $query = $this->db->update('bank_soal');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            foreach ($get_all_soal_id as $key_soal_id => $val_soal_id) {
                $disable_jawaban = $this->disable_jawaban($val_soal_id->id); //Disable soal = Disable Jawaban juga
            }
            if (!empty($disable_jawaban)) {
                $this->db->trans_commit();
                return $query;
            } else {
                $this->db->trans_rollback();
                return null;
            }
        }
    }

    public function update_bacaan_soal($data, $bacaan_soal_id, $paket_soal_id)
    {
        $this->db->trans_start();
        $this->db->where('id', $bacaan_soal_id);
        $this->db->where('paket_soal_id', $paket_soal_id);
        $query = $this->db->update('bacaan_soal', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function update_group_soal($data, $group_soal_id, $paket_soal_id)
    {
        $this->db->trans_start();
        $this->db->where('id', $group_soal_id);
        $this->db->where('paket_soal_id', $paket_soal_id);
        $query = $this->db->update('group_soal', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function disable_sesi_pelaksana($sesi_pelaksana_id, $data)
    {
        $this->db->trans_start();
        $query_sesi = $this->db->where('id', $sesi_pelaksana_id)->update('sesi_pelaksanaan', $data);
        $query_kelompok = $this->db->where('sesi_pelaksanaan_id', $sesi_pelaksana_id)->update('sesi_pelaksanaan_komposisi', $data);
        $query_user = $this->db->where('sesi_pelaksanaan_id', $sesi_pelaksana_id)->update('sesi_pelaksanaan_user', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function disable_peserta_sesi_pelaksanaan($tbl, $id)
    {
        $this->db->trans_start();
        $this->db->set('is_enable', 0);
        $this->db->where('sesi_pelaksanaan_id', $id);
        $query = $this->db->update($tbl);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function disable_report_ujian($sesi_pelaksanaan_id, $paket_soal_id, $user_id, $data)
    {
        $this->db->trans_start();
        $this->db->where('sesi_pelaksanaan_id', $sesi_pelaksanaan_id);
        $this->db->where('paket_soal_id', $paket_soal_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->update('ujian_report', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function delete_data_ujian_by_sesi($sesi_pelaksanaan_id, $paket_soal_id, $user_id)
    {
        $this->db->trans_start();
        $this->db->set('is_enable', 0);
        $this->db->where('sesi_pelaksanaan_id', $sesi_pelaksanaan_id);
        $this->db->where('paket_soal_id', $paket_soal_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('is_enable', 1);
        $query = $this->db->update('ujian');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return null;
        } else {
            $this->db->trans_commit();
            return $query;
        }
    }

    public function get_sesi_pelaksanaan_user_by_sesi($sesi_pelaksanaan_id, $user_id, $is_enable = null)
    {
        if ($is_enable) {
            return $this->db->get_where('sesi_pelaksanaan_user', array('sesi_pelaksanaan_id' => $sesi_pelaksanaan_id, 'user_id' => $user_id, 'is_enable' => $is_enable))->row();
        } else {
            return $this->db->get_where('sesi_pelaksanaan_user', array('sesi_pelaksanaan_id' => $sesi_pelaksanaan_id, 'user_id' => $user_id))->row();
        }
    }

    public function reset_data_ujian_peserta($sesi_pelaksanaan_id, $paket_soal_id, $user_id)
    {
        $ujian_id = $this->db->get_where('ujian', array('sesi_pelaksanaan_id' => $sesi_pelaksanaan_id, 'paket_soal_id' => $paket_soal_id, 'user_id' => $user_id, 'is_enable' => 1))->row()->id;
        if (isset($ujian_id)) {
            $this->db->trans_start();

            //Disable ujian
            $this->db->set('is_enable', 0);
            $this->db->where('sesi_pelaksanaan_id', $sesi_pelaksanaan_id);
            $this->db->where('paket_soal_id', $paket_soal_id);
            $this->db->where('user_id', $user_id);
            $this->db->where('is_enable', 1);
            $this->db->update('ujian');

            //Disable ujian report
            $this->db->set('is_enable', 0);
            $this->db->where('sesi_pelaksanaan_id', $sesi_pelaksanaan_id);
            $this->db->where('paket_soal_id', $paket_soal_id);
            $this->db->where('user_id', $user_id);
            $this->db->where('is_enable', 1);
            $this->db->update('ujian_report');

            //Disable ujian skor
            $this->db->set('is_enable', 0);
            $this->db->where('ujian_id', $ujian_id);
            $this->db->where('is_enable', 1);
            $this->db->update('ujian_skor');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return null;
            } else {
                $this->db->trans_commit();
                return 1;
            }
        } else {
            return null;
        }
    }
}
