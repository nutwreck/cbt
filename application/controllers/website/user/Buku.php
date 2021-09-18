<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    private $length_pass = 15;
    private $sbmptn_id = 2;
    private $toefl_id = 1;
    private $cpns_id = 3;
    private $tbl_kode_unik = 'kode_unik';
    private $tbl_invoice = 'invoice';
    private $tbl_ujian = 'ujian';
    private $tbl_ujian_skor = 'ujian_skor';

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login_user')){
            redirect('login');
        }
        $this->load->library('encryption');
        $this->load->helper('download');
        $this->load->config('email');
        $this->load->model('General','general');
        $this->load->model('Tes_online_model','tes');
        $this->load->model('Management_model','management');
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
        $this->load->view($view['js_additional']);
        $this->load->view('website/user/_template/footer');
    }

    private function generate_no_invoice($buku_id) {
        $no_invoice = '';

        $min = 0;
        $max = 9999;
        $output = rand($min,$max);

        $length = strlen($output);
        $date = date('Y').date('m').date('d');

        if($length == 1){
            $no_invoice = $date.'000'.$output.'-'.$buku_id;
        } elseif($length == 2) {
            $no_invoice = $date.'00'.$output.'-'.$buku_id;
        } elseif($length == 3) {
            $no_invoice = $date.'0'.$output.'-'.$buku_id;
        } elseif($length == 4) {
            $no_invoice = $date.$output.'-'.$buku_id;
        }

        $check_no_invoice = $this->management->checking_nomor_invoice($no_invoice);

        if($check_no_invoice){
            $this->generate_no_invoice($buku_id);
        } else {
            return $no_invoice;
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

    public function output_json($data, $encode = true)
	{
        if($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }
    
    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function sbmptn($id_config_buku_group){
        $user_id = $this->session->userdata('user_id');
        $sbmptn_id = $this->sbmptn_id;

        $get_check_invoice = $this->management->get_user_status_buku($sbmptn_id, $user_id);
        $get_check_paket = $this->management->get_config_buku_by_buku($sbmptn_id);

        $jurusan = !empty($get_check_invoice->detail_buku_id) ? $get_check_invoice->detail_buku_id : NULL ;
        $free_paket = $get_check_paket->free_paket;
        $price = $get_check_paket->price;

        //for passing data to view
        $data['content']['sbmptn_paket'] = $this->tes->get_paket_soal_buku($sbmptn_id, $jurusan);
        $data['content']['status_user'] = !empty($get_check_invoice) ? 'purchase' : 'free';
        $data['content']['free_paket'] = $free_paket;

        if($id_config_buku_group == 'launch'){
            $data['content']['group_stat'] = 0;
            $data['content']['buku_group'] = $this->management->get_config_buku_group_by_buku($sbmptn_id);
        } elseif($id_config_buku_group == 'back'){
            $data['content']['group_stat'] = 1;
            $data['content']['buku_group'] = $this->management->get_config_buku_group_by_buku($sbmptn_id);
        } else {
            $config_buku_group_id = base64_decode(urldecode($id_config_buku_group));
            $data['content']['group_stat'] = 1;
            $data['content']['buku_group'] = $this->management->get_config_buku_detail_by_id($config_buku_group_id, $jurusan);
        }

        $data['content']['sbmptn_id'] = urlencode(base64_encode($sbmptn_id));
        $data['title_header'] = ['title' => 'Buku SBMPTN'];

        //for load view
        $view['css_additional'] = 'website/user/buku/sbmptn/css';
        $view['content'] = 'website/user/buku/sbmptn/content';
        $view['js_additional'] = 'website/user/buku/sbmptn/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function toefl($id_config_buku_group){
        $user_id = $this->session->userdata('user_id');
        $toefl_id = $this->toefl_id;

        $get_check_invoice = $this->management->get_user_status_buku($toefl_id, $user_id);
        $get_check_paket = $this->management->get_config_buku_by_buku($toefl_id);

        $jurusan = !empty($get_check_invoice->detail_buku_id) ? $get_check_invoice->detail_buku_id : NULL ;
        $free_paket = $get_check_paket->free_paket;
        $price = $get_check_paket->price;

        //for passing data to view
        $data['content']['toefl_paket'] = $this->tes->get_paket_soal_buku($toefl_id, $jurusan);
        $data['content']['status_user'] = !empty($get_check_invoice) ? 'purchase' : 'free';
        $data['content']['free_paket'] = $free_paket;

        if($id_config_buku_group == 'launch'){
            $data['content']['group_stat'] = 0;
            $data['content']['buku_group'] = $this->management->get_config_buku_group_by_buku($toefl_id);
        } elseif($id_config_buku_group == 'back'){
            $data['content']['group_stat'] = 1;
            $data['content']['buku_group'] = $this->management->get_config_buku_group_by_buku($toefl_id);
        } else {
            $config_buku_group_id = base64_decode(urldecode($id_config_buku_group));
            $data['content']['group_stat'] = 1;
            $data['content']['buku_group'] = $this->management->get_config_buku_detail_by_id($config_buku_group_id, $jurusan);
        }

        $data['content']['toefl_id'] = urlencode(base64_encode($toefl_id));
        $data['title_header'] = ['title' => 'Buku TOEFL'];

        //for load view
        $view['css_additional'] = 'website/user/buku/toefl/css';
        $view['content'] = 'website/user/buku/toefl/content';
        $view['js_additional'] = 'website/user/buku/toefl/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function cpns($id_config_buku_group){
        $user_id = $this->session->userdata('user_id');
        $cpns_id = $this->cpns_id;

        $get_check_invoice = $this->management->get_user_status_buku($cpns_id, $user_id);
        $get_check_paket = $this->management->get_config_buku_by_buku($cpns_id);

        $jurusan = !empty($get_check_invoice->detail_buku_id) ? $get_check_invoice->detail_buku_id : NULL ;
        $free_paket = $get_check_paket->free_paket;
        $price = $get_check_paket->price;

        //for passing data to view
        $data['content']['cpns_paket'] = $this->tes->get_paket_soal_buku($cpns_id, $jurusan);
        $data['content']['status_user'] = !empty($get_check_invoice) ? 'purchase' : 'free';
        $data['content']['free_paket'] = $free_paket;

        if($id_config_buku_group == 'launch'){
            $data['content']['group_stat'] = 0;
            $data['content']['buku_group'] = $this->management->get_config_buku_group_by_buku($cpns_id);
        } elseif($id_config_buku_group == 'back'){
            $data['content']['group_stat'] = 1;
            $data['content']['buku_group'] = $this->management->get_config_buku_group_by_buku($cpns_id);
        } else {
            $config_buku_group_id = base64_decode(urldecode($id_config_buku_group));
            $data['content']['group_stat'] = 1;
            $data['content']['buku_group'] = $this->management->get_config_buku_detail_by_id($config_buku_group_id, $jurusan);
        }

        $data['content']['cpns_id'] = urlencode(base64_encode($cpns_id));
        $data['title_header'] = ['title' => 'Buku CPNS'];

        //for load view
        $view['css_additional'] = 'website/user/buku/cpns/css';
        $view['content'] = 'website/user/buku/cpns/content';
        $view['js_additional'] = 'website/user/buku/cpns/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function download_buku($id_detail_buku){
        $get_detail_buku = $this->management->get_config_buku_detail_download($id_detail_buku);

        $nama_file = 'storage/website/lembaga/grandsbmptn/modul/'.$get_detail_buku->nama_file;

        force_download($nama_file, NULL);
    }

    public function pembelian_buku($id_buku){
        $user_id = $this->session->userdata('user_id');
        $buku_id = base64_decode(urldecode($id_buku));
        $pembayaran_master_id = 1; //Bank

        $data['content']['payment_method'] = $this->management->get_pembayaran_master();
        $data['content']['payment_method_detail'] = $this->management->get_pembayaran_master_by_id($pembayaran_master_id);
        $data['content']['user_data'] = $this->user->get_data_user_by_id($user_id);
        $data['content']['buku_data'] = $this->management->get_config_buku_by_buku($buku_id);
        $data['content']['id_buku'] = $id_buku;
        $data['title_header'] = ['title' => 'Pembelian Buku'];

        //for load view
        $view['css_additional'] = 'website/user/buku/pembelian_buku/css';
        $view['content'] = 'website/user/buku/pembelian_buku/content';
        $view['js_additional'] = 'website/user/buku/pembelian_buku/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_payment(){
        $data = [];
        $datas = [];

        $id_buku = $this->input->post('id_buku');
        $buku_id = base64_decode(urldecode($id_buku));

        $voucher = $this->input->post('voucher', TRUE);

        if($voucher != '' || !empty($voucher)){
            $voucher_str = strtoupper($voucher);
            $get_voucher = $this->management->get_voucher_by_name($voucher_str);

            if($get_voucher){
                $voucher_id = $get_voucher->id;
                $voucher_name = $get_voucher->name;
                $voucher_potongan = $get_voucher->potongan;
            } else {
                $this->session->set_flashdata('warning', 'Kode voucher tidak ditemukan, Info lebih lanjut hubungi admin');
                redirect('pembelian-buku/'.$id_buku);
            }
        } else {
            $voucher_id = 0;
            $voucher_name = '';
            $voucher_potongan = 0;
        }

        if($buku_id == 1){
            $buku = 'TOEFL';
        } elseif($buku_id == 2){
            $buku = 'SBMPTN';
        } elseif($buku_id == 3){
            $buku = 'CPNS';
        }

        $detail_buku_check = $this->input->post('detail_buku_id', TRUE);
        if($buku_id == 2 && ($detail_buku_check == '' || $detail_buku_check == NULL)){ //2 SBMPTN
            $this->session->set_flashdata('warning', 'Jurusan wajib dipilih!');
            redirect('pembelian-buku/'.$id_buku);
        }

        if($buku_id == 2 && $detail_buku_check == 1){ //2 SBMPTN
            $detail_buku_name = 'SAINTEK';
        } elseif($buku_id == 2 && $detail_buku_check == 2){
            $detail_buku_name = 'SOSHUM';
        } else {
            $detail_buku_name = null;
        }

        $payment_check = $this->input->post('payment_choosen', TRUE);
        if($payment_check == 1){ //BANK
            $payment_method_id = $payment_check;
            $payment_method_name = 'BANK';
            $data_bank = $this->input->post('payment_bank', TRUE);
            $data_bank_exp = explode('|', $data_bank);
            $payment_method_detail_id = $data_bank_exp[0];
            $payment_method_detail_name = $data_bank_exp[1].' - '.$data_bank_exp[2].' - '.$data_bank_exp[3];
        } else{
            $payment_method_id = $payment_check;
            $payment_method_name = 'QRIS';
            $payment_method_detail_id = $this->management->get_id_qris($payment_check);
            $payment_method_detail_name = 'Qris';
        }
        
        $user_id = $this->input->post('user_id', TRUE);
        $user_name = $this->input->post('user_name', TRUE);
        $user_email = $this->input->post('user_email', TRUE);
        $user_no_telp = $this->input->post('user_no_telp', TRUE);
        
        $no_invoice = $this->generate_no_invoice($buku_id);
        $invoice_number = $no_invoice;
        $invoice_total_cost_input = $this->input->post('invoice_total_cost', TRUE);

        $tbl_kode_unik = $this->tbl_kode_unik;

        $kode_unik_data = $this->management->get_kode_unik();
        if($kode_unik_data == 999){
            $new_number = 300;
            $update_kode_unik = array('number' => $new_number);
            $this->general->update_data($tbl_kode_unik, $update_kode_unik, 1);
            $kode_unik_data = $this->management->get_kode_unik();
        }
        
        if(!empty($get_voucher) && $voucher_name != '' && $voucher_potongan != 0){
            $invoice_total_cost = ($invoice_total_cost_input + $kode_unik_data) - $voucher_potongan;
        } else {
            $invoice_total_cost = $invoice_total_cost_input + $kode_unik_data;
        }

        $kode_unik = $kode_unik_data;
        
        $new_number = $kode_unik+1;
        $update_kode_unik = array('number' => $new_number);
        $this->general->update_data($tbl_kode_unik, $update_kode_unik, 1); //Update Kode Unik

        $now = date('Y-m-d H:i:s');
        $invoice_date_create = $now;
        $invoice_date_expirate = date('Y-m-d H:i:s', strtotime($now. ' + 1 days'));
        $status = 0; //Submit New
        $created_datetime = $now;

        $tbl_invoice = $this->tbl_invoice;
        $data = array(
            'buku_id' => $buku_id,
            'detail_buku_id' => $detail_buku_check,
            'payment_method_id' => $payment_method_id,
            'payment_method_name' => $payment_method_name,
            'payment_method_detail_id' => $payment_method_detail_id,
            'payment_method_detail_name' => $payment_method_detail_name,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_no_telp' => $user_no_telp,
            'invoice_number' => $invoice_number,
            'invoice_total_cost' => $invoice_total_cost,
            'kode_unik' => $kode_unik,
            'voucher_id' => $voucher_id,
            'voucher_name' => $voucher_name,
            'voucher_potongan' => $voucher_potongan,
            'invoice_date_create' => $invoice_date_create,
            'invoice_date_expirate' => $invoice_date_expirate,
            'status' => $status,
            'created_datetime' => $created_datetime
        );
        $insert = $this->general->input_data_id($tbl_invoice, $data);

        $img_qris = $this->management->get_img_qris();
        $datas = array(
            'detail_buku_name' => $detail_buku_name,
            'payment_method_id' => $payment_method_id,
            'payment_method_name' => $payment_method_name,
            'bank' => !empty($data_bank_exp[1]) ? $data_bank_exp[1] : '',
            'bank_account' => !empty($data_bank_exp[2]) ? $data_bank_exp[2] : '',
            'bank_number' => !empty($data_bank_exp[3]) ? $data_bank_exp[3] : '',
            'qris' => $img_qris,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_no_telp' => $user_no_telp,
            'invoice_number' => $invoice_number,
            'price' => $invoice_total_cost_input,
            'invoice_total_cost' => $invoice_total_cost,
            'kode_unik' => $kode_unik,
            'voucher_name' => $voucher_name,
            'voucher_potongan' => $voucher_potongan,
            'invoice_date_create' => $invoice_date_create,
            'invoice_date_expirate' => $invoice_date_expirate,
            'status' => $status,
            'buku_name' => $buku
        );

        if($insert){
            $this->email->clear(TRUE);

            $from = $this->config->item('smtp_user');
            $subject = 'Invoice #'.$no_invoice.' '.format_indo($now);
            $message = $this->load->view('website/user/buku/pembelian_buku/invoice/content', $datas, TRUE);

            $this->email->set_newline("\r\n");
            $this->email->from($from, '[NO-REPLY] Zambert');
            $this->email->to($user_email);
            $this->email->subject($subject);
            $this->email->message($message);

            if($this->email->send()){
                $this->session->set_flashdata('success', 'Email invoice berhasil dikirim ke '.$user_email);

                $message = '';
                
                $data['content']['data'] = $datas;
                $data['title_header'] = ['title' => 'Success Invoice'];

                //for load view
                $view['css_additional'] = 'website/user/buku/pembelian_buku/css';
                $view['content'] = 'website/user/buku/pembelian_buku/invoice_send';
                $view['js_additional'] = 'website/user/buku/pembelian_buku/js';

                //get function view website
                $this->_generate_view($view, $data);
            } else { //jika email tidak terkirim invoice dibatalkan / disable
                $disable = [];
                $tbl_invoice = $this->tbl_invoice;
                $disable = array(
                    'is_enable' => 0,
                    'updated_datetime' => date('Y-m-d H:i:s')
                );
                $this->general->update_data($tbl_invoice, $disable, $insert);
                $this->session->set_flashdata('error', 'Invoice dibatalkan. Email Invoice tidak terkirim, Mohon hubungi admin lewat Whatsapp dibawah ini.');
                redirect('pembelian-buku/'.$id_buku);
            }
        } else {
            $this->session->set_flashdata('error', 'Invoice gagal dibuat, Mohon ulangi beberapa saat lagi.');
            redirect('pembelian-buku/'.$id_buku);
        }
    }

    public function invoice_status(){
        $user_id = $this->session->userdata('user_id');
        $data['content']['invoice'] = $this->management->get_invoice_by_user_id($user_id);
        $data['title_header'] = ['title' => 'Status Incoice'];

        //for load view
        $view['css_additional'] = 'website/user/invoice_data/css';
        $view['content'] = 'website/user/invoice_data/content';
        $view['js_additional'] = 'website/user/invoice_data/js';
      
        $this->_generate_view($view, $data);
    }

    public function manual_confirm($id_invoice, $status){
        if($status == 0 || $status == 4){
            $invoice_id = base64_decode(urldecode($id_invoice));

            $data['content']['invoice_detail'] = $this->management->get_invoice_by_id($invoice_id);
            $data['content']['id_invoice'] = $id_invoice;
            $data['title_header'] = ['title' => 'Konfirmasi Manual'];
    
            //for load view
            $view['css_additional'] = 'website/user/invoice_data/manual_confirm/css';
            $view['content'] = 'website/user/invoice_data/manual_confirm/content';
            $view['js_additional'] = 'website/user/invoice_data/manual_confirm/js';
          
            $this->_generate_view($view, $data);
        } else {
            $this->session->set_flashdata('warning', 'Anda sudah mengajukan upload bukti, tunggu approval / reject dari admin');
            redirect('purchase');
        }
    }

    public function submit_konfirm_invoice(){
        $data = [];

        $id_invoice =  $this->input->post('id_invoice');
        $invoice_id = base64_decode(urldecode($id_invoice));
        $invoice_number = $this->input->post('invoice_number', TRUE);
        $old_bukti = $this->input->post('old_bukti');
        $status = $this->input->post('status');

        $dname = explode(".", $_FILES['bukti_pembayaran']['name']);
        $ext = end($dname);
        $new_name                   = $invoice_number.'.'.$ext;

        $config['file_name']        = $new_name;
        $config['upload_path']      = FCPATH.'storage/website/lembaga/grandsbmptn/confirm_payment/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }
        
        $this->load->library('upload', $config);

        if(!empty($_FILES['bukti_pembayaran']['name'])){
            if (!$this->upload->do_upload('bukti_pembayaran')){
               /*  $error = $this->upload->display_errors();
                show_error($error, 500, 'File Audio Petunjuk Error');
                exit(); */
                if($ext != 'png' || $ext != 'jpg' || $ext != 'jpeg'){
                    $this->session->set_flashdata('warning', 'Jenis gambar tidak sesuai ketentuan, Ulangi kembali');
                    redirect('manual-confirm/'.$id_invoice);
                } else {
                    $this->session->set_flashdata('warning', 'Gambar gagal disimpan, Ulangi kembali');
                    redirect('manual-confirm/'.$id_invoice);
                }
            }else{
                $data['confirm_image'] = $this->upload->data('file_name');
            }
        } else {
            $data['confirm_image'] = $old_bukti;
        }

        $now = date('Y-m-d H:i:s');
        $data['invoice_date_update'] = $now;
        $data['updated_datetime'] = $now;
        if($status == 0) {
            $data['status'] = 1;
        } elseif($status == 4){ //Reject
            $data['status'] = 5; //Revisi Bukti
        } else {
            $data['status'] = 1;
        }
        
        $tbl_invoice = $this->tbl_invoice;
        $update = $this->general->update_data($tbl_invoice, $data, $invoice_id);

        if($update){
            $this->session->set_flashdata('success', 'Upload bukti inv #'.$invoice_number.' berhasil, Mohon tunggu approval admin');
            redirect('purchase');
        } else {
            $this->session->set_flashdata('error', 'Bukti gagal diupload, ulangi beberapa saat lagi atau hubungi admin');
            redirect('manual-confirm/'.$id_invoice);
        }
    }

    public function mulai_ujian($id_paket_soal){
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $generate_string = $this->generate_string($permitted_chars, 175);

        $paket_soal_id = base64_decode(urldecode($id_paket_soal));
        //for passing data to view
        $data['content']['paket_soal'] = $this->tes->get_paket_soal_sesi_by_id($paket_soal_id);
        $data['content']['id_paket_soal'] = $id_paket_soal;
        $data['content']['encrypt'] = $generate_string;
        $data['title_header'] = ['title' => 'Persiapan dan Petunjuk Pengerjaan'];

        //for load view
        $view['css_additional'] = 'website/user/buku/ujian/css';
        $view['content'] = 'website/user/buku/ujian/mulai_ujian/content';
        $view['js_additional'] = 'website/user/buku/ujian/mulai_ujian/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function portal_tes($id_paket_soal, $random_secure){
        $data_ujian = [];
        $bank_soal = [];
        $data = [];

        $paket_soal_id = base64_decode(urldecode($id_paket_soal));
        $id_config_buku_group = 'launch';

        $paket_soal = $this->tes->get_paket_soal_sesi_by_id($paket_soal_id); //Get Paket Soal
        $ujian_data = $this->tes->get_checking_ujian($paket_soal_id, $this->session->userdata('user_id')); //CEK SEBELUMNYA UDH PERNAH TES ATAU BELUM
        $audio_limit = $paket_soal->visual_limit;

        if(empty($ujian_data)){ //jika wadah untuk pemilihan soal dan jawaban belum ada
            $komposisi_soal = $this->tes->get_komposisi_soal_by_paket($paket_soal_id);//Ambil bank soal
            
            $data_ujian['sesi_pelaksanaan_id'] = 0;
            $data_ujian['paket_soal_id'] = $paket_soal_id;
            $data_ujian['user_id'] = $this->session->userdata('user_id');
            $data_ujian['user_no'] = $this->session->userdata('no_peserta');
            $data_ujian['user_name'] = $this->session->userdata('peserta_name');
            $data_ujian['user_email'] = $this->session->userdata('username');
            $now = date('Y-m-d H:i:s');
            $data_ujian['tgl_mulai'] = $now;
            $data_ujian['tgl_selesai'] = NULL;

            foreach($komposisi_soal as $val_komposisi){ //Membuat komposisi soal
                $bank_soal[$val_komposisi->id_group_soal] = $this->tes->get_bank_soal_ujian_buku($val_komposisi->paket_soal_id, $val_komposisi->id_group_soal);
            }
    
            $list_id_soal	= "";
            $list_jw_soal 	= "";
            if (!empty($bank_soal)) {
                foreach($bank_soal as $key_soal => $val_soal){ //membuat wadah untuk list soal dan tempat jawabannya
                    $group_soal_key = $key_soal;
                    foreach($val_soal as $val_deep_soal){
                        $list_id_soal .= $group_soal_key."|".$val_deep_soal['bank_soal_id'].",";
                        $list_jw_soal .= $group_soal_key."|".$val_deep_soal['bank_soal_id']."||N|0|0,";
                    }
                }
            }

            $list_id_soal = substr($list_id_soal, 0, -1);
            $list_jw_soal = substr($list_jw_soal, 0, -1);
            $data_ujian['list_soal'] = $list_id_soal;
            $data_ujian['list_jawaban'] = $list_jw_soal;
            $data_ujian['created_datetime'] = date('Y-m-d H:i:s');

            $tbl_ujian = $this->tbl_ujian;
            $input_docker_soal = $this->general->input_data($tbl_ujian, $data_ujian);

            if($input_docker_soal){ //jika data tempat ujian sudah terbuat
                redirect('buku/tes/'.$id_paket_soal.'/'.$random_secure, 'location', 301); //refresh halaman agar dimulai lagi dari awal
            } else {
                $this->session->set_flashdata('warning', 'Terjadi kesalahan saat persiapan ujian silahkan ulangi lagi!');
                redirect('buku/sbmptn/'.$id_config_buku_group);
            }
        }

        //Pengambilan data list jawaban, group soal, soalnya, dan hasil jawabannya
        $urut_soal 		= explode(",", $ujian_data->list_jawaban);
        $soal_urut_ok	= array();
        $jumlah_soal    = sizeof($urut_soal);
		for ($i = 0; $i < sizeof($urut_soal); $i++) {
			$pc_urut_soal	    = explode("|",$urut_soal[$i]);//pecah data wadah list jawaban
			$pc_urut_soal_jwb 	= empty($pc_urut_soal[2]) ? "''" : "'{$pc_urut_soal[2]}'";//List jawaban user
			$ambil_soal 	    = $this->tes->get_ujian_list_user($pc_urut_soal_jwb, $pc_urut_soal[1], $paket_soal_id);
			$soal_urut_ok[]     = $ambil_soal;
        }
        
        $soal_urut_ok = $soal_urut_ok;
        
        //Pengambilan isi dari data list ujian user
		$pc_list_jawaban = explode(",", $ujian_data->list_jawaban);
		$arr_jawab = array();
		foreach ($pc_list_jawaban as $v) {
            $pc_v 	= explode("|", $v);
            $gr     = $pc_v[0]; //Id Group
			$idx 	= $pc_v[1]; //Id Soal
			$val 	= $pc_v[2]; //Jawaban
			$rg 	= $pc_v[3]; //Ragu/Tidak
			$aud_g 	= $pc_v[4]; //Audio Group
			$aud_s 	= $pc_v[5]; //Audio Soal

			$arr_jawab[$idx] = array("g"=>$gr,"j"=>$val,"r"=>$rg,"aud_g"=>$aud_g,"aud_s"=>$aud_s);
        }

        $show_soal = [];
        $html = '';
        $previous_number = '';
        $next_number = '';
        $arrow_back = '';
        $arrow_next = '';
        $no_previous = '';
        $no_next = '';
        $group_soal_before = 0;
        if (!empty($soal_urut_ok)){
            $nomor_soal = 1;
            $num_group_soal = 0;
            foreach ($soal_urut_ok as $s) {
                $group_soal_next = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;

                $id_group_soal_p = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;
                $group_soal_p = $s->group_soal_parent_name != 0 || !empty($s->group_soal_parent_name) ? $s->group_soal_parent_name : $s->group_soal_name;

                $cek_group_mode_jwb = $s->group_mode_jwb_id == 1 ? '' : 'style="display:none;"'; //1 Pilihan ganda 2 essay
                $bacaan_soal = $s->isi_bacaan_soal <> 0 || !empty($s->isi_bacaan_soal) ? $s->isi_bacaan_soal.'<br />' : ''; // bacaan soal
                $bacaan_soal_name = $s->bacaan_soal_name <> 0 || !empty($s->bacaan_soal_name) ? '<b>'.$s->bacaan_soal_name.'</b><br />' : ''; // bacaan soal judul
                $group_soal_petunjuk = $s->group_soal_petunjuk <> 0 || !empty($s->group_soal_petunjuk) ? $s->group_soal_petunjuk.'<br />' : '';
                $group_soal_audio = ($s->group_soal_audio <> 0 || !empty($s->group_soal_audio)) && $audio_limit > $arr_jawab[$s->bank_soal_id]["aud_g"] ? '<audio id="group-loop-limited-'.$nomor_soal.'" controls controlsList="nodownload"><source src="'.config_item('_dir_website').'/lembaga/grandsbmptn/group_soal/group_'.$s->paket_soal_id.'/'.$s->group_soal_audio.'" type="'.$s->group_soal_tipe_audio.'">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : '';
                $soal_audio = ($s->file <> 0 || !empty($s->file)) && $audio_limit > $arr_jawab[$s->bank_soal_id]["aud_s"] ? '<audio id="loop-limited-'.$nomor_soal.'" controls controlsList="nodownload"><source src="'.config_item('_dir_website').'/lembaga/grandsbmptn/paket_soal/soal_'.$s->paket_soal_id.'/'.$s->file.'" type="'.$s->tipe_file.'">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : '';
                
                $html .= '<div class="step card text-left font-poppins" id="widget_'.$nomor_soal.'">';
                $vrg = $arr_jawab[$s->bank_soal_id]["r"] == "" ? "N" : $arr_jawab[$s->bank_soal_id]["r"];
                $ad_g = $arr_jawab[$s->bank_soal_id]["aud_g"] == "0" ? "0" : $arr_jawab[$s->bank_soal_id]["aud_g"];
                $ad_s = $arr_jawab[$s->bank_soal_id]["aud_s"] == "0" ? "0" : $arr_jawab[$s->bank_soal_id]["aud_s"];
                $html .= '<input type="hidden" name="id_group_mode_jwb'.$nomor_soal.'" value="'.$s->group_mode_jwb_id.'">';
                $html .= '<input type="hidden" name="id_group_soal_'.$nomor_soal.'" value="'.$id_group_soal_p.'">';
                $html .= '<input type="hidden" name="id_bank_soal_'.$nomor_soal.'" value="'.$s->bank_soal_id.'">';
                $html .= '<input type="hidden" name="group_soal_'.$nomor_soal.'" value="'.$group_soal_p.'">';
                $html .= '<input type="hidden" name="group_soal_sub_'.$nomor_soal.'" value="'.$s->group_soal_name.'">';
                $html .= '<input type="hidden" name="rg_'.$nomor_soal.'" id="rg_'.$nomor_soal.'" value="'.$vrg.'">';
                $html .= '<input type="hidden" name="audio_group_'.$nomor_soal.'" id="audio_group_'.$nomor_soal.'" value="'.$ad_g.'">';
				$html .= '<input type="hidden" name="audio_soal_'.$nomor_soal.'" id="audio_soal_'.$nomor_soal.'" value="'.$ad_s.'">';
                
                $no_previous = $nomor_soal-1;
                $no_next = $nomor_soal+1;

                if($group_soal_next == $group_soal_before){ //Isi Group
                    $arrow_back = $nomor_soal == 1 ? '<a id="arrow_back" class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>' : '<a rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left" aria-hidden="true" title="Soal Sebelumnya"></i></a>';
                    $arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true" title="Soal Berikutnya"></i></a>';
                    
                    $previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="previous_back" rel="0" onclick="return back();" class="back btn btn-md btn-primary text-white">No '.$no_previous.'</a></div>';
                    $next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No '.$no_next.'</a></div>';

                    $ragu_ragu = '<div class="col" data-position="up"><a rel="1" class="ragu_ragu btn btn-md btn-warning text-white" onclick="return tidak_jawab();">Ragu</a></div>';
                } else { // Parent Group
                    $num_group_soal++;
                    $arrow_back = $nomor_soal == 1 ? '<a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left"></i></a>' : '<a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left"></i></a>';
                    $arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';;

                    $previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" onclick="return back_group();" class="back btn btn-md btn-primary text-white">No '.$no_previous.'</a></div>';
                    $next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No '.$no_next.'</a></div>';
                    
                    $ragu_ragu = '<div class="col" data-position="up"><a rel="1" class="ragu_ragu btn btn-md btn-warning text-white" onclick="return tidak_jawab();">Ragu</a></div>';
                }

                $html .= '
                    <div class="card-header bg-primary text-white">
                        <div class="row">
                            <div class="col">
                                <h5><i class="fa fa-braille" aria-hidden="true"></i> Soal No #'.$nomor_soal.' / '.$jumlah_soal.'</h5>
                            </div>
                            <div class="col text-right">
                                <a id="_increase" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _increase();"><i class="fa fa-plus-square" aria-hidden="true" title="Zoom In"></i></a>
                                <a id="_reset" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _reset();"><i class="fa fa-sync" aria-hidden="true" title="Default"></i></a>
                                <a id="_decrease" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _decrease();"><i class="fa fa-minus-square" aria-hidden="true" title="Zoom Out"></i></a>
                                <span class="btn-nxt-brf-hrd">|</span>
                                '.$arrow_back.'
                                '.$arrow_next.'
                            </div>
                        </div>
                    </div>';

                $html .= '<div class="card-body">
                    <div class="card-text text-justify">'.$group_soal_audio.$bacaan_soal_name.$bacaan_soal.$soal_audio.$s->bank_soal_name.'</div><hr>';

                if($s->group_mode_jwb_id == 1){
                    $html .= '<div class="card-text mt-2">
                            <p><b>Pilih salah satu jawaban!</b></p>
                        </div>
                        <div class="funkyradio text-justify">';
                    $jawaban = $this->tes->get_jawaban_by_id_user($s->bank_soal_id, $s->paket_soal_id);
                    $opsi = config_item('_def_opsi_jawaban');
                    $jawaban_soal = [];
                    $number_opsi = 1;
                    foreach($jawaban as $key_jawaban => $val_jawaban) {
                        $checked = $arr_jawab[$s->bank_soal_id]["j"] == $val_jawaban->order ? "checked" : "";
                        $html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
                                <input type="radio" id="opsi_'.$opsi.'_'.$nomor_soal.'" name="opsi_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'" '.$checked.'> 
                                <label for="opsi_'.$opsi.'_'.$nomor_soal.'">
                                    <div class="huruf_opsi">'.$opsi.'</div> 
                                    <div class="card-text">'.$val_jawaban->name.'</div>
                                </label>
                            </div>';
                        $opsi++;
                        $number_opsi++;
                    };
                    $html .= '</div>';
                } else{
                    $history_jawab = !empty($arr_jawab[$s->bank_soal_id]["j"]) ? $arr_jawab[$s->bank_soal_id]["j"] : "";
                    $html .= '<div class="form-group">
                        <label class="card-text mt-2" for="essay_'.$nomor_soal.'">Masukkan jawaban anda dibawah ini</label>
                        <textarea class="form-control" id="essay_'.$nomor_soal.'" name="essay_'.$nomor_soal.'" rows="5">'.$history_jawab.'</textarea>
                    </div>';
                }

                $html .= '</div>';

                $html .= '<div class="card-footer text-muted">
                        <div class="row text-center">
                            '.$previous_number.'
                            '.$ragu_ragu.'
                            '.$next_number.'
                        </div>
                    </div>
                </div>';

                $nomor_soal++;

                $group_soal_before = $group_soal_next;
            }
        }
        
        //for passing data to view
        $data['content']['paket_soal'] = $paket_soal;
        $data['content']['lembar_jawaban'] = $html;
        $data['content']['ujian_id'] = $this->encryption->encrypt($ujian_data->id);
        $data['content']['random_secure'] = $random_secure;
        $data['content']['jumlah_soal'] = $nomor_soal;
        $data['content']['audio_limit'] = $paket_soal->visual_limit;
        $data['content']['is_jawab'] = $paket_soal->is_jawab;
        $data['content']['is_continuous'] = $paket_soal->is_continuous;
        $data['title_header'] = ['title' => 'Lembar Ujian Online'];

        //for load view
        $view['css_additional'] = 'website/user/buku/ujian/css';
        $view['content'] = 'website/user/buku/ujian/content';
        $view['js_additional'] = 'website/user/buku/ujian/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function simpan_satu(){
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);
		
        $input 	= $this->input->post(null, true);
        $d_simpan = [];
		$list_jawaban 	= "";
		for ($i = 1; $i < $input['jml_soal']; $i++) {
            $_tmode	    = "id_group_mode_jwb".$i;
            $_imode     = $input[$_tmode];
            
            $_tjawabes 	= "essay_".$i;
            $_tjawab 	= "opsi_".$i;
            if(!empty($input[$_tjawab])){
                $jwb_exp = explode("|", $input[$_tjawab]);
                $jawab_order = $jwb_exp[0];
            } else {
                $jawab_order = null;
            }
            $_tidgroup	= "id_group_soal_".$i;
			$_tidsoal 	= "id_bank_soal_".$i;
            $_ragu 		= "rg_".$i;
            $_audio_g 	= "audio_group_".$i;
            $_audio_s	= "audio_soal_".$i;
            if($input[$_audio_g] != 0){
                $audio_g_ = $input[$_audio_g];
            } else {
                $audio_g_ = 0;
            }
            if($input[$_audio_s] != 0){
                $audio_s_ = $input[$_audio_s];
            } else {
                $audio_s_ = 0;
            }

            if($_imode == 1){ //1 Pilihan ganda 2 Essay
                $jawaban_ 	= empty($jawab_order) ? "" : $jawab_order;
                $list_jawaban	.= $input[$_tidgroup]."|".$input[$_tidsoal]."|".$jawaban_."|".$input[$_ragu]."|".$audio_g_."|".$audio_s_.",";
            } else {
                $jawaban_ 	= empty($input[$_tjawabes]) ? "" : $input[$_tjawabes];
                $list_jawaban	.= $input[$_tidgroup]."|".$input[$_tidsoal]."|".$jawaban_."|".$input[$_ragu]."|".$audio_g_."|".$_audio_s.",";
            }
		}
		$list_jawaban	= substr($list_jawaban, 0, -1);
		$d_simpan = [
			'list_jawaban' => $list_jawaban
        ];
		
        // Simpan jawaban
        $tbl_ujian = $this->tbl_ujian;
		$this->general->update_data($tbl_ujian, $d_simpan, $id_tes);
		$this->output_json(['status'=>true]);
    }
    
    public function buka_group(){
        $data = [];
        $id_group = $this->input->post('id_group', true);
        $urutan = $this->input->post('urutan', true);
        $group_first = $this->input->post('group_first', true);

        $petunjuk = $this->tes->get_petunjuk_by_id($id_group);

        $data = array(
            'judul' => $petunjuk->name.' ('.$group_first.')',
            'petunjuk' => $petunjuk->petunjuk,
            'footer' => '<button type="button" class="btn btn-primary" onclick="return buka_non_group('.$urutan.')">Lanjut No '.$urutan.'</button>'
        );
        
        header("Content-Type: application/json");

        echo json_encode($data);
    }

    public function simpan_akhir(){
        $d_update = [];
        $data_group = array();
        $data_group_skor = array();
        $ujian_skor = [];
        $data_ujian_skor = [];

        // Decrypt Id
		$id_tes = $this->input->post('id', true);
        $id_tes = $this->encryption->decrypt($id_tes);
        
        $get_paket_data = $this->tes->get_paket_soal_by_tes($id_tes);
        $paket_soal = $this->tes->get_paket_soal_sesi_by_id($get_paket_data); //Get Paket Soal
		
		// Get Jawaban
		$list_jawaban = $this->tes->get_jawaban_ujian($id_tes);

		// Pecah Jawaban
		$pc_jawaban = explode(",", $list_jawaban);
		
		$jumlah_benar 	= 0;
		$jumlah_salah 	= 0;
        $jumlah_kosong  = 0;
        $jumlah_ragu    = 0;
		$skor 	        = 0;
		$jumlah_soal	= sizeof($pc_jawaban);

		foreach ($pc_jawaban as $jwb) { //Grouping Soal Jawaban
            $pc_dt 		= explode("|", $jwb);
            $group_soal = (int) $pc_dt[0];
			$id_soal 	= (int) $pc_dt[1];
			$jawaban 	= $pc_dt[2];
            $ragu 		= $pc_dt[3];
            $data_group[$group_soal][] = array('id_soal' => $id_soal, 'jawaban' => $jawaban, 'ragu' => $ragu);
        }

        $skor_total = [];
        foreach($data_group as $key_group => $val_group){ //Grouping Skor
            $group_soal_id = $key_group;
            foreach($val_group as $val_ungroup){
                $cek_jwb 	= $this->tes->get_jawaban_soal($val_ungroup['id_soal']);
                $cek_score 	= $this->tes->get_jawaban_score_soal($val_ungroup['id_soal']);
    
                $val_ungroup['jawaban'] == $cek_jwb && $val_ungroup['jawaban'] != '' ?  $jumlah_benar++ : '';
                $val_ungroup['jawaban'] != $cek_jwb && $val_ungroup['jawaban'] != '' ?  $jumlah_salah++ : '';

                if($cek_score == 0 && $val_ungroup['jawaban'] == $cek_jwb && $val_ungroup['jawaban'] != ''){
                    $skor += 1;
                } elseif($cek_score != 0 && $val_ungroup['jawaban'] == $cek_jwb && $val_ungroup['jawaban'] != '') {
                    $skor += $cek_score;
                }
    
                $val_ungroup['jawaban'] == '' || empty($val_ungroup['jawaban']) ? $jumlah_kosong++ : $jumlah_kosong;
    
                $val_ungroup['ragu'] == 'Y' && $val_ungroup['jawaban'] != '' ? $jumlah_ragu++ : $jumlah_ragu;
                $skor_total[] = $skor;
            }
            $data_group_skor[$group_soal_id][] = array('skor' => end($skor_total));
            $skor = 0;
            $skor_total = [];
        }

        $group_soal_id = '';

        foreach($data_group_skor as $key_group_skor => $val_group_skor){ //Konversi skor
            $group_soal_id = $key_group_skor;
            foreach($val_group_skor as $sub_val_group){
                $konversi_id = $this->tes->get_group_soal_ujian($group_soal_id);
                $skor_asal = $sub_val_group['skor'];
                $check_konversi = $this->tes->get_konversi_skor($konversi_id, $skor_asal);
                array_push($ujian_skor, array(
                    'ujian_id' => $id_tes,
                    'group_soal_id' => $group_soal_id,
                    'skor_original' => $sub_val_group['skor'],
                    'skor_konversi' => !empty($check_konversi) ? $check_konversi : $sub_val_group['skor'],
                    'created_datetime' => date('Y-m-d H:i:s')
                ));
            }
        }

        $check_skor_ujian = $this->tes->get_ujian_skor_detail($id_tes);
        $tbl_ujian_skor = $this->tbl_ujian_skor;
        if($check_skor_ujian){ //jika skor ujian sebelumnya sudah ada didisable dulu baru diinsert yang baru
            foreach($check_skor_ujian as $val_data_skor){
                $this->general->delete_data($tbl_ujian_skor, $val_data_skor->id);
            }
            $this->general->input_batch($tbl_ujian_skor, $ujian_skor);
        } else {
            $this->general->input_batch($tbl_ujian_skor, $ujian_skor);
        }

        $skor_total_ujian = $this->tes->get_ujian_skor_all($id_tes);
        $skala_penilaian = $paket_soal->pengaturan_universal_id;

        if($skala_penilaian == 1){ //SKALA 100
            $final_skor = ($jumlah_benar / $jumlah_soal)  * 100;
        } elseif($skala_penilaian == 2){ //SESUAI SKOR
            $final_skor = $skor_total_ujian;
        } elseif($skala_penilaian == 10){ //(TOTAL SKOR / 3) x 10
            $final_skor = ($skor_total_ujian/3)*10;
        }

        $d_update = [
			'jml_benar'		=> $jumlah_benar,
			'jml_salah'		=> $jumlah_salah,
			'jml_ragu'		=> $jumlah_ragu,
			'jml_kosong'	=> $jumlah_kosong,
			'skor'	        => str_replace(',', '.', $final_skor),
            'status'		=> 1,
            'updated_datetime' => date('Y-m-d H:i:s'),
            'tgl_selesai' => date('Y-m-d H:i:s')
        ];

        $tbl_ujian = $this->tbl_ujian;
        $this->general->update_data($tbl_ujian, $d_update, $id_tes);

        $show_hasil = 1;

		$this->output_json(['status'=>TRUE, 'id'=>$id_tes, 'hasil'=>$show_hasil]);
    }

    public function hasil_ujian($ujian_id){
        $ujian_data = $this->tes->get_checking_ujian_by_id($ujian_id); //CEK UJIAN
        $paket_soal = $this->tes->get_paket_soal_by_id($ujian_data->paket_soal_id);

        $data['content']['ujian'] = $ujian_data;
        $data['content']['paket_soal'] = $paket_soal;
        $data['title_header'] = ['title' => 'Hasil Ujian Online'];

        //for load view
        $view['css_additional'] = 'website/user/buku/ujian/result/css';
        $view['content'] = 'website/user/buku/ujian/result/content';
        $view['js_additional'] = 'website/user/buku/ujian/result/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function pembahasan($id_ujian, $id_paket_soal, $user_id){
        $paket_soal_id = base64_decode(urldecode($id_paket_soal));
        $ujian_id = base64_decode(urldecode($id_ujian));

        $data_ujian = [];
        $bank_soal = [];
        $data = [];

        $paket_soal = $this->tes->get_paket_soal_sesi_by_id($paket_soal_id); //Get Paket Soal
        $ujian_data = $this->tes->get_checking_ujian_by_id($ujian_id); //CEK UJIAN

        if(empty($ujian_data)){
            $this->session->set_flashdata('error', 'Anda belum diijikan melihat pembahasan! Silahkan kerjakan soal sampai selesai terlebih dahulu');
            redirect('buku/sbmptn/launch');
        }

        //Pengambilan data list jawaban, group soal, soalnya, dan hasil jawabannya
        $urut_soal 		= explode(",", $ujian_data->list_jawaban);
        $soal_urut_ok	= array();
        $jumlah_soal    = sizeof($urut_soal);
		for ($i = 0; $i < sizeof($urut_soal); $i++) {
			$pc_urut_soal	    = explode("|",$urut_soal[$i]);//pecah data wadah list jawaban
			$pc_urut_soal_jwb 	= empty($pc_urut_soal[2]) ? "''" : "'{$pc_urut_soal[2]}'";//List jawaban user
			$ambil_soal 	    = $this->tes->get_ujian_list_user($pc_urut_soal_jwb, $pc_urut_soal[1], $paket_soal_id);
			$soal_urut_ok[]     = $ambil_soal;
        }
        
        $soal_urut_ok = $soal_urut_ok;
        
        //Pengambilan isi dari data list ujian user
		$pc_list_jawaban = explode(",", $ujian_data->list_jawaban);
		$arr_jawab = array();
		foreach ($pc_list_jawaban as $v) {
            $pc_v 	= explode("|", $v);
            $gr     = $pc_v[0];
			$idx 	= $pc_v[1];
			$val 	= $pc_v[2];
			$rg 	= $pc_v[3];

			$arr_jawab[$idx] = array("g"=>$gr,"j"=>$val,"r"=>$rg);
        }

        $show_soal = [];
        $html = '';
        $previous_number = '';
        $next_number = '';
        $arrow_back = '';
        $arrow_next = '';
        $no_previous = '';
        $no_next = '';
        $group_soal_before = 0;
        if (!empty($soal_urut_ok)){
            $nomor_soal = 1;
            $num_group_soal = 0;
            foreach ($soal_urut_ok as $s) {
                $group_soal_next = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;

                $id_group_soal_p = $s->group_soal_parent != 0 || !empty($s->group_soal_parent) ? $s->group_soal_parent : $s->group_soal_id;
                $group_soal_p = $s->group_soal_parent_name != 0 || !empty($s->group_soal_parent_name) ? $s->group_soal_parent_name : $s->group_soal_name;

                $cek_group_mode_jwb = $s->group_mode_jwb_id == 1 ? '' : 'style="display:none;"'; //1 Pilihan ganda 2 essay
                $bacaan_soal = $s->isi_bacaan_soal <> 0 || !empty($s->isi_bacaan_soal) ? $s->isi_bacaan_soal.'<br />' : ''; // bacaan soal
                $bacaan_soal_name = $s->bacaan_soal_name <> 0 || !empty($s->bacaan_soal_name) ? '<b>'.$s->bacaan_soal_name.'</b><br />' : ''; // bacaan soal judul
                $group_soal_petunjuk = $s->group_soal_petunjuk <> 0 || !empty($s->group_soal_petunjuk) ? $s->group_soal_petunjuk.'<br />' : '';
                /* $group_soal_audio = $s->group_soal_audio <> 0 || !empty($s->group_soal_audio) ? '<audio id="loop-limited-'.$nomor_soal.'" controls controlsList="nodownload"><source src="'.config_item('_dir_website').'/lembaga/grandsbmptn/group_soal/group_'.$s->paket_soal_id.'/'.$s->group_soal_audio.'" type="'.$s->group_soal_tipe_audio.'">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : '';
                $soal_audio = $s->file <> 0 || !empty($s->file) ? '<audio id="loop-limited-'.$nomor_soal.'" controls controlsList="nodownload"><source src="'.config_item('_dir_website').'/lembaga/grandsbmptn/paket_soal/soal_'.$s->paket_soal_id.'/'.$s->file.'" type="'.$s->tipe_file.'">Browsermu tidak mendukung tag audio, upgrade donk!</audio><br /><br />' : ''; */
                
                $html .= '<div class="step card text-left font-poppins" id="widget_'.$nomor_soal.'">';
                $vrg = $arr_jawab[$s->bank_soal_id]["r"] == "" ? "N" : $arr_jawab[$s->bank_soal_id]["r"];
                $html .= '<input type="hidden" name="id_group_mode_jwb'.$nomor_soal.'" value="'.$s->group_mode_jwb_id.'">';
                $html .= '<input type="hidden" name="id_group_soal_'.$nomor_soal.'" value="'.$id_group_soal_p.'">';
                $html .= '<input type="hidden" name="group_soal_sub_'.$nomor_soal.'" value="'.$s->group_soal_name.'">';
                $html .= '<input type="hidden" name="group_soal_'.$nomor_soal.'" value="'.$group_soal_p.'">';
				$html .= '<input type="hidden" name="id_bank_soal_'.$nomor_soal.'" value="'.$s->bank_soal_id.'">';
				$html .= '<input type="hidden" name="rg_'.$nomor_soal.'" id="rg_'.$nomor_soal.'" value="'.$vrg.'">';
                
                $no_previous = $nomor_soal-1;
                $no_next = $nomor_soal+1;

                if($group_soal_next == $group_soal_before){ //Isi Group
                    $arrow_back = $nomor_soal == 1 ? '<a id="arrow_back" class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>' : '<a rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left" aria-hidden="true" title="Soal Sebelumnya"></i></a>';
                    $arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true" title="Soal Berikutnya"></i></a>';
                    
                    $previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="previous_back" rel="0" onclick="return back();" class="back btn btn-md btn-primary text-white">No '.$no_previous.'</a></div>';
                    $next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No '.$no_next.'</a></div>';

                    $ragu_ragu = '<div class="col"></div>';
                } else { // Parent Group
                    $num_group_soal++;
                    $arrow_back = $nomor_soal == 1 ? '<a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-left"></i></a>' : '<a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" class="back btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-left"></i></a>';
                    $arrow_next = $nomor_soal == $jumlah_soal ? '<a class="btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>' : '<a rel="2" onclick="return next();" class="next btn btn-sm text-primary bg-white btn-nxt-brf-hrd"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>';;

                    $previous_number = $nomor_soal == 1 ? '<div class="col"></div>' : '<div class="col"><a id="group_petunjuk_'.$nomor_soal.'" rel="0" onclick="return back();" onclick="return back_group();" class="back btn btn-md btn-primary text-white">No '.$no_previous.'</a></div>';
                    $next_number = $nomor_soal == $jumlah_soal ? '<div class="col"></div>' : '<div class="col"><a rel="2" onclick="return next();" class="next btn btn-md btn-primary text-white">No '.$no_next.'</a></div>';
                    
                    $ragu_ragu = '<div class="col"></div>';
                }

                $html .= '
                    <div class="card-header bg-primary text-white">
                        <div class="row">
                            <div class="col">
                                <h5><i class="fa fa-braille" aria-hidden="true"></i> Soal No #'.$nomor_soal.' / '.$jumlah_soal.'</h5>
                            </div>
                            <div class="col text-right">
                                <a id="_increase" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _increase();"><i class="fa fa-plus-square" aria-hidden="true" title="Zoom In"></i></a>
                                <a id="_reset" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _reset();"><i class="fa fa-sync" aria-hidden="true" title="Default"></i></a>
                                <a id="_decrease" class="btn btn-sm text-primary bg-white" data-position="up" onclick="return _decrease();"><i class="fa fa-minus-square" aria-hidden="true" title="Zoom Out"></i></a>
                                <span class="btn-nxt-brf-hrd">|</span>
                                '.$arrow_back.'
                                '.$arrow_next.'
                            </div>
                        </div>
                    </div>';

                $html .= '<div class="card-body">';

                $pembahasan = $this->tes->get_pembahasan($s->bank_soal_id);
                $url_video = !empty($pembahasan->url) ? '<div class="player"><iframe width="762" height="400" src="'.$pembahasan->url.'" frameborder="0" allowfullscreen></iframe></div>' : '';
                $text_pembahasan = !empty($pembahasan->pembahasan) ? '<p>'.$pembahasan->pembahasan.'</p>' : '';
                $pembahasan = !empty($pembahasan->pembahasan) || !empty($pembahasan->url) ? '<h5>Pembahasan : </h5>' : '';

                $html .= '<div class="row">
                <center><div class="m-3">'.$pembahasan.$url_video.'</div>
                <div class="text-left m-3">'.$text_pembahasan.'</div></center>
                </div>';

                $html .= '<div class="card-text text-justify">'.$bacaan_soal_name.$bacaan_soal.$s->bank_soal_name.'</div><hr>';

                if($s->group_mode_jwb_id == 1){
                    $html .= '<div class="card-text mt-2">
                            <p><b>Pilih salah satu jawaban!</b></p>
                        </div>
                        <div class="funkyradio text-justify">';
                    $jawaban = $this->tes->get_jawaban_by_id_pembahasan($s->bank_soal_id, $s->paket_soal_id);
                    $jawaban_benar = $this->tes->get_jawaban_by_id_benar($s->bank_soal_id, $s->paket_soal_id);
                    $opsi = config_item('_def_opsi_jawaban');
                    $jawaban_soal = [];
                    $number_opsi = 1;
                    foreach($jawaban as $key_jawaban => $val_jawaban) {
                        $checked = $arr_jawab[$s->bank_soal_id]["j"] == $val_jawaban->order ? "checked" : "";
                        if($number_opsi != $jawaban_benar && $number_opsi != $arr_jawab[$s->bank_soal_id]["j"]){ //Selain jawaban salah dan benar
                            $html .= '<div class="funkyradio-default">
                                <input type="checkbox" style="display:none;" id="key_'.$opsi.'_'.$nomor_soal.'" name="key_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'|'.$jawaban_benar.'">
                                <input type="checkbox" id="opsi_'.$opsi.'_'.$nomor_soal.'" name="opsi_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'" disabled> 
                                <label for="opsi_'.$opsi.'_'.$nomor_soal.'">
                                    <div class="huruf_opsi">'.$opsi.'</div> 
                                    <div class="card-text">'.$val_jawaban->name.'</div>
                                </label>
                            </div>';
                        } elseif($number_opsi == $jawaban_benar && $number_opsi == $arr_jawab[$s->bank_soal_id]["j"]){ //Jawaban benar dari user
                            $html .= '<div class="funkyradio-success">
                                <input type="checkbox" style="display:none;" id="key_'.$opsi.'_'.$nomor_soal.'" name="key_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'|'.$jawaban_benar.'" '.$checked.'>
                                <input type="checkbox" id="opsi_'.$opsi.'_'.$nomor_soal.'" name="opsi_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'" '.$checked.' disabled> 
                                <label style="background:#86C186;" for="opsi_'.$opsi.'_'.$nomor_soal.'">
                                    <div class="huruf_opsi">'.$opsi.'</div> 
                                    <div class="card-text">'.$val_jawaban->name.'</div>
                                </label>
                            </div>';
                        } elseif($number_opsi == $jawaban_benar){ //Jawaban benar dari sistem
                            $html .= '<div class="funkyradio-success">
                                <input type="checkbox" style="display:none;" id="key_'.$opsi.'_'.$nomor_soal.'" name="key_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'|'.$jawaban_benar.'">
                                <input type="checkbox" id="opsi_'.$opsi.'_'.$nomor_soal.'" name="opsi_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'" disabled>
                                <label style="background:#86C186;" for="opsi_'.$opsi.'_'.$nomor_soal.'">
                                    <div class="huruf_opsi">'.$opsi.'</div> 
                                    <div class="card-text">'.$val_jawaban->name.'</div>
                                </label>
                            </div>';
                        } elseif($jawaban_benar != $arr_jawab[$s->bank_soal_id]["j"]) { //Jawaban salah dari user
                            $html .= '<div class="funkyradio-danger">
                                <input type="checkbox" style="display:none;" id="key_'.$opsi.'_'.$nomor_soal.'" name="key_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'|'.$jawaban_benar.'" '.$checked.'>
                                <input type="checkbox" id="opsi_'.$opsi.'_'.$nomor_soal.'" name="opsi_'.$nomor_soal.'" value="'.$val_jawaban->order.'|'.$number_opsi.'" '.$checked.' disabled> 
                                <label style="background:#df706d;" for="opsi_'.$opsi.'_'.$nomor_soal.'">
                                    <div class="huruf_opsi">'.$opsi.'</div> 
                                    <div class="card-text">'.$val_jawaban->name.'</div>
                                </label>
                            </div>';
                        }
                        $opsi++;
                        $number_opsi++;
                    };
                    $html .= '</div>';
                } else{
                    $history_jawab = !empty($arr_jawab[$s->bank_soal_id]["j"]) ? $arr_jawab[$s->bank_soal_id]["j"] : "";
                    $html .= '<div class="form-group">
                        <label class="card-text mt-2" for="essay_'.$nomor_soal.'">Masukkan jawaban anda dibawah ini</label>
                        <textarea class="form-control" id="essay_'.$nomor_soal.'" name="essay_'.$nomor_soal.'" rows="5">'.$history_jawab.'</textarea>
                    </div>';
                }

                if($jawaban_benar && $jawaban_benar == 1){
                    $key_opsi = 'A';
                } elseif($jawaban_benar && $jawaban_benar == 2){
                    $key_opsi = 'B';
                } elseif($jawaban_benar && $jawaban_benar == 3){
                    $key_opsi = 'C';
                } elseif($jawaban_benar && $jawaban_benar == 4){
                    $key_opsi = 'D';
                } elseif($jawaban_benar && $jawaban_benar == 5){
                    $key_opsi = 'E';
                }

                $html .= '<div class="row">
                <h5 class="card-text mt-2 ml-3">Jawaban Benar : '.$key_opsi.'</h5>
                </div>';

                $html .= '</div>';

                $html .= '<div class="card-footer text-muted">
                        <div class="row text-center">
                            '.$previous_number.'
                            '.$ragu_ragu.'
                            '.$next_number.'
                        </div>
                    </div>
                </div>';

                $nomor_soal++;

                $group_soal_before = $group_soal_next;
            }
        }
        
        //for passing data to view
        $data['content']['paket_soal'] = $paket_soal;
        $data['content']['lembar_jawaban'] = $html;
        $data['content']['ujian'] = $ujian_data;
        $data['content']['ujian_id'] = $this->encryption->encrypt($ujian_data->id);
        $data['content']['jumlah_soal'] = $nomor_soal;
        $data['title_header'] = ['title' => 'Pembahasan Ujian Online'];

        //for load view
        $view['css_additional'] = 'website/user/buku/ujian/css';
        $view['content'] = 'website/user/buku/ujian/pembahasan/content';
        $view['js_additional'] = 'website/user/buku/ujian/pembahasan/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function tonton($id_config_detail){
        $url_past = $_SERVER['HTTP_REFERER'];

        //for passing data to view
        $data['content']['data'] = $this->management->get_config_buku_detail_download($id_config_detail);
        $data['content']['url_back'] = $url_past;
        $data['title_header'] = ['title' => 'Video Materi'];

        //for load view
        $view['css_additional'] = 'website/user/buku/tonton/css';
        $view['content'] = 'website/user/buku/tonton/content';
        $view['js_additional'] = 'website/user/buku/tonton/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

}