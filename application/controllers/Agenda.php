<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $login_type = $this->session->userdata('userType');
        if ($login_type != 'user') {
            redirect('login');
        }
        $get_user_token_details = $this->common->get_user_details($this->session->userdata('cid'));
        if($this->session->userdata('token') != $get_user_token_details->token){
           redirect('login');   
        }
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('agenda');
        $this->load->view('footer');
    }
}
