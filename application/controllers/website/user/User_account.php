<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_account extends CI_Controller {
    
    
    private $length_pass = 6;

    public function __construct(){
        parent::__construct();
        $this->load->library('encryption');
        $this->load->model('General','general');
        $this->load->model('User_model','user');
        $this->load->config('email');
    }



     private function _generate_view($view, $data){
        $this->load->view('website/user/_template/header', $data['title_header']);
        $this->load->view($view['css_additional']);
        $this->load->view('website/user/_template/content');
        $this->load->view('website/user/_template/sidebar');
        $this->load->view($view['content'], $data['content']);
        $this->load->view('website/user/_template/js_main');
        //$this->load->view($view['js_additional']);
        $this->load->view('website/user/_template/footer');
    }
    /*
    |
    | START FUNCTION IN THIS CONTROLLER
    |
    */

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function index(){
        $this->load->view('website/user/login/home/content');
    }

    public function user_account(){
        
        $id = $this->session->userdata('user_id');
        
        $data['content']['data_user'] = $this->user->get_data_user_by_id($id);
        $data['title_header'] = ['title' => 'Daftar History Ujian'];

        //for load view
        $view['css_additional'] = 'website/user/login/account/css';
        $view['menu_header'] = 'website/user/_template/menu';
        $view['content'] = 'website/user/login/account/content';
      
        $this->_generate_view($view, $data);
    }

    public function submit_edit_password(){
        $id = $this->input->post('id');
       // $id_buku = $konversi_id = base64_decode(urldecode($buku_id_crypt));

      //  $data['username'] = $this->input->post('name', TRUE);
        $new_pass = $this->input->post('password');
        $encript_pass = $this->encryption->encrypt($new_pass);
     //   var_dump($new_pass);die();
        $data['password'] = $encript_pass;

        $tbl = 'user';

        $update = $this->general->update_data($tbl, $data, $id);
        $this->session->set_flashdata('success', 'Password sudah diperbarui');
        redirect("account");
       
    }
  /*   public function history_ujian(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Daftar History Ujian'];

        //for load view
        $view['css_additional'] = 'website/user/history_ujian/css';
        $view['menu_header'] = 'website/user/_template/menu';
        $view['content'] = 'website/user/history_ujian/content';
        $view['js_additional'] = 'website/user/history_ujian/js';

        //get function view website
        $this->_generate_view($view, $data);
    } */
    
    public function logout(){
        $this->session->sess_destroy();
        redirect("login");
    }
}