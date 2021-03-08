<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

    public function __construct(){
		  parent::__construct();
    }

    public function index(){
        $this->load->view('website/_template/header');
        $this->load->view('website/ujian/css');
        $this->load->view('website/ujian/content_dashboard');
        $this->load->view('website/_template/footer');
    }

    public function lembar_soal(){
        $this->load->view('website/_template/header');
        $this->load->view('website/ujian/css');
        $this->load->view('website/ujian/content_main');
        $this->load->view('website/_template/footer');
    }
}