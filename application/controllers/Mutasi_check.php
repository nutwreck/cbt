<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_check extends CI_Controller {

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
            var_dump($get_data);
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

            //sampai sini boss

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

                $data_update_invoice = array( //DATA UNTUK UPDATE INVOICE
                    "invoice_date_update" => date('Y-m-d h:i:s'),
                    "confirm_status" => 1,
                    "is_check" => 1,
                    "date_check" => $start_date,
                    "status" => 1,
                );
                $no_invoice = $clean_data['invoice_number'];

                $check_id_mutation = $this->Get_nominal_invoice->mutation_bank_list($mutation_id); //CEK ID MUTASI SEBELUMNYA

                if($check_id_mutation){ //JIKA ID MUTASI SEBELUMNYA SUDAH ADA LANGSUNG UPDATE INVOICENYA
                    $update_invoice = $this->Get_nominal_invoice->update_invoice($data_update_invoice, $no_invoice);//INSERT DATA MUTATION BANK
                    //echo 'berhasil hanya update '.$clean_data['invoice_number'].'<br />';
                } else {
                    $insert_mutation = $this->Get_nominal_invoice->mutation_bank($data_hit_save);//INSERT DATA MUTATION BANK

                    $update_invoice = $this->Get_nominal_invoice->update_invoice($data_update_invoice, $no_invoice);//INSERT DATA MUTATION BANK

                    if($insert_mutation !== 'Rollback' && $update_invoice !== 'Rollback'){ //JIKA DATA BERHASIL DISIMPAN DAN UPDATE INVOICE
                        $this->send_email_confirm($no_invoice);
                        //echo 'Berhasil simpan '.$clean_data['invoice_number'].'<br />';
                    } else { //JIKA INSERT DATA MUTASI DAN UPDATE INVOICE GAGAL KEMBALI LAGI KE LOOPING
                        $this->loop_mutasi($get_data);
                    }
                }
            } elseif($status_data_mutation == 1 && $eror_msg_mutation == '' && empty($status_data_response)){ //JIKA TIDAK DITEMUKAN DATA MUTASINYA TIDAK MELAKUKKAN APA-APA
                /* echo 'tidak ditemukan data '.$clean_data['invoice_number'].'<br />'; */
            } else {
                die();
            }
        }
    }

    public function send_email_confirm($no_invoice){
        $item_user = $this->Update_auto_confirm->Get_user_invoice($no_invoice);

        for($i = 0; $i < sizeof($item_user); $i++) {
            $user_id =  $item_user[$i]['user_id'];
            $event_id =  $item_user[$i]['event_id'];
            $invoice_number = $item_user[$i]['invoice_number'];

            $this->data['data'] = $this->Update_auto_confirm->send_user_data($user_id,$event_id,$invoice_number);
            $send_to = $item_user[$i]['email'];
            
            /*Confirm*/
            $invoice_file = $invoice_number."-".$user_id.".pdf";
            $name_file = $invoice_file;
            $location = 'assets/confirm/';
            $mpdf = new \Mpdf\Mpdf();

            $this->data['invoice_file'] = $invoice_file;

            $data = $this->load->view('website/confirm_invoice/content.php',$this->data, TRUE);
			$mpdf->WriteHTML($data);

            //$mpdf->Output();
            $mpdf->Output($location .$invoice_file, \Mpdf\Output\Destination::FILE);

            $this->email->clear(TRUE);

            /*email*/
            $from = $this->config->item('smtp_user');
            $subject = 'Zambert Confirm Invoice Success';
            $message = $this->load->view('website/email/confirm_invoice.php',$this->data,TRUE);

            $this->email->set_newline("\r\n");
            $this->email->from($from, '[NO-REPLY] Zambert System');
            $this->email->to($send_to);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->attach(base_url().'assets/confirm/'.$name_file);
            $this->email->send();
        }
    }
}