<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konversi_skor extends CI_Controller {

    /**
	 * Author : Candra Aji Pamungkas
     * Create : 18-03-2021
     * Change :
     *      - {date} | {description}
	 */

    private $tbl_konversi = 'konversi_skor'; //SET TABEL KONVERSI
    private $tbl_user = 'user';
    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
            redirect('admin/login');
        }
        $this->load->model('General','general');
        $this->load->model('konversi_skor_model','konversi');
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

    public function konversi(){
        //for passing data to view
        $data['content']['konversi_data'] = $this->konversi->get_konversi();
        $data['title_header'] = ['title' => 'Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/konversi/css';
        $view['content'] = 'website/lembaga/konversi/content';
        $view['js_additional'] = 'website/lembaga/konversi/js';
     
        //get function view website
        $this->_generate_view($view, $data);
    }
    public function add_konversi(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Tambah Materi'];

        //for load view
        $view['css_additional'] = 'website/lembaga/konversi/css';
        $view['content'] = 'website/lembaga/konversi/add';
        $view['js_additional'] = 'website/lembaga/konversi/js';

        //get function view website
        $this->_generate_view($view, $data);
    }
    public function submit_add_konversi(){
        $data['name'] = ucwords($this->input->post('materi', TRUE));
        $data['created_datetime'] = date('Y-m-d H:i:s');
        $tbl = $this->tbl_konversi;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'admin/konversi';
        $urlx = 'admin/add-konversi';
        $this->input_end($input, $urly, $urlx);
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
    public function disable_konversi_skor($id){
        $data = [];
        $konversiid = base64_decode(urldecode($id));

        $tbl = $this->tbl_konversi;
        $disable = $this->general->delete_data($tbl, $konversiid);

        $urly = 'admin/konversi';
        $urlx = 'admin/konversi';
        $this->delete_end($disable, $urly, $urlx);
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
    public function edit_konversi($id){
      //  $konversi_id = base64_decode(urldecode($id));

      
        $data['content']['konversi_data'] = $this->konversi->get_konversi_id($id);
        $data['title_header'] = ['title' => 'Edit Konversi'];

        //for load view
        $view['css_additional'] = 'website/lembaga/konversi/css';
        $view['content'] = 'website/lembaga/konversi/edit';
        $view['js_additional'] = 'website/lembaga/konversi/js';
        //get function view website
        $this->_generate_view($view, $data);
    }
    public function submit_edit_konversi(){
        $id = $this->input->post('id', TRUE);
        $data['name'] = strtoupper($this->input->post('konversi', TRUE));
        $data['updated_datetime'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $this->session->userdata('user_id');
        $tbl = $this->tbl_konversi;
        $update = $this->general->update_data($tbl, $data, $id);

        $urly = 'admin/konversi';
        $urlx = 'admin/edit-konversi/'.$id;
        $this->update_end($update, $urly, $urlx);
    }

    public function detail_konversi($id){
        $konversi_id = base64_decode(urldecode($id));

        //for passing data to view
        $data['content']['konversi_data'] = $this->konversi->get_konversi_id($konversi_id);
        $data['title_header'] = ['title' => 'Detail Konversi'];

        //for load view
        $view['css_additional'] = 'website/lembaga/konversi/css';
        $view['content'] = 'website/lembaga/konversi/edit';
        $view['js_additional'] = 'website/lembaga/konversi/js';

        //get function view website
        $this->_generate_view($view, $data);
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
}