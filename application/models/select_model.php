<?php

class select_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_geterror_card() {
        $query = $this->db->query("select * from tcsappo.pa_truecard_customer a  where a.Last_Update_By = 'PA_SYSTEM'  AND a.CARDNAME IS NULL");
        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function get_countgeterror_card() {
        $query = $this->db->query("select count(*) as RCOUNT from tcsappo.pa_truecard_customer a  where a.Last_Update_By = 'PA_SYSTEM'  AND a.CARDNAME IS NULL");
        $this->db->close();
        return $query->row();
    }

    function get_search_privilege($prm = null, $page, $limit, $prefix) {

        $strlimit = "";
        if ($page != null) {
            $strlimit = " AND mynum BETWEEN $page AND $limit ";
        }
        if ($prefix == 'true') {
            $query = $this->db->query("SELECT * FROM("
                    . " SELECT   rownum mynum,a.* FROM tcsappo.pa_privilege_data a WHERE  a.title like '%" . $prm . "%' ) WHERE 1 = 1  $strlimit  ORDER BY CAST(title AS varchar(100)) asc ");
        } else {
            $query = $this->db->query("SELECT * FROM("
                    . " SELECT   rownum mynum,a.* FROM tcsappo.pa_privilege_data a WHERE  a.title like '%" . $prm . "%' OR a.address like '%" . $prm . "%' OR a.tel like '%" . $prm . "%'  "
                    . " OR a.strdescription like '%" . $prm . "%') WHERE 1 = 1  $strlimit  ORDER BY CAST(title AS varchar(100)) asc ");
        }
        $this->db->close();
        if ($query->num_rows > 0) {

            return $query->result();
        } else {
            return null;
        }
    }

    function get_search_count($prm = null, $page, $limit, $prefix) {

        $strlimit = "";
        if ($page != null) {
            $strlimit = " AND ROWNUM BETWEEN $page AND $limit ";
        }
        if ($prefix == 'true') {
            $query = $this->db->query("SELECT count(*) as count FROM("
                    . " SELECT a.* FROM tcsappo.pa_privilege_data a WHERE  a.title like '%" . $prm . "%' ) WHERE 1 = 1  $strlimit  ORDER BY CAST(title AS varchar(100)) asc ");
        } else {
            $query = $this->db->query("SELECT count(*) as count FROM("
                    . " SELECT a.* FROM tcsappo.pa_privilege_data a WHERE  a.title like '%" . $prm . "%' OR a.address like '%" . $prm . "%' OR a.tel like '%" . $prm . "%'  "
                    . " OR a.strdescription like '%" . $prm . "%') WHERE 1 = 1  $strlimit  ORDER BY CAST(title AS varchar(100)) asc ");
        }
        $this->db->close();
        return $query->row();
    }

    function getcustomer_search_list($prm = null, $sidx, $sort, $page, $limit) {

        $strlimit = "";
        $strorderby = "";
        $strlimit = " WHERE RNUM BETWEEN $page AND $limit";
        $strorderby = "  ORDER BY c.status_name, $sidx $sort";

        $query = $this->db->query("SELECT  * FROM(SELECT   ROWNUM as RNUM,THAIID,CARDID,CARDNAME,CARDTYPE_NAME,ENDDATE,STATUS_DESCRIPTION  FROM tcsappo.pa_truecard_customer a "
                . " INNER JOIN tcsappo.pa_cardtype b"
                . " ON a.cardtype = b.cardtype_id"
                . " INNER JOIN tcsappo.pa_truecard_status c"
                . " ON a.status = c.status_name"
                . " WHERE "
                . " a.cardname like '" . $prm . "'"
                . " OR a.cardid like '" . $prm . "'"
                . " OR a.thaiid like '" . $prm . "'"
                . ")"
                . $strlimit);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
        $this->db->close();
    }

    function getcustomer_search_count($prm = null) {
        $query = $this->db->query("SELECT   count(*) as rowcount FROM tcsappo.pa_truecard_customer a "
                . " INNER JOIN tcsappo.pa_cardtype b"
                . " ON a.cardtype = b.cardtype_id"
                . " INNER JOIN tcsappo.pa_truecard_status c"
                . " ON a.status = c.status_name"
                . " WHERE "
                . " a.cardname like '" . $prm . "'"
                . " OR a.cardid like '" . $prm . "'"
                . " OR a.thaiid like '" . $prm . "'");
        $this->db->close();
        return $query->row();
    }

    function getprivilege_data_count($prm = null) {
        $query = $this->db->query("SELECT  count(*) as ROWCOUNT FROM tcsappo.pa_privilege_data a "
                . " WHERE "
                . " a.title like '" . $prm . "'"
                . " OR a.address  like '" . $prm . "'"
                . " OR a.strdescription like '" . $prm . "'");
        $this->db->close();
        return $query->row();
    }

