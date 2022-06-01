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
    
    private function secure_random_string($length) {
        $random_string = '';
        for($i = 0; $i < $length; $i++) {
            $number = random_int(0, 36);
            $character = base_convert($number, 10, 36);
            $random_string .= $character;
        }
     
        return $random_string;
    }

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function lupa_password(){
		$event_prefix = $this->uri->segment(2);

		if ($event_prefix != "" || $event_prefix != null) {
			$data['event_prefix'] = $event_prefix;
			$data['event_url'] = 'event/'.$event_prefix;
		} else {
			$data['event_prefix'] = "";
			$data['event_url'] = "register";
		}

        $this->load->view('website/user/login/lupa_password/content', $data);
    }

    public function submit_lupa_password(){
        $username = $this->input->post('username', TRUE);
        $prefix_url = $this->input->post('prefix_url', TRUE);
        $check_username = $this->user->get_checking_username($username);
        $usernameid = $this->user->get_id_by_username($username);
      
        $userid  = $usernameid->id;
 
        if(!empty($check_username)){
            $new_pass = $this->secure_random_string($this->length_pass);        
            $from = $this->config->item('smtp_user');
            $subject = 'Reset Password';
            $message="Password anda berhasil direset,<br> <b>Password</b> baru anda <b>$new_pass</b><br /><br />.<h2>==EMAIL JANGAN DIBALAS==</h2><br />Thanks & Regards<br />ADMIN";  

            $this->email->set_newline("\r\n");
            $this->email->from($from, '[NO-REPLY] Zambert');
            $this->email->to($username);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();

            $tbl = 'user';
           
            $encript_pass = $this->encryption->encrypt($new_pass);
            $data['password'] = $encript_pass;
            $update = $this->general->update_data($tbl, $data, $userid);

            $this->session->set_flashdata('success', 'Password baru sudah di kirim via email, silahkan cek email!');
			
			if ($prefix_url != "") {
				redirect("event/login/".$prefix_url);
			} else {
				redirect("login");
			}
        } else {
            $this->session->set_flashdata('error', 'Email yang anda masukkan tidak terdaftar!');

			if ($prefix_url != "") {
				redirect("lupa-password/".$prefix_url);
			} else {
				redirect("lupa-password");
			}
        }
    }
}
