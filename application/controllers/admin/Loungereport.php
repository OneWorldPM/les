<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Loungereport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $login_type = $this->session->userdata('aname');
        if ($login_type != 'admin') {
            redirect('admin/alogin');
        }
    }

    public function index() {
        $data['loungereport'] = $this->get_loungereport();
        echo "<pre>";
        print_r($data['loungereport']);
        die;
        $this->load->view('admin/header');
        $this->load->view('admin/loungereport', $data);
        $this->load->view('admin/footer');
    }

     function get_loungereport() {
        $meetings = $query = $this->db->query("
                                        SELECT DISTINCT lm.*, CONCAT(cm.first_name, ' ', cm.last_name) AS host_name
                                        FROM lounge_meetings lm
                                        LEFT JOIN lounge_meeting_attendees lma ON lm.id = lma.meeting_id
                                        LEFT JOIN customer_master cm ON lm.host = cm.cust_id");
        if ($meetings->num_rows() > 0) {

            foreach ($meetings->result() as $meeting) {
                $meeting->attendees = $this->getAttendeesPerMeet($meeting->id);
            }
            return $meetings->result();
        } else {
            return false;
        }
    }

    public function getAttendeesPerMeet($meeting_id) {
        $users = $query = $this->db->query("
                                        SELECT attendee_id 
                                        FROM lounge_meeting_attendees
                                        WHERE meeting_id = '{$meeting_id}'
                                        ");
        if ($users->num_rows() > 0) {
            return $users->result_array();
        } else {
            return '';
        }
    }

}
