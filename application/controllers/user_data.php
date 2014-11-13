<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_data extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
    }

    function __destruct() {
        parent::__destruct();
    }

    public function index() {
        
    }

    public function userdetail() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        $userid = $this->input->get('userid');
        $data['users'] = $this->select_model->getuser($userid);
        $data['service'] = $this->select_model->getservice();
        $data['jobstatus'] = $this->select_model->getjobstatus();
        $data['menu'] = 'user_data';
        $data['body'] = 'user_data/userdetail';
        $this->load->view('template/index', $data);
    }

    public function userprofile() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        $userid = $this->input->get('userid');
        $data['users'] = $this->select_model->getuser($userid);
        $data['service'] = $this->select_model->getservice();
        $data['jobstatus'] = $this->select_model->getjobstatus();
        $data['menu'] = 'user_data';
        // print_r($data['users']);
        $data['body'] = 'user_data/userprofile';
        $this->load->view('template/index', $data);
    }

    public function agentgroup() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        $groupid = $this->input->get('groupid');
        $data['group_detail'] = $this->select_model->getgroup($groupid);
        $data['users'] = $this->select_model->getalluserbygroup($groupid);
        $data['menu'] = 'user_data';
        $data['body'] = 'user_data/agentgroup';
        $this->load->view('template/index', $data);
    }

}
