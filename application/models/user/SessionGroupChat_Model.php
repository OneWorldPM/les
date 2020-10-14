<?php


class SessionGroupChat_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function newText()
    {

        $userId=$this->session->userdata('cid');
        $userName=$this->session->userdata('fullname');
        $message = htmlspecialchars($this->input->post()['message']);
        $sessionId=$this->input->post()['sessionId'];

        $data = array(
            'user_id' => $userId,
            'user_name' => $userName,
            'message' => $message,
            'session_id' => $sessionId
        );

        $this->db->insert('session_group_chat', $data);

        return $data;
    }
    public function getTexts(){
        $query = $this->db->query("SELECT * FROM session_group_chat ORDER BY id DESC LIMIT 15");
        $result = $query->result_array();
        
        return $result;
    }
    public function sessionGetTexts($sesionId){
        $query = $this->db->query("SELECT * FROM session_group_chat where session_id='$sesionId' ORDER BY id DESC LIMIT 15");
        $result = $query->result_array();

        return $result;
    }
    public function deleteOneMessage(){
        $sessionId = $this->input->post()['sessionId'];

        $this->db->where('id', $sessionId);
        $this->db->delete('session_group_chat');

        return "success";
    }

}
