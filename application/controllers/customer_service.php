<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_service extends CI_Controller {

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
        $data['status'] = $this->input->get('status');
        $data['menu'] = 'customer_service';
        $data['input_search'] = '';

        $data['cardid'] = '0';
        if (!empty($_GET['cardid'])) {
            $data['cardid'] = $this->input->get('cardid');
        }
        $data['datanotfound'] = false;

        $data['customer_detail'] = null;

        if (!empty($_POST['input_btnsearch'])) {
            $data['datanotfound'] = true;
            $data['input_search'] = trim($this->input->post('input_search'));

            $offset = 0;
            $limit = 5;
            $data['jobstatus'] = $this->select_model->getjobstatus();
            $data['customer_detail'] = $this->select_model->getcustomer_search($data['input_search']);
            if (count($data['customer_detail']) == 0) {
                $cardinfo = $this->user_model->_get_card_info(ACCESSTOKEN, $data['input_search']);
                if ($cardinfo['ErrorCode'] == 0) {
                    $data['customer_detail'][0]->CARDNAME = $cardinfo['CardName'];
                    $data['customer_detail'][0]->THAIID = $cardinfo['ThaiID'];
                    $data['customer_detail'][0]->CARDADDRESS = $cardinfo['CardAddress'];
                    $data['customer_detail'][0]->CARDID = $cardinfo['TrueCardNr'];
                    $data['customer_detail'][0]->CARDTYPE_NAME = $cardinfo['CardType'];
                    $data['customer_detail'][0]->ENDDATE = $cardinfo['CardExpired'];
                    $data['customer_detail'][0]->STATUS_NAME = 'A';
                    $data['customer_detail'][0]->STATUS_DESCRIPTION = 'ใช้งานได้ (Active)';

                    $input_enddate = $cardinfo['CardExpired'];
                    $input = array('CARDNAME' => $cardinfo['CardName']
                        , 'THAIID' => $cardinfo['ThaiID']
                        , 'CARDADDRESS' => $cardinfo['CardAddress']
                        , 'ID' => $data['customer_detail'][0]->ID
                        , 'STATUS' => $data['customer_detail'][0]->STATUS_NAME
                        , 'CARDID' => $cardinfo['TrueCardNr']
                        , 'CARDTYPE' => $cardinfo['CardType'] == 'BLACK' ? 2 : 1
                        , 'CREATE_BY' => 'PA_SYSTEM');

                    if ($this->insert_model->inserte_truecardcust($input, $input_enddate)) {
                        $data['dataupdate'] = $time = date('d/m/Y H:i:s');
                    }
                }
            } elseif (count($data['customer_detail']) == 1) {
                $cardinfo = $this->user_model->_get_card_info(ACCESSTOKEN, $data['customer_detail'][0]->THAIID);
                if ($cardinfo['ErrorCode'] == 0) {
                    $data['customer_detail'][0]->CARDTYPE_NAME = $cardinfo['CardName'];
                    $data['customer_detail'][0]->CARDADDRESS = $cardinfo['CardAddress'];
                    $data['customer_detail'][0]->CARDID = $cardinfo['TrueCardNr'];
                    $data['customer_detail'][0]->CARDTYPE_NAME = $cardinfo['CardType'];
                    $data['customer_detail'][0]->ENDDATE = $cardinfo['CardExpired'];
                    $data['customer_detail'][0]->STATUS = 'A';
                    $data['customer_detail'][0]->STATUS_DESCRIPTION = 'ใช้งานได้ (Active)';

                    $input_enddate = $cardinfo['CardExpired'];
                    $input = array('CARDNAME' => $cardinfo['CardName']
                        , 'CARDADDRESS' => $cardinfo['CardAddress']
                        , 'ID' => $data['customer_detail'][0]->ID
                        , 'CARDID' => $cardinfo['TrueCardNr']
                        , 'CARDTYPE' => $cardinfo['CardType'] == 'BLACK' ? 2 : 1
                        , 'STATUS' => 'A'
                        , 'LAST_UPDATE_BY' => 'PA_SYSTEM');

                    $cardinfo = $this->user_model->_get_card_info(ACCESSTOKEN, $data['customer_detail'][0]->THAIID);

                    if ($this->update_model->update_truecardcust($input, $input_enddate)) {
                        $data['dataupdate'] = $time = date('d/m/Y H:i:s');
                    }
                } else {
                    //$data['customer_detail'][0]->CARDTYPE_NAME = $cardinfo['CardName'];
                    // $data['customer_detail'][0]->CARDADDRESS = $cardinfo['CardAddress'];
                    //$data['customer_detail'][0]->CARDID = $cardinfo['TrueCardNr'];
                    //$data['customer_detail'][0]->CARDTYPE_NAME = $cardinfo['CardType'];
                    //$data['customer_detail'][0]->ENDDATE = $cardinfo['CardExpired'];
                    $data['customer_detail'][0]->STATUS = 'C';
                    $data['customer_detail'][0]->STATUS_DESCRIPTION = 'ยกเลิก (Cancel)';

                    $input_enddate = $cardinfo['CardExpired'];
                    $input = array('STATUS' => 'C'
                        , 'LAST_UPDATE_BY' => 'PA_SYSTEM');
                    if ($this->update_model->update_truecardcust($input, $input_enddate)) {
                        $data['dataupdate'] = $time = date('d/m/Y H:i:s');
                    }
                }


                $data['cardid'] = $data['customer_detail'][0]->CARDID;
                $data['customer_activity'] = $this->select_model->getcustomer_activity($data['customer_detail'][0]->CARDID, $offset, $limit);
            }
        } else {
            if (!empty($_GET['cardid'])) {
                $data['datanotfound'] = true;
                if (!empty($_POST['input_btnsearch'])) {
                    $data['input_search'] = trim($this->input->post('input_search'));
                }
                $cardid = $this->input->get('cardid');
                $recid = $this->input->get('recid');

                $offset = 0;
                $limit = 5;

                $data['jobstatus'] = $this->select_model->getjobstatus();
                $data['customer_detail'] = $this->select_model->getcustomerlist_byid($cardid);

                $cardinfo = $this->user_model->_get_card_info(ACCESSTOKEN, $data['customer_detail'][0]->THAIID);


                if ($cardinfo['ErrorCode'] == 0) {
                    $data['customer_detail'][0]->CARDTYPE_NAME = $cardinfo['CardName'];
                    $data['customer_detail'][0]->CARDADDRESS = $cardinfo['CardAddress'];
                    $data['customer_detail'][0]->CARDID = $cardinfo['TrueCardNr'];
                    $data['customer_detail'][0]->CARDTYPE_NAME = $cardinfo['CardType'];
                    $data['customer_detail'][0]->ENDDATE = $cardinfo['CardExpired'];
                    $data['customer_detail'][0]->STATUS = 'A';
                    $input_enddate = $cardinfo['CardExpired'];
                    $input = array('CARDNAME' => $cardinfo['CardName']
                        , 'CARDADDRESS' => $cardinfo['CardAddress']
                        , 'ID' => $data['customer_detail'][0]->ID
                        , 'CARDID' => $cardinfo['TrueCardNr']
                        , 'CARDTYPE' => $cardinfo['CardType'] == 'BLACK' ? 2 : 1
                        , 'STATUS' => 'A'
                        , 'LAST_UPDATE_BY' => 'PA_SYSTEM');
                    if ($this->update_model->update_truecardcust($input, $input_enddate)) {
                        $data['dataupdate'] = $time = date('d/m/Y H:i:s');
                    }
                } else {
                    $data['customer_detail'][0]->STATUS = 'C';
                    $data['customer_detail'][0]->STATUS_DESCRIPTION = 'ยกเลิก (Cancel)';
                    $input_enddate = $cardinfo['CardExpired'];
                    $input = array('STATUS' => 'C'
                        , 'LAST_UPDATE_BY' => 'PA_SYSTEM');
                    if ($this->update_model->update_truecardcust($input, $input_enddate)) {
                        $data['dataupdate'] = $time = date('d/m/Y H:i:s');
                    }
                }

                $data['cardid'] = $cardid;
                if (count($data['customer_detail']) == 1) {
                    $data['customer_activity'] = $this->select_model->getcustomer_activity($data['customer_detail'][0]->CARDID, $offset, $limit);
                } else {
                    
                }
            }
        }
        $data['body'] = 'customer_service/index';
        $this->load->view('template/index', $data);
    }

    public function select_service() {
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $data['cardid'] = $this->input->get('cardid');
        $data['recid'] = $this->input->get('recid');
        $data['service'] = $this->select_model->getservice();
        $data['customer_detail'] = $this->select_model->getcustomer_bycardid($data['cardid']);
        $data['menu'] = 'customer_service';
        $data['body'] = 'customer_service/select_service';
        $this->load->view('template/index', $data);
    }

    public function apply_service($id) {

        $serviceid = $id;
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }

        $months = array();
        $time = date('d/m/Y');
        array_push($months, date("m/Y", strtotime("+1 month", strtotime($time))));
        array_push($months, date("m/Y", strtotime("+2 month", strtotime($time))));
        array_push($months, date("m/Y", strtotime("+3 month", strtotime($time))));
        array_push($months, date("m/Y", strtotime("+4 month", strtotime($time))));
        $data['nextmonth'] = $months;
        $data['method'] = $this;
        $data['cardid'] = $this->input->get('cardid');
        $data['recid'] = $this->input->get('recid');
        $data['customfields'] = $this->select_model->getcustomfield_byserviceid($id);

        $this->session->set_flashdata('flagsave', false);


        $data['customer_detail'] = $this->select_model->getcustomer_bycardid($data['cardid']);
        $data['service'] = $this->select_model->getservice_byid($id);
        $data['service_partner'] = $this->select_model->getservice_partner($id);
        $data['article'] = $this->select_model->getarticle_byserviceid($id);

        $data['deductpoint'] = $this->select_model->gettotalpoint_activity($data['cardid'], $serviceid, $data['service']->SERVICE_TYPE, null)->DEDUCTPOINT;
        $data['totalpoint_service'] = $this->select_model->gettotalpoint_service($serviceid, $data['service']->SERVICE_TYPE)->DEDUCTPOINT;

        if ($data['service']->SERVICE_POINTQUOTA > 0) {
            $data['service_totalpoint'] = $data['service']->SERVICE_POINTQUOTA - $data['totalpoint_service']; // point รวมของ service
        } else {
            $data['service_totalpoint'] = 9999999999999999;
        }
        $data['totalpoint'] = $data['service']->SERVICE_POINTHOLDER - $data['deductpoint'];

        $data['jobstatus'] = $this->select_model->getjobstatus();

        $data['customer_activity'] = $this->select_model->getcustomer_activitybyserviceid($serviceid, $data['cardid'], 0, 10);


        $data['menu'] = 'customer_service';
        $data['body'] = 'customer_service/apply_service';
        $this->load->view('template/index', $data);
    }

    public function mapmonth($month) {
        $M = substr($month, 0, 2);
        $Y = substr($month, 3, 5);
        $thai_month_arr = array(
            "00" => "",
            "01" => "มค.",
            "02" => "กพ.",
            "03" => "มีค.",
            "04" => "เมษ",
            "05" => "พค.",
            "06" => "มิย.",
            "07" => "กค.",
            "08" => "สค.",
            "09" => "กย.",
            "10" => "ตค.",
            "11" => "พย.",
            "12" => "ธค."
        );
        $THM = "";
        $THM = $thai_month_arr[$M];
        return $THM . $Y;
    }

    public function get_userservice_totalpoint($serviceid, $months = null, $cardid = null) {
        $service = $this->select_model->getservice_byid($serviceid);
        $totalpoint_service = $this->select_model->gettotalpoint_service($serviceid, $service->SERVICE_TYPE, '01/' . $months)->DEDUCTPOINT;


        if ($service->SERVICE_POINTQUOTA != 0) {
            $isunlimit = false;
            $lasttotalpoint_service = $service->SERVICE_POINTQUOTA - $totalpoint_service; // point รวมของ service
        } else {
            $lasttotalpoint_service = 999999999999;
            $isunlimit = true;
        }

        $deductpoint = $this->select_model->gettotalpoint_activity($cardid, $serviceid, $service->SERVICE_TYPE, '01/' . $months)->DEDUCTPOINT;
        //$totalpoint_service = $this->select_model->gettotalpoint_service($serviceid, $service->SERVICE_TYPE, '01/' . $months)->DEDUCTPOINT;

        if ($data['service']->SERVICE_POINTQUOTA > 0) {
            $service_totalpoint = $service->SERVICE_POINTQUOTA - $totalpoint_service; // point รวมของ service
        } else {
            $service_totalpoint = 9999999999999999;
        }


        $totalpoint = $service->SERVICE_POINTHOLDER - $deductpoint;

        if ($lasttotalpoint_service <= 0 && $isunlimit == false) {
            return '<span style="color:red"><b>มีผู้ใช้สิทธิ์ครบจำนวนแล้ว</b></span>';
        } else {
            if ($totalpoint <= 0) {
                return '<span style="color:red"><b>ลูกค้าใช้สิทธิ์นี้แล้ว</b></span>';
            } else {
                return 'จำนวนสิทธิ์ที่ใช้ได้ <span style="color:green"><b>' . $totalpoint . '/' . $service->SERVICE_POINTHOLDER . '</b></span>';
            }
        }
    }

    public function send_sms($id, $type, $activityid) {
        $service = $this->select_model->getservice_byid($id);

        //print_r($service);

        if ($type == 'open') {
            if ($service->SMS_OPEN_TEMPLATE_ID != null) {
                $sms = $this->select_model->getsms_template_byid($service->SMS_OPEN_TEMPLATE_ID);
            }
        } else {
            if ($service->SMS_CLOSE_TEMPLATE_ID != null) {
                $sms = $this->select_model->getsms_template_byid($service->SMS_CLOSE_TEMPLATE_ID);
            }
        }
        if ($sms != null) {

            $activity = $this->select_model->getcustomer_activity_byid($activityid);

            $html_customfield = '';
            $customfield = explode(';', rtrim($activity->ACTIVITY_CUSTOMFIELD, ";"));
            foreach ($customfield as $field) {
                $f = explode(',', $field);
                $html_customfield .= $f[1] . " : " . $f[2] . "<br/>";
            }

            $time = date('d/m/Y H:i:s');
            $sms_body = $sms->SMS_DESC;
            $sms_body = str_replace("{cust_name}", $activity->ACTIVITY_CONTACTNAME . ' ,', $sms_body);
            $sms_body = str_replace("{cust_tel}", $activity->ACTIVITY_CONTACTNUMBER . ' ,', $sms_body);
            $sms_body = str_replace("{due_date}", $activity->ACTIVITY_DUEDATE . ' ,', $sms_body);
            $sms_body = str_replace("{cust_contactinfo}", $activity->ACTIVITY_NOTE . ' ,', $sms_body);
            $sms_body = str_replace("{datenow}", $time . ' ,', $sms_body);
            $sms_body = str_replace("{truecard_no}", $activity->ACTIVITY_CUSTOMERCARDID . ' ,', $sms_body);
            $sms_body = str_replace("{cust_email}", $activity->ACTIVITY_CONTACTEMAIL . ' ,', $sms_body);
            $sms_body = str_replace("{customfield}", $html_customfield . ' ,', $sms_body);


            $sms_num = $sms->SMS_TO;
            $sms_num = str_replace("{cust_tel}", $activity->ACTIVITY_CONTACTNUMBER, $sms_num);
            $sms_num = mobile_format($sms_num);
            $nums = explode(',', $sms_num);
            //print_r($nums);
            foreach ($nums as $num) {
                $this->user_model->_sendSMS($num, $sms_body, $sms->SMS_SENDER);
            }
        }
    }

    public function send_email($serviceid, $activityid) {
        $service = $this->select_model->getservice_byid($serviceid);
        if ($service->SERVICE_EMAIL_TEMPLATE_ID != null || $service->SERVICE_EMAIL_TEMPLATE_ID != '') {
            $email = $this->select_model->getemail_template_byid($service->SERVICE_EMAIL_TEMPLATE_ID);


            $activity = $this->select_model->getcustomer_activity_byid($activityid);


            //print_r($activity);
            $html_customfield = '';
            $customfield = explode(';', rtrim($activity->ACTIVITY_CUSTOMFIELD, ";"));
            foreach ($customfield as $field) {
                $f = explode(',', $field);
                $html_customfield .= $f[1] . " : " . $f[2] . "<br/>";
            }
            $time = date('d/m/Y H:i:s');
            $complete_msg = read_clob($email->EMAIL_BODY);
            $complete_msg = str_replace("{cust_name}", $activity->ACTIVITY_CONTACTNAME, $complete_msg);
            $complete_msg = str_replace("{cust_tel}", $activity->ACTIVITY_CONTACTNUMBER, $complete_msg);
            $complete_msg = str_replace("{due_date}", $activity->ACTIVITY_DUEDATE, $complete_msg);
            $complete_msg = str_replace("{cust_contactinfo}", $activity->ACTIVITY_NOTE, $complete_msg);
            $complete_msg = str_replace("{datenow}", $time, $complete_msg);
            $complete_msg = str_replace("{truecard_no}", $activity->ACTIVITY_CUSTOMERCARDID, $complete_msg);
            $complete_msg = str_replace("{cust_email}", $activity->ACTIVITY_CONTACTEMAIL, $complete_msg);
            $complete_msg = str_replace("{customfield}", $html_customfield, $complete_msg);


            $complete_subject = $email->EMAIL_SUBJECT;
            $complete_subject = str_replace("{cust_name}", $activity->ACTIVITY_CONTACTNAME, $complete_subject);
            $complete_subject = str_replace("{cust_tel}", $activity->ACTIVITY_CONTACTNUMBER, $complete_subject);
            $complete_subject = str_replace("{due_date}", $activity->ACTIVITY_DUEDATE, $complete_subject);
            $complete_subject = str_replace("{cust_contactinfo}", $activity->ACTIVITY_NOTE, $complete_subject);
            $complete_subject = str_replace("{datenow}", $time, $complete_subject);
            $complete_subject = str_replace("{truecard_no}", $activity->ACTIVITY_CUSTOMERCARDID, $complete_subject);
            $complete_subject = str_replace("{cust_email}", $activity->ACTIVITY_CONTACTEMAIL, $complete_subject);
            $complete_subject = str_replace("{customfield}", $html_customfield, $complete_subject);

            $data['subject'] = $complete_subject;
            $data['msg'] = $complete_msg;


            $data['email'] = explode(',', read_clob($email->EMAIL_TO));
            $data['cc'] = explode(',', read_clob($email->EMAIL_CC));

            //print_r($complete_msg);
            //config
            $config['protocol'] = 'esmtp';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = FALSE;
            $config['mailtype'] = 'html';
            $config['smtp_host'] = 'appsmtp1.true.th';
            $config['smtp_port'] = '25';
            //$config['smtp_user'] = '';
            //$config['smtp_pass'] = '';
            $this->email->initialize($config);
            //config
            $this->email->from('www.trueyou.co.th', 'TrueYou Personal Assistant');
            $this->email->to($data['email']); //ส่งถึงใคร
            $this->email->cc($data['cc']);
            $this->email->subject($data['subject']); //หัวข้อของอีเมล
            $this->email->message($data['msg']); //เนื้อหาของอีเมล
            $this->email->send();
            //echo $this->email->print_debugger();
        }
    }

}
