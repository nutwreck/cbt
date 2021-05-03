<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_check extends CI_Controller {

    private $tbl_invoice = 'invoice';
    private $tbl_hit_mutation = 'hit_mutation';
    private $tbl_user_pembelian_buku = 'user_pembelian_buku';

    function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->config('email'); //SET CONFIG EMAIL
        $this->load->model('General','general');
        $this->load->model('Management_model','management');
    }

    public function index(){
        //DATA INVOICE HARI INI YANG STATUSNYA MASIH REGISTRASI DAN BELUM DIKONFIRM
        $get_data = $this->management->Invoice_nominal();

        /* echo '<pre>';
        var_Dump($get_data);
        echo '</pre>';
        die(); */

        if(!empty($get_data)){
            $this->checking_balance($get_data);
        } else {
            echo 'no data';
        }
    }

    public function checking_balance($get_data){
        $ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/balance",
			CURLOPT_POST            => true,
			CURLOPT_HTTPHEADER      => ["Api-Key: 0c170393b96bed553820fda3166ec7655f98f7459ea44", "Accept: application/json"], // tanpa tanda kurung
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HEADER          => false,
			CURLOPT_IPRESOLVE		=> CURL_IPRESOLVE_V4,
		));
		$balance = curl_exec($ch);
		curl_close($ch);
		$balance_decode = json_decode($balance);
		$response_balance = $balance_decode->response;
        $balance = $response_balance->balance;

        if($balance <= 0){
            var_dump($balance);
        } else {
            $this->loop_mutasi($get_data);
        }
    }

    public function loop_mutasi($get_data){
        $get_datas = [];
        $datas = [];

        foreach($get_data as $pass_data) { //CONVERT TO ARRAY
            $get_datas[] = $pass_data;
        }

        //PARAMETER
        $start_date = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 23:59:59',strtotime('+1 day'));

        foreach($get_datas as $clean_data) { //EKSESKUSI LOOP DATA MUTASI KE CEK MUTASINYA
            $payment_method_detail_name = explode("-", $clean_data['payment_method_detail_name']);
            $bank = trim(strtolower($payment_method_detail_name[0]));
            $account_number = trim($payment_method_detail_name[2]);
            $mutasi_data = array(
                "search"  => array(
                    "date"		=> [
                        "from"	=> $start_date,
                        "to"	=> $end_date,
                    ],
                    "type"				=> "credit", //HANYA CEK TRANSAKSI MASUK
                    "service_code"   	=> $bank,
                    "account_number"  	=> $account_number,
                    "amount"          	=> $clean_data['invoice_total_cost']
                )
            );
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/bank/search",
                CURLOPT_POST            => true,
                CURLOPT_POSTFIELDS      => http_build_query($mutasi_data),
                CURLOPT_HTTPHEADER      => ["Api-Key: 0c170393b96bed553820fda3166ec7655f98f7459ea44", "Accept: application/json"], // tanpa tanda kurung
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER          => false,
                CURLOPT_IPRESOLVE		=> CURL_IPRESOLVE_V4,
            ));
            $mutasi = curl_exec($ch);
            curl_close($ch);
            $mutasi_decode = json_decode($mutasi);

            foreach($mutasi_decode as $key => $value){
                $datas[$key] = $value;
            }

            $status_data_mutation = $datas['success'];
            $eror_msg_mutation = $datas['error_message'];
            $status_data_response = $datas['response'];

            $data_hit_save = [];
            $data_mutation = [];

            if($status_data_mutation == true && $eror_msg_mutation == '' && !empty($status_data_response)) { //JIKA DATA DITEMUKAN
                foreach($status_data_response as $value){
                    $data_mutation[] = $value;
                }

                foreach($data_mutation as $clean_mutation_val){
                    $description = $clean_mutation_val->description;
                    $amount = $clean_mutation_val->amount;
                    $type = $clean_mutation_val->type;
                    $mutation_id = $clean_mutation_val->id;
                    $token = $clean_mutation_val->unix_timestamp;
                }

                $data_hit_save = array( //DATA UNTUK MENYIMPAN HIT MUTASINYA
                    "date" => $start_date, 
                    "description" => $description, 
                    "amount" => $amount, 
                    "type" => 'CR', 
                    "note" => '',
                    "created_at" => $start_date,
                    "updated_at" => $start_date,
                    "mutation_id" => $mutation_id,
                    "token" => $token,
                    "post_date" => $start_date
                );

                $no_invoice = $clean_data['invoice_number'];
                $id_invoice = $clean_data['id'];

                $check_id_mutation = $this->management->mutation_bank_list($mutation_id); //CEK ID MUTASI SEBELUMNYA

                if($check_id_mutation){ //JIKA ID MUTASI SEBELUMNYA SUDAH ADA LANGSUNG UPDATE INVOICENYA
                    $this->send_email_confirm($id_invoice);
                } else {
                    $tbl_hit_mutation = $this->tbl_hit_mutation;
                    $insert_mutation = $this->general->insert_data($tbl_hit_mutation, $data_hit_save);//INSERT DATA MUTATION BANK

                    if($insert_mutation){ //JIKA DATA BERHASIL DISIMPAN LANJUT UPDATE INVOICE
                        $this->send_email_confirm($id_invoice);
                        //echo 'Berhasil simpan '.$clean_data['invoice_number'].'<br />';
                    } else { //JIKA INSERT DATA MUTASI DAN UPDATE INVOICE GAGAL KEMBALI LAGI KE LOOPING
                        /* $this->loop_mutasi($get_data); */
                    }
                }
            } elseif($status_data_mutation == true && $eror_msg_mutation == '' && empty($status_data_response)){ //JIKA TIDAK DITEMUKAN DATA MUTASINYA TIDAK MELAKUKKAN APA-APA
                /* echo 'tidak ditemukan data '.$clean_data['invoice_number'].'<br />'; */
            } else {
               
            }
        }
    }

    public function send_email_confirm($id_invoice){
        $item_user = $this->management->get_invoice_by_id($invoice_id);

        if(!empty($item_user)){
            $data = [];
            $datas = [];
            $list_pembelian = [];
            $invoice_id = base64_decode(urldecode($id_invoice));

            $data_invoice = $this->management->get_invoice_by_id($invoice_id);

            $status_data = $data_invoice->status;
            $reject_data = $data_invoice->reject_desc;

            $now = date('Y-m-d H:i:s');
            $data = array(
                'status' => 2, //Invoice Success
                'reject_desc' => NULL,
                'updated_datetime' => $now,
                'invoice_date_update' => $now
            );

            $datas['invoice'] = $data_invoice;

            $tbl = $this->tbl_invoice;
            $update = $this->general->update_data($tbl, $data, $invoice_id);

            if($update){
                $this->email->clear(TRUE);

                $from = $this->config->item('smtp_user');
                $subject = 'Invoice #'.$data_invoice->invoice_number.' '.format_indo($now).' '.(Lunas);
                $message = $this->load->view('website/lembaga/management/invoice/confirm_success/content', $datas, TRUE);

                $this->email->set_newline("\r\n");
                $this->email->from($from, '[NO-REPLY] Zambert');
                $this->email->to($data_invoice->user_email);
                $this->email->subject($subject);
                $this->email->message($message);

                if($this->email->send()){
                    $message = '';

                    $list_pembelian = array(
                        'invoice_id' => $invoice_id,
                        'invoice_number' => $data_invoice->invoice_number,
                        'user_id' => $data_invoice->user_id,
                        'user_name' => $data_invoice->user_name,
                        'user_email' => $data_invoice->user_email,
                        'user_telp' => $data_invoice->user_no_telp,
                        'buku_id' => $data_invoice->buku_id,
                        'detail_buku_id' => $data_invoice->detail_buku_id,
                        'created_datetime' => $now,
                    );

                    $tbl_user_pembelian_buku = $this->tbl_user_pembelian_buku;
                    $this->general->input_data($tbl_user_pembelian_buku, $list_pembelian);

                    return 'OK';
                } else { //jika email tidak terkirim invoice dibatalkan / disable
                    $rollback = [];
                    $tbl_invoice = $this->tbl_invoice;
                    $rollback = array(
                        'status' => $status_data,
                        'reject_desc' => $reject_data,
                        'updated_datetime' => $now,
                        'invoice_date_update' => $now
                    );
                    $this->general->update_data($tbl_invoice, $rollback, $invoice_id);
                    
                    return 'ROLLBACK';
                }
            } else {
                return 'ERROR';
            }
        }
    }
}