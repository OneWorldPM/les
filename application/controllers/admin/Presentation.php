<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presentation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $login_type = $this->session->userdata('aname');
        if ($login_type != 'admin') {
            redirect('admin/alogin');
        }
        $this->load->model('madmin/m_presentation', 'mpresentation');
    }

    public function index() {
        $data['presentation'] = $this->mpresentation->get_presentation_data();
        $this->load->view('admin/header');
        $this->load->view('admin/presentation', $data);
        $this->load->view('admin/footer');
    }

    public function add_presentation() {
        $post = $this->input->post();
        if (!empty($post)) {
            $res = $this->mpresentation->add_presentation($post);
            if ($res) {
                header('location: ' . base_url() . 'admin/presentation?msg=S');
            } else {
                header('location: ' . base_url() . 'admin/presentation?msg=E');
            }
        }
    }
    
     public function delete_presentation($pid) {
        $this->db->delete('presentation_resources', array('presentation_resources_id' => $pid));
        header('Location: ' . base_url() . 'admin/presentation?msg=D');
    }

}
