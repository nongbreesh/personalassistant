<?php

class Insert_model extends CI_Model {

    function insert_group($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('USERGROUP_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_USERGROUP', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function import_truecard_customer($file) {
        $this->db->trans_start();
        while (!feof($file)) {
            $rs = explode(";", fgets($file));
            if (count($rs) == 27) {
                if ($rs[1] != '') {
                    if ($rs[26] != '0000-00-00 00:00:00' || $rs[26] != '') {
                        $this->db->set("THAIID", "'$rs[1]'", false);
                        $this->db->set("CARDID", "'$rs[2]'", false);
                        $this->db->set("CARD10", "'$rs[3]'", false);
                        $this->db->set("MIFIRE", "'$rs[4]'", false);
                        $this->db->set("GRADE", "'$rs[6]'", false);
                        $this->db->set("CARDNAME", "'$rs[8]'", false);
                        $this->db->set("EMPID", "'$rs[9]'", false);
                        $this->db->set("CARDADDRESS", "'$rs[10]'", false);
                        //$this->db->set("STATUS", "'$rs[14]'", false);
                        $this->db->set("ACTIVATED", "'$rs[15]'", false);
                        //$this->db->set("LANGUAGE", "'$rs[17]'", false);
                        //$this->db->set("CUSTOMERTYPE", "'$rs[18]'", false);
                        //$this->db->set("RETURNCARE", "'$rs[20]'", false);
                        //$this->db->set("EXTRA1", "'$rs[21]'", false);
                        //$this->db->set("EXTRA2", "'$rs[22]'", false);
                        //$this->db->set("LAST_UPDATE_BY", "'$rs[24]'", false);
                        $this->db->set("CARDTYPE", 2, false);
                    }

                    $SENTDATE = $rs[5] == '-' ? '2014/01/01' : $rs[5];
                    $EXPIRED = $rs[7] == '-' ? '2014/01/01' : $rs[7];
                    $INVITEDATE = $rs[11] == '-' ? '2014/01/01' : $rs[11];
                    $STARTDATE = $rs[12] == '-' ? '2014/01/01' : $rs[12];
                    $ENDDATE = $rs[13] == '-' ? '2014/01/01' : $rs[13];
                    $STAMPDATE = $rs[16] == '-' ? '2014/01/01' : $rs[16];
                    $EXPIRED_DATE = $rs[23] == '-' ? '2014/01/01' : $rs[23];
                    $LAST_UPDATE_DT = $rs[24] == '-' ? '2014/01/01' : $rs[24];
                    $GRADINGDATE = $rs[19] == '-' ? '2014/01/01' : $rs[19];

                    $this->db->set('SENTDATE', "to_date(to_date('$SENTDATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('EXPIRED', "to_date(to_date('$EXPIRED','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('INVITEDATE', "to_date(to_date('$INVITEDATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('STARTDATE', "to_date(to_date('$STARTDATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('ENDDATE', "to_date(to_date('$ENDDATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('STAMPDATE', "to_date(to_date('$STAMPDATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('EXPIRED_DATE', "to_date(to_date('$EXPIRED_DATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('LAST_UPDATE_DT', "to_date(to_date('$LAST_UPDATE_DT','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->set('GRADINGDATE', "to_date(to_date('$GRADINGDATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                    $this->db->insert('TCSAPPO.PA_TRUECARD_CUSTOMER');
                }
            }
        }
        $this->db->trans_complete();
        $this->db->close();
    }

    function import_priv_data($file) {
        $this->db->trans_start();
        while (!feof($file)) {
            $rs = explode(";", fgets($file));
            if (count($rs) == 12) {

                $this->db->set("TITLE", "'$rs[0]'", false);
                $this->db->set("STRTYPE", "'-'", false);
                $this->db->set("URL", "'-'", false);
                $this->db->set("ADDRESS", "'$rs[1]'", false);
                $this->db->set("STRDESCRIPTION", "'$rs[4]'", false);
                $this->db->set("TEL", "'$rs[2]'", false);
                $this->db->set("FAX", "'-'", false);
                $this->db->set("STRMAP", "'-'", false);
                $this->db->set("STRLAT", "'-'", false);
                $this->db->set("STRLONG", "'-'", false);
                $this->db->set("CAM_NAME", "'$rs[3]'", false);
                $this->db->set("DEAL_OFFER", "'$rs[8]'", false);
                $this->db->set("DEAL_CODE", "'$rs[9]'", false);
                $this->db->set("DEAL_USSD", "'$rs[10]'", false);
                $this->db->set("DEAL_SMS", "'$rs[11]'", false);


                //$CREATE_DATE = $rs[5] == '-' ? '2014/01/01' : $rs[5];
                $DEAL_START = $rs[6] == '-' ? '2014/01/01' : $rs[6];
                $DEAL_END = $rs[7] == '-' ? '2014/01/01' : $rs[7];

                // $this->db->set('CREATE_DATE', "to_date(to_date('$CREATE_DATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                $this->db->set('DEAL_START', "to_date(to_date('$DEAL_START','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                $this->db->set('DEAL_END', "to_date(to_date('$DEAL_END','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);

                $this->db->insert('TCSAPPO.PA_PRIVILEGE_DATA');
            }
        }
        $this->db->trans_complete();
        $this->db->close();
    }

    function import_priv_data_for_edt($file) {
        $this->db->trans_start();
        while (!feof($file)) {
            $rs = explode(";", fgets($file));
            if (count($rs) == 12) {

                $this->db->set("TITLE", "'$rs[1]'", false);
                $this->db->set("STRTYPE", "'$rs[2]'", false);
                $this->db->set("URL", "'$rs[3]'", false);
                $this->db->set("ADDRESS", "'$rs[4]'", false);
                $this->db->set("STRDESCRIPTION", "'$rs[5]'", false);
                $this->db->set("TEL", "'$rs[6]'", false);
                $this->db->set("FAX", "'$rs[7]'", false);
                $this->db->set("STRMAP", "'$rs[8]'", false);
                $this->db->set("STRLAT", "'$rs[9]'", false);
                $this->db->set("STRLONG", "'$rs[10]'", false);
                $this->db->set("CAM_NAME", "'-'", false);
                $this->db->set("DEAL_OFFER", "'-'", false);
                $this->db->set("DEAL_CODE", "'-'", false);
                $this->db->set("DEAL_USSD", "'-'", false);
                $this->db->set("DEAL_SMS", "'-'", false);


                //$CREATE_DATE = $rs[5] == '-' ? '2014/01/01' : $rs[5];
                //$DEAL_START = $rs[6] == '-' ? '2014/01/01' : $rs[6];
                //$DEAL_END = $rs[7] == '-' ? '2014/01/01' : $rs[7];
                // $this->db->set('CREATE_DATE', "to_date(to_date('$CREATE_DATE','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                //$this->db->set('DEAL_START', "to_date(to_date('$DEAL_START','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);
                //$this->db->set('DEAL_END', "to_date(to_date('$DEAL_END','yyyy/mm/dd HH24:MI:SS'),'dd/mm/yyyy HH24:MI:SS')", false);

                $this->db->insert('TCSAPPO.PA_PRIVILEGE_DATA');
            }
        }
        $this->db->trans_complete();
        $this->db->close();
    }

    function inserte_truecardcust($input, $input_enddate) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('EXPIRED', "LAST_DAY(to_date('$input_enddate', 'mm/yyyy HH24:MI:SS'))", false);
        $this->db->set('ENDDATE', "LAST_DAY(to_date('$input_enddate', 'mm/yyyy HH24:MI:SS'))", false);
        $this->db->set('CREATE_DATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_TRUECARD_CUSTOMER', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function insert_user($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('USER_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_USER', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    
      function insert_log($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('LOG_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_APPLICATION_LOG', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }
    
    
    function insert_permission($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('PERMISSION_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_PERMISSION', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function gen_seq_activity() {
        $query = $this->db->query(" SELECT tcsappo.pa_customer_activity_seq.NEXTVAL as NEXTVAL  FROM DUAL");
        return $query->row();
    }

    function gen_seq_service() {
        $query = $this->db->query(" SELECT tcsappo.pa_customer_activity_seq.NEXTVAL as NEXTVAL  FROM DUAL");
        return $query->row();
    }

    function save_activity($input, $input_duedate = null) {
        $seq = $this->gen_seq_activity()->NEXTVAL;
        if ($input_duedate != null) {
            $this->db->set('ACTIVITY_DUEDATE', "to_date('$input_duedate', 'dd/mm/yyyy HH24:MI:SS')", false);
        }
        $this->db->set('ACTIVITY_ID', $seq, false);
        $time = date('d/m/Y H:i:s');
        $this->db->set('ACTIVITY_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_CUSTOMER_ACTIVITY', $input)):
            $this->db->close();
            return $seq;
        else:
            return false;
        endif;
    }

    function save_partner($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('PARTNER_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_PARTNER', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function save_customfield($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('CUSTOM_FIELD_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_CUSTOM_FIELD', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function save_article($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('ARTICLE_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_ARTICLE', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function save_service($input) {
        $seq = $this->gen_seq_service()->NEXTVAL;
        $time = date('d/m/Y H:i:s');
        $this->db->set('SERVICE_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->set('SERVICE_ID', $seq, false);
        $this->db->insert('TCSAPPO.PA_SERVICE', $input);
        $this->db->close();
        return $seq;
    }

    function save_email_template($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('EMAIL_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_EMAIL_TEMPLATE', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function save_sms_template($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('SMS_CREATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        if ($this->db->insert('TCSAPPO.PA_SMS_TEMPLATE', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

}

?>