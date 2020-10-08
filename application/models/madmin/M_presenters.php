<?php

class M_presenters extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_presenters() {
        $this->db->select('*');
        $this->db->from('presenter');
        $presenter = $this->db->get();
        if ($presenter->num_rows() > 0) {
            return $presenter->result();
        } else {
            return '';
        }
    }

    function add_presenters($post) {
  
        if ($post['cr_type'] == 'save') {
            $or_where = '(email = "' . trim($post['email']) . '")';
            $this->db->where($or_where);
            $presenter = $this->db->get('presenter');
            if ($presenter->num_rows() > 0) {
                return '';
            } else {
                $data = array(
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'presenter_name' => $post['first_name'] . ' ' . $post['last_name'],
                    'title' => $post['title'],
                    'degree' => $post['degree'],
                    'specialty' => "",
                    'designation' => "",
                    'phone' => $post['phone'],
                    'bio' => $post['bio'],
                    'company_name' => $post['company_name'],
                    'email' => $post['email'],
                    'password' => $post['password'],
                    'facebook' => $post['facebook'],
                    'linkin' => $post['linkin'],
                    'twitter' => $post['twitter'],
                    'reg_date' => date("Y-m-d h:i:s")
                );
                $this->db->insert('presenter', $data);
                $pid = $this->db->insert_id();
                if ($pid > 0) {
                    if ($_FILES['presenter_photo']['name'] != "") {
                        $_FILES['presenter_photo']['name'] = $_FILES['presenter_photo']['name'];
                        $_FILES['presenter_photo']['type'] = $_FILES['presenter_photo']['type'];
                        $_FILES['presenter_photo']['tmp_name'] = $_FILES['presenter_photo']['tmp_name'];
                        $_FILES['presenter_photo']['error'] = $_FILES['presenter_photo']['error'];
                        $_FILES['presenter_photo']['size'] = $_FILES['presenter_photo']['size'];
                        $this->load->library('upload');
                        $this->upload->initialize($this->set_upload_options());
                        $this->upload->do_upload('presenter_photo');
                        $file_upload_name = $this->upload->data();
                        $this->db->update('presenter', array('presenter_photo' => $file_upload_name['file_name']), array('presenter_id' => $pid));
                    }
                    return $pid;
                } else {
                    return '';
                }
            }
        } else if ($post['cr_type'] == 'update') {
            $or_where = '(email = "' . trim($post['email']) . '")';
            $this->db->where($or_where);
            $this->db->where("presenter_id !=", $post['presenter_id']);
            $presenter = $this->db->get('presenter');
            if ($presenter->num_rows() > 0) {
                return '';
            } else {
                $set_array = array(
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'presenter_name' => $post['first_name'] . ' ' . $post['last_name'],
                    'specialty' => "",
                    'designation' => "",
                    'phone' => $post['phone'],
                    'title' => $post['title'],
                    'degree' => $post['degree'],
                    'bio' => $post['bio'],
                    'company_name' => $post['company_name'],
                    'password' => $post['password'],
                    'facebook' => $post['facebook'],
                    'linkin' => $post['linkin'],
                    'twitter' => $post['twitter'],
                    'email' => $post['email']
                );
                $this->db->update('presenter', $set_array, array('presenter_id' => $post['presenter_id']));
                if ($post['presenter_id'] > 0) {
                    if ($_FILES['presenter_photo']['name'] != "") {
                        $_FILES['presenter_photo']['name'] = $_FILES['presenter_photo']['name'];
                        $_FILES['presenter_photo']['type'] = $_FILES['presenter_photo']['type'];
                        $_FILES['presenter_photo']['tmp_name'] = $_FILES['presenter_photo']['tmp_name'];
                        $_FILES['presenter_photo']['error'] = $_FILES['presenter_photo']['error'];
                        $_FILES['presenter_photo']['size'] = $_FILES['presenter_photo']['size'];
                        $this->load->library('upload');
                        $this->upload->initialize($this->set_upload_options());
                        $this->upload->do_upload('presenter_photo');
                        $file_upload_name = $this->upload->data();
                       
                        $this->db->update('presenter', array('presenter_photo' => $file_upload_name['file_name']), array('presenter_id' => $post['presenter_id']));
                    }
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    function set_upload_options() {
        $this->load->helper('string');
        $randname = random_string('numeric', '8');
        $config = array();
        $config['upload_path'] = './uploads/presenter_photo/';
        $config['allowed_types'] = 'jpg|png';
        $config['overwrite'] = FALSE;
        $config['file_name'] = "presenter_" . $randname;
        return $config;
    }

    function import_presenter() {
        $this->load->library('csvimport');
        if ($_FILES['import_file']['error'] != 4) {
            $pathMain = FCPATH . "/uploads/csv/";
            $filename = $this->generateRandomString() . '_' . $_FILES['import_file']['name'];
            $result = $this->common->do_upload('import_file', $pathMain, $filename);
            $file_path = $result['upload_data']['full_path'];
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                if (!empty($csv_array)) {
                    foreach ($csv_array as $val) {
                        if ($val['email'] != "" && $val['password'] != "") {
                            $or_where = '(email = "' . trim($val['email']) . '")';
                            $this->db->where($or_where);
                            $presenter = $this->db->get('presenter');
                            if ($presenter->num_rows() > 0) { //Check Email or Phone exist with new User 
                                $import_fail_record['session_presenter'][] = array(
                                    'first_name' => isset($val['first_name']) ? $val['first_name'] : '',
                                    'last_name' => isset($val['last_name']) ? $val['last_name'] : '',
                                    'phone' => isset($val['phone']) ? $val['phone'] : '',
                                    'email' => isset($val['email']) ? $val['email'] : '',
                                    'status' => "This Presenter Already Exists"
                                );
                                $this->session->set_userdata($import_fail_record);
                            } else {
                                $data = array(
                                    'first_name' => isset($val['first_name']) ? $val['first_name'] : '',
                                    'last_name' => isset($val['last_name']) ? $val['last_name'] : '',
                                    'presenter_name' => isset($val['last_name']) ? $val['first_name'] . ' ' . $val['last_name'] : '',
                                    'title' => isset($val['title']) ? $val['title'] : '',
                                    'degree' => isset($val['degree']) ? $val['degree'] : '',
                                    'specialty' => isset($val['specialty']) ? $val['specialty'] : '',
                                    'designation' => isset($val['designation']) ? $val['designation'] : '',
                                    'phone' => isset($val['phone']) ? $val['phone'] : '',
                                    'bio' => isset($val['bio']) ? $val['bio'] : '',
                                    'company_name' => isset($val['company_name']) ? $val['company_name'] : '',
                                    'email' => isset($val['email']) ? $val['email'] : '',
                                    'password' => isset($val['password']) ? $val['password'] : '',
                                    'facebook' => isset($val['facebook_id']) ? $val['facebook_id'] : '',
                                    'linkin' => isset($val['linkin_id']) ? $val['linkin_id'] : '',
                                    'twitter' => isset($val['twitter_id']) ? $val['twitter_id'] : '',
                                    'reg_date' => date("Y-m-d h:i:s")
                                );
                                $this->db->insert('presenter', $data);
                                $pid = $this->db->insert_id();
                                if ($val['profile'] != "") {
                                    $file_name = 'presenter_' . $this->generateRandomString() . '.jpg';
                                    $url = $val['profile'];
                                    $img = './uploads/presenter_photo/' . $file_name;
                                    file_put_contents($img, file_get_contents($url));
                                    $this->db->update('presenter', array('presenter_photo' => $file_name), array('presenter_id' => $pid));
                                }
                            }
                        } else {
                            $import_fail_record['session_presenter'][] = array(
                                'first_name' => trim($val['first_name']),
                                'last_name' => trim($val['last_name']),
                                'phone' => $val['phone'],
                                'email' => $val['email'],
                                'status' => "Import Fail"
                            );
                            $this->session->set_userdata($import_fail_record);
                        }
                    }
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function generateRandomString($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}
