<?php

class SponsorResources extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function getResources(){
        $query=$this->db->query("select sponsor_resources.*,sponsors.sponsors_logo 
                                  from sponsor_resources 
                                  left join sponsors on sponsors.sponsors_id=sponsor_resources.sponsor_id")->result_Array();
        return $query;
    }
    
    function get_presentation_resources() {
        $this->db->select('*');
        $this->db->from('presentation_resources');
        $presentation_resources = $this->db->get();
        if ($presentation_resources->num_rows() > 0) {
            return $presentation_resources->result();
        } else {
            return '';
        }
    }


}
