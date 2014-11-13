<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class master_data extends CI_Controller {

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
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/index';
        $this->load->view('template/index', $data);
    }

    public function create_service() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $data['monthsval'] = "";
        if ($_POST) {
            $data['monthsval'] = $this->input->post('nextmonth');
        }

        $months = array();
        $time = date('d/m/Y');
        array_push($months, date("m/Y", strtotime("+1 month", strtotime($time))));
        array_push($months, date("m/Y", strtotime("+2 month", strtotime($time))));
        array_push($months, date("m/Y", strtotime("+3 month", strtotime($time))));
        array_push($months, date("m/Y", strtotime("+4 month", strtotime($time))));

        $data['nextmonth'] = $months;
        $data['method'] = $this;
        $data['service'] = $this->select_model->getservice();
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_service';
        $this->load->view('template/index', $data);
    }

    public function get_service_totalpoint($serviceid, $months = null) {
        $data['service'] = $this->select_model->getservice_byid($serviceid);
        $data['totalpoint_service'] = $this->select_model->gettotalpoint_service($serviceid, $data['service']->SERVICE_TYPE, '01' . $months)->DEDUCTPOINT;

        if ($data['service']->SERVICE_POINTQUOTA > 0) {
            $rs = $data['service']->SERVICE_POINTQUOTA - $data['totalpoint_service']; // point รวมของ service
        } else {
            $rs = 'ไม่จำกัด';
        }
        return $rs;
    }

    public function create_email() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $data['email'] = $this->select_model->getemail_template();
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_email';
        $this->load->view('template/index', $data);
    }

    public function create_sms() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $data['sms'] = $this->select_model->getsms_template();
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_sms';
        $this->load->view('template/index', $data);
    }

    public function create_sms_new() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if (!empty($_POST['input_btnadd'])) {
            $data['input_name'] = $this->input->post('input_name');
            $data['input_to'] = $this->input->post('input_to');
            $data['input_sender'] = $this->input->post('input_sender');
            $data['input_smsbody'] = $this->input->post('input_smsbody');

            $input = array('SMS_NAME' => $data['input_name']
                , 'SMS_TO' => $data['input_to']
                , 'SMS_SENDER' => $data['input_sender']
                , 'SMS_DESC' => $data['input_smsbody']);

            $service_id = $this->insert_model->save_sms_template($input);
            redirect('master_data/create_sms/' . $service_id . '?status=success&type=create_email');
        }

        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_sms_new';
        $this->load->view('template/index', $data);
    }

    public function create_email_edit($email_id) {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if (!empty($_POST['input_btnadd'])) {
            $data['input_emailid'] = $this->input->post('input_emailid');
            $data['input_subject'] = $this->input->post('input_subject');
            $data['input_body'] = $this->input->post('input_body');
            $data['input_sender'] = $this->input->post('input_sender');
            $data['input_to'] = $this->input->post('input_to');
            $data['input_cc'] = $this->input->post('input_cc');

            $input = array('EMAIL_ID' => $data['input_emailid']
                , 'EMAIL_SUBJECT' => $data['input_subject']
                , 'EMAIL_BODY' => $data['input_body']
                , 'EMAIL_SENDER' => $data['input_sender']
                , 'EMAIL_TO' => $data['input_to']
                , 'EMAIL_CC' => $data['input_cc']);

            $service_id = $this->update_model->update_email_template($input);
            redirect('master_data/create_email_edit/' . $data['input_emailid'] . '?status=success&type=update_email');
        }

        $data['email_id'] = $email_id;
        $data['email'] = $this->select_model->getemail_template_byid($email_id);
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_email_edit';
        $this->load->view('template/index', $data);
    }

    public function create_service_add() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $data['service'] = $this->select_model->getservice();
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_service_add';
        $this->load->view('template/index', $data);
    }

    public function create_service_edit($service_id) {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if (!empty($_POST['input_btnaddscript'])) {
            $data['service_id'] = $this->input->post('service_id');
            $data['input_service_name'] = $this->input->post('input_service_name');
            $data['service_script'] = $this->input->post('service_script');
            $data['input_pointquota'] = $this->input->post('input_pointquota');
            $data['input_type'] = $this->input->post('inputtype');
            $data['input_pointholder'] = $this->input->post('input_pointholder');
            $data['service_pointtype'] = $this->input->post('inputpointtype');
            $data['input_pointdeduct'] = $this->input->post('input_pointdeduct');
            $data['input_email_template_id'] = $this->input->post('input_email_template_id');
            $data['input_sms_template_open'] = $this->input->post('input_sms_template_open');
            $data['input_sms_template_close'] = $this->input->post('input_sms_template_close');



            $input = array('SERVICE_ID' => $data['service_id']
                , 'SERVICE_NAME' => $data['input_service_name']
                , 'SERVICE_SCRIPT' => $data['service_script']
                , 'SERVICE_POINTQUOTA' => $data['input_pointquota']
                , 'SERVICE_TYPE' => $data['input_type']
                , 'SERVICE_POINTHOLDER' => $data['input_pointholder']
                , 'SERVICE_POINTTYPE' => $data['service_pointtype']
                , 'SERVICE_POINTDEDUCT' => $data['input_pointdeduct']
                , 'SERVICE_EMAIL_TEMPLATE_ID' => $data['input_email_template_id']
                , 'SMS_OPEN_TEMPLATE_ID' => $data['input_sms_template_open']
                , 'SMS_CLOSE_TEMPLATE_ID' => $data['input_sms_template_close']);

            if ($this->update_model->update_service($input)) {
                redirect('master_data/create_service_edit/' . $data['service_id'] . '?status=success&type=update_success');
            }
        }

        if (!empty($_POST['input_btnaddpartner'])) {
            $data['service_id'] = $this->input->post('service_id');
            $data['input_partnername'] = $this->input->post('input_partnername');
            $data['input_partnerlink'] = $this->input->post('input_partnerlink');

            $input = array('PARTNER_NAME' => $data['input_partnername']
                , 'PARTNER_LINK' => $data['input_partnerlink']
                , 'PARTNER_SERVICEID' => $data['service_id']);

            if ($this->insert_model->save_partner($input)) {
                redirect('master_data/create_service_edit/' . $data['service_id'] . '?status=success&type=create_partner');
            }
        }

        if (!empty($_POST['input_btnaddcustomfield'])) {
            $data['service_id'] = $this->input->post('service_id');
            $data['input_ftype'] = $this->input->post('input_ftype');
            $data['input_flabel'] = $this->input->post('input_flabel');
            $data['input_fname'] = $this->input->post('input_fname');
            $data['input_fvalue'] = $this->input->post('input_fvalue');
            $data['input_fmandatory'] = $this->input->post('input_fmandatory');
            $data['input_fplaceholder'] = $this->input->post('input_fplaceholder');


            $input = array('CUSTOM_FIELD_LABEL' => $data['input_flabel']
                , 'CUSTOM_FIELD_NAME' => $data['input_fname']
                , 'CUSTOM_FIELD_VALUE' => $data['input_fvalue']
                , 'CUSTOM_FIELD_TYPE' => $data['input_ftype']
                , 'CUSTOM_FIELD_PLACEHOLDER' => $data['input_fplaceholder']
                , 'CUSTOM_FIELD_ISMANDATORY' => $data['input_fmandatory']
                , 'SERVICE_ID' => $data['service_id']);



            if ($this->insert_model->save_customfield($input)) {
                redirect('master_data/create_service_edit/' . $data['service_id'] . '?status=success&type=create_success');
            }
        }



        if (!empty($_POST['input_btnaddarticle'])) {
            $data['service_id'] = $this->input->post('service_id');
            $data['input_article_title'] = $this->input->post('input_article_title');
            $data['input_article_detail'] = $this->input->post('input_article_detail');

            $input = array('ARTICLE_TITLE' => $data['input_article_title']
                , 'ARTICLE_DESCRIPTION' => $data['input_article_detail']
                , 'SERVICE_ID' => $data['service_id']);

            if ($this->insert_model->save_article($input)) {
                redirect('master_data/create_service_edit/' . $data['service_id'] . '?status=success&type=create_article');
            }
        }


        if (!empty($_POST['input_btneditarticle'])) {
            $data['service_id'] = $this->input->post('service_id');
            $data['input_article_id'] = $this->input->post('input_article_id');
            $data['input_article_title'] = $this->input->post('input_article_title');
            $data['input_article_detail'] = $this->input->post('input_article_detail');

            $input = array('ARTICLE_TITLE' => $data['input_article_title']
                , 'ARTICLE_DESCRIPTION' => $data['input_article_detail']
                , 'ARTICLE_ID' => $data['input_article_id']);

            if ($this->update_model->update_article($input)) {
                redirect('master_data/create_service_edit/' . $data['service_id'] . '?status=success&type=update_success');
            }
        }

        if (!empty($_POST['input_btneditcustomfield'])) {
            $data['service_id'] = $this->input->post('service_id');
            $data['input_customf_id'] = $this->input->post('input_customf_id');
            $data['input_ftype'] = $this->input->post('input_ftype');
            $data['input_flabel'] = $this->input->post('input_flabel');
            $data['input_fname'] = $this->input->post('input_fname');
            $data['input_fvalue'] = $this->input->post('input_fvalue');
            $data['input_fmandatory'] = $this->input->post('input_fmandatory');
            $data['input_fplaceholder'] = $this->input->post('input_fplaceholder');

            $input = array('CUSTOM_FIELD_ID' => $data['input_customf_id']
                , 'CUSTOM_FIELD_LABEL' => $data['input_flabel']
                , 'CUSTOM_FIELD_NAME' => $data['input_fname']
                , 'CUSTOM_FIELD_VALUE' => $data['input_fvalue']
                , 'CUSTOM_FIELD_TYPE' => $data['input_ftype']
                , 'CUSTOM_FIELD_PLACEHOLDER' => $data['input_fplaceholder']
                , 'CUSTOM_FIELD_ISMANDATORY' => $data['input_fmandatory']
                , 'SERVICE_ID' => $data['service_id']);

            if ($this->update_model->update_customfield($input)) {
                redirect('master_data/create_service_edit/' . $data['service_id'] . '?status=success&type=update_success');
            }
        }

        $data['service_id'] = $service_id;
        $data['service'] = $this->select_model->getservice_byid($service_id);
        $data['article'] = $this->select_model->getarticle_byserviceid($service_id);
        $data['service_partner'] = $this->select_model->getservice_partner($service_id);
        $data['customf'] = $this->select_model->getcustomfield_byserviceid($service_id);
        $data['email'] = $this->select_model->getemail_template();
        $data['sms'] = $this->select_model->getsms_template();
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_service_edit';
        $this->load->view('template/index', $data);
    }

    public function create_service_new() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if (!empty($_POST['input_btnaddscript'])) {
            $data['input_service_name'] = $this->input->post('input_service_name');
            $data['service_script'] = $this->input->post('service_script');
            $data['input_pointquota'] = $this->input->post('input_pointquota');
            $data['input_type'] = $this->input->post('inputtype');
            $data['input_pointholder'] = $this->input->post('input_pointholder');
            $data['service_pointtype'] = $this->input->post('inputpointtype');
            $data['input_pointdeduct'] = $this->input->post('input_pointdeduct');
            $data['input_email_template_id'] = $this->input->post('input_email_template_id');

            $input = array('SERVICE_NAME' => $data['input_service_name']
                , 'SERVICE_SCRIPT' => $data['service_script']
                , 'SERVICE_POINTQUOTA' => $data['input_pointquota']
                , 'SERVICE_TYPE' => $data['input_type']
                , 'SERVICE_POINTHOLDER' => $data['input_pointholder']
                , 'SERVICE_POINTTYPE' => $data['service_pointtype']
                , 'SERVICE_POINTDEDUCT' => $data['input_pointdeduct']
                , 'SERVICE_EMAIL_TEMPLATE_ID' => $data['input_email_template_id']);


            $service_id = $this->insert_model->save_service($input);
            redirect('master_data/create_service_edit/' . $service_id . '?status=success&type=create_service');
        }

        $data['email'] = $this->select_model->getemail_template();
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_service_new';
        $this->load->view('template/index', $data);
    }

    public function create_email_new() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if (!empty($_POST['input_btnadd'])) {
            $data['input_subject'] = $this->input->post('input_subject');
            $data['input_body'] = $this->input->post('email_body');
            $data['input_sender'] = $this->input->post('input_sender');
            $data['input_to'] = $this->input->post('input_to');
            $data['input_cc'] = $this->input->post('input_cc');

            $input = array('EMAIL_SUBJECT' => $data['input_subject']
                , 'EMAIL_BODY' => $data['input_body']
                , 'EMAIL_SENDER' => $data['input_sender']
                , 'EMAIL_TO' => $data['input_to']
                , 'EMAIL_CC' => $data['input_cc']);

            $service_id = $this->insert_model->save_email_template($input);
            redirect('master_data/create_email/' . $service_id . '?status=success&type=create_email');
        }

        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_email_new';
        $this->load->view('template/index', $data);
    }

    public function create_sms_edit($id) {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        if (!empty($_POST['input_btnadd'])) {
            $data['input_smsid'] = $this->input->post('input_smsid');
            $data['input_name'] = $this->input->post('input_name');
            $data['input_to'] = $this->input->post('input_to');
            $data['input_sender'] = $this->input->post('input_sender');
            $data['input_smsbody'] = $this->input->post('input_smsbody');

            $input = array('SMS_ID' => $data['input_smsid']
                , 'SMS_NAME' => $data['input_name']
                , 'SMS_TO' => $data['input_to']
                , 'SMS_SENDER' => $data['input_sender']
                , 'SMS_DESC' => $data['input_smsbody']);

            $service_id = $this->update_model->update_sms_template($input);
            redirect('master_data/create_sms_edit/' . $data['input_smsid'] . '?status=success&type=update_email');
        }

        $data['sms_id'] = $id;
        $data['email'] = $this->select_model->getsms_template_byid($id);
        $data['menu'] = 'master_data';
        $data['body'] = 'master_data/create_sms_edit';
        $this->load->view('template/index', $data);
    }

    function delete_partner($partner_id, $service_id) {
        if ($this->delete_model->delete_partner($partner_id)) {
            redirect('master_data/create_service_edit/' . $service_id . '?status=success&type=remove_success');
        }
    }

    function delete_customf($customf_id, $service_id) {
        if ($this->delete_model->delete_customf($customf_id)) {
            redirect('master_data/create_service_edit/' . $service_id . '?status=success&type=remove_success');
        }
    }

    function delete_article($article_id, $service_id) {
        if ($this->delete_model->delete_article($article_id)) {
            redirect('master_data/create_service_edit/' . $service_id . '?status=success&type=remove_success');
        }
    }

    function delete_service($service_id) {
        if ($this->delete_model->delete_service($service_id)) {
            redirect('master_data/create_service?status=success&type=remove_service');
        }
    }

    function delete_email_template($email_id) {
        if ($this->delete_model->delete_email($email_id)) {
            redirect('master_data/create_email?status=success&type=remove_email');
        }
    }

    function delete_sms_template($id) {
        if ($this->delete_model->delete_sms($id)) {
            redirect('master_data/create_sms?status=success&type=remove_email');
        }
    }

}
