<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Tes_online extends CI_Controller
{

	/**
	 * Author : Candra Aji Pamungkas
	 * Create : 18-03-2021
	 * Change :
	 *      - {date} | {description}
	 */

	private $tbl_materi = 'materi'; //SET TABEL MATERI
	private $tbl_paket_soal = 'paket_soal'; //SET TABEL PAKET SOAL
	private $tbl_bacaan_soal = 'bacaan_soal'; //SET TABEL BACAAN SOAL
	private $tbl_group_soal = 'group_soal'; //SET TABEL GROUP SOAL
	private $tbl_sesi_pelaksanaan = 'sesi_pelaksanaan'; //SET SESI PELAKSANAAN
	private $tbl_sesi_pelaksanaan_komposisi = 'sesi_pelaksanaan_komposisi'; //SET SESI PELAKSANAAN KOMPOSISI
	private $tbl_sesi_pelaksanaan_user = 'sesi_pelaksanaan_user';

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('has_login')) {
			redirect('admin/login');
		}
		$this->load->library('encryption');
		$this->load->model('General', 'general');
		$this->load->model('Tes_online_model', 'tes');
	}

	/*
    |
    | START FUNCTION IN THIS CONTROLLER
    |
    */

	/*
    |  Structure View
    |
    |  $this->load->view('website/lembaga/_template/header', $data['title_header']); -->head (termasuk css yang digunakan general)
    |  $this->load->view($view['css_additional']); -->untuk tambahan css jika diperlukan, diubah melalui controller masing-masing
    |  $this->load->view('website/lembaga/_template/menu'); -->untuk peletakan head body dan menu jika dibuka di mobile
    |  $this->load->view('website/lembaga/_template/sidebar'); -->menu sidebar
    |  $this->load->view($view['content'], $data['content']); -->dinamis content, diubah melalui controller masing-masing
    |  $this->load->view('website/lembaga/_template/footer'); -->footer
    |  $this->load->view('website/lembaga/_template/js_main'); -->js yang digunakan general
    |  $this->load->view($view['js_additional']); -->untuk tambahan js jika diperlukan, diubah melalui controller masing-masing
    |  $this->load->view('website/lembaga/_template/end_page'); --> menutup dokumen html
    |
    |  EDIT CODE DIBAWAH INI UNTUK MENGGANTI STRUKTUR PEMANGGILAN VIEW / DESIGN
    |
    */

	private function _generate_view($view, $data)
	{
		$this->load->view('website/lembaga/_template/header', $data['title_header']);
		if (!empty($view['css_additional'])) {
			$this->load->view($view['css_additional']);
		} else {
		}
		$this->load->view('website/lembaga/_template/menu');
		$this->load->view('website/lembaga/_template/sidebar');
		$this->load->view($view['content'], !empty($data['content']) ? $data['content'] : []);
		$this->load->view('website/lembaga/_template/footer');
		$this->load->view('website/lembaga/_template/js_main');
		if (!empty($view['js_additional'])) {
			$this->load->view($view['js_additional']);
		} else {
		}
		$this->load->view('website/lembaga/_template/end_page');
	}

	private function input_end($input, $urly, $urlx)
	{
		if (!empty($input)) {
			$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
			redirect($urly);
		} else {
			$this->session->set_flashdata('error', 'Data gagal disimpan!');
			redirect($urlx);
		}
	}

	private function update_end($update, $urly, $urlx)
	{
		if (!empty($update)) {
			$this->session->set_flashdata('success', 'Data berhasil diedit');
			redirect($urly);
		} else {
			$this->session->set_flashdata('error', 'Data gagal terupdate!');
			redirect($urlx);
		}
	}

	private function delete_end($delete, $urly, $urlx)
	{
		if (!empty($delete)) {
			$this->session->set_flashdata('success', 'Data berhasil dinonaktifkan');
			redirect($urly);
		} else {
			$this->session->set_flashdata('error', 'Data gagal ternonaktifkan!');
			redirect($urlx);
		}
	}

	private function active_end($active, $urly, $urlx)
	{
		if (!empty($active)) {
			$this->session->set_flashdata('success', 'Data berhasil diaktifkan');
			redirect($urly);
		} else {
			$this->session->set_flashdata('error', 'Data gagal diaktifkan!');
			redirect($urlx);
		}
	}

	/*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

	public function materi()
	{
		//for passing data to view
		$data['content']['materi_data'] = $this->tes->get_materi_user();
		$data['title_header'] = ['title' => 'Materi'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/materi/css';
		$view['content'] = 'website/lembaga/tes_online/materi/content';
		$view['js_additional'] = 'website/lembaga/tes_online/materi/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_materi()
	{
		//for passing data to view
		$data['content'] = [];
		$data['title_header'] = ['title' => 'Tambah Materi'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/materi/css';
		$view['content'] = 'website/lembaga/tes_online/materi/add';
		$view['js_additional'] = 'website/lembaga/tes_online/materi/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_materi()
	{
		$data['name'] = ucwords($this->input->post('materi', TRUE));
		$data['created_by'] = $this->session->userdata('user_id');
		$data['created_datetime'] = date('Y-m-d H:i:s');
		$tbl = $this->tbl_materi;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/materi';
		$urlx = 'admin/add-materi';
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_materi($id_materi)
	{
		//for passing data to view
		$data['content']['materi_data'] = $this->tes->get_materi_by_id($id_materi);
		$data['title_header'] = ['title' => 'Edit Materi'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/materi/css';
		$view['content'] = 'website/lembaga/tes_online/materi/edit';
		$view['js_additional'] = 'website/lembaga/tes_online/materi/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_materi()
	{
		$id = $this->input->post('id', TRUE);
		$data['name'] = strtoupper($this->input->post('materi', TRUE));
		$data['updated_datetime'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('user_id');
		$tbl = $this->tbl_materi;
		$update = $this->general->update_data($tbl, $data, $id);

		$urly = 'admin/materi';
		$urlx = 'admin/edit-materi/' . $id;
		$this->update_end($update, $urly, $urlx);
	}

	public function delete_materi($id)
	{
		$tbl = $this->tbl_materi;
		$delete = $this->general->delete_data($tbl, $id);

		$urly = 'admin/materi';
		$urlx = 'admin/materi';
		$this->delete_end($delete, $urly, $urlx);
	}

	public function active_materi($id)
	{
		$tbl = $this->tbl_materi;
		$active = $this->general->active_data($tbl, $id);

		$urly = 'admin/materi';
		$urlx = 'admin/materi';
		$this->active_end($active, $urly, $urlx);
	}

	public function paket_soal()
	{
		//for passing data to view
		$data['content']['paket_soal'] = $this->tes->get_paket_soal();
		$data['title_header'] = ['title' => 'Paket Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
		$view['content'] = 'website/lembaga/tes_online/paket_soal/content';
		$view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function get_detail_paket_data($id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		//for passing data to view
		$data['content']['paket_soal'] = $this->tes->get_paket_soal_by_id($paket_soal_id);
		$data['title_header'] = ['title' => 'Detail Paket Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
		$view['content'] = 'website/lembaga/tes_online/paket_soal/detail';
		$view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_paket_soal()
	{
		//for passing data to view
		$data['content']['get_materi'] = $this->tes->get_materi_enable();
		$data['content']['get_kelas'] = $this->tes->get_kelas_enable();
		$data['content']['get_mode_jawaban'] = $this->tes->get_mode_jawaban_enable();
		$data['content']['get_skala_nilai'] = $this->tes->get_skala_nilai_enable();
		$data['content']['get_type_paket'] = $this->tes->get_type_paket();
		$data['content']['get_buku'] = $this->tes->get_buku_enable();
		$data['content']['get_detail_buku'] = $this->tes->get_detail_buku();
		$data['title_header'] = ['title' => 'Tambah Paket Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
		$view['content'] = 'website/lembaga/tes_online/paket_soal/add';
		$view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function get_count_free_buku()
	{
		$data = [];

		$id_buku = $this->input->post('buku_id');
		$buku_id_exp = explode("|", $id_buku);
		$buku_id = $buku_id_exp[0];

		$check_paket = $this->tes->get_buku_count_free($buku_id);
		$check_config_buku = $this->tes->get_buku_config_free($buku_id);

		$left_free = $check_config_buku - $check_paket;

		if ($left_free <= 0) {
			$status = 0;
			$text = '';
		} else {
			$status = 1;
			$text = 'Sisa ' . $left_free . ' paket buku yang bisa dijadikan gratis';
		}

		$data = array(
			'status' => $status,
			'text' => $text
		);

		header("Content-Type: application/json");

		echo json_encode($data);
	}

	public function submit_add_paket_soal()
	{
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$type_paket  = $this->input->post('type_paket', TRUE);
		$exp_type_paket = explode("|", $type_paket);
		$data['type_paket_id'] = $exp_type_paket[0];
		$data['type_paket_name'] = $exp_type_paket[1];

		$buku  = $this->input->post('buku', TRUE);
		$exp_buku = explode("|", $buku);
		$data['buku_id'] = $exp_buku[0];
		$data['buku_name'] = $exp_buku[1];

		$detail_buku  = $this->input->post('detail_buku', TRUE);
		$exp_detail_buku = explode("|", $detail_buku);
		$data['detail_buku_id'] = $exp_detail_buku[0];
		$data['detail_buku_name'] = $exp_detail_buku[1];

		$kelas  = $this->input->post('kelas', TRUE);
		$exp_kelas = explode("|", $kelas);
		$data['kelas_id'] = $exp_kelas[0];
		$data['kelas_name'] = $exp_kelas[1];
		$materi  = $this->input->post('materi', TRUE);
		$exp_materi = explode("|", $materi);
		$data['materi_id'] = $exp_materi[0];
		$data['materi_name'] = $exp_materi[1];
		$data['detail_mode_jwb_id'] = $this->input->post('mode_jawaban', TRUE);
		$data['is_free'] = $this->input->post('is_free', TRUE);
		$data['is_acak_soal'] = $this->input->post('acak_soal', TRUE);
		$data['is_acak_jawaban'] = $this->input->post('acak_jawaban', TRUE);
		$data['pengaturan_universal_id'] = $this->input->post('skala_nilai', TRUE);
		/* $data['skor_null'] = $this->input->post('skor_tdk_jwb', TRUE); */
		$data['is_continuous'] = $this->input->post('continous', TRUE);
		$data['is_jawab'] = $this->input->post('menjawab', TRUE);
		$petunjuk = $this->input->post('petunjuk_text');
		if ($petunjuk == '<p><br></p>') {
			$data['petunjuk'] = '';
		} else {
			$data['petunjuk'] = $petunjuk;
		}
		$data['visual_limit'] = $this->input->post('audio_limit', TRUE);
		$data['file'] = $this->input->post('petunjuk_audio', TRUE);
		$data['created_datetime'] = date('Y-m-d H:i:s');
		$data['created_by'] = $this->session->userdata('user_id');

		$allowed_type 	= [
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav"
		];
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/paket_soal/';
		$config['allowed_types']    = 'mpeg|mpg|mpeg3|mp3|wav|wave';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['petunjuk_audio']['name'])) {
			if (!$this->upload->do_upload('petunjuk_audio')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Audio Petunjuk Error');
				exit();
			} else {
				$data['file'] = $this->upload->data('file_name');
				$data['tipe_file'] = $this->upload->data('file_type');
			}
		}

		$tbl = $this->tbl_paket_soal;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/paket-soal';
		$urlx = 'admin/add-paket-soal';
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_paket_data($id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		//for passing data to view
		$paket_soal = $this->tes->get_paket_soal_by_id($paket_soal_id);
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['paket_soal'] = $paket_soal;
		$data['content']['get_materi'] = $this->tes->get_materi_selected($paket_soal->materi_id);
		$data['content']['get_kelas'] = $this->tes->get_kelas_selected($paket_soal->kelas_id);
		$data['content']['get_mode_jawaban'] = $this->tes->get_mode_jawaban_selected($paket_soal->detail_mode_jwb_id);
		$data['content']['get_skala_nilai'] = $this->tes->get_skala_nilai_selected($paket_soal->pengaturan_universal_id);
		$data['content']['get_buku'] = $this->tes->get_buku_selected($paket_soal->buku_id);
		$data['content']['get_type_paket'] = $this->tes->get_type_paket_selected($paket_soal->type_paket_id);
		$data['content']['get_detail_buku'] = $this->tes->get_detail_buku_selected($paket_soal->detail_buku_id);
		$data['title_header'] = ['title' => 'Edit Paket Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
		$view['content'] = 'website/lembaga/tes_online/paket_soal/edit';
		$view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_paket_soal()
	{
		$id_paket_soal = $this->input->post('id_paket_soal');
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$type_paket  = $this->input->post('type_paket', TRUE);
		$exp_type_paket = explode("|", $type_paket);
		$data['type_paket_id'] = $exp_type_paket[0];
		$data['type_paket_name'] = $exp_type_paket[1];

		$buku  = $this->input->post('buku', TRUE);
		$exp_buku = explode("|", $buku);
		$data['buku_id'] = $exp_buku[0];
		$data['buku_name'] = $exp_buku[1];

		$detail_buku  = $this->input->post('detail_buku', TRUE);
		$exp_detail_buku = explode("|", $detail_buku);
		$data['detail_buku_id'] = $exp_detail_buku[0];
		$data['detail_buku_name'] = $exp_detail_buku[1];

		$data['name'] = ucwords($this->input->post('name', TRUE));
		$kelas  = $this->input->post('kelas', TRUE);
		$exp_kelas = explode("|", $kelas);
		$data['kelas_id'] = $exp_kelas[0];
		$data['kelas_name'] = $exp_kelas[1];
		$materi  = $this->input->post('materi', TRUE);
		$exp_materi = explode("|", $materi);
		$data['materi_id'] = $exp_materi[0];
		$data['materi_name'] = $exp_materi[1];
		$data['detail_mode_jwb_id'] = $this->input->post('mode_jawaban', TRUE);
		$data['is_free'] = $this->input->post('is_free', TRUE);
		$data['is_acak_soal'] = $this->input->post('acak_soal', TRUE);
		$data['is_acak_jawaban'] = $this->input->post('acak_jawaban', TRUE);
		$data['pengaturan_universal_id'] = $this->input->post('skala_nilai', TRUE);
		/* $data['skor_null'] = $this->input->post('skor_tdk_jwb', TRUE); */
		$data['is_continuous'] = $this->input->post('continous', TRUE);
		$data['is_jawab'] = $this->input->post('menjawab', TRUE);
		$petunjuk = $this->input->post('petunjuk_text');
		if ($petunjuk == '<p><br></p>') {
			$data['petunjuk'] = '';
		} else {
			$data['petunjuk'] = $petunjuk;
		}
		$data['visual_limit'] = $this->input->post('audio_limit', TRUE);
		$data['file'] = $this->input->post('petunjuk_audio', TRUE);
		$old_name_audio = $this->input->post('old_name_audio');
		if ($old_name_audio == NULL || $old_name_audio == '') {
			$old_name_audio_x = NULL;
		} else {
			$old_name_audio_x = $old_name_audio;
		}
		$old_type_audio = $this->input->post('old_type_audio');
		if ($old_type_audio == NULL || $old_type_audio == '') {
			$old_type_audio_x = NULL;
		} else {
			$old_type_audio_x = $old_type_audio;
		}
		$data['updated_datetime'] = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('user_id');

		$allowed_type 	= [
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav"
		];
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/paket_soal/';
		$config['allowed_types']    = 'mpeg|mpg|mpeg3|mp3|wav|wave';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['petunjuk_audio']['name'])) {
			if (!$this->upload->do_upload('petunjuk_audio')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Audio Petunjuk Error');
				exit();
			} else {
				$data['file'] = $this->upload->data('file_name');
				$data['tipe_file'] = $this->upload->data('file_type');
			}
		} else {
			$data['file'] = $old_name_audio_x;
			$data['tipe_file'] = $old_type_audio_x;
		}

		$tbl = $this->tbl_paket_soal;
		$input = $this->general->update_data($tbl, $data, $paket_soal_id);

		$urly = 'admin/paket-soal';
		$urlx = 'admin/edit-paket-soal/' . $id_paket_soal;
		$this->update_end($input, $urly, $urlx);
	}

	public function disable_paket_data($id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$tbl = $this->tbl_paket_soal;
		$delete = $this->general->delete_data($tbl, $paket_soal_id);

		$urly = 'admin/paket-soal';
		$urlx = 'admin/paket-soal';
		$this->delete_end($delete, $urly, $urlx);
	}

	public function active_paket_data($id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$tbl = $this->tbl_paket_soal;
		$active = $this->general->active_data($tbl, $paket_soal_id);

		$urly = 'admin/paket-soal';
		$urlx = 'admin/paket-soal';
		$this->active_end($active, $urly, $urlx);
	}

	public function editor_paket_soal()
	{ //upload image dipaket soal petunjuk pengerjaan 
		$data = [];
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_petunjuk_paket_data');
		$target_dir = $this->input->post('folder', TRUE);

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/add-paket-soal');
		} else {
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777);
			}

			$config['upload_path']          = $target_dir;
			$config['allowed_types']        = 'jpg|png|jpeg';
			$config['max_size']             = 500;
			$config['remove_spaces']        = TRUE;
			$config['encrypt_name']         = TRUE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$datas = array(
					'link' => '',
					'csrf' => $this->security->get_csrf_hash()
				);
				/* $error = array('error' => $this->upload->display_errors());
                var_dump($error); */
			} else {
				$data = array('upload_data' => $this->upload->data());
				$datas = array(
					'link' => base_url() . $target_dir . $data['upload_data']['file_name'],
					'csrf' => $this->security->get_csrf_hash()
				);
			}
			echo json_encode($datas);
		}
	}

	public function editor_paket_soal_delete()
	{ //hapus upload image dipaket soal petunjuk pengerjaan
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_petunjuk_paket_data');
		$src = $this->input->post('src', TRUE);
		$file_name = str_replace(base_url(), '', $src);

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/add-paket-soal');
		} else {
			if (unlink($file_name)) {
				$datas = array(
					'text' => 'Success Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			} else {
				$datas = array(
					'text' => 'Failed Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			}

			echo json_encode($datas);
		}
	}

	public function list_soal($id_paket_soal, $search = null, $search_data = [])
	{
		//for passing data to view
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$data['content']['id_paket_soal'] = $id_paket_soal;

		$data['content']['paket_soal'] = $this->tes->get_paket_soal_by_id($paket_soal_id);

		if ($search) { //Search Aktif
			$data['content']['id_soal_list'] = $this->tes->get_all_soal_by_search($paket_soal_id, $search_data['group_soal_id'], $search_data['kata_kunci_soal']);
			$first_exam = $data['content']['id_soal_list'] != NULL ? $data['content']['id_soal_list'][0] : NULL; //Ambil Id Pertama soal yang muncul
			$data['content']['soal_first_list'] = $first_exam != NULL ? $first_exam->id : NULL;
		} else { //Search tidak aktif
			$data['content']['id_soal_list'] = $this->tes->get_all_soal_by_paketid($paket_soal_id);
			$first_exam = $data['content']['id_soal_list'] != NULL ? $data['content']['id_soal_list'][0] : NULL; //Ambil Id Pertama soal yang muncul
			$data['content']['soal_first_list'] = $first_exam != NULL ? $first_exam->id : NULL;
		}

		$data['content']['list_group_soal'] = $this->tes->get_all_group_by_paketid($paket_soal_id);
		$data['title_header'] = ['title' => 'Daftar Soal'];

		if (empty($data['content']['id_soal_list'])) { //Jika soal kosong
			$this->session->set_flashdata('error', 'Tidak ada soal!');
		}

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/soal/css';
		$view['content'] = 'website/lembaga/tes_online/soal/content';
		$view['js_additional'] = 'website/lembaga/tes_online/soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_search_soal()
	{
		$id_paket_soal = $this->input->post('id_paket_soal');
		$search_data['group_soal_id']  = $this->input->post('group_soal_id');
		$search_data['kata_kunci_soal']  = $this->input->post('kata_kunci_soal', TRUE);
		$search = 1;

		if ($search_data['group_soal_id'] === "" && $search_data['kata_kunci_soal'] === "") { //jika group soal yang di pilih all maka keluar semua data
			redirect('admin/list-soal/' . $id_paket_soal);
		} elseif ($search_data['group_soal_id'] === "all_soal") {
			redirect('admin/list-soal/' . $id_paket_soal);
		} else {
			$this->list_soal($id_paket_soal, $search, $search_data);
		}
	}

	public function get_detail_exam()
	{ //PENGAMBILAN SOAL 1 PER SATU
		$jawaban_soal = [];
		$header_soal = '';
		$content_soal = '';
		$datas = [];
		$soal = '';
		$jawaban = '';

		$paket_soal_id = $this->input->post('paket_soal_id');
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_tampil_soal');
		$bank_soal_id = $this->input->post('bank_soal_id', TRUE);
		$bank_soal_id_crypt = urlencode(base64_encode($bank_soal_id));
		$nomor_soal = $this->input->post('nomor_soal', TRUE);
		$id_paket_soal = base64_decode(urldecode($paket_soal_id));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/list-soal/' . $paket_soal_id);
		} else {
			$soal = $this->tes->get_soal_by_id($id_paket_soal, $bank_soal_id);
			$jawaban = $this->tes->get_jawaban_by_id($bank_soal_id, $id_paket_soal);

			$acak_soal_badge = $soal->is_acak_soal == 1 ? 'badge-success' : 'badge-danger';
			$acak_soal_icon = $soal->is_acak_soal == 1 ? 'fa-check' : 'fa-close';
			$acak_jwb_badge = $soal->is_acak_jawaban == 1 ? 'badge-success' : 'badge-danger';
			$acak_jwb_icon = $soal->is_acak_jawaban == 1 ? 'fa-check' : 'fa-close';
			$cek_group_mode_jwb = $soal->group_mode_jwb_id == 1 ? '' : 'style="display:none;"'; //1 Pilihan ganda 2 essay
			$bacaan_soal = $soal->isi_bacaan_soal <> 0 || !empty($soal->isi_bacaan_soal) ? $soal->isi_bacaan_soal . '<br />' : ''; // bacaan soal
			$bacaan_soal_name = $soal->bacaan_soal_name <> 0 || !empty($soal->bacaan_soal_name) ? '<b>' . $soal->bacaan_soal_name . '</b><br />' : ''; // bacaan soal judul
			$group_soal = $soal->group_soal_name <> 0 || !empty($soal->group_soal_name) ? '<div class="col-12 text-left"><span class="badge badge-success">Group Soal ' . $soal->group_soal_name . '</span></div>' : '';
			$group_soal_petunjuk = $soal->group_soal_petunjuk <> 0 || !empty($soal->group_soal_petunjuk) ? $soal->group_soal_petunjuk . '<br />' : '';
			$group_soal_audio = $soal->group_soal_audio <> 0 || !empty($soal->group_soal_audio) ? '<audio id="loop-limited" controls><source src="' . config_item('_dir_website') . '/lembaga/grandsbmptn/group_soal/group_' . $soal->paket_soal_id . '/' . $soal->group_soal_audio . '" type="' . $soal->group_soal_tipe_audio . '">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br />' : '';
			$soal_audio = $soal->file <> 0 || !empty($soal->file) ? '<audio id="loop-limited" controls><source src="' . config_item('_dir_website') . '/lembaga/grandsbmptn/paket_soal/soal_' . $soal->paket_soal_id . '/' . $soal->file . '" type="' . $soal->tipe_file . '">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br />' : '';
			$pembahasan = $soal->url_pembahasan <> '' || !empty($soal->url_pembahasan) || $soal->pembahasan <> '' || !empty($soal->pembahasan) ? '' : 'style="display:none;"';

			$header_soal = '
            <div class="row">
                <div class="col-8 p-1">
                    <h5 class="text-white">
                        <i class="fa fa-braille" aria-hidden="true"></i> Soal No ' . $nomor_soal . '
                        <span class="badge badge-success">' . $soal->group_mode_jwb_name . '</span>
                        <span class="badge ' . $acak_soal_badge . '">
                            <i class="fa ' . $acak_soal_icon . '" aria-hidden="true"></i> Acak Soal
                        </span>
                        <span ' . $cek_group_mode_jwb . ' class="badge ' . $acak_jwb_badge . '">
                            <i class="fa ' . $acak_jwb_icon . '" aria-hidden="true"></i> Acak Jawaban
                        </span>
                        <span ' . $pembahasan . ' class="badge badge-success">
                            <i class="fa fa-check" aria-hidden="true"></i> Ada Pembahasan
                        </span>
                    </h5>
                </div>
                <div class="col-4 text-right">
                        <a href="' . base_url() . 'admin/edit-soal/' . $paket_soal_id . '/' . $bank_soal_id_crypt . '/' . $nomor_soal . '" class="btn btn-sm btn-success" title="Edit Soal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="' . base_url() . 'admin/disable-soal/' . $paket_soal_id . '/' . $bank_soal_id_crypt . '/' . $nomor_soal . '" class="btn btn-sm btn-danger" title="Hapus Soal" onclick="return confirm(' . "'Apakah kamu yakin menghapus soal no $nomor_soal ? Setelah soal ini dihapus otomatis sistem akan mengurutkan urutan soal kembali'" . ')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </div>
                ' . $group_soal . '
            </div>';

			$content_soal = '<div class="card-text text-justify">' . $group_soal_petunjuk . $group_soal_audio . $bacaan_soal_name . $bacaan_soal . $soal_audio . $soal->bank_soal_name . '</div>';

			$opsi = config_item('_def_opsi_jawaban');
			foreach ($jawaban as $key_jawaban => $val_jawaban) {
				$is_key = $val_jawaban->is_key == 1 ? 'checked' : 'disabled';
				$jawaban_soal[] = '<div class="funkyradio-success">
                        <input type="radio" id="opsi_' . $opsi . '" name="opsi" value="' . $val_jawaban->order . '" ' . $is_key . '> 
                        <label for="opsi_' . $opsi . '">
                            <div class="huruf_opsi">' . $opsi . '</div> 
                            <div class="card-text">' . $val_jawaban->name . '</div>
                        </label>
                    </div>';
				$opsi++;
			};

			$datas = array(
				'header_soal' => $header_soal,
				'content_soal' => $content_soal,
				'jawaban_soal' => implode(" ", $jawaban_soal),
				'csrf' => $this->security->get_csrf_hash()
			);

			echo json_encode($datas);
		}
	}

	public function add_soal($id_paket_soal)
	{
		//for passing data to view
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$mode_jawaban = $this->tes->get_total_mode_jwb($paket_soal_id); //Untuk soal pilihan ganda
		$total_soal = $this->tes->get_total_soal($paket_soal_id); //Total soal
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['count_pilihan_ganda'] = intval($mode_jawaban->count_pilgan);
		$data['content']['total_soal'] = intval($total_soal->total_soal);
		$data['content']['jenis_soal'] = $this->tes->get_jenis_soal_enable();
		$data['content']['tipe_kesulitan'] = $this->tes->get_tipe_kesulitan_enable();
		$data['content']['group_soal'] = $this->tes->get_group_soal($paket_soal_id);
		$data['content']['bacaan_soal'] = $this->tes->get_bacaan_soal($paket_soal_id);
		$data['title_header'] = ['title' => 'Tambah Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/soal/css';
		$view['content'] = 'website/lembaga/tes_online/soal/add';
		$view['js_additional'] = 'website/lembaga/tes_online/soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_soal()
	{
		$data = [];
		$datas = [];
		$pembahasan = [];

		$paket_soal_id = $this->input->post('id_paket_soal'); //EncryptIdPaketSoal
		$type_exam = $this->input->post('jenis_soal', TRUE);
		//SAVE SOAL
		$data['paket_soal_id']  = base64_decode(urldecode($this->input->post('id_paket_soal', TRUE)));
		$data['group_mode_jwb_id']  = $this->input->post('jenis_soal', TRUE);
		$data['no_soal']  = $this->input->post('no_soal', TRUE);
		$name  = $this->input->post('soal');
		if ($name == '<p><br></p>') {
			$data['name'] = '';
		} else {
			$data['name'] = $name;
		}
		$data['kata_kunci']  = $this->input->post('kata_kunci', TRUE);
		$data['tipe_kesulitan_id']  = $this->input->post('tipe_kesulitan', TRUE);
		$data['is_acak_soal']  = $this->input->post('acak_soal', TRUE);
		$data['is_acak_jawaban']  = $this->input->post('acak_jawaban', TRUE);
		$data['group_soal_id']  = $this->input->post('group_soal_id', TRUE);
		$data['bacaan_soal_id']  = $this->input->post('bacaan_soal_id', TRUE);
		$data['file']  = $this->input->post('soal_audio', TRUE);
		$data['created_datetime']  = date('Y-m-d H:i:s');

		$allowed_type 	= [
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav"
		];
		$_id_paket_soal = $data['paket_soal_id'];
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/paket_soal/soal_' . $_id_paket_soal . '/';
		$config['allowed_types']    = 'mpeg|mpg|mpeg3|mp3|wav|wave';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['soal_audio']['name'])) {
			if (!$this->upload->do_upload('soal_audio')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Audio Soal Error');
				exit();
			} else {
				$data['file'] = $this->upload->data('file_name');
				$data['tipe_file'] = $this->upload->data('file_type');
			}
		}

		$save_soal = $this->tes->save_soal($data);

		//SAVE JAWABAN
		if ($save_soal) {
			if ($type_exam == 1) { //Tipe pilihan ganda memerlukan jawaban
				$jawaban = $this->input->post('jawaban');
				$skor_jawaban = $this->input->post('skor_jawaban', TRUE);
				$tandai_jawaban  = $this->input->post('tanda_jawaban', TRUE);
				$order = 1;
				$datas = array();
				foreach ($jawaban as $key => $value) {
					$datas[]  = array(
						'bank_soal_id' => $save_soal,
						'order' => $order,
						'name' => $jawaban[$key],
						'score' => $skor_jawaban[$key],
						'is_key' => $order == $tandai_jawaban ? 1 : 0,
						'created_datetime' => date('Y-m-d H:i:s')
					);
					$order++;
				}

				$save_jawaban = $this->tes->save_jawaban($datas);

				//Pembahasan
				$pembahasan['bank_soal_id'] = $save_soal;
				$url = $this->input->post('url');
				$pembahasan['url'] = str_replace("watch?v=", "embed/", $url);
				$pembahasan['pembahasan'] = $this->input->post('pembahasan');
				$pembahasan['created_datetime'] = date('Y-m-d H:i:s');

				$save_pembahasan = $this->tes->save_pembahasan($pembahasan);

				$urly = 'admin/list-soal/' . $paket_soal_id;
				$urlx = 'admin/add-soal/' . $paket_soal_id;
				$this->input_end($save_jawaban, $urly, $urlx);
			} else { //tipe essay tidak perlu jawaban
				//Pembahasan
				$pembahasan['bank_soal_id'] = $save_soal;
				$url = $this->input->post('url');
				$pembahasan['url'] = str_replace("watch?v=", "embed/", $url);
				$pembahasan['pembahasan'] = $this->input->post('pembahasan');
				$pembahasan['created_datetime'] = date('Y-m-d H:i:s');

				$save_pembahasan = $this->tes->save_pembahasan($pembahasan);

				$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
				redirect('admin/list-soal/' . $paket_soal_id);
			}
		} else {
			$this->session->set_flashdata('error', 'Data gagal disimpan! Ulangi kembali');
			redirect('admin/add-soal/' . $paket_soal_id);
		}
	}

	public function import_soal($id_paket_soal, $datas = NULL)
	{
		$name_config = 'TEMPLATE UPLOAD';
		$detail_config = 'UPLOAD DATA SOAL';
		//for passing data to view
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['file_template'] = $this->tes->get_pengaturan_universal_id($name_config, $detail_config);
		if (!empty($datas)) {
			$data['content']['message'] = $datas;
		} else {
			$data['content']['message'] = '';
		}
		$data['title_header'] = ['title' => 'Upload Excel Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/soal/css';
		$view['content'] = 'website/lembaga/tes_online/soal/upload_excel';
		$view['js_additional'] = 'website/lembaga/tes_online/soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_upload_add_soal()
	{
		$id_paket_soal = $this->input->post('id_paket_soal');
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$group_mode_jwb = '';
		$soal = '';
		$jawaban = '';
		$kata_kunci = '';
		$tingkat_kesulitan = '';
		$kode_group_soal = '';
		$kode_group_bacaan = '';
		$acak_soal = '';
		$acak_jawaban = '';
		$A = '';
		$B = '';
		$C = '';
		$D = '';
		$E = '';
		$url_pembahasan = '';
		$isi_pembahasan = '';
		$data = [];

		if ($_FILES["data_soal"]["name"] != '') {
			$allowed_extension = array('xls', 'xlsx');
			$file_array = explode(".", $_FILES["data_soal"]["name"]);
			$file_extension = end($file_array);

			if (in_array($file_extension, $allowed_extension)) {
				$file_name = time() . '.' . $file_extension;
				move_uploaded_file($_FILES['data_soal']['tmp_name'], $file_name);
				$file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

				$spreadsheet = $reader->load($file_name);

				unlink($file_name);

				$data = $spreadsheet->getActiveSheet()->toArray();

				$no_null = 0;
				$no_upload = 0;
				//Detail data untuk peserta dan user
				foreach ($data as $key => $row) {
					if ($key > 0 && ($row[0] != '' && $row[1] != '')) { //Header tidak diikutkan di save
						//Cleaning whitespace
						$group_mode_jwb = strtoupper(trim($row[0]));
						$soal = trim($row[1]);
						$jawaban = strtoupper(trim($row[2]));
						$kata_kunci = trim($row[3]);
						$tingkat_kesulitan = trim($row[4]);
						$kode_group_soal = strtoupper(trim($row[5]));
						$kode_group_bacaan = strtoupper(trim($row[6]));
						$acak_soal = trim($row[7]);
						$acak_jawaban = trim($row[8]);
						$A = trim($row[9]);
						$B = trim($row[10]);
						$C = trim($row[11]);
						$D = trim($row[12]);
						$E = trim($row[13]);
						$url_pembahasan = trim($row[14]);
						$isi_pembahasan = trim($row[15]);

						//Insert data soal
						$soal = $this->insert_data_soal($paket_soal_id, $group_mode_jwb, $soal, $kata_kunci, $tingkat_kesulitan, $kode_group_soal, $kode_group_bacaan, $acak_soal, $acak_jawaban);

						//Insert data jawaban
						$jawaban = $this->insert_data_jawaban($soal, $group_mode_jwb, $A, $B, $C, $D, $E, $jawaban);

						//Insert data pembahasan
						$pembahasan = $this->insert_data_pembahasan($soal, $url_pembahasan, $isi_pembahasan);

						$no_upload++;
					} elseif ($key > 0 && ($row[0] == '' && $row[1] == '')) {
						$no_null++;
					}
				}

				if ($no_null) {
					$text = '<div class="alert alert-info">' . $no_upload . ' Data berhasil disimpan, Tetapi Terdapat ' . $no_null . ' data upload yang gagal, periksa kembali jika ada soal yang masih kosong</div>';
					$this->import_soal($id_paket_soal, $text);
				} else {
					$text = '<div class="alert alert-success">' . $no_upload . ' Data berhasil disimpan</div>';
					$this->import_soal($id_paket_soal, $text);
				}
			} else {
				$text = '<div class="alert alert-danger">Hanya tipe excel .xls dan .xlsx yang diijinkan</div>';
				$this->import_soal($id_paket_soal, $text);
			}
		} else {
			$text = '<div class="alert alert-danger">Tidak ada file yang diupload</div>';
			$this->import_soal($id_paket_soal, $text);
		}
	}

	public function insert_data_soal($paket_soal_id, $group_mode_jwb, $soal, $kata_kunci, $tingkat_kesulitan, $kode_group_soal, $kode_group_bacaan, $acak_soal, $acak_jawaban)
	{
		$data = [];

		$data['paket_soal_id'] = $paket_soal_id;

		if ($group_mode_jwb == 'PG') {
			$data['group_mode_jwb_id'] = 1; //1 Pilihan Ganda //2 Essay
		} else {
			$data['group_mode_jwb_id'] = 2;
		}

		$get_total_soal = $this->tes->get_paket_soal_by_id($paket_soal_id);
		$total_soal = $get_total_soal->total_soal;
		$data['no_soal'] = $total_soal + 1;

		$data['name'] = $soal;
		$data['kata_kunci'] = $kata_kunci;

		if ($tingkat_kesulitan == 0 || $tingkat_kesulitan == '' || $tingkat_kesulitan === NULL) {
			$data['tipe_kesulitan_id'] = 1;
		} else {
			$data['tipe_kesulitan_id'] = $tingkat_kesulitan;
		}

		if ($kode_group_soal != 0 || $kode_group_soal != '' || $kode_group_soal !== NULL) {
			$check_kode_group = $this->tes->get_group_soal_by_kode($kode_group_soal, $paket_soal_id);
			$data['group_soal_id'] = $check_kode_group->id_group_soal;
		} else {
			$data['group_soal_id'] = NULL;
		}

		if ($kode_group_bacaan != 0 || $kode_group_bacaan != '' || $kode_group_bacaan !== NULL) {
			$check_kode_bacaan = $this->tes->get_bacaan_soal_by_kode($kode_group_bacaan, $paket_soal_id);
			$data['bacaan_soal_id'] = $check_kode_bacaan->id;
		} else {
			$data['bacaan_soal_id'] = NULL;
		}

		$data['is_acak_soal'] = $acak_soal == '' ? 0 : $acak_soal;
		$data['is_acak_jawaban'] = $acak_jawaban == '' ? 0 : $acak_jawaban;
		$data['created_datetime'] = date('Y-m-d H:i:s');

		$input = $this->tes->save_soal($data);

		if ($input) {
			return $input;
		} else {
			$this->session->set_flashdata('error', 'Data gagal disimpan! Kesalahan saat menyimpan soal. Ulangi kembali');
			redirect('admin/import-soal/' . urlencode(base64_encode($paket_soal_id)));
		}
	}

	public function insert_data_jawaban($soal, $group_mode_jwb, $A, $B, $C, $D, $E, $jawaban)
	{
		if ($group_mode_jwb == 'PG') {
			if ($jawaban == 'A') {
				$key = 1;
			} elseif ($jawaban == 'B') {
				$key = 2;
			} elseif ($jawaban == 'C') {
				$key = 3;
			} elseif ($jawaban == 'D') {
				$key = 4;
			} elseif ($jawaban == 'E') {
				$key = 5;
			}

			if ($A != '') {
				$data = [];
				$order_a = 1;
				$data = array(
					'bank_soal_id' => $soal,
					'order' => $order_a,
					'name' => $A,
					'score' => $order_a == $key ? 1 : 0,
					'is_key' => $order_a == $key ? 1 : 0,
					'created_datetime' => date('Y-m-d H:i:s')
				);
				$input = $this->tes->save_jawaban_single($data);
			}
			if ($B != '') {
				$data = [];
				$order_b = 2;
				$data = array(
					'bank_soal_id' => $soal,
					'order' => $order_b,
					'name' => $B,
					'score' => $order_b == $key ? 1 : 0,
					'is_key' => $order_b == $key ? 1 : 0,
					'created_datetime' => date('Y-m-d H:i:s')
				);
				$input = $this->tes->save_jawaban_single($data);
			}
			if ($C != '') {
				$data = [];
				$order_c = 3;
				$data = array(
					'bank_soal_id' => $soal,
					'order' => $order_c,
					'name' => $C,
					'score' => $order_c == $key ? 1 : 0,
					'is_key' => $order_c == $key ? 1 : 0,
					'created_datetime' => date('Y-m-d H:i:s')
				);
				$input = $this->tes->save_jawaban_single($data);
			}
			if ($D != '') {
				$data = [];
				$order_d = 4;
				$data = array(
					'bank_soal_id' => $soal,
					'order' => $order_d,
					'name' => $D,
					'score' => $order_d == $key ? 1 : 0,
					'is_key' => $order_d == $key ? 1 : 0,
					'created_datetime' => date('Y-m-d H:i:s')
				);
				$input = $this->tes->save_jawaban_single($data);
			}
			if ($E != '') {
				$data = [];
				$order_e = 5;
				$data = array(
					'bank_soal_id' => $soal,
					'order' => $order_e,
					'name' => $E,
					'score' => $order_e == $key ? 1 : 0,
					'is_key' => $order_e == $key ? 1 : 0,
					'created_datetime' => date('Y-m-d H:i:s')
				);
				$input = $this->tes->save_jawaban_single($data);
			}

			return true;
		} else {
			return true;
		}
	}

	public function insert_data_pembahasan($soal, $url_pembahasan, $isi_pembahasan)
	{
		$data = [];

		if ($url_pembahasan != '' || $isi_pembahasan != '') {
			$data['bank_soal_id'] = $soal;
			$data['url'] = $url_pembahasan;
			$data['pembahasan'] = $isi_pembahasan;
			$data['created_datetime'] = date('Y-m-d H:i:s');

			$save_pembahasan = $this->tes->save_pembahasan($data);

			return true;
		} else {
			return true;
		}
	}

	public function editor_soal()
	{ //upload image disoal
		$data = [];
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_input_soal_data');
		$target_dir = $this->input->post('folder', TRUE);
		$paket_soal_id = urlencode(base64_encode($this->input->post('id_paket_soal')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/add-soal/' . $paket_soal_id);
		} else {
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777);
			}

			$config['upload_path']          = $target_dir;
			$config['allowed_types']        = 'jpg|png|jpeg';
			$config['max_size']             = 500;
			$config['remove_spaces']        = TRUE;
			$config['encrypt_name']         = TRUE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$datas = array(
					'link' => '',
					'csrf' => $this->security->get_csrf_hash()
				);
				/* $error = array('error' => $this->upload->display_errors());
                var_dump($error); */
			} else {
				$data = array('upload_data' => $this->upload->data());
				$datas = array(
					'link' => base_url() . $target_dir . $data['upload_data']['file_name'],
					'csrf' => $this->security->get_csrf_hash()
				);
			}
			echo json_encode($datas);
		}
	}

	public function editor_soal_delete()
	{ //hapus upload image dipaket soal petunjuk pengerjaan
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_input_soal_data');
		$src = $this->input->post('src', TRUE);
		$file_name = str_replace(base_url(), '', $src);
		$paket_soal_id = urlencode(base64_encode($this->input->post('id_paket_soal')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/add-soal/' . $paket_soal_id);
		} else {
			if (unlink($file_name)) {
				$datas = array(
					'text' => 'Success Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			} else {
				$datas = array(
					'text' => 'Failed Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			}

			echo json_encode($datas);
		}
	}

	public function edit_soal($id_paket_soal, $id_bank_soal, $nomor_soal)
	{
		//for passing data to view
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$bank_soal_id = base64_decode(urldecode($id_bank_soal));
		$soal_detail = $this->tes->get_soal_by_id($paket_soal_id, $bank_soal_id); //Detail soal
		$jawaban_detail = $this->tes->get_jawaban_detail($bank_soal_id); //Detail jawaban
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['id_bank_soal'] = $id_bank_soal;
		$data['content']['nomor_soal'] = $nomor_soal;
		$data['content']['soal_detail'] = $soal_detail;
		$data['content']['jawaban_detail'] = $jawaban_detail;
		$data['content']['jenis_soal'] = $this->tes->get_jenis_soal_selected($soal_detail->group_mode_jwb_id);
		$data['content']['tipe_kesulitan'] = $this->tes->get_tipe_kesulitan_selected($soal_detail->tipe_kesulitan_id);
		$data['content']['group_soal'] = $this->tes->get_group_soal_selected($paket_soal_id, $soal_detail->group_soal_id);
		$data['content']['bacaan_soal'] = $this->tes->get_bacaan_soal_selected($paket_soal_id, $soal_detail->bacaan_soal_id);
		$data['content']['pembahasan'] = $this->tes->get_pembahasan($bank_soal_id);
		$data['title_header'] = ['title' => 'Edit Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/soal/css';
		$view['content'] = 'website/lembaga/tes_online/soal/edit';
		$view['js_additional'] = 'website/lembaga/tes_online/soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_soal()
	{
		$paket_soal_id = $this->input->post('id_paket_soal'); //EncryptIdPaketSoal
		$bank_soal_id = $this->input->post('id_bank_soal'); //EncryptIdBankSoal
		$type_exam = $this->input->post('jenis_soal', TRUE);
		$nomor_soal = $this->input->post('no_soal', TRUE);
		//SAVE SOAL
		$id_bank_soal = base64_decode(urldecode($bank_soal_id));
		$data['paket_soal_id']  = base64_decode(urldecode($this->input->post('id_paket_soal', TRUE)));
		$data['group_mode_jwb_id']  = $type_exam;
		$data['no_soal']  = $nomor_soal;
		$name  = $this->input->post('soal');
		if ($name == '<p><br></p>') {
			$data['name'] = '';
		} else {
			$data['name'] = $name;
		}
		$data['kata_kunci']  = $this->input->post('kata_kunci', TRUE);
		$data['tipe_kesulitan_id']  = $this->input->post('tipe_kesulitan', TRUE);
		$data['is_acak_soal']  = $this->input->post('acak_soal', TRUE);
		$data['is_acak_jawaban']  = $this->input->post('acak_jawaban', TRUE);
		$data['group_soal_id']  = $this->input->post('group_soal_id', TRUE);
		$data['bacaan_soal_id']  = $this->input->post('bacaan_soal_id', TRUE);
		$data['file']  = $this->input->post('soal_audio', TRUE);
		$old_name_audio = $this->input->post('old_name_audio');
		if ($old_name_audio == NULL || $old_name_audio == '') {
			$old_name_audio_x = NULL;
		} else {
			$old_name_audio_x = $old_name_audio;
		}
		$old_type_audio = $this->input->post('old_type_audio');
		if ($old_type_audio == NULL || $old_type_audio == '') {
			$old_type_audio_x = NULL;
		} else {
			$old_type_audio_x = $old_type_audio;
		}
		$data['updated_datetime']  = date('Y-m-d H:i:s');

		$allowed_type 	= [
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav"
		];
		$_id_paket_soal = $data['paket_soal_id'];
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/paket_soal/soal_' . $_id_paket_soal . '/';
		$config['allowed_types']    = 'mpeg|mpg|mpeg3|mp3|wav|wave';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['soal_audio']['name'])) {
			if (!$this->upload->do_upload('soal_audio')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Audio Soal Error');
				exit();
			} else {
				$data['file'] = $this->upload->data('file_name');
				$data['tipe_file'] = $this->upload->data('file_type');
			}
		} else {
			$data['file'] = $old_name_audio_x;
			$data['tipe_file'] = $old_type_audio_x;
		}

		$update_soal = $this->tes->update_soal($id_bank_soal, $data);

		//SAVE JAWABAN
		if ($update_soal) {
			if ($type_exam == 1) { //Tipe pilihan ganda memerlukan jawaban
				$jawaban = $this->input->post('jawaban');
				$id_jawaban = $this->input->post('id_jawaban', TRUE);
				$skor_jawaban = $this->input->post('skor_jawaban', TRUE);
				$tandai_jawaban  = $this->input->post('tanda_jawaban', TRUE);
				$order = 1;
				$datas = array();
				foreach ($jawaban as $key => $value) {
					$datas[] = array(
						'id' => $id_jawaban[$key],
						'bank_soal_id' => $id_bank_soal,
						'order' => $order,
						'name' => $jawaban[$key],
						'score' => $skor_jawaban[$key],
						'is_key' => $order == $tandai_jawaban ? 1 : 0,
						'updated_datetime' => date('Y-m-d H:i:s')
					);
					$order++;
				}

				$update_jawaban = $this->tes->update_jawaban($datas);

				//Update pembahasan
				$url = $this->input->post('url');
				$pembahasan['url'] = str_replace("watch?v=", "embed/", $url);
				$pembahasan['pembahasan'] = $this->input->post('pembahasan');
				$pembahasan['updated_datetime'] = date('Y-m-d H:i:s');

				$update_pembahasan = $this->tes->update_pembahasan($id_bank_soal, $pembahasan);

				$urly = 'admin/list-soal/' . $paket_soal_id;
				$urlx = 'admin/edit-soal/' . $paket_soal_id . '/' . $bank_soal_id . '/' . $nomor_soal;
				$this->update_end($update_jawaban, $urly, $urlx);
			} else { //tipe essay tidak perlu jawaban
				//Update pembahasan
				$url = $this->input->post('url');
				$pembahasan['url'] = str_replace("watch?v=", "embed/", $url);
				$pembahasan['pembahasan'] = $this->input->post('pembahasan');
				$pembahasan['updated_datetime'] = date('Y-m-d H:i:s');

				$update_pembahasan = $this->tes->update_pembahasan($id_bank_soal, $pembahasan);

				$this->session->set_flashdata('success', 'Soal no ' . $nomor_soal . ' berhasil diubah');
				redirect('admin/list-soal/' . $paket_soal_id);
			}
		} else {
			$this->session->set_flashdata('error', 'Soal no ' . $nomor_soal . ' gagal diubah! Ulangi kembali');
			redirect('admin/edit-soal/' . $paket_soal_id . '/' . $bank_soal_id . '/' . $nomor_soal);
		}
	}

	public function disable_soal($id_paket_soal, $id_bank_soal, $nomor_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$bank_soal_id = base64_decode(urldecode($id_bank_soal));

		$disable_soal = $this->tes->disable_soal($paket_soal_id, $bank_soal_id);

		if (!empty($disable_soal)) {
			$exam_order = $this->general->exam_order($paket_soal_id); //Urutin no soal lagi

			$this->session->set_flashdata('success', 'Soal no ' . $nomor_soal . ' berhasil dihapus');
			redirect('admin/list-soal/' . $id_paket_soal);
		} else {
			$this->session->set_flashdata('error', 'Soal no ' . $nomor_soal . ' gagal dihapus!');
			redirect('admin/list-soal/' . $id_paket_soal);
		}
	}

	public function disable_all_soal($id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$get_all_soal_id = $this->tes->get_all_soal_by_paketid($paket_soal_id); //Ambil semua id soal, untuk penghapusan jawaban
		$disable_all_soal = $this->tes->disable_all_soal($paket_soal_id, $get_all_soal_id); //disable semua soal dan jawabannya

		if (!empty($disable_all_soal)) {
			$this->session->set_flashdata('success', 'Paket soal berhasil dikosongkan');
			redirect('admin/list-soal/' . $id_paket_soal);
		} else {
			$this->session->set_flashdata('error', 'Paket soal gagal dikosongkan!');
			redirect('admin/list-soal/' . $id_paket_soal);
		}
	}

	public function bacaan_soal($id_paket_soal)
	{
		$paket_soal_id =  base64_decode(urldecode($id_paket_soal));
		//for passing data to view
		$data['content']['bacaan_soal'] = $this->tes->get_bacaan_soal($paket_soal_id);
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['title_header'] = ['title' => 'Bacaan Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/bacaan_soal/css';
		$view['content'] = 'website/lembaga/tes_online/bacaan_soal/content';
		$view['js_additional'] = 'website/lembaga/tes_online/bacaan_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_bacaan_soal($id_paket_soal)
	{
		//for passing data to view
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['title_header'] = ['title' => 'Add Bacaan Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/bacaan_soal/css';
		$view['content'] = 'website/lembaga/tes_online/bacaan_soal/add';
		$view['js_additional'] = 'website/lembaga/tes_online/bacaan_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_bacaan_soal()
	{
		$id_paket_soal = $this->input->post('id_paket_soal');
		$data['paket_soal_id'] = base64_decode(urldecode($id_paket_soal));
		$data['name'] = $this->input->post('name', TRUE);
		$data['kode_bacaan'] = strtoupper($this->input->post('kode_bacaan', TRUE));
		$bacaan = $this->input->post('bacaan');
		if ($bacaan == '<p><br></p>') {
			$data['bacaan'] = '';
		} else {
			$data['bacaan'] = $bacaan;
		}
		$data['created_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_bacaan_soal;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/bacaan-soal/' . $id_paket_soal;
		$urlx = 'admin/add-bacaan-soal/' . $id_paket_soal;
		$this->input_end($input, $urly, $urlx);
	}

	public function editor_bacaan_soal()
	{ //upload image di bacaan soal
		$data = [];
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_bacaan_soal');
		$target_dir = $this->input->post('folder', TRUE);
		$paket_soal_id = urlencode(base64_encode($this->input->post('id_paket_soal')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/bacaan-soal/' . $paket_soal_id);
		} else {
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777);
			}

			$config['upload_path']   = $target_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']      = 500;
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$datas = array(
					'link' => '',
					'csrf' => $this->security->get_csrf_hash()
				);
			} else {
				$data = array('upload_data' => $this->upload->data());
				$datas = array(
					'link' => base_url() . $target_dir . $data['upload_data']['file_name'],
					'csrf' => $this->security->get_csrf_hash()
				);
			}
			echo json_encode($datas);
		}
	}

	public function editor_bacaan_soal_delete()
	{ //hapus upload image dipaket soal bacaan
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_bacaan_soal');
		$src = $this->input->post('src', TRUE);
		$file_name = str_replace(base_url(), '', $src);
		$paket_soal_id = urlencode(base64_encode($this->input->post('id_paket_soal')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/bacaan-soal/' . $paket_soal_id);
		} else {
			if (unlink($file_name)) {
				$datas = array(
					'text' => 'Success Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			} else {
				$datas = array(
					'text' => 'Failed Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			}

			echo json_encode($datas);
		}
	}

	public function detail_bacaan_soal($id_bacaan_soal)
	{
		$bacaan_soal_id = base64_decode(urldecode($id_bacaan_soal));

		//for passing data to view
		$data['content']['bacaan_soal'] = $this->tes->get_bacaan_soal_by_id($bacaan_soal_id);
		$data['title_header'] = ['title' => 'Detail Bacaan Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/bacaan_soal/css';
		$view['content'] = 'website/lembaga/tes_online/bacaan_soal/detail';
		$view['js_additional'] = 'website/lembaga/tes_online/bacaan_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function edit_bacaan_soal($id_bacaan_soal, $id_paket_soal)
	{
		$bacaan_soal_id = base64_decode(urldecode($id_bacaan_soal));

		//for passing data to view
		$data['content']['bacaan_soal'] = $this->tes->get_bacaan_soal_by_id($bacaan_soal_id);
		$data['content']['id_bacaan_soal'] = $id_bacaan_soal;
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['title_header'] = ['title' => 'Edit Bacaan Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/bacaan_soal/css';
		$view['content'] = 'website/lembaga/tes_online/bacaan_soal/edit';
		$view['js_additional'] = 'website/lembaga/tes_online/bacaan_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_bacaan_soal()
	{
		$bacaan_soal_id_crypt = $this->input->post('id_bacaan_soal');
		$bacaan_soal_id = base64_decode(urldecode($bacaan_soal_id_crypt));
		$paket_soal_id_crypt = $this->input->post('id_paket_soal');
		$paket_soal_id = base64_decode(urldecode($paket_soal_id_crypt));

		$data['name'] = $this->input->post('name', TRUE);
		$data['kode_bacaan'] = strtoupper($this->input->post('kode_bacaan', TRUE));
		$bacaan = $this->input->post('bacaan');
		if ($bacaan == '<p><br></p>') {
			$data['bacaan'] = '';
		} else {
			$data['bacaan'] = $bacaan;
		}
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$update = $this->tes->update_bacaan_soal($data, $bacaan_soal_id, $paket_soal_id);

		$urly = 'admin/bacaan-soal/' . $paket_soal_id_crypt;
		$urlx = 'admin/edit-bacaan-soal/' . $bacaan_soal_id_crypt;
		$this->update_end($update, $urly, $urlx);
	}

	public function disable_bacaan_soal($id_bacaan_soal, $id_paket_soal)
	{
		$bacaan_soal_id = base64_decode(urldecode($id_bacaan_soal));

		$tbl = $this->tbl_bacaan_soal;
		$delete = $this->general->delete_data($tbl, $bacaan_soal_id);

		$urly = 'admin/bacaan-soal/' . $id_paket_soal;
		$urlx = 'admin/paket-soal/' . $id_paket_soal;
		$this->delete_end($delete, $urly, $urlx);
	}

	public function group_soal($id_paket_soal)
	{
		$paket_soal_id =  base64_decode(urldecode($id_paket_soal));
		//for passing data to view
		$data['content']['group_soal'] = $this->tes->get_group_soal($paket_soal_id);
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['title_header'] = ['title' => 'Group Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/group_soal/css';
		$view['content'] = 'website/lembaga/tes_online/group_soal/content';
		$view['js_additional'] = 'website/lembaga/tes_online/group_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function editor_group_soal()
	{ //upload image di bacaan soal
		$data = [];
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_group_soal');
		$target_dir = $this->input->post('folder', TRUE);
		$paket_soal_id = urlencode(base64_encode($this->input->post('id_paket_soal')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/group-soal/' . $paket_soal_id);
		} else {
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777);
			}

			$config['upload_path']   = $target_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']      = 500;
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$datas = array(
					'link' => '',
					'csrf' => $this->security->get_csrf_hash()
				);
			} else {
				$data = array('upload_data' => $this->upload->data());
				$datas = array(
					'link' => base_url() . $target_dir . $data['upload_data']['file_name'],
					'csrf' => $this->security->get_csrf_hash()
				);
			}
			echo json_encode($datas);
		}
	}

	public function editor_group_soal_delete()
	{ //hapus upload image dipaket soal bacaan
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_group_soal');
		$src = $this->input->post('src', TRUE);
		$file_name = str_replace(base_url(), '', $src);
		$paket_soal_id = urlencode(base64_encode($this->input->post('id_paket_soal')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/group-soal/' . $paket_soal_id);
		} else {
			if (unlink($file_name)) {
				$datas = array(
					'text' => 'Success Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			} else {
				$datas = array(
					'text' => 'Failed Delete Data Image',
					'csrf' => $this->security->get_csrf_hash()
				);
			}

			echo json_encode($datas);
		}
	}

	public function add_group_soal($id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		//for passing data to view
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['konversi_skor'] = $this->tes->get_konversi_skor_enable();
		$data['content']['parent_group'] = $this->tes->get_parent_group($paket_soal_id);
		$data['title_header'] = ['title' => 'Add Group Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/group_soal/css';
		$view['content'] = 'website/lembaga/tes_online/group_soal/add';
		$view['js_additional'] = 'website/lembaga/tes_online/group_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_group_soal()
	{
		$paket_soal_id = $this->input->post('id_paket_soal'); //EncryptIdPaketSoal
		$id_paket_soal = base64_decode(urldecode($paket_soal_id));

		$data['paket_soal_id']  = $id_paket_soal;
		$data['name']  = $this->input->post('name', TRUE);
		$data['kode_group']  = strtoupper($this->input->post('kode_group', TRUE));
		$petunjuk = $this->input->post('petunjuk');
		$data['konversi_skor_id']  = $this->input->post('konversi_skor_id', TRUE);
		$data['parent_id']  = $this->input->post('parent_id', TRUE);
		$data['is_continuous']  = $this->input->post('is_continuous', TRUE);
		$data['created_datetime']  = date('Y-m-d H:i:s');

		if ($petunjuk == '<p><br></p>') {
			$data['petunjuk'] = '';
		} else {
			$data['petunjuk'] = $petunjuk;
		}

		$allowed_type 	= [
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav"
		];
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/group_soal/group_' . $id_paket_soal . '/';
		$config['allowed_types']    = 'mpeg|mpg|mpeg3|mp3|wav|wave';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['audio_group']['name'])) {
			if (!$this->upload->do_upload('audio_group')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Audio Soal Error');
				exit();
			} else {
				$data['file'] = $this->upload->data('file_name');
				$data['tipe_file'] = $this->upload->data('file_type');
			}
		}

		$tbl = $this->tbl_group_soal;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/group-soal/' . $paket_soal_id;
		$urlx = 'admin/add-group-soal/' . $paket_soal_id;
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_group_soal($id_group_soal, $id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$group_soal_id = base64_decode(urldecode($id_group_soal));

		//for passing data to view
		$group_data = $this->tes->get_group_soal_by_id($group_soal_id);
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['id_group_soal'] = $id_group_soal;
		$data['content']['konversi_skor'] = $this->tes->get_konversi_skor_selected($group_data->konversi_skor_id);
		$data['content']['parent_group'] = $this->tes->get_parent_group_selected($paket_soal_id, $group_data->parent_id);
		$data['content']['group_soal'] = $group_data;
		$data['title_header'] = ['title' => 'Edit Group Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/group_soal/css';
		$view['content'] = 'website/lembaga/tes_online/group_soal/edit';
		$view['js_additional'] = 'website/lembaga/tes_online/group_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_group_soal()
	{
		$paket_soal_id_crypt = $this->input->post('id_paket_soal'); //EncryptIdPaketSoal
		$group_soal_id_crypt = $this->input->post('id_group_soal'); //EncryptIdGroupSoal

		$group_soal_id = base64_decode(urldecode($group_soal_id_crypt));
		$paket_soal_id  = base64_decode(urldecode($paket_soal_id_crypt));

		$data['name']  = $this->input->post('name', TRUE);
		$data['kode_group']  = strtoupper($this->input->post('kode_group', TRUE));
		$petunjuk  = $this->input->post('petunjuk');
		if ($petunjuk == '<p><br></p>') {
			$data['petunjuk'] = '';
		} else {
			$data['petunjuk'] = $petunjuk;
		}
		$data['konversi_skor_id']  = $this->input->post('konversi_skor_id', TRUE);
		$data['parent_id']  = $this->input->post('parent_id', TRUE);
		$data['is_continuous']  = $this->input->post('is_continuous', TRUE);
		$old_name_audio = $this->input->post('old_name_audio');
		if ($old_name_audio == NULL || $old_name_audio == '') {
			$old_name_audio_x = NULL;
		} else {
			$old_name_audio_x = $old_name_audio;
		}
		$old_type_audio = $this->input->post('old_type_audio');
		if ($old_type_audio == NULL || $old_type_audio == '') {
			$old_type_audio_x = NULL;
		} else {
			$old_type_audio_x = $old_type_audio;
		}
		$data['updated_datetime']  = date('Y-m-d H:i:s');

		$allowed_type 	= [
			"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav"
		];

		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/group_soal/group_' . $paket_soal_id . '/';
		$config['allowed_types']    = 'mpeg|mpg|mpeg3|mp3|wav|wave';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['audio_group']['name'])) {
			if (!$this->upload->do_upload('audio_group')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Audio Soal Error');
				exit();
			} else {
				$data['file'] = $this->upload->data('file_name');
				$data['tipe_file'] = $this->upload->data('file_type');
			}
		} else {
			$data['file'] = $old_name_audio_x;
			$data['tipe_file'] = $old_type_audio_x;
		}

		$tbl = $this->tbl_group_soal;
		$update = $this->tes->update_group_soal($data, $group_soal_id, $paket_soal_id);

		$urly = 'admin/group-soal/' . $paket_soal_id_crypt;
		$urlx = 'admin/edit-group-soal/' . $group_soal_id_crypt . '/' . $paket_soal_id_crypt;
		$this->update_end($update, $urly, $urlx);
	}

	public function detail_group_soal($id_group_soal, $id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$group_soal_id = base64_decode(urldecode($id_group_soal));

		//for passing data to view
		$group_data = $this->tes->get_group_soal_by_id($group_soal_id);
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['id_group_soal'] = $id_group_soal;
		$data['content']['konversi_skor'] = $this->tes->get_konversi_skor_selected($group_data->konversi_skor_id);
		$data['content']['parent_group'] = $this->tes->get_parent_group_selected($paket_soal_id, $group_data->parent_id);
		$data['content']['group_soal'] = $group_data;
		$data['title_header'] = ['title' => 'Detail Group Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/group_soal/css';
		$view['content'] = 'website/lembaga/tes_online/group_soal/detail';
		$view['js_additional'] = 'website/lembaga/tes_online/group_soal/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function disable_group_soal($id_group_soal, $id_paket_soal)
	{
		$group_soal_id = base64_decode(urldecode($id_group_soal));

		$tbl = $this->tbl_group_soal;
		$delete = $this->general->delete_data($tbl, $group_soal_id);

		$urly = 'admin/group-soal/' . $id_paket_soal;
		$urlx = 'admin/group-soal/' . $id_paket_soal;
		$this->delete_end($delete, $urly, $urlx);
	}

	public function sesi_pelaksana()
	{
		$data['content']['sesi_pelaksanaan'] = $this->tes->get_sesi_pelaksanaan();
		$data['title_header'] = ['title' => 'Sesi Pelaksanaan'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/css';
		$view['content'] = 'website/lembaga/tes_online/sesi_pelaksanaan/content';
		$view['js_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function paket_sesi_pelaksana()
	{
		$data['content']['paket_soal'] = $this->tes->get_paket_soal_sesi();
		$data['title_header'] = ['title' => 'Pilihan Paket Soal'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/css';
		$view['content'] = 'website/lembaga/tes_online/sesi_pelaksanaan/browse_paket';
		$view['js_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_sesi_pelaksana($id_paket_soal)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['content']['paket_soal'] = $this->tes->get_paket_soal_sesi_selected($paket_soal_id);
		$data['content']['komposisi_soal'] = $this->tes->get_komposisi_soal($paket_soal_id);
		$data['content']['group_peserta'] = $this->tes->get_group_peserta();
		$data['title_header'] = ['title' => 'Add Sesi Pelaksanaan'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/css';
		$view['content'] = 'website/lembaga/tes_online/sesi_pelaksanaan/add';
		$view['js_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function get_peserta_by_select()
	{
		$searchTerm = $this->input->post('searchTerm');
		$response = $this->tes->getUsers($searchTerm);

		echo json_encode($response);
	}

	public function submit_add_sesi_pelaksana()
	{
		$paket_soal_id_crypt = $this->input->post('id_paket_soal');

		$data_sesi = [];
		$data_komposisi = [];
		$data_user = [];

		//SESI PELAKSANAAN
		$mode_peserta = $this->input->post('mode_peserta', TRUE);
		$data_sesi['paket_soal_id'] = base64_decode(urldecode($paket_soal_id_crypt));
		$data_sesi['name'] = $this->input->post('name', TRUE);
		$data_sesi['mode_peserta_id'] = $this->input->post('mode_peserta', TRUE);
		$waktu_mulai = $this->input->post('waktu_mulai', TRUE);
		$waktu_mulai_input = date("Y-m-d H:i", strtotime($waktu_mulai));
		$data_sesi['waktu_mulai'] = $waktu_mulai_input;
		$data_sesi['lama_pengerjaan'] = $this->input->post('lama_pengerjaan', TRUE);
		$lama_pengerjaan = $data_sesi['lama_pengerjaan'];
		$data_sesi['is_fleksible'] = $this->input->post('is_fleksible', TRUE);
		$fleksible = $data_sesi['is_fleksible'];
		$batas_pengerjaan = $this->input->post('batas_pengerjaan', TRUE);
		if ($fleksible == 0) {
			$batas_pengerjaan_input = date("Y-m-d H:i", strtotime($waktu_mulai . ' + ' . $lama_pengerjaan . ' minutes'));
		} else {
			$batas_pengerjaan_input = date("Y-m-d H:i", strtotime($batas_pengerjaan));
		}
		$data_sesi['batas_pengerjaan'] = $batas_pengerjaan_input;
		$data_sesi['blok_layar'] = $this->input->post('blok_layar', TRUE);
		$data_sesi['is_hasil'] = $this->input->post('is_hasil', TRUE);
		$data_sesi['is_ranking'] = $this->input->post('is_ranking', TRUE);
		$data_sesi['is_pembahasan'] = $this->input->post('is_pembahasan', TRUE);
		$data_sesi['is_kunci_pembahasan'] = $this->input->post('is_kunci_pembahasan', TRUE);
		$data_sesi['is_komposisi_soal'] = $this->input->post('komposisi_soal', TRUE);
		$data_sesi['created_datetime'] = date('Y-m-d H:i:s');

		$tbl_sesi = $this->tbl_sesi_pelaksanaan;
		$insert_sesi = $this->general->input_data_id($tbl_sesi, $data_sesi);

		if ($insert_sesi) {
			//SESI PELAKSANA KOMPOSISI
			$id_group_soal = $this->input->post('id_group_soal', TRUE);
			$total_soal = $this->input->post('total_soal', TRUE);

			$index_komposisi = 0;
			foreach ($id_group_soal as $value_group) {
				array_push($data_komposisi, array(
					'sesi_pelaksanaan_id' => $insert_sesi,
					'group_soal_id' => $value_group,
					'total_soal' => $total_soal[$index_komposisi],
					'created_datetime' => date('Y-m-d H:i:s')
				));

				$index_komposisi++;
			}

			$tbl_komposisi = $this->tbl_sesi_pelaksanaan_komposisi;
			$input_komposisi = $this->general->input_batch($tbl_komposisi, $data_komposisi);

			//SESI USER
			if ($mode_peserta == 1) { //1 KELOMPOK 2 MANUAL INPUT
				$group_peserta_id = $this->input->post('group_peserta_id', TRUE);

				foreach ($group_peserta_id as $val_group_peserta) {
					$insert_user_sesi = $this->insert_group_peserta_komposisi($val_group_peserta, $insert_sesi);
				}
			} else {
				$peserta_id = $this->input->post('manual_peserta_id', TRUE);

				foreach ($peserta_id as $val_peserta) {
					$data_user[] = array(
						'sesi_pelaksanaan_id' => $insert_sesi,
						'group_peserta_id' => 0,
						'user_id' => $val_peserta,
						'created_datetime' => date('Y-m-d H:i:s')
					);
				}

				$tbl_sesi_user = $this->tbl_sesi_pelaksanaan_user;
				$input_user = $this->general->input_batch($tbl_sesi_user, $data_user);
			}

			$this->session->set_flashdata('success', 'Data sesi pelaksanaan berhasil disimpan!');
			redirect('admin/sesi-pelaksana');
		} else {
			$this->session->set_flashdata('error', 'Data sesi pelaksanaan gagal disimpan!');
			redirect('admin/add-sesi-pelaksana/' . $paket_soal_id_crypt);
		}
	}

	public function add_peserta_sesi_pelaksana($id_sesi_pelaksana)
	{
		$data['content']['id_sesi_pelaksana'] = $id_sesi_pelaksana;
		$data['content']['group_peserta'] = $this->tes->get_group_peserta();
		$data['title_header'] = ['title' => 'Add Peserta Sesi Pelaksanaan'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/add_peserta/css';
		$view['content'] = 'website/lembaga/tes_online/sesi_pelaksanaan/add_peserta/add_peserta';
		$view['js_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/add_peserta/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_peserta_sesi_pelaksana()
	{
		$id_sesi_pelaksana = $this->input->post('id_sesi_pelaksana');
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

		$data_user = [];

		$data_sesi['mode_peserta_id'] = $this->input->post('mode_peserta', TRUE);
		$mode_peserta = $this->input->post('mode_peserta', TRUE);

		//SESI USER
		if ($mode_peserta == 1) { //1 KELOMPOK 2 MANUAL INPUT
			$group_peserta_id = $this->input->post('group_peserta_id', TRUE);

			foreach ($group_peserta_id as $val_group_peserta) {
				$this->insert_group_peserta_komposisi($val_group_peserta, $sesi_pelaksana_id);
			}
		} else {
			$peserta_id = $this->input->post('manual_peserta_id', TRUE);

			foreach ($peserta_id as $val_peserta) {
				$data_user[] = array(
					'sesi_pelaksanaan_id' => $sesi_pelaksana_id,
					'group_peserta_id' => 0,
					'user_id' => $val_peserta,
					'created_datetime' => date('Y-m-d H:i:s')
				);
			}

			$tbl_sesi_user = $this->tbl_sesi_pelaksanaan_user;
			$this->general->input_batch($tbl_sesi_user, $data_user);
		}

		$this->session->set_flashdata('success', 'Tambah Peserta pelaksanaan berhasil disimpan!');
		redirect('admin/sesi-pelaksana');
	}

	private function insert_group_peserta_komposisi($val_group_peserta, $insert_sesi)
	{
		$data_user = [];

		$get_peserta_by_group = $this->tes->get_peserta_by_group($val_group_peserta);

		foreach ($get_peserta_by_group as $val_peserta) {
			$data_user[] = array(
				'sesi_pelaksanaan_id' => $insert_sesi,
				'group_peserta_id' => $val_group_peserta,
				'user_id' => $val_peserta->user_id,
				'created_datetime' => date('Y-m-d H:i:s')
			);
		}

		$tbl_sesi_user = $this->tbl_sesi_pelaksanaan_user;
		$input_user = $this->general->input_batch($tbl_sesi_user, $data_user);

		return true;
	}

	public function edit_sesi_pelaksana($id_sesi_pelaksana)
	{
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));
		$data['content']['id_sesi_pelaksana'] = $id_sesi_pelaksana;
		$sesi_pelaksanaan = $this->tes->get_sesi_pelaksana_by_id($sesi_pelaksana_id);
		$data['content']['sesi_pelaksana'] = $sesi_pelaksanaan;
		$data['content']['id_paket_soal'] = urlencode(base64_encode($sesi_pelaksanaan->paket_soal_id));
		$data['content']['paket_soal'] = $this->tes->get_paket_soal_sesi_selected($sesi_pelaksanaan->paket_soal_id);
		$data['content']['komposisi_soal'] = $this->tes->get_komposisi_soal_by_id($sesi_pelaksana_id);
		$data['content']['group_peserta'] = $this->tes->get_group_peserta();
		$data['title_header'] = ['title' => 'Edit Sesi Pelaksanaan'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/css';
		$view['content'] = 'website/lembaga/tes_online/sesi_pelaksanaan/edit';
		$view['js_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_sesi_pelaksana()
	{
		$paket_soal_id_crypt = $this->input->post('id_paket_soal');
		$sesi_pelaksana_id_crypt = $this->input->post('id_sesi_pelaksana');
		$paket_soal_id = base64_decode(urldecode($paket_soal_id_crypt));
		$sesi_pelaksana_id = base64_decode(urldecode($sesi_pelaksana_id_crypt));

		$data_sesi = [];
		$data_komposisi = [];

		//SESI PELAKSANAAN
		$mode_peserta = $this->input->post('mode_peserta', TRUE);
		$data_sesi['name'] = $this->input->post('name', TRUE);
		$waktu_mulai = $this->input->post('waktu_mulai', TRUE);
		$waktu_mulai_input = date("Y-m-d H:i", strtotime($waktu_mulai));
		$data_sesi['waktu_mulai'] = $waktu_mulai_input;
		$data_sesi['lama_pengerjaan'] = $this->input->post('lama_pengerjaan', TRUE);
		$lama_pengerjaan = $data_sesi['lama_pengerjaan'];
		$data_sesi['is_fleksible'] = $this->input->post('is_fleksible', TRUE);
		$fleksible = $data_sesi['is_fleksible'];
		$batas_pengerjaan = $this->input->post('batas_pengerjaan', TRUE);
		if ($fleksible == 0) {
			$batas_pengerjaan_input = date("Y-m-d H:i", strtotime($waktu_mulai . ' + ' . $lama_pengerjaan . ' minutes'));
		} else {
			$batas_pengerjaan_input = date("Y-m-d H:i", strtotime($batas_pengerjaan));
		}
		$data_sesi['batas_pengerjaan'] = $batas_pengerjaan_input;
		$data_sesi['blok_layar'] = $this->input->post('blok_layar', TRUE);
		$data_sesi['is_hasil'] = $this->input->post('is_hasil', TRUE);
		$data_sesi['is_ranking'] = $this->input->post('is_ranking', TRUE);
		$data_sesi['is_pembahasan'] = $this->input->post('is_pembahasan', TRUE);
		$data_sesi['is_kunci_pembahasan'] = $this->input->post('is_kunci_pembahasan', TRUE);
		$data_sesi['is_komposisi_soal'] = $this->input->post('komposisi_soal', TRUE);
		$data_sesi['updated_datetime'] = date('Y-m-d H:i:s');

		$tbl_sesi = $this->tbl_sesi_pelaksanaan;
		$update_sesi = $this->general->update_data($tbl_sesi, $data_sesi, $sesi_pelaksana_id);

		if ($update_sesi) {
			//SESI PELAKSANA KOMPOSISI
			$id_group_soal = $this->input->post('id_group_soal', TRUE);
			$total_soal = $this->input->post('total_soal', TRUE);
			$id_sesi_pelaksana_komposisi = $this->input->post('id_sesi_pelaksana_komposisi', TRUE);

			$index_komposisi = 0;
			foreach ($id_group_soal as $value_group) {
				array_push($data_komposisi, array(
					'id' => $id_sesi_pelaksana_komposisi[$index_komposisi],
					'sesi_pelaksanaan_id' => $sesi_pelaksana_id,
					'group_soal_id' => $value_group,
					'total_soal' => $total_soal[$index_komposisi],
					'updated_datetime' => date('Y-m-d H:i:s')
				));

				$index_komposisi++;
			}

			$tbl_komposisi = $this->tbl_sesi_pelaksanaan_komposisi;
			$update_komposisi = $this->general->update_batch($tbl_komposisi, $data_komposisi, 'id');

			if ($update_komposisi) {
				$this->session->set_flashdata('success', 'Data sesi pelaksanaan berhasil disimpan!');
				redirect('admin/sesi-pelaksana');
			} else {
				$this->session->set_flashdata('error', 'Data sesi pelaksanaan gagal disimpan saat update komposisi soal!');
				redirect('admin/edit-sesi-pelaksana/' . $sesi_pelaksana_id_crypt);
			}
		} else {
			$this->session->set_flashdata('error', 'Data sesi pelaksanaan gagal disimpan!');
			redirect('admin/edit-sesi-pelaksana/' . $sesi_pelaksana_id_crypt);
		}
	}

	public function list_peserta_sesi_pelaksana($id_sesi_pelaksana)
	{
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

		$name_sesi = $this->tes->get_sesi_pelaksanaan_by_id($sesi_pelaksana_id);
		$data['content']['list_peserta_sesi'] = $this->tes->get_list_peserta_sesi($sesi_pelaksana_id);
		$data['content']['name_sesi_pelaksana'] = $name_sesi->sesi_pelaksanaan_name;
		$data['content']['id_sesi_pelaksana'] = $id_sesi_pelaksana;
		$data['title_header'] = ['title' => 'List Peserta Sesi Pelaksanaan'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/list_peserta/css';
		$view['content'] = 'website/lembaga/tes_online/sesi_pelaksanaan/list_peserta/content';
		$view['js_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/list_peserta/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function export_list_peserta_sesi_pelaksana($id_sesi_pelaksana)
	{
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nomor Peserta');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Kelompok');
		$sheet->setCellValue('E1', 'Username/Email');
		$sheet->setCellValue('F1', 'Password');

		$peserta_sesi = $this->tes->get_list_peserta_sesi($sesi_pelaksana_id);
		$name_sesi = $this->tes->get_sesi_pelaksanaan_by_id($sesi_pelaksana_id);
		$name_file = $name_sesi->sesi_pelaksanaan_name;

		$no = 1;
		$x = 2;
		foreach ($peserta_sesi as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, (int) $row->no_peserta);
			$sheet->setCellValue('C' . $x, $row->peserta_name);
			$sheet->setCellValue('D' . $x, $row->group_peserta_name);
			$sheet->setCellValue('E' . $x, $row->username);
			$sheet->setCellValue('F' . $x, $this->encryption->decrypt($row->password));
			$x++;
		}

		// Column sizing
		foreach (range('A', 'F') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $name_file . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function disable_all_peserta_sesi_pelaksana($id_sesi_pelaksana)
	{
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

		$tbl = $this->tbl_sesi_pelaksanaan_user;
		$delete = $this->tes->disable_peserta_sesi_pelaksanaan($tbl, $sesi_pelaksana_id);

		$urly = 'admin/list-peserta-sesi-pelaksana/' . $id_sesi_pelaksana;
		$urlx = 'admin/list-peserta-sesi-pelaksana/' . $id_sesi_pelaksana;
		$this->delete_end($delete, $urly, $urlx);
	}

	public function disable_peserta_sesi_pelaksana($id_sesi_pelaksana_user, $id_sesi_pelaksanaan)
	{
		$sesi_pelaksana_user_id = base64_decode(urldecode($id_sesi_pelaksana_user));

		$tbl = $this->tbl_sesi_pelaksanaan_user;
		$delete = $this->general->delete_data($tbl, $sesi_pelaksana_user_id);

		$urly = 'admin/list-peserta-sesi-pelaksana/' . $id_sesi_pelaksanaan;
		$urlx = 'admin/list-peserta-sesi-pelaksana/' . $id_sesi_pelaksanaan;
		$this->delete_end($delete, $urly, $urlx);
	}

	public function sesi_peserta_multiple_delete()
	{
		if ($this->input->post('checkbox_value')) {
			$id = $this->input->post('checkbox_value');

			$data = array(
				'is_enable' => 0,
				'updated_datetime' => date('Y-m-d H:i:s')
			);

			for ($count = 0; $count < count($id); $count++) {
				$tbl = $this->tbl_sesi_pelaksanaan_user;
				$this->general->delete_data($tbl, $id[$count]);
			}
		}
	}

	public function detail_sesi_pelaksana($id_sesi_pelaksana)
	{
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));
		$data['content']['id_sesi_pelaksana'] = $id_sesi_pelaksana;
		$sesi_pelaksanaan = $this->tes->get_sesi_pelaksana_by_id($sesi_pelaksana_id);
		$data['content']['sesi_pelaksana'] = $sesi_pelaksanaan;
		$data['content']['id_paket_soal'] = urlencode(base64_encode($sesi_pelaksanaan->paket_soal_id));
		$data['content']['paket_soal'] = $this->tes->get_paket_soal_sesi_selected($sesi_pelaksanaan->paket_soal_id);
		$data['content']['komposisi_soal'] = $this->tes->get_komposisi_soal_by_id($sesi_pelaksana_id);
		$data['content']['group_peserta'] = $this->tes->get_group_peserta();
		$data['title_header'] = ['title' => 'Detail Sesi Pelaksanaan'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/css';
		$view['content'] = 'website/lembaga/tes_online/sesi_pelaksanaan/detail';
		$view['js_additional'] = 'website/lembaga/tes_online/sesi_pelaksanaan/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function disable_sesi_pelaksana($id_sesi_pelaksana)
	{
		$data = [];

		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

		$data = array(
			'is_enable' => 0,
			'updated_datetime' => date('Y-m-d H:i:s')
		);

		$delete = $this->tes->disable_sesi_pelaksana($sesi_pelaksana_id, $data);

		$urly = 'admin/sesi-pelaksana';
		$urlx = 'admin/sesi-pelaksana';
		$this->delete_end($delete, $urly, $urlx);
	}

	public function report_ujian()
	{
		$search_active = $this->input->post('search_active') && $this->input->post('search_active') == 1 ? 1 : 0;
		$group_kelompok_peserta = $this->input->post('group_kelompok_name');
		$sesi_pelaksanaan = $this->input->post('kata_kunci_sesi');
		$paket_soal = $this->input->post('kata_kunci_paket_soal');

		if ($search_active == 1) { //POST DATA
			$data['content']['list_ujian'] = $this->tes->get_ujian_header_filter_data(
				$group_kelompok_peserta,
				$sesi_pelaksanaan,
				$paket_soal,
			);
			$data['content']['group_kelompok_peserta'] = $group_kelompok_peserta;
			$data['content']['sesi_pelaksanaan'] = $sesi_pelaksanaan;
			$data['content']['paket_soal'] = $paket_soal;
		} else {
			$data['content']['list_ujian'] = []; //$this->tes->get_ujian_header();
			$data['content']['group_kelompok_peserta'] = 'all_group';
			$data['content']['sesi_pelaksanaan'] = '';
			$data['content']['paket_soal'] = '';
		}

		$data['content']['group_peserta'] = $this->tes->get_group_peserta();
		$data['title_header'] = ['title' => 'Report Ujian'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/report_ujian/css';
		$view['content'] = 'website/lembaga/tes_online/report_ujian/content';
		$view['js_additional'] = 'website/lembaga/tes_online/report_ujian/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function detail_report_ujian($id_sesi_pelaksanaan, $id_paket_soal)
	{
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksanaan));
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$data['content']['list_ujian_detail'] = $this->tes->get_ujian_detail($sesi_pelaksana_id, $paket_soal_id);
		$data['content']['list_ujian'] = $this->tes->get_ujian_header_by_id($sesi_pelaksana_id, $paket_soal_id);
		$data['content']['id_sesi_pelaksanaan'] = $id_sesi_pelaksanaan;
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['title_header'] = ['title' => 'Detail Report Ujian'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/report_ujian/detail_report/css';
		$view['content'] = 'website/lembaga/tes_online/report_ujian/detail_report/content';
		$view['js_additional'] = 'website/lembaga/tes_online/report_ujian/detail_report/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function export_detail_report_ujian($id_sesi_pelaksanaan, $id_paket_soal)
	{
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksanaan));
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$data = $this->tes->get_ujian_detail($sesi_pelaksana_id, $paket_soal_id);
		$sesi = $this->tes->get_sesi_pelaksana_by_id($sesi_pelaksana_id);

		$total_soal = $this->tes->get_total_soal($paket_soal_id);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		foreach ($data as $val) {
			$group_soal_name_raw = $val->group_soal_name;
		}

		$group_soal_name = explode(',', $group_soal_name_raw);

		$column_skor = sizeof($group_soal_name);

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nomor Peserta');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Kelompok');
		$sheet->setCellValue('E1', 'Waktu Mulai Sesi');
		$sheet->setCellValue('F1', 'Waktu Mulai Peserta');
		$sheet->setCellValue('G1', 'Waktu Selesai Sesi');
		$sheet->setCellValue('H1', 'Waktu Selesai Peserta');
		$sheet->setCellValue('I1', 'Jumlah Benar');
		$sheet->setCellValue('J1', 'Jumlah Salah');
		$sheet->setCellValue('K1', 'Jumlah Ragu');
		$sheet->setCellValue('L1', 'Jumlah Kosong');
		$col = 'M';
		$index = 1;
		for ($i = 0; $i < $column_skor; $i++) {
			$sheet->setCellValue($col++ . $index, $group_soal_name[$i]);
		}
		$sheet->setCellValue($col++ . $index, 'Total Skor');
		$sheet->setCellValue($col++ . $index, 'Nilai');
		$sheet->setCellValue($col++ . $index, 'Skala Penilaian');
		$sheet->setCellValue($col . $index, '');
		$last_col = $col++;
		$count_soal = $total_soal->total_soal;
		$no_soal = 1;
		for ($h = 0; $h < $count_soal; $h++) {
			$sheet->setCellValue($col++ . $index, $no_soal);
			$no_soal++;
		}

		$no = 1;
		$x = 2;
		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, (int) $row->user_no);
			$sheet->setCellValue('C' . $x, $row->user_name);
			$sheet->setCellValue('D' . $x, !empty($row->group_peserta_name) ? $row->group_peserta_name : 'NO_GROUP');
			$sheet->setCellValue('E' . $x, format_indo($row->tgl_mulai_sesi));
			$sheet->setCellValue('F' . $x, format_indo($row->tgl_mulai_peserta));
			$sheet->setCellValue('G' . $x, format_indo($row->tgl_selesai_sesi));
			$sheet->setCellValue('H' . $x, format_indo($row->tgl_selesai_peserta));
			$sheet->setCellValue('I' . $x, $row->jml_benar ? $row->jml_benar : 0);
			$sheet->setCellValue('J' . $x, $row->jml_salah ? $row->jml_salah : 0);
			$sheet->setCellValue('K' . $x, $row->jml_ragu ? $row->jml_ragu : 0);
			$sheet->setCellValue('L' . $x, $row->jml_kosong ? $row->jml_kosong : 0);

			$skor_group = explode(',', $row->skor_group);
			$number_skor = sizeof($skor_group);
			$rows = 'M';
			for ($j = 0; $j < $number_skor; $j++) {
				$sheet->setCellValue($rows++ . $x, $skor_group[$j] ? $skor_group[$j] : 0);
			}

			$sheet->setCellValue($rows++ . $x, $row->total_skor ? $row->total_skor : 0);
			$sheet->setCellValue($rows++ . $x, $row->nilai ? $row->nilai : 0);
			$sheet->setCellValue($rows++ . $x, $row->skala_penilaian ? $row->skala_penilaian : 0);
			$sheet->setCellValue($rows++ . $x, '');

			$get_ujian_report = $this->tes->report_ujian_by_user($sesi_pelaksana_id, $paket_soal_id, $row->user_id);
			foreach ($get_ujian_report as $val_report_ujian) {
				$sheet->setCellValue($rows++ . $x, $val_report_ujian->hasil_jawaban);
			}

			$x++;
		}

		// Column sizing
		foreach (range('A', $last_col) as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = $sesi->sesi_pelaksanaan_name . ' (' . $sesi->nama_paket_soal . ' ' . $sesi->materi_name . ')';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function export_detail_report_ujian_st($id_sesi_pelaksanaan, $id_paket_soal)
	{ //excel report statistik
		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksanaan));
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$data = $this->tes->get_ujian_detail($sesi_pelaksana_id, $paket_soal_id);
		$sesi = $this->tes->get_sesi_pelaksana_by_id($sesi_pelaksana_id);

		$total_soal = $this->tes->get_total_soal($paket_soal_id);

		$spreadsheet = new Spreadsheet();

		//DETAIL UJIAN
		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle('Data Jawaban Peserta');
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nomor Peserta');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Kelompok');
		$sheet->setCellValue('E1', '');
		$col = 'F';
		$index = 1;
		$count_soal = $total_soal->total_soal;
		$no_soal = 1;
		for ($h = 0; $h < $count_soal; $h++) {
			$sheet->setCellValue($col++ . $index, $no_soal);
			$no_soal++;
		}

		$no = 1;
		$x = 2;
		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, (int) $row->user_no);
			$sheet->setCellValue('C' . $x, $row->user_name);
			$sheet->setCellValue('D' . $x, !empty($row->group_peserta_name) ? $row->group_peserta_name : 'NO_GROUP');
			$sheet->setCellValue('E' . $x, '');
			$rows = 'F';
			$get_ujian_report = $this->tes->report_ujian_by_user($sesi_pelaksana_id, $paket_soal_id, $row->user_id);
			foreach ($get_ujian_report as $val_report_ujian) {
				$sheet->setCellValue($rows++ . $x, $val_report_ujian->str_jawaban);
			}

			$x++;
		}

		// Column sizing
		foreach (range('A', 'E') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		//STATISTIK SHEET
		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(1);
		$spreadsheet->getActiveSheet()->setTitle('Data Statistik');
		$sheet = $spreadsheet->getActiveSheet();

		$data_mode_jwb = $this->tes->get_paket_soal_by_id($paket_soal_id);
		$mode_jw_ct = $data_mode_jwb->count_pilgan;
		$column_take = '';
		$opsi = config_item('_def_opsi_jawaban');
		for ($u = 0; $u < $mode_jw_ct; $u++) {
			$column_take .= $opsi . ',';
			$opsi++;
		}

		$statistik_report = $this->tes->report_ujian_by_st($sesi_pelaksana_id, $paket_soal_id, $column_take);

		$sheet->setCellValue('A1', 'Nomor Soal');
		$col = 'B';
		$index = 1;
		$opsi = config_item('_def_opsi_jawaban');
		for ($w = 0; $w < $mode_jw_ct; $w++) {
			$sheet->setCellValue($col++ . $index, $opsi);
			$opsi++;
		}

		$row = 2;
		$no_sm = 1;
		$xsm = 2;
		foreach ($statistik_report as $val_st) {
			$sheet->setCellValue('A' . $xsm, $val_st->no_soal);
			$rows = 'B';
			$opsi = config_item('_def_opsi_jawaban');
			for ($d = 0; $d < $mode_jw_ct; $d++) {
				$sheet->setCellValue($rows++ . $xsm, $val_st->$opsi);
				$opsi++;
			}

			$xsm++;
		}

		// Column sizing
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

		//Sheet aktif diawal
		$spreadsheet->setActiveSheetIndex(0);

		$writer = new Xlsx($spreadsheet);
		$filename = 'Statistik ' . $sesi->sesi_pelaksanaan_name . ' (' . $sesi->nama_paket_soal . ' ' . $sesi->materi_name . ')';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function detail_ujian_peserta($id_ujian, $id_sesi_pelaksanaan, $id_paket_soal)
	{
		$sesi_pelaksanaan_id = base64_decode(urldecode($id_sesi_pelaksanaan));
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$ujian_id = base64_decode(urldecode($id_ujian));

		$data_ujian = [];
		$bank_soal = [];
		$data = [];
		$file_name = '';

		$sesi_detail = $this->tes->get_sesi_pelaksanaan_pembahasan($sesi_pelaksanaan_id); //Get Sesi Pelaksanaan
		$ujian_data = $this->tes->get_checking_ujian_by_id($ujian_id); //CEK UJIAN

		if (empty($ujian_data)) {
			$this->session->set_flashdata('error', 'Peserta tidak mengikuti ujian!');
			redirect('admin/detail-report-ujian/' . $id_sesi_pelaksanaan . '/' . $id_paket_soal);
		}

		//Pengambilan data list jawaban, group soal, soalnya, dan hasil jawabannya
		$urut_soal 		= explode(",", $ujian_data->list_jawaban);
		$soal_urut_ok	= array();
		$jumlah_soal    = sizeof($urut_soal);
		for ($i = 0; $i < sizeof($urut_soal); $i++) {
			$pc_urut_soal	    = explode("|", $urut_soal[$i]); //pecah data wadah list jawaban
			$pc_urut_soal_jwb 	= empty($pc_urut_soal[2]) ? "''" : "'{$pc_urut_soal[2]}'"; //List jawaban user
			$ambil_soal 	    = $this->tes->get_ujian_list_user($pc_urut_soal_jwb, $pc_urut_soal[1], $paket_soal_id);
			$soal_urut_ok[]     = $ambil_soal;
		}

		$soal_urut_ok = $soal_urut_ok;

		//Pengambilan isi dari data list ujian user
		$pc_list_jawaban = explode(",", $ujian_data->list_jawaban);
		$arr_jawab = array();
		foreach ($pc_list_jawaban as $v) {
			$pc_v 	= explode("|", $v);
			$gr     = $pc_v[0];
			$idx 	= $pc_v[1];
			$val 	= $pc_v[2];
			$rg 	= $pc_v[3];

			$arr_jawab[$idx] = array("g" => $gr, "j" => $val, "r" => $rg);
		}

		$html = '';
		$group_soal_name_before = '';
		$no = 1;
		if (!empty($soal_urut_ok)) {
			foreach ($soal_urut_ok as $s) {
				$bacaan_soal = $s->isi_bacaan_soal <> 0 || !empty($s->isi_bacaan_soal) ? $s->isi_bacaan_soal . '<br />' : ''; // bacaan soal
				$bacaan_soal_name = $s->bacaan_soal_name <> 0 || !empty($s->bacaan_soal_name) ? '<b>' . $s->bacaan_soal_name . '</b><br />' : ''; // bacaan soal judul
				$group_soal_name = $s->group_soal_name <> 0 || !empty($s->group_soal_name) ? 'GROUP ' . $s->group_soal_name : '';

				$html .= '<h4 class="group-name">' . $group_soal_name . '</h4>';

				$html .= '<soal><quiz><table class="tbl-soal"><tr><td style="vertical-align:top;">' . $no . '. </td><td>' . $bacaan_soal_name . $bacaan_soal . $s->bank_soal_name . '</td></tr></table>';

				if ($s->group_mode_jwb_id == 1) {
					$jawaban = $this->tes->get_jawaban_by_id_pembahasan($s->bank_soal_id, $s->paket_soal_id);
					$jawaban_benar = $this->tes->get_jawaban_by_id_benar($s->bank_soal_id, $s->paket_soal_id);
					$opsi = config_item('_def_opsi_jawaban');

					foreach ($jawaban as $key_jawaban => $val_jawaban) {
						$checked = $arr_jawab[$s->bank_soal_id]["j"] == $val_jawaban->order ? "jawaban" : "";
						$html .= '<table class="tbl-jwb"><tr><td width="5px"><a class="btn ' . $checked . '" href="#">' . $opsi . '</a></td><td>' . $val_jawaban->name . '</td></tr>';
						$opsi++;
					}

					if ($jawaban_benar && $jawaban_benar == 1) {
						$key_opsi = 'A';
					} elseif ($jawaban_benar && $jawaban_benar == 2) {
						$key_opsi = 'B';
					} elseif ($jawaban_benar && $jawaban_benar == 3) {
						$key_opsi = 'C';
					} elseif ($jawaban_benar && $jawaban_benar == 4) {
						$key_opsi = 'D';
					} elseif ($jawaban_benar && $jawaban_benar == 5) {
						$key_opsi = 'E';
					}

					$html .= '<tr><td colspan="2">Kunci Jawaban : ' . $key_opsi . '</td></tr>';
				} else {
					$history_jawab = !empty($arr_jawab[$s->bank_soal_id]["j"]) ? $arr_jawab[$s->bank_soal_id]["j"] : "";
					$html .= '<tr><td colspan="2">' . $history_jawab . '</td></tr>';
				}

				$html .= '</table></quiz></soal>';

				$no++;
				$group_soal_name_before = $group_soal_name;
			}
		}

		$file_name = $sesi_detail->sesi_pelaksanaan_name . ' ' . $ujian_data->user_name . ' (' . $ujian_data->user_no . ')';

		//for passing data to view
		$data = array(
			'sesi_pelaksana' => $sesi_detail,
			'ljk' => $html,
			'ujian' => $ujian_data,
			'title' => $file_name
		);

		$this->load->view('website/lembaga/tes_online/report_ujian/detail_ujian/content', $data);
	}

	public function report_buku()
	{
		$data['content']['list_buku'] = $this->tes->get_buku_header();
		$data['title_header'] = ['title' => 'Report Buku'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/report_buku/css';
		$view['content'] = 'website/lembaga/tes_online/report_buku/content';
		$view['js_additional'] = 'website/lembaga/tes_online/report_buku/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function detail_report_buku($id_paket_soal, $id_buku)
	{
		$buku_id = base64_decode(urldecode($id_buku));
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$data['content']['list_ujian_detail'] = $this->tes->get_buku_detail($paket_soal_id, $buku_id);
		$data['content']['list_ujian'] = $this->tes->get_buku_header_by_id($paket_soal_id, $buku_id);
		$data['content']['id_buku'] = $id_buku;
		$data['content']['id_paket_soal'] = $id_paket_soal;
		$data['title_header'] = ['title' => 'Detail Report Buku'];

		//for load view
		$view['css_additional'] = 'website/lembaga/tes_online/report_buku/detail_report/css';
		$view['content'] = 'website/lembaga/tes_online/report_buku/detail_report/content';
		$view['js_additional'] = 'website/lembaga/tes_online/report_buku/detail_report/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function export_detail_report_buku($id_paket_soal, $id_buku)
	{
		$buku_id = base64_decode(urldecode($id_buku));
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));

		$data = $this->tes->get_buku_detail($paket_soal_id, $buku_id);
		$buku = $this->tes->get_buku_header_by_id($paket_soal_id, $buku_id);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		foreach ($data as $val) {
			$group_soal_name_raw = $val->group_soal_name;
		}

		$group_soal_name = explode(',', $group_soal_name_raw);

		$column_skor = sizeof($group_soal_name);

		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nomor Peserta');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Waktu Mulai Peserta');
		$sheet->setCellValue('E1', 'Waktu Selesai Peserta');
		$sheet->setCellValue('F1', 'Jumlah Benar');
		$sheet->setCellValue('G1', 'Jumlah Salah');
		$sheet->setCellValue('H1', 'Jumlah Ragu');
		$sheet->setCellValue('I1', 'Jumlah Kosong');
		$col = 'J';
		$index = 1;
		for ($i = 0; $i < $column_skor; $i++) {
			$sheet->setCellValue($col++ . $index, $group_soal_name[$i]);
		}
		$sheet->setCellValue($col++ . $index, 'Total Skor');
		$sheet->setCellValue($col++ . $index, 'Nilai');
		$sheet->setCellValue($col++ . $index, 'Skala Penilaian');

		$no = 1;
		$x = 2;
		foreach ($data as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, (int) $row->user_no);
			$sheet->setCellValue('C' . $x, $row->user_name);
			$sheet->setCellValue('D' . $x, format_indo($row->tgl_mulai_peserta));
			$sheet->setCellValue('E' . $x, format_indo($row->tgl_selesai_peserta));
			$sheet->setCellValue('F' . $x, $row->jml_benar);
			$sheet->setCellValue('G' . $x, $row->jml_salah);
			$sheet->setCellValue('H' . $x, $row->jml_ragu);
			$sheet->setCellValue('I' . $x, $row->jml_kosong);

			$skor_group = explode(',', $row->skor_group);
			$number_skor = sizeof($skor_group);
			$rows = 'J';
			for ($j = 0; $j < $number_skor; $j++) {
				$sheet->setCellValue($rows++ . $x, $skor_group[$j]);
			}

			$sheet->setCellValue($rows++ . $x, $row->total_skor);
			$sheet->setCellValue($rows++ . $x, $row->nilai);
			$sheet->setCellValue($rows++ . $x, $row->skala_penilaian);
			$x++;
		}

		// Column sizing
		foreach (range('A', $col) as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = $buku->buku_name . ' (' . $buku->nama_paket_soal . ' ' . $buku->materi_name . ')';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function detail_buku_peserta($id_ujian, $id_paket_soal, $id_buku)
	{
		$buku_id = base64_decode(urldecode($id_buku));
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$ujian_id = base64_decode(urldecode($id_ujian));

		$data_ujian = [];
		$bank_soal = [];
		$data = [];
		$file_name = '';

		$buku = $this->tes->get_buku_header_by_id($paket_soal_id, $buku_id);
		$ujian_data = $this->tes->get_checking_ujian_by_id($ujian_id); //CEK UJIAN

		if (empty($ujian_data)) {
			$this->session->set_flashdata('error', 'Peserta tidak mengikuti ujian!');
			redirect('admin/detail-report-buku/' . $id_paket_soal . '/' . $id_buku);
		}

		//Pengambilan data list jawaban, group soal, soalnya, dan hasil jawabannya
		$urut_soal 		= explode(",", $ujian_data->list_jawaban);
		$soal_urut_ok	= array();
		$jumlah_soal    = sizeof($urut_soal);
		for ($i = 0; $i < sizeof($urut_soal); $i++) {
			$pc_urut_soal	    = explode("|", $urut_soal[$i]); //pecah data wadah list jawaban
			$pc_urut_soal_jwb 	= empty($pc_urut_soal[2]) ? "''" : "'{$pc_urut_soal[2]}'"; //List jawaban user
			$ambil_soal 	    = $this->tes->get_ujian_list_user($pc_urut_soal_jwb, $pc_urut_soal[1], $paket_soal_id);
			$soal_urut_ok[]     = $ambil_soal;
		}

		$soal_urut_ok = $soal_urut_ok;

		//Pengambilan isi dari data list ujian user
		$pc_list_jawaban = explode(",", $ujian_data->list_jawaban);
		$arr_jawab = array();
		foreach ($pc_list_jawaban as $v) {
			$pc_v 	= explode("|", $v);
			$gr     = $pc_v[0];
			$idx 	= $pc_v[1];
			$val 	= $pc_v[2];
			$rg 	= $pc_v[3];

			$arr_jawab[$idx] = array("g" => $gr, "j" => $val, "r" => $rg);
		}

		$html = '';
		$group_soal_name_before = '';
		$no = 1;
		if (!empty($soal_urut_ok)) {
			foreach ($soal_urut_ok as $s) {
				$bacaan_soal = $s->isi_bacaan_soal <> 0 || !empty($s->isi_bacaan_soal) ? $s->isi_bacaan_soal . '<br />' : ''; // bacaan soal
				$bacaan_soal_name = $s->bacaan_soal_name <> 0 || !empty($s->bacaan_soal_name) ? '<b>' . $s->bacaan_soal_name . '</b><br />' : ''; // bacaan soal judul
				$group_soal_name = $s->group_soal_name <> 0 || !empty($s->group_soal_name) ? 'GROUP ' . $s->group_soal_name : '';

				$html .= '<h4 class="group-name">' . $group_soal_name . '</h4>';

				$html .= '<soal><quiz><table class="tbl-soal"><tr><td style="vertical-align:top;">' . $no . '. </td><td>' . $bacaan_soal_name . $bacaan_soal . $s->bank_soal_name . '</td></tr></table>';

				if ($s->group_mode_jwb_id == 1) {
					$jawaban = $this->tes->get_jawaban_by_id_pembahasan($s->bank_soal_id, $s->paket_soal_id);
					$jawaban_benar = $this->tes->get_jawaban_by_id_benar($s->bank_soal_id, $s->paket_soal_id);
					$opsi = config_item('_def_opsi_jawaban');

					foreach ($jawaban as $key_jawaban => $val_jawaban) {
						$checked = $arr_jawab[$s->bank_soal_id]["j"] == $val_jawaban->order ? "jawaban" : "";
						$html .= '<table class="tbl-jwb"><tr><td width="5px"><a class="btn ' . $checked . '" href="#">' . $opsi . '</a></td><td>' . $val_jawaban->name . '</td></tr>';
						$opsi++;
					}

					if ($jawaban_benar && $jawaban_benar == 1) {
						$key_opsi = 'A';
					} elseif ($jawaban_benar && $jawaban_benar == 2) {
						$key_opsi = 'B';
					} elseif ($jawaban_benar && $jawaban_benar == 3) {
						$key_opsi = 'C';
					} elseif ($jawaban_benar && $jawaban_benar == 4) {
						$key_opsi = 'D';
					} elseif ($jawaban_benar && $jawaban_benar == 5) {
						$key_opsi = 'E';
					}

					$html .= '<tr><td colspan="2">Kunci Jawaban : ' . $key_opsi . '</td></tr>';
				} else {
					$history_jawab = !empty($arr_jawab[$s->bank_soal_id]["j"]) ? $arr_jawab[$s->bank_soal_id]["j"] : "";
					$html .= '<tr><td colspan="2">' . $history_jawab . '</td></tr>';
				}

				$html .= '</table></quiz></soal>';

				$no++;
				$group_soal_name_before = $group_soal_name;
			}
		}

		$file_name = $buku->buku_name . ' ' . $ujian_data->user_name . ' (' . $ujian_data->user_no . ')';

		//for passing data to view
		$data = array(
			'buku' => $buku,
			'ljk' => $html,
			'ujian' => $ujian_data,
			'title' => $file_name
		);

		$this->load->view('website/lembaga/tes_online/report_buku/detail_ujian/content', $data);
	}
}
