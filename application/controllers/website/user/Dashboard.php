<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata('has_login_user')) {
            redirect('login');
        }

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
    |  $this->load->view('website/user/_template/menu'); --> Header menu main (flexible - can replace)
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

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function index()
    {
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $generate_string = $this->generate_string($permitted_chars, 175);

        $user_id = $this->session->userdata('user_id');
        //for passing data to view
        $data['content']['sesi_pelaksana'] = $this->tes->get_sesi_pelaksanaan_existing($user_id);
        $data['content']['encrypt'] = $generate_string;
        $data['title_header'] = ['title' => 'Daftar Sesi Ujian'];

        //for load view
        $view['css_additional'] = 'website/user/dashboard/css';
        $view['content'] = 'website/user/dashboard/content';
        $view['js_additional'] = 'website/user/dashboard/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function history_ujian()
    {
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $generate_string = $this->generate_string($permitted_chars, 175);

        $user_id = $this->session->userdata('user_id');
        //for passing data to view
        $data['content']['sesi_pelaksana'] = $this->tes->get_sesi_pelaksanaan_past($user_id);
        $data['content']['encrypt'] = $generate_string;
        $data['title_header'] = ['title' => 'Daftar History Ujian'];

        //for load view
        $view['css_additional'] = 'website/user/history_ujian/css';
        $view['menu_header'] = 'website/user/_template/menu';
        $view['content'] = 'website/user/history_ujian/content';
        $view['js_additional'] = 'website/user/history_ujian/js';

        //get function view website
        $this->_generate_view($view, $data);
    }
}
