<?php

class M_login extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function user_login($username, $password) {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->where("(email = '$username' OR username = '$username')");
        $this->db->where("password", $password);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return '';
        }
    }

    public function register_login($cust_id) {
        $result = $this->db->select('*')->get_where('customer_master', array("cust_id" => $cust_id));
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return '';
        }
    }

    function update_presenter_data($username, $password) {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->where("cust_id", $this->session->userdata("cid"));
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $customer_master = $result->row();
            $presenter_details = $this->db->get_where("presenter", array("email" => $customer_master->email))->row();
            if (!empty($presenter_details)) {
                $update_array = array("username" => $username, "password" => $password);
                $this->db->update("presenter", $update_array, array("presenter_id" => $presenter_details->presenter_id));
            }
        } else {
            return '';
        }
    }

    public function update_user_token($cust_id) {
        $token = $this->generateRandomString();
        $this->db->update("customer_master", array("token" => $token), array("cust_id" => $cust_id));
        return $token;
    }

    function generateRandomString($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}
