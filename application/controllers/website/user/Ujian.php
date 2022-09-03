<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ujian extends CI_Controller
{

	//private $length_pass = 15;
	private $tbl_ujian = 'ujian';
	private $tbl_ujian_skor = 'ujian_skor';
	private $tbl_ujian_report = 'ujian_report';
	private $tbl_user = 'user';

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('has_login_user')) {
			redirect('login');
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
    |  $this->load->view('website/user/_template/header'); -->head (must - include css main)
    |  $this->load->view('website/ujian/css'); --> css additional (flexible)
    |  $this->load->view('website/user/_template/content'); --> content body (must)
    |  $this->load->view('website/_template/menu'); --> Header menu main (flexible - can replace)
    |  $this->load->view('website/ujian/content_dashboard'); --> content web (must)
    |  $this->load->view('website/user/_template/js_main'); --> js main (must)
    |  $this->load->view('website/ujian/js'); --> js additional (flexible)
    |  $this->load->view('website/user/_template/footer'); --> content body (must)
    |
    |  EDIT CODE DIBAWAH INI UNTUK MENGGANTI STRUKTUR PEMANGGILAN VIEW / DESIGN
    |
    */

	private function _generate_view($view, $data)
	{
		$this->load->view('website/user/_template/header', $data['title_header']);
		$this->load->view($view['css_additional']);
		$this->load->view('website/user/_template/content');
		$this->load->view('website/user/_template/sidebar');
		$this->load->view($view['content'], $data['content']);
		$this->load->view('website/user/_template/js_main');
		$this->load->view($view['js_additional']);
		$this->load->view('website/user/_template/footer');
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

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	/* private function get_ip_address()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //whether ip is from share internet
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //whether ip is from proxy
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else { //whether ip is from remote address
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		return $ip_address;
	} */

	/* private function get_timezone($ip_address)
	{
		//Jika ip yang didapat tidak sesuai kembalikan Asia Jakarta
		if (is_null($ip_address) || $ip_address == "" || $ip_address == "::1" || $ip_address == "127.0.0.1") {
			$timezone = 'Asia/Jakarta';
			return $timezone;
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://ip-api.com/json/" . $ip_address . '?fields=timezone',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"content-type: application/json"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) { //Jika eror dari GeoIP langsung dibikin Asia/Jakarta
			$timezone = 'Asia/Jakarta';
			return $timezone;
		} else {
			$obj = json_decode($response);
			$timezone = $obj->{'time_zone'};

			if ($timezone == NULL) {
				$timezone = 'Asia/Jakarta';
				return $timezone;
			}
			 $countrycode = $obj->{'country_code'};

			//return result
			if ($countrycode != 'ID') {
                redirect('location-checking');
            } else {
			return $timezone;
			}
		}
	} */

	/*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

	public function portal_tes($id_sesi_pelaksana, $random_secure)
	{
		//Cheking IP
		// $ip_address = $this->get_ip_address();
		//Checking Timezone
		// $timezone = $this->get_timezone($ip_address);

		$data_ujian = [];
		$bank_soal = [];
		$data = [];
		try {
			$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

			$sesi_detail = $this->tes->get_sesi_pelaksanaan_selected($sesi_pelaksana_id); //Get Sesi Pelaksanaan
			if (empty($sesi_detail)) {
				$this->session->set_flashdata('warning', 'Sesi pelaksanaan ujian telah berakhir!');
				redirect('dashboard');
			}

			$sesi_pelaksanaan_user = $this->tes->get_sesi_pelaksanaan_user_by_sesi($sesi_pelaksana_id, $this->session->userdata('user_id'), 1); //Check sesi pelaksanaan user
			if (empty($sesi_pelaksanaan_user)) {
				$this->session->set_flashdata('warning', 'Anda tidak terdaftar dalam sesi ujian ini!');
				redirect('dashboard');
			}

			$paket_soal_id = $sesi_detail->paket_soal_id;
			$paket_soal = $this->tes->get_paket_soal_sesi_by_id($paket_soal_id); //Get Paket Soal
			if (empty($paket_soal)) {
				$this->session->set_flashdata('warning', 'Paket soal ujian tidak ditemukan. Hubungi admin!');
				redirect('dashboard');
			}

			$ujian_data = $this->tes->get_checking_ujian_non_buku($sesi_pelaksana_id, $paket_soal_id, $this->session->userdata('user_id')); //CEK SEBELUMNYA UDH PERNAH TES ATAU BELUM
			$audio_limit = $paket_soal->visual_limit;
		} catch (Exception $e) {
			$this->session->set_flashdata('portal_error', 'Terjadi kesalahan saat membuka ujian. Silahkan membuka ulang tes anda kembali <i>atau</i> Jika daftar ujian anda hilang silahkan LOGOUT dan LOGIN ulang!');
			redirect('dashboard');
		}

		if (empty($ujian_data)) { //jika wadah untuk pemilihan soal dan jawaban belum ada
			try {
				$this->db->trans_begin();
				$komposisi_soal = $this->tes->get_komposisi_soal_by_id($sesi_pelaksana_id, $paket_soal_id); //Ambil bank soal

				$data_ujian['sesi_pelaksanaan_id'] = $sesi_pelaksana_id;
				$data_ujian['paket_soal_id'] = $paket_soal_id;
				$data_ujian['user_id'] = $this->session->userdata('user_id');
				$data_ujian['user_no'] = $this->session->userdata('no_peserta');
				$data_ujian['user_name'] = $this->session->userdata('peserta_name');
				$data_ujian['user_email'] = $this->session->userdata('username');

				//Set tanggal jam mulai dan berakhir
				$now = date("Y-m-d H:i:s");
				$data_ujian['tgl_mulai'] = $now;
				$data_ujian['tgl_selesai'] = date("Y-m-d H:i:s", strtotime($now . ' + ' . $sesi_detail->lama_pengerjaan . ' minutes'));

				foreach ($komposisi_soal as $val_komposisi) { //Membuat komposisi soal
					$bank_soal[$val_komposisi->id_group_soal] = $this->tes->get_bank_soal_ujian($val_komposisi->paket_soal_id, $val_komposisi->id_group_soal, $val_komposisi->total_soal);
				}

				$list_id_soal	= "";
				$list_jw_soal 	= "";
				if (!empty($bank_soal)) {
					foreach ($bank_soal as $key_soal => $val_soal) { //membuat wadah untuk list soal dan tempat jawabannya
						$group_soal_key = $key_soal;
						foreach ($val_soal as $val_deep_soal) {
							$list_id_soal .= $group_soal_key . "|" . $val_deep_soal['bank_soal_id'] . ",";
							$list_jw_soal .= $group_soal_key . "|" . $val_deep_soal['bank_soal_id'] . "||N|0|0,";
						}
					}
				}

				$list_id_soal = substr($list_id_soal, 0, -1);
				$list_jw_soal = substr($list_jw_soal, 0, -1);
				$data_ujian['list_soal'] = $list_id_soal;
				$data_ujian['list_jawaban'] = $list_jw_soal;
				$data_ujian['created_datetime'] = date('Y-m-d H:i:s');

				$tbl_ujian = $this->tbl_ujian;
				$input_docker_soal = $this->general->input_data($tbl_ujian, $data_ujian);

				if ($input_docker_soal && $this->db->trans_status() !== FALSE) { //jika data tempat ujian sudah terbuat
					$this->db->trans_commit();
					redirect('ujian/' . $id_sesi_pelaksana . '/' . $random_secure, 'location', 301); //refresh halaman agar dimulai lagi dari awal
				} else {
					$this->db->trans_rollback();
					$this->session->set_flashdata('warning', 'Terjadi kesalahan saat persiapan ujian silahkan ulangi lagi!');
					redirect('dashboard');
				}
			} catch (Exception $e) {
				$this->session->set_flashdata('portal_error', 'Terjadi kesalahan saat membuka ujian. Silahkan membuka ulang tes anda kembali <i>atau</i> Jika daftar ujian anda hilang silahkan LOGOUT dan LOGIN ulang!');
				redirect('dashboard');
			}
		}

		try {
			if ($ujian_data->list_soal == NULL || $ujian_data->list_soal == '') { //pengecekan jika list soal kosong
				$this->session->set_flashdata('portal_error', 'List soal anda tidak ditemukan silahkan hubungi admin untuk dilakukkan reset tes jika waktu sesi pelaksanaan masih ada atau lakukkan tes ulang!');
				redirect('dashboard');
			}

			if ($ujian_data->list_jawaban == NULL || $ujian_data->list_jawaban == '') { //pengecekan jika list jawaban kosong
				$this->session->set_flashdata('portal_error', 'List jawaban anda tidak ditemukan silahkan hubungi admin untuk dilakukkan reset tes jika waktu sesi pelaksanaan masih ada atau lakukkan tes ulang!');
				redirect('dashboard');
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
				$gr     = $pc_v[0]; //Id Group
				$idx 	= $pc_v[1]; //Id Soal
				$val 	= $pc_v[2]; //Jawaban
				$rg 	= $pc_v[3]; //Ragu/Tidak
				$aud_g 	= $pc_v[4]; //Audio Group
				$aud_s 	= $pc_v[5]; //Audio Soal

				$arr_jawab[$idx] = array("g" => $gr, "j" => $val, "r" => $rg, "aud_g" => $aud_g, "aud_s" => $aud_s);
			}

			$html = '';
			$previous_number = '';
			$next_number = '';
			$arrow_back = '';
			$arrow_next = '';
			$no_previous = '';
			$no_next = '';
			$group_soal_before = 0;
			if (!empty($soal_urut_ok)) {
				$nomor_soal = 1;
				$num_group_soal = 0;
				foreach ($soal_urut_ok as $s) {
					$group_soal_next = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;

					$id_group_soal_p = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;
					$group_soal_p = $s->group_soal_parent_name != 0 || !empty($s->group_soal_parent_name) ? $s->group_soal_parent_name : $s->group_soal_name;

					$bacaan_soal = $s->isi_bacaan_soal <> 0 || !empty($s->isi_bacaan_soal) ? $s->isi_bacaan_soal . '<br />' : ''; // bacaan soal
					$bacaan_soal_name = $s->bacaan_soal_name <> 0 || !empty($s->bacaan_soal_name) ? '<b>' . $s->bacaan_soal_name . '</b><br />' : ''; // bacaan soal judul
					$group_soal_audio = ($s->group_soal_audio != NULL || $s->group_soal_audio != "") && $audio_limit > $arr_jawab[$s->bank_soal_id]["aud_g"] ? '<audio id="group-loop-limited-' . $nomor_soal . '" controls controlsList="nodownload"><source src="' . config_item('_dir_website') . 'lembaga/grandsbmptn/group_soal/group_' . $s->paket_soal_id . '/' . $s->group_soal_audio . '" type="' . $s->group_soal_tipe_audio . '">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : '';
					$soal_audio = ($s->file <> 0 || !empty($s->file) || $s->file != NULL || $s->file != "") && $audio_limit > $arr_jawab[$s->bank_soal_id]["aud_s"] ? '<audio id="loop-limited-' . $nomor_soal . '" controls controlsList="nodownload"><source src="' . config_item('_dir_website') . 'lembaga/grandsbmptn/paket_soal/soal_' . $s->paket_soal_id . '/' . $s->file . '" type="' . $s->tipe_file . '">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : '';

					$html .= '<div class="step card text-left font-poppins" id="widget_' . $nomor_soal . '">';
					$vrg = $arr_jawab[$s->bank_soal_id]["r"] == "" ? "N" : $arr_jawab[$s->bank_soal_id]["r"];
					$ad_g = $arr_jawab[$s->bank_soal_id]["aud_g"] == "0" ? "0" : $arr_jawab[$s->bank_soal_id]["aud_g"];
					$ad_s = $arr_jawab[$s->bank_soal_id]["aud_s"] == "0" ? "0" : $arr_jawab[$s->bank_soal_id]["aud_s"];
					$html .= '<input type="hidden" name="id_group_mode_jwb' . $nomor_soal . '" value="' . $s->group_mode_jwb_id . '">';
					$html .= '<input type="hidden" name="id_group_soal_' . $nomor_soal . '" value="' . $id_group_soal_p . '">';
					$html .= '<input type="hidden" name="group_soal_' . $nomor_soal . '" value="' . $group_soal_p . '">';
					$html .= '<input type="hidden" name="group_soal_sub_' . $nomor_soal . '" value="' . $s->group_soal_name . '">';
					$html .= '<input type="hidden" name="id_bank_soal_' . $nomor_soal . '" value="' . $s->bank_soal_id . '">';
					$html .= '<input type="hidden" name="rg_' . $nomor_soal . '" id="rg_' . $nomor_soal . '" value="' . $vrg . '">';
					$html .= '<input type="hidden" name="audio_group_' . $nomor_soal . '" id="audio_group_' . $nomor_soal . '" value="' . $ad_g . '">';
					$html .= '<input type="hidden" name="audio_soal_' . $nomor_soal . '" id="audio_soal_' . $nomor_soal . '" value="' . $ad_s . '">';
					$html .= '<input type="hidden" name="opsi_jawaban_' . $nomor_soal . '" id="opsi_jawaban_' . $nomor_soal . '" value="' . $s->is_opsi_jawaban . '">';

					$no_previous = $nomor_soal - 1;
					$no_next = $nomor_soal + 1;

					if ($group_soal_next == $group_soal_before) { //Isi Group
						$arrow_back = $nomor_soal == 1 ? '<a id="arrow_back" class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>' : '<a rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left" aria-hidden="true" title="Soal Sebelumnya"></i></a>';
						$arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true" title="Soal Berikutnya"></i></a>';

						$previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="previous_back" rel="0" onclick="return back();" class="back btn btn-md btn-primary text-white">No ' . $no_previous . '</a></div>';
						$next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No ' . $no_next . '</a></div>';

						$ragu_ragu = '<div class="col" data-position="up"><a rel="1" class="ragu_ragu btn btn-md btn-warning text-white" onclick="return tidak_jawab();">Ragu</a></div>';
					} else { // Parent Group
						$num_group_soal++;
						$arrow_back = $nomor_soal == 1 ? '<a id="group_petunjuk_' . $nomor_soal . '" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left"></i></a>' : '<a id="group_petunjuk_' . $nomor_soal . '" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left"></i></a>';
						$arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';;

						$previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="group_petunjuk_' . $nomor_soal . '" rel="0" onclick="return back();" onclick="return back_group();" class="back btn btn-md btn-primary text-white">No ' . $no_previous . '</a></div>';
						$next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No ' . $no_next . '</a></div>';

						$ragu_ragu = '<div class="col" data-position="up"><a rel="1" class="ragu_ragu btn btn-md btn-warning text-white" onclick="return tidak_jawab();">Ragu</a></div>';
					}

					$button_timer_soal = $s->timer != 0 ? '<button id="btn_timer_soals_' . $nomor_soal . '" type="button" class="btn btn-primary" onclick="buka_soal_timer(' . $nomor_soal . ',' . $s->timer . ')" style="display: block;">Buka soal selama ' . $s->timer . ' Menit</button>' : '';
					$hide_soal_by_timer = $s->timer != 0 ? ' style="display: none;"' : '';

					$html .= '
						<div class="card-header bg-primary text-white">
							<div class="row">
								<div class="col">
									<h5><i class="fa fa-braille" aria-hidden="true"></i> Soal No #' . $nomor_soal . ' / ' . $jumlah_soal . '</h5>
								</div>
								<div class="col text-right">
									<a id="_increase" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _increase();"><i class="fa fa-plus-square" aria-hidden="true" title="Zoom In"></i></a>
									<a id="_reset" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _reset();"><i class="fa fa-sync" aria-hidden="true" title="Default"></i></a>
									<a id="_decrease" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _decrease();"><i class="fa fa-minus-square" aria-hidden="true" title="Zoom Out"></i></a>
									<span class="btn-nxt-brf-hrd">|</span>
									' . $arrow_back . '
									' . $arrow_next . '
								</div>
							</div>
						</div>';

					$html .= '<div class="card-body">
						<div id="timer_soals_' . $nomor_soal . '" class="card-text text-justify">' . $button_timer_soal . '</div>
						<div id="nomor_soals_' . $nomor_soal . '" class="card-text text-justify" ' . $hide_soal_by_timer . '>' . $group_soal_audio . $bacaan_soal_name . $bacaan_soal . $soal_audio . $s->bank_soal_name . '</div>
					<hr>';

					if ($s->group_mode_jwb_id == 1) {
						$text_info_soal_pilihan = $s->is_opsi_jawaban == 1 ? 'Pilih salah satu jawaban!' : 'Pilih dua jawaban!';
						$html .= '<div class="card-text mt-2">
								<p><b>' . $text_info_soal_pilihan . '</b></p>
							</div>
							<div class="funkyradio text-justify">';
						$jawaban = $this->tes->get_jawaban_by_id_user($s->bank_soal_id, $s->paket_soal_id);
						$opsi = config_item('_def_opsi_jawaban');
						$number_opsi = 1;
						foreach ($jawaban as $key_jawaban => $val_jawaban) {
							$explode_jawaban = explode(':', $arr_jawab[$s->bank_soal_id]["j"]);
							$order_jawaban_user = $val_jawaban->order;
							$fix_jawaban = array_filter($explode_jawaban, function ($number) use ($order_jawaban_user) {
								return (int) $number == $order_jawaban_user;
							});
							$checked = count($fix_jawaban) > 0 ? "checked" : "";

							$html .= '<div class="funkyradio-success">
									<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '[]" value="' . $order_jawaban_user . '|' . $number_opsi . '" onclick="get_opsi_jawaban_selected(' . $nomor_soal . ',\'' . $opsi . '\')" ' . $checked . '> 
									<label for="opsi_' . $opsi . '_' . $nomor_soal . '">
										<div class="huruf_opsi">' . $opsi . '</div>
										<div class="card-text">' . $val_jawaban->name . '</div>
									</label>
								</div>'; //onclick="return simpan_sementara();"
							$opsi++;
							$number_opsi++;
						};
						$html .= '</div>';
					} else {
						$history_jawab = !empty($arr_jawab[$s->bank_soal_id]["j"]) ? $arr_jawab[$s->bank_soal_id]["j"] : "";
						$html .= '<div class="form-group">
							<label class="card-text mt-2" for="essay_' . $nomor_soal . '">Masukkan jawaban anda dibawah ini</label>
							<textarea class="form-control" id="essay_' . $nomor_soal . '" name="essay_' . $nomor_soal . '" rows="5">' . $history_jawab . '</textarea>
						</div>';
					}

					$html .= '</div>';

					$html .= '<div class="card-footer text-muted">
							<div class="row text-center">
								' . $previous_number . '
								' . $ragu_ragu . '
								' . $next_number . '
							</div>
						</div>
					</div>';

					$nomor_soal++;

					$group_soal_before = $group_soal_next;
				}
			}

			//Get timezone user
			$user_data = $this->general->get_data_by_id($this->tbl_user, $this->session->userdata('user_id'));
			$now = date("Y-m-d H:i:s");
			$timezone = $user_data->timezone;

			//Get waktu sekarang mulai ujian
			$waktu_sekarang_datetime = new DateTime($now);
			$waktu_sekarang_timezone = $waktu_sekarang_datetime->setTimezone(new DateTimeZone($timezone));
			$waktu_sekarang = $waktu_sekarang_timezone->format(DateTime::ATOM); //ISO8601

			//Get waktu berakhir ujian
			$waktu_berakhir_datetime = new DateTime($ujian_data->tgl_selesai);
			$waktu_berakhir_timezone = $waktu_berakhir_datetime->setTimezone(new DateTimeZone($timezone));
			$waktu_berakhir = $waktu_berakhir_timezone->format(DateTime::ATOM); //ISO8601

			//for passing data to view
			$data['content']['sesi_pelaksana'] = $sesi_detail;
			$data['content']['lembar_jawaban'] = $html;
			$data['content']['ujian_id'] = $this->encryption->encrypt($ujian_data->id);
			$data['content']['random_secure'] = $random_secure;
			$data['content']['jumlah_soal'] = $nomor_soal;
			$data['content']['waktu_selesai'] = $waktu_berakhir;
			$data['content']['waktu_sekarang'] = $waktu_sekarang;
			$data['content']['audio_limit'] = $audio_limit;
			$data['content']['is_jawab'] = $paket_soal->is_jawab;
			$data['content']['is_continuous'] = $paket_soal->is_continuous;
			$data['content']['blok_layar'] = (int) $sesi_detail->blok_layar * 60;
			$data['title_header'] = ['title' => 'Lembar Ujian Online'];

			//for load view
			$view['css_additional'] = 'website/user/ujian/css';
			$view['content'] = 'website/user/ujian/content';
			$view['js_additional'] = 'website/user/ujian/js';

			//get function view website
			$this->_generate_view($view, $data);
		} catch (Exception $e) {
			$this->session->set_flashdata('portal_error', 'Terjadi kesalahan saat membuka ujian. Silahkan membuka ulang tes anda kembali <i>atau</i> Jika daftar ujian anda hilang silahkan LOGOUT dan LOGIN ulang!');
			redirect('dashboard');
		}
	}

	public function disable_ujian()
	{
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);

		// Simpan jawaban
		$tbl_ujian = $this->tbl_ujian;
		$this->general->delete_data($tbl_ujian, $id_tes);
		$this->output_json(['status' => true]);
	}

	public function simpan_satu()
	{
		try {
			$this->db->trans_begin();
			// Decrypt Id
			$id_tes = $this->encryption->decrypt($this->input->post('id', true));

			$input 	= $this->input->post(null, true);
			$d_simpan = [];
			$list_jawaban 	= "";
			for ($i = 1; $i < $input['jml_soal']; $i++) {
				$_tmode	    = "id_group_mode_jwb" . $i;
				$_imode     = $input[$_tmode];

				$_tjawabes 	= "essay_" . $i;
				$_tjawab 	= "opsi_" . $i;
				if (!empty($input[$_tjawab])) {
					if (count($input[$_tjawab]) > 0) {
						$tampung_jawaban = array();
						for ($f = 0; $f < count($input[$_tjawab]); $f++) {
							$jwb_exp = explode("|", $input[$_tjawab][$f]);
							$tampung_jawaban[] = $jwb_exp[0];
						}
						$jawab_order = implode(":", $tampung_jawaban);
					} else {
						$jawab_order = null;
					}
				} else {
					$jawab_order = null;
				}
				$_tidgroup	= "id_group_soal_" . $i;
				$_tidsoal 	= "id_bank_soal_" . $i;
				$_ragu 		= "rg_" . $i;
				$_audio_g 	= "audio_group_" . $i;
				$_audio_s	= "audio_soal_" . $i;
				if ($input[$_audio_g] != 0) {
					$audio_g_ = $input[$_audio_g];
				} else {
					$audio_g_ = 0;
				}

				if ($input[$_audio_s] != 0) {
					$audio_s_ = $input[$_audio_s];
				} else {
					$audio_s_ = 0;
				}

				if ($_imode == 1) { //1 Pilihan ganda 2 Essay
					$jawaban_ 	= empty($jawab_order) ? "" : $jawab_order;
					$list_jawaban	.= $input[$_tidgroup] . "|" . $input[$_tidsoal] . "|" . $jawaban_ . "|" . $input[$_ragu] . "|" . $audio_g_ . "|" . $audio_s_ . ",";
				} else {
					$jawaban_ 	= empty($input[$_tjawabes]) ? "" : $input[$_tjawabes];
					$list_jawaban	.= $input[$_tidgroup] . "|" . $input[$_tidsoal] . "|" . $jawaban_ . "|" . $input[$_ragu] . "|" . $audio_g_ . "|" . $_audio_s . ",";
				}
			}
			$list_jawaban	= substr($list_jawaban, 0, -1);
			$d_simpan = [
				'list_jawaban' => $list_jawaban
			];

			// Simpan jawaban
			$tbl_ujian = $this->tbl_ujian;
			$this->general->update_data($tbl_ujian, $d_simpan, $id_tes);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->output_json(['status' => "gagal"]);
			} else {
				$this->db->trans_commit();
				$this->output_json(['status' => "sukses"]);
			}
		} catch (Exception $e) {
			$this->output_json(['status' => "gagal"]);
		}
	}

	public function buka_group()
	{
		$data = [];
		$id_group = $this->input->post('id_group', true);
		$urutan = $this->input->post('urutan', true);

		$petunjuk = $this->tes->get_petunjuk_by_id($id_group);

		$data = array(
			'judul' => $petunjuk->name,
			'petunjuk' => $petunjuk->petunjuk,
			'footer' => '<button type="button" class="btn btn-primary" onclick="return buka_non_group(' . $urutan . ')">Lanjut No ' . $urutan . '</button>'
		);

		header("Content-Type: application/json");

		echo json_encode($data);
	}

	public function mulai_ujian($id_sesi_pelaksana)
	{
		$permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$generate_string = $this->generate_string($permitted_chars, 75);

		$sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

		$sesi_detail = $this->tes->get_sesi_pelaksanaan_selected($sesi_pelaksana_id); //Get Sesi Pelaksanaan
		if (empty($sesi_detail)) {
			$this->session->set_flashdata('warning', 'Sesi pelaksanaan ujian telah berakhir!');
			redirect('dashboard');
		}

		$sesi_pelaksanaan_user = $this->tes->get_sesi_pelaksanaan_user_by_sesi($sesi_pelaksana_id, $this->session->userdata('user_id'), 1); //Check sesi pelaksanaan user
		if (empty($sesi_pelaksanaan_user)) {
			$this->session->set_flashdata('warning', 'Anda tidak terdaftar dalam sesi ujian ini!');
			redirect('dashboard');
		}

		$paket_soal_id = $sesi_detail->paket_soal_id;
		$paket_soal = $this->tes->get_paket_soal_sesi_by_id($paket_soal_id); //Get Paket Soal
		if (empty($paket_soal)) {
			$this->session->set_flashdata('warning', 'Paket soal ujian tidak ditemukan. Hubungi admin!');
			redirect('dashboard');
		}

		//for passing data to view
		$data['content']['sesi_pelaksana'] = $this->tes->get_sesi_pelaksanaan_selected($sesi_pelaksana_id);
		$data['content']['id_sesi_pelaksana'] = $id_sesi_pelaksana;
		$data['content']['encrypt'] = $generate_string;
		$data['title_header'] = ['title' => 'Persiapan dan Petunjuk Pengerjaan'];

		//for load view
		$view['css_additional'] = 'website/user/ujian/css';
		$view['content'] = 'website/user/ujian/mulai_ujian/content';
		$view['js_additional'] = 'website/user/ujian/mulai_ujian/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function simpan_akhir()
	{
		try {
			$this->db->trans_begin();
			$d_update = [];
			$data_group = array();
			$data_group_skor = array();
			$ujian_skor = [];
			$data_report_ujian = [];
			$data_bank_soal = [];
			$data_combine_report = [];
			$data_ujian_report_user = [];

			// Decrypt Id
			$id_tes = $this->input->post('id', true);
			$id_tes = $this->encryption->decrypt($id_tes);

			//Get ujian
			$get_ujian_sesi = $this->tes->get_ujian_by_id($id_tes);
			if (empty($get_ujian_sesi)) {
				$this->session->set_flashdata('warning', 'Data ujian tidak ditemukan!');
				redirect('dashboard');
			}

			//Get sesi pelaksanaan
			$get_sesi_ujian = $this->tes->get_sesi_pelaksana_by_id($get_ujian_sesi->sesi_pelaksanaan_id);
			if (empty($get_sesi_ujian)) {
				$this->session->set_flashdata('warning', 'Sesi pelaksanaan ujian tidak ditemukan!');
				redirect('dashboard');
			}

			//Get paket soal dari data ujian
			$get_paket_data = $this->tes->get_paket_soal_by_tes($id_tes);
			if (empty($get_paket_data)) {
				$this->session->set_flashdata('warning', 'Paket soal didata ujian tidak ditemukan!');
				redirect('dashboard');
			}

			//Get paket soal
			$paket_soal = $this->tes->get_paket_soal_sesi_by_id($get_paket_data); //Get Paket Soal
			if (empty($paket_soal)) {
				$this->session->set_flashdata('warning', 'Paket soal ujian tidak ditemukan!');
				redirect('dashboard');
			}

			//get user id tes
			$get_user_id = $this->tes->get_user_id_by_tes($id_tes);

			//Get bank soal
			$bank_soal = $this->tes->get_all_soal_by_paketid($get_paket_data);
			if (count($bank_soal) < 0) {
				$this->session->set_flashdata('warning', 'Bank soal tidak ditemukan!');
				redirect('dashboard');
			}

			// Get Jawaban
			$list_jawaban = $this->tes->get_jawaban_ujian($id_tes);

			// Pecah Jawaban
			$pc_jawaban = explode(",", $list_jawaban);

			$jumlah_benar 	= 0;
			$jumlah_salah 	= 0;
			$jumlah_kosong  = 0;
			$jumlah_ragu    = 0;
			$skor 	        = 0;
			$jumlah_soal	= sizeof($pc_jawaban);

			foreach ($pc_jawaban as $jwb) { //Grouping Soal Jawaban
				$pc_dt 		= explode("|", $jwb);
				$group_soal = (int) $pc_dt[0];
				$id_soal 	= (int) $pc_dt[1];
				$jawaban 	= $pc_dt[2];
				$ragu 		= $pc_dt[3];
				$data_report_ujian[$id_soal] = array('group_soal_id' => $group_soal, 'jawaban' => $jawaban); //untuk kebutuhan ujian report
				$data_group[$group_soal][] = array('id_soal' => $id_soal, 'jawaban' => $jawaban, 'ragu' => $ragu);
			}

			foreach ($bank_soal as $val_bank_soal) { //all bank soal
				$data_bank_soal[$val_bank_soal->id] = array(
					'group_soal_id' => 0,
					'jawaban' => '',
					'no_soal' => $val_bank_soal->no_soal,
					'is_opsi_jawaban' => $val_bank_soal->is_opsi_jawaban
				);
			}

			$data_combine_report = array_replace_recursive($data_bank_soal, $data_report_ujian); //combine bank soal dengan jawaban peserta

			$check_report = $this->tes->check_report_ujian($get_ujian_sesi->sesi_pelaksanaan_id, $get_paket_data, $get_user_id); //cek report jika sebelumnya ada didisable

			if ($check_report) { //disable report ujian
				$deactive_report_data = array(
					'is_enable' => 0
				);
				$this->tes->disable_report_ujian($get_ujian_sesi->sesi_pelaksanaan_id, $get_paket_data, $get_user_id, $deactive_report_data);
			}

			foreach ($data_combine_report as $key_combine_r => $val_combine_r) { //data report ujian fix
				$data_ujian_report_user[] = array(
					'sesi_pelaksanaan_id' => $get_ujian_sesi->sesi_pelaksanaan_id,
					'paket_soal_id' => $get_paket_data,
					'user_id' => $get_user_id,
					'no_soal' => $val_combine_r['no_soal'],
					'group_soal_id' => $val_combine_r['group_soal_id'],
					'bank_soal_id' => $key_combine_r,
					'order_jawaban' => $val_combine_r['jawaban'],
					'is_opsi_jawaban' => $val_combine_r['is_opsi_jawaban']
				);
			}

			//Insert ujian report
			$tbl_ujian_report = $this->tbl_ujian_report;
			$this->general->input_batch($tbl_ujian_report, $data_ujian_report_user);

			$skor_total = [];
			foreach ($data_group as $key_group => $val_group) { //Grouping Skor
				$group_soal_id = $key_group;
				foreach ($val_group as $val_ungroup) {
					$cek_jwb 	= $this->tes->get_jawaban_soal($val_ungroup['id_soal']);
					$cek_score 	= $this->tes->get_jawaban_score_soal($val_ungroup['id_soal']);
					$cek_opsi_jwb 	= $this->tes->get_opsi_jawaban($val_ungroup['id_soal']);

					if ($cek_opsi_jwb == 1) { //opsi jawaban single
						$val_ungroup['jawaban'] == $cek_jwb && $val_ungroup['jawaban'] != '' ?  $jumlah_benar++ : '';
						$val_ungroup['jawaban'] != $cek_jwb && $val_ungroup['jawaban'] != '' ?  $jumlah_salah++ : '';

						//skoring
						if ($cek_score == 0 && $val_ungroup['jawaban'] == $cek_jwb && $val_ungroup['jawaban'] != '') {
							$skor += 1;
						} elseif ($cek_score != 0 && $val_ungroup['jawaban'] == $cek_jwb && $val_ungroup['jawaban'] != '') {
							$skor += $cek_score;
						}
					} elseif ($cek_opsi_jwb == 2) { //opsi jawaban multi
						$exp_multi_jwb = explode(":", $val_ungroup['jawaban']);
						count($exp_multi_jwb) > 1 && $val_ungroup['jawaban'] != '' ? $jumlah_benar++ : '';
						count($exp_multi_jwb) == 1 && $val_ungroup['jawaban'] != '' ? $jumlah_salah++ : '';

						//skoring
						if ($cek_score == 0 && count($exp_multi_jwb) > 1 && $val_ungroup['jawaban'] != '') {
							$skor += 1;
						} elseif ($cek_score != 0 && count($exp_multi_jwb) > 1 && $val_ungroup['jawaban'] != '') {
							$skor += $cek_score;
						}
					}

					$val_ungroup['jawaban'] == '' || empty($val_ungroup['jawaban']) ? $jumlah_kosong++ : $jumlah_kosong;

					$val_ungroup['ragu'] == 'Y' && $val_ungroup['jawaban'] != '' ? $jumlah_ragu++ : $jumlah_ragu;
					$skor_total[] = $skor;
				}
				$data_group_skor[$group_soal_id][] = array('skor' => end($skor_total));
				$skor = 0;
				$skor_total = [];
			}

			$group_soal_id = '';

			foreach ($data_group_skor as $key_group_skor => $val_group_skor) { //Konversi skor
				$group_soal_id = $key_group_skor;
				foreach ($val_group_skor as $sub_val_group) {
					$konversi_id = $this->tes->get_group_soal_ujian($group_soal_id);
					$skor_asal = $sub_val_group['skor'];
					$check_konversi = $this->tes->get_konversi_skor($konversi_id, $skor_asal);
					array_push($ujian_skor, array(
						'ujian_id' => $id_tes,
						'group_soal_id' => $group_soal_id,
						'skor_original' => $sub_val_group['skor'],
						'skor_konversi' => !empty($check_konversi) ? $check_konversi : $sub_val_group['skor'],
						'created_datetime' => date('Y-m-d H:i:s')
					));
				}
			}

			//Insert skor ujian
			$check_skor_ujian = $this->tes->get_ujian_skor_detail($id_tes);
			$tbl_ujian_skor = $this->tbl_ujian_skor;
			if ($check_skor_ujian) { //jika skor ujian sebelumnya sudah ada didisable dulu baru diinsert yang baru
				foreach ($check_skor_ujian as $val_data_skor) {
					$this->general->delete_data($tbl_ujian_skor, $val_data_skor->id);
				}
				$this->general->input_batch($tbl_ujian_skor, $ujian_skor);
			} else {
				$this->general->input_batch($tbl_ujian_skor, $ujian_skor);
			}

			//Final skor ujian
			$skor_total_ujian = $this->tes->get_ujian_skor_all($id_tes);
			$skala_penilaian = $paket_soal->pengaturan_universal_id;
			if ($skala_penilaian == 1) { //SKALA 100
				$final_skor = ($jumlah_benar / $jumlah_soal)  * 100;
			} elseif ($skala_penilaian == 2) { //SESUAI SKOR
				$final_skor = $skor_total_ujian;
			} elseif ($skala_penilaian == 10) { //(TOTAL SKOR / 3) x 10
				$final_skor = ($skor_total_ujian / 3) * 10;
			}

			$d_update = [
				'jml_benar'		=> $jumlah_benar,
				'jml_salah'		=> $jumlah_salah,
				'jml_ragu'		=> $jumlah_ragu,
				'jml_kosong'	=> $jumlah_kosong,
				'skor'	        => str_replace(',', '.', $final_skor),
				'status'		=> 1,
				'updated_datetime' => date('Y-m-d H:i:s')
			];

			$tbl_ujian = $this->tbl_ujian;
			$this->general->update_data($tbl_ujian, $d_update, $id_tes);

			$show_hasil = $get_sesi_ujian->is_hasil;
			$show_ranking = $get_sesi_ujian->is_ranking;

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->output_json(['status' => FALSE, 'id' => NULL, 'hasil' => NULL, 'ranking' => NULL]);
			} else {
				$this->db->trans_commit();
				$this->output_json(['status' => TRUE, 'id' => $id_tes, 'hasil' => $show_hasil, 'ranking' => $show_ranking]);
			}
		} catch (Exception $e) {
			$this->output_json(['status' => FALSE, 'id' => NULL, 'hasil' => NULL, 'ranking' => NULL]);
		}
	}

	public function ujian_berakhir()
	{
		$this->session->set_flashdata('error', 'Waktu ujian telah berakhir!');
		redirect('dashboard');
	}

	public function pembahasan($id_paket_soal, $id_ujian, $pembahasan_kunci)
	{
		$paket_soal_id = base64_decode(urldecode($id_paket_soal));
		$ujian_id = base64_decode(urldecode($id_ujian));
		$kunci_pembahasan = base64_decode(urldecode($pembahasan_kunci));

		$data = [];

		$ujian_data = $this->tes->get_checking_ujian_by_id($ujian_id); //CEK UJIAN
		if (empty($ujian_data)) {
			$this->session->set_flashdata('error', 'Anda belum diijikan melihat pembahasan!');
			redirect('dashboard');
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
			$gr     = $pc_v[0]; //Id Group
			$idx 	= $pc_v[1]; //Id Soal
			$val 	= $pc_v[2]; //Jawaban
			$rg 	= $pc_v[3]; //Ragu/Tidak

			$arr_jawab[$idx] = array("g" => $gr, "j" => $val, "r" => $rg);
		}

		$html = '';
		$previous_number = '';
		$next_number = '';
		$arrow_back = '';
		$arrow_next = '';
		$no_previous = '';
		$no_next = '';
		$group_soal_before = 0;
		if (!empty($soal_urut_ok)) {
			$nomor_soal = 1;
			$num_group_soal = 0;
			foreach ($soal_urut_ok as $s) {
				$group_soal_next = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;

				$id_group_soal_p = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;
				$group_soal_p = $s->group_soal_parent_name != 0 || !empty($s->group_soal_parent_name) ? $s->group_soal_parent_name : $s->group_soal_name;

				$bacaan_soal = $s->isi_bacaan_soal <> 0 || !empty($s->isi_bacaan_soal) ? $s->isi_bacaan_soal . '<br />' : ''; // bacaan soal
				$bacaan_soal_name = $s->bacaan_soal_name <> 0 || !empty($s->bacaan_soal_name) ? '<b>' . $s->bacaan_soal_name . '</b><br />' : ''; // bacaan soal judul

				$html .= '<div class="step card text-left font-poppins" id="widget_' . $nomor_soal . '">';
				$vrg = $arr_jawab[$s->bank_soal_id]["r"] == "" ? "N" : $arr_jawab[$s->bank_soal_id]["r"];
				$html .= '<input type="hidden" name="id_group_mode_jwb' . $nomor_soal . '" value="' . $s->group_mode_jwb_id . '">';
				$html .= '<input type="hidden" name="id_group_soal_' . $nomor_soal . '" value="' . $id_group_soal_p . '">';
				$html .= '<input type="hidden" name="group_soal_' . $nomor_soal . '" value="' . $group_soal_p . '">';
				$html .= '<input type="hidden" name="group_soal_sub_' . $nomor_soal . '" value="' . $s->group_soal_name . '">';
				$html .= '<input type="hidden" name="id_bank_soal_' . $nomor_soal . '" value="' . $s->bank_soal_id . '">';
				$html .= '<input type="hidden" name="rg_' . $nomor_soal . '" id="rg_' . $nomor_soal . '" value="' . $vrg . '">';

				$no_previous = $nomor_soal - 1;
				$no_next = $nomor_soal + 1;

				if ($group_soal_next == $group_soal_before) { //Isi Group
					$arrow_back = $nomor_soal == 1 ? '<a id="arrow_back" class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>' : '<a rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left" aria-hidden="true" title="Soal Sebelumnya"></i></a>';
					$arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true" title="Soal Berikutnya"></i></a>';

					$previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="previous_back" rel="0" onclick="return back();" class="back btn btn-md btn-primary text-white">No ' . $no_previous . '</a></div>';
					$next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No ' . $no_next . '</a></div>';

					$ragu_ragu = '<div class="col"></div>';
				} else { // Parent Group
					$num_group_soal++;
					$arrow_back = $nomor_soal == 1 ? '<a id="group_petunjuk_' . $nomor_soal . '" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left"></i></a>' : '<a id="group_petunjuk_' . $nomor_soal . '" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left"></i></a>';
					$arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';

					$previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="group_petunjuk_' . $nomor_soal . '" rel="0" onclick="return back();" onclick="return back_group();" class="back btn btn-md btn-primary text-white">No ' . $no_previous . '</a></div>';
					$next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No ' . $no_next . '</a></div>';

					$ragu_ragu = '<div class="col"></div>';
				}

				$html .= '
                    <div class="card-header bg-primary text-white">
                        <div class="row">
                            <div class="col">
                                <h5><i class="fa fa-braille" aria-hidden="true"></i> Soal No #' . $nomor_soal . ' / ' . $jumlah_soal . '</h5>
                            </div>
                            <div class="col text-right">
                                <a id="_increase" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _increase();"><i class="fa fa-plus-square" aria-hidden="true" title="Zoom In"></i></a>
                                <a id="_reset" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _reset();"><i class="fa fa-sync" aria-hidden="true" title="Default"></i></a>
                                <a id="_decrease" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _decrease();"><i class="fa fa-minus-square" aria-hidden="true" title="Zoom Out"></i></a>
                                <span class="btn-nxt-brf-hrd">|</span>
                                ' . $arrow_back . '
                                ' . $arrow_next . '
                            </div>
                        </div>
                    </div>';

				$html .= '<div class="card-body">';

				$pembahasan = $this->tes->get_pembahasan($s->bank_soal_id);
				$url_video = !empty($pembahasan->url) ? '<div class="player"><iframe width="762" height="400" src="' . $pembahasan->url . '" frameborder="0" allowfullscreen></iframe></div>' : '';
				$text_pembahasan = !empty($pembahasan->pembahasan) ? '<p>' . $pembahasan->pembahasan . '</p>' : '';
				$pembahasan = !empty($pembahasan->pembahasan) || !empty($pembahasan->url) ? '<h5>Pembahasan : </h5>' : '';

				$html .= '<div class="row">
                <center><div class="m-3">' . $pembahasan . $url_video . '</div>
                <div class="text-left m-3">' . $text_pembahasan . '</div></center>
                </div>';

				$html .= '<div class="card-text text-justify">' . $bacaan_soal_name . $bacaan_soal . $s->bank_soal_name . '</div><hr>';

				$tipe_opsi_jawaban = $this->tes->get_opsi_jawaban($s->bank_soal_id);

				$html .= '<input type="hidden" name="tipe_opsi_jawaban_' . $nomor_soal . '" value="' . $tipe_opsi_jawaban . '">';

				if ($s->group_mode_jwb_id == 1) {
					$text_info_soal_pilihan = $s->is_opsi_jawaban == 1 ? 'Pilih salah satu jawaban!' : 'Pilih dua jawaban!';
					$html .= '<div class="card-text mt-2">
						<p><b>' . $text_info_soal_pilihan . '</b></p>
                        </div>
                        <div class="funkyradio text-justify">';
					$jawaban = $this->tes->get_jawaban_by_id_pembahasan($s->bank_soal_id, $s->paket_soal_id);
					$jawaban_benar = $this->tes->get_jawaban_by_id_benar($s->bank_soal_id, $s->paket_soal_id);

					$opsi = config_item('_def_opsi_jawaban');
					$number_opsi = 1;

					if ($tipe_opsi_jawaban == 1) { //Soal Single
						if ($kunci_pembahasan == 1) {
							foreach ($jawaban as $key_jawaban => $val_jawaban) {
								$checked = $arr_jawab[$s->bank_soal_id]["j"] == $val_jawaban->order ? "checked" : "";
								if ($number_opsi != $jawaban_benar && $number_opsi != $arr_jawab[$s->bank_soal_id]["j"]) { //Selain jawaban salah dan benar
									$html .= '<div class="funkyradio-default">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '">
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" disabled> 
										<label for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								} elseif ($number_opsi == $jawaban_benar && $number_opsi == $arr_jawab[$s->bank_soal_id]["j"]) { //Jawaban benar dari user
									$html .= '<div class="funkyradio-success">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '" ' . $checked . '>
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" ' . $checked . ' disabled> 
										<label style="background:#86C186;" for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								} elseif ($number_opsi == $jawaban_benar) { //Jawaban benar dari sistem
									$html .= '<div class="funkyradio-success">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '">
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" disabled>
										<label style="background:#86C186;" for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								} elseif ($jawaban_benar != $arr_jawab[$s->bank_soal_id]["j"]) { //Jawaban salah dari user
									$html .= '<div class="funkyradio-danger">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '" ' . $checked . '>
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" ' . $checked . ' disabled> 
										<label style="background:#df706d;" for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								}
								$opsi++;
								$number_opsi++;
							};
						} else {
							foreach ($jawaban as $key_jawaban => $val_jawaban) {
								$checked = $arr_jawab[$s->bank_soal_id]["j"] == $val_jawaban->order ? "checked" : "";
								if ($number_opsi != $jawaban_benar && $number_opsi != $arr_jawab[$s->bank_soal_id]["j"]) { //Selain jawaban salah dan benar
									$html .= '<div class="funkyradio-default">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '">
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" disabled> 
										<label for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								} elseif ($number_opsi == $jawaban_benar && $number_opsi == $arr_jawab[$s->bank_soal_id]["j"]) { //Jawaban benar dari user
									$html .= '<div class="funkyradio-success">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '" ' . $checked . '>
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" ' . $checked . ' disabled> 
										<label style="background:#86C186;" for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								} elseif ($number_opsi == $jawaban_benar) { //Jawaban benar dari sistem
									$html .= '<div class="funkyradio-default">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '">
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" disabled> 
										<label for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								} elseif ($jawaban_benar != $arr_jawab[$s->bank_soal_id]["j"]) { //Jawaban salah dari user
									$html .= '<div class="funkyradio-danger">
										<input type="checkbox" style="display:none;" id="key_' . $opsi . '_' . $nomor_soal . '" name="key_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '|' . $jawaban_benar . '" ' . $checked . '>
										<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '" value="' . $val_jawaban->order . '|' . $number_opsi . '" ' . $checked . ' disabled> 
										<label style="background:#df706d;" for="opsi_' . $opsi . '_' . $nomor_soal . '">
											<div class="huruf_opsi">' . $opsi . '</div> 
											<div class="card-text">' . $val_jawaban->name . '</div>
										</label>
									</div>';
								}
								$opsi++;
								$number_opsi++;
							};
						}
					} else if ($tipe_opsi_jawaban == 2) { //Soal Multiple
						$jawaban_user = $this->tes->get_jawaban_by_id_user($s->bank_soal_id, $s->paket_soal_id);
						$opsi = config_item('_def_opsi_jawaban');
						$number_opsi = 1;
						$explode_jawaban = explode(':', $arr_jawab[$s->bank_soal_id]["j"]);
						$multi_benar_salah = count($explode_jawaban) > 1 ? 1 : 0;

						$html .= '<input type="hidden" name="opsi_multi_jawaban_' . $nomor_soal . '" value="' . $multi_benar_salah  . '">';
						foreach ($jawaban_user as $key_jawaban => $val_jawaban) {
							$order_jawaban_user = $val_jawaban->order;
							$fix_jawaban = array_filter($explode_jawaban, function ($number) use ($order_jawaban_user) {
								return (int) $number == $order_jawaban_user;
							});
							$checked = count($fix_jawaban) > 0 ? "checked" : "";

							$status_jawaban = count($explode_jawaban) > 1 ? "funkyradio-success" : "funkyradio-danger";
							$status_jwb = $checked == "checked" ? $status_jawaban : "";
							$status_isi_jawaban = count($explode_jawaban) > 1 ? 'style="background:#86C186;"' : 'style="background:#df706d;"';
							$status_isi_jwb = $checked == "checked" ? $status_isi_jawaban : "";

							$html .= '<div class="' . $status_jwb . '">
									<input type="checkbox" id="opsi_' . $opsi . '_' . $nomor_soal . '" name="opsi_' . $nomor_soal . '[]" value="' . $order_jawaban_user . '|' . $number_opsi . '" ' . $checked . '> 
									<label ' . $status_isi_jwb . ' for="opsi_' . $opsi . '_' . $nomor_soal . '">
										<div class="huruf_opsi">' . $opsi . '</div>
										<div class="card-text">' . $val_jawaban->name . '</div>
									</label>
								</div>';
							$opsi++;
							$number_opsi++;
						};
					}

					$html .= '</div>';
				} else {
					$history_jawab = !empty($arr_jawab[$s->bank_soal_id]["j"]) ? $arr_jawab[$s->bank_soal_id]["j"] : "";
					$html .= '<div class="form-group">
                        <label class="card-text mt-2" for="essay_' . $nomor_soal . '">Masukkan jawaban anda dibawah ini</label>
                        <textarea class="form-control" id="essay_' . $nomor_soal . '" name="essay_' . $nomor_soal . '" rows="5">' . $history_jawab . '</textarea>
                    </div>';
				}

				if ($tipe_opsi_jawaban == 1) {
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
					} elseif ($jawaban_benar && $jawaban_benar == 6) {
						$key_opsi = 'F';
					} elseif ($jawaban_benar && $jawaban_benar == 7) {
						$key_opsi = 'G';
					} elseif ($jawaban_benar && $jawaban_benar == 8) {
						$key_opsi = 'H';
					} elseif ($jawaban_benar && $jawaban_benar == 9) {
						$key_opsi = 'I';
					} elseif ($jawaban_benar && $jawaban_benar == 10) {
						$key_opsi = 'J';
					}

					if ($kunci_pembahasan == 1) {
						$html .= '<div class="row">
						<h5 class="card-text mt-2 ml-3">Jawaban Benar : ' . $key_opsi . '</h5>
						</div>';
					}
				} else {
					$html .= '<div class="row">
						<h6 class="card-text mt-2 ml-3">Note : Jawaban dianggap benar jika terdapat 2 jawaban</h6>
						</div>';
				}

				$html .= '</div>';

				$html .= '<div class="card-footer text-muted">
                        <div class="row text-center">
                            ' . $previous_number . '
                            ' . $ragu_ragu . '
                            ' . $next_number . '
                        </div>
                    </div>
                </div>';

				$nomor_soal++;

				$group_soal_before = $group_soal_next;
			}
		}

		//for passing data to view
		$data['content']['lembar_jawaban'] = $html;
		$data['content']['ujian'] = $ujian_data;
		$data['content']['ujian_id'] = $this->encryption->encrypt($ujian_data->id);
		$data['content']['jumlah_soal'] = $nomor_soal;
		$data['title_header'] = ['title' => 'Pembahasan Ujian Online'];

		//for load view
		$view['css_additional'] = 'website/user/ujian/css';
		$view['content'] = 'website/user/ujian/pembahasan/content';
		$view['js_additional'] = 'website/user/ujian/pembahasan/js';

		//get function view website
		$this->_generate_view($view, $data);
	}

	public function hasil_ujian($ujian_id, $show_ranking)
	{
		$ujian_data = $this->tes->get_checking_ujian_by_id($ujian_id); //CEK UJIAN
		$sesi_detail = $this->tes->get_sesi_pelaksana_by_id($ujian_data->sesi_pelaksanaan_id); //Get Sesi Pelaksanaan
		$total_user_ujian = $this->tes->get_total_user_ujian($ujian_data->sesi_pelaksanaan_id, $ujian_data->paket_soal_id); //CEK UJIAN
		$ranking_user = $this->tes->get_ranking_ujian_user($ujian_id); //CEK UJIAN

		$data['content']['sesi_pelaksana'] = $sesi_detail;
		$data['content']['is_ranking'] = $show_ranking;
		$data['content']['ujian'] = $ujian_data;
		$data['content']['total_user'] = $total_user_ujian->total_user_ujian;
		$data['content']['ranking_user'] = $ranking_user->ranking;
		$data['title_header'] = ['title' => 'Hasil Ujian Online'];

		//for load view
		$view['css_additional'] = 'website/user/ujian/result/css';
		$view['content'] = 'website/user/ujian/result/content';
		$view['js_additional'] = 'website/user/ujian/result/js';

		//get function view website
		$this->_generate_view($view, $data);
	}
}
