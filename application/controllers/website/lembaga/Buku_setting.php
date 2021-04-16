<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_setting extends CI_Controller {

    /**
	 * Author : Candra Aji Pamungkas
     * Create : 18-03-2021
     * Change :
     *      - {date} | {description}
	 */

    private $tbl_buku = 'buku'; //SET TABEL KONVERSI
    private $tbl_config_buku = 'config_buku';
    private $tbl_buku_detail = 'buku_detail';

    public function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
            redirect('admin/login');
        }
        $this->load->model('General','general');
        $this->load->model('Config_buku_model','buku_config');
    }

    /*
    |
    | START FUNCTION IN THIS CONTROLLER
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

    public function setting_buku(){
        //for passing data to view
        $data['content']['buku_data'] = $this->buku_config->get_buku_config();
        $data['title_header'] = ['title' => 'Buku Setting'];

        //for load view
        $view['css_additional'] = 'website/lembaga/Buku_setting/css';
        $view['content'] = 'website/lembaga/Buku_setting/content';
        $view['js_additional'] = 'website/lembaga/Buku_setting/js';
     
        //get function view website
        $this->_generate_view($view, $data);
    }
    public function edit_buku($id_buku){
        $buku_id = base64_decode(urldecode($id_buku));
        //for passing data to view
        $data['content']['buku_data'] = $this->buku_config->get_buku_by_id($buku_id);
        $data['content']['id_buku'] = $id_buku;
        $data['title_header'] = ['title' => 'Edit Buku Setting'];

        //for load view
        $view['css_additional'] = 'website/lembaga/Buku_setting/css';
        $view['content'] = 'website/lembaga/Buku_setting/edit';
        $view['js_additional'] = 'website/lembaga/Buku_setting/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_edit_buku(){
        $buku_id_crypt = $this->input->post('id_buku');
        $id_buku = $konversi_id = base64_decode(urldecode($buku_id_crypt));

        $data['name'] = $this->input->post('name', TRUE);
        $data['updated_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_buku;
        $update = $this->general->update_data($tbl, $data, $id_buku);

        $urly = 'admin/buku-setting';
        $urlx = 'admin/edit-buku/'.$buku_id_crypt;
        $this->update_end($update, $urly, $urlx);
    }
    public function disable_buku($id_buku){
        $buku_id = $konversi_id = base64_decode(urldecode($id_buku));

        $tbl = $this->tbl_buku;
        $delete = $this->general->delete_data($tbl, $buku_id);

        $urly = 'admin/buku-setting';
        $urlx = 'admin/buku-setting';
        $this->delete_end($delete, $urly, $urlx);
    }

    public function setting_buku_detail($id_buku){
        $id =  base64_decode(urldecode($id_buku));

        //for passing data to view
        $data['content']['detail_buku'] = $this->buku_config->get_detail_buku_by_buku($id);
        $data['content']['id_buku'] = $id_buku;
        $data['title_header'] = ['title' => 'Detail Konversi Skor'];
 
        //for load view
        $view['css_additional'] = 'website/lembaga/Buku_setting/css';
        $view['content'] = 'website/lembaga/Buku_setting/detail';
        $view['js_additional'] = 'website/lembaga/Buku_setting/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function save_video(){
        //  $id = $buku_id = base64_decode(urldecode($id_buku));
      $buku_id_encrypt = $this->input->post('id_buku');
        
      $data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));

        //for passing data to view
      //  $data['content']['id_buku'] = $this->buku_config->get_detail_buku_by_buku($id);
      //  $data['content']['id_buku'] = $id_buku;
           //  $data['nama_file']= '';
          // $data['content']['buku_id'] = $buku_id;
            $gambar  = $_FILES['filevideo']['name']; 
            $config['upload_path']          = './storage/website/lembaga/grandsbmptn/modul';
            $config['allowed_types']        = 'avi|flv|wmv|mp3|mp4';
            $config['max_size']             = 60000;
            

            $this->load->library('upload', $config);


            if ( ! $this->upload->do_upload('filevideo'))
            {
                    $error = array('error' => $this->upload->display_errors());
                    show_error($error, 500, 'File Audio Soal Error');
                    exit();
                  
            }
            else
            {
                   // $data = array('upload_data' => $this->upload->data());
                   $gambar= $this->upload->data('file_name');
                   $data['nama_file'] = $gambar;// $this->input->post('namafile',TRUE);
                   $data['type_file'] = '3';//video
                   $data ['created_date']= date('Y-m-d H:i:s');
                   $tbl = $this->tbl_buku_detail;
                   $input = $this->general->input_data($tbl, $data);
       
                 /*   $view['css_additional'] = 'website/lembaga/Buku_setting/css';
                   $view['content'] = 'website/lembaga/Buku_setting/detail';
                   $view['js_additional'] = 'website/lembaga/Buku_setting/js'; */
                   $urly = 'admin/detail-buku/'.$buku_id_encrypt;
                    $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
                    $this->input_end($input, $urly, $urlx);

            }
   
    }

    public function save_gambar()
    {
      //  $id = $buku_id = base64_decode(urldecode($id_buku));
      $buku_id_encrypt = $this->input->post('id_buku');
        
      $data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));

        //for passing data to view
      //  $data['content']['id_buku'] = $this->buku_config->get_detail_buku_by_buku($id);
      //  $data['content']['id_buku'] = $id_buku;
           //  $data['nama_file']= '';
          // $data['content']['buku_id'] = $buku_id;
            $gambar  = $_FILES['namafile']['name']; 
            $config['upload_path']          = './storage/website/lembaga/grandsbmptn/modul';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 10000;
            $config['max_width']            = 10000;
            $config['max_height']           = 10000;

            $this->load->library('upload', $config);


            if ( ! $this->upload->do_upload('namafile'))
            {
                    $error = array('error' => $this->upload->display_errors());
                    show_error($error, 500, 'File Audio Soal Error');
                    exit();
                  
            }
            else
            {
                   // $data = array('upload_data' => $this->upload->data());
                   $gambar= $this->upload->data('file_name');
                   $data['nama_file'] = $gambar;// $this->input->post('namafile',TRUE);
                   $data['type_file']= '1';// gambar
                    $data ['created_date']= date('Y-m-d H:i:s');
                   $tbl = $this->tbl_buku_detail;
                   $input = $this->general->input_data($tbl, $data);
       
                 /*   $view['css_additional'] = 'website/lembaga/Buku_setting/css';
                   $view['content'] = 'website/lembaga/Buku_setting/detail';
                   $view['js_additional'] = 'website/lembaga/Buku_setting/js'; */
                   $urly = 'admin/detail-buku/'.$buku_id_encrypt;
                    $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
                    $this->input_end($input, $urly, $urlx);

            }
        }

        public function save_audio()
        {
          //  $id = $buku_id = base64_decode(urldecode($id_buku));
          $buku_id_encrypt = $this->input->post('id_buku');
            
          $data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));
    
            //for passing data to view
          //  $data['content']['id_buku'] = $this->buku_config->get_detail_buku_by_buku($id);
          //  $data['content']['id_buku'] = $id_buku;
               //  $data['nama_file']= '';
              // $data['content']['buku_id'] = $buku_id;
                $gambar  = $_FILES['fileaudio']['name']; 
                $config['upload_path']          = './storage/website/lembaga/grandsbmptn/modul';
                $config['allowed_types']        = 'mpeg|mpg|mpeg3|mp3|/x-wav|wave|wav';

                $this->load->library('upload', $config);
    
    
                if ( ! $this->upload->do_upload('fileaudio'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        show_error($error, 500, 'File Audio Soal Error');
                        exit();
                      
                }
                else
                {
                       // $data = array('upload_data' => $this->upload->data());
                       $gambar= $this->upload->data('file_name');
                  
                       $data['nama_file'] = $gambar;// $this->input->post('namafile',TRUE);
                       $data['type_file'] = '2' ; // audio
                        $data ['created_date']= date('Y-m-d H:i:s');
                       $tbl = $this->tbl_buku_detail;
                       $input = $this->general->input_data($tbl, $data);
           
                     /*   $view['css_additional'] = 'website/lembaga/Buku_setting/css';
                       $view['content'] = 'website/lembaga/Buku_setting/detail';
                       $view['js_additional'] = 'website/lembaga/Buku_setting/js'; */
                       $urly = 'admin/detail-buku/'.$buku_id_encrypt;
                        $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
                        $this->input_end($input, $urly, $urlx);
    
                }
            }
            public function save_link(){
              $buku_id_encrypt = $this->input->post('id_buku');
            
              $data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));
              $data['nama_file'] = $this->input->post('link');
              $data['type_file'] = '4'; //link
              $data['created_date'] = date('Y-m-d H:i:s');
      
              $tbl = $this->tbl_buku_detail;
              $input = $this->general->input_data($tbl, $data);
      
              $urly = 'admin/detail-buku/'.$buku_id_encrypt;
              $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
              $this->input_end($input, $urly, $urlx);
          }
          public function save_text(){
            $buku_id_encrypt = $this->input->post('id_buku');
          
            $data['buku_id'] = $konversi_id = base64_decode(urldecode($buku_id_encrypt));
            $data['nama_file'] = $this->input->post('summernote');
            $data['type_file'] = '5'; //text
            $data['created_date'] = date('Y-m-d H:i:s');
    
            $tbl = $this->tbl_buku_detail;
            $input = $this->general->input_data($tbl, $data);
    
            $urly = 'admin/detail-buku/'.$buku_id_encrypt;
            $urlx = 'admin/detail-buku/'.$buku_id_encrypt;
            $this->input_end($input, $urly, $urlx);
        }

        public function editor_modul(){ //upload image disoal
          $data = [];
          $datas = [];
          $_token = $this->input->post('_token', TRUE);
          $validation = config_item('_token_modul');
          $target_dir = $this->input->post('folder', TRUE);
          $paket_soal_id = urlencode(base64_encode($this->input->post('id_buku')));
  
          if($validation != $_token || empty($_token)){
              $this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
              redirect('admin/detail-buku/'.$paket_soal_id);
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
                  /* $error = array('error' => $this->upload->display_errors());
                  var_dump($error); */
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
  
      public function editor_modul_delete(){ //hapus upload image dipaket soal petunjuk pengerjaan
          $datas = [];
          $_token = $this->input->post('_token', TRUE);
          $validation = config_item('_token_modul');
          $src = $this->input->post('src', TRUE); 
          $file_name = str_replace(base_url(), '', $src);
          $paket_soal_id = urlencode(base64_encode($this->input->post('id_buku')));
  
          if($validation != $_token || empty($_token)){
              $this->session->set_flashdata('warning', 'Terjadi kesalahan lalu lintas data!');
              redirect('admin/detail-buku/'.$paket_soal_id);
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
  
      public function edit_detail_buku($id_buku_detail, $id_buku){
        $buku_detail_id = base64_decode(urldecode($id_buku_detail));
        //for passing data to view
        $data['content']['detail_buku'] = $this->management->get_detail_konversi_by_id($buku_detail_id);
        $data['content']['id_buku_detail'] = $id_buku_detail;
        $data['content']['id_buku'] = $id_buku;
        $data['title_header'] = ['title' => 'Edit Detail Konversi Skor'];

        //for load view
        $view['css_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/css';
        $view['content'] = 'website/lembaga/management/konversi_skor/detail_konversi/edit';
        $view['js_additional'] = 'website/lembaga/management/konversi_skor/detail_konversi/js';

        //get function view website
        $this->_generate_view($view, $data);
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
   
}



/* CREATE TABLE `buku_detail` (
	`id` INT(12) NOT NULL AUTO_INCREMENT,
	`buku_id` INT(12) NOT NULL,
	`type_file` INT(11) NOT NULL,
	`nama_file` VARCHAR(225) NOT NULL COLLATE 'latin1_swedish_ci',
	`created_date` DATETIME NOT NULL,
	`updated_date` DATETIME NOT NULL,
	`is_enable` TINYINT(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=35
;
 */