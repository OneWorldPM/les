<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lounge_group_chat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/LoungeGroupChat_Model', 'groupChatModel');
    }

    public function index()
    {
        $chats = $this->groupChatModel->getAllChats();

        $data["chats"] = $chats;

        $this->load->view('admin/header');
        $this->load->view('admin/lounge_group_chat',$data);
        $this->load->view('admin/footer');
    }

    public function deleteMessage(){
//        deleteOneMessage()
      $data=  $this->groupChatModel->deleteOneMessage();

    echo $data;
    }


}
