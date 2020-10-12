<?php

class M_settings extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function updateSessionIframe() {

        $post = $this->input->post();

        $iframe=$post['iframe'];
        $this->db->update('a_settings', array('value' => $iframe), array('id' => 1));

        return "success";

    }
    function getSessionIframe() {
        $this->db->select('*');
        $this->db->from('a_settings');
        $this->db->where("id", 1);
        $iframe = $this->db->get()->row();

        return $iframe;

    }



}
