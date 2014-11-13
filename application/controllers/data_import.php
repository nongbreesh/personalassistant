<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_import extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    public function truecard_customer() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('csvimport');


        if ($_POST['submit']) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv|txt';
            $config['max_size'] = '10000000';

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                $file = fopen($file_path, "r");

                $this->insert_model->import_truecard_customer($file);
                fclose($file);
            }
        }

        $data['menu'] = 'dashboard';
        $data['body'] = 'importdata/index';
        $this->load->view('template/index', $data);
    }

    public function true_priv_data() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('csvimport');


        if ($_POST['submit']) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv|txt';
            $config['max_size'] = '10000000';

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                $file = fopen($file_path, "r");
                $this->insert_model->import_priv_data_for_edt($file);
                fclose($file);
            }
        }

        $data['menu'] = 'dashboard';
        $data['body'] = 'importdata/index';
        $this->load->view('template/index', $data);
    }

}
