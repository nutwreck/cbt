<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    /**
	 * Author : Candra Aji Pamungkas
     * Create : 30-03-2021
     * Change :
     *      - {date} | {description}
	 */

    private $tbl_group_peserta = 'group_peserta';
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

    private function input_end($input, $urly, $urlx){
        if(!empty($input)){
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan!');
		    redirect($urlx);
        }
    }

    private function update_end($update, $urly, $urlx){
        if(!empty($update)){
            $this->session->set_flashdata('success', 'Data berhasil diedit');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal terupdate!');
		    redirect($urlx);
        }
    }

    private function delete_end($delete, $urly, $urlx){
        if(!empty($delete)){
            $this->session->set_flashdata('success', 'Data berhasil dinonaktifkan');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal ternonaktifkan!');
		    redirect($urlx);
        }
    }

    private function active_end($active, $urly, $urlx){
        if(!empty($active)){
            $this->session->set_flashdata('success', 'Data berhasil diaktifkan');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal diaktifkan!');
		    redirect($urlx);
        }
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

    private function secure_random_string($length) {
        $random_string = '';
        for($i = 0; $i < $length; $i++) {
            $number = random_int(0, 36);
            $character = base_convert($number, 10, 36);
            $random_string .= $character;
        }
     
        return $random_string;
    }

    private function generate_username(){
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generate_string = $this->generate_string($permitted_chars, 5);
        $get_time = strtotime("now");
        $username = $generate_string.'@'.$get_time;

        $username_check = $this->user->get_checking_username($username);

        if($username_check){
            $this->generate_username();
        } else {
            return $username;
        }
    }

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function user_lembaga(){
        //for passing data to view
        $data['content']['user_lembaga'] = $this->user->get_user_lembaga();
        $data['title_header'] = ['title' => 'User Lembaga'];

        //for load view
        $view['css_additional'] = 'website/lembaga/user/admin_lembaga/css';
        $view['content'] = 'website/lembaga/user/admin_lembaga/content';
        $view['js_additional'] = 'website/lembaga/user/admin_lembaga/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_user_lembaga(){
        //for passing data to view
        $lembaga_id = 2; //Next diganti dari session login
        $role_user_id = 3; //Next diganti dari session login
        $lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
        $role_user_id_crypt = urlencode(base64_encode($role_user_id));
        $cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

        $data['content']['role_user_id'] = $role_user_id_crypt; //Role user id untuk user lembaga
        $data['content']['lembaga_id'] = $lembaga_id_crypt; //Lembaga id untuk user lembaga
        $data['title_header'] = ['title' => 'Add User Lembaga'];

        if($cek_verify_lembaga->is_verify == 1){
            //for load view
            $view['css_additional'] = 'website/lembaga/user/admin_lembaga/css';
            $view['content'] = 'website/lembaga/user/admin_lembaga/add';
            $view['js_additional'] = 'website/lembaga/user/admin_lembaga/js';

            //get function view website
            $this->_generate_view($view, $data);
        } else {
            $this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah admin lembaga!');
		    redirect('lembaga/user-lembaga');
        }
    }

    public function submit_add_user_lembaga(){
        $lembaga_id = $this->input->post('lembaga_id'); //No Decode
        $role_user_id = $this->input->post('role_user_id'); //No Decode
        $email = $this->input->post('email', TRUE);

        $cek_email = $this->user->get_user_by_email($email); //Cek email

        if($cek_email){ //Jika email sudah dipakai dan masih aktif
            $this->session->set_flashdata('warning', 'Email sudah terdaftar!');
		    redirect('lembaga/add-user-lembaga');
        } else {
            //lembaga_user
            $data_user_lembaga['lembaga_id'] = base64_decode(urldecode($lembaga_id));
            $data_user_lembaga['name'] = ucwords($this->input->post('name', TRUE));
            $data_user_lembaga['email'] = $email;
            $data_user_lembaga['created_datetime'] = date('Y-m-d H:i:s');
            
            //user access
            $data_user['role_user_id'] = base64_decode(urldecode($role_user_id));
            $data_user['username'] = $email;
            $data_user['password'] = $this->encryption->encrypt($this->input->post('password', TRUE));
            $data_user['created_datetime'] = date('Y-m-d H:i:s');

            $allowed_type 	= [
                "jpeg", "jpg", "png"
            ];
            $config['upload_path']      = FCPATH.'storage/website/lembaga/grandsbmptn/user_admin/';
            $config['allowed_types']    = 'jpeg|jpg|png';
            $config['encrypt_name']     = TRUE;
            $_upload_path = $config['upload_path'];

            if(!file_exists($_upload_path)){
                mkdir($_upload_path,0777);
            }
            
            $this->load->library('upload', $config);

            if(!empty($_FILES['soal_audio']['name'])){
                if (!$this->upload->do_upload('soal_audio')){
                    $error = $this->upload->display_errors();
                    show_error($error, 500, 'File Audio Soal Error');
                    exit();
                }else{
                    $data_user_lembaga['file'] = $this->upload->data('file_name');
                }
            }

            $input = $this->user->input_lembaga_user($data_user_lembaga, $data_user);

            $urly = 'lembaga/user-lembaga';
            $urlx = 'lembaga/add-user-lembaga';
            $this->input_end($input, $urly, $urlx);
        }
    }

    public function disable_user_lembaga($id_user_lembaga, $id_user){
        $data = [];
        $lembaga_user_id = base64_decode(urldecode($id_user_lembaga));
        $user_id = base64_decode(urldecode($id_user));

        $data = array(
            'is_enable' => 0
        );

        $disable = $this->user->disable_lembaga_user($lembaga_user_id, $user_id, $data);

        $urly = 'lembaga/user-lembaga';
        $urlx = 'lembaga/user-lembaga';
        $this->delete_end($disable, $urly, $urlx);
    }

    public function group_participants(){
        $lembaga_id = 2; //Next diganti dari session login
        //for passing data to view
        $data['content']['group_peserta'] = $this->user->get_group_peserta_enable($lembaga_id);
        $data['title_header'] = ['title' => 'Group Peserta'];

        //for load view
        $view['css_additional'] = 'website/lembaga/user/group_peserta/css';
        $view['content'] = 'website/lembaga/user/group_peserta/content';
        $view['js_additional'] = 'website/lembaga/user/group_peserta/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_group_participants(){
        //for passing data to view
        $lembaga_id = 2; //Next diganti dari session login
        $lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
        $cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

        $data['content']['lembaga_id'] = $lembaga_id_crypt; //Lembaga id untuk user lembaga
        $data['title_header'] = ['title' => 'Add Group Peserta'];

        if($cek_verify_lembaga->is_verify == 1){
            //for load view
            $view['css_additional'] = 'website/lembaga/user/group_peserta/css';
            $view['content'] = 'website/lembaga/user/group_peserta/add';
            $view['js_additional'] = 'website/lembaga/user/group_peserta/js';

            //get function view website
            $this->_generate_view($view, $data);
        } else {
            $this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah group peserta!');
		    redirect('lembaga/user-lembaga');
        }
    }

    public function submit_add_group_peserta(){
        $lembaga_id = $this->input->post('lembaga_id'); //No Decode

        $data['lembaga_id'] = base64_decode(urldecode($lembaga_id));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $data['created_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_group_peserta;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'lembaga/group-participants';
        $urlx = 'lembaga/add-group-participants';
        $this->input_end($input, $urly, $urlx);
    }

    public function edit_group_participants($id_group_participants){
        $participants_group_id = base64_decode(urldecode($id_group_participants));

        //for passing data to view
        $data['content']['group_peserta'] = $this->user->get_group_peserta_by_id($participants_group_id);
        $data['title_header'] = ['title' => 'Edit Group Peserta'];

        //for load view
        $view['css_additional'] = 'website/lembaga/user/group_peserta/css';
        $view['content'] = 'website/lembaga/user/group_peserta/edit';
        $view['js_additional'] = 'website/lembaga/user/group_peserta/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_group_peserta(){
        $id_group_participants = $this->input->post('id'); //No Decode
        $participants_group_id = base64_decode(urldecode($id_group_participants));
        $lembaga_id = $this->input->post('lembaga_id'); //No Decode

        $data['lembaga_id'] = base64_decode(urldecode($lembaga_id));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_group_peserta;
        $update = $this->general->update_data($tbl, $data, $participants_group_id);

        $urly = 'lembaga/group-participants';
        $urlx = 'lembaga/edit-group-participants/'.$id_group_participants;
        $this->update_end($update, $urly, $urlx);
    }

    public function disable_group_participants($id_group_participants){
        $data = [];
        $participants_group_id = base64_decode(urldecode($id_group_participants));

        $tbl = $this->tbl_group_peserta;
        $disable = $this->general->delete_data($tbl, $participants_group_id);

        $urly = 'lembaga/group-participants';
        $urlx = 'lembaga/group-participants';
        $this->delete_end($disable, $urly, $urlx);
    }

    public function participants(){
        $lembaga_id = 2; //Next diganti dari session login
        //for passing data to view
        $data['content']['participants'] = $this->user->get_peserta_by_lembaga($lembaga_id);
        $data['title_header'] = ['title' => 'Peserta List'];

        //for load view
        $view['css_additional'] = 'website/lembaga/user/peserta/css';
        $view['content'] = 'website/lembaga/user/peserta/content';
        $view['js_additional'] = 'website/lembaga/user/peserta/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_participants(){
        //for passing data to view
        $lembaga_id = 2; //Next diganti dari session login
        $role_user_id = 2; //Role Id untuk user
        $lembaga_id_crypt = urlencode(base64_encode($lembaga_id));
        $role_user_id_crypt = urlencode(base64_encode($role_user_id));
        $cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

        $data['content']['role_user_id'] = $role_user_id_crypt; //Role user id untuk peserta
        $data['content']['lembaga_id'] = $lembaga_id_crypt; //Lembaga id untuk peserta
        $data['content']['group_peserta'] = $this->user->get_group_peserta_enable($lembaga_id);
        $data['title_header'] = ['title' => 'Add Peserta'];

        if($cek_verify_lembaga->is_verify == 1){
            //for load view
            $view['css_additional'] = 'website/lembaga/user/peserta/css';
            $view['content'] = 'website/lembaga/user/peserta/add';
            $view['js_additional'] = 'website/lembaga/user/peserta/js';

            //get function view website
            $this->_generate_view($view, $data);
        } else {
            $this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah admin lembaga!');
            redirect('lembaga/user-lembaga');
        }
    }

    public function submit_add_peserta(){
        $data_user = [];
        $data_peserta = [];
        $role_user_id = $this->input->post('role_user_id');
        $lembaga_id = $this->input->post('lembaga_id');

        $username = $this->input->post('email_peserta', TRUE);
        $password = $this->input->post('password', TRUE);

        if($username == '' || $username == NULL || empty($username)){ //Jika email dikosongkan
            $username_input = $this->generate_username();
        } else {
            $username_input = $username;
        }

        if($password == '' || $password == NULL || empty($password)){
            $pass_input = $this->secure_random_string($this->length_pass);
        } else {
            $pass_input = $password;
        }

        //Data User
        $data_user['role_user_id'] = base64_decode(urldecode($role_user_id));
        $data_user['username'] = $username_input;
        $data_user['password'] = $this->encryption->encrypt($pass_input);
        $data_user['created_datetime'] = date('Y-m-d H:i:s');

        //Data Peserta
        $data_peserta['lembaga_id'] = base64_decode(urldecode($lembaga_id));
        $data_peserta['no_peserta'] = $this->input->post('no_peserta', TRUE);
        $data_peserta['group_peserta_id'] = $this->input->post('group_peserta', TRUE);
        $data_peserta['name'] = ucwords($this->input->post('nama_peserta', TRUE));
        $data_peserta['created_datetime'] = date('Y-m-d H:i:s');

        $input = $this->user->input_peserta_tes($data_user, $data_peserta);

        $urly = 'lembaga/participants';
        $urlx = 'lembaga/add-participants';
        $this->input_end($input, $urly, $urlx);
    }

    public function edit_participants($id_peserta, $id_user){
        //for passing data to view
        $peserta_id = base64_decode(urldecode($id_peserta));
        $user_id = base64_decode(urldecode($id_user));
        $detail_partisipan = $this->user->get_peserta_by_id($peserta_id, $user_id);
        $lembaga_id = $detail_partisipan->lembaga_id;

        $cek_verify_lembaga = $this->user->get_lembaga_by_id($lembaga_id); //Cek verifikasi akun lembaga

        $data['content']['id_peserta'] = $id_peserta;
        $data['content']['id_user'] = $id_user;
        $data['content']['id_lembaga'] = urlencode(base64_encode($lembaga_id));
        $data['content']['group_peserta'] = $this->user->get_group_peserta_selected($detail_partisipan->group_peserta_id);
        $data['title_header'] = ['title' => 'Edit Peserta'];

        var_dump($data);die();

        if($cek_verify_lembaga->is_verify == 1){
            //for load view
            $view['css_additional'] = 'website/lembaga/user/peserta/css';
            $view['content'] = 'website/lembaga/user/peserta/edit';
            $view['js_additional'] = 'website/lembaga/user/peserta/js';

            //get function view website
            $this->_generate_view($view, $data);
        } else {
            $this->session->set_flashdata('warning', 'Lakukkan verifikasi akun sebelum menambah admin lembaga!');
            redirect('lembaga/user-lembaga');
        }
    }

    public function submit_edit_peserta(){

    }

    public function disable_participants($id_peserta, $id_user){

    }


}