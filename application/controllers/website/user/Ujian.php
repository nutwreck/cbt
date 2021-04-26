<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

    private $length_pass = 15;
    private $tbl_ujian = 'ujian';

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login_user')){
            redirect('login');
        }
        $this->load->library('encryption');
        $this->load->model('General','general');
        $this->load->model('Tes_online_model','tes');
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

    private function _generate_view($view, $data){
        $this->load->view('website/user/_template/header', $data['title_header']);
        $this->load->view($view['css_additional']);
        $this->load->view('website/user/_template/content');
        $this->load->view('website/user/_template/sidebar');
        $this->load->view($view['content'], $data['content']);
        $this->load->view('website/user/_template/js_main');
        $this->load->view($view['js_additional']);
        $this->load->view('website/user/_template/footer');
    }

    private function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
    
        return $random_string;
    }

    public function output_json($data, $encode = true)
	{
        if($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
	}

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function portal_tes($id_sesi_pelaksana, $random_secure){
        $data_ujian = [];
        $bank_soal = [];
        $data = [];

        $sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

        $sesi_detail = $this->tes->get_sesi_pelaksanaan_selected($sesi_pelaksana_id);//Get Sesi Pelaksanaan
        $paket_soal_id = $sesi_detail->paket_soal_id;
        $paket_soal = $this->tes->get_paket_soal_sesi_by_id($paket_soal_id); //Get Paket Soal
        $ujian_data = $this->tes->get_checking_ujian($paket_soal_id, $this->session->userdata('user_id')); //CEK SEBELUMNYA UDH PERNAH TES ATAU BELUM

        if(empty($ujian_data)){ //jika wadah untuk pemilihan soal dan jawaban belum ada
            $komposisi_soal = $this->tes->get_komposisi_soal_by_id($sesi_pelaksana_id);//Ambil bank soal
            
            $data_ujian['sesi_pelaksanaan_id'] = $sesi_pelaksana_id;
            $data_ujian['paket_soal_id'] = $paket_soal_id;
            $data_ujian['user_id'] = $this->session->userdata('user_id');
            $data_ujian['user_no'] = $this->session->userdata('no_peserta');
            $data_ujian['user_name'] = $this->session->userdata('peserta_name');
            $data_ujian['user_email'] = $this->session->userdata('username');
            $now = date('Y-m-d H:i:s');
            $data_ujian['tgl_mulai'] = $now;
            $data_ujian['tgl_selesai'] = date("Y-m-d H:i:s", strtotime($now. ' + '.$sesi_detail->lama_pengerjaan.' minutes'));

            foreach($komposisi_soal as $val_komposisi){ //Membuat komposisi soal
                $bank_soal[$val_komposisi->id_group_soal] = $this->tes->get_bank_soal_ujian($val_komposisi->paket_soal_id, $val_komposisi->id_group_soal, $val_komposisi->total_soal);
            }
    
            $list_id_soal	= "";
            $list_jw_soal 	= "";
            if (!empty($bank_soal)) {
                foreach($bank_soal as $key_soal => $val_soal){ //membuat wadah untuk list soal dan tempat jawabannya
                    $group_soal_key = $key_soal;
                    foreach($val_soal as $val_deep_soal){
                        $list_id_soal .= $group_soal_key."|".$val_deep_soal['bank_soal_id'].",";
                        $list_jw_soal .= $group_soal_key."|".$val_deep_soal['bank_soal_id']."||N,";
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

            if($input_docker_soal){ //jika data tempat ujian sudah terbuat
                redirect('ujian/'.$id_sesi_pelaksana.'/'.$random_secure, 'location', 301); //refresh halaman agar dimulai lagi dari awal
            } else {
                $this->session->set_flashdata('warning', 'Terjadi kesalahan saat persiapan ujian silahkan ulangi lagi!');
                redirect('dashboard');
            }
        }

        //Pengambilan data list jawaban, group soal, soalnya, dan hasil jawabannya
        $urut_soal 		= explode(",", $ujian_data->list_jawaban);
        $soal_urut_ok	= array();
        $jumlah_soal    = sizeof($urut_soal);
		for ($i = 0; $i < sizeof($urut_soal); $i++) {
			$pc_urut_soal	    = explode("|",$urut_soal[$i]);//pecah data wadah list jawaban
			$pc_urut_soal_jwb 	= empty($pc_urut_soal[2]) ? "''" : "'{$pc_urut_soal[2]}'";//List jawaban user
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

			$arr_jawab[$idx] = array("g"=>$gr,"j"=>$val,"r"=>$rg);
        }

        $show_soal = [];
        $html = '';
        $previous_number = '';
        $next_number = '';
        $arrow_back = '';
        $arrow_next = '';
        $no_previous = '';
        $no_next = '';
        $group_soal_before = 0;
        if (!empty($soal_urut_ok)){
            $nomor_soal = 1;
            $num_group_soal = 0;
            foreach ($soal_urut_ok as $s) {
                $group_soal_next = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;

                $id_group_soal_p = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;

                $cek_group_mode_jwb = $s->group_mode_jwb_id == 1 ? '' : 'style="display:none;"'; //1 Pilihan ganda 2 essay
                $bacaan_soal = $s->isi_bacaan_soal <> 0 || !empty($s->isi_bacaan_soal) ? $s->isi_bacaan_soal.'<br />' : ''; // bacaan soal
                $bacaan_soal_name = $s->bacaan_soal_name <> 0 || !empty($s->bacaan_soal_name) ? '<b>'.$s->bacaan_soal_name.'</b><br />' : ''; // bacaan soal judul
                $group_soal_petunjuk = $s->group_soal_petunjuk <> 0 || !empty($s->group_soal_petunjuk) ? $s->group_soal_petunjuk.'<br />' : '';
                $group_soal_audio = $s->group_soal_audio <> 0 || !empty($s->group_soal_audio) ? '<audio id="loop-limited-'.$nomor_soal.'" controls><source src="'.config_item('_dir_website').'/lembaga/grandsbmptn/group_soal/group_'.$s->paket_soal_id.'/'.$s->group_soal_audio.'" type="'.$s->group_soal_tipe_audio.'">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : '';
                $soal_audio = $s->file <> 0 || !empty($s->file) ? '<audio id="loop-limited-'.$nomor_soal.'" controls><source src="'.config_item('_dir_website').'/lembaga/grandsbmptn/paket_soal/soal_'.$s->paket_soal_id.'/'.$s->file.'" type="'.$s->tipe_file.'">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : '';
                
                $html .= '<div class="step card text-left font-poppins" id="widget_'.$nomor_soal.'">';
                $vrg = $arr_jawab[$s->bank_soal_id]["r"] == "" ? "N" : $arr_jawab[$s->bank_soal_id]["r"];
                $html .= '<input type="hidden" name="id_group_mode_jwb'.$nomor_soal.'" value="'.$s->group_mode_jwb_id.'">';
                $html .= '<input type="hidden" name="id_group_soal_'.$nomor_soal.'" value="'.$id_group_soal_p.'">';
				$html .= '<input type="hidden" name="id_bank_soal_'.$nomor_soal.'" value="'.$s->bank_soal_id.'">';
				$html .= '<input type="hidden" name="rg_'.$nomor_soal.'" id="rg_'.$nomor_soal.'" value="'.$vrg.'">';
                
                $no_previous = $nomor_soal-1;
                $no_next = $nomor_soal+1;

                if($group_soal_next == $group_soal_before){ //Isi Group
                    $arrow_back = $nomor_soal == 1 ? '<a id="arrow_back" class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>' : '<a rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left" aria-hidden="true" title="Soal Sebelumnya"></i></a>';
                    $arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true" title="Soal Berikutnya"></i></a>';
                    
                    $previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="previous_back" rel="0" onclick="return back();" class="back btn btn-md btn-primary text-white">No '.$no_previous.'</a></div>';
                    $next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No '.$no_next.'</a></div>';

                    $ragu_ragu = '<div class="col" data-position="up"><a rel="1" class="ragu_ragu btn btn-md btn-warning text-white" onclick="return tidak_jawab();">Ragu</a></div>';
                } else { // Parent Group
                    $num_group_soal++;
                    $arrow_back = $nomor_soal == 1 ? '<a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left"></i></a>' : '<a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left"></i></a>';
                    $arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';;

                    $previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" onclick="return back_group();" class="back btn btn-md btn-primary text-white">No '.$no_previous.'</a></div>';
                    $next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No '.$no_next.'</a></div>';
                    
                    $ragu_ragu = '<div class="col" data-position="up"><a rel="1" class="ragu_ragu btn btn-md btn-warning text-white" onclick="return tidak_jawab();">Ragu</a></div>';
                }

                $group_soal_name = $s->group_soal_name <> 0 || !empty($s->group_soal_name) ? '<b> GROUP '.$s->group_soal_name.' (G'.$num_group_soal.')</b><br /><br />' : '';

                $html .= '
                    <div class="card-header bg-primary text-white">
                        <div class="row">
                            <div class="col">
                                <h5><i class="fa fa-braille" aria-hidden="true"></i> Soal No #'.$nomor_soal.' / '.$jumlah_soal.'</h5>
                            </div>
                            <div class="col text-right">
                                <a id="_increase" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _increase();"><i class="fa fa-plus-square" aria-hidden="true" title="Zoom In"></i></a>
                                <a id="_reset" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _reset();"><i class="fa fa-sync" aria-hidden="true" title="Default"></i></a>
                                <a id="_decrease" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _decrease();"><i class="fa fa-minus-square" aria-hidden="true" title="Zoom Out"></i></a>
                                <span class="btn-nxt-brf-hrd">|</span>
                                '.$arrow_back.'
                                '.$arrow_next.'
                            </div>
                        </div>
                    </div>';

                $html .= '<div class="card-body">
                    <div class="card-text text-justify">'.$group_soal_name.$group_soal_audio.$bacaan_soal_name.$bacaan_soal.$soal_audio.$s->bank_soal_name.'</div><hr>';

                if($s->group_mode_jwb_id == 1){
                    $html .= '<div class="card-text mt-2">
                            <p><b>Pilih salah satu jawaban!</b></p>
                        </div>
                        <div class="funkyradio text-justify">';
                    $jawaban = $this->tes->get_jawaban_by_id_user($s->bank_soal_id, $s->paket_soal_id);
                    $opsi = config_item('_def_opsi_jawaban');
                    $jawaban_soal = [];
                    $number_opsi = 1;
                    foreach($jawaban as $key_jawaban => $val_jawaban) {
                        $checked = $arr_jawab[$s->bank_soal_id]["j"] == $val_jawaban->order ? "checked" : "";
                        $html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
                                <input type="radio" id="opsi_'.$opsi.'_'.$nomor_soal.'" name="opsi_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'" '.$checked.'> 
                                <label for="opsi_'.$opsi.'_'.$nomor_soal.'">
                                    <div class="huruf_opsi">'.$opsi.'</div> 
                                    <div class="card-text">'.$val_jawaban->name.'</div>
                                </label>
                            </div>';
                        $opsi++;
                        $number_opsi++;
                    };
                    $html .= '</div>';
                } else{
                    $history_jawab = !empty($arr_jawab[$s->bank_soal_id]["j"]) ? $arr_jawab[$s->bank_soal_id]["j"] : "";
                    $html .= '<div class="form-group">
                        <label class="card-text mt-2" for="essay_'.$nomor_soal.'">Masukkan jawaban anda dibawah ini</label>
                        <textarea class="form-control" id="essay_'.$nomor_soal.'" name="essay_'.$nomor_soal.'" rows="5">'.$history_jawab.'</textarea>
                    </div>';
                }

                $html .= '</div>';

                $html .= '<div class="card-footer text-muted">
                        <div class="row text-center">
                            '.$previous_number.'
                            '.$ragu_ragu.'
                            '.$next_number.'
                        </div>
                    </div>
                </div>';

                $nomor_soal++;

                $group_soal_before = $group_soal_next;
            }
        }

        /* echo '<pre>';
        var_dump($html);die(); */
        
        //for passing data to view
        $data['content']['sesi_pelaksana'] = $sesi_detail;
        $data['content']['lembar_jawaban'] = $html;
        $data['content']['ujian_id'] = $this->encryption->encrypt($ujian_data->id);
        $data['content']['random_secure'] = $random_secure;
        $data['content']['jumlah_soal'] = $nomor_soal;
        $data['content']['waktu_selesai'] = $ujian_data->tgl_selesai;
        $data['content']['audio_limit'] = $paket_soal->visual_limit;
        $data['content']['is_jawab'] = $paket_soal->is_jawab;
        $data['content']['is_continuous'] = $paket_soal->is_continuous;
        $data['content']['blok_layar'] = (int) $sesi_detail->blok_layar*60;
        $data['title_header'] = ['title' => 'Lembar Ujian Online'];

        //for load view
        $view['css_additional'] = 'website/user/ujian/css';
        $view['content'] = 'website/user/ujian/content';
        $view['js_additional'] = 'website/user/ujian/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function simpan_satu(){
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);
		
        $input 	= $this->input->post(null, true);
        $d_simpan = [];
		$list_jawaban 	= "";
		for ($i = 1; $i < $input['jml_soal']; $i++) {
            $_tmode	    = "id_group_mode_jwb".$i;
            $_imode     = $input[$_tmode];
            
            $_tjawabes 	= "essay_".$i;
            $_tjawab 	= "opsi_".$i;
            $jwb_exp = explode("|", $input[$_tjawab]);
            $jawab_order = $jwb_exp[0];
            $_tidgroup	= "id_group_soal_".$i;
			$_tidsoal 	= "id_bank_soal_".$i;
			$_ragu 		= "rg_".$i;
            if($_imode == 1){ //1 Pilihan ganda 2 Essay
                $jawaban_ 	= empty($jawab_order) ? "" : $jawab_order;
                $list_jawaban	.= $input[$_tidgroup]."|".$input[$_tidsoal]."|".$jawaban_."|".$input[$_ragu].",";
            } else {
                $jawaban_ 	= empty($input[$_tjawabes]) ? "" : $input[$_tjawabes];
                $list_jawaban	.= $input[$_tidgroup]."|".$input[$_tidsoal]."|".$jawaban_."|".$input[$_ragu].",";
            }
		}
		$list_jawaban	= substr($list_jawaban, 0, -1);
		$d_simpan = [
			'list_jawaban' => $list_jawaban
        ];
		
        // Simpan jawaban
        $tbl = $this->tbl_ujian;
		$this->general->update_data($tbl, $d_simpan, $id_tes);
		$this->output_json(['status'=>true]);
    }
    
    public function buka_group(){
        $data = [];
        $id_group = $this->input->post('id_group', true);
        $urutan = $this->input->post('urutan', true);

        $petunjuk = $this->tes->get_petunjuk_by_id($id_group);

        $data = array(
            'judul' => $petunjuk->name.' (G'.$urutan.')',
            'petunjuk' => $petunjuk->petunjuk,
            'footer' => '<button type="button" class="btn btn-primary" onclick="return buka_non_group('.$urutan.')">Lanjut No '.$urutan.'</button>'
        );
        
        header("Content-Type: application/json");

        echo json_encode($data);
    }

    public function mulai_ujian($id_sesi_pelaksana){
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $generate_string = $this->generate_string($permitted_chars, 175);

        $sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));
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

    public function simpan_akhir(){
        $d_update = [];
        // Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);
		
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

		foreach ($pc_jawaban as $jwb) {
            $pc_dt 		= explode("|", $jwb);
            $group_soal = $pc_dt[0];
			$id_soal 	= (int) $pc_dt[1];
			$jawaban 	= $pc_dt[2];
            $ragu 		= $pc_dt[3];

            $cek_jwb 	= $this->tes->get_jawaban_soal($id_soal);
            $cek_score 	= $this->tes->get_jawaban_score_soal($id_soal);

            $dataaa[] = $cek_score;

            $jawaban == $cek_jwb ?  $jumlah_benar++ : $jumlah_salah++;

            $cek_score == 0 && $jawaban == $cek_jwb ? $skor++ : $skor+$cek_score;
            $cek_score != 0 && $jawaban == $cek_jwb ? $skor++ : '';

            $jawaban == '' || empty($jawaban) ? $jumlah_kosong++ : $jumlah_kosong;

            $ragu == 'Y' && $jawaban != '' ? $jumlah_ragu++ : $jumlah_ragu;
        }

		/* $nilai = ($jumlah_benar / $jumlah_soal)  * 100;
		$nilai_bobot = ($total_bobot / $jumlah_soal)  * 100; */

		$d_update = [
			'jml_benar'		=> $jumlah_benar,
			'jml_salah'		=> $jumlah_salah,
			'jml_ragu'		=> $jumlah_ragu,
			'jml_kosong'	=> $jumlah_kosong,
			'skor'			=> $skor,
			'status'		=> 1
        ];

		$this->general->update_data('ujian', $d_update, $id_tes);
		$this->output_json(['status'=>TRUE, 'data'=>$d_update, 'id'=>$id_tes]);
    }

    public function ujian_berakhir(){
        $this->session->set_flashdata('error', 'Waktu ujian telah berakhir!');
        redirect('dashboard');
    }

}