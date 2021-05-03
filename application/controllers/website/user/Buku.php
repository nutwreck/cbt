<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    private $length_pass = 15;
    private $sbmptn_id = 2;
    private $toefl_id = 1;
    private $cpns_id = 3;
    private $tbl_kode_unik = 'kode_unik';
    private $tbl_invoice = 'invoice';

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
            $this->generate_no_invoice();
        } else {
            return $no_invoice;
        }
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
        if(!empty($get_check_invoice)){
            $free_paket = NULL;
            $data['content']['sbmptn_paket'] = $this->tes->get_paket_soal_buku($sbmptn_id, $jurusan, $free_paket);
        } else {
            $data['content']['sbmptn_paket'] = $this->tes->get_paket_soal_buku($sbmptn_id, $jurusan, $free_paket);
        }
        $data['content']['status_user'] = !empty($get_check_invoice) ? 'purchase' : 'free';
        $data['content']['free_paket'] = $free_paket;

        if($id_config_buku_group == 'launch'){
            $data['content']['group_stat'] = 0;
            $data['content']['buku_group'] = $this->management->get_config_buku_group_by_buku($sbmptn_id);
        } else {
            $config_buku_group_id = base64_decode(urldecode($id_config_buku_group));
            $data['content']['group_stat'] = 1;
            $data['content']['buku_group'] = $this->management->get_config_buku_detail_by_id($config_buku_group_id);
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
        } elseif($buku_id == 1 && $detail_buku_check == 2){
            $detail_buku_name = 'SOSHUM';
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

        $tbl_kode_unik = $this->tbl_kode_unik;
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

}