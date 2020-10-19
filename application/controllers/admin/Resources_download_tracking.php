<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resources_download_tracking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $login_type = $this->session->userdata('aname');
        if ($login_type != 'admin') {
            redirect('admin/alogin');
        }
        $this->load->model('madmin/m_resources_download_tracking', 'mresources_download_tracking');
    }

    public function index() {
        $data['resources_download_tracking'] = $this->mresources_download_tracking->get_resources_download_tracking();
        $this->load->view('admin/header');
        $this->load->view('admin/resources_download_tracking', $data);
        $this->load->view('admin/footer');
    }

   
}
