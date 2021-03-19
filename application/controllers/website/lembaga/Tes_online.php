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
         $data['title_header'] = ['title' => 'Tambah Paket Soal'];
 
         //for load view
         $view['css_additional'] = 'website/lembaga/tes_online/paket_soal/css';
         $view['content'] = 'website/lembaga/tes_online/paket_soal/add';
         $view['js_additional'] = 'website/lembaga/tes_online/paket_soal/js';
 
         //get function view website
         $this->_generate_view($view, $data);
    }

}