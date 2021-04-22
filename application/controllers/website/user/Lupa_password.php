<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lupa_password extends CI_Controller {
    
    
    private $length_pass = 6;

    public function __construct(){
        parent::__construct();
        $this->load->library('encryption');
        $this->load->model('General','general');
        $this->load->model('User_model','user');
        $this->load->config('email');
    }

    /*
    |
    | START FUNCTION IN THIS CONTROLLER
    |
    */

    private function generate_no_peserta() {
        $min = 0;
        $max = 9999;
        $output = rand($min,$max);

        $length = strlen($output);
        $date = date('Y').date('m').date('d');

        if($length == 1){
            $no_peserta = $date.'000'.$output;
        } elseif($length == 2) {
            $no_peserta = $date.'00'.$output;
        } elseif($length == 3) {
            $no_peserta = $date.'0'.$output;
        } elseif($length == 4) {
            $no_peserta = $date.$output;
        }

        $check_no_peserta = $this->user->checking_nomor_peserta($no_peserta);

        if($check_no_peserta){
            $this->generate_no_peserta();
        } else {
            return $no_peserta;
        }
    }

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function index(){
        $this->load->view('website/user/login/home/content');
    }

    public function lupa_password(){
        $this->load->view('website/user/login/lupa_password/content');
    }
    private function secure_random_string($length) {
        $random_string = '';
        for($i = 0; $i < $length; $i++) {
            $number = random_int(0, 36);
            $character = base_convert($number, 10, 36);
            $random_string .= $character;
        }
     
        return $random_string;
    }

    public function submit_lupa_password(){

        $username = $this->input->post('username', TRUE);
        $check_username = $this->user->get_checking_username($username);
        $usernameid= $this->user->get_id_by_username($username);
      
        $userid  = $usernameid->id;
 
        if(!empty($check_username)){
            $new_pass = $this->secure_random_string($this->length_pass);        
            //var_dump($new_pass);die();
            $from = $this->config->item('smtp_user');
            $subject = 'Reset Password';      
          //  $message = $this->load->view("",$data,TRUE); //halaman view email, $data berisi data2 lemparan ke view
          $message="Password anda berhasil direset,<br> <b>Password</b> baru anda <b>$new_pass</b><br /><br />.<h2>==EMAIL JANGAN DIBALAS==</h2><br />Thanks & Regards<br />ADMIN";  
          //var_dump($message); die();
            $this->email->set_newline("\r\n");
            $this->email->from($from, '[NO-REPLY] Testing Sistem');
            $this->email->to($username);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();

            $tbl='user';
           
            $encript_pass = $this->encryption->encrypt($new_pass);
            $data['password'] = $encript_pass;
            $update = $this->general->update_data($tbl, $data, $userid);

            $this->session->set_flashdata('success', 'Password baru sudah di kirim email, silahkan cek email');
      
            redirect("login");
        }else{

            $this->session->set_flashdata('error', 'Email yang anda masukkan tidak terdaftar, silahkan cek ulang !');
            
            redirect("lupa_password");
        }


    }



    public function logout(){
        $this->session->sess_destroy();
        redirect("login");
    }
}