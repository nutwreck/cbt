<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
            redirect('admin/login');
        }
        $this->load->model('General','general');
        $this->load->model('Tes_online_model','tes');
        $this->load->model('Management_model','management');
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

    public function index(){
        //for passing data to view
        $data['content']['total_event'] = $this->management->get_total_event();
        $data['content']['total_paket_soal'] = $this->tes->get_total_paket_soal();
        $data['content']['total_peserta'] = $this->tes->get_total_peserta();
        $data['title_header'] = ['title' => 'Portal Lembaga'];

        //for load view
        $view['css_additional'] = 'website/lembaga/dashboard/css';
        $view['content'] = 'website/lembaga/dashboard/content';
        $view['js_additional'] = 'website/lembaga/dashboard/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function logout(){
        //update is login
        /* $tbl = 'user';

        $datas = array(
            'is_login' => 0
        );

        $id =  $this->session->userdata('user_id');
        $this->general->update_data($tbl, $datas, $id); */

        $this->session->sess_destroy();
        redirect("admin/login");
    }

}
