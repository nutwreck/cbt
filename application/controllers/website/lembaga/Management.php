<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Management extends CI_Controller {
    /**
	 * Author : Candra Aji Pamungkas
     * Create : 12-04-2021
     * Change :
     *      - {date} | {description}
	 */

    private $tbl_lembaga = 'lembaga';
    private $tbl_konversi_skor = 'konversi_skor';
    private $tbl_detail_konversi_skor = 'detail_konversi_skor';
    private $tbl_payment_method_detail = 'payment_method_detail';
    private $tbl_buku = 'buku';
    private $tbl_config_buku = 'config_buku';
    private $tbl_config_buku_detail = 'config_buku_detail';

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
            redirect('admin/login');
        }
        $this->load->model('General','general');
        $this->load->model('Management_model','management');
        $this->load->model('Invoice_list_admin_model','invoice_list_admin');
        $this->load->model('Invoice_confirm_admin_model','invoice_confirm_admin');
        $this->load->model('Invoice_success_admin_model','invoice_success_admin');
        $this->load->model('Invoice_expired_admin_model','invoice_expired_admin');
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

    /*
    |
    | END FUNCTION IN THIS CONTROLLER
    |
    */

    public function data_lembaga(){
        //for passing data to view
        $data['content']['data_lembaga'] = $this->management->get_lembaga();
        $data['content']['get_kota_kab'] = $this->management->get_kota_kab();
        $data['content']['get_type_lembaga'] = $this->management->get_type_lembaga();
        $data['title_header'] = ['title' => 'Data Lembaga'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/data_lembaga/css';
        $view['content'] = 'website/lembaga/management/data_lembaga/content';
        $view['js_additional'] = 'website/lembaga/management/data_lembaga/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_data_lembaga(){
        $data = [];
        $lembaga_id = $this->input->post('lembaga_id', TRUE);
        $data['name'] = $this->input->post('name', TRUE);
        $data['lembaga_type_id'] = $this->input->post('lembaga_type_id', TRUE);
        $data['email'] = $this->input->post('email', TRUE);
        $data['alamat'] = $this->input->post('alamat');
        $data['no_telp'] = $this->input->post('no_telp', TRUE);
        $lembaga_kota_kab_data = $this->input->post('kota_kab_id', TRUE);
        $exp_kota_kab = explode("|", $lembaga_kota_kab_data);
        $data['kota_kab_id'] = $exp_kota_kab[0];
        $data['kota_kab'] = $exp_kota_kab[1];
        $data['informasi'] = $this->input->post('informasi');
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_lembaga;
        $update = $this->general->update_data($tbl, $data, $lembaga_id);

        $urly = 'admin/data-lembaga';
        $urlx = 'admin/data-lembaga';
        $this->update_end($update, $urly, $urlx);
    }

    public function konversi(){
        //for passing data to view
        $data['content']['konversi'] = $this->management->get_konversi();
        $data['title_header'] = ['title' => 'Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/content';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_konversi(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Add Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/add';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_add_konversi(){
        $data['name'] = $this->input->post('name');
        $data['created_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_konversi_skor;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'admin/konversi-skor';
        $urlx = 'admin/add-konversi-skor';
        $this->input_end($input, $urly, $urlx);
    }

    public function edit_konversi($id_konversi){
        $konversi_id = base64_decode(urldecode($id_konversi));
        //for passing data to view
        $data['content']['konversi'] = $this->management->get_konversi_by_id($konversi_id);
        $data['content']['id_konversi'] = $id_konversi;
        $data['title_header'] = ['title' => 'Edit Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/edit';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_konversi(){
        $konversi_skor_id_crypt = $this->input->post('id_konversi');
        $konversi_skor_id = base64_decode(urldecode($konversi_skor_id_crypt));

        $data['name'] = $this->input->post('name', TRUE);
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_konversi_skor;
        $update = $this->general->update_data($tbl, $data, $konversi_skor_id);

        $urly = 'admin/konversi-skor';
        $urlx = 'admin/edit-konversi-skor/'.$konversi_skor_id_crypt;
        $this->update_end($update, $urly, $urlx);
    }

    public function disable_konversi($id_konversi){
        $konversi_skor_id = base64_decode(urldecode($id_konversi));

        $tbl = $this->tbl_konversi_skor;
        $delete = $this->general->delete_data($tbl, $konversi_skor_id);

        $urly = 'admin/konversi-skor';
        $urlx = 'admin/konversi-skor';
        $this->delete_end($delete, $urly, $urlx);
    }

    public function detail_konversi($id_konversi){
        $konversi_skor_id = $konversi_id = base64_decode(urldecode($id_konversi));

        //for passing data to view
        $data['content']['detail_konversi'] = $this->management->get_detail_konversi_by_konversi($konversi_skor_id);
        $data['content']['id_konversi'] = $id_konversi;
        $data['title_header'] = ['title' => 'Detail Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/content';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_detail_konversi($id_konversi){
        //for passing data to view
        $data['content']['id_konversi'] = $id_konversi;
        $data['title_header'] = ['title' => 'Add Detail Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/add';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_add_detail_konversi(){
        $konversi_skor_id_crypt = $this->input->post('id_konversi');
        
        $data['konversi_skor_id'] = $konversi_id = base64_decode(urldecode($konversi_skor_id_crypt));
        $data['skor_asal'] = $this->input->post('skor_asal', TRUE);
        $data['skor_konversi'] = $this->input->post('skor_konversi', TRUE);
        $data['created_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_detail_konversi_skor;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'admin/detail-konversi-skor/'.$konversi_skor_id_crypt;
        $urlx = 'admin/add-detail-konversi-skor/'.$konversi_skor_id_crypt;
        $this->input_end($input, $urly, $urlx);
    }

    public function edit_detail_konversi($id_detail_konversi, $id_konversi){
        $detail_konversi_id = base64_decode(urldecode($id_detail_konversi));
        //for passing data to view
        $data['content']['detail_konversi'] = $this->management->get_detail_konversi_by_id($detail_konversi_id);
        $data['content']['id_detail_konversi'] = $id_detail_konversi;
        $data['content']['id_konversi'] = $id_konversi;
        $data['title_header'] = ['title' => 'Edit Detail Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/edit';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_detail_konversi(){
        $id_konversi = $this->input->post('id_konversi');
        $detail_konversi_skor_id_crypt = $this->input->post('id_detail_konversi');
        $detail_konversi_skor_id = $konversi_id = base64_decode(urldecode($detail_konversi_skor_id_crypt));

        $data['skor_asal'] = $this->input->post('skor_asal', TRUE);
        $data['skor_konversi'] = $this->input->post('skor_konversi', TRUE);
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_detail_konversi_skor;
        $update = $this->general->update_data($tbl, $data, $detail_konversi_skor_id);

        $urly = 'admin/detail-konversi-skor/'.$id_konversi;
        $urlx = 'admin/edit-detail-konversi-skor/'.$id_konversi;
        $this->update_end($update, $urly, $urlx);
    }

    public function disable_detail_konversi($id_detail_konversi, $id_konversi){
        $detail_konversi_skor_id = base64_decode(urldecode($id_detail_konversi));

        $tbl = $this->tbl_detail_konversi_skor;
        $delete = $this->general->delete_data($tbl, $detail_konversi_skor_id);

        $urly = 'admin/detail-konversi-skor/'.$id_konversi;
        $urlx = 'admin/detail-konversi-skor/'.$id_konversi;
        $this->delete_end($delete, $urly, $urlx);
    }

    public function import_detail_konversi($id_konversi, $datas = NULL){
        $name_config = 'TEMPLATE UPLOAD';
        $detail_config = 'UPLOAD DATA KONVERSI';

        if(!empty($datas)){
            $data['content']['message'] = $datas;
        } else {
            $data['content']['message'] = ''; 
        }

        //for passing data to view
        $data['content']['id_konversi'] = $id_konversi;
        $data['content']['file_template'] = $this->management->get_pengaturan_universal_id($name_config, $detail_config);
        $data['title_header'] = ['title' => 'Import Detail Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/upload_excel';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_import_detail_konversi(){
        $konversi_id_crypt = $this->input->post('id_konversi');
        $konversi_id = base64_decode(urldecode($konversi_id_crypt));

        //Define penampung data
        $skor_asal = '';
        $skor_konversi = '';
        $detail_konversi = '';

        if($_FILES["data_konversi"]["name"] != '') {
            $allowed_extension = array('xls', 'xlsx');
            $file_array = explode(".", $_FILES["data_konversi"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)) {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['data_konversi']['tmp_name'], $file_name);
                $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                $spreadsheet = $reader->load($file_name);

                unlink($file_name);

                $data = $spreadsheet->getActiveSheet()->toArray();

                $no_null = 0;
                $no_upload = 0;
                //Detail data untuk peserta dan user
                foreach($data as $key => $row) {
                    if($key > 0 && (($row[0] != '' && $row[1] != '') || ($row[0] >= 0 && $row[1] >= 0))){ //Header tidak diikutkan di save
                        //Define
                        $skor_asal = trim($row[0]);
                        $skor_konversi = trim($row[1]);

                        $data = [];
        
                        $tbl = $this->tbl_detail_konversi_skor;
                        $data = array(
                            'konversi_skor_id' => $konversi_id,
                            'skor_asal' => $skor_asal,
                            'skor_konversi' => $skor_konversi,
                            'created_datetime' => date('Y-m-d H:i:s')
                        );

                        $insert_konversi = $this->general->input_data($tbl, $data);

                        $no_upload++;
                    } elseif($key > 0 && ($row[0] == '' && $row[1] == '')){
                        $no_null++;
                    }
                }

                if($no_null){
                    $text = '<div class="alert alert-info">'.$no_upload.' Data berhasil disimpan, Tetapi Terdapat '.$no_null.' data upload yang gagal, periksa kembali jika ada data yang masih kosong</div>';
                    $this->import_detail_konversi($konversi_id_crypt, $text);
                } else {
                    $text = '<div class="alert alert-success">'.$no_upload.' Data berhasil disimpan</div>';
                    $this->import_detail_konversi($konversi_id_crypt, $text);
                }
            } else {
                $text = '<div class="alert alert-danger">Hanya tipe excel .xls dan .xlsx yang diijinkan</div>';
                $this->import_detail_konversi($konversi_id_crypt, $text);
            }
        } else {
            $text = '<div class="alert alert-danger">Tidak ada file yang diupload</div>';
            $this->import_detail_konversi($konversi_id_crypt, $text);
        }
    }

    public function pembayaran_master(){
        //for passing data to view
        $data['content']['pembayaran_master'] = $this->management->get_pembayaran_master();
        $data['title_header'] = ['title' => 'Master Pembayaran'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
        $view['content'] = 'website/lembaga/management/pembayaran_master/content';
        $view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function detail_pembayaran_master($id_pembayaran_master){
        $pembayaran_master_id = base64_decode(urldecode($id_pembayaran_master));
        //for passing data to view
        $data['content']['detail_pembayaran_master'] = $this->management->get_pembayaran_master_by_id($pembayaran_master_id);
        $data['content']['pembayaran_master_id'] = $pembayaran_master_id;
        $data['content']['id_pembayaran_master'] = $id_pembayaran_master;
        $data['title_header'] = ['title' => 'Detail Master Pembayaran'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
        $view['content'] = 'website/lembaga/management/pembayaran_master/detail';
        $view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_detail_pembayaran_master($pembayaran_master_id){
        //for passing data to view
        $data['content']['id_pembayaran_master'] = $pembayaran_master_id;
        $data['title_header'] = ['title' => 'Add Detail Master Pembayaran'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
        $view['content'] = 'website/lembaga/management/pembayaran_master/add';
        $view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_add_detail_pembayaran_master(){
        $data = [];
        $pembayaran_master_id_crypt = $this->input->post('id_pembayaran_master');
        $pembayaran_master_id = base64_decode(urldecode($pembayaran_master_id_crypt));

        $data['payment_method_id'] = $pembayaran_master_id;
        //logo payment
        $config['upload_path']      = FCPATH.'storage/website/lembaga/grandsbmptn/master_pembayaran/';
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['encrypt_name']     = TRUE;
        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }
        
        $this->load->library('upload', $config);

        if(!empty($_FILES['logo_payment']['name'])){
            if (!$this->upload->do_upload('logo_payment')){
                $error = $this->upload->display_errors();
                show_error($error, 500, 'File Gambar Logo Payment Error');
                exit();
            }else{
                $data['logo_payment'] = $this->upload->data('file_name');
            }
        }

        //Image Payment
        $config['upload_path']      = FCPATH.'storage/website/lembaga/grandsbmptn/master_pembayaran/';
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['encrypt_name']     = TRUE;
        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }
        
        $this->load->library('upload', $config);

        if(!empty($_FILES['image_payment']['name'])){
            if (!$this->upload->do_upload('image_payment')){
                $error = $this->upload->display_errors();
                show_error($error, 500, 'File Gambar Image Payment Error');
                exit();
            }else{
                $data['image_payment'] = $this->upload->data('file_name');
            }
        }

        $data['bank_name'] = $this->input->post('bank_name', TRUE);
        $data['bank_account'] = $this->input->post('bank_account', TRUE);
        $data['bank_number'] = $this->input->post('bank_number', TRUE);
        $data['created_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_payment_method_detail;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'admin/detail-pembayaran-master/'.$pembayaran_master_id_crypt;
        $urlx = 'admin/add-detail-pembayaran-master/'.$pembayaran_master_id_crypt;
        $this->input_end($input, $urly, $urlx);
    }

    public function edit_detail_pembayaran_master($id_pembayaran_detail_master){
        $pembayaran_detail_master_id = base64_decode(urldecode($id_pembayaran_detail_master));
        //for passing data to view
        $data['content']['detail_pembayaran_master'] = $this->management->get_detail_master_pembayaran($pembayaran_detail_master_id);
        $data['content']['id_pembayaran_detail_master'] = $id_pembayaran_detail_master;
        $data['title_header'] = ['title' => 'Edit Detail Master Pembayaran'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/pembayaran_master/css';
        $view['content'] = 'website/lembaga/management/pembayaran_master/edit';
        $view['js_additional'] = 'website/lembaga/management/pembayaran_master/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_detail_pembayaran_master(){
        $data = [];
        $pembayaran_detail_master_id_crypt = $this->input->post('id_pembayaran_detail_master');
        $pembayaran_detail_master_id = base64_decode(urldecode($pembayaran_detail_master_id_crypt));

        $pembayaran_master_id_crypt = $this->input->post('id_pembayaran_master');
        $pembayaran_master_id = base64_decode(urldecode($pembayaran_master_id_crypt));

        //logo payment
        $old_name_logo = $this->input->post('old_name_logo');
            if($old_name_logo == NULL || $old_name_logo == ''){
                $old_name_logo_x = NULL;
            } else {
                $old_name_logo_x = $old_name_logo;
            }
        //image payment
        $old_name_image = $this->input->post('old_name_image');
            if($old_name_image == NULL || $old_name_image == ''){
                $old_name_image_x = NULL;
            } else {
                $old_name_image_x = $old_name_image;
            }

        //logo payment
        $config['upload_path']      = FCPATH.'storage/website/lembaga/grandsbmptn/master_pembayaran/';
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['encrypt_name']     = TRUE;
        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }
        
        $this->load->library('upload', $config);

        if(!empty($_FILES['logo_payment']['name'])){
            if (!$this->upload->do_upload('logo_payment')){
                $error = $this->upload->display_errors();
                show_error($error, 500, 'File Gambar Logo Payment Error');
                exit();
            }else{
                $data['logo_payment'] = $this->upload->data('file_name');
            }
        } else {
            $data['logo_payment'] = $old_name_logo_x;
        }

        //Image Payment
        $config['upload_path']      = FCPATH.'storage/website/lembaga/grandsbmptn/master_pembayaran/';
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['encrypt_name']     = TRUE;
        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }
        
        $this->load->library('upload', $config);

        if(!empty($_FILES['image_payment']['name'])){
            if (!$this->upload->do_upload('image_payment')){
                $error = $this->upload->display_errors();
                show_error($error, 500, 'File Gambar Image Payment Error');
                exit();
            }else{
                $data['image_payment'] = $this->upload->data('file_name');
            }
        } else {
            $data['image_payment'] = $old_name_image_x;
        }

        $data['bank_name'] = $this->input->post('bank_name', TRUE);
        $data['bank_account'] = $this->input->post('bank_account', TRUE);
        $data['bank_number'] = $this->input->post('bank_number', TRUE);
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_payment_method_detail;
        $update = $this->general->update_data($tbl, $data, $pembayaran_detail_master_id);

        $urly = 'admin/detail-pembayaran-master/'.$pembayaran_master_id_crypt;
        $urlx = 'admin/edit-detail-pembayaran-master/'.$pembayaran_master_id_crypt;
        $this->input_end($update, $urly, $urlx);
    }

    public function disable_detail_pembayaran_master($id_pembayaran_detail_master, $id_pembayaran_master){
        $pembayaran_detail_master_id = base64_decode(urldecode($id_pembayaran_detail_master));

        $tbl = $this->tbl_payment_method_detail;
        $delete = $this->general->delete_data($tbl, $pembayaran_detail_master_id);

        $urly = 'admin/detail-pembayaran-master/'.$id_pembayaran_master;
        $urlx = 'admin/detail-pembayaran-master/'.$id_pembayaran_master;
        $this->delete_end($delete, $urly, $urlx);
    }

    public function setting_buku(){
        //for passing data to view
        $data['content']['buku_data'] = $this->management->get_buku_config();
        $data['title_header'] = ['title' => 'Setting Buku'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/buku_setting/css';
        $view['content'] = 'website/lembaga/management/buku_setting/content';
        $view['js_additional'] = 'website/lembaga/management/buku_setting/js';
     
        //get function view website
        $this->_generate_view($view, $data);
    }

    public function setting_buku_detail($id_buku){
        $buku_id = base64_decode(urldecode($id_buku));

        //for passing data to view
        $get_buku = $this->management->get_buku($buku_id);
        $data['content']['detail_buku'] = $this->management->get_detail_buku_by_buku($buku_id);
        $data['content']['id_buku'] = $id_buku;
        $data['content']['buku_name'] = $get_buku->buku_name;
        $data['title_header'] = ['title' => 'Detail Modul'];
 
        //for load view
        $view['css_additional'] = 'website/lembaga/management/buku_setting/css';
        $view['content'] = 'website/lembaga/management/buku_setting/detail';
        $view['js_additional'] = 'website/lembaga/management/buku_setting/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_detail_buku_setting($id_buku){
        $data['content']['id_buku'] = $id_buku;
        $data['content']['detail_jurusan'] = $this->management->get_detail_jurusan();
        $data['title_header'] = ['title' => 'Add Detail Modul'];
 
        //for load view
        $view['css_additional'] = 'website/lembaga/management/buku_setting/css';
        $view['content'] = 'website/lembaga/management/buku_setting/add_detail';
        $view['js_additional'] = 'website/lembaga/management/buku_setting/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function save_gambar_buku_detail() {
        $buku_id_encrypt = $this->input->post('id_buku');
            
        $data['buku_id'] = base64_decode(urldecode($buku_id_encrypt));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $detail_buku_id = $this->input->post('detail_buku_id', TRUE);
        if($detail_buku_id == '' || empty($detail_buku_id)){
            $detail_buku_id_x = 0;
        } else {
            $detail_buku_id_x = $detail_buku_id;
        }
        $data['detail_buku_id'] = $detail_buku_id_x;

        $config['upload_path']    = './storage/website/lembaga/grandsbmptn/modul';
        $config['allowed_types']  = 'gif|jpg|png';
        $config['encrypt_name']   = TRUE;

        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('filegambar')) {
            $error = array('error' => $this->upload->display_errors());
            show_error($error, 500, 'File Gambar Modul Error');
            exit();     
        } else {
            $data['nama_file'] = $this->upload->data('file_name');
            $data['type_file'] = '1';// gambar
            $data ['created_date'] = date('Y-m-d H:i:s');
            $tbl = $this->tbl_config_buku_detail;
            $input = $this->general->input_data($tbl, $data);
            $urly = 'admin/detail-buku/'.$buku_id_encrypt;
            $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
            $this->input_end($input, $urly, $urlx);
        }
    }

    public function save_audio_buku_detail() {
        $buku_id_encrypt = $this->input->post('id_buku');
            
        $data['buku_id'] = base64_decode(urldecode($buku_id_encrypt));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $detail_buku_id = $this->input->post('detail_buku_id', TRUE);
        if($detail_buku_id == '' || empty($detail_buku_id)){
            $detail_buku_id_x = 0;
        } else {
            $detail_buku_id_x = $detail_buku_id;
        }
        $data['detail_buku_id'] = $detail_buku_id_x;

        $config['upload_path']     = './storage/website/lembaga/grandsbmptn/modul';
        $config['allowed_types']   = 'mpeg|mpg|mpeg3|mp3|/x-wav|wave|wav';
        $config['encrypt_name']    = TRUE;

        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('fileaudio')) {
            $error = array('error' => $this->upload->display_errors());
            show_error($error, 500, 'File Audio Modul Error');
            exit();
        } else {
            $gambar= $this->upload->data('file_name');
        
            $data['nama_file'] = $gambar;
            $data['type_file'] = '2' ; // audio
            $data ['created_date']= date('Y-m-d H:i:s');
            $tbl = $this->tbl_config_buku_detail;
            $input = $this->general->input_data($tbl, $data);
            $urly = 'admin/detail-buku/'.$buku_id_encrypt;
            $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
            $this->input_end($input, $urly, $urlx);
        }
    }

    public function save_video_buku_detail(){
        $buku_id_encrypt = $this->input->post('id_buku');
            
        $data['buku_id'] = base64_decode(urldecode($buku_id_encrypt));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $detail_buku_id = $this->input->post('detail_buku_id', TRUE);
        if($detail_buku_id == '' || empty($detail_buku_id)){
            $detail_buku_id_x = 0;
        } else {
            $detail_buku_id_x = $detail_buku_id;
        }
        $data['detail_buku_id'] = $detail_buku_id_x;

        $config['upload_path']    = './storage/website/lembaga/grandsbmptn/modul';
        $config['allowed_types']  = 'avi|flv|wmv|mp3|mp4';
        $config['encrypt_name']   = TRUE;

        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }
        
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('filevideo')) {
            $error = array('error' => $this->upload->display_errors());
            show_error($error, 500, 'File Video Modul Error');
            exit();
        } else {
            $gambar = $this->upload->data('file_name');
            $data['nama_file'] = $gambar;
            $data['type_file'] = '3';//video
            $data ['created_date']= date('Y-m-d H:i:s');
            $tbl = $this->tbl_config_buku_detail;
            $input = $this->general->input_data($tbl, $data);

            $urly = 'admin/detail-buku/'.$buku_id_encrypt;
            $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
            $this->input_end($input, $urly, $urlx);
        }
    }

    public function save_text_buku_detail(){
        $buku_id_encrypt = $this->input->post('id_buku');
        
        $data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $detail_buku_id = $this->input->post('detail_buku_id', TRUE);
        if($detail_buku_id == '' || empty($detail_buku_id)){
            $detail_buku_id_x = 0;
        } else {
            $detail_buku_id_x = $detail_buku_id;
        }
        $data['detail_buku_id'] = $detail_buku_id_x;
        $data['nama_file'] = $this->input->post('summernote');
        $data['type_file'] = '4'; //text
        $data['created_date'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_config_buku_detail;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'admin/detail-buku/'.$buku_id_encrypt;
        $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
        $this->input_end($input, $urly, $urlx);
    }

    public function save_link_buku_detail(){
        $buku_id_encrypt = $this->input->post('id_buku');
        
        $data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $detail_buku_id = $this->input->post('detail_buku_id', TRUE);
        if($detail_buku_id == '' || empty($detail_buku_id)){
            $detail_buku_id_x = 0;
        } else {
            $detail_buku_id_x = $detail_buku_id;
        }
        $data['detail_buku_id'] = $detail_buku_id_x;
        $data['nama_file'] = $this->input->post('link');
        $data['type_file'] = '5'; //link
        $data['created_date'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_config_buku_detail;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'admin/detail-buku/'.$buku_id_encrypt;
        $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
        $this->input_end($input, $urly, $urlx);
    }

    public function editor_modul(){
        $data = [];
        $datas = [];
        $_token = $this->input->post('_token', TRUE);
        $validation = config_item('_token_modul');
        $target_dir = $this->input->post('folder', TRUE);
        $buku_id = urlencode(base64_encode($this->input->post('id_buku')));

        if($validation != $_token || empty($_token)){
            $this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
            redirect('admin/detail-buku/'.$buku_id);
        } else {
            if(!file_exists($target_dir)){
                mkdir($target_dir,0777);
            }

            $config['upload_path']          = $target_dir;
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 500;
            $config['remove_spaces']        = TRUE;        
            $config['encrypt_name']         = TRUE;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file')) {
                $datas = array(
                    'link' => '',
                    'csrf' => $this->security->get_csrf_hash()
                );
            }
            else {
                $data = array('upload_data' => $this->upload->data());
                $datas = array(
                    'link' => base_url().$target_dir.$data['upload_data']['file_name'],
                    'csrf' => $this->security->get_csrf_hash()
                );
            }
            echo json_encode($datas);
        }
    }

    public function editor_modul_delete(){
        $datas = [];
        $_token = $this->input->post('_token', TRUE);
        $validation = config_item('_token_modul');
        $src = $this->input->post('src', TRUE); 
        $file_name = str_replace(base_url(), '', $src);
        $buku_id = urlencode(base64_encode($this->input->post('id_buku')));

        if($validation != $_token || empty($_token)){
            $this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
            redirect('admin/detail-buku/'.$buku_id);
        } else {
            if(unlink($file_name)){
                $datas = array(
                    'text' => 'Success Delete Data Image',
                    'csrf' => $this->security->get_csrf_hash()
                );
            } else {
                $datas = array(
                    'text' => 'Failed Delete Data Image',
                    'csrf' => $this->security->get_csrf_hash()
                );
            }

            echo json_encode($datas);
        }
    }

    public function edit_setting_buku($id_config_buku){
        $config_buku_id = base64_decode(urldecode($id_config_buku));
        //for passing data to view
        $data['content']['config_buku'] = $this->management->get_buku_config_by_id($config_buku_id);
        $data['content']['id_config_buku'] = $id_config_buku;
        $data['title_header'] = ['title' => 'Edit Buku'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/buku_setting/css';
        $view['content'] = 'website/lembaga/management/buku_setting/edit';
        $view['js_additional'] = 'website/lembaga/management/buku_setting/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_setting_buku(){
        $config_buku_id_crypt = $this->input->post('id_config_buku');
        $config_buku_id = base64_decode(urldecode($config_buku_id_crypt));

        $data['free_paket'] = $this->input->post('free_paket', TRUE);
        $data['price'] = $this->input->post('price', TRUE);
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_config_buku;
        $update = $this->general->update_data($tbl, $data, $config_buku_id);

        $urly = 'admin/buku-setting';
        $urlx = 'admin/edit-buku-setting/'.$config_buku_id_crypt;
        $this->update_end($update, $urly, $urlx);
    }

    public function disable_detail_buku_setting($id_config_buku_detail, $id_buku){
        $config_buku_detail_id = base64_decode(urldecode($id_config_buku_detail));

        $tbl = $this->tbl_config_buku_detail;
        $delete = $this->general->delete_data($tbl, $config_buku_detail_id);

        $urly = 'admin/detail-buku/'.$id_buku;
        $urlx = 'admin/detail-buku/'.$id_buku;
        $this->delete_end($delete, $urly, $urlx);
    }

    public function invoice_list(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Invoice All List'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/invoice/invoice_all/css';
        $view['content'] = 'website/lembaga/management/invoice/invoice_all/content';
        $view['js_additional'] = 'website/lembaga/management/invoice/invoice_all/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function invoice_list_all(){ //page 1
        $list = $this->invoice_list_admin->get_datatables();
		$data = array();
        $no = $_POST['start'];
        $url_manual_confirm = base_url().'admin/invoice/manual-confirm/1/';
        $url_delete = base_url().'admin/invoice/delete-invoice/1/';
		foreach ($list as $field) {
			$no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="table-data-feature">
                        <a href="'.$url_manual_confirm.urlencode(base64_encode($field->id_invoice)).'" class="item" data-toggle="tooltip" data-placement="top" title="Manual Confirm">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="'.$url_delete.urlencode(base64_encode($field->id_invoice)).'" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="zmdi zmdi-delete"></i>
                        </a>
                    </div>';
            $row[] = $field->invoice_number;
            $row[] = $field->status_invoice;
            $row[] = $field->invoice_total_cost;
            $row[] = $field->payment_method_detail_name;
            $row[] = $field->buku_name;
            $row[] = $field->user_name;
            $row[] = $field->user_email;
            $row[] = $field->user_no_telp;
            $row[] = format_indo($field->invoice_date_create);
            $row[] = format_indo($field->invoice_date_expirate);
            $row[] = $field->date_left.' Left';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_list_admin->count_all(),
			"recordsFiltered" => $this->invoice_list_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

    public function export_invoice_all(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Invoice');
        $sheet->setCellValue('C1', 'Status Invoice');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Payment');
        $sheet->setCellValue('F1', 'Buku');
        $sheet->setCellValue('G1', 'Name');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'No Telp');
        $sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
        $sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
        
        $siswa = $this->management->get_invoice_all();
        $no = 1;
        $x = 2;
        foreach($siswa as $row)
        {
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->invoice_number);
            $sheet->setCellValue('C'.$x, $row->status_invoice);
            $sheet->setCellValue('D'.$x, $row->invoice_total_cost);
            $sheet->setCellValue('E'.$x, $row->payment_method_detail_name);
            $sheet->setCellValue('F'.$x, $row->buku_name);
            $sheet->setCellValue('G'.$x, $row->user_name);
            $sheet->setCellValue('H'.$x, $row->user_email);
            $sheet->setCellValue('I'.$x, $row->user_no_telp);
            $sheet->setCellValue('J'.$x, format_indo($row->invoice_date_create));
            $sheet->setCellValue('K'.$x, format_indo($row->invoice_date_expirate));
            $x++;
        }

        // Column sizing
        foreach(range('A','K') as $columnID){
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'All-Data-invoice';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function invoice_confirm(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Invoice All Confirm'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/invoice/invoice_confirm/css';
        $view['content'] = 'website/lembaga/management/invoice/invoice_confirm/content';
        $view['js_additional'] = 'website/lembaga/management/invoice/invoice_confirm/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function invoice_list_confirm_all(){ //page 2
        $list = $this->invoice_confirm_admin->get_datatables();
		$data = array();
        $no = $_POST['start'];
        $url_manual_confirm = base_url().'admin/invoice/manual-confirm/2/';
        $url_delete = base_url().'admin/invoice/delete-invoice/2/';
		foreach ($list as $field) {
			$no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="table-data-feature">
                        <a href="'.$url_manual_confirm.urlencode(base64_encode($field->id_invoice)).'" class="item" data-toggle="tooltip" data-placement="top" title="Manual Confirm">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="'.$url_delete.urlencode(base64_encode($field->id_invoice)).'" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="zmdi zmdi-delete"></i>
                        </a>
                    </div>';
            $row[] = '<a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="Nomor #'.$field->invoice_number.'" data-caption="" data-image="'.config_item('_dir_website').'lembaga/grandsbmptn/confirm_payment/'.$field->invoice_number.'" data-target="#image-gallery">
                            <img class="img-responsive" src="'.config_item('_dir_website').'lembaga/grandsbmptn/confirm_payment/'.$field->invoice_number.'" style="width:100px;" alt="'.$field->invoice_number.'">
                    </a>';
            $row[] = $field->invoice_number;
            $row[] = $field->status_invoice;
            $row[] = $field->invoice_total_cost;
            $row[] = $field->payment_method_detail_name;
            $row[] = $field->buku_name;
            $row[] = $field->user_name;
            $row[] = $field->user_email;
            $row[] = $field->user_no_telp;
            $row[] = format_indo($field->invoice_date_create);
            $row[] = format_indo($field->invoice_date_expirate);
            $row[] = $field->date_left.' Left';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_confirm_admin->count_all(),
			"recordsFiltered" => $this->invoice_confirm_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

    public function export_invoice_all_confirm(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Invoice');
        $sheet->setCellValue('C1', 'Status Invoice');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Payment');
        $sheet->setCellValue('F1', 'Buku');
        $sheet->setCellValue('G1', 'Name');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'No Telp');
        $sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
        $sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
        
        $siswa = $this->management->get_invoice_confirm();
        $no = 1;
        $x = 2;
        foreach($siswa as $row)
        {
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->invoice_number);
            $sheet->setCellValue('C'.$x, $row->status_invoice);
            $sheet->setCellValue('D'.$x, $row->invoice_total_cost);
            $sheet->setCellValue('E'.$x, $row->payment_method_detail_name);
            $sheet->setCellValue('F'.$x, $row->buku_name);
            $sheet->setCellValue('G'.$x, $row->user_name);
            $sheet->setCellValue('H'.$x, $row->user_email);
            $sheet->setCellValue('I'.$x, $row->user_no_telp);
            $sheet->setCellValue('J'.$x, format_indo($row->invoice_date_create));
            $sheet->setCellValue('K'.$x, format_indo($row->invoice_date_expirate));
            $x++;
        }

        // Column sizing
        foreach(range('A','K') as $columnID){
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'All-Data-invoice-confirm';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function invoice_success(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Invoice All Success'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/invoice/invoice_success/css';
        $view['content'] = 'website/lembaga/management/invoice/invoice_success/content';
        $view['js_additional'] = 'website/lembaga/management/invoice/invoice_success/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function invoice_list_success_all(){ //page 3
        $list = $this->invoice_success_admin->get_datatables();
		$data = array();
        $no = $_POST['start'];
        $url_manual_confirm = base_url().'admin/invoice/manual-confirm/3/';
        $url_delete = base_url().'admin/invoice/delete-invoice/3/';
		foreach ($list as $field) {
			$no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->invoice_number;
            $row[] = $field->status_invoice;
            $row[] = $field->invoice_total_cost;
            $row[] = $field->payment_method_detail_name;
            $row[] = $field->buku_name;
            $row[] = $field->user_name;
            $row[] = $field->user_email;
            $row[] = $field->user_no_telp;
            $row[] = format_indo($field->invoice_date_create);
            $row[] = format_indo($field->invoice_date_expirate);

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_success_admin->count_all(),
			"recordsFiltered" => $this->invoice_success_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

    public function export_invoice_all_success(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Invoice');
        $sheet->setCellValue('C1', 'Status Invoice');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Payment');
        $sheet->setCellValue('F1', 'Buku');
        $sheet->setCellValue('G1', 'Name');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'No Telp');
        $sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
        $sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
        
        $siswa = $this->management->get_invoice_success();
        $no = 1;
        $x = 2;
        foreach($siswa as $row)
        {
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->invoice_number);
            $sheet->setCellValue('C'.$x, $row->status_invoice);
            $sheet->setCellValue('D'.$x, $row->invoice_total_cost);
            $sheet->setCellValue('E'.$x, $row->payment_method_detail_name);
            $sheet->setCellValue('F'.$x, $row->buku_name);
            $sheet->setCellValue('G'.$x, $row->user_name);
            $sheet->setCellValue('H'.$x, $row->user_email);
            $sheet->setCellValue('I'.$x, $row->user_no_telp);
            $sheet->setCellValue('J'.$x, format_indo($row->invoice_date_create));
            $sheet->setCellValue('K'.$x, format_indo($row->invoice_date_expirate));
            $x++;
        }

        // Column sizing
        foreach(range('A','K') as $columnID){
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'All-Data-invoice-success';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function invoice_expired(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Invoice All Expired'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/invoice/invoice_expired/css';
        $view['content'] = 'website/lembaga/management/invoice/invoice_expired/content';
        $view['js_additional'] = 'website/lembaga/management/invoice/invoice_expired/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function invoice_list_expired_all(){ //page 4
        $list = $this->invoice_expired_admin->get_datatables();
		$data = array();
        $no = $_POST['start'];
        $url_manual_confirm = base_url().'admin/invoice/manual-confirm/4/';
        $url_delete = base_url().'admin/invoice/delete-invoice/4/';
		foreach ($list as $field) {
			$no++;
            $row = array();
            $row[] = $no;
            $row[] = '<div class="table-data-feature">
                        <a href="'.$url_manual_confirm.urlencode(base64_encode($field->id_invoice)).'" class="item" data-toggle="tooltip" data-placement="top" title="Manual Confirm">
                            <i class="zmdi zmdi-check"></i>
                        </a>
                        <a href="'.$url_delete.urlencode(base64_encode($field->id_invoice)).'" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                            <i class="zmdi zmdi-delete"></i>
                        </a>
                    </div>';
            $row[] = $field->invoice_number;
            $row[] = $field->status_invoice;
            $row[] = $field->invoice_total_cost;
            $row[] = $field->payment_method_detail_name;
            $row[] = $field->buku_name;
            $row[] = $field->user_name;
            $row[] = $field->user_email;
            $row[] = $field->user_no_telp;
            $row[] = format_indo($field->invoice_date_create);
            $row[] = format_indo($field->invoice_date_expirate);
            $row[] = $field->date_left.' Left';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->invoice_expired_admin->count_all(),
			"recordsFiltered" => $this->invoice_expired_admin->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

    public function export_invoice_all_expired(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Invoice');
        $sheet->setCellValue('C1', 'Status Invoice');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Payment');
        $sheet->setCellValue('F1', 'Buku');
        $sheet->setCellValue('G1', 'Name');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'No Telp');
        $sheet->setCellValue('J1', 'Tanggal Invoice Dibuat');
        $sheet->setCellValue('K1', 'Tanggal Invoice Kadaluarsa');
        
        $siswa = $this->management->get_invoice_expired();
        $no = 1;
        $x = 2;
        foreach($siswa as $row)
        {
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->invoice_number);
            $sheet->setCellValue('C'.$x, $row->status_invoice);
            $sheet->setCellValue('D'.$x, $row->invoice_total_cost);
            $sheet->setCellValue('E'.$x, $row->payment_method_detail_name);
            $sheet->setCellValue('F'.$x, $row->buku_name);
            $sheet->setCellValue('G'.$x, $row->user_name);
            $sheet->setCellValue('H'.$x, $row->user_email);
            $sheet->setCellValue('I'.$x, $row->user_no_telp);
            $sheet->setCellValue('J'.$x, format_indo($row->invoice_date_create));
            $sheet->setCellValue('K'.$x, format_indo($row->invoice_date_expirate));
            $x++;
        }

        // Column sizing
        foreach(range('A','K') as $columnID){
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'All-Data-invoice-expired';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function manual_confirm_invoice($page, $id_invoice){
        $invoice_id = base64_decode(urldecode($id_invoice));
    }

    public function disable_invoice($page, $id_invoice){
        $invoice_id = base64_decode(urldecode($id_invoice));

        $tbl = $this->tbl_invoice;
        $delete = $this->general->delete_data($tbl, $invoice_id);

        if($page == 1){ //1 Invoice All 2 Confirm 3 Success 4 Expired
            $urly = 'admin/invoice';
            $urlx = 'admin/invoice';
        } elseif($page == 2){
            $urly = 'admin/invoice-confirm';
            $urlx = 'admin/invoice-confirm';
        } elseif($page == 3){
            $urly = 'admin/invoice-success';
            $urlx = 'admin/invoice-success';
        } elseif($page == 4){
            $urly = 'admin/invoice-expired';
            $urlx = 'admin/invoice-expired';
        }

        $this->delete_end($delete, $urly, $urlx);
    }

}