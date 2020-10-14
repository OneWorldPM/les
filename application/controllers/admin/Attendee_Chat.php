<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Attendee_Chat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/SessionGroupChat_Model', 'SessionGroupChatModel');
    }



    public function chat($id)
    {
        $chats= $this->SessionGroupChatModel->sessionGetTexts(getAppName($id));

        if($chats)$chats=array_reverse($chats);

        $data["chats"]=$chats;

        $this->load->view('admin/header');
        $this->load->view('admin/attende_chat',$data);
        $this->load->view('admin/footer');
    }

    public function deleteMessage(){
        $data= $this->SessionGroupChatModel->deleteOneMessage();

        echo $data;
    }




}
