<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    public function index() {
        $data = null;
        if ($_POST) {
            include_once APPPATH . 'libraries/adLDAP.php';
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $rs = true;
            try {
                $adldap = new adLDAP(array('admin_username' => $username, 'admin_password' => $password));
            } catch (adLDAPException $e) {
                echo "<script> alert('Username OR Password is incorrect');</script>";
                $rs = false;
            }
            if (!$adldap) {
                //echo "<script> alert('Username OR Password is incorrect');</script>";
                $rs = false;
            }

            if ($rs) {
                if ($adldap->authenticate($username, $password)) {
                    $userinfo = $adldap->user()->infoCollection($username, array("*"));
                    $data['Authen_Logon'] = $userinfo->samaccountname; //Logon
                    $data['Authen_Emp_id'] = $userinfo->employeeid; //employeeid
                    $data['Authen_Displayname'] = $userinfo->displayname; //Wisuth Ngamcharoen
                    $data['Authen_Email'] = $userinfo->mail; //Email
                    $data['Authen_Department'] = $userinfo->department; //department
                }

                $input = array('empid' => $data['Authen_Emp_id']);

                if ($this->user_model->getauthen($input)) {
                    redirect(base_url() . 'dashboard');
                } else {
                    echo "<script> alert('You do not have a permission to using this application');</script>";
                }
            }
            /* $input['username'] = $this->input->post('username');
              $input['password'] = $this->input->post('password');
              $input['empid'] = '01011550';
              if ($this->user_model->getauthen($input)) {
              redirect(base_url() . 'dashboard');
              } */
        }

        $this->load->view('template/login', $data);
    }

}
