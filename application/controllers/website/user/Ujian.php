<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

    private $length_pass = 15;

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
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


    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function portal_tes($id_sesi_pelaksana){
        $data_ujian = [];
        $bank_soal = [];

        $sesi_pelaksana_id = base64_decode(urldecode($id_sesi_pelaksana));

        $sesi_detail = $this->tes->get_sesi_pelaksanaan_selected($sesi_pelaksana_id);//Get Sesi Pelaksanaan
        $paket_soal_id = $sesi_detail->paket_soal_id;
        $paket_soal = $this->tes->get_paket_soal_sesi_by_id($paket_soal_id); //Get Paket Soal
        $komposisi_soal = $this->tes->get_komposisi_soal_by_id($sesi_pelaksana_id);
        $check_tes = $this->tes->get_checking_ujian($paket_soal_id, $this->session->userdata('user_id')); //CEK SEBELUMNYA UDH PERNAH TES ATAU BELUM

        foreach($komposisi_soal as $val_komposisi){ //Membuat komposisi soal
            $bank_soal[$val_komposisi->id_group_soal] = $this->tes->get_bank_soal_ujian($val_komposisi->paket_soal_id, $val_komposisi->id_group_soal, $val_komposisi->total_soal);
        }

        $list_id_soal	= "";
        $list_jw_soal 	= "";
        if (!empty($bank_soal)) {
            foreach($bank_soal as $key_soal => $val_soal){
                $group_soal_key = $key_soal;
                foreach($val_soal as $val_deep_soal){
                    $list_id_soal .= $group_soal_key.":".$val_deep_soal['bank_soal_id'].",";
                    $list_jw_soal .= $group_soal_key.":".$val_deep_soal['bank_soal_id']."::N,";
                }
            }
        }

        echo '<pre>';
        var_dump($list_id_soal);die();

        if(empty($check_tes)){
            $data_ujian['sesi_pelaksanaan_id'] = $sesi_pelaksana_id;
            $data_ujian['paket_soal_id'] = $paket_soal_id;
            $data_ujian['user_id'] = $this->session->userdata('user_id');
            $data_ujian['user_no'] = $this->session->userdata('no_peserta');
            $data_ujian['user_name'] = $this->session->userdata('peserta_name');
            $data_ujian['user_email'] = $this->session->userdata('user_id');
            $now = date('Y-m-d H:i:s');
            $data_ujian['tgl_mulai'] = $now;
            $data_ujian['tgl_selesai'] = date("Y-m-d H:i:s", strtotime($now. ' + '.$sesi_detail->lama_pengerjaan.' minutes'));
        }
        
        //for passing data to view
        $data['content']['sesi_pelaksana'] = $sesi_detail;
        $data['title_header'] = ['title' => 'Ujian Online'];

        //for load view
        $view['css_additional'] = 'website/user/ujian/css';
        $view['content'] = 'website/user/ujian/content';
        $view['js_additional'] = 'website/user/ujian/js';

        //get function view website
        $this->_generate_view($view, $data);
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

}