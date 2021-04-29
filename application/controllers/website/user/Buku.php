<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    private $length_pass = 15;
    private $sbmptn_id = 2;
    private $toefl_id = 1;
    private $cpns_id = 3;

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login_user')){
            redirect('login');
        }
        $this->load->library('encryption');
        $this->load->model('General','general');
        $this->load->model('Tes_online_model','tes');
        $this->load->model('Management_model','management');
    }

    /*
    |
    | START FUNCTION IN THIS CONTROLLER
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

    public function sbmptn(){
        $user_id = $this->session->userdata('user_id');
        $sbmptn_id = $this->sbmptn_id;

        $get_check_invoice = $this->management->get_user_status_buku($sbmptn_id, $user_id);
        $get_check_paket = $this->management->get_config_buku_by_buku($sbmptn_id);

        $jurusan = !empty($get_check_invoice->detail_buku_id) ? $get_check_invoice->detail_buku_id : NULL ;
        $free_paket = $get_check_paket->free_paket;
        $price = $get_check_paket->price;

        //for passing data to view
        if(!empty($get_check_invoice)){
            $free_paket = NULL;
            $data['content']['sbmptn_paket'] = $this->tes->get_paket_soal_buku($sbmptn_id, $jurusan, $free_paket);
        } else {
            $data['content']['sbmptn_paket'] = $this->tes->get_paket_soal_buku($sbmptn_id, $jurusan, $free_paket);
        }
        $data['content']['status_user'] = !empty($get_check_invoice) ? 'purchase' : 'free';
        $data['content']['free_paket'] = $free_paket;
        $data['title_header'] = ['title' => 'Lembar Ujian Online'];

        //for load view
        $view['css_additional'] = 'website/user/buku/sbmptn/css';
        $view['content'] = 'website/user/buku/sbmptn/content';
        $view['js_additional'] = 'website/user/buku/sbmptn/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

}