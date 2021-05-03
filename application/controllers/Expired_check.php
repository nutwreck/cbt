<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expired_check extends CI_Controller {

    private $tbl_invoice = 'invoice';

    function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('General','general');
        $this->load->model('Management_model','management');
    }

	public function index(){
        $data = [];
        $invoice_exp = '';

        $invoice_exp =  $this->management->list_invoice_expired();
        $tbl = $this->tbl_invoice;

        if(!empty($invoice_exp)){
            foreach ($invoice_exp as $key_invoice => $item_invoice) {
                $now = date('Y-m-d H:i:s');
                $data = [];
    
                $data = array(
                    'status' => 3, //Expired
                    'reject_desc' => NULL,
                    'updated_datetime' => $now,
                    'invoice_date_update' => $now
                );
    
                $this->general->update_data($tbl, $data, $item_invoice['id']);
            }
        } else {
            echo 'no data';
        }
	}




}
