<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_setting extends CI_Controller {

    /**
	 * Author : Candra Aji Pamungkas
     * Create : 18-03-2021
     * Change :
     *      - {date} | {description}
	 */

    private $tbl_buku = 'buku'; //SET TABEL KONVERSI
    private $tbl_config_buku = 'config_buku';

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
            redirect('admin/login');
        }
        $this->load->model('General','general');
        $this->load->model('Config_buku_model','buku_config');
    }

    /*
    |
    | START FUNCTION IN THIS CONTROLLER
    |
    */



    private function _generate_view($view, $data){
        $this->load->view('website/lembaga/_template/header', $data['title_header']);
        if(!empty($view['css_additional'])){
            $this->load->view($view['css_additional']);
        } else {

        }
        $this->load->view('website/lembaga/_template/menu');
        $this->load->view('website/lembaga/_template/sidebar');
        $this->load->view($view['content'], !empty($data['content']) ? $data['content'] : []);
        $this->load->view('website/lembaga/_template/footer');
        $this->load->view('website/lembaga/_template/js_main');
        if(!empty($view['js_additional'])){
            $this->load->view($view['js_additional']);
        } else {

        }
        $this->load->view('website/lembaga/_template/end_page');
    }

    public function setting_buku(){
        //for passing data to view
        $data['content']['buku_data'] = $this->buku_config->get_buku_config();
        $data['title_header'] = ['title' => 'Buku Setting'];

        //for load view
        $view['css_additional'] = 'website/lembaga/Buku_setting/css';
        $view['content'] = 'website/lembaga/Buku_setting/content';
        $view['js_additional'] = 'website/lembaga/Buku_setting/js';
     
        //get function view website
        $this->_generate_view($view, $data);
    }
   
    public function setting_buku_detail($id_buku){
        $id = $buku_id = base64_decode(urldecode($id_buku));

        //for passing data to view
        $data['content']['detail_buku'] = $this->buku_config->get_detail_buku_by_buku($id);
        $data['content']['id_bukui'] = $id_buku;
        $data['title_header'] = ['title' => 'Detail Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/Buku_setting/css';
        $view['content'] = 'website/lembaga/Buku_setting/detail';
        $view['js_additional'] = 'website/lembaga/Buku_setting/js';

        //get function view website
        $this->_generate_view($view, $data);
    }
   
   
   
}