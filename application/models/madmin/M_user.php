<?php

class M_user extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getUserData() {
        $this->db->select('*');
        $this->db->from('customer_master c');
        $this->db->order_by("c.cust_id", "DESC");
        $user = $this->db->get();
        if ($user->num_rows() > 0) {
            return $user->result();
        } else {
            return '';
        }
    }

    function getUserDetail($userid) {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->where('cust_id', $userid);
        $user = $this->db->get();
        if ($user->num_rows() > 0) {
            return $user->row();
        } else {
            return '';
        }
    }

    function filter_search() {
        $post = $this->input->post();

        $this->db->select('*');
        $this->db->from('customer_master');

        ($post['start_date'] != "") ? $where['DATE(register_date) >='] = date('Y-m-d', strtotime($post['start_date'])) : '';
        ($post['end_date'] != "") ? $where['DATE(register_date) <='] = date('Y-m-d', strtotime($post['end_date'])) : '';

        ($post['country'] != "") ? $where['country'] = trim($post['country']) : '';

        ($post['cname'] != "") ? $where['fullname LIKE'] = '%' . trim($post['cname']) . '%' : '';

        ($post['phone_number'] != "") ? $where['phone LIKE'] = '%' . trim($post['phone_number']) . '%' : '';

        if (!empty($where)) {
            $this->db->where($where);
        } else {
            return "";
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return "";
        }
    }

    function add_customer() {
        $post = $this->input->post();
        $or_where = '(email = "' . trim($post['email']) . '" or phone = "' . trim($post['phone']) . '")';
        $this->db->where($or_where);
        $customer = $this->db->get('customer_master');
        if ($customer->num_rows() > 0) { //Check Email or Phone exist with new User 
            return "0";
        } else {
            $set = array(
                'fullname' => trim($post['full_name']),
                'phone' => trim($post['phone']),
                'email' => trim($post['email']),
                'password' => base64_encode($post['password']),
                'country' => trim($post['country']),
                'status' => 1,
                "verified_status" => 1,
                'referralcode' => $this->generateRandomString(),
                'referralcodefrom' => ""
            );
            $this->db->insert("customer_master", $set);
            $cust_id = $this->db->insert_id();
            if ($cust_id > 0) {
                $from = 'support@devtesting.club';
                $subject = 'Registration is Successful';
                $message = '<p>Congratulation, Your registration is successful You can login. <br><br><br> Best Regards,<br>Portal Team<p>';
                $this->common->sendEmail($from, trim($post['email']), $subject, $message);
                return "1";
            } else {
                return "2";
            }
        }
    }

    function updateCustomer($post) {
        $set = array(
            'fullname' => trim($post['full_name']),
            'phone' => trim($post['phone']),
            'country' => trim($post['country']),
            'status' => 1
        );
        $this->db->update("customer_master", $set, array('cust_id' => $post['cid']));
        return "1";
    }

    function generateRandomString($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function get_user_activity($userid) {
        $this->db->select('*');
        $this->db->from('user_activity');
        $this->db->where('user_id', $userid);
        $user = $this->db->get();
        if ($user->num_rows() > 0) {
            return $user->result();
        } else {
            return '';
        }
    }

    function import_user() {
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
                        if ($val['Email_Address'] != "" && $val['Password'] != "") {
                            $post = $this->input->post();
                            $or_where = '(email = "' . trim($val['Email_Address']) . '")';
                            $this->db->where($or_where);
                            $customer = $this->db->get('customer_master');
                            if ($customer->num_rows() > 0) { //Check Email or Phone exist with new User 
                                continue;
                            } else {
                                $this->db->order_by("cust_id", "desc");
                                $row_data = $this->db->get("customer_master")->row();
                                if (!empty($row_data)) {
                                    $reg_id = $row_data->cust_id;
                                    $register_id = date("Y") . '-20' . $reg_id;
                                } else {
                                    $register_id = date("Y") . '-200';
                                }
                                $set = array(
                                    "register_id" => $register_id,
                                    "user_id" => trim($val['Registration_Badge_ID']),
                                    'first_name' => trim($val['First_Name']),
                                    'last_name' => trim($val['Last_Name']),
                                    'email' => trim($val['Email_Address']),
                                    'username' => "",
                                    'password' => base64_encode($val['Password']),
                                    'specialty' => trim($val['Specialty']),
                                    'address' => trim($val['Address']),
                                    'address_cont' => trim($val['Address_cont']),
                                    'city' => trim($val['City']),
                                    'state' => trim($val['State']),
                                    'country' => trim($val['Country']),
                                    'phone' => trim($val['Phone']),
                                    'company_name' => trim($val['Organization']),
                                    'title' => trim($val['Title']),
                                    'twitter_id' => trim($val['twitter_id']),
                                    'facebook_id' => trim($val['facebook_id']),
                                    'instagram_id' => trim($val['instagram_id']),
                                    'customer_type' => $val['Attendee_Type_Name'],
                                    'member_status' => $val['Attendee_Type_Name'],
                                    'website' => $val['Website'],
                                    'status' => 1,
                                    'event_date' => date("Y-m-d", strtotime($val['Event_Date'])),
                                    'register_date' => date("Y-m-d h:i")
                                );
                                $this->db->insert("customer_master", $set);
                                $cid = $this->db->insert_id();
                                if ($val['Profile'] != "") {
                                    $file_name = 'member_' . $this->generateRandomString() . '.jpg';
                                    $url = $val['Profile'];
                                    $img = './uploads/customer_profile/' . $file_name;
                                    file_put_contents($img, file_get_contents($url));
                                    $this->db->update('customer_master', array('profile' => $file_name), array('cust_id' => $cid));
                                }
                            }
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

    function add_user_with_type($post) {
        if ($post['cr_type'] == 'save') {
            if ($post['username'] != '' && $post['password'] != '') {
                $or_where = '(username = "' . trim($post['username']) . '")';
                $this->db->where($or_where);
                $customer = $this->db->get('customer_master');
                if ($customer->num_rows() > 0) { //Check Email or Phone exist with new User 
                    return "exist";
                } else {
                    $this->db->order_by("cust_id", "desc");
                    $row_data = $this->db->get("customer_master")->row();
                    if (!empty($row_data)) {
                        $reg_id = $row_data->cust_id;
                        $register_id = date("Y") . '-20' . $reg_id;
                    } else {
                        $register_id = date("Y") . '-200';
                    }
                    $set = array(
                        "register_id" => $register_id,
                        'first_name' => "",
                        'last_name' => "",
                        'email' => $post['email'],
                        'username' => $post['username'],
                        'password' => base64_encode($post['password']),
                        'customer_type' => $post['member_type'],
                        'member_status' => "non-member",
                        'register_date' => date("Y-m-d h:i")
                    );
                    $this->db->insert("customer_master", $set);
                    $cust_id = $this->db->insert_id();
                    if ($cust_id > 0) {
                        return $cust_id;
                    } else {
                        return "error";
                    }
                }
            } else {
                return "error";
            }
        } else if ($post['cr_type'] == 'update') {
            $set = array(
                'customer_type' => $post['member_type']
            );
            $this->db->update("customer_master", $set, array("cust_id" => $post['cust_id']));
            $cust_id = $post['cust_id'];
            if ($cust_id > 0) {
                return $cust_id;
            } else {
                return "error";
            }
        }
    }

}
