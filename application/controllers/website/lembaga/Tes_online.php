<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes_online extends CI_Controller {

    /**
	 * Author : Candra Aji Pamungkas
     * Create : 18-03-2021
     * Change :
     *      - {date} | {description}
	 */

    private $tbl_materi = 'materi'; //SET TABEL MATERI
    private $tbl_paket_soal = 'paket_soal'; //SET TABEL PAKET SOAL

    public function __construct(){
          parent::__construct();

          $this->load->model('General','general');
          $this->load->model('Tes_online_model','tes');
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

    public function materi(){
        //for passing data to view
        $data['content']['materi_data'] = $this->tes->get_materi();
        $data['title_header'] = ['title' => 'Materi'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/materi/css';
        $view['content'] = 'website/lembaga/tes_online/materi/content';
        $view['js_additional'] = 'website/lembaga/tes_online/materi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_materi(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Tambah Materi'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/materi/css';
        $view['content'] = 'website/lembaga/tes_online/materi/add';
        $view['js_additional'] = 'website/lembaga/tes_online/materi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_add_materi(){
        $data['name'] = ucwords($this->input->post('materi', TRUE));
        $data['created_datetime'] = date('Y-m-d H:i:s');
        $tbl = $this->tbl_materi;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'lembaga/materi';
        $urlx = 'lembaga/add-materi';
        $this->input_end($input, $urly, $urlx);
    }

    public function edit_materi($id_materi){
        //for passing data to view
        $data['content']['materi_data'] = $this->tes->get_materi_by_id($id_materi);
        $data['title_header'] = ['title' => 'Edit Materi'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/materi/css';
        $view['content'] = 'website/lembaga/tes_online/materi/edit';
        $view['js_additional'] = 'website/lembaga/tes_online/materi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_materi(){
        $id = $this->input->post('id', TRUE);
        $data['name'] = strtoupper($this->input->post('materi', TRUE));
        $data['updated_datetime'] = date('Y-m-d H:i:s');
        $tbl = $this->tbl_materi;
        $update = $this->general->update_data($tbl, $data, $id);

        $urly = 'lembaga/materi';
        $urlx = 'lembaga/edit-materi/'.$id;
        $this->update_end($update, $urly, $urlx);
    }

    public function delete_materi($id)
	{
        $tbl = $this->tbl_materi;
        $delete = $this->general->delete_data($tbl, $id);

        $urly = 'lembaga/materi';
        $urlx = 'lembaga/materi';
        $this->delete_end($delete, $urly, $urlx);
    }

    public function active_materi($id)
	{
        $tbl = $this->tbl_materi;
        $active = $this->general->active_data($tbl, $id);

        $urly = 'lembaga/materi';
        $urlx = 'lembaga/materi';
        $this->active_end($active, $urly, $urlx);
    }

    public function paket_soal(){
        //for passing data to view
        $data['content']['paket_soal'] = $this->tes->get_paket_soal();
        $data['title_header'] = ['title' => 'Paket Soal'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
        $view['content'] = 'website/lembaga/tes_online/paket_soal/content';
        $view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_paket_soal(){
         //for passing data to view
         $data['content']['get_materi'] = $this->tes->get_materi_enable();
         $data['content']['get_kelas'] = $this->tes->get_kelas_enable();
         $data['content']['get_mode_jawaban'] = $this->tes->get_mode_jawaban_enable();
         $data['content']['get_skala_nilai'] = $this->tes->get_skala_nilai_enable();
         $data['title_header'] = ['title' => 'Tambah Paket Soal'];
 
         //for load view
         $view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
         $view['content'] = 'website/lembaga/tes_online/paket_soal/add';
         $view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';
 
         //get function view website
         $this->_generate_view($view, $data);
    }

    public function submit_add_paket_soal(){
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $kelas  = $this->input->post('kelas', TRUE);
        $exp_kelas = explode("|", $kelas);
        $data['kelas_id'] = $exp_kelas[0];
        $data['kelas_name'] = $exp_kelas[1];
        $materi  = $this->input->post('materi', TRUE);
        $exp_materi = explode("|", $materi);
        $data['materi_id'] = $exp_materi[0];
        $data['materi_name'] = $exp_materi[1];
        $data['detail_mode_jwb_id'] = $this->input->post('mode_jawaban', TRUE);
        $data['is_acak_soal'] = $this->input->post('acak_soal', TRUE);
        $data['is_acak_jawaban'] = $this->input->post('acak_jawaban', TRUE);
        $data['pengaturan_universal_id'] = $this->input->post('skala_nilai', TRUE);
        $data['skor_null'] = $this->input->post('skor_tdk_jwb', TRUE);
        $data['is_continuous'] = $this->input->post('continous', TRUE);
        $data['is_jawab'] = $this->input->post('menjawab', TRUE);
        $data['petunjuk'] = $this->input->post('petunjuk_text');
        $data['visual_limit'] = $this->input->post('audio_limit', TRUE);
        $data['file'] = $this->input->post('petunjuk_audio', TRUE);
        $data['created_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_paket_soal;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'lembaga/paket-soal';
        $urlx = 'lembaga/add-paket-soal';
        $this->input_end($input, $urly, $urlx);
    }

    public function editor_paket_soal(){ //upload image dipaket soal petunjuk pengerjaan 
        $_token = $this->input->post('_token', TRUE);
        $validation = config_item('_token_petunjuk_paket_data');
        $target_dir = $this->input->post('folder', TRUE);

        if($validation != $validation || empty($_token)){
            $this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
            redirect('lembaga/add-paket-soal');
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
                $error = array('error' => $this->upload->display_errors());
                var_dump($error);
            }
            else {
                $data = array('upload_data' => $this->upload->data());
                $datas = array(
                    'link' => base_url().'storage/website/lembaga/grandsbmptn/paket_soal/'.$data['upload_data']['file_name'],
                    'csrf' => $this->security->get_csrf_hash()
                );
                echo json_encode($datas);
            }
        }
    }

    public function editor_paket_soal_delete(){ //hapus upload image dipaket soal petunjuk pengerjaan
        $_token = $this->input->post('_token', TRUE);
        $validation = config_item('_token_petunjuk_paket_data');
        $src = $this->input->post('src', TRUE); 
        $file_name = str_replace(base_url(), '', $src);

        if($validation != $validation || empty($_token)){
            $this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
            redirect('lembaga/add-paket-soal');
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

    public function list_soal($id_paket_soal){
        //for passing data to view
        $data['content']['id_paket_soal'] = $id_paket_soal;
        $data['title_header'] = ['title' => 'Daftar Soal'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/soal/css';
        $view['content'] = 'website/lembaga/tes_online/soal/content';
        $view['js_additional'] = 'website/lembaga/tes_online/soal/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_soal($id_paket_soal){
        //for passing data to view
        $paket_soal_id = base64_decode(urldecode($id_paket_soal));
        $mode_jawaban = $this->tes->get_total_mode_jwb($paket_soal_id); //Untuk soal pilihan ganda
        $total_soal = $this->tes->get_total_soal($paket_soal_id); //Total soal
        $data['content']['id_paket_soal'] = $id_paket_soal;
        $data['content']['count_pilihan_ganda'] = intval($mode_jawaban->count_pilgan);
        $data['content']['total_soal'] = intval($total_soal->total_soal);
        $data['content']['jenis_soal'] = $this->tes->get_jenis_soal_enable();
        $data['content']['tipe_kesulitan'] = $this->tes->get_tipe_kesulitan_enable();
        $data['title_header'] = ['title' => 'Tambah Soal'];

        //for load view
        $view['css_additional'] = 'website/lembaga/tes_online/soal/css';
        $view['content'] = 'website/lembaga/tes_online/soal/add';
        $view['js_additional'] = 'website/lembaga/tes_online/soal/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

}