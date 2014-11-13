<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pending_case extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
    }

    function __destruct() {
        parent::__destruct();
    }

    public function index() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        //print_r($data['user']);
        $data['service'] = $this->select_model->getservice();
        $data['jobstatus'] = $this->select_model->getjobstatus();


        $data['menu'] = 'pending_case';
        $data['body'] = 'pending_case/index';
        $this->load->view('template/index', $data);
    }

}
