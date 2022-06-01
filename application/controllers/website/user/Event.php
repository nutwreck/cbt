<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
		$this->load->model('General', 'general');
		$this->load->model('Management_model', 'management');
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

	private function event_group_count($event_group_peserta)
	{
		$count_user = 0;
		if ($event_group_peserta) {
			foreach ($event_group_peserta as $valEGP) {
				$user_group_peserta = $this->management->count_user_by_group_peserta($valEGP->group_peserta_id);
				$count_user += (int) $user_group_peserta;
			}

			return $count_user;
		} else {
			return $count_user;
		}
	}

	private function event_group_fill($event_group_peserta)
	{
		foreach ($event_group_peserta as $valEGP) {
			$user_group_peserta = (int) $this->management->count_user_by_group_peserta($valEGP->group_peserta_id);
			if ($user_group_peserta < $valEGP->max_kuota) {
				return $valEGP->group_peserta_id;
			}
		}
	}

	private function get_group_peserta($event)
	{
		## KUOTA TERBATAS ##
		if ($event->mode_kuota_peserta == 2) {
			## GET TOTAL USER YANG SUDAH PAKAI
			$event_group_peserta = $this->management->get_group_peserta_by_id($event->id);
			$total_count_group = (int) $this->event_group_count($event_group_peserta);

			if ($total_count_group >= (int) $event->kuota) {
				return 'penuh';
			} else {
				$group_select = $this->event_group_fill($event_group_peserta);
				return $group_select;
			}
		} else {
			$event_group_peserta = $this->management->get_group_peserta_by_id($event->id);

			foreach ($event_group_peserta as $valEGP) {
				$user_group_peserta = (int) $this->management->count_user_by_group_peserta($valEGP->group_peserta_id);
				if ($user_group_peserta < $valEGP->max_kuota || $valEGP->max_kuota == 0) {
					return $valEGP->group_peserta_id;
				}
			}
		}
	}

	/*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

	public function url_prefix($prefix = "")
	{
		if ($prefix == "") {
			$this->session->set_flashdata('warning', 'Akses Tidak Diijinkan!');

			redirect('/');
		}

		$event = $this->management->get_event_by_prefix($prefix);

		if ($event) {
			$event_id = $event->id;

			$data['event'] = $event;
			$data['banner'] = $this->management->get_event_banner_by_event($event_id);
			$this->load->view('website/user/event/register/content', $data);
		} else {
			$this->session->set_flashdata('error', 'Event Tidak Ditemukan!');
			redirect('/');
		}
	}

	public function submit_register()
	{
		$prefix = $this->input->post('prefix_url', TRUE);

		$event = $this->management->get_event_by_prefix($prefix);
		$now = date('Y-m-d H:i:s');

		if ($event) {
			## WAKTU TERBATAS ##
			if ($event->start_date != null || $event->end_date != null) {
				## WAKTU SELESAI ##
				if ($now >= $event->end_date) {
					$this->session->set_flashdata('info', 'Event Sudah Berakhir!');
					redirect('/event/login/' . $event->prefix_url);
				}

				## WAKTU BELUM MULAI ##
				if ($now <= $event->start_date) {
					$this->session->set_flashdata('info', 'Event Belum Dimulai!');
					redirect('/event/login/' . $event->prefix_url);
				}
			}

			$data = [];
			$data_user = [];
			$data_peserta = [];
			$role_user_id = 2;
			$lembaga_id = 2;

			$username = $this->input->post('email', TRUE);
			$password = $this->input->post('password', TRUE);

			$check_username = $this->user->get_checking_username($username);

			if (!empty($check_username)) {
				$this->session->set_flashdata('error', 'Email anda sudah terdaftar! Silahkan login.');
				redirect("event/" . $event->prefix_url);
			}

			//Group peserta check
			$group_peserta_id = $this->get_group_peserta($event);
			if ($group_peserta_id == "penuh") {
				$this->session->set_flashdata('error', 'Kuota Pendaftaran Sudah Habis.');
				redirect("event/" . $event->prefix_url);
			}

			//Data User
			$data_user['role_user_id'] = $role_user_id;
			$data_user['username'] = $username;
			$data_user['is_event'] = 1;
			$data_user['password'] = $this->encryption->encrypt($password);
			$data_user['created_datetime'] = date('Y-m-d H:i:s');

			//Data Peserta
			$data_peserta['lembaga_id'] = $lembaga_id;
			$data_peserta['no_telp'] = $this->input->post('phone', TRUE);
			$data_peserta['event_id'] = $event->id;
			$data_peserta['no_peserta'] = $this->generate_no_peserta();
			$data_peserta['group_peserta_id'] = $group_peserta_id;
			$data_peserta['name'] = ucwords($this->input->post('name', TRUE));
			$data_peserta['created_datetime'] = date('Y-m-d H:i:s');

			$data['username'] = $username;

			$input = $this->user->input_peserta_tes($data_user, $data_peserta);

			if ($input) {
				$data['login_user'] = $this->general->login_user($data);

				$user_datas = array(
					'user_id' => $data['login_user'][0]['user_id'],
					'username' => $data['login_user'][0]['username'],
					'is_login' => $data['login_user'][0]['is_login'],
					'no_peserta' => $data['login_user'][0]['no_peserta'],
					'peserta_name' => $data['login_user'][0]['peserta_name'],
					'group_peserta_id' => $data['login_user'][0]['group_peserta_id'],
					'group_peserta_name' => $data['login_user'][0]['group_peserta_name'],
					'role_user_id' => $data['login_user'][0]['role_user_id'],
					'event' => 1, //1 Event 0 Tidak Event
					'has_login_user' => 1
				);

				$this->session->set_userdata($user_datas);
				session_start();

				$this->session->set_flashdata('success', 'Selamat Datang ' . $data['login_user'][0]['peserta_name']);

				redirect('dashboard');
			} else {
				$this->session->set_flashdata('error', 'Pendaftaran gagal! Silahkan coba beberapa saat lagi');
				redirect("event/" . $event->prefix_url);
			}
		} else {
			$this->session->set_flashdata('error', 'Event Tidak Ditemukan!');
			redirect('/');
		}
	}

	public function login($prefix = "")
	{
		if ($prefix == "") {
			$this->session->set_flashdata('warning', 'Akses Tidak Diijinkan!');
			redirect('/');
		}

		$event = $this->management->get_event_by_prefix($prefix);

		if ($event) {
			$event_id = $event->id;

			$data['event'] = $event;
			$data['banner'] = $this->management->get_event_banner_by_event($event_id);

			$this->load->view('website/user/event/login/content', $data);
		} else {
			$this->session->set_flashdata('error', 'Event Tidak Ditemukan!');
			redirect('/');
		}
	}

	public function submit_login()
	{
		$prefix = $this->input->post('prefix_url', TRUE);

		$event = $this->management->get_event_by_prefix($prefix);
		$now = date('Y-m-d H:i:s');

		if ($event) {
			## WAKTU TERBATAS ##
			if ($event->start_date != null || $event->end_date != null) {
				## WAKTU SELESAI ##
				if ($now >= $event->end_date) {
					$this->session->set_flashdata('info', 'Event Sudah Berakhir!');
					redirect('/event/login/' . $event->prefix_url);
				}

				## WAKTU BELUM MULAI ##
				if ($now <= $event->start_date) {
					$this->session->set_flashdata('info', 'Event Belum Dimulai!');
					redirect('/event/login/' . $event->prefix_url);
				}
			}

			$data['username'] = $this->input->post('username', TRUE);
			$data['password'] = $this->input->post('password', TRUE);

			$data['login_user'] = $this->general->login_user($data);

			$decode = $this->encryption->decrypt($data['login_user'][0]['password']);

			if ($data['login_user'] && $decode == $data['password']) {
				$user_datas = array(
					'user_id' => $data['login_user'][0]['user_id'],
					'username' => $data['login_user'][0]['username'],
					'is_login' => $data['login_user'][0]['is_login'],
					'no_peserta' => $data['login_user'][0]['no_peserta'],
					'peserta_name' => $data['login_user'][0]['peserta_name'],
					'group_peserta_id' => $data['login_user'][0]['group_peserta_id'],
					'group_peserta_name' => $data['login_user'][0]['group_peserta_name'],
					'role_user_id' => $data['login_user'][0]['role_user_id'],
					'event' => 1, //1 Event 0 Tidak Event
					'event_prefix' => $event->prefix_url,
					'has_login_user' => 1
				);

				$this->session->set_userdata($user_datas);
				session_start();

				$this->session->set_flashdata('success', 'Selamat Datang ' . $data['login_user'][0]['peserta_name']);

				redirect('dashboard');
			} else {
				$this->session->set_flashdata('error', 'Login gagal! Username atau Password Salah');
				redirect("event/login/" . $event->prefix_url);
			}
		} else {
			$this->session->set_flashdata('error', 'Event Tidak Ditemukan!');
			redirect('/');
		}
	}

	public function logout($prefix_url)
	{
		$this->session->sess_destroy();
		redirect('/event/login/' . $prefix_url);
	}
}
