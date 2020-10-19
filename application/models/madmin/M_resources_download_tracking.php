<?php

class M_resources_download_tracking extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_resources_download_tracking() {
        $this->db->select('*');
        $this->db->from('download_resources_history d');
        $this->db->join('customer_master c', 'd.cust_id = c.cust_id');
        $this->db->order_by("d.download_resources_history_id", "desc");
        $download_resources = $this->db->get();
        if ($download_resources->num_rows() > 0) {
            return $download_resources->result();
        } else {
            return '';
        }
    }

}
