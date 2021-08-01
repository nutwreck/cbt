<?php 
class VPN_check extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
        $this->output->set_status_header('401'); 
        $this->load->view('errors/html/errVPN');
    } 
} 