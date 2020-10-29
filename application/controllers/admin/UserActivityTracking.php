<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UserActivityTracking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $login_type = $this->session->userdata('aname');
        if ($login_type != 'admin') {
            redirect('admin/alogin');
        }
    }

    public function index() {
        $data['user_activity_tracking'] = $this->get_user_activity_tracking();
        $this->load->view('admin/header');
        $this->load->view('admin/user_activity_tracking', $data);
        $this->load->view('admin/footer');
    }

    function get_user_activity_tracking() {
        $this->db->select('u.*, c.first_name,c.last_name,c.phone,c.email,c.city');
        $this->db->from('user_activity u');
        $this->db->join('customer_master c', 'u.user_id=c.cust_id');
        $this->db->order_by("user_activity_id", "desc");
       // $this->db->limit(300);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return '';
        }
    }

}
