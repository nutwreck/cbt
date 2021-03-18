<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes_online extends CI_Controller {

    public function __construct(){
          parent::__construct();
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

    private function _generate_view($view, $data){
        $this->load->view('website/lembaga/_template/header', $data['title_header']);
        $this->load->view($view['css_additional']);
        $this->load->view('website/lembaga/_template/menu');
        $this->load->view('website/lembaga/_template/sidebar');
        $this->load->view($view['content'], $data['content']);
        $this->load->view('website/lembaga/_template/footer');
        $this->load->view('website/lembaga/_template/js_main');
        $this->load->view($view['js_additional']);
        $this->load->view('website/lembaga/_template/end_page');
    }

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function materi(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Materi'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/materi/css';
        $view['content'] = 'website/lembaga/tes_online/materi/content';
        $view['js_additional'] = 'website/lembaga/tes_online/materi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function paket_soal(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Paket Soal'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
        $view['content'] = 'website/lembaga/tes_online/paket_soal/content';
        $view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

}