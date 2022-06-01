<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class User extends CI_Controller
{
	/**
	 * Author : Candra Aji Pamungkas
	 * Create : 30-03-2021
	 * Change :
	 *      - {date} | {description}
	 */

	private $tbl_group_peserta = 'group_peserta';
	private $tbl_user = 'user';
	private $tbl_peserta = 'peserta';
	private $length_pass = 6;

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('has_login')) {
			redirect('admin/login');
		}
		$this->load->library('encryption');
		$this->load->model('General', 'general');
		$this->load->model('User_model', 'user');
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

	private function generate_string($input, $strength = 16)
	{
		$input_length = strlen($input);
		$random_string = '';
		for ($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}

		return $random_string;
	}

	private function secure_random_string($length)
	{
		$random_string = '';
		for ($i = 0; $i < $length; $i++) {
			$number = random_int(0, 36);
			$character = base_convert($number, 10, 36);
			$random_string .= $character;
		}

		return $random_string;
	}

	private function generate_username()
	{
		$permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$generate_string = $this->generate_string($permitted_chars, 5);
		$get_time = strtotime("now");
		$username = $generate_string . '@' . $get_time;

		$username_check = $this->user->get_checking_username($username);

		if ($username_check) {
			$this->generate_username();
		} else {
			return $username;
		}
	}

	/*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

	public function user_lembaga()
	{
		//for passing data to view
		$data['content']['user_lembaga'] = $this->user->get_user_lembaga();
		$data['title_header'] = ['title' => 'User Lembaga'];

		//for load view
		$view['css_additional'] = 'website/lembaga/user/admin_lembaga/css';
		$view['content'] = 'website/lembaga/user/admin_lembaga/content';
		$view['js_additional'] = 'website/lembaga/user/admin_lembaga/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_user_lembaga()
	{
		//for passing data to view
		$lembaga_id = $this->session->userdata('lembaga_id');
		$role_user_id = 3;
		$lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
		$role_user_id_crypt = urlencode(base64_encode($role_user_id));
		$cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

		$data['content']['role_user_id'] = $role_user_id_crypt; //Role user id untuk user lembaga
		$data['content']['lembaga_id'] = $lembaga_id_crypt; //Lembaga id untuk user lembaga
		$data['title_header'] = ['title' => 'Add User Lembaga'];

		if ($cek_verify_lembaga->is_verify == 1) {
			//for load view
			$view['css_additional'] = 'website/lembaga/user/admin_lembaga/css';
			$view['content'] = 'website/lembaga/user/admin_lembaga/add';
			$view['js_additional'] = 'website/lembaga/user/admin_lembaga/js';

			//get function view website
			$this->_generate_view($view, $data);
		} else {
			$this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah admin lembaga!');
			redirect('admin/user-lembaga');
		}
	}

	public function submit_add_user_lembaga()
	{
		$lembaga_id = $this->input->post('lembaga_id'); //No Decode
		$role_user_id = $this->input->post('role_user_id'); //No Decode
		$email = $this->input->post('email', TRUE);

		$cek_email = $this->user->get_user_by_email($email); //Cek email

		if ($cek_email) { //Jika email sudah dipakai dan masih aktif
			$this->session->set_flashdata('warning', 'Email sudah terdaftar!');
			redirect('admin/add-user-lembaga');
		} else {
			//lembaga_user
			$data_user_lembaga['lembaga_id'] = base64_decode(urldecode($lembaga_id));
			$data_user_lembaga['name'] = ucwords($this->input->post('name', TRUE));
			$data_user_lembaga['email'] = $email;
			$data_user_lembaga['created_datetime'] = date('Y-m-d H:i:s');
			$data_user_lembaga['file'] = NULL;

			//user access
			$data_user['role_user_id'] = base64_decode(urldecode($role_user_id));
			$data_user['username'] = $email;
			$data_user['password'] = $this->encryption->encrypt($this->input->post('password', TRUE));
			$data_user['created_datetime'] = date('Y-m-d H:i:s');

			/*  $allowed_type 	= [
                "jpeg", "jpg", "png"
            ];
            $config['upload_path']      = FCPATH.'storage/website/lembaga/grandsbmptn/user_admin/';
            $config['allowed_types']    = 'jpeg|jpg|png';
            $config['encrypt_name']     = TRUE;
            $_upload_path = $config['upload_path'];

            if(!file_exists($_upload_path)){
                mkdir($_upload_path,0777);
            }
            
            $this->load->library('upload', $config);

            if(!empty($_FILES['file_photo']['name'])){
                if (!$this->upload->do_upload('file_photo')){
                    $error = $this->upload->display_errors();
                    show_error($error, 500, 'File Audio Soal Error');
                    exit();
                }else{
                    $data_user_lembaga['file'] = $this->upload->data('file_name');
                }
            } */

			$input = $this->user->input_lembaga_user($data_user_lembaga, $data_user);

			$urly = 'admin/user-lembaga';
			$urlx = 'admin/add-user-lembaga';
			$this->input_end($input, $urly, $urlx);
		}
	}

	public function edit_user_lembaga($id_user_lembaga, $id_user)
	{
		$lembaga_user_id = base64_decode(urldecode($id_user_lembaga));
		$user_id = base64_decode(urldecode($id_user));

		//for passing data to view
		$get_data = $this->user->get_user_lembaga_by_id($lembaga_user_id, $user_id);
		$data['content']['user_lembaga'] = $get_data;
		$data['content']['password'] = $this->encryption->decrypt($get_data->password);
		$data['title_header'] = ['title' => 'Edit User Lembaga'];

		//for load view
		$view['css_additional'] = 'website/lembaga/user/admin_lembaga/css';
		$view['content'] = 'website/lembaga/user/admin_lembaga/edit';
		$view['js_additional'] = 'website/lembaga/user/admin_lembaga/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_lembaga()
	{
		$lembaga_id = $this->input->post('lembaga_id'); //No Decode
		$role_user_id = $this->input->post('role_user_id'); //No Decode
		$email = $this->input->post('email', TRUE);
		$id_user = $this->input->post('user_id');
		$id_user_lembaga = $this->input->post('lembaga_user_id');

		//lembaga_user
		$data_user_lembaga['lembaga_id'] = $lembaga_id;
		$data_user_lembaga['name'] = ucwords($this->input->post('name', TRUE));
		$data_user_lembaga['email'] = $email;
		$data_user_lembaga['updated_datetime'] = date('Y-m-d H:i:s');
		$data_user_lembaga['user_id'] = $id_user;
		$data_user_lembaga['file'] = NULL;

		//user access
		$data_user['role_user_id'] = $role_user_id;
		$data_user['username'] = $email;
		$data_user['password'] = $this->encryption->encrypt($this->input->post('password', TRUE));
		$data_user['updated_datetime'] = date('Y-m-d H:i:s');

		$update = $this->user->update_lembaga_user($id_user_lembaga, $data_user_lembaga, $id_user, $data_user);

		$urly = 'admin/user-lembaga';
		$urlx = 'admin/add-user-lembaga';
		$this->update_end($update, $urly, $urlx);
	}

	public function disable_user_lembaga($id_user_lembaga, $id_user)
	{
		$data = [];
		$lembaga_user_id = base64_decode(urldecode($id_user_lembaga));
		$user_id = base64_decode(urldecode($id_user));

		$data = array(
			'is_enable' => 0,
			'updated_datetime' => date('Y-m-d H:i:s')
		);

		$disable = $this->user->disable_lembaga_user($lembaga_user_id, $user_id, $data);

		$urly = 'admin/user-lembaga';
		$urlx = 'admin/user-lembaga';
		$this->delete_end($disable, $urly, $urlx);
	}

	public function group_participants()
	{
		$lembaga_id = $this->session->userdata('lembaga_id');
		//for passing data to view
		$data['content']['group_peserta'] = $this->user->get_group_peserta_enable($lembaga_id);
		$data['title_header'] = ['title' => 'Group Peserta'];

		//for load view
		$view['css_additional'] = 'website/lembaga/user/group_peserta/css';
		$view['content'] = 'website/lembaga/user/group_peserta/content';
		$view['js_additional'] = 'website/lembaga/user/group_peserta/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_group_participants()
	{
		//for passing data to view
		$lembaga_id = $this->session->userdata('lembaga_id');
		$lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
		$cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

		$data['content']['lembaga_id'] = $lembaga_id_crypt; //Lembaga id untuk user lembaga
		$data['title_header'] = ['title' => 'Add Group Peserta'];

		if ($cek_verify_lembaga->is_verify == 1) {
			//for load view
			$view['css_additional'] = 'website/lembaga/user/group_peserta/css';
			$view['content'] = 'website/lembaga/user/group_peserta/add';
			$view['js_additional'] = 'website/lembaga/user/group_peserta/js';

			//get function view website
			$this->_generate_view($view, $data);
		} else {
			$this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah group peserta!');
			redirect('admin/group-participants');
		}
	}

	public function submit_add_group_peserta()
	{
		$lembaga_id = $this->input->post('lembaga_id'); //No Decode

		$data['lembaga_id'] = base64_decode(urldecode($lembaga_id));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$data['created_datetime'] = date('Y-m-d H:i:s');

		$cek_group = $this->user->checking_group_peserta(base64_decode(urldecode($lembaga_id)), ucwords($this->input->post('name', TRUE)));
		if (!empty($cek_group)) { //Jika ada gagal
			$this->session->set_flashdata('error', 'Data gagal disimpan! Nama Group Sudah Dipakai');
			redirect('admin/add-group-participants');
		} else { //Jika masih belum ada simpan
			$tbl = $this->tbl_group_peserta;
			$input = $this->general->input_data($tbl, $data);	
		}

		$urly = 'admin/group-participants';
		$urlx = 'admin/add-group-participants';
		$this->input_end($input, $urly, $urlx);
	}

	public function edit_group_participants($id_group_participants)
	{
		$participants_group_id = base64_decode(urldecode($id_group_participants));

		//for passing data to view
		$data['content']['group_peserta'] = $this->user->get_group_peserta_by_id($participants_group_id);
		$data['title_header'] = ['title' => 'Edit Group Peserta'];

		//for load view
		$view['css_additional'] = 'website/lembaga/user/group_peserta/css';
		$view['content'] = 'website/lembaga/user/group_peserta/edit';
		$view['js_additional'] = 'website/lembaga/user/group_peserta/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function submit_edit_group_peserta()
	{
		$id_group_participants = $this->input->post('id'); //No Decode
		$participants_group_id = base64_decode(urldecode($id_group_participants));
		$lembaga_id = $this->input->post('lembaga_id'); //No Decode

		$data['lembaga_id'] = base64_decode(urldecode($lembaga_id));
		$data['name'] = ucwords($this->input->post('name', TRUE));
		$data['updated_datetime'] = date('Y-m-d H:i:s');

		$cek_group = $this->user->checking_group_peserta(base64_decode(urldecode($lembaga_id)), ucwords($this->input->post('name', TRUE)));
		if (!empty($cek_group)) { //Jika ada gagal
			$this->session->set_flashdata('error', 'Data gagal disimpan! Nama Group Sudah Dipakai');
			redirect('admin/edit-group-participants/' . $id_group_participants);
		} else { //Jika masih belum ada simpan
			$tbl = $this->tbl_group_peserta;
			$update = $this->general->update_data($tbl, $data, $participants_group_id);
		}

		$urly = 'admin/group-participants';
		$urlx = 'admin/edit-group-participants/' . $id_group_participants;
		$this->update_end($update, $urly, $urlx);
	}

	public function disable_group_participants($id_group_participants)
	{
		$data = [];
		$participants_group_id = base64_decode(urldecode($id_group_participants));

		$tbl = $this->tbl_group_peserta;
		$disable = $this->general->delete_data($tbl, $participants_group_id);

		$urly = 'admin/group-participants';
		$urlx = 'admin/group-participants';
		$this->delete_end($disable, $urly, $urlx);
	}

	public function participants()
	{
		$lembaga_id = $this->session->userdata('lembaga_id');

		$search_active = $this->input->post('search_active') && $this->input->post('search_active') == 1 ? 1 : 0;
		$group_kelompok_peserta = $this->input->post('group_kelompok_id');
		$nomor_peserta = $this->input->post('kata_kunci_nomor');
		$nama_peserta = $this->input->post('kata_kunci_nama');
		$username_peserta = $this->input->post('kata_kunci_username');

		if ($search_active == 1) { //POST DATA
			$data['content']['participants'] = $this->user->get_peserta_filter_data(
				$lembaga_id,
				$group_kelompok_peserta,
				$nomor_peserta,
				$nama_peserta,
				$username_peserta
			);
			$data['content']['group_kelompok_peserta'] = $group_kelompok_peserta;
			$data['content']['nomor_peserta'] = $nomor_peserta;
			$data['content']['nama_peserta'] = $nama_peserta;
			$data['content']['username_peserta'] = $username_peserta;
		} else {
			$data['content']['participants'] = []; //$this->user->get_peserta_by_lembaga($lembaga_id);
			$data['content']['group_kelompok_peserta'] = 'all_group';
			$data['content']['nomor_peserta'] = '';
			$data['content']['nama_peserta'] = '';
			$data['content']['username_peserta'] = '';
		}

		//for passing data to view
		$data['content']['group_peserta'] = $this->tes->get_group_peserta();
		$data['title_header'] = ['title' => 'Peserta List'];

		//for load view
		$view['css_additional'] = 'website/lembaga/user/peserta/css';
		$view['content'] = 'website/lembaga/user/peserta/content';
		$view['js_additional'] = 'website/lembaga/user/peserta/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function add_participants()
	{
		//for passing data to view
		$lembaga_id = $this->session->userdata('lembaga_id');
		$role_user_id = 2; //Role Id untuk user
		$lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
		$role_user_id_crypt = urlencode(base64_encode($role_user_id));
		$cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

		$data['content']['role_user_id'] = $role_user_id_crypt; //Role user id untuk peserta
		$data['content']['lembaga_id'] = $lembaga_id_crypt; //Lembaga id untuk peserta
		$data['content']['group_peserta'] = $this->user->get_group_peserta_enable($lembaga_id);
		$data['title_header'] = ['title' => 'Add Peserta'];

		if ($cek_verify_lembaga->is_verify == 1) {
			//for load view
			$view['css_additional'] = 'website/lembaga/user/peserta/css';
			$view['content'] = 'website/lembaga/user/peserta/add';
			$view['js_additional'] = 'website/lembaga/user/peserta/js';

			//get function view website
			$this->_generate_view($view, $data);
		} else {
			$this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah admin lembaga!');
			redirect('admin/participants');
		}
	}

	public function submit_add_peserta()
	{
		$data_user = [];
		$data_peserta = [];
		$role_user_id = $this->input->post('role_user_id');
		$lembaga_id = $this->input->post('lembaga_id');

		$username = $this->input->post('email_peserta', TRUE);
		$password = $this->input->post('password', TRUE);

		//cek email user
		$cek_email_user = $this->user->get_peserta_by_username($username);

		if ($cek_email_user) { //jika email peserta sudah pernah kedaftar
			$peserta_id = $cek_email_user->peserta_id;
			$user_id = $cek_email_user->user_id;
			$email = $cek_email_user->username;
			$no_peserta = $this->input->post('no_peserta', TRUE);
			$group_peserta = $this->input->post('group_peserta', TRUE);
			$nama_peserta = $this->input->post('nama_peserta', TRUE);

			$update_data_user = $this->submit_edit_peserta_new($peserta_id, $user_id, $email, $password, $no_peserta, $group_peserta, $nama_peserta);

			if (!empty($update_data_user)) {
				$this->session->set_flashdata('success', 'User sudah terdaftar! Data berhasil diperbaharui');
				redirect('admin/participants');
			} else { //Jika insert gagal hentikan proses upload
				$this->session->set_flashdata('error', 'Data gagal disimpan! Kesalahan saat menyimpan data peserta. Ulangi kembali');
				redirect('admin/add-participants');
			}
		}

		if ($username == '' || $username == NULL || empty($username)) { //Jika email dikosongkan
			$username_input = $this->generate_username();
		} else {
			$username_input = $username;
		}

		if ($password == '' || $password == NULL || empty($password)) {
			$pass_input = $this->secure_random_string($this->length_pass);
		} else {
			$pass_input = $password;
		}

		//Data User
		$data_user['role_user_id'] = base64_decode(urldecode($role_user_id));
		$data_user['username'] = $username_input;
		$data_user['password'] = $this->encryption->encrypt($pass_input);
		$data_user['created_datetime'] = date('Y-m-d H:i:s');

		//Data Peserta
		$data_peserta['lembaga_id'] = base64_decode(urldecode($lembaga_id));
		$data_peserta['no_peserta'] = $this->input->post('no_peserta', TRUE);
		$data_peserta['group_peserta_id'] = $this->input->post('group_peserta', TRUE);
		$data_peserta['name'] = ucwords($this->input->post('nama_peserta', TRUE));
		$data_peserta['created_datetime'] = date('Y-m-d H:i:s');

		$input = $this->user->input_peserta_tes($data_user, $data_peserta);

		$urly = 'admin/participants';
		$urlx = 'admin/add-participants';
		$this->input_end($input, $urly, $urlx);
	}

	public function add_import_excel_participants($datas = NULL)
	{
		//for passing data to view
		$lembaga_id = $this->session->userdata('lembaga_id');
		$role_user_id = 2; //Role Id untuk user

		$name_config = 'TEMPLATE UPLOAD';
		$detail_config = 'UPLOAD DATA PESERTA';

		$lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
		$role_user_id_crypt = urlencode(base64_encode($role_user_id));

		$cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

		if (!empty($datas)) {
			$data['content']['message'] = $datas;
		} else {
			$data['content']['message'] = '';
		}
		$data['content']['role_user_id'] = $role_user_id_crypt; //Role user id untuk peserta
		$data['content']['lembaga_id'] = $lembaga_id_crypt; //Lembaga id untuk peserta
		$data['content']['file_template'] = $this->user->get_pengaturan_universal_id($name_config, $detail_config);
		$data['title_header'] = ['title' => 'Upload Data Peserta'];

		if ($cek_verify_lembaga->is_verify == 1) {
			//for load view
			$view['css_additional'] = 'website/lembaga/user/peserta/css';
			$view['content'] = 'website/lembaga/user/peserta/upload_excel';
			$view['js_additional'] = 'website/lembaga/user/peserta/js';

			//get function view website
			$this->_generate_view($view, $data);
		} else {
			$this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah admin lembaga!');
			redirect('admin/participants');
		}
	}

	public function submit_upload_add_peserta()
	{
		$id_lembaga = $this->input->post('lembaga_id');
		$lembaga_id = base64_decode(urldecode($id_lembaga));

		$id_role_user = $this->input->post('role_user_id');
		$role_user_id = base64_decode(urldecode($id_role_user));

		//Define penampung data
		$group_peserta = '';
		$kelompok = '';
		$nomor_peserta = '';
		$nama_peserta = '';
		$email = '';
		$password = '';
		$user = '';
		$peserta = '';
		$data = [];

		if ($_FILES["data_peserta"]["name"] != '') {
			$allowed_extension = array('xls', 'xlsx');
			$file_array = explode(".", $_FILES["data_peserta"]["name"]);
			$file_extension = end($file_array);

			if (in_array($file_extension, $allowed_extension)) {
				$file_name = time() . '.' . $file_extension;
				move_uploaded_file($_FILES['data_peserta']['tmp_name'], $file_name);
				$file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

				$spreadsheet = $reader->load($file_name);

				unlink($file_name);

				$data = $spreadsheet->getActiveSheet()->toArray();

				$no_null = 0;
				$no_upload = 0;
				//Detail data untuk peserta dan user
				foreach ($data as $key => $row) {
					if ($key > 0 && ((!empty($row[1]) || $row[1] != '' || $row[1] != NULL) && (!empty($row[2]) || $row[2] != '' || $row[2] != NULL))) { //Header tidak diikutkan di save
						//Cleaning whitespace
						$group_peserta = trim($row[0]);
						$nomor_peserta = trim($row[1]);
						$nama_peserta = trim($row[2]);
						$email = trim($row[3]);
						$password = trim($row[4]);

						//Insert data kelompok peserta
						$kelompok = $this->insert_data_group_peserta($lembaga_id, ucwords($group_peserta));

						//Insert data user
						$user = $this->insert_data_user_peserta($role_user_id, $email, $password);

						//Insert data peserta
						$peserta = $this->insert_data_peserta($lembaga_id, $kelompok, $user, $nomor_peserta, $nama_peserta);

						$no_upload++;
					} elseif ($key > 0 && ($row[0] == '' && $row[1] == '' && $row[2] == '' && $row[3] == '' && $row[4] == '')) {
					} elseif ($key > 0 && ((empty($row[1]) || $row[1] == '' || $row[1] == NULL) && (empty($row[2]) || $row[2] == '' || $row[2] == NULL))) {
						$no_null++;
					}
				}

				if ($no_null) {
					$text = '<div class="alert alert-info">' . $no_upload . ' Data berhasil disimpan, Tetapi Terdapat ' . $no_null . ' data upload yang gagal, periksa kembali jika ada nomor peserta atau nama peserta yang masih kosong</div>';
					$this->add_import_excel_participants($text);
				} else {
					$text = '<div class="alert alert-success">' . $no_upload . ' Data berhasil disimpan</div>';
					$this->add_import_excel_participants($text);
				}
			} else {
				$text = '<div class="alert alert-danger">Hanya tipe excel .xls dan .xlsx yang diijinkan</div>';
				$this->add_import_excel_participants($text);
			}
		} else {
			$text = '<div class="alert alert-danger">Tidak ada file yang diupload</div>';
			$this->add_import_excel_participants($text);
		}
	}

	private function insert_data_group_peserta($lembaga_id, $row)
	{
		$data_kelompok = [];

		if (empty($row) || $row == '' || $row == NULL) {
			$id = 0;
			return $id;
		}

		//Cek Database
		$cek_group = $this->user->checking_group_peserta($lembaga_id, $row);

		if (empty($cek_group)) {
			$tbl = $this->tbl_group_peserta;
			$data_kelompok = array(
				'lembaga_id' => $lembaga_id,
				'name' => $row,
				'created_datetime' => date('Y-m-d H:i:s')
			);

			$insert_group = $this->general->input_data_id($tbl, $data_kelompok);

			if (!empty($insert_group)) {
				return $insert_group;
			} else { //Jika insert gagal cek data jika sebelumnnya udah ada yang kesimpan
				$cek_group = $this->user->checking_group_peserta($lembaga_id, $row);
				if (!empty($cek_group)) { //Jika ada lempar data id
					return $cek_group->id;
				} else { //Jika masih belum ada langsung gagal aja
					$this->session->set_flashdata('error', 'Data gagal disimpan! Kesalahan saat menyimpan nama kelompok. Ulangi kembali');
					redirect('admin/add-import-participants');
				}
			}
		} else {
			return $cek_group->id;
		}
	}

	private function insert_data_user_peserta($role_user_id, $username, $password)
	{
		$data_user = [];
		$tbl = $this->tbl_user;

		//Cek user didatabase
		$cek_user = $this->user->checking_user_peserta($role_user_id, $username);

		if (empty($cek_user)) { //Jika data email tersebut belum terdaftar
			if (empty($username) || $username == '' || $username == NULL) { //Jika email kosong / tidak diisi
				$username_input = $this->generate_username();
			} else {
				$username_input = $username;
			}

			if ($password == '' || $password == NULL || empty($password)) { //Jika password kosong /tidak diisi
				$pass_input = $this->encryption->encrypt($this->secure_random_string($this->length_pass));
			} else {
				$pass_input = $this->encryption->encrypt($password);
			}
		} else { //Jika data email tersebut sudah terdaftar, perbaharui password jika diisi baru / kosong
			if ($password == '' || $password == NULL || empty($password)) { //Jika password kosong /tidak diisi
				$pass_input = $this->encryption->encrypt($this->secure_random_string($this->length_pass));
			} else {
				$pass_input = $this->encryption->encrypt($password);
			}

			$id_peserta = $cek_user->id;
			$datas = array(
				'password' => $pass_input
			);

			$this->general->update_data($tbl, $datas, $id_peserta);
			return $cek_user->id;
		}

		$data_user = array(
			'role_user_id' => $role_user_id,
			'username' => $username_input,
			'password' => $pass_input,
			'created_datetime' => date('Y-m-d H:i:s')
		);

		$insert_user = $this->general->input_data_id($tbl, $data_user);

		if (!empty($insert_user)) {
			return $insert_user;
		} else { //Jika insert gagal cek data jika sebelumnnya udah ada yang kesimpan
			$cek_user = $this->user->checking_user_peserta($role_user_id, $username_input);
			if (!empty($cek_user)) { //Jika ada lempar data id
				return $cek_user->id;
			} else { //Jika masih belum ada langsung gagal aja
				$this->session->set_flashdata('error', 'Data gagal disimpan! Kesalahan saat menyimpan username dan password. Ulangi kembali');
				redirect('admin/add-import-participants');
			}
		}
	}

	private function insert_data_peserta($lembaga_id, $kelompok, $user, $no_peserta, $nama_peserta)
	{
		$data_peserta = [];
		$datas = [];

		$cek_peserta = $this->user->checking_peserta($lembaga_id, $user);

		if (!empty($cek_peserta)) {
			$datas = array(
				'is_lock' => 1
			);
			$this->user->update_data_peserta_excel($datas, $user);
		}

		$data_peserta = array(
			'user_id' => $user,
			'lembaga_id' => $lembaga_id,
			'group_peserta_id'  => $kelompok,
			'no_peserta'  => $no_peserta,
			'name'  => $nama_peserta,
			'created_datetime' => date('Y-m-d H:i:s')
		);

		$tbl = $this->tbl_peserta;

		$input_peserta = $this->general->input_data_id($tbl, $data_peserta);

		if (!empty($input_peserta)) {
			return $input_peserta;
		} else { //Jika insert gagal hentikan proses upload
			$this->session->set_flashdata('error', 'Data gagal disimpan! Kesalahan saat menyimpan data peserta. Ulangi kembali');
			redirect('admin/add-import-participants');
		}
	}

	public function edit_participants($id_peserta, $id_user)
	{
		//for passing data to view
		$peserta_id = base64_decode(urldecode($id_peserta));
		$user_id = base64_decode(urldecode($id_user));
		$detail_partisipan = $this->user->get_peserta_by_id($peserta_id, $user_id);
		$lembaga_id = $detail_partisipan->lembaga_id;

		$cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

		$data['content']['id_peserta'] = $id_peserta;
		$data['content']['id_user'] = $id_user;
		$data['content']['id_lembaga'] = urlencode(base64_encode($lembaga_id));
		$data['content']['group_peserta'] = $this->user->get_group_peserta_selected($detail_partisipan->group_peserta_id);
		$data['content']['participants'] = $detail_partisipan;
		$data['content']['password'] = $this->encryption->decrypt($detail_partisipan->password);
		$data['title_header'] = ['title' => 'Edit Peserta'];

		if ($cek_verify_lembaga->is_verify == 1) {
			//for load view
			$view['css_additional'] = 'website/lembaga/user/peserta/css';
			$view['content'] = 'website/lembaga/user/peserta/edit';
			$view['js_additional'] = 'website/lembaga/user/peserta/js';

			//get function view website
			$this->_generate_view($view, $data);
		} else {
			$this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah admin lembaga!');
			redirect('admin/user-lembaga');
		}
	}

	public function submit_edit_peserta()
	{
		$data_user = [];
		$data_peserta = [];
		$peserta_id = $this->input->post('peserta_id');
		$user_id = $this->input->post('user_id');

		$username = $this->input->post('email_peserta', TRUE);
		$password = $this->input->post('password', TRUE);

		if ($username == '' || $username == NULL || empty($username)) { //Jika email dikosongkan
			$username_input = $this->generate_username();
		} else {
			$username_input = $username;
		}

		if ($password == '' || $password == NULL || empty($password)) {
			$pass_input = $this->secure_random_string($this->length_pass);
		} else {
			$pass_input = $password;
		}

		//Data User
		$id_user = base64_decode(urldecode($user_id));
		$data_user['username'] = $username_input;
		$data_user['password'] = $this->encryption->encrypt($pass_input);
		$data_user['updated_datetime'] = date('Y-m-d H:i:s');

		//Data Peserta
		$id_peserta = base64_decode(urldecode($peserta_id));
		$data_peserta['no_peserta'] = $this->input->post('no_peserta', TRUE);
		$data_peserta['group_peserta_id'] = $this->input->post('group_peserta', TRUE);
		$data_peserta['name'] = ucwords($this->input->post('nama_peserta', TRUE));
		$data_peserta['updated_datetime'] = date('Y-m-d H:i:s');

		$update = $this->user->update_peserta_tes($data_user, $id_user, $data_peserta, $id_peserta);

		$urly = 'admin/participants';
		$urlx = 'admin/edit-participants/' . $peserta_id . '/' . $user_id;
		$this->update_end($update, $urly, $urlx);
	}

	public function submit_edit_peserta_new($peserta_id, $user_id, $email, $password, $no_peserta, $group_peserta, $nama_peserta)
	{
		$data_user = [];
		$data_peserta = [];

		if ($password == '' || $password == NULL || empty($password)) {
			$pass_input = $this->secure_random_string($this->length_pass);
		} else {
			$pass_input = $password;
		}

		//Data User
		$id_user = $user_id;
		$data_user['username'] = $email;
		$data_user['password'] = $this->encryption->encrypt($pass_input);
		$data_user['updated_datetime'] = date('Y-m-d H:i:s');

		//Data Peserta
		$id_peserta = $peserta_id;
		$data_peserta['no_peserta'] = $no_peserta;
		$data_peserta['group_peserta_id'] = $group_peserta;
		$data_peserta['name'] = ucwords($nama_peserta);
		$data_peserta['updated_datetime'] = date('Y-m-d H:i:s');

		$update = $this->user->update_peserta_tes($data_user, $id_user, $data_peserta, $id_peserta);

		return $update;
	}

	public function disable_participants($id_peserta, $id_user)
	{
		$data = [];
		$peserta_id = base64_decode(urldecode($id_peserta));
		$user_id = base64_decode(urldecode($id_user));

		$data = array(
			'is_enable' => 0,
			'updated_datetime' => date('Y-m-d H:i:s')
		);

		$disable = $this->user->disable_peserta_user($peserta_id, $user_id, $data);

		$urly = 'admin/participants';
		$urlx = 'admin/participants';
		$this->delete_end($disable, $urly, $urlx);
	}

	public function user_multiple_delete_all()
	{
		if ($this->input->post('checkbox_value')) {
			$id = $this->input->post('checkbox_value');

			$data = array(
				'is_enable' => 0,
				'updated_datetime' => date('Y-m-d H:i:s')
			);

			for ($count = 0; $count < count($id); $count++) {
				$peserta_exp = explode("|", $id[$count]);
				$peserta_id = $peserta_exp[0];
				$user_id = $peserta_exp[1];
				$this->user->disable_peserta_user($peserta_id, $user_id, $data);
			}
		}
	}

	public function user_peserta_delete_all()
	{
		$data = array(
			'is_enable' => 0,
			'updated_datetime' => date('Y-m-d H:i:s')
		);

		$disable = $this->user->disable_all_peserta_user($data);

		$urly = 'admin/participants';
		$urlx = 'admin/participants';
		$this->delete_end($disable, $urly, $urlx);
	}

	public function export_participants()
	{
		$lembaga_id = $this->session->userdata('lembaga_id');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nomor Peserta');
		$sheet->setCellValue('C1', 'Nama');
		$sheet->setCellValue('D1', 'Kelompok');
		$sheet->setCellValue('E1', 'Username/Email');
		$sheet->setCellValue('F1', 'Password');

		$siswa = $this->user->get_peserta_by_lembaga($lembaga_id);
		$no = 1;
		$x = 2;
		foreach ($siswa as $row) {
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
		$filename = 'All-Data-Peserta';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
