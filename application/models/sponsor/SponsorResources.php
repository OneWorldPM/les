<?php

class SponsorResources extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function getResources($sponsorId){
        $this->db->select('*');
        $this->db->from('sponsor_resources');
        $this->db->where('sponsor_id', $sponsorId);
        $query = $this->db->get()->result_Array();

        return $query;
    }

}
