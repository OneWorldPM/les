<?php

class M_presentation extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_presentation_data() {
        $this->db->select('*');
        $this->db->from('presentation_resources');
        $presentation = $this->db->get();
        if ($presentation->num_rows() > 0) {
            return $presentation->result();
        } else {
            return '';
        }
    }

    function add_presentation($post) {
        $data = array(
            'title' => $post['title'],
        );
        $this->db->insert('presentation_resources', $data);
        $pid = $this->db->insert_id();
        if ($pid) {
            if ($_FILES['resources_file']['name'] != "") {
                $_FILES['resources_file']['name'] = $_FILES['resources_file']['name'];
                $_FILES['resources_file']['type'] = $_FILES['resources_file']['type'];
                $_FILES['resources_file']['tmp_name'] = $_FILES['resources_file']['tmp_name'];
                $_FILES['resources_file']['error'] = $_FILES['resources_file']['error'];
                $_FILES['resources_file']['size'] = $_FILES['resources_file']['size'];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options($post['title'],$pid));
                $this->upload->do_upload('resources_file');
                $file_upload_name = $this->upload->data();
                $this->db->update('presentation_resources', array('resources_file' => $file_upload_name['file_name']), array('presentation_resources_id' => $pid));
            }
        } else {
            return '';
        }
    }
    
     function set_upload_options($name,$pid) {
        $this->load->helper('string');
        $filename = str_replace(' ', '_', strtolower($name));
        $randname = random_string('numeric', '3');
        $config = array();
        $config['upload_path'] = './uploads/presentation_resources/';
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;
        $config['file_name'] = $filename."_".$pid."_".$randname;
        return $config;
    }


}
