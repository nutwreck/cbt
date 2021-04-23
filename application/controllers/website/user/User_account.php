<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_account extends CI_Controller {
    
    private $length_pass = 6;

    public function __construct(){
        parent::__construct();
        $this->load->library('encryption');
        $this->load->model('General','general');
        $this->load->model('User_model','user');
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
        $this->load->view('website/user/_template/footer');
    }
    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function user_account(){
        $id = $this->session->userdata('user_id');
        
        $data['content']['data_user'] = $this->user->get_data_user_by_id($id);
        $data['title_header'] = ['title' => 'Akun User'];

        //for load view
        $view['css_additional'] = 'website/user/login/account/css';
        $view['menu_header'] = 'website/user/_template/menu';
        $view['content'] = 'website/user/login/account/content';
      
        $this->_generate_view($view, $data);
    }

    public function submit_edit_account(){
        $data_user = [];
        $data_peserta = [];

        //User
        $id_user = $this->input->post('id');
        $new_pass = $this->input->post('password');
        $encript_pass = $this->encryption->encrypt($new_pass);
        $data_user['password'] = $encript_pass;

        //Peserta
        $id_peserta = $this->input->post('id_peserta');
        $data_peserta['name'] = $this->input->post('name', TRUE);
        $data_peserta['no_telp'] = $this->input->post('phone', TRUE);

        $update = $this->user->update_peserta_tes($data_user, $id_user, $data_peserta, $id_peserta);

        if($update){
            $newdata = array(
                'peserta_name' => $data_peserta['name'],
            );
            $this->session->set_userdata($newdata);

            $this->session->set_flashdata('success', 'Data akun berhasil diperbarui');
            redirect("account");
        } else {
            $this->session->set_flashdata('error', 'Data akun gagal diperbarui!');
            redirect("account");
        }
    }

}