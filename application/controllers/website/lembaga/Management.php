<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends CI_Controller {
    /**
	 * Author : Candra Aji Pamungkas
     * Create : 12-04-2021
     * Change :
     *      - {date} | {description}
	 */

    private $tbl_lembaga = 'lembaga';

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

}