<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
	{
		parent::__construct();
        $this->load->library('encryption');
		$this->load->model('General','general');
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }
    
    public function index(){
        $this->load->view('website/lembaga/login');
    }

    public function submit_login(){
        $data['username'] = $this->input->post('username', TRUE);
        $data['password'] = $this->input->post('password', TRUE);

        $data['login_admin'] = $this->general->login_admin($data);
        
       /*  if($data['login_admin'][0]['is_login'] == 1){
            $this->session->set_flashdata('info', 'Akun terdeteksi masih login dikomputer lain, harap di logout terlebih dahulu');
            redirect('admin/login');
        } else { */
        $decode = $this->encryption->decrypt($data['login_admin'][0]['password']);

        if($data['login_admin'] && $decode == $data['password']){
            $newdata = array(
                    'user_id' => $data['login_admin'][0]['user_id'],
                    'is_login' => $data['login_admin'][0]['is_login'],
                    'lembaga_user_id' => $data['login_admin'][0]['lembaga_user_id'],
                    'lembaga_id' => $data['login_admin'][0]['lembaga_id'],
                    'lembaga_name' => $data['login_admin'][0]['lembaga_name'],
                    'lembaga_type_name' => $data['login_admin'][0]['lembaga_type_name'],
                    'lembaga_user_name' => $data['login_admin'][0]['lembaga_user_name'],
                    'username' => $data['login_admin'][0]['username'],
                    'lembaga_user_email' => $data['login_admin'][0]['lembaga_user_email'],
                    'has_login' => 1
            );

            $this->session->set_userdata($newdata);
            session_start();

            $this->session->set_flashdata('success', 'Selamat Datang '.$data['login_admin'][0]['lembaga_user_name']);
            
            /* //update is login
            $tbl = 'user';

            $datas = array(
                'is_login' => 1
            );

            $id =  $data['login_admin'][0]['id_user'];

            $this->general->update_data($tbl, $datas, $id); */

            redirect("admin/dashboard");
        }else{
            $this->session->set_flashdata('error', 'Email atau password salah!');
            redirect("admin/login");
        }
        /* } */
    }

}