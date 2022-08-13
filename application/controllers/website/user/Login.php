<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	private $tbl_user = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
		$this->load->model('General', 'general');
		$this->load->model('User_model', 'user');
	}

	/*
    |
    | START FUNCTION IN THIS CONTROLLER
    |
    */

	private function generate_no_peserta()
	{
		$no_peserta = '';

		$min = 0;
		$max = 9999;
		$output = rand($min, $max);

		$length = strlen($output);
		$date = date('Y') . date('m') . date('d');

		if ($length == 1) {
			$no_peserta = $date . '000' . $output;
		} elseif ($length == 2) {
			$no_peserta = $date . '00' . $output;
		} elseif ($length == 3) {
			$no_peserta = $date . '0' . $output;
		} elseif ($length == 4) {
			$no_peserta = $date . $output;
		}

		$check_no_peserta = $this->user->checking_nomor_peserta($no_peserta);

		if ($check_no_peserta) {
			$this->generate_no_peserta();
		} else {
			return $no_peserta;
		}
	}

	private function saved_login($timezone, $user_id)
	{
		$datetime_login = new DateTime(date('Y-m-d H:i:s'));
		$timezones = $datetime_login->setTimezone(new DateTimeZone($timezone));
		$datetime_logins = $timezones->format(DateTime::ATOM); //ISO8601
		$login_datas = array(
			'timezone' => $timezone,
			'last_login' => $datetime_logins
		);
		$this->general->update_data($this->tbl_user, $login_datas, $user_id);

		return true;
	}

	/*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

	public function index()
	{
		$this->load->view('website/user/login/home/content');
	}

	public function login()
	{
		$this->load->view('website/user/login/content');
	}

	public function submit_register()
	{
		$data = [];
		$data_user = [];
		$data_peserta = [];
		$role_user_id = 2;
		$lembaga_id = 2;

		$username = $this->input->post('email', TRUE);
		$password = $this->input->post('password', TRUE);
		$timezone = $this->input->post('timezone', TRUE);

		$check_username = $this->user->get_checking_username($username);

		if (!empty($check_username)) {
			$this->session->set_flashdata('error', 'Email anda sudah terdaftar! Silahkan login.');
			redirect("register");
		}

		//Data User
		$data_user['role_user_id'] = $role_user_id;
		$data_user['username'] = $username;
		$data_user['is_event'] = 0;
		$data_user['password'] = $this->encryption->encrypt($password);
		$data_user['created_datetime'] = date('Y-m-d H:i:s');

		//Data Peserta
		$data_peserta['lembaga_id'] = $lembaga_id;
		$data_peserta['no_telp'] = $this->input->post('phone', TRUE);
		$data_peserta['no_peserta'] = $this->generate_no_peserta();
		$data_peserta['event_id'] = null;
		$data_peserta['group_peserta_id'] = 0;
		$data_peserta['name'] = ucwords($this->input->post('name', TRUE));
		$data_peserta['created_datetime'] = date('Y-m-d H:i:s');

		$data['username'] = $username;

		$input = $this->user->input_peserta_tes($data_user, $data_peserta);

		if ($input) {
			$data['login_user'] = $this->general->login_user($data);

			$this->saved_login($timezone, $data['login_user'][0]['user_id']);

			$user_datas = array(
				'user_id' => $data['login_user'][0]['user_id'],
				'username' => $data['login_user'][0]['username'],
				'is_login' => $data['login_user'][0]['is_login'],
				'no_peserta' => $data['login_user'][0]['no_peserta'],
				'peserta_name' => $data['login_user'][0]['peserta_name'],
				'group_peserta_id' => $data['login_user'][0]['group_peserta_id'],
				'group_peserta_name' => $data['login_user'][0]['group_peserta_name'],
				'role_user_id' => $data['login_user'][0]['role_user_id'],
				'event' => 0, //1 Event 0 Tidak Event
				'has_login_user' => 1
			);

			$this->session->set_userdata($user_datas);
			session_start();

			$this->session->set_flashdata('success', 'Selamat Datang ' . $data['login_user'][0]['peserta_name']);

			redirect('dashboard');
		} else {
			$this->session->set_flashdata('error', 'Pendaftaran gagal! Silahkan coba beberapa saat lagi');
			redirect("register");
		}
	}

	public function submit_login()
	{
		$data['username'] = $this->input->post('username', TRUE);
		$data['password'] = $this->input->post('password', TRUE);
		$timezone = $this->input->post('timezone', TRUE);

		$data['login_user'] = $this->general->login_user($data);

		$decode = $this->encryption->decrypt($data['login_user'][0]['password']);

		if ($data['login_user'] && $decode == $data['password']) {
			$this->saved_login($timezone, $data['login_user'][0]['user_id']);

			$user_datas = array(
				'user_id' => $data['login_user'][0]['user_id'],
				'username' => $data['login_user'][0]['username'],
				'is_login' => $data['login_user'][0]['is_login'],
				'no_peserta' => $data['login_user'][0]['no_peserta'],
				'peserta_name' => $data['login_user'][0]['peserta_name'],
				'group_peserta_id' => $data['login_user'][0]['group_peserta_id'],
				'group_peserta_name' => $data['login_user'][0]['group_peserta_name'],
				'role_user_id' => $data['login_user'][0]['role_user_id'],
				'event' => 0, //1 Event 0 Tidak Event
				'event_prefix' => null,
				'has_login_user' => 1
			);

			$this->session->set_userdata($user_datas);
			session_start();

			$this->session->set_flashdata('success', 'Selamat Datang ' . $data['login_user'][0]['peserta_name']);

			redirect('dashboard');
		} else {
			$this->session->set_flashdata('error', 'Login gagal! Username atau Password Salah');
			redirect("login");
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("login");
	}
}
