<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends CI_Controller {

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


        $data['users'] = $this->select_model->getalluser();
        $data['menu'] = 'setting';
        $data['body'] = 'setting/index';
        $this->load->view('template/index', $data);
    }

    public function create_group() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if ($_POST) {
            $input_groupname = $this->input->post('input_groupname');
            $input = array('USERGROUP_NAME' => $input_groupname);
            $this->insert_model->insert_group($input);
        }

        $data['groups'] = $this->select_model->getallgroup();


        $data['menu'] = 'setting';
        $data['body'] = 'setting/create_group';
        $this->load->view('template/index', $data);
    }

    public function create_user() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if ($_POST) {
            $input_name = $this->input->post('input_name');
            $input_empid = $this->input->post('input_empid');
            $input_fullname = $this->input->post('input_fullname');
            $input_email = $this->input->post('input_email');
            $input_tel = $this->input->post('input_tel');
            $input_groupid = $this->input->post('input_groupid');
            $input_permisionid = $this->input->post('input_permisionid');



            $input = array('USER_NAME' => $input_name
                , 'USER_EMPID' => $input_empid
                , 'USER_FULLNAME' => $input_fullname
                , 'USER_EMAIL' => $input_email
                , 'USER_TEL' => $input_tel
                , 'USER_GROUPID' => $input_groupid
                , 'USER_PERMISSIONID' => $input_permisionid);
            $this->insert_model->insert_user($input);
        }


        $data['permissions'] = $this->select_model->getallpermission();
        $data['groups'] = $this->select_model->getallgroup();
        $data['users'] = $this->select_model->getalluser();
        $data['menu'] = 'setting';
        $data['body'] = 'setting/create_user';
        $this->load->view('template/index', $data);
    }

    public function create_permission() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if ($_POST) {
            $input_name = $this->input->post('input_name');
            $isview = $this->input->post('input_isview') == '' ? '0' : '1';
            $isedit = $this->input->post('input_isedit') == '' ? '0' : '1';
            $isreviewer = $this->input->post('input_isreviewer') == '' ? '0' : '1';
            $isadmin = $this->input->post('input_isadmin') == '' ? '0' : '1';
            $input = array('PERMISSION_NAME' => $input_name
                , 'PERMISSION_ISVIEW' => $isview
                , 'PERMISSION_ISEDIT' => $isedit
                , 'PERMISSION_ISREVIEWER' => $isreviewer
                , 'PERMISSION_ISADMIN' => $isadmin);
            $this->insert_model->insert_permission($input);
        }

        $data['permissions'] = $this->select_model->getallpermission();


        $data['menu'] = 'setting';
        $data['body'] = 'setting/create_permission';
        $this->load->view('template/index', $data);
    }

    function ldap_test() {
        include_once APPPATH . 'libraries/adLDAP.php';
        $username = 'veeray5';
        $password = 'Breesh1112';
        try {
            $adldap = new adLDAP(array('admin_username' => $username, 'admin_password' => $password));
        } catch (adLDAPException $e) {
            $data['message'] = "Username OR Password is incorrect";
            $rs = false;
        }
        $rs = true;
        if ($rs) {
            if ($adldap->authenticate($username, $password)) {
                $userinfo = $adldap->user()->infoCollection($username, array("*"));
                $data['Authen_Logon'] = $userinfo->samaccountname; //Logon
                $data['Authen_Emp_id'] = $userinfo->employeeid; //employeeid
                $data['Authen_Displayname'] = $userinfo->displayname; //Wisuth Ngamcharoen
                $data['Authen_Email'] = $userinfo->mail; //Email
                $data['Authen_Department'] = $userinfo->department; //department
            }
        }
        $rs = $adldap->user()->info('sanpon', array('*'));
        print_r($rs);
    }

}