    function getprivilege_data($prm, $sidx, $sort, $page, $limit) {
        $strlimit = "";
        $strorderby = "";
        $strlimit = " WHERE RNUM between  $page AND $limit";
        $strorderby = "  ORDER BY $sidx $sort";



        $query = $this->db->query("SELECT  * FROM(SELECT  ROWNUM as RNUM,DBMS_LOB.substr(TITLE,5000) as STITLE,TEL,ADDRESS  FROM tcsappo.pa_privilege_data a "
                . " WHERE "
                . " a.title like '" . $prm . "'"
                . " OR a.address  like '" . $prm . "'"
                . " OR a.strdescription like '" . $prm . "')"
                . $strlimit);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getcustomer_search($prm = null) {
//. " OR concat_ws(' - ',a.customer_thaiid,concat_ws(' ',a.customer_firstname,a.customer_lastname)) like '%" . $prm . "%'"
        $query = $this->db->query("SELECT * FROM(SELECT  * FROM  tcsappo.pa_truecard_customer a "
                . " INNER JOIN tcsappo.pa_cardtype b"
                . " ON a.cardtype = b.cardtype_id"
                . " INNER JOIN tcsappo.pa_truecard_status c"
                . " ON a.status = c.status_name"
                . " WHERE "
                . " a.cardname like '" . $prm . "'"
                . " OR  concat(concat(a.cardid,' - '),a.cardname) like '%" . $prm . "%'"
                . " OR a.cardid like '" . $prm . "'"
                . " OR a.thaiid like '" . $prm . "')
                   WHERE rownum between 0 and 1"
                . " ORDER BY status_name");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getcustomerlist_byid($cardid) {
        $query = $this->db->query("SELECT  * FROM tcsappo.pa_truecard_customer a "
                . " INNER JOIN tcsappo.pa_cardtype b"
                . " ON a.cardtype = b.cardtype_id"
                . " INNER JOIN tcsappo.pa_truecard_status c"
                . " ON a.status = c.status_name"
                . " WHERE "
                . " a.cardid = '" . $cardid . "'"
                . " AND a.status = 'A'"
                . " ORDER BY c.status_name");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getalluser() {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_user a"
                . " INNER JOIN tcsappo.pa_permission b ON a.user_permissionid = b.permission_id"
                . " INNER JOIN tcsappo.pa_usergroup c ON a.user_groupid = c.usergroup_id");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getdbsession($dbuser) {
        $query = $this->db->query('SELECT t.SID AS SID,t.SERIAL# AS SERIAL, t.USERNAME , t.STATUS  , t.SERVER , t.SERVICE_NAME , t.OSUSER ,t.LOGON_TIME, t.MACHINE
   FROM V$SESSION t
   WHERE USERNAME = ' . $dbuser . '
order by logon_time  desc');

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getuser($userid) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_user a"
                . " INNER JOIN tcsappo.pa_permission b ON a.user_permissionid = b.permission_id"
                . " INNER JOIN tcsappo.pa_usergroup c ON a.user_groupid = c.usergroup_id where a.user_id = " . $userid);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getalluserbygroup($groupid) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_user a"
                . " INNER JOIN tcsappo.pa_permission b ON a.user_permissionid = b.permission_id"
                . " INNER JOIN tcsappo.pa_usergroup c ON a.user_groupid = c.usergroup_id where a.user_groupid = " . $groupid);
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
        $this->db->close();
    }

    function getgroup($groupid) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_usergroup where usergroup_id =" . $groupid);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getallgroup() {


        $query = $this->db->query("SELECT * FROM tcsappo.pa_usergroup");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getallpermission() {


        $query = $this->db->query("SELECT * FROM tcsappo.pa_permission");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getcustomer_bycardid($cardid) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_truecard_customer a "
                . " INNER JOIN tcsappo.pa_cardtype b"
                . " ON a.cardtype = b.cardtype_id"
                . " WHERE "
                . " a.cardid = " . $cardid);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getcustomer_activity($prm = null, $offset = 0, $limit = 5) {
        $query = $this->db->query("SELECT * FROM(SELECT ROWNUM as RNUM,activity_id
,jobstatus_id
,jobstatus_name
,service_name
,activity_note
,activity_createdate
,createuser_fullname
,createuser_id
,activity_duedate
,updateuser_fullname
,activity_updatedate FROM(
SELECT  ROWNUM as RNUM,activity_id
,jobstatus_id
,jobstatus_name
,service_name
,activity_note
,to_char(activity_createdate, 'DD/MM/YYYY HH24:MI:SSxFF') as activity_createdate
,to_char(activity_duedate, 'DD/MM/YYYY HH24:MI:SSxFF') as activity_duedate
,to_char(activity_updatedate, 'DD/MM/YYYY HH24:MI:SSxFF') as activity_updatedate
,b.user_fullname as createuser_fullname
, b.user_id as createuser_id
, f.user_fullname as updateuser_fullname 
FROM tcsappo.pa_customer_activity a INNER JOIN tcsappo.pa_user b ON a.activity_userid = b.user_id
 INNER JOIN tcsappo.pa_truecard_customer c ON a.activity_customercardid = c.cardid INNER JOIN tcsappo.pa_jobstatus d ON a.activity_jobstatus = d.jobstatus_id 
 INNER JOIN tcsappo.pa_service e ON a.activity_serviceid = e.service_id LEFT JOIN tcsappo.pa_user f ON a.activity_updateuserid = f.user_id
 INNER JOIN tcsappo.pa_truecard_status g ON c.status = g.status_name
 WHERE c.cardid = '$prm' AND c.status = 'A' ORDER BY a.activity_createdate desc 
 ))WHERE RNUM BETWEEN $offset AND $limit");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getcustomer_activitybyserviceid($serviceid, $prm = null, $offset = 0, $limit = 5) {

        $query = $this->db->query("SELECT * FROM(
SELECT  activity_id
,jobstatus_name
,service_name
,activity_note
,to_char(activity_createdate, 'DD/MM/YYYY HH24:MI:SSxFF') as activity_createdate
,to_char(activity_duedate, 'DD/MM/YYYY HH24:MI:SSxFF') as activity_duedate
,to_char(activity_updatedate, 'DD/MM/YYYY HH24:MI:SSxFF') as activity_updatedate
,b.user_fullname as createuser_fullname
, b.user_id as createuser_id
, f.user_fullname as updateuser_fullname 
FROM tcsappo.pa_customer_activity a INNER JOIN tcsappo.pa_user b ON a.activity_userid = b.user_id
 INNER JOIN tcsappo.pa_truecard_customer c ON a.activity_customercardid = c.cardid INNER JOIN tcsappo.pa_jobstatus d ON a.activity_jobstatus = d.jobstatus_id 
 INNER JOIN tcsappo.pa_service e ON a.activity_serviceid = e.service_id LEFT JOIN tcsappo.pa_user f ON a.activity_updateuserid = f.user_id
 INNER JOIN tcsappo.pa_truecard_status g ON c.status = g.status_name
 WHERE c.cardid = '$prm' AND c.status = 'A'
AND e.service_id =  $serviceid     
ORDER BY a.activity_createdate desc 
 )WHERE ROWNUM BETWEEN $offset AND $limit");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function gettotalpoint_activity($cardid, $serviceid, $period, $months = null) {
        $strperiod = '';
        switch ($period) {
            case 1:
                if ($months != null && $months != '01') {
                    /* $strperiod = "   AND extract(month from to_date(a.activity_duedate, 'dd/mm/yyyy HH24:MI:SS')) = extract(month from  to_date('$months', 'dd/mm/yyyy HH24:MI:SS')) 
                      AND extract(year from to_date(a.activity_duedate, 'dd/mm/yyyy HH24:MI:SS')) = extract(year from  to_date('$months', 'dd/mm/yyyy HH24:MI:SS'))"; */
                    $strperiod = "  AND extract(month from a.activity_duedate) = extract(month from to_date('$months', 'dd/mm/yyyy HH24:MI:SS')) 
 AND extract(year from a.activity_duedate) = extract(year from to_date('$months', 'dd/mm/yyyy HH24:MI:SS'))";
                } else {
                    $strperiod = "  AND extract(month from a.activity_duedate) = extract(month from SYSTIMESTAMP) 
 AND extract(year from a.activity_duedate) = extract(year from SYSTIMESTAMP)";
                }
                break;

            case 2:
                if ($months != null && $months != '01') {
                    $strperiod = "    AND extract(year from a.activity_duedate) = extract(year from to_date('$months', 'dd/mm/yyyy HH24:MI:SS'))";
                } else {
                    $strperiod = "  AND extract(year from a.activity_duedate) = extract(year from SYSTIMESTAMP)";
                }
                break;
        }

        $query = $this->db->query("SELECT count(*) as deductpoint FROM tcsappo.pa_customer_activity a"
                . " WHERE a.activity_customercardid =  " . $cardid
                . " AND a.activity_serviceid = " . $serviceid
                . " AND a.activity_jobstatus != 5 AND a.activity_jobstatus != 6 " . $strperiod);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function gettotalpoint_service($serviceid, $period, $months = null) {

        switch ($period) {
            case 1:
                if ($months != null && $months != '01') {
                    $period = "   AND extract(month from activity_duedate) = extract(month from to_date('$months', 'dd/mm/yyyy HH24:MI:SS')) 
 AND extract(year from activity_duedate) = extract(year from to_date('$months', 'dd/mm/yyyy HH24:MI:SS'))";
                } else {
                    $period = "  AND extract(month from activity_duedate) = extract(month from SYSTIMESTAMP) 
 AND extract(year from activity_duedate) = extract(year from SYSTIMESTAMP)";
                }
                break;

            case 2:
                if ($months != null && $months != '01') {
                    $period = "  AND extract(year from activity_duedate) = extract(year from to_date('$months', 'dd/mm/yyyy HH24:MI:SS'))";
                } else {
                    $period = "  AND extract(year from activity_duedate) = extract(year from SYSTIMESTAMP)";
                }
                break;
        }



        $query = $this->db->query("SELECT count(*) as deductpoint FROM tcsappo.pa_customer_activity a"
                . " WHERE a.activity_serviceid = " . $serviceid
                . " AND a.activity_jobstatus != 5  AND a.activity_jobstatus != 6"
                . $period);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getcustomer_activity_byid($id) {
        $query = $this->db->query("SELECT a.activity_customfield,a.activity_customercardid"
                . ",e.service_id,DBMS_LOB.substr( a.activity_customfield, 10000) as ACTIVITY_CUSTOMFIELD"
                . ",a.activity_jobstatus"
                . ",to_char(activity_duedate, 'DD/MM/YYYY HH24:MI:SSxFF') as activity_duedate"
                . ",DBMS_LOB.substr(activity_note,10000) AS activity_note "
                . ",activity_contactname"
                . ",activity_contactnumber"
                . ",activity_contactemail"
                . ",activity_howtoclosejob"
                . ", f.user_fullname as updateuser_fullname FROM tcsappo.pa_customer_activity a "
                . " INNER JOIN tcsappo.pa_user b"
                . " ON a.activity_userid = b.user_id"
                . " INNER JOIN tcsappo.pa_truecard_customer c"
                . " ON a.activity_customercardid = c.cardid"
                . " INNER JOIN tcsappo.pa_jobstatus d"
                . " ON a.activity_jobstatus = d.jobstatus_id"
                . " INNER JOIN tcsappo.pa_service e"
                . " ON a.activity_serviceid = e.service_id"
                . " LEFT JOIN tcsappo.pa_user f"
                . " ON a.activity_updateuserid = f.user_id"
                . " WHERE "
                . " a.activity_id = '" . $id . "'");


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getservice() {


        $query = $this->db->query("SELECT * FROM tcsappo.pa_service a ");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getemail_template() {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_email_template a ");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getsms_template() {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_sms_template a ");
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
        $this->db->close();
    }

    function getservice_byid($id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_service a where service_id = " . $id);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getarticle_byid($id) {
        $query = $this->db->query("SELECT article_id,service_id,article_title,DBMS_LOB.substr(article_description, 10000) as article_description,article_createdate FROM tcsappo.pa_article a where article_id = " . $id);
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
        $this->db->close();
    }

    function getarticle_byserviceid($id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_article a where service_id = " . $id);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getcustomfield_byserviceid($id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_custom_field a where service_id = $id  order by a.custom_field_createdate asc");


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getcustomfield_byid($id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_custom_field a where custom_field_id = " . $id);
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
        $this->db->close();
    }

    function getemail_template_byid($id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_email_template a where email_id = " . $id);

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getsms_template_byid($id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_sms_template a where sms_id = " . $id);


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getservice_partner(
    $id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_partner a where partner_serviceid = " . $id);


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getjobstatus() {


        $query = $this->db->query("SELECT * FROM tcsappo.pa_jobstatus a ORDER BY jobstatus_priority ASC");


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getjob_bystatus($status, $servicetype = null, $user_groupid, $isreviewer = null, $offset, $limit, $userid = null) {
        $cond = '';
        $cond2 = '';
        $cond3 = '';
        if ($servicetype != null) {
            $cond = " AND f.service_id in ($servicetype)";
        }

        if ($isreviewer != '1') {
            $cond2 = " AND e.usergroup_id = $user_groupid";
        }
        if ($userid != null) {
            $cond3 = " AND     c.user_id  = '$userid'";
        }
        $query = $this->db->query("SELECT * FROM (SELECT ACTIVITY_JOBSTATUS,DBMS_LOB.substr(ACTIVITY_NOTE,5000) as ACTIVITY_NOTE
                ,ROWNUM as RNUM,ACTIVITY_ID,JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE
FROM tcsappo.pa_customer_activity a 
            inner join tcsappo.pa_jobstatus b 
            on a.activity_jobstatus = b.jobstatus_id 
            inner join tcsappo.pa_user c 
            on a.activity_userid = c.user_id
            left join tcsappo.pa_truecard_customer d 
            on a.activity_customercardid = d.cardid
            inner join tcsappo.pa_usergroup e
            on c.user_groupid = e.usergroup_id
            inner join tcsappo.pa_service f
            on a.activity_serviceid = f.service_id
            where b.jobstatus_id = " . $status . $cond . $cond2 . $cond3 . ")
            WHERE RNUM BETWEEN $offset AND $limit
             ORDER BY jobstatus_priority, ACTIVITY_CREATEDATE DESC");


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getjob_allstatus($servicetype = null, $user_groupid, $isreviewer = null, $offset, $limit, $userid = null) {
        $cond = '';
        $cond2 = '';
        $cond3 = '';
        if ($servicetype != null) {
            if ($userid != null) {
                $cond3 = " AND     c.user_id  = '$userid'";
            }$cond = " AND     f.service_id in ($servicetype)";
        }

        if ($isreviewer != '1') {
            $cond2 = " AND e.usergroup_id = $user_groupid";
        }
        if ($userid != null) {
            $cond3 = " AND     c.user_id  = '$userid'";
        }


        $query = $this->db->query("SELECT * FROM (SELECT ROWNUM as RNUM ,DBMS_LOB.substr(ACTIVITY_NOTE,5000) as ACTIVITY_NOTE,ACTIVITY_ID,JOBSTATUS_ID, JOBSTATUS_NAME, SERVICE_NAME, CARDID, CARDNAME, USER_FULLNAME, USER_ID, USERGROUP_ID, USERGROUP_NAME, JOBSTATUS_PRIORITY,
 ACTIVITY_DUEDATE, ACTIVITY_UPDATEDATE, ACTIVITY_CREATEDATE FROM  (SELECT ACTIVITY_NOTE,ACTIVITY_JOBSTATUS,ACTIVITY_ID,JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE
 FROM tcsappo.pa_customer_activity a
                inner join tcsappo.pa_jobstatus b
                on a.activity_jobstatus = b.jobstatus_id
                inner join tcsappo.pa_user c
                on a.activity_userid = c.user_id
                inner join tcsappo.pa_truecard_customer d
                on a.activity_customercardid = d.cardid
                inner join tcsappo.pa_usergroup e
                on c.user_groupid = e.usergroup_id
                inner join tcsappo.pa_service f
                on a.activity_serviceid = f.service_id
                Where 1 = 1 " . $cond . $cond2 . $cond3 . " ORDER BY jobstatus_priority, ACTIVITY_CREATEDATE DESC )
                ) WHERE RNUM BETWEEN $offset AND $limit ");

        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getjob_overdue($servicetype = null, $user_groupid, $isreviewer = null, $offset, $limit, $userid = null) {
        $cond = '';
        $cond2 = '';
        $cond3 = '';

        if ($servicetype != null) {
            $cond = " AND     f.service_id in ($servicetype)";
        }

        if ($isreviewer != '1') {
            $cond2 = " AND e.usergroup_id = $user_groupid";
        }
        if ($userid != null) {
            $cond3 = " AND     c.user_id  = '$userid'";
        }

        $query = $this->db->query("SELECT * FROM (SELECT ACTIVITY_JOBSTATUS,DBMS_LOB.substr(ACTIVITY_NOTE,5000) as ACTIVITY_NOTE,
              ROWNUM as RNUM,ACTIVITY_ID,JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
 ACTIVITY_DUEDATE ,
 ACTIVITY_UPDATEDATE,
 ACTIVITY_CREATEDATE FROM (SELECT ACTIVITY_JOBSTATUS,ACTIVITY_NOTE,
ACTIVITY_ID,JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE 
FROM tcsappo.pa_customer_activity a
                inner join tcsappo.pa_jobstatus b
                on a.activity_jobstatus = b.jobstatus_id
                inner join tcsappo.pa_user c
                on a.activity_userid = c.user_id
                inner join tcsappo.pa_truecard_customer d
                on a.activity_customercardid = d.cardid
                inner join tcsappo.pa_usergroup e
                on c.user_groupid = e.usergroup_id
                inner join tcsappo.pa_service f
                on a.activity_serviceid = f.service_id
                where a.activity_duedate < SYSDATE
                AND b.jobstatus_id not in (1, 5,6)" . $cond . $cond2 . $cond3 . "))
                WHERE RNUM BETWEEN $offset AND $limit ORDER BY   ACTIVITY_CREATEDATE DESC ");
// where a.activity_duedate < SYSDATE - INTERVAL '1' DAY
        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getjobreport_overdue($period) {
        switch ($period) {
            case 1:
                $period = "  AND extract(month from activity_createdate) = extract(month from SYSTIMESTAMP) 
 AND extract(year from activity_createdate) = extract(year from SYSTIMESTAMP)";
                break;

            case 2:
                $period = "  AND extract(year from activity_createdate) = extract(year from SYSTIMESTAMP)";
                break;
        }

        $query = $this->db->query("SELECT COUNT(*) as count FROM (SELECT ACTIVITY_JOBSTATUS,
              ACTIVITY_ID,JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE
FROM tcsappo.pa_customer_activity a
                inner join tcsappo.pa_jobstatus b
                on a.activity_jobstatus = b.jobstatus_id
                inner join tcsappo.pa_user c
                on a.activity_userid = c.user_id
                inner join tcsappo.pa_truecard_customer d
                on a.activity_customercardid = d.cardid
                inner join tcsappo.pa_usergroup e
                on c.user_groupid = e.usergroup_id
                inner join tcsappo.pa_service f
                on a.activity_serviceid = f.service_id
                where a.activity_duedate < SYSDATE
                AND b.jobstatus_id not in (1, 5,6) $period)");
        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getjobreport_bymonthly() {
        $query = $this->db->query("SELECT to_char(edate.each_date,'DD') as each_date
,(SELECT COUNT(*) FROM TCSAPPO.PA_CUSTOMER_ACTIVITY ACT WHERE to_char(ACT.ACTIVITY_CREATEDATE,'DD/MM') = to_char(edate.each_date,'DD/MM') AND ACT.ACTIVITY_JOBSTATUS = 1) as fclose
,(SELECT COUNT(*) FROM TCSAPPO.PA_CUSTOMER_ACTIVITY ACT WHERE to_char(ACT.ACTIVITY_CREATEDATE,'DD/MM') = to_char(edate.each_date,'DD/MM')  AND ACT.ACTIVITY_JOBSTATUS = 2) as fcallback
,(SELECT COUNT(*) FROM TCSAPPO.PA_CUSTOMER_ACTIVITY ACT WHERE to_char(ACT.ACTIVITY_CREATEDATE,'DD/MM') = to_char(edate.each_date,'DD/MM')  AND ACT.ACTIVITY_JOBSTATUS = 3) as fwaiting
,(SELECT COUNT(*) FROM TCSAPPO.PA_CUSTOMER_ACTIVITY ACT WHERE to_char(ACT.ACTIVITY_CREATEDATE,'DD/MM') = to_char(edate.each_date,'DD/MM') AND ACT.ACTIVITY_JOBSTATUS = 4) as fopen
,(SELECT COUNT(*) FROM TCSAPPO.PA_CUSTOMER_ACTIVITY ACT WHERE to_char(ACT.ACTIVITY_CREATEDATE,'DD/MM') = to_char(edate.each_date,'DD/MM')  AND ACT.ACTIVITY_JOBSTATUS = 5) as fcancel
FROM (SELECT  TO_DATE(TRUNC (SYSDATE, 'MM'), 'DD/MM/YYYY')+(LEVEL - 1) each_date
FROM    DUAL a
CONNECT BY LEVEL < (TO_NUMBER (TO_CHAR (TRUNC (SYSDATE, 'MM') - 1, 'DD'))+1)
)  edate");


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getcreate_act_eport_bymonthly() {
        $query = $this->db->query("SELECT to_char(edate.each_date,'DD') as each_date
,(SELECT COUNT(*) FROM TCSAPPO.PA_CUSTOMER_ACTIVITY ACT WHERE  to_char(ACT.ACTIVITY_CREATEDATE,'DD/MM') = to_char(edate.each_date,'DD/MM')) as fopen
FROM (SELECT  TO_DATE(TRUNC (SYSDATE, 'MM'), 'DD/MM/YYYY')+(LEVEL - 1) each_date
FROM    DUAL a
CONNECT BY LEVEL < (TO_NUMBER (TO_CHAR (TRUNC (SYSDATE, 'MM') - 1, 'DD'))+1)
)  edate");


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function getjobreport_bystatus($status, $period) {
        switch ($period) {
            case 1:
                $period = "  AND extract(month from activity_createdate) = extract(month from SYSTIMESTAMP) 
 AND extract(year from activity_createdate) = extract(year from SYSTIMESTAMP)";
                break;

            case 2:
                $period = "  AND extract(year from activity_createdate) = extract(year from SYSTIMESTAMP)";
                break;
        }
        $query = $this->db->query("SELECT COUNT(*) as count FROM (SELECT ACTIVITY_JOBSTATUS,
              JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE
FROM tcsappo.pa_customer_activity a 
            inner join tcsappo.pa_jobstatus b 
            on a.activity_jobstatus = b.jobstatus_id 
            inner join tcsappo.pa_user c 
            on a.activity_userid = c.user_id
            inner join tcsappo.pa_truecard_customer d 
            on a.activity_customercardid = d.cardid
            inner join tcsappo.pa_usergroup e
            on c.user_groupid = e.usergroup_id
            inner join tcsappo.pa_service f
            on a.activity_serviceid = f.service_id
            where b.jobstatus_id = " . $status . " $period)
             ORDER BY jobstatus_priority, activity_duedate DESC");


        $this->db->close();
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function getjobexport_allstatus($servicetype = null, $user_groupid, $isreviewer = null, $offset = null, $limit = null, $userid = null, $from = null, $to = null) {
        $cond = '';
        $cond2 = '';
        $cond3 = '';
        $strrang = '';
        $strlimit = '';
        if ($servicetype != null) {
            if ($userid != null) {
                $cond3 = " AND     c.user_id  = '$userid'";
            }$cond = " AND     f.service_id in ($servicetype)";
        }

        if ($isreviewer != '1') {
            $cond2 = " AND e.usergroup_id = $user_groupid";
        }
        if ($userid != null) {
            $cond3 = " AND     c.user_id  = '$userid'";
        }

        if ($offset != null) {
            $strlimit = " AND RNUM BETWEEN $offset AND $limit";
        }

        if ($from != null && $to != null) {
            $strrang = " AND ACTIVITY_CREATEDATE BETWEEN to_date('$from 00:00:01', 'dd/mm/yyyy HH24:MI:SS') AND to_date('$to 23:00:59', 'dd/mm/yyyy HH24:MI:SS')";
        }

        $sql = "";
        $sql .= "SELECT * FROM (SELECT JOBSTATUS_NAME , SERVICE_NAME, DBMS_LOB.substr(ACTIVITY_NOTE,5000) as ACTIVITY_NOTE
            ,ACTIVITY_CONTACTNAME
            ,ACTIVITY_CONTACTNUMBER
            ,ACTIVITY_CONTACTEMAIL
            ,DBMS_LOB.substr(ACTIVITY_CUSTOMFIELD,10000) as ACTIVITY_CUSTOMFIELD, CARDID, CARDNAME, USER_FULLNAME,  USERGROUP_NAME,
 ACTIVITY_DUEDATE, ACTIVITY_UPDATEDATE, ACTIVITY_CREATEDATE FROM  (SELECT ACTIVITY_NOTE ,ACTIVITY_CONTACTNAME
            ,ACTIVITY_CONTACTNUMBER
            ,ACTIVITY_CONTACTEMAIL,ACTIVITY_CUSTOMFIELD,ACTIVITY_JOBSTATUS,ACTIVITY_ID,JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE
 FROM tcsappo.pa_customer_activity a
                inner join tcsappo.pa_jobstatus b
                on a.activity_jobstatus = b.jobstatus_id
                inner join tcsappo.pa_user c
                on a.activity_userid = c.user_id
                inner join tcsappo.pa_truecard_customer d
                on a.activity_customercardid = d.cardid
                inner join tcsappo.pa_usergroup e
                on c.user_groupid = e.usergroup_id
                inner join tcsappo.pa_service f
                on a.activity_serviceid = f.service_id
                Where 1 = 1 " . $cond . $cond2 . $cond3 . $strrang . " ORDER BY jobstatus_priority, ACTIVITY_CREATEDATE DESC )
                ) WHERE 1=1 $strlimit ";


//mysql_query('SET CHARACTER SET tis620');
//mysql_query('SET collation_connection = "tis620_thai_ci"');
        $query = $this->db->query($sql);
        $this->db->close();
        return $query;
    }

    function getjobexport_overdue($servicetype = null, $user_groupid, $isreviewer = null, $offset = null, $limit = null, $userid = null, $from = null, $to = null) {
        $cond = '';
        $cond2 = '';
        $cond3 = '';
        $strlimit = '';
        $strrang = '';
        if ($servicetype != null) {
            $cond = " AND     f.service_id in ($servicetype)";
        }

        if ($isreviewer != '1') {
            $cond2 = " AND e.usergroup_id = $user_groupid";
        }
        if ($userid != null) {
            $cond3 = " AND     c.user_id  = '$userid'";
        }

        if ($offset != null) {
            $strlimit = " AND RNUM BETWEEN $offset AND $limit";
        }

        if ($from != null && $to != null) {
            $strrang = " AND ACTIVITY_CREATEDATE BETWEEN to_date('$from 00:00:01', 'dd/mm/yyyy HH24:MI:SS') AND to_date('$to 23:00:59', 'dd/mm/yyyy HH24:MI:SS')";
        }
        $sql = "";
        $sql .= "SELECT * FROM (SELECT JOBSTATUS_NAME,
SERVICE_NAME,DBMS_LOB.substr(ACTIVITY_NOTE,5000) as ACTIVITY_NOTE
            ,ACTIVITY_CONTACTNAME
            ,ACTIVITY_CONTACTNUMBER
            ,ACTIVITY_CONTACTEMAIL
,DBMS_LOB.substr(ACTIVITY_CUSTOMFIELD,10000) as ACTIVITY_CUSTOMFIELD,
CARDID,
CARDNAME,
USER_FULLNAME,
USERGROUP_NAME,
 ACTIVITY_DUEDATE ,
 ACTIVITY_UPDATEDATE,
 ACTIVITY_CREATEDATE FROM (SELECT ACTIVITY_JOBSTATUS ,ACTIVITY_CONTACTNAME
            ,ACTIVITY_CONTACTNUMBER
            ,ACTIVITY_CONTACTEMAIL,ACTIVITY_NOTE,ACTIVITY_CUSTOMFIELD,
ACTIVITY_ID,JOBSTATUS_ID,
JOBSTATUS_NAME,
SERVICE_NAME,
CARDID,
CARDNAME,
USER_FULLNAME,
USER_ID,
USERGROUP_ID,
USERGROUP_NAME,
JOBSTATUS_PRIORITY,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE 
FROM tcsappo.pa_customer_activity a
                inner join tcsappo.pa_jobstatus b
                on a.activity_jobstatus = b.jobstatus_id
                inner join tcsappo.pa_user c
                on a.activity_userid = c.user_id
                inner join tcsappo.pa_truecard_customer d
                on a.activity_customercardid = d.cardid
                inner join tcsappo.pa_usergroup e
                on c.user_groupid = e.usergroup_id
                inner join tcsappo.pa_service f
                on a.activity_serviceid = f.service_id
                where a.activity_duedate < SYSDATE
                AND b.jobstatus_id not in (1, 5,6)" . $cond . $cond2 . $cond3 . $strrang . "))
                WHERE 1=1 $strlimit  ORDER BY   ACTIVITY_CREATEDATE DESC ";
// where a.activity_duedate < SYSDATE - INTERVAL '1' DAY
//mysql_query('SET CHARACTER SET tis620');
//mysql_query('SET collation_connection = "tis620_thai_ci"');
        $query = $this->db->query($sql);
        $this->db->close();
        return $query;
    }

    function getjobexport_bystatus($status, $servicetype = null, $user_groupid, $isreviewer = null, $offset = null, $limit = null, $userid = null, $from = null, $to = null) {
        $cond = '';
        $cond2 = '';
        $cond3 = '';
        $strlimit = '';
        $strrang = '';
        if ($servicetype != null) {
            $cond = " AND f.service_id in ($servicetype)";
        }

        if ($isreviewer != '1') {
            $cond2 = " AND e.usergroup_id = $user_groupid";
        }
        if ($userid != null) {
            $cond3 = " AND     c.user_id  = '$userid'";
        }
        if ($offset != null) {
            $strlimit = " AND RNUM BETWEEN $offset AND $limit";
        }

        if ($from != null && $to != null) {
            $strrang = " AND ACTIVITY_CREATEDATE BETWEEN to_date('$from 00:00:01', 'dd/mm/yyyy HH24:MI:SS') AND to_date('$to 23:00:59', 'dd/mm/yyyy HH24:MI:SS')";
        }

        $sql = "";
        $sql .= "SELECT * FROM (SELECT JOBSTATUS_NAME,
SERVICE_NAME,DBMS_LOB.substr(ACTIVITY_NOTE,5000) as ACTIVITY_NOTE
            ,ACTIVITY_CONTACTNAME
            ,ACTIVITY_CONTACTNUMBER
            ,ACTIVITY_CONTACTEMAIL
,DBMS_LOB.substr(ACTIVITY_CUSTOMFIELD,10000) as ACTIVITY_CUSTOMFIELD,
CARDID,
CARDNAME,
USER_FULLNAME,
USERGROUP_NAME,
to_char(ACTIVITY_DUEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_DUEDATE ,
to_char(ACTIVITY_UPDATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF') as ACTIVITY_UPDATEDATE,
to_char(ACTIVITY_CREATEDATE, 'DD/MM/YYYY HH24:MI:SSxFF')  as ACTIVITY_CREATEDATE,
jobstatus_priority
FROM tcsappo.pa_customer_activity a 
            inner join tcsappo.pa_jobstatus b 
            on a.activity_jobstatus = b.jobstatus_id 
            inner join tcsappo.pa_user c 
            on a.activity_userid = c.user_id
            left join tcsappo.pa_truecard_customer d 
            on a.activity_customercardid = d.cardid
            inner join tcsappo.pa_usergroup e
            on c.user_groupid = e.usergroup_id
            inner join tcsappo.pa_service f
            on a.activity_serviceid = f.service_id
            where b.jobstatus_id = " . $status . $cond . $cond2 . $cond3 . $strrang . ")
            WHERE 1=1 $strlimit
             ORDER BY jobstatus_priority, ACTIVITY_CREATEDATE DESC";



//mysql_query('SET CHARACTER SET tis620');
//mysql_query('SET collation_connection = "tis620_thai_ci"');
        $query = $this->db->query($sql);
        $this->db->close();
        return $query;
    }

}

?>