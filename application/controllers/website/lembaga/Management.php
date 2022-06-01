<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Management extends CI_Controller
{
	/**
	 * Author : Candra Aji Pamungkas
	 * Create : 12-04-2021
	 * Change :
	 *      - {date} | {description}
	 */

	private $tbl_lembaga = 'lembaga';
	private $tbl_konversi_skor = 'konversi_skor';
	private $tbl_detail_konversi_skor = 'detail_konversi_skor';
	private $tbl_payment_method_detail = 'payment_method_detail';
	private $tbl_buku = 'buku';
	private $tbl_config_buku = 'config_buku';
	private $tbl_config_buku_detail = 'config_buku_detail';
	private $tbl_config_buku_group = 'config_buku_group';
	private $tbl_invoice = 'invoice';
	private $tbl_user_pembelian_buku = 'user_pembelian_buku';
	private $tbl_voucher = 'voucher';
	private $tbl_event = 'event';
	private $tbl_event_banner = 'event_banner';
	private $tbl_event_group_peserta = 'event_group_peserta';
	private $tbl_group_peserta = 'group_peserta';
	private $max_kuota_split = 200;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('has_login')) {
			redirect('admin/login');
		}
		$this->load->config('email');
		$this->load->model('General', 'general');
		$this->load->model('Management_model', 'management');
		$this->load->model('Invoice_list_admin_model', 'invoice_list_admin');
		$this->load->model('Invoice_confirm_admin_model', 'invoice_confirm_admin');
		$this->load->model('Invoice_success_admin_model', 'invoice_success_admin');
		$this->load->model('Invoice_expired_admin_model', 'invoice_expired_admin');
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

	public function data_lembaga()
	{
		//for passing data to view
		$data['content']['data_lembaga'] = $this->management->get_lembaga();
		$data['content']['get_kota_kab'] = $this->management->get_kota_kab();
		$data['content']['get_type_lembaga'] = $this->management->get_type_lembaga();
		$data['title_header'] = ['title' => 'Data Lembaga'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/data_lembaga/css';
		$view['content'] = 'website/lembaga/management/data_lembaga/content';
		$view['js_additional'] = 'website/lembaga/management/data_lembaga/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_data_lembaga()
	{
		$data = [];
		$lembaga_id = $this->input->post('lembaga_id', TRUE);
		$data['name'] = $this->input->post('name', TRUE);
		$data['lembaga_type_id'] = $this->input->post('lembaga_type_id', TRUE);
		$data['email'] = $this->input->post('email', TRUE);
		$data['alamat'] = $this->input->post('alamat');
		$data['no_telp'] = $this->input->post('no_telp', TRUE);
		$lembaga_kota_kab_data = $this->input->post('kota_kab_id', TRUE);
		$exp_kota_kab = explode("|", $lembaga_kota_kab_data);
		$data['kota_kab_id'] = $exp_kota_kab[0];
		$data['kota_kab'] = $exp_kota_kab[1];
		$data['informasi'] = $this->input->post('informasi');
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_lembaga;
		$update = $this->general->update_data($tbl, $data, $lembaga_id);

		$urly = 'admin/data-lembaga';
		$urlx = 'admin/data-lembaga';
		$this->update_end($update, $urly, $urlx);
	}

	public function konversi()
	{
		//for passing data to view
		$data['content']['konversi'] = $this->management->get_konversi();
		$data['title_header'] = ['title' => 'Konversi Skor'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/konversi_skor/css';
		$view['content'] = 'website/lembaga/management/konversi_skor/content';
		$view['js_additional'] = 'website/lembaga/management/konversi_skor/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_konversi()
	{
		//for passing data to view
		$data['content'] = [];
		$data['title_header'] = ['title' => 'Add Konversi Skor'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/konversi_skor/css';
		$view['content'] = 'website/lembaga/management/konversi_skor/add';
		$view['js_additional'] = 'website/lembaga/management/konversi_skor/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_konversi()
	{
		$data['name'] = $this->input->post('name');
		$data['created_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_konversi_skor;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/konversi-skor';
		$urlx = 'admin/add-konversi-skor';
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_konversi($id_konversi)
	{
		$konversi_id = base64_decode(urldecode($id_konversi));
		//for passing data to view
		$data['content']['konversi'] = $this->management->get_konversi_by_id($konversi_id);
		$data['content']['id_konversi'] = $id_konversi;
		$data['title_header'] = ['title' => 'Edit Konversi Skor'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/konversi_skor/css';
		$view['content'] = 'website/lembaga/management/konversi_skor/edit';
		$view['js_additional'] = 'website/lembaga/management/konversi_skor/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_konversi()
	{
		$konversi_skor_id_crypt = $this->input->post('id_konversi');
		$konversi_skor_id = base64_decode(urldecode($konversi_skor_id_crypt));

		$data['name'] = $this->input->post('name', TRUE);
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_konversi_skor;
		$update = $this->general->update_data($tbl, $data, $konversi_skor_id);

		$urly = 'admin/konversi-skor';
		$urlx = 'admin/edit-konversi-skor/' . $konversi_skor_id_crypt;
		$this->update_end($update, $urly, $urlx);
	}

	public function disable_konversi($id_konversi)
	{
		$konversi_skor_id = base64_decode(urldecode($id_konversi));

		$tbl = $this->tbl_konversi_skor;
		$delete = $this->general->delete_data($tbl, $konversi_skor_id);

		$urly = 'admin/konversi-skor';
		$urlx = 'admin/konversi-skor';
		$this->delete_end($delete, $urly, $urlx);
	}

	public function detail_konversi($id_konversi)
	{
		$konversi_skor_id = $konversi_id = base64_decode(urldecode($id_konversi));

		//for passing data to view
		$data['content']['detail_konversi'] = $this->management->get_detail_konversi_by_konversi($konversi_skor_id);
		$data['content']['id_konversi'] = $id_konversi;
		$data['title_header'] = ['title' => 'Detail Konversi Skor'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
		$view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/content';
		$view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_detail_konversi($id_konversi)
	{
		//for passing data to view
		$data['content']['id_konversi'] = $id_konversi;
		$data['title_header'] = ['title' => 'Add Detail Konversi Skor'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
		$view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/add';
		$view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_detail_konversi()
	{
		$konversi_skor_id_crypt = $this->input->post('id_konversi');

		$data['konversi_skor_id'] = $konversi_id = base64_decode(urldecode($konversi_skor_id_crypt));
		$data['skor_asal'] = $this->input->post('skor_asal', TRUE);
		$data['skor_konversi'] = $this->input->post('skor_konversi', TRUE);
		$data['created_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_detail_konversi_skor;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/detail-konversi-skor/' . $konversi_skor_id_crypt;
		$urlx = 'admin/add-detail-konversi-skor/' . $konversi_skor_id_crypt;
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_detail_konversi($id_detail_konversi, $id_konversi)
	{
		$detail_konversi_id = base64_decode(urldecode($id_detail_konversi));
		//for passing data to view
		$data['content']['detail_konversi'] = $this->management->get_detail_konversi_by_id($detail_konversi_id);
		$data['content']['id_detail_konversi'] = $id_detail_konversi;
		$data['content']['id_konversi'] = $id_konversi;
		$data['title_header'] = ['title' => 'Edit Detail Konversi Skor'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
		$view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/edit';
		$view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_detail_konversi()
	{
		$id_konversi = $this->input->post('id_konversi');
		$detail_konversi_skor_id_crypt = $this->input->post('id_detail_konversi');
		$detail_konversi_skor_id = $konversi_id = base64_decode(urldecode($detail_konversi_skor_id_crypt));

		$data['skor_asal'] = $this->input->post('skor_asal', TRUE);
		$data['skor_konversi'] = $this->input->post('skor_konversi', TRUE);
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_detail_konversi_skor;
		$update = $this->general->update_data($tbl, $data, $detail_konversi_skor_id);

		$urly = 'admin/detail-konversi-skor/' . $id_konversi;
		$urlx = 'admin/edit-detail-konversi-skor/' . $id_konversi;
		$this->update_end($update, $urly, $urlx);
	}

	public function disable_detail_konversi($id_detail_konversi, $id_konversi)
	{
		$detail_konversi_skor_id = base64_decode(urldecode($id_detail_konversi));

		$tbl = $this->tbl_detail_konversi_skor;
		$delete = $this->general->delete_data($tbl, $detail_konversi_skor_id);

		$urly = 'admin/detail-konversi-skor/' . $id_konversi;
		$urlx = 'admin/detail-konversi-skor/' . $id_konversi;
		$this->delete_end($delete, $urly, $urlx);
	}

	public function import_detail_konversi($id_konversi, $datas = NULL)
	{
		$name_config = 'TEMPLATE UPLOAD';
		$detail_config = 'UPLOAD DATA KONVERSI';

		if (!empty($datas)) {
			$data['content']['message'] = $datas;
		} else {
			$data['content']['message'] = '';
		}

		//for passing data to view
		$data['content']['id_konversi'] = $id_konversi;
		$data['content']['file_template'] = $this->management->get_pengaturan_universal_id($name_config, $detail_config);
		$data['title_header'] = ['title' => 'Import Detail Konversi Skor'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
		$view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/upload_excel';
		$view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_import_detail_konversi()
	{
		$konversi_id_crypt = $this->input->post('id_konversi');
		$konversi_id = base64_decode(urldecode($konversi_id_crypt));

		//Define penampung data
		$skor_asal = '';
		$skor_konversi = '';
		$detail_konversi = '';

		if ($_FILES["data_konversi"]["name"] != '') {
			$allowed_extension = array('xls', 'xlsx');
			$file_array = explode(".", $_FILES["data_konversi"]["name"]);
			$file_extension = end($file_array);

			if (in_array($file_extension, $allowed_extension)) {
				$file_name = time() . '.' . $file_extension;
				move_uploaded_file($_FILES['data_konversi']['tmp_name'], $file_name);
				$file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

				$spreadsheet = $reader->load($file_name);

				unlink($file_name);

				$data = $spreadsheet->getActiveSheet()->toArray();

				$no_null = 0;
				$no_upload = 0;
				//Detail data untuk peserta dan user
				foreach ($data as $key => $row) {
					if ($key > 0 && (($row[0] != '' && $row[1] != '') || ($row[0] >= 0 && $row[1] >= 0))) { //Header tidak diikutkan di save
						//Define
						$skor_asal = trim($row[0]);
						$skor_konversi = trim($row[1]);

						$data = [];

						$tbl = $this->tbl_detail_konversi_skor;
						$data = array(
							'konversi_skor_id' => $konversi_id,
							'skor_asal' => $skor_asal,
							'skor_konversi' => $skor_konversi,
							'created_datetime' => date('Y-m-d H:i:s')
						);

						$insert_konversi = $this->general->input_data($tbl, $data);

						$no_upload++;
					} elseif ($key > 0 && ($row[0] == '' && $row[1] == '')) {
						$no_null++;
					}
				}

				if ($no_null) {
					$text = '<div class="alert alert-info">' . $no_upload . ' Data berhasil disimpan, Tetapi Terdapat ' . $no_null . ' data upload yang gagal, periksa kembali jika ada data yang masih kosong</div>';
					$this->import_detail_konversi($konversi_id_crypt, $text);
				} else {
					$text = '<div class="alert alert-success">' . $no_upload . ' Data berhasil disimpan</div>';
					$this->import_detail_konversi($konversi_id_crypt, $text);
				}
			} else {
				$text = '<div class="alert alert-danger">Hanya tipe excel .xls dan .xlsx yang diijinkan</div>';
				$this->import_detail_konversi($konversi_id_crypt, $text);
			}
		} else {
			$text = '<div class="alert alert-danger">Tidak ada file yang diupload</div>';
			$this->import_detail_konversi($konversi_id_crypt, $text);
		}
	}

	public function pembayaran_master()
	{
		//for passing data to view
		$data['content']['pembayaran_master'] = $this->management->get_pembayaran_master();
		$data['title_header'] = ['title' => 'Master Pembayaran'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
		$view['content'] = 'website/lembaga/management/pembayaran_master/content';
		$view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function detail_pembayaran_master($id_pembayaran_master)
	{
		$pembayaran_master_id = base64_decode(urldecode($id_pembayaran_master));
		//for passing data to view
		$data['content']['detail_pembayaran_master'] = $this->management->get_pembayaran_master_by_id($pembayaran_master_id);
		$data['content']['pembayaran_master_id'] = $pembayaran_master_id;
		$data['content']['id_pembayaran_master'] = $id_pembayaran_master;
		$data['title_header'] = ['title' => 'Detail Master Pembayaran'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
		$view['content'] = 'website/lembaga/management/pembayaran_master/detail';
		$view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_detail_pembayaran_master($pembayaran_master_id)
	{
		//for passing data to view
		$data['content']['id_pembayaran_master'] = $pembayaran_master_id;
		$data['title_header'] = ['title' => 'Add Detail Master Pembayaran'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
		$view['content'] = 'website/lembaga/management/pembayaran_master/add';
		$view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_detail_pembayaran_master()
	{
		$data = [];
		$pembayaran_master_id_crypt = $this->input->post('id_pembayaran_master');
		$pembayaran_master_id = base64_decode(urldecode($pembayaran_master_id_crypt));

		$data['payment_method_id'] = $pembayaran_master_id;
		//logo payment
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/master_pembayaran/';
		$config['allowed_types']    = 'jpg|png|jpeg';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['logo_payment']['name'])) {
			if (!$this->upload->do_upload('logo_payment')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Gambar Logo Payment Error');
				exit();
			} else {
				$data['logo_payment'] = $this->upload->data('file_name');
			}
		}

		//Image Payment
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/master_pembayaran/';
		$config['allowed_types']    = 'jpg|png|jpeg';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['image_payment']['name'])) {
			if (!$this->upload->do_upload('image_payment')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Gambar Image Payment Error');
				exit();
			} else {
				$data['image_payment'] = $this->upload->data('file_name');
			}
		}

		$data['bank_name'] = strtoupper($this->input->post('bank_name', TRUE));
		$data['bank_account'] = ucwords($this->input->post('bank_account', TRUE));
		$data['bank_number'] = $this->input->post('bank_number', TRUE);
		$data['created_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_payment_method_detail;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/detail-pembayaran-master/' . $pembayaran_master_id_crypt;
		$urlx = 'admin/add-detail-pembayaran-master/' . $pembayaran_master_id_crypt;
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_detail_pembayaran_master($id_pembayaran_detail_master)
	{
		$pembayaran_detail_master_id = base64_decode(urldecode($id_pembayaran_detail_master));
		//for passing data to view
		$data['content']['detail_pembayaran_master'] = $this->management->get_detail_master_pembayaran($pembayaran_detail_master_id);
		$data['content']['id_pembayaran_detail_master'] = $id_pembayaran_detail_master;
		$data['title_header'] = ['title' => 'Edit Detail Master Pembayaran'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
		$view['content'] = 'website/lembaga/management/pembayaran_master/edit';
		$view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_detail_pembayaran_master()
	{
		$data = [];
		$pembayaran_detail_master_id_crypt = $this->input->post('id_pembayaran_detail_master');
		$pembayaran_detail_master_id = base64_decode(urldecode($pembayaran_detail_master_id_crypt));

		$pembayaran_master_id_crypt = $this->input->post('id_pembayaran_master');
		$pembayaran_master_id = base64_decode(urldecode($pembayaran_master_id_crypt));

		//logo payment
		$old_name_logo = $this->input->post('old_name_logo');
		if ($old_name_logo == NULL || $old_name_logo == '') {
			$old_name_logo_x = NULL;
		} else {
			$old_name_logo_x = $old_name_logo;
		}
		//image payment
		$old_name_image = $this->input->post('old_name_image');
		if ($old_name_image == NULL || $old_name_image == '') {
			$old_name_image_x = NULL;
		} else {
			$old_name_image_x = $old_name_image;
		}

		//logo payment
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/master_pembayaran/';
		$config['allowed_types']    = 'jpg|png|jpeg';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['logo_payment']['name'])) {
			if (!$this->upload->do_upload('logo_payment')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Gambar Logo Payment Error');
				exit();
			} else {
				$data['logo_payment'] = $this->upload->data('file_name');
			}
		} else {
			$data['logo_payment'] = $old_name_logo_x;
		}

		//Image Payment
		$config['upload_path']      = FCPATH . 'storage/website/lembaga/grandsbmptn/master_pembayaran/';
		$config['allowed_types']    = 'jpg|png|jpeg';
		$config['encrypt_name']     = TRUE;
		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!empty($_FILES['image_payment']['name'])) {
			if (!$this->upload->do_upload('image_payment')) {
				$error = $this->upload->display_errors();
				show_error($error, 500, 'File Gambar Image Payment Error');
				exit();
			} else {
				$data['image_payment'] = $this->upload->data('file_name');
			}
		} else {
			$data['image_payment'] = $old_name_image_x;
		}

		$data['bank_name'] = $this->input->post('bank_name', TRUE);
		$data['bank_account'] = $this->input->post('bank_account', TRUE);
		$data['bank_number'] = $this->input->post('bank_number', TRUE);
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_payment_method_detail;
		$update = $this->general->update_data($tbl, $data, $pembayaran_detail_master_id);

		$urly = 'admin/detail-pembayaran-master/' . $pembayaran_master_id_crypt;
		$urlx = 'admin/edit-detail-pembayaran-master/' . $pembayaran_master_id_crypt;
		$this->input_end($update, $urly, $urlx);
	}

	public function disable_detail_pembayaran_master($id_pembayaran_detail_master, $id_pembayaran_master)
	{
		$pembayaran_detail_master_id = base64_decode(urldecode($id_pembayaran_detail_master));

		$tbl = $this->tbl_payment_method_detail;
		$delete = $this->general->delete_data($tbl, $pembayaran_detail_master_id);

		$urly = 'admin/detail-pembayaran-master/' . $id_pembayaran_master;
		$urlx = 'admin/detail-pembayaran-master/' . $id_pembayaran_master;
		$this->delete_end($delete, $urly, $urlx);
	}

	public function setting_buku()
	{
		//for passing data to view
		$data['content']['buku_data'] = $this->management->get_buku_config();
		$data['title_header'] = ['title' => 'Setting Buku'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/buku_setting/css';
		$view['content'] = 'website/lembaga/management/buku_setting/content';
		$view['js_additional'] = 'website/lembaga/management/buku_setting/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function group_buku_detail($id_buku)
	{
		$buku_id = base64_decode(urldecode($id_buku));

		//for passing data to view
		$get_buku = $this->management->get_buku($buku_id);
		$config_buku = $this->management->config_buku($buku_id);
		$data['content']['group_buku'] = $this->management->get_group_buku_by_buku($buku_id);
		$data['content']['id_buku'] = $id_buku;
		$data['content']['config_buku_id'] = urlencode(base64_encode($config_buku->id));
		$data['content']['buku_name'] = $get_buku->buku_name;
		$data['title_header'] = ['title' => 'Group Modul'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/buku_setting/css';
		$view['content'] = 'website/lembaga/management/buku_setting/group';
		$view['js_additional'] = 'website/lembaga/management/buku_setting/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_group_buku_detail($id_buku, $id_config_buku)
	{
		$data['content']['id_buku'] = $id_buku;
		$data['content']['id_config_buku'] = $id_config_buku;
		$data['title_header'] = ['title' => 'Add Group'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/buku_setting/css';
		$view['content'] = 'website/lembaga/management/buku_setting/add_group';
		$view['js_additional'] = 'website/lembaga/management/buku_setting/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_group_modul()
	{
		$id_buku = $this->input->post('id_buku');
		$id_config_buku = $this->input->post('id_config_buku');
		$config_buku_id = base64_decode(urldecode($id_config_buku));

		$data['name'] = $this->input->post('name', TRUE);
		$data['config_buku_id'] = $config_buku_id;
		$data['created_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_config_buku_group;
		$input = $this->general->input_data($tbl, $data);
		$urly = 'admin/group-buku/' . $id_buku;
		$urlx = 'admin/add-group-buku/' . $id_buku . '/' . $id_config_buku;
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_group_buku_setting($id_buku, $id_config_group)
	{
		$config_group_id = base64_decode(urldecode($id_config_group));

		$group = $this->management->get_group_modul_by_id($config_group_id);
		$data['content']['config_group'] = $group;
		$data['content']['id_config_group'] = urlencode(base64_encode($group->id));
		$data['content']['id_config_buku'] = $id_config_group;
		$data['content']['id_buku'] = $id_buku;
		$data['title_header'] = ['title' => 'Edit Group'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/buku_setting/css';
		$view['content'] = 'website/lembaga/management/buku_setting/edit_group';
		$view['js_additional'] = 'website/lembaga/management/buku_setting/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_group_buku_setting()
	{
		$id_buku = $this->input->post('id_buku');
		$id_config_buku = $this->input->post('id_config_buku');
		$id_config_group = $this->input->post('id_config_group');
		$config_group_id = base64_decode(urldecode($id_config_group));

		$data['name'] = $this->input->post('name', TRUE);
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_config_buku_group;
		$update = $this->general->update_data($tbl, $data, $config_group_id);
		$urly = 'admin/group-buku/' . $id_buku;
		$urlx = 'admin/edit-group-buku/' . $id_buku . '/' . $id_config_buku;
		$this->update_end($update, $urly, $urlx);
	}

	public function setting_buku_detail($id_buku, $id_config_buku, $id_config_buku_group)
	{
		$buku_id = base64_decode(urldecode($id_buku));
		$config_buku_id = base64_decode(urldecode($id_config_buku));
		$config_buku_group_id = base64_decode(urldecode($id_config_buku_group));

		//for passing data to view
		$get_buku = $this->management->get_buku($buku_id);
		$get_group_buku = $this->management->get_group_buku($config_buku_group_id);
		$data['content']['detail_buku'] = $this->management->get_detail_buku_by_group($config_buku_group_id);
		$data['content']['id_buku'] = $id_buku;
		$data['content']['id_config_buku'] = $id_config_buku;
		$data['content']['id_config_buku_group'] = $id_config_buku_group;
		$data['content']['buku_name'] = $get_buku->buku_name;
		$data['content']['group_buku_name'] = $get_group_buku->group_buku_name;
		$data['title_header'] = ['title' => 'Detail Modul'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/buku_setting/css';
		$view['content'] = 'website/lembaga/management/buku_setting/detail';
		$view['js_additional'] = 'website/lembaga/management/buku_setting/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_detail_buku_setting($id_buku, $id_config_buku, $id_config_buku_group)
	{
		$data['content']['id_buku'] = $id_buku;
		$data['content']['id_config_buku'] = $id_config_buku;
		$data['content']['id_config_buku_group'] = $id_config_buku_group;
		$data['content']['detail_jurusan'] = $this->management->get_detail_jurusan();
		$data['title_header'] = ['title' => 'Add Detail Modul'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/buku_setting/css';
		$view['content'] = 'website/lembaga/management/buku_setting/add_detail';
		$view['js_additional'] = 'website/lembaga/management/buku_setting/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function save_gambar_buku_detail()
	{
		$buku_id_encrypt = $this->input->post('id_buku');
		$config_buku_id_encrypt = $this->input->post('id_config_buku');
		$config_buku_group_id_encrypt = $this->input->post('id_config_buku_group');

		$data['buku_id'] = base64_decode(urldecode($buku_id_encrypt));
		$data['config_buku_id'] = base64_decode(urldecode($config_buku_id_encrypt));
		$data['config_buku_group_id'] = base64_decode(urldecode($config_buku_group_id_encrypt));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$detail_buku_id = $this->input->post('detail_buku_id', TRUE);
		if ($detail_buku_id == '' || empty($detail_buku_id)) {
			$detail_buku_id_x = 0;
		} else {
			$detail_buku_id_x = $detail_buku_id;
		}
		$data['detail_buku_id'] = $detail_buku_id_x;

		$config['upload_path']    = './storage/website/lembaga/grandsbmptn/modul';
		$config['allowed_types']  = 'gif|jpg|png';
		$config['encrypt_name']   = TRUE;

		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('filegambar')) {
			$error = array('error' => $this->upload->display_errors());
			show_error($error, 500, 'File Gambar Modul Error');
			exit();
		} else {
			$data['nama_file'] = $this->upload->data('file_name');
			$data['type_file'] = '1'; // gambar
			$data['created_date'] = date('Y-m-d H:i:s');
			$tbl = $this->tbl_config_buku_detail;
			$input = $this->general->input_data($tbl, $data);
			$urly = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
			$urlx = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
			$this->input_end($input, $urly, $urlx);
		}
	}

	public function save_audio_buku_detail()
	{
		$buku_id_encrypt = $this->input->post('id_buku');
		$config_buku_id_encrypt = $this->input->post('id_config_buku');
		$config_buku_group_id_encrypt = $this->input->post('id_config_buku_group');

		$data['buku_id'] = base64_decode(urldecode($buku_id_encrypt));
		$data['config_buku_id'] = base64_decode(urldecode($config_buku_id_encrypt));
		$data['config_buku_group_id'] = base64_decode(urldecode($config_buku_group_id_encrypt));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$detail_buku_id = $this->input->post('detail_buku_id', TRUE);
		if ($detail_buku_id == '' || empty($detail_buku_id)) {
			$detail_buku_id_x = 0;
		} else {
			$detail_buku_id_x = $detail_buku_id;
		}
		$data['detail_buku_id'] = $detail_buku_id_x;

		$config['upload_path']     = './storage/website/lembaga/grandsbmptn/modul';
		$config['allowed_types']   = 'mpeg|mpg|mpeg3|mp3|/x-wav|wave|wav';
		$config['encrypt_name']    = TRUE;

		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('fileaudio')) {
			$error = array('error' => $this->upload->display_errors());
			show_error($error, 500, 'File Audio Modul Error');
			exit();
		} else {
			$gambar = $this->upload->data('file_name');

			$data['nama_file'] = $gambar;
			$data['type_file'] = '2'; // audio
			$data['created_date'] = date('Y-m-d H:i:s');
			$tbl = $this->tbl_config_buku_detail;
			$input = $this->general->input_data($tbl, $data);
			$urly = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
			$urlx = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
			$this->input_end($input, $urly, $urlx);
		}
	}

	public function save_video_buku_detail()
	{
		$buku_id_encrypt = $this->input->post('id_buku');
		$config_buku_id_encrypt = $this->input->post('id_config_buku');
		$config_buku_group_id_encrypt = $this->input->post('id_config_buku_group');

		$data['buku_id'] = base64_decode(urldecode($buku_id_encrypt));
		$data['config_buku_id'] = base64_decode(urldecode($config_buku_id_encrypt));
		$data['config_buku_group_id'] = base64_decode(urldecode($config_buku_group_id_encrypt));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$detail_buku_id = $this->input->post('detail_buku_id', TRUE);
		if ($detail_buku_id == '' || empty($detail_buku_id)) {
			$detail_buku_id_x = 0;
		} else {
			$detail_buku_id_x = $detail_buku_id;
		}
		$data['detail_buku_id'] = $detail_buku_id_x;

		//Video
		$config['upload_path']    = './storage/website/lembaga/grandsbmptn/modul';
		$config['allowed_types']  = 'avi|flv|wmv|mp3|mp4|gif|jpg|png';
		$config['encrypt_name']   = TRUE;

		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('filevideo')) {
			$error = array('error' => $this->upload->display_errors());
			show_error($error, 500, 'File Video Modul Error');
			exit();
		} else {
			$video = $this->upload->data('file_name');

			//Thumbnail
			$config['encrypt_name']   = TRUE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('thumbnail')) {
				$error = array('error' => $this->upload->display_errors());
				show_error($error, 500, 'File Thumbnail Video Modul Error');
				exit();
			} else {
				$data['nama_file'] = $video;
				$data['thumbnail'] = $this->upload->data('file_name');
				$data['type_file'] = '3'; //video
				$data['created_date'] = date('Y-m-d H:i:s');
				$tbl = $this->tbl_config_buku_detail;
				$input = $this->general->input_data($tbl, $data);

				$urly = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
				$urlx = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
				$this->input_end($input, $urly, $urlx);
			}
		}
	}

	public function save_text_buku_detail()
	{
		$buku_id_encrypt = $this->input->post('id_buku');
		$config_buku_id_encrypt = $this->input->post('id_config_buku');
		$config_buku_group_id_encrypt = $this->input->post('id_config_buku_group');

		$data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));
		$data['config_buku_id'] = base64_decode(urldecode($config_buku_id_encrypt));
		$data['config_buku_group_id'] = base64_decode(urldecode($config_buku_group_id_encrypt));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$detail_buku_id = $this->input->post('detail_buku_id', TRUE);
		if ($detail_buku_id == '' || empty($detail_buku_id)) {
			$detail_buku_id_x = 0;
		} else {
			$detail_buku_id_x = $detail_buku_id;
		}
		$data['detail_buku_id'] = $detail_buku_id_x;
		$data['nama_file'] = $this->input->post('summernote');
		$data['type_file'] = '4'; //text
		$data['created_date'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_config_buku_detail;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
		$urlx = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
		$this->input_end($input, $urly, $urlx);
	}

	public function save_link_buku_detail()
	{
		$buku_id_encrypt = $this->input->post('id_buku');
		$config_buku_id_encrypt = $this->input->post('id_config_buku');
		$config_buku_group_id_encrypt = $this->input->post('id_config_buku_group');

		$data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));
		$data['config_buku_id'] = base64_decode(urldecode($config_buku_id_encrypt));
		$data['config_buku_group_id'] = base64_decode(urldecode($config_buku_group_id_encrypt));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$detail_buku_id = $this->input->post('detail_buku_id', TRUE);
		if ($detail_buku_id == '' || empty($detail_buku_id)) {
			$detail_buku_id_x = 0;
		} else {
			$detail_buku_id_x = $detail_buku_id;
		}
		$data['detail_buku_id'] = $detail_buku_id_x;
		$data['nama_file'] = $this->input->post('link');
		$data['type_file'] = '5'; //link
		$data['created_date'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_config_buku_detail;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
		$urlx = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
		$this->input_end($input, $urly, $urlx);
	}

	public function save_file_buku_detail()
	{
		$buku_id_encrypt = $this->input->post('id_buku');
		$config_buku_id_encrypt = $this->input->post('id_config_buku');
		$config_buku_group_id_encrypt = $this->input->post('id_config_buku_group');

		$data['buku_id'] = base64_decode(urldecode($buku_id_encrypt));
		$data['config_buku_id'] = base64_decode(urldecode($config_buku_id_encrypt));
		$data['config_buku_group_id'] = base64_decode(urldecode($config_buku_group_id_encrypt));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$detail_buku_id = $this->input->post('detail_buku_id', TRUE);
		if ($detail_buku_id == '' || empty($detail_buku_id)) {
			$detail_buku_id_x = 0;
		} else {
			$detail_buku_id_x = $detail_buku_id;
		}
		$data['detail_buku_id'] = $detail_buku_id_x;

		$config['upload_path']    = './storage/website/lembaga/grandsbmptn/modul';
		$config['allowed_types']  = 'pdf|xlsx|doc|docx|pptx';
		$config['encrypt_name']   = TRUE;

		$_upload_path = $config['upload_path'];

		if (!file_exists($_upload_path)) {
			mkdir($_upload_path, 0777);
		}

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('filedokumen')) {
			$error = array('error' => $this->upload->display_errors());
			show_error($error, 500, 'File Dokumen Modul Error');
			exit();
		} else {
			$gambar = $this->upload->data('file_name');
			$data['nama_file'] = $gambar;
			$data['type_file'] = '6'; //File
			$data['created_date'] = date('Y-m-d H:i:s');
			$tbl = $this->tbl_config_buku_detail;
			$input = $this->general->input_data($tbl, $data);

			$urly = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
			$urlx = 'admin/detail-buku/' . $buku_id_encrypt . '/' . $config_buku_id_encrypt . '/' . $config_buku_group_id_encrypt;
			$this->input_end($input, $urly, $urlx);
		}
	}

	public function editor_modul()
	{
		$data = [];
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_modul');
		$target_dir = $this->input->post('folder', TRUE);
		$buku_id = urlencode(base64_encode($this->input->post('id_buku')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/detail-buku/' . $buku_id);
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

	public function editor_modul_delete()
	{
		$datas = [];
		$_token = $this->input->post('_token', TRUE);
		$validation = config_item('_token_modul');
		$src = $this->input->post('src', TRUE);
		$file_name = str_replace(base_url(), '', $src);
		$buku_id = urlencode(base64_encode($this->input->post('id_buku')));

		if ($validation != $_token || empty($_token)) {
			$this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
			redirect('admin/detail-buku/' . $buku_id);
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

	public function edit_setting_buku($id_config_buku)
	{
		$config_buku_id = base64_decode(urldecode($id_config_buku));
		//for passing data to view
		$data['content']['config_buku'] = $this->management->get_buku_config_by_id($config_buku_id);
		$data['content']['id_config_buku'] = $id_config_buku;
		$data['title_header'] = ['title' => 'Edit Buku'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/buku_setting/css';
		$view['content'] = 'website/lembaga/management/buku_setting/edit';
		$view['js_additional'] = 'website/lembaga/management/buku_setting/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_setting_buku()
	{
		$config_buku_id_crypt = $this->input->post('id_config_buku');
		$config_buku_id = base64_decode(urldecode($config_buku_id_crypt));

		$data['free_paket'] = $this->input->post('free_paket', TRUE);
		$data['price'] = $this->input->post('price', TRUE);
		$data['desc'] = $this->input->post('desc');
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$tbl = $this->tbl_config_buku;
		$update = $this->general->update_data($tbl, $data, $config_buku_id);

		$urly = 'admin/buku-setting';
		$urlx = 'admin/edit-buku-setting/' . $config_buku_id_crypt;
		$this->update_end($update, $urly, $urlx);
	}

	public function disable_detail_buku_setting($id_config_buku_detail, $id_buku)
	{
		$config_buku_detail_id = base64_decode(urldecode($id_config_buku_detail));

		$tbl = $this->tbl_config_buku_detail;
		$delete = $this->general->delete_data($tbl, $config_buku_detail_id);

		$urly = 'admin/detail-buku/' . $id_buku;
		$urlx = 'admin/detail-buku/' . $id_buku;
		$this->delete_end($delete, $urly, $urlx);
	}

	public function invoice_list()
	{
		//for passing data to view
		$data['content'] = [];
		$data['title_header'] = ['title' => 'Invoice All List'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/invoice/invoice_all/css';
		$view['content'] = 'website/lembaga/management/invoice/invoice_all/content';
		$view['js_additional'] = 'website/lembaga/management/invoice/invoice_all/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function invoice_list_all()
	{ //page 1
		$list = $this->invoice_list_admin->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$url_manual_confirm = base_url() . 'admin/invoice/manual-confirm/1/';
		$url_delete = base_url() . 'admin/invoice/delete-invoice/1/';
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<div class="table-data-feature">
                        <a href="' . $url_manual_confirm . urlencode(base64_encode($field->id_invoice)) . '" class="item" data-toggle="tooltip" data-placement="top" title="Manual Confirm">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="' . $url_delete . urlencode(base64_encode($field->id_invoice)) . '" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="zmdi zmdi-delete"></i>
                        </a>
                    </div>';
			$row[] = $field->invoice_number;
			$row[] = $field->status_invoice;
			$row[] = rupiah($field->invoice_total_cost);
			$row[] = $field->payment_method_detail_name;
			$row[] = $field->buku_name;
			$row[] = $field->user_name;
			$row[] = $field->user_email;
			$row[] = $field->user_no_telp;
			$row[] = $field->voucher_name;
			$row[] = rupiah($field->voucher_potongan);
			$row[] = format_indo($field->invoice_date_create);
			$row[] = format_indo($field->invoice_date_expirate);
			$row[] = $field->date_left . ' Left';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_list_admin->count_all(),
			"recordsFiltered" => $this->invoice_list_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function export_invoice_all()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Invoice');
		$sheet->setCellValue('C1', 'Status Invoice');
		$sheet->setCellValue('D1', 'Harga');
		$sheet->setCellValue('E1', 'Payment');
		$sheet->setCellValue('F1', 'Buku');
		$sheet->setCellValue('G1', 'Name');
		$sheet->setCellValue('H1', 'Email');
		$sheet->setCellValue('I1', 'No Telp');
		$sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
		$sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
		$sheet->setCellValue('L1', 'Voucher');
		$sheet->setCellValue('M1', 'Potongan');

		$siswa = $this->management->get_invoice_all();
		$no = 1;
		$x = 2;
		foreach ($siswa as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->invoice_number);
			$sheet->setCellValue('C' . $x, $row->status_invoice);
			$sheet->setCellValue('D' . $x, $row->invoice_total_cost);
			$sheet->setCellValue('E' . $x, $row->payment_method_detail_name);
			$sheet->setCellValue('F' . $x, $row->buku_name);
			$sheet->setCellValue('G' . $x, $row->user_name);
			$sheet->setCellValue('H' . $x, $row->user_email);
			$sheet->setCellValue('I' . $x, $row->user_no_telp);
			$sheet->setCellValue('J' . $x, format_indo($row->invoice_date_create));
			$sheet->setCellValue('K' . $x, format_indo($row->invoice_date_expirate));
			$sheet->setCellValue('L' . $x, $row->voucher_name);
			$sheet->setCellValue('M' . $x, $row->voucher_potongan);
			$x++;
		}

		// Column sizing
		foreach (range('A', 'M') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'All-Data-invoice';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function invoice_confirm()
	{
		//for passing data to view
		$data['content'] = [];
		$data['title_header'] = ['title' => 'Invoice All Confirm'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/invoice/invoice_confirm/css';
		$view['content'] = 'website/lembaga/management/invoice/invoice_confirm/content';
		$view['js_additional'] = 'website/lembaga/management/invoice/invoice_confirm/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function invoice_list_confirm_all()
	{ //page 2
		$list = $this->invoice_confirm_admin->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$url_manual_confirm = base_url() . 'admin/invoice/manual-confirm/2/';
		$url_reject_confirm = base_url() . 'admin/invoice/reject-confirm/';
		$url_delete = base_url() . 'admin/invoice/delete-invoice/2/';
		foreach ($list as $field) {
			$no++;
			$status_invoice = !empty($field->invoice_date_update) || $field->invoice_date_update != '' ? '<h6>' . $field->status_invoice . '<br /><small class="bg-success text-white">' . format_indo($field->invoice_date_update) . '</small></h6>' : '<h6>' . $field->status_invoice . '<br /><small class="bg-danger text-white">Tanggal Tidak Tersimpan</small></h6>';
			$row = array();
			$row[] = $no;
			$row[] = '<div class="table-data-feature">
                        <a href="' . $url_manual_confirm . urlencode(base64_encode($field->id_invoice)) . '" class="item" data-toggle="tooltip" data-placement="top" title="Manual Confirm">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="' . $url_reject_confirm . urlencode(base64_encode($field->id_invoice)) . '" class="item" data-toggle="tooltip" data-placement="top" title="Reject Confirm">
                        <i class="fa fa-times"></i>
                    </a>
                        <a href="' . $url_delete . urlencode(base64_encode($field->id_invoice)) . '" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="zmdi zmdi-delete"></i>
                        </a>
                    </div>';
			$row[] = '<a class="lightbox" href="#' . $field->invoice_number . '" title="Klik untuk memperbesar gambar">
                        <img src="' . config_item('_dir_website') . 'lembaga/grandsbmptn/confirm_payment/' . $field->confirm_image . '" width="100px;"/>
                    </a>
                    <div class="lightbox-target" id="' . $field->invoice_number . '">
                        <img src="' . config_item('_dir_website') . 'lembaga/grandsbmptn/confirm_payment/' . $field->confirm_image . '"/>
                        <a class="lightbox-close" href="#"></a>
                    </div>';
			$row[] = $field->invoice_number;
			$row[] = $status_invoice;
			$row[] = rupiah($field->invoice_total_cost);
			$row[] = $field->payment_method_detail_name;
			$row[] = $field->buku_name;
			$row[] = $field->user_name;
			$row[] = $field->user_email;
			$row[] = $field->user_no_telp;
			$row[] = $field->voucher_name;
			$row[] = rupiah($field->voucher_potongan);
			$row[] = format_indo($field->invoice_date_create);
			$row[] = format_indo($field->invoice_date_expirate);

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_confirm_admin->count_all(),
			"recordsFiltered" => $this->invoice_confirm_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function export_invoice_all_confirm()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Invoice');
		$sheet->setCellValue('C1', 'Status Invoice');
		$sheet->setCellValue('D1', 'Harga');
		$sheet->setCellValue('E1', 'Payment');
		$sheet->setCellValue('F1', 'Buku');
		$sheet->setCellValue('G1', 'Name');
		$sheet->setCellValue('H1', 'Email');
		$sheet->setCellValue('I1', 'No Telp');
		$sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
		$sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
		$sheet->setCellValue('L1', 'Tanggal Invoice Konfirmasi');
		$sheet->setCellValue('M1', 'voucher');
		$sheet->setCellValue('N1', 'Potongan');

		$siswa = $this->management->get_invoice_confirm();
		$no = 1;
		$x = 2;
		foreach ($siswa as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->invoice_number);
			$sheet->setCellValue('C' . $x, $row->status_invoice);
			$sheet->setCellValue('D' . $x, $row->invoice_total_cost);
			$sheet->setCellValue('E' . $x, $row->payment_method_detail_name);
			$sheet->setCellValue('F' . $x, $row->buku_name);
			$sheet->setCellValue('G' . $x, $row->user_name);
			$sheet->setCellValue('H' . $x, $row->user_email);
			$sheet->setCellValue('I' . $x, $row->user_no_telp);
			$sheet->setCellValue('J' . $x, format_indo($row->invoice_date_create));
			$sheet->setCellValue('K' . $x, format_indo($row->invoice_date_expirate));
			$sheet->setCellValue('L' . $x, format_indo($row->invoice_date_update));
			$sheet->setCellValue('M' . $x, $row->voucher_name);
			$sheet->setCellValue('N' . $x, $row->voucher_potongan);
			$x++;
		}

		// Column sizing
		foreach (range('A', 'N') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'All-Data-invoice-confirm';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function invoice_success()
	{
		//for passing data to view
		$data['content'] = [];
		$data['title_header'] = ['title' => 'Invoice All Success'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/invoice/invoice_success/css';
		$view['content'] = 'website/lembaga/management/invoice/invoice_success/content';
		$view['js_additional'] = 'website/lembaga/management/invoice/invoice_success/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function invoice_list_success_all()
	{ //page 3
		$list = $this->invoice_success_admin->get_datatables();

		$data = array();
		$no = $_POST['start'];
		$url_manual_confirm = base_url() . 'admin/invoice/manual-confirm/3/';
		$url_delete = base_url() . 'admin/invoice/delete-invoice/3/';
		foreach ($list as $field) {
			$status_invoice = !empty($field->invoice_date_update) || $field->invoice_date_update != '' ? '<h6>' . $field->status_invoice . '<br /><small class="bg-success text-white">' . format_indo($field->invoice_date_update) . '</small></h6>' : '<h6>' . $field->status_invoice . '<br /><small class="bg-danger text-white">Tanggal Tidak Tersimpan</small></h6>';
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field->invoice_number;
			$row[] = $status_invoice;
			$row[] = rupiah($field->invoice_total_cost);
			$row[] = $field->payment_method_detail_name;
			$row[] = $field->buku_name;
			$row[] = $field->user_name;
			$row[] = $field->user_email;
			$row[] = $field->user_no_telp;
			$row[] = $field->voucher_name;
			$row[] = rupiah($field->voucher_potongan);
			$row[] = format_indo($field->invoice_date_create);
			$row[] = format_indo($field->invoice_date_expirate);

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_success_admin->count_all(),
			"recordsFiltered" => $this->invoice_success_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function export_invoice_all_success()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Invoice');
		$sheet->setCellValue('C1', 'Status Invoice');
		$sheet->setCellValue('D1', 'Harga');
		$sheet->setCellValue('E1', 'Payment');
		$sheet->setCellValue('F1', 'Buku');
		$sheet->setCellValue('G1', 'Name');
		$sheet->setCellValue('H1', 'Email');
		$sheet->setCellValue('I1', 'No Telp');
		$sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
		$sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
		$sheet->setCellValue('L1', 'Tanggal Invoice Terkonfirmasi');
		$sheet->setCellValue('M1', 'voucher');
		$sheet->setCellValue('N1', 'Potongan');

		$siswa = $this->management->get_invoice_success();
		$no = 1;
		$x = 2;
		foreach ($siswa as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->invoice_number);
			$sheet->setCellValue('C' . $x, $row->status_invoice);
			$sheet->setCellValue('D' . $x, $row->invoice_total_cost);
			$sheet->setCellValue('E' . $x, $row->payment_method_detail_name);
			$sheet->setCellValue('F' . $x, $row->buku_name);
			$sheet->setCellValue('G' . $x, $row->user_name);
			$sheet->setCellValue('H' . $x, $row->user_email);
			$sheet->setCellValue('I' . $x, $row->user_no_telp);
			$sheet->setCellValue('J' . $x, format_indo($row->invoice_date_create));
			$sheet->setCellValue('K' . $x, format_indo($row->invoice_date_expirate));
			$sheet->setCellValue('L' . $x, format_indo($row->invoice_date_update));
			$sheet->setCellValue('M' . $x, $row->voucher_name);
			$sheet->setCellValue('N' . $x, $row->voucher_potongan);
			$x++;
		}

		// Column sizing
		foreach (range('A', 'N') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'All-Data-invoice-success';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function invoice_expired()
	{
		//for passing data to view
		$data['content'] = [];
		$data['title_header'] = ['title' => 'Invoice All Expired'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/invoice/invoice_expired/css';
		$view['content'] = 'website/lembaga/management/invoice/invoice_expired/content';
		$view['js_additional'] = 'website/lembaga/management/invoice/invoice_expired/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function invoice_list_expired_all()
	{ //page 4
		$list = $this->invoice_expired_admin->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$url_manual_confirm = base_url() . 'admin/invoice/manual-confirm/4/';
		$url_delete = base_url() . 'admin/invoice/delete-invoice/4/';
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<div class="table-data-feature">
                        <a href="' . $url_manual_confirm . urlencode(base64_encode($field->id_invoice)) . '" class="item" data-toggle="tooltip" data-placement="top" title="Manual Confirm">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="' . $url_delete . urlencode(base64_encode($field->id_invoice)) . '" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="zmdi zmdi-delete"></i>
                        </a>
                    </div>';
			$row[] = $field->invoice_number;
			$row[] = $field->status_invoice;
			$row[] = rupiah($field->invoice_total_cost);
			$row[] = $field->payment_method_detail_name;
			$row[] = $field->buku_name;
			$row[] = $field->user_name;
			$row[] = $field->user_email;
			$row[] = $field->user_no_telp;
			$row[] = $field->voucher_name;
			$row[] = rupiah($field->voucher_potongan);
			$row[] = format_indo($field->invoice_date_create);
			$row[] = format_indo($field->invoice_date_expirate);

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_expired_admin->count_all(),
			"recordsFiltered" => $this->invoice_expired_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function export_invoice_all_expired()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Invoice');
		$sheet->setCellValue('C1', 'Status Invoice');
		$sheet->setCellValue('D1', 'Harga');
		$sheet->setCellValue('E1', 'Payment');
		$sheet->setCellValue('F1', 'Buku');
		$sheet->setCellValue('G1', 'Name');
		$sheet->setCellValue('H1', 'Email');
		$sheet->setCellValue('I1', 'No Telp');
		$sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
		$sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
		$sheet->setCellValue('L1', 'voucher');
		$sheet->setCellValue('M1', 'Potongan');

		$siswa = $this->management->get_invoice_expired();
		$no = 1;
		$x = 2;
		foreach ($siswa as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->invoice_number);
			$sheet->setCellValue('C' . $x, $row->status_invoice);
			$sheet->setCellValue('D' . $x, $row->invoice_total_cost);
			$sheet->setCellValue('E' . $x, $row->payment_method_detail_name);
			$sheet->setCellValue('F' . $x, $row->buku_name);
			$sheet->setCellValue('G' . $x, $row->user_name);
			$sheet->setCellValue('H' . $x, $row->user_email);
			$sheet->setCellValue('I' . $x, $row->user_no_telp);
			$sheet->setCellValue('J' . $x, format_indo($row->invoice_date_create));
			$sheet->setCellValue('K' . $x, format_indo($row->invoice_date_expirate));
			$sheet->setCellValue('L' . $x, $row->voucher_name);
			$sheet->setCellValue('M' . $x, $row->voucher_potongan);
			$x++;
		}

		// Column sizing
		foreach (range('A', 'M') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($spreadsheet);
		$filename = 'All-Data-invoice-expired';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function reject_confirm_invoice($id_invoice)
	{
		$invoice_id = base64_decode(urldecode($id_invoice));
		//for passing data to view
		$data['content']['id_invoice'] = $id_invoice;
		$data['content']['invoice'] = $this->management->get_invoice_by_id($invoice_id);
		$data['title_header'] = ['title' => 'Reject Bukti Pembayaran'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/invoice/invoice_confirm/css';
		$view['content'] = 'website/lembaga/management/invoice/invoice_confirm/reject';
		$view['js_additional'] = 'website/lembaga/management/invoice/invoice_confirm/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_reject_invoice()
	{
		$id_invoice = $this->input->post('id_invoice');
		$invoice_id = base64_decode(urldecode($id_invoice));
		$data['reject_desc'] = $this->input->post('reject_desc', TRUE);
		$now = date('Y-m-d H:i:s');
		$data['invoice_date_update'] = $now;
		$data['updated_datetime'] = $now;
		$data['status'] = 4;

		$tbl = $this->tbl_invoice;
		$update = $this->general->update_data($tbl, $data, $invoice_id);

		$urly = 'admin/invoice-confirm';
		$urlx = 'admin/invoice-confirm';
		$this->update_end($update, $urly, $urlx);
	}

	public function manual_confirm_invoice($page, $id_invoice)
	{
		$data = [];
		$datas = [];
		$list_pembelian = [];
		$invoice_id = base64_decode(urldecode($id_invoice));

		$data_invoice = $this->management->get_invoice_by_id($invoice_id);

		$status_data = $data_invoice->status;
		$reject_data = $data_invoice->reject_desc;

		$now = date('Y-m-d H:i:s');
		$data = array(
			'status' => 2, //Invoice Success
			'reject_desc' => NULL,
			'updated_datetime' => $now,
			'invoice_date_update' => $now
		);

		$datas['invoice'] = $data_invoice;

		$tbl = $this->tbl_invoice;
		$update = $this->general->update_data($tbl, $data, $invoice_id);

		if ($update) {
			$this->email->clear(TRUE);

			$from = $this->config->item('smtp_user');
			$subject = 'Invoice #' . $data_invoice->invoice_number . ' ' . format_indo($now) . ' ' . (Lunas);
			$message = $this->load->view('website/lembaga/management/invoice/confirm_success/content', $datas, TRUE);

			$this->email->set_newline("\r\n");
			$this->email->from($from, '[NO-REPLY] Zambert');
			$this->email->to($data_invoice->user_email);
			$this->email->subject($subject);
			$this->email->message($message);

			if ($this->email->send()) {
				$this->session->set_flashdata('success', 'Email konfirmasi pembayaran invoice berhasil dikirim ke ' . $data_invoice->user_email);

				$message = '';

				$list_pembelian = array(
					'invoice_id' => $invoice_id,
					'invoice_number' => $data_invoice->invoice_number,
					'user_id' => $data_invoice->user_id,
					'user_name' => $data_invoice->user_name,
					'user_email' => $data_invoice->user_email,
					'user_telp' => $data_invoice->user_no_telp,
					'buku_id' => $data_invoice->buku_id,
					'detail_buku_id' => $data_invoice->detail_buku_id,
					'created_datetime' => $now,
				);

				$tbl_user_pembelian_buku = $this->tbl_user_pembelian_buku;
				$this->general->input_data($tbl_user_pembelian_buku, $list_pembelian);

				$this->manual_confirm_page($page);
			} else { //jika email tidak terkirim invoice dibatalkan / disable
				$rollback = [];
				$tbl_invoice = $this->tbl_invoice;
				$rollback = array(
					'status' => $status_data,
					'reject_desc' => $reject_data,
					'updated_datetime' => $now,
					'invoice_date_update' => $now
				);
				$this->general->update_data($tbl_invoice, $rollback, $invoice_id);
				$this->session->set_flashdata('error', 'Perubahan Invoice dibatalkan. Email Invoice tidak terkirim, Mohon ulangi kembali.');
				$this->manual_confirm_page($page);
			}
		} else {
			$this->session->set_flashdata('error', 'Perubahan Invoice dibatalkan. Data tidak terupdate, Mohon ulangi kembali.');
			$this->manual_confirm_page($page);
		}
	}

	public function manual_confirm_page($page)
	{
		if ($page == 1) { //1 Invoice All 2 Confirm 3 Success 4 Expired
			redirect('admin/invoice');
		} elseif ($page == 2) {
			redirect('admin/invoice-confirm');
		} elseif ($page == 3) {
			redirect('admin/invoice-success');
		} elseif ($page == 4) {
			redirect('admin/invoice-expired');
		}
	}

	public function disable_invoice($page, $id_invoice)
	{
		$invoice_id = base64_decode(urldecode($id_invoice));

		$tbl = $this->tbl_invoice;
		$delete = $this->general->delete_data($tbl, $invoice_id);

		if ($page == 1) { //1 Invoice All 2 Confirm 3 Success 4 Expired
			$urly = 'admin/invoice';
			$urlx = 'admin/invoice';
		} elseif ($page == 2) {
			$urly = 'admin/invoice-confirm';
			$urlx = 'admin/invoice-confirm';
		} elseif ($page == 3) {
			$urly = 'admin/invoice-success';
			$urlx = 'admin/invoice-success';
		} elseif ($page == 4) {
			$urly = 'admin/invoice-expired';
			$urlx = 'admin/invoice-expired';
		}

		$this->delete_end($delete, $urly, $urlx);
	}

	public function voucher()
	{
		$data['content']['voucher'] = $this->management->get_voucher();
		$data['title_header'] = ['title' => 'Kode Voucher'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/voucher/css';
		$view['content'] = 'website/lembaga/management/voucher/content';
		$view['js_additional'] = 'website/lembaga/management/voucher/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_voucher()
	{
		//for passing data to view
		$data['content'] = [];
		$data['title_header'] = ['title' => 'Tambah Voucher'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/voucher/css';
		$view['content'] = 'website/lembaga/management/voucher/add';
		$view['js_additional'] = 'website/lembaga/management/voucher/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_voucher()
	{
		$data['name'] = ucwords($this->input->post('voucher', TRUE));
		$data['potongan'] = ucwords($this->input->post('potongan', TRUE));
		$data['created_datetime'] = date('Y-m-d H:i:s');
		$tbl = $this->tbl_voucher;
		$input = $this->general->input_data($tbl, $data);

		$urly = 'admin/voucher';
		$urlx = 'admin/add-voucher';
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_voucher($id_voucher)
	{
		//for passing data to view
		$data['content']['voucher'] = $this->management->get_voucher_by_id($id_voucher);
		$data['title_header'] = ['title' => 'Edit Voucher'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/voucher/css';
		$view['content'] = 'website/lembaga/management/voucher/edit';
		$view['js_additional'] = 'website/lembaga/management/voucher/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_voucher()
	{
		$id = $this->input->post('id', TRUE);
		$data['name'] = strtoupper($this->input->post('voucher', TRUE));
		$data['potongan'] = $this->input->post('potongan', TRUE);
		$data['updated_datetime'] = date('Y-m-d H:i:s');
		$tbl = $this->tbl_voucher;
		$update = $this->general->update_data($tbl, $data, $id);

		$urly = 'admin/voucher';
		$urlx = 'admin/edit-voucher/' . $id;
		$this->update_end($update, $urly, $urlx);
	}

	public function disable_voucher($id)
	{
		$tbl = $this->tbl_voucher;
		$delete = $this->general->delete_data($tbl, $id);

		$urly = 'admin/voucher';
		$urlx = 'admin/voucher';
		$this->delete_end($delete, $urly, $urlx);
	}

	public function active_voucher($id)
	{
		$tbl = $this->tbl_voucher;
		$active = $this->general->active_data($tbl, $id);

		$urly = 'admin/voucher';
		$urlx = 'admin/voucher';
		$this->active_end($active, $urly, $urlx);
	}

	public function event_all()
	{
		//for passing data to view
		$data['content']['event'] = $this->management->get_all_event();
		$data['title_header'] = ['title' => 'Event Management'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/event/css';
		$view['content'] = 'website/lembaga/management/event/content';
		$view['js_additional'] = 'website/lembaga/management/event/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function event_add()
	{
		//for passing data to view
		$lembaga_id = $this->session->userdata('lembaga_id');
		$lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
		$data['content']['lembaga_id'] = $lembaga_id_crypt;
		$data['content']['max_kuota_split'] = $this->max_kuota_split;
		$data['title_header'] = ['title' => 'Tambah Event'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/event/css';
		$view['content'] = 'website/lembaga/management/event/add';
		$view['js_additional'] = 'website/lembaga/management/event/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_add_event()
	{
		## EVENT INPUT ##
		$event_name = strtoupper($this->input->post('name', TRUE));
		$waktu_mulai = $this->input->post('start_date', TRUE);
		$waktu_selesai = $this->input->post('end_date', TRUE);
		$prefix_url = strtolower($this->input->post('prefix_url', TRUE));
		$kuota = (int) $this->input->post('kuota', TRUE);
		$lembaga_id_raw = $this->input->post('lembaga_id'); //No Decode
		$lembaga_id = base64_decode(urldecode($lembaga_id_raw));
		$mode_kuota_peserta = $this->input->post('mode_kuota'); //1 Tak Terbatas | 2 Terbatas
		$mode_kelompok_peserta = $this->input->post('mode_kelompok'); //1 Otomatis | 2 Manual
		$event_data = array();

		$event_data['name'] = $event_name;
		$event_data['prefix_url'] = $prefix_url;
		$event_data['start_date'] = $waktu_mulai ? date("Y-m-d H:i", strtotime($waktu_mulai)) : NULL;
		$event_data['end_date'] = $waktu_selesai ? date("Y-m-d H:i", strtotime($waktu_selesai)) : NULL;
		$event_data['kuota'] = $kuota;
		$event_data['mode_kuota_peserta'] = $mode_kuota_peserta;
		$event_data['mode_kelompok_peserta'] = $mode_kelompok_peserta;
		$event_tbl = $this->tbl_event;
		$event_input = $this->general->input_data_id($event_tbl, $event_data);

		if ($event_input) {
			## EVENT IMAGE ##
			$event_banner_data = array();
			$countfiles = count($_FILES['banner_image']['name']);

			for ($i = 0; $i < $countfiles; $i++) {
				if (!empty($_FILES['banner_image']['name'][$i])) {
					$_FILES['file']['name'] = $_FILES['banner_image']['name'][$i];
					$_FILES['file']['type'] = $_FILES['banner_image']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['banner_image']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['banner_image']['error'][$i];
					$_FILES['file']['size'] = $_FILES['banner_image']['size'][$i];

					$config['upload_path'] = FCPATH . 'storage/website/lembaga/grandsbmptn/event/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['encrypt_name'] = TRUE;

					$_upload_path = $config['upload_path'];

					if (!file_exists($_upload_path)) {
						mkdir($_upload_path, 0777);
					}

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

						$event_banner_data['event_id'] = $event_input;
						$event_banner_data['image'] = $filename;
						$event_banner_tbl = $this->tbl_event_banner;
						$this->general->input_data($event_banner_tbl, $event_banner_data);
					}
				}
			}

			## EVENT GROUP PESERTA ##
			$multi_kelompok_peserta = $this->input->post('multi_kelompok_peserta');
			$multi_kuota_kelompok = $this->input->post('multi_kuota_kelompok');
			$event_group_data = array();
			$event_group_tbl = $this->tbl_event_group_peserta;

			## GROUP PESERTA MASTER ADD ##
			if ($mode_kuota_peserta == 1) { //Tak Terbatas
				$group_save = $this->group_peserta_add($lembaga_id, $prefix_url);

				$event_group_data['event_id'] = $event_input;
				$event_group_data['group_peserta_id'] = $group_save;
				$event_group_data['max_kuota'] = $kuota;

				$this->general->input_data($event_group_tbl, $event_group_data);
			} elseif ($mode_kuota_peserta == 2) { //Terbatas
				if ($mode_kelompok_peserta == 1) { //Otomatis
					if ($kuota <= $this->max_kuota_split) {
						$group_save = $this->group_peserta_add($lembaga_id, $prefix_url);

						$event_group_data['event_id'] = $event_input;
						$event_group_data['group_peserta_id'] = $group_save;
						$event_group_data['max_kuota'] = $kuota;

						$this->general->input_data($event_group_tbl, $event_group_data);
					} else {
						$jumlah_group_daftar = ceil($kuota / $this->max_kuota_split);
						$jumlah_group_daftar_last = $jumlah_group_daftar - 1;

						$count_group_daftar = 0;
						for ($z = 0; $z < $jumlah_group_daftar; $z++) {
							$number_group = (int) $z + 1;
							$names_group = $prefix_url . ' - ' . $number_group;
							$group_save = $this->group_peserta_add($lembaga_id, $names_group);

							$event_group_data['event_id'] = $event_input;
							$event_group_data['group_peserta_id'] = $group_save;

							if ($jumlah_group_daftar_last == $z) {
								$event_group_data['max_kuota'] = abs($kuota - $count_group_daftar);
							} else {
								$event_group_data['max_kuota'] = $this->max_kuota_split;
							}

							$this->general->input_data($event_group_tbl, $event_group_data);

							$count_group_daftar += $this->max_kuota_split;
						}
					}
				} elseif ($mode_kelompok_peserta == 2) { //Manual
					foreach ($multi_kelompok_peserta as $key => $value) {
						$group_save = $this->group_peserta_add($lembaga_id, $value);

						$event_group_data['event_id'] = $event_input;
						$event_group_data['group_peserta_id'] = $group_save;
						$event_group_data['max_kuota'] = $multi_kuota_kelompok[$key];

						$this->general->input_data($event_group_tbl, $event_group_data);
					}
				}
			}
		}

		$urly = 'admin/event';
		$urlx = 'admin/event-add';
		$this->input_end($event_input, $urly, $urlx);
	}

	public function group_peserta_add($lembaga_id, $prefix_url)
	{
		$data_peserta_single['lembaga_id'] = $lembaga_id;
		$data_peserta_single['name'] = $prefix_url;
		$data_peserta_single['created_datetime'] = date('Y-m-d H:i:s');

		$group_peserta_tbl = $this->tbl_group_peserta;
		$save = $this->general->input_data_id($group_peserta_tbl, $data_peserta_single);
		return $save;
	}

	public function event_check_prefix()
	{
		$data = [];
		$prefix = strtolower($this->input->post('value', true));

		$get_data = $this->management->check_prefix_available($prefix);

		if ($get_data) {
			$data = array(
				'status' => 0,
				'message' => 'Prefix URL Sudah Digunakan! Silahkan ganti Prefix URL yang lain'
			);
		} else {
			$data = array(
				'status' => 1,
				'message' => 'Prefix URL Tersedia!'
			);
		}

		header("Content-Type: application/json");

		echo json_encode($data);
	}

	public function event_delete($id_event)
	{
		$event_id = base64_decode(urldecode($id_event));

		$event_group_peserta = $this->management->get_group_peserta_by_id($event_id);

		$this->event_delete_validation($event_group_peserta);

		## EVENT GROUP PESERTA ##
		if ($event_group_peserta) {
			## GROUP PESERTA ##
			$id_group_peserta = array();
			foreach ($event_group_peserta as $valEGP) {
				$id_group_peserta[] = $valEGP->group_peserta_id;
			}
			$group_peserta_tbl = $this->tbl_group_peserta;
			$group_peserta_clm = 'id';
			$this->general->delete_hard_data($group_peserta_tbl, $group_peserta_clm, $id_group_peserta);

			## GROUP PESERTA EVENT ##
			$event_group_peserta_tbl = $this->tbl_event_group_peserta;
			$event_group_peserta_clm = 'event_id';
			$this->general->delete_hard_data($event_group_peserta_tbl, $event_group_peserta_clm, $event_id);
		}

		## EVENT BANNER ##
		$event_banner = $this->management->get_event_banner_by_event($event_id);

		if ($event_banner) {
			foreach ($event_banner as $valEB) {
				$path = FCPATH . 'storage/website/lembaga/grandsbmptn/event/' . $valEB->image;
				chmod($path, 0777);
				unlink($path);
			}

			$event_banner_tbl = $this->tbl_event_banner;
			$event_banner_clm = 'event_id';
			$event_delete = $this->general->delete_hard_data($event_banner_tbl, $event_banner_clm, $event_id);
		}

		## EVENT DELETE ##
		$event_tbl = $this->tbl_event;
		$event_clm = 'id';
		$event_delete = $this->general->delete_hard_data($event_tbl, $event_clm, $event_id);

		$urly = 'admin/event';
		$urlx = 'admin/event';
		$this->delete_end($event_delete, $urly, $urlx);
	}

	public function event_delete_validation($event_group_peserta)
	{
		## VALIDASI APAKAH SUDAH DIISI PESERTA ATAU BELUM ##
		if ($event_group_peserta) {
			$count_user = 0;
			foreach ($event_group_peserta as $valEGP) {
				$user_group_peserta = $this->management->count_user_by_group_peserta($valEGP->group_peserta_id);
				$count_user += (int) $user_group_peserta;
			}

			if ($count_user > 0) {
				$this->session->set_flashdata('error', 'Event tidak bisa dihapus! Sudah ada peserta');
				redirect('admin/event');
			} else {
				return;
			}
		} else {
			return;
		}
	}

	public function event_edit($id_event)
	{
		$event_id = base64_decode(urldecode($id_event));

		$event = $this->management->get_detail_event_by_id($event_id);
		$banner = $this->management->get_detail_event_banner_by_event_id($event_id);
		$group_peserta = $this->management->get_detail_event_group_by_event_id($event_id);

		if ($event->kuota != 0) {
			$count_group = 0;
			foreach ($group_peserta as $vGP) {
				$count_group += (int) $vGP->max_kuota;
			}
			$kuota_sisa = (int) $event->kuota - (int) $count_group;
		} else {
			$kuota_sisa = 0;
		}

		//for passing data to view
		$lembaga_id = $this->session->userdata('lembaga_id');
		$lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
		$data['content']['lembaga_id'] = $lembaga_id_crypt;
		$data['content']['event_id'] = $id_event;
		$data['content']['max_kuota_split'] = $this->max_kuota_split;
		$data['content']['event'] = $event;
		$data['content']['banner'] = $banner;
		$data['content']['group_peserta'] = $group_peserta;
		$data['content']['kuota_sisa'] = $kuota_sisa;
		$data['title_header'] = ['title' => 'Edit Event'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/event/css';
		$view['content'] = 'website/lembaga/management/event/edit';
		$view['js_additional'] = 'website/lembaga/management/event/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_event()
	{
		## EVENT INPUT ##
		$event_id_raw = $this->input->post('event_id'); //No Decode
		$event_id =  base64_decode(urldecode($event_id_raw));
		$event_old = $this->management->get_detail_event_by_id($event_id);
		$event_name = strtoupper($this->input->post('name', TRUE));
		$waktu_mulai = $this->input->post('start_date', TRUE);
		$waktu_selesai = $this->input->post('end_date', TRUE);
		$prefix_url = strtolower($this->input->post('prefix_url', TRUE));
		$kuota = (int) $this->input->post('kuota', TRUE);
		$lembaga_id_raw = $this->input->post('lembaga_id'); //No Decode
		$lembaga_id = base64_decode(urldecode($lembaga_id_raw));
		$mode_kuota_peserta = $this->input->post('mode_kuota'); //1 Tak Terbatas | 2 Terbatas
		$mode_kelompok_peserta = $this->input->post('mode_kelompok'); //1 Otomatis | 2 Manual
		$event_data = array();

		$event_data['name'] = $event_name;
		$event_data['prefix_url'] = $prefix_url;
		$event_data['start_date'] = $waktu_mulai ? date("Y-m-d H:i", strtotime($waktu_mulai)) : NULL;
		$event_data['end_date'] = $waktu_selesai ? date("Y-m-d H:i", strtotime($waktu_selesai)) : NULL;
		$event_data['kuota'] = $kuota;
		$event_data['mode_kuota_peserta'] = $mode_kuota_peserta;
		$event_data['mode_kelompok_peserta'] = $mode_kelompok_peserta;
		$event_tbl = $this->tbl_event;
		$event_edit = $this->general->update_data($event_tbl, $event_data, $event_id);

		if ($event_edit) {
			## EVENT IMAGE ##
			// DELETE BANNER LAMA
			$event_banner_old = $this->management->get_event_banner_by_event($event_id);
			if ($event_banner_old && count($event_banner_old) > 0) {
				for ($v = 0; $v < count($event_banner_old); $v++) {
					$del_html_name_banner = 'event-banner-image-' . $v;
					$del_banner_input = $this->input->post($del_html_name_banner, TRUE);
					$explode_input_banner_del = explode("-", $del_banner_input);
					$id_banner = $explode_input_banner_del[0];
					$action_banner = $explode_input_banner_del[1];

					if ($action_banner == 1) { //1 Delete | 0 Not Delete
						$banner_detail =  $this->management->get_event_banner_by_id($id_banner);
						$path = FCPATH . 'storage/website/lembaga/grandsbmptn/event/' . $banner_detail->image;
						chmod($path, 0777);
						unlink($path);

						$event_banner_tbl = $this->tbl_event_banner;
						$event_banner_clm = 'id';
						$this->general->delete_hard_data($event_banner_tbl, $event_banner_clm, $banner_detail->id);
					}
				}
			}

			$event_banner_data = array();
			$countfiles = count($_FILES['banner_image']['name']);

			if ($countfiles > 0) {
				for ($i = 0; $i < $countfiles; $i++) {
					if (!empty($_FILES['banner_image']['name'][$i])) {
						$_FILES['file']['name'] = $_FILES['banner_image']['name'][$i];
						$_FILES['file']['type'] = $_FILES['banner_image']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['banner_image']['tmp_name'][$i];
						$_FILES['file']['error'] = $_FILES['banner_image']['error'][$i];
						$_FILES['file']['size'] = $_FILES['banner_image']['size'][$i];

						$config['upload_path'] = FCPATH . 'storage/website/lembaga/grandsbmptn/event/';
						$config['allowed_types'] = 'jpg|jpeg|png';
						$config['encrypt_name'] = TRUE;

						$_upload_path = $config['upload_path'];

						if (!file_exists($_upload_path)) {
							mkdir($_upload_path, 0777);
						}

						$this->load->library('upload', $config);

						if ($this->upload->do_upload('file')) {
							$uploadData = $this->upload->data();
							$filename = $uploadData['file_name'];

							$event_banner_data['event_id'] = $event_id;
							$event_banner_data['image'] = $filename;
							$event_banner_tbl = $this->tbl_event_banner;
							$this->general->input_data($event_banner_tbl, $event_banner_data);
						}
					}
				}
			}

			## EVENT GROUP PESERTA ##
			$multi_kelompok_peserta_old_id = $this->input->post('multi_kelompok_peserta_old_id');
			$multi_kelompok_master_old_id = $this->input->post('multi_kelompok_master_old_id');
			$multi_kelompok_peserta = $this->input->post('multi_kelompok_peserta');
			$multi_kelompok_peserta_old = $this->input->post('multi_kelompok_peserta_old');
			$multi_kuota_kelompok = $this->input->post('multi_kuota_kelompok');
			$old_multi_kuota_kelompok = $this->input->post('old_multi_kuota_kelompok');
			$event_group_data = array();
			$event_group_tbl = $this->tbl_event_group_peserta;

			## GROUP PESERTA MASTER ADD ##
			//$mode_kuota_peserta == 1 Tak Terbatas | tidak usah diupdate
			if ($mode_kuota_peserta == 2) { //Terbatas
				if ($mode_kelompok_peserta == 1) { //Otomatis
					if ($event_old->kuota != $kuota) {
						$sisa_kuota = abs((int) $event_old->kuota - (int) $kuota);
						$count_group_peserta = $this->management->get_total_event_group_by_event_id($event_id);

						if ($sisa_kuota != 0 && $sisa_kuota <= $this->max_kuota_split) {
							$number_group = (int) $count_group_peserta + 1;
							$names_group = $prefix_url . ' - ' . $number_group;
							$group_save = $this->group_peserta_add($lembaga_id, $names_group);

							$event_group_data['event_id'] = $event_id;
							$event_group_data['group_peserta_id'] = $group_save;
							$event_group_data['max_kuota'] = $sisa_kuota;

							$this->general->input_data($event_group_tbl, $event_group_data);
						} elseif ($sisa_kuota != 0 && $sisa_kuota >= $this->max_kuota_split) {
							$jumlah_group_daftar = ceil($sisa_kuota / $this->max_kuota_split);
							$jumlah_group_daftar_last = $jumlah_group_daftar - 1;

							$count_group_daftar = 0;
							for ($z = 0; $z < $jumlah_group_daftar; $z++) {
								$number_group = (int) $count_group_peserta + 1;
								$names_group = $prefix_url . ' - ' . $number_group;
								$group_save = $this->group_peserta_add($lembaga_id, $names_group);

								$event_group_data['event_id'] = $event_id;
								$event_group_data['group_peserta_id'] = $group_save;

								if ($jumlah_group_daftar_last == $z) {
									$event_group_data['max_kuota'] = abs($sisa_kuota - $count_group_daftar);
								} else {
									$event_group_data['max_kuota'] = $this->max_kuota_split;
								}

								$this->general->input_data($event_group_tbl, $event_group_data);

								$count_group_daftar += $this->max_kuota_split;
								(int) $count_group_peserta++;
							}
						}
					}
				} elseif ($mode_kelompok_peserta == 2) { //Manual
					## OLD INPUT ##
					if ($multi_kelompok_peserta_old_id) {
						foreach ($multi_kelompok_peserta_old_id as $key => $value) {
							## EVENT GROUP ##
							$event_group_data['event_id'] = $event_id;
							$event_group_data['group_peserta_id'] = $multi_kelompok_master_old_id[$key];
							$event_group_data['max_kuota'] = $old_multi_kuota_kelompok[$key];

							$this->general->update_data($event_group_tbl, $event_group_data, $value);

							## MASTER GROUP ##
							$data_peserta_single['lembaga_id'] = $lembaga_id;
							$data_peserta_single['name'] = $multi_kelompok_peserta_old[$key];
							$data_peserta_single['updated_datetime'] = date('Y-m-d H:i:s');

							$group_peserta_tbl = $this->tbl_group_peserta;
							$this->general->update_data($group_peserta_tbl, $data_peserta_single, $multi_kelompok_master_old_id[$key]);
						}
					}

					## NEW INPUT ##
					if ($multi_kelompok_peserta) {
						foreach ($multi_kelompok_peserta as $key => $value) {
							$group_save = $this->group_peserta_add($lembaga_id, $value);

							$event_group_data['event_id'] = $event_id;
							$event_group_data['group_peserta_id'] = $group_save;
							$event_group_data['max_kuota'] = $multi_kuota_kelompok[$key];

							$this->general->input_data($event_group_tbl, $event_group_data);
						}
					}
				}
			}
		}

		$urly = 'admin/event';
		$urlx = 'admin/event-edit/' . $event_id_raw;
		$this->update_end($event_edit, $urly, $urlx);
	}

	public function event_detail($id_event)
	{
		$event_id = base64_decode(urldecode($id_event));

		$event = $this->management->get_detail_event_by_id($event_id);
		$banner = $this->management->get_detail_event_banner_by_event_id($event_id);
		$group_peserta = $this->management->get_detail_event_group_by_event_id($event_id);

		if ($event->kuota != 0) {
			$count_group = 0;
			foreach ($group_peserta as $vGP) {
				$count_group += (int) $vGP->max_kuota;
			}
			$kuota_sisa = (int) $event->kuota - (int) $count_group;
		} else {
			$kuota_sisa = 0;
		}

		//for passing data to view
		$data['content']['max_kuota_split'] = $this->max_kuota_split;
		$data['content']['event'] = $event;
		$data['content']['banner'] = $banner;
		$data['content']['group_peserta'] = $group_peserta;
		$data['content']['kuota_sisa'] = $kuota_sisa;
		$data['title_header'] = ['title' => 'Detail Event'];

		//for load view
		$view['css_additional'] = 'website/lembaga/management/event/css';
		$view['content'] = 'website/lembaga/management/event/detail';
		$view['js_additional'] = 'website/lembaga/management/event/js';

		//get function view website
		$this->_generate_view($view, $data);
	}
}
