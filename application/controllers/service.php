<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
    }

    function __destruct() {
        parent::__destruct();
    }

    function getJsondata($url) {
        header('Content-type: application/json');
        $Data = json_decode(file_get_contents($url), true);
        return $Data;
    }

    function getJsondatafromString($contents) {
        header('Content-type: application/json');
        $Data = json_decode($contents, true);
        return $Data;
    }

    public function index() {
        
    }

    public function load_dealer_list() {
        $result = $this->select_model->get_dealer_list();
        $i = 1;
        $html = '';
        foreach ($result as $row) {

            $html .= '<tr>';
            $html .= '<td>' . $row->Dealer_ID . '</td>';
            $html .= '<td>' . $row->AREA_NAME . '</td>';
            $html .= '<td>' . $row->Dealer_Name . '<br>';
            $html .= '<div class = "tools"><span class = "edit"><a href = "javascript:;" onclick="editdata(' . $row->Dealer_ID . ');">Edit</a> | </span><span class = "delete"><a class = "delete-tag" href = "javascript:;" onclick="removedata(' . $row->Dealer_ID . ');">Delete</a></div></td>';

            $html .= '<td>' . $row->Dealer_Address . '</td>';
            $html .= '<td>' . $row->Dealer_Tel . '</td>';
            $html .= '<td>' . $row->Dealer_URL . '</td>';
            $html .= '<td>' . $row->Dealer_Agent . '</td>';
            $html .= '<td>' . $row->Create_Date . '</td>';
            $html .= '<td>' . $row->Update_Date . '</td>';

            $html .= '</tr>';
            $i++;
        }
        echo $html;
    }

    public function getactivity_byid() {
        $id = $this->input->post('id');
        $cardid = $this->input->get('cardid');
        $data['result'] = $this->select_model->getcustomer_activity_byid($id);
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function getactivity() {
        $cardid = $this->input->post('cardid');
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $result = $this->select_model->getcustomer_activity($cardid, $offset, $limit);

        $html = '';
        $i = $offset + 1;
        if (count($result) > 0) {
            foreach ($result as $each) {
                $updatedate = $each->ACTIVITY_UPDATEDATE == null ? '-' : $each->ACTIVITY_UPDATEDATE;
                $updateuser = $each->UPDATEUSER_FULLNAME == '' ? '-' : $each->UPDATEUSER_FULLNAME;
                $html .= '<tr>';
                $html .= '<td>' . $i . '</td>';

                $html .= '<td><a href="javascript:;" onclick="open_activity_detail(' . $each->ACTIVITY_ID . ');">แก้ไข</span></a></td>';
                if ($each->JOBSTATUS_ID != 1 && $each->JOBSTATUS_ID != 5 && $each->JOBSTATUS_ID != 6) {
                    $html .= '<td style="color:green;">' . $each->JOBSTATUS_NAME . '</td>';
                } else {
                    $html .= '<td style="color:#C4C4C4;">' . $each->JOBSTATUS_NAME . '</td>';
                }
                $html .= '<td>' . $each->SERVICE_NAME . '</td>';
                $html .= '<td>' . read_clob($each->ACTIVITY_NOTE) . '</td>';
                $html .= '<td><a href="' . base_url() . 'user_data/userdetail?userid=' . $each->CREATEUSER_ID . '" style="color: #5D7CCC;text-decoration: underline;">' . $each->CREATEUSER_FULLNAME . '</a></td>';
                $html .= '<td>' . $each->ACTIVITY_CREATEDATE . '</td>';
                $html .= '<td>' . $each->ACTIVITY_DUEDATE . '</td>';
                $html .= '<td>' . $updateuser . '</td>';
                $html .= '<td>' . $updatedate . '</td>';
                $html .= '</tr>';
                $i++;
            }
        }
        echo $html;
    }

    public function getarticle_byid() {
        $id = $this->input->post('id');
        $data['result'] = $this->select_model->getarticle_byid($id);

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function export_jobs() {
        $user = $this->user_model->get_account_cookie();


        $user_groupid = $user['user_groupid'];
        $user_permissionid = $user['user_permissionid'];
        $isreviewer = $user['isreviewer'];


        $status = $this->input->get('status');
        $servicetype = $this->input->get('servicetype') == '' ? null : $this->input->get('servicetype');
        $userid = $this->input->get('userid');
        $format = $this->input->get('format');
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        switch ($status) {
            case 0:
                $result = $this->select_model->getjobexport_allstatus($servicetype, $user_groupid, $isreviewer, $offset, $limit, $userid, $from, $to);
                break;
            case 9999:
                $result = $this->select_model->getjobexport_overdue($servicetype, $user_groupid, $isreviewer, $offset, $limit, $userid, $from, $to);
                break;
            default :
                $result = $this->select_model->getjobexport_bystatus($status, $servicetype, $user_groupid, $isreviewer, $offset, $limit, $userid, $from, $to);
                break;
        }
        $this->load->helper('date');
        $time = date('Ymd');
        switch ($format) {
            case 'XLS':
                $filename = 'jobstatusreport_' . $time . '.xls';
                break;
            case 'CSV':
                $filename = 'jobstatusreport_' . $time . '.csv';
                break;
            default :
                $filename = 'jobstatusreport_' . $time . '.csv';
                break;
        }


        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        //header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        header("Content-Disposition: attachment;filename={$filename}");
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        //print_r($result);
        echo query_to_csv($result, $filename);
    }

    public function getcustomf_byid() {
        $id = $this->input->post('id');
        $data['result'] = $this->select_model->getcustomfield_byid($id);

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function remove_group($id) {
        if ($this->delete_model->delete_group($id)) {
            redirect(base_url() . 'setting/create_group');
        }
    }

    public function remove_user($id) {
        if ($this->delete_model->delete_user($id)) {
            redirect(base_url() . 'setting/create_user');
        }
    }

    public function remove_permission($id) {
        if ($this->delete_model->delete_permission($id)) {
            redirect(base_url() . 'setting/create_permission');
        }
    }

    public function getcustomer() {
        $response = new stdClass();
        $page = $this->input->get('page'); // get the requested page
        $limit = 10; // get how many rows we want to have into the grid
        $sidx = $this->input->get('sidx'); // get index row - i.e. user click to sort
        $sort = $this->input->get('sort'); // get the direction
        $searchTerm = $this->input->get('searchTerm');
        if (!$sidx)
            $sidx = 1;
        if ($searchTerm == "") {
            $searchTerm = "%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }


        $count = $this->select_model->getcustomer_search_count($searchTerm)->ROWCOUNT;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }




        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($total_pages != 0) {
            $result = $this->select_model->getcustomer_search_list($searchTerm, $sidx, $sort, $start + 1, $limit + $start);
        } else {
            $result = $this->select_model->getcustomer_search_list($searchTerm, $sidx, $sort, 0, 0);
        }

        $response->page = $page;
        $response->total = $total_pages;
        $response->records = count($result);


        $i = 0;
        foreach ($result as $each) {
            $response->rows[$i]['CUSTOMER_THAIID'] = $each->THAIID;
            $response->rows[$i]['CUSTOMER_TRUECARDID'] = $each->CARDID;
            $response->rows[$i]['CUSTOMER_NAME'] = $each->CARDNAME;
            $response->rows[$i]['CARDTYPE_NAME'] = $each->CARDTYPE_NAME;
            $response->rows[$i]['CARDTYPE_EXPIRED'] = $each->ENDDATE;
            $response->rows[$i]['STATUS'] = $each->STATUS_DESCRIPTION;
            $i++;
        }

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function getcustomer_serch_count() {
        $count = $this->select_model->getprivilege_data_count('%ชา%');
        print_r($count);
    }

    public function getprivilege_data() {
        $response = new stdClass();
        $this->load->helper('text');
        $page = $this->input->get('page'); // get the requested page
        $limit = 10; // get how many rows we want to have into the grid
        $sidx = $this->input->get('sidx'); // get index row - i.e. user click to sort
        $sort = $this->input->get('sort'); // get the direction
        $searchTerm = $this->input->get('searchTerm');
        if (!$sidx)
            $sidx = 1;
        if ($searchTerm == "") {
            $searchTerm = "%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }


        $count = $this->select_model->getprivilege_data_count($searchTerm)->ROWCOUNT;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }


        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($total_pages != 0) {
            $result = $this->select_model->getprivilege_data($searchTerm, $sidx, $sort, $start + 1, $limit + $start);
        } else {
            $result = $this->select_model->getprivilege_data($searchTerm, $sidx, $sort, 0, 0);
        }

        $response->page = $page;
        $response->total = $total_pages;
        $response->records = count($result);


        $i = 0;
        foreach ($result as $each) {
            $response->rows[$i]['title'] = $each->STITLE;
            $response->rows[$i]['tel'] = $each->TEL;
            $response->rows[$i]['address'] = word_limiter($each->ADDRESS, 5);
            $i++;
        }

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function getcustomer_activity_byid() {
        
    }

    public function getjob_bystatus() {
        $user = $this->user_model->get_account_cookie();


        $user_groupid = $user['user_groupid'];
        $user_permissionid = $user['user_permissionid'];
        $isreviewer = $user['isreviewer'];


        $status = $this->input->post('status');
        $servicetype = $this->input->post('servicetype') == '' ? null : $this->input->post('servicetype');
        $offset = $this->input->post('offset') == '' ? null : $this->input->post('offset');
        $limit = $this->input->post('limit') == '' ? null : $this->input->post('limit') + $offset;
        $userid = $this->input->post('userid');
        switch ($status) {
            case 0:
                $result = $this->select_model->getjob_allstatus($servicetype, $user_groupid, $isreviewer, $offset, $limit, $userid);
                break;
            case 9999:
                $result = $this->select_model->getjob_overdue($servicetype, $user_groupid, $isreviewer, $offset, $limit, $userid);
                break;
            default :
                $result = $this->select_model->getjob_bystatus($status, $servicetype, $user_groupid, $isreviewer, $offset, $limit, $userid);
                break;
        }
        $html = '';
        $i = $offset + 1;
        if (count($result) > 0) {
            foreach ($result as $each) {
                $updatedate = $each->ACTIVITY_UPDATEDATE == null ? '-' : $each->ACTIVITY_UPDATEDATE;
                $html .= '<tr>';
                $html .= ' <td>' . $i . '</td>';

                $html .= '<td><a href="javascript:;" onclick="open_activity_detail(' . $each->ACTIVITY_ID . ')">แก้ไข</span></a></td>';

                if ($each->JOBSTATUS_ID != 1 && $each->JOBSTATUS_ID != 5 && $each->JOBSTATUS_ID != 6) {
                    $html .= '<td style="color:green;">' . $each->JOBSTATUS_NAME . '</td>';
                } else {
                    $html .= '<td style="color:#C4C4C4;">' . $each->JOBSTATUS_NAME . '</td>';
                }
                $html .= '<td>' . $each->ACTIVITY_DUEDATE . '</td>';
                $html .= '<td>' . $each->SERVICE_NAME . '</td>';
                $html .= '<td>' . $each->ACTIVITY_NOTE . '</td>';
                $html .= '<td><a href="' . base_url() . 'index.php/customer_service/index?cardid=' . $each->CARDID . '" style="color: #5D7CCC;text-decoration: underline;">' . $each->CARDNAME . '</a></td>';
                $html .= '<td><a href="user_data/userdetail?userid=' . $each->USER_ID . '" style="color: #5D7CCC;text-decoration: underline;">' . $each->USER_FULLNAME . '</a></td>';
                $html .= '<td><a href="user_data/agentgroup?groupid=' . $each->USERGROUP_ID . '" style="color: #5D7CCC;text-decoration: underline;">' . $each->USERGROUP_NAME . '</a></td>';
                $html .= '<td>' . $each->ACTIVITY_CREATEDATE . '</td>';
                $html .= '<td>' . $updatedate . '</td>';
                $html .= '</tr>';
                $i++;
            }
        }
        echo $html;
    }

    public function getnotification() {
        $user = $this->user_model->get_account_cookie();


        $user_groupid = $user['user_groupid'];
        $user_permissionid = $user['user_permissionid'];
        $isreviewer = $user['isreviewer'];

        $data['result'] = count($this->select_model->getjob_overdue(null, $user_groupid, $isreviewer, 0, 9999));
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function repair_customercard() {
        $user = $this->select_model->get_geterror_card();
        if ($user != null) {
            foreach ($user as $each) {
                $cardinfo = $this->user_model->_get_card_info(ACCESSTOKEN, $each->THAIID);
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
                        , 'ID' => $each->ID
                        , 'CARDID' => $cardinfo['TrueCardNr']
                        , 'CARDTYPE' => $cardinfo['CardType'] == 'BLACK' ? 2 : 1
                        , 'STATUS' => 'A'
                        , 'LAST_UPDATE_BY' => 'PA_SYSTEM');


                    if ($this->update_model->update_truecardcust($input, $input_enddate)) {
                        
                    }
                } elseif ($cardinfo['ErrorCode'] == 709) {
                    $input_enddate = $cardinfo['CardExpired'];
                    $input = array('CARDNAME' => '-'
                        , 'ID' => $each->ID
                        , 'STATUS' => 'C'
                        , 'LAST_UPDATE_BY' => 'PA_SYSTEM');
                    if ($this->update_model->update_truecardcust($input, $input_enddate)) {
                        
                    }
                }
            }
        }
        $data['result'] = $this->select_model->get_countgeterror_card()->RCOUNT;
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function getjobreport() {

        $data['y_overdue'] = $this->select_model->getjobreport_overdue(2)->COUNT;
        $data['y_close'] = $this->select_model->getjobreport_bystatus(1, 2)->COUNT;
        $data['y_callback'] = $this->select_model->getjobreport_bystatus(2, 2)->COUNT;
        $data['y_waiting'] = $this->select_model->getjobreport_bystatus(3, 2)->COUNT;
        $data['y_open'] = $this->select_model->getjobreport_bystatus(4, 2)->COUNT;
        $data['y_cancel'] = $this->select_model->getjobreport_bystatus(5, 2)->COUNT;


        $data['overdue'] = $this->select_model->getjobreport_overdue(1)->COUNT;
        $data['close'] = $this->select_model->getjobreport_bystatus(1, 1)->COUNT;
        $data['callback'] = $this->select_model->getjobreport_bystatus(2, 1)->COUNT;
        $data['waiting'] = $this->select_model->getjobreport_bystatus(3, 1)->COUNT;
        $data['open'] = $this->select_model->getjobreport_bystatus(4, 1)->COUNT;
        $data['cancel'] = $this->select_model->getjobreport_bystatus(5, 1)->COUNT;

        $data['monthly_report'] = $this->select_model->getjobreport_bymonthly();

        $data['createjob_report'] = $this->select_model->getcreate_act_eport_bymonthly();

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function getcustomer_data() {
        include_once APPPATH . 'libraries/adLDAP.php';
        $input_name = $this->input->post('input_name');
        $username = 'U-SVC-Concierge';
        $password = 'Fd483#ntPa';
        try {
            $adldap = new adLDAP(array('admin_username' => $username, 'admin_password' => $password));
        } catch (adLDAPException $e) {
            $data['message'] = "Username OR Password is incorrect";
            $data['result'] = false;
            $rs = false;
        }
        $rs = true;
        if ($rs) {
            if ($adldap->authenticate($username, $password)) {
                $result = $adldap->user()->info($input_name, array('*'));
                $data['result'] = array('title' => $result[0]['title'][0], 'empid' => $result[0]['description'][0], 'fullname' => $result[0]['cn'][0], 'email' => $result[0]['mail'][0]);
            } else {
                $data['result'] = false;
            }
        }




        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function getcustomer_product() {
        $thaiid = $this->input->post('thaiid');
        $result = $this->user_model->_get_prod_info('175|1.654132a3b1bdc765b05555__3600.1420538197-5076893|a2b7e1b3f0d22b387217845d4df', $thaiid);
// print_r($result['Products']);
        $html = "";

        $i = 1;
        foreach ($result['Products'] as $each) {
            $html .= "<tr>";
            switch ($each['UsageLabel']) {
                case 'TRUEMOVEH':
                    $html .= "<td>$i</td><td><b>" . $each['UsageLabel'] . "</b></td>" . "<td>" . $each['ProductID'] . "</td>";
                    break;
                case 'TRUE':
                    $html .= "<td>$i</td><td><b>" . $each['UsageLabel'] . "</b></td>" . "<td>" . $each['ProductID'] . "</td>";
                    break;
                case 'INTERNET':
                    $html .= "<td>$i</td><td><b>" . $each['UsageLabel'] . "</b></td>" . "<td>" . $each['ProductID'] . "</td>";
                    break;
                case 'TVS':
                    $html .= "<td>$i</td><td><b>" . $each['UsageLabel'] . "</b></td>" . "<td>" . $each['ProductID'] . "</td>";
                    break;
            }
            $html .= "</tr>";
            $i++;
        }
        echo $html;
    }

    public function edit_service() {
        $data['user'] = $this->user_model->get_account_cookie();
        $data['result'] = false;
        $activity_id = $this->input->post('activity_id');
        $input_jobstatus = $this->input->post('input_jobstatus');
        $input_duedate = $this->input->post('input_duedate');
        $input_duetime = $this->input->post('input_duetime');
        $input_note = $this->input->post('input_note');
        $input_howclosejob = $this->input->post('input_howclosejob');
        $input = array('ACTIVITY_ID' => $activity_id
            , 'ACTIVITY_JOBSTATUS' => $input_jobstatus
            , 'ACTIVITY_NOTE' => $input_note
            , 'ACTIVITY_HOWTOCLOSEJOB' => $input_howclosejob
            , 'ACTIVITY_UPDATEUSERID' => $data['user']['user_id']);
        $services = $this->select_model->getcustomer_activity_byid($activity_id);
        $data['cardid'] = $this->select_model->getcustomer_activity_byid($activity_id)->ACTIVITY_CUSTOMERCARDID;
        if ($this->update_model->update_activity($input, $input_duedate . ' ' . $input_duetime)) {
            //$this->send_email($services->SERVICE_ID, $activity_id);
            switch ($input_howclosejob) {
                case 'NONE':
                    break;
                case 'SMS':
                    if ($input_jobstatus == 1 && $input_howclosejob == 'SMS') {
                        $this->send_sms($services->SERVICE_ID, 'close', $activity_id);
                    }
                    break;
                case 'CALLBACK':
                    break;
            }
            $data['result'] = true;
        }
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function testd() {
        $newDate = explode("/", '23/12/2014');
        $newDate = $newDate[1] . '/' . $newDate[0] . '/' . $newDate[2];
        $shortduedate = date("m/Y", strtotime($newDate));
        echo $shortduedate;
    }

    public function apply_service() {
        $cardid = $this->input->get('cardid');
        $service_id = $this->input->get('serviceid');
        $data['user'] = $this->user_model->get_account_cookie();
        $data['customfields'] = $this->select_model->getcustomfield_byserviceid($service_id);
        $data['result'] = true;
        $customfield = "";
        if ($data['customfields'] != "") {
            foreach ($data['customfields'] as $each) {
                $customfield .= "$each->CUSTOM_FIELD_LABEL" . ",$each->CUSTOM_FIELD_LABEL" . "," . $this->input->post("$each->CUSTOM_FIELD_NAME") . ";";
            }
        }
        $data["activity_customfield"] = $customfield;
        $input_jobstatus = $this->input->post('input_jobstatus');
        $input_note = $this->input->post('input_note');
        $input_duedate = $this->input->post('input_duedate');
        $input_duetime = $this->input->post('input_duetime');
        $input_howclosejob = $this->input->post('input_howclosejob');
        $input_contactname = $this->input->post('input_contactname');
        $input_contactnumber = $this->input->post('input_contactnumber');
        $input_contactemail = $this->input->post('input_contactemail');
        $input_note2 = $this->input->post('input_note2');



        $newDate = explode("/", $input_duedate);
        $newDate = $newDate[1] . '/' . $newDate[0] . '/' . $newDate[2];
        $shortduedate = date("m/Y", strtotime($newDate));
        $service = $this->select_model->getservice_byid($service_id);


        $totalpoint_service = $this->select_model->gettotalpoint_service($service_id, $service->SERVICE_TYPE, '01/' . $shortduedate)->DEDUCTPOINT;

        if ($service->SERVICE_POINTQUOTA != 0) {
            $isunlimit = false;
            $lasttotalpoint_service = $service->SERVICE_POINTQUOTA - $totalpoint_service; // point รวมของ service
        } else {
            $lasttotalpoint_service = 999999999999;
            $isunlimit = true;
        }


        $deductpoint = $this->select_model->gettotalpoint_activity($cardid, $service_id, $service->SERVICE_TYPE, '01/' . $shortduedate)->DEDUCTPOINT;
        $totalpoint = $service->SERVICE_POINTHOLDER - $deductpoint;

        if ($lasttotalpoint_service <= 0 && $isunlimit == false) {
            $data['result'] = false;
            $data['msg'] = 'สิทธ์ของบริการนี้ภายใน เดือน/ปี ของช่วงวันที่ ' . $input_duedate . ' ครบกำหนดแล้ว';
        } else {
            if ($totalpoint <= 0) {
                $data['result'] = false;
                $data['msg'] = 'ลุกค้าท่านนี้ได้ใช้สิทธ์ของ เดือน/ปี ของช่วงวันที่ ' . $input_duedate . ' ครบกำหนดแล้ว';
            } else {
                if ($input_jobstatus != 6) {
                    $data['input'] = array('ACTIVITY_CUSTOMERCARDID' => $cardid
                        , 'ACTIVITY_USERID' => $data['user']['user_id']
                        , 'ACTIVITY_SERVICEID' => $service_id
                        , 'ACTIVITY_JOBSTATUS' => $input_jobstatus
                        , 'ACTIVITY_NOTE' => $input_note
                        , 'ACTIVITY_CONTACTNAME' => $input_contactname
                        , 'ACTIVITY_HOWTOCLOSEJOB' => $input_howclosejob
                        , 'ACTIVITY_CONTACTEMAIL' => $input_contactemail
                        , 'ACTIVITY_CONTACTNUMBER' => $input_contactnumber
                        , 'ACTIVITY_CUSTOMFIELD' => $data["activity_customfield"]);
                    $rsid = $this->insert_model->save_activity($data['input'], $input_duedate . ' ' . $input_duetime);
                } else {
                    $data['input'] = array('ACTIVITY_CUSTOMERCARDID' => $cardid
                        , 'ACTIVITY_USERID' => $data['user']['user_id']
                        , 'ACTIVITY_SERVICEID' => $service_id
                        , 'ACTIVITY_JOBSTATUS' => $input_jobstatus
                        , 'ACTIVITY_NOTE' => $input_note2
                        , 'ACTIVITY_CONTACTNAME' => $input_contactname
                        , 'ACTIVITY_HOWTOCLOSEJOB' => $input_howclosejob
                        , 'ACTIVITY_CONTACTEMAIL' => $input_contactemail
                        , 'ACTIVITY_CONTACTNUMBER' => $input_contactnumber
                        , 'ACTIVITY_CUSTOMFIELD' => $data["activity_customfield"]);
                    $rsid = $this->insert_model->save_activity($data['input']);
                }



                if ($rsid != false) {
                    sleep(5);
                    if ($input_jobstatus != 5 && $input_jobstatus != 6) {
                        $this->send_sms($service_id, 'open', $rsid);
                        $this->send_email($service_id, $rsid);
                    }
                    switch ($input_howclosejob) {
                        case 'NONE':
                            break;
                        case 'SMS':
                            if ($input_jobstatus == 1) {
                                $this->send_sms($service_id, 'close', $rsid);
                            }
                            break;
                        case 'CALLBACK':
                            break;
                    }
                }
            }
        }

        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function send_sms($id, $type, $activityid) {
        //$this->savelog(0, 'send_sms_getactivity_id', $activityid);
        $service = $this->select_model->getservice_byid($id);
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
            //$this->savelog(0, 'getactivitycustomfield', $activity->ACTIVITY_CUSTOMFIELD);
            $html_customfield = '';
            $customfield = explode(';', rtrim($activity->ACTIVITY_CUSTOMFIELD, ";"));
            foreach ($customfield as $field) {
                $f = explode(',', $field);
                $html_customfield .= $f[1] . "  " . $f[2] . " ";
            }

            $time = date('d/m/Y H:i:s');
            $sms_body = $sms->SMS_DESC;
            $sms_body = str_replace("{cust_name}", $activity->ACTIVITY_CONTACTNAME . '  ', $sms_body);
            $sms_body = str_replace("{cust_tel}", $activity->ACTIVITY_CONTACTNUMBER . '  ', $sms_body);
            $sms_body = str_replace("{due_date}", $activity->ACTIVITY_DUEDATE . '  ', $sms_body);
            $sms_body = str_replace("{cust_contactinfo}", $activity->ACTIVITY_NOTE . '  ', $sms_body);
            $sms_body = str_replace("{datenow}", $time . ' ,', $sms_body);
            $sms_body = str_replace("{truecard_no}", $activity->ACTIVITY_CUSTOMERCARDID . '  ', $sms_body);
            $sms_body = str_replace("{cust_email}", $activity->ACTIVITY_CONTACTEMAIL . '  ', $sms_body);
            $sms_body = str_replace("{customfield}", $html_customfield . '  ', $sms_body);


            $sms_num = $sms->SMS_TO;
            $sms_num = str_replace("{cust_tel}", $activity->ACTIVITY_CONTACTNUMBER, $sms_num);
            $sms_num = mobile_format($sms_num);
            $nums = explode(',', $sms_num);
//print_r($nums);
            foreach ($nums as $num) {
                $smsrs = $this->user_model->_sendSMS($num, rtrim($sms_body, ','), $sms->SMS_SENDER);
                // $this->savelog(0, 'sms', $smsrs);
            }
        }
    }

    public function send_email($serviceid, $activityid) {
        $service = $this->select_model->getservice_byid($serviceid);

        if ($service->SERVICE_EMAIL_TEMPLATE_ID != null || $service->SERVICE_EMAIL_TEMPLATE_ID != '') {
            $email = $this->select_model->getemail_template_byid($service->SERVICE_EMAIL_TEMPLATE_ID);


            $activity = $this->select_model->getcustomer_activity_byid($activityid);



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

//print_r($data);
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
            //$this->savelog(0, 'emaildebug', $this->email->print_debugger());
        }
    }

    public function savelog($errcode, $type, $msg) {
        $log = array('LOG_CODE' => $errcode
            , 'LOG_MESSAGE' => $msg
            , 'LOG_TYPE' => $type
            , 'LOG_IPADDRESS' => $_SERVER['SERVER_ADDR']);
        $this->insert_model->insert_log($log);
    }

    public function getcardinfo() {
        $thaiid = '1200900063315';
        $result = $this->user_model->_get_card_info(ACCESSTOKEN, $thaiid);
        print_r($result);
        $html = "";

        echo $html;
    }

}
