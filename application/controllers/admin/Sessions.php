<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sessions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->common->set_timezone();
        $login_type = $this->session->userdata('aname');
        if ($login_type != 'admin') {
            redirect('admin/alogin');
        }
        $this->load->model('madmin/m_sessions', 'msessions');
        $this->load->model('madmin/m_settings', 'm_settings');

    }

    public function index() {
        $data['sessions'] = $this->msessions->getSessionsAll();
        $data['session_types'] = $this->msessions->getSessionTypes();
        $import_sessions = $this->session->userdata("session_sessions_data");
        if (!empty($import_sessions)) {
            $data['import_sessions_details'] = $this->session->userdata("session_sessions_data");
            $this->session->unset_userdata('session_sessions_data');
        }
        $iframe=$this->m_settings->getSessionIframe();
        $data['iframe']=$iframe;
        $this->load->view('admin/header');
        $this->load->view('admin/sessions', $data);
        $this->load->view('admin/footer');
    }

    public function filter() {
        $data['sessions'] = $this->msessions->getSessionsFilter();
        $data['session_types'] = $this->msessions->getSessionTypes();

        $this->load->view('admin/header');
        $this->load->view('admin/sessions', $data);
        $this->load->view('admin/footer');
    }
	
	public function filter_clear() {
        $this->session->unset_userdata('start_date');
        $this->session->unset_userdata('end_date');
        header('location:' . base_url() . 'admin/sessions');
    }

    public function add_sessions() {
        $data['presenter'] = $this->msessions->getPresenterDetails();
        $data['sessions_type'] = $this->msessions->getSessionTypes();
        $data['session_tracks'] = $this->msessions->getSessionTracks();
        $this->load->view('admin/header');
        $this->load->view('admin/add_sessions', $data);
        $this->load->view('admin/footer');
    }

    public function createSessions() {
        $result = $this->msessions->createSessions();
        if ($result != "") {
            header('location:' . base_url() . 'admin/sessions?msg=S');
        } else {
            header('location:' . base_url() . 'admin/sessions?msg=E');
        }
    }

    public function edit_sessions($sessions_id) {
        $data['sessions_edit'] = $this->msessions->edit_sessions($sessions_id);
        $data['presenter'] = $this->msessions->getPresenterDetails();
        $data['sessions_type'] = $this->msessions->getSessionTypes();
        $data['session_tracks'] = $this->msessions->getSessionTracks();
        $this->load->view('admin/header');
        $this->load->view('admin/add_sessions', $data);
        $this->load->view('admin/footer');
    }

    function delete_sessions($sessions_id) {
        if ($sessions_id != "") {
            $this->msessions->delete_sessions($sessions_id);
            header('location:' . base_url() . 'admin/sessions?msg=D');
        } else {
            header('location:' . base_url() . 'admin/sessions?msg=E');
        }
    }

    public function updateSessions() {
        $result = $this->msessions->updateSessions();
        if ($result != "") {
            header('location:' . base_url() . 'admin/sessions?msg=U');
        } else {
            header('location:' . base_url() . 'admin/sessions?msg=E');
        }
    }

    public function endSession() {
        $data=$this->msessions->endSession();

        echo $data;
    }

    public function openSession() {
        $data=$this->msessions->openSession();

        echo $data;
    }

    public function create_poll($sessions_id) {
        $data['sessions'] = $this->msessions->edit_sessions($sessions_id);
        $data['poll_type'] = $this->msessions->get_poll_type();
        $this->load->view('admin/header');
        $this->load->view('admin/create_poll', $data);
        $this->load->view('admin/footer');
    }

    public function add_poll_data() {
        $result = $this->msessions->add_poll_data();
        if ($result) {
            header('location:' . base_url() . 'admin/sessions');
        } else {
            header('location:' . base_url() . 'admin/sessions');
        }
    }

    public function view_poll($sessions_id) {
        $data['poll_data'] = $this->msessions->get_poll_details($sessions_id);

        $this->load->view('admin/header');
        $this->load->view('admin/view_poll', $data);
        $this->load->view('admin/footer');
    }

    public function deletePollQuestion($sessions_poll_question_id) {
        if ($sessions_poll_question_id != "") {
            $this->msessions->deletePollQuestion($sessions_poll_question_id);
            header('location:' . base_url() . 'admin/sessions');
        } else {
            header('location:' . base_url() . 'admin/sessions');
        }
    }

    public function editPollQuestion($sessions_poll_question_id) {
        $data['sessions_data'] = $this->msessions->editPollQuestion($sessions_poll_question_id);
        $data['poll_type'] = $this->msessions->get_poll_type();
        $this->load->view('admin/header');
        $this->load->view('admin/create_poll', $data);
        $this->load->view('admin/footer');
    }

    public function update_poll_data() {
        $result = $this->msessions->update_poll_data();
        if ($result) {
            header('location:' . base_url() . 'admin/sessions');
        } else {
            header('location:' . base_url() . 'admin/sessions');
        }
    }

    public function open_poll($sessions_poll_question_id) {
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        if (!empty($sessions_poll_question_row)) {
            $sessions_poll_question_row_data = $this->db->get_where("sessions_poll_question", array("sessions_id" => $sessions_poll_question_row->sessions_id, "status" => 1))->row();
            $sessions_poll_question_row_data_2 = $this->db->get_where("sessions_poll_question", array("sessions_id" => $sessions_poll_question_row->sessions_id, "status" => 2))->row();
            if (empty($sessions_poll_question_row_data) && empty($sessions_poll_question_row_data_2)) {
                $this->db->update("sessions_poll_question", array("status" => 1), array("sessions_poll_question_id" => $sessions_poll_question_id));
                header('location:' . base_url() . 'admin/sessions/view_poll/' . $sessions_poll_question_row->sessions_id . '?msg=U');
            } else {
                header('location:' . base_url() . 'admin/sessions/view_poll/' . $sessions_poll_question_row->sessions_id . '?msg=A');
            }
        }
    }

    public function show_result($sessions_poll_question_id) {
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        if (!empty($sessions_poll_question_row)) {
            $this->db->update("sessions_poll_question", array("status" => 2), array("sessions_poll_question_id" => $sessions_poll_question_id));
            header('location:' . base_url() . 'admin/sessions/view_poll/' . $sessions_poll_question_row->sessions_id . '?msg=U');
        }
    }

    public function close_poll($sessions_poll_question_id) {
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        $this->db->update("sessions_poll_question", array("status" => 4), array("sessions_poll_question_id" => $sessions_poll_question_id));
        header('location:' . base_url() . 'admin/sessions/view_poll/' . $sessions_poll_question_row->sessions_id . '?msg=U');
    }

    public function close_result($sessions_poll_question_id) {
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        $this->db->update("sessions_poll_question", array("status" => 3), array("sessions_poll_question_id" => $sessions_poll_question_id));
        header('location:' . base_url() . 'admin/sessions/view_poll/' . $sessions_poll_question_row->sessions_id . '?msg=U');
    }

    public function view_question_answer($sessions_id) {
        $data['sessions_id'] = $sessions_id;
        $this->load->view('admin/header');
        $this->load->view('admin/view_question_answer', $data);
        $this->load->view('admin/footer');
    }

    public function get_question_list() {
        $result_data = $this->msessions->get_question_list();
        if (!empty($result_data)) {
            $result_array = array("status" => "success", "question_list" => $result_data);
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function addQuestionAnswer() {
        $result_data = $this->msessions->addQuestionAnswer();
        if ($result_data) {
            $result_array = array("status" => "success");
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function report($sessions_id) {
        $data['sessions_report'] = $this->msessions->getSessionsReportData($sessions_id);
        $this->load->view('admin/header');
        $this->load->view('admin/sessions_report', $data);
        $this->load->view('admin/footer');
    }

    function view_result($sessions_poll_question_id) {
        $data['poll_report'] = $this->msessions->view_result($sessions_poll_question_id);
        $this->load->view('admin/header');
        $this->load->view('admin/view_result', $data);
        $this->load->view('admin/footer');
    }

    public function view_session($sessions_id) {
        $data['poll_data'] = $this->msessions->get_poll_details($sessions_id);
        $data["sessions"] = $this->msessions->view_session($sessions_id);
        $data["session_resource"] = $this->msessions->get_session_resource($sessions_id);
        $this->load->view('admin/header');
        $this->load->view('admin/view_session', $data);
        $this->load->view('admin/footer');
    }

    public function get_poll_vot_section() {
        $result_data = $this->msessions->get_poll_vot_section();
        if (!empty($result_data)) {
            $result_array = array("status" => "success", "result" => $result_data);
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function get_poll_vot_section_close_poll() {
        $result_data = $this->msessions->get_poll_vot_section_close_poll();
        if (!empty($result_data)) {
            $result_array = array("status" => "success", "result" => $result_data);
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function favorite_hide_question() {
        $post = $this->input->post();
        if ($post['tbl_favorite_question_admin_id'] != '') {
            $this->db->update('tbl_favorite_question_admin', array('hide_status' => 1), array('tbl_favorite_question_admin_id' => $post['tbl_favorite_question_admin_id']));
            if ($this->db->affected_rows()) {
                $result_array = array("status" => "success");
            } else {
                $result_array = array("status" => "error");
            }
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function get_favorite_question_list() {
        $result_data = $this->msessions->get_favorite_question_list();
        if (!empty($result_data)) {
            $result_array = array("status" => "success", "question_list" => $result_data);
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function likeQuestion() {
        $result_data = $this->msessions->likeQuestion();
        if ($result_data) {
            $result_array = array("status" => "success");
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function open_poll_ajax() {
        $sessions_poll_question_id = $this->input->post('sessions_poll_question_id');
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        if (!empty($sessions_poll_question_row)) {
            $sessions_poll_question_row_data = $this->db->get_where("sessions_poll_question", array("sessions_id" => $sessions_poll_question_row->sessions_id, "status" => 1))->row();
            $sessions_poll_question_row_data_2 = $this->db->get_where("sessions_poll_question", array("sessions_id" => $sessions_poll_question_row->sessions_id, "status" => 2))->row();
            if (empty($sessions_poll_question_row_data) && empty($sessions_poll_question_row_data_2)) {
                $this->db->update("sessions_poll_question", array("status" => 1), array("sessions_poll_question_id" => $sessions_poll_question_id));
                $result_array = array("status" => "success");
            } else {
                $result_array = array("status" => "error");
            }
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function show_result_ajax() {
        $sessions_poll_question_id = $this->input->post('sessions_poll_question_id');
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        if (!empty($sessions_poll_question_row)) {
            $this->db->update("sessions_poll_question", array("status" => 2), array("sessions_poll_question_id" => $sessions_poll_question_id));
            $result_array = array("status" => "success");
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    public function close_poll_ajax() {
        $sessions_poll_question_id = $this->input->post('sessions_poll_question_id');
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        $this->db->update("sessions_poll_question", array("status" => 4), array("sessions_poll_question_id" => $sessions_poll_question_id));
        $result_array = array("status" => "success");
        echo json_encode($result_array);
    }

    public function close_result_ajax() {
        $sessions_poll_question_id = $this->input->post('sessions_poll_question_id');
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        $this->db->update("sessions_poll_question", array("status" => 3), array("sessions_poll_question_id" => $sessions_poll_question_id));
        $result_array = array("status" => "success");
        echo json_encode($result_array);
    }

    public function hide_question() {
        $post = $this->input->post();
        if ($post['sessions_question_id'] != '') {
            $this->db->update('sessions_cust_question', array('hide_status' => 1), array('sessions_cust_question_id' => $post['sessions_question_id']));
            if ($this->db->affected_rows()) {
                $result_array = array("status" => "success");
            } else {
                $result_array = array("status" => "error");
            }
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    function poll_redo($sessions_poll_question_id) {
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        $this->db->update("sessions_poll_question", array("status" => 0, "timer_status" => 0), array("sessions_poll_question_id" => $sessions_poll_question_row->sessions_poll_question_id));
        $this->db->update("poll_question_option", array("total_vot" => 0), array("sessions_poll_question_id" => $sessions_poll_question_id));
        $this->db->delete("tbl_poll_voting", array("sessions_poll_question_id" => $sessions_poll_question_id));
        header('location:' . base_url() . 'admin/sessions/view_poll/' . $sessions_poll_question_row->sessions_id . '?msg=U');
    }

    function resource($sessions_id) {
        $data['resource'] = $this->msessions->get_resource($sessions_id);
        $data['sessions_id'] = $sessions_id;
        $this->load->view('admin/header');
        $this->load->view('admin/resource', $data);
        $this->load->view('admin/footer');
    }

    public function add_resource() {
        $post = $this->input->post();
        if (!empty($post)) {
            $res = $this->msessions->add_resource($post);
            if ($res) {
                header('Location: ' . base_url() . 'admin/sessions/resource/' . $post['sessions_id'] . '?msg=S');
            } else {
                header('Location: ' . base_url() . 'admin/sessions/resource/' . $post['sessions_id'] . '?msg=E');
            }
        }
    }

    public function delete_resource($rid) {
        $sessions_id = $this->input->get('sessions_id');
        $this->db->delete('session_resource', array('session_resource_id' => $rid));
        header('Location: ' . base_url() . 'admin/sessions/resource/' . $sessions_id);
    }

    public function remove_presenter_by_session() {
        $post = $this->input->post();
        $this->db->delete('sessions_add_presenter', array('sessions_add_presenter_id' => $post['sessions_add_presenter_id']));
        $result_array = array("status" => "success");
        echo json_encode($result_array);
    }

    public function start_timer($sessions_poll_question_id) {
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        $this->db->update("sessions_poll_question", array("timer_status" => 1), array("sessions_poll_question_id" => $sessions_poll_question_id));
        header('location:' . base_url() . 'admin/sessions/view_poll/' . $sessions_poll_question_row->sessions_id . '?msg=U');
    }

    public function start_timer_ajax() {
        $sessions_poll_question_id = $this->input->post('sessions_poll_question_id');
        $sessions_poll_question_row = $this->db->get_where("sessions_poll_question", array("sessions_poll_question_id" => $sessions_poll_question_id))->row();
        if (!empty($sessions_poll_question_row)) {
            $this->db->update("sessions_poll_question", array("timer_status" => 1), array("sessions_poll_question_id" => $sessions_poll_question_id));
            $result_array = array("status" => "success");
        } else {
            $result_array = array("status" => "error");
        }
        echo json_encode($result_array);
    }

    function importSessionsPoll() {
        $result = $this->msessions->importSessionsPoll();
        if ($result) {
            header('location:' . base_url() . 'admin/sessions?msg=S');
        } else {
            header('location:' . base_url() . 'admin/sessions?msg=E');
        }
    }

    function user_sign_up($sessions_id) {
        $data['user'] = $this->msessions->get_user_sign_up($sessions_id);
        $this->load->view('admin/header');
        $this->load->view('admin/user_sign_up', $data);
        $this->load->view('admin/footer');
    }

    function import_sessions() {
        $result = $this->msessions->import_sessions();
        if ($result) {
            header('location:' . base_url() . 'admin/sessions?msg=S');
        } else {
            header('location:' . base_url() . 'admin/sessions?msg=E');
        }
    }
    
     public function alldelete($id) {
        $ids = (explode(',', $id));
        $query = $this->msessions->alldelete($ids);
        if ($query) {
            header("location:" . base_url() . "admin/sessions?msg=D");
        } else {
            header("location:" . base_url() . "admin/sessions?msg=E");
        }
    }

}
