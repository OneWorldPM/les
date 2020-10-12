<?php

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('madmin/m_settings', 'm_settings');
    }


    public function setSessionIframe(){
        echo $this->m_settings->updateSessionIframe();

    }

}
