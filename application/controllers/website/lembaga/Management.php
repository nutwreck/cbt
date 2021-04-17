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

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
            redirect('admin/login');
        }
        $this->load->model('General','general');
        $this->load->model('Management_model','management');
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
        $konversi_skor_id = $konversi_id = base64_decode(urldecode($konversi_skor_id_crypt));

        $data['name'] = $this->input->post('name', TRUE);
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_konversi_skor;
        $update = $this->general->update_data($tbl, $data, $konversi_skor_id);

        $urly = 'admin/konversi-skor';
        $urlx = 'admin/edit-konversi-skor/'.$konversi_skor_id_crypt;
        $this->update_end($update, $urly, $urlx);
    }

    public function disable_konversi($id_konversi){
        $konversi_skor_id = $konversi_id = base64_decode(urldecode($id_konversi));

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

}