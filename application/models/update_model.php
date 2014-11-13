<?php

class update_model extends CI_Model {

    function update_activity($input, $input_duedate) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('ACTIVITY_UPDATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->set('ACTIVITY_DUEDATE', "to_date('$input_duedate', 'dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->where('ACTIVITY_ID', $input['ACTIVITY_ID']);
        if ($this->db->update('TCSAPPO.PA_CUSTOMER_ACTIVITY', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function update_truecardcust($input, $input_enddate) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('LAST_UPDATE_DT', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->set('EXPIRED', "LAST_DAY(to_date('$input_enddate', 'mm/yyyy HH24:MI:SS'))", false);
        $this->db->set('ENDDATE', "LAST_DAY(to_date('$input_enddate', 'mm/yyyy HH24:MI:SS'))", false);
        $this->db->where('ID', $input['ID']);
        if ($this->db->update('TCSAPPO.PA_TRUECARD_CUSTOMER', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function update_service($input) {

        $time = date('d/m/Y H:i:s');
        $this->db->set('SERVICE_UPDATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->where('SERVICE_ID', $input['SERVICE_ID']);
        if ($this->db->update('TCSAPPO.PA_SERVICE', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function update_email_template($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('EMAIL_UPDATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->where('EMAIL_ID', $input['EMAIL_ID']);
        if ($this->db->update('TCSAPPO.PA_EMAIL_TEMPLATE', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function update_sms_template($input) {
        $time = date('d/m/Y H:i:s');
        $this->db->set('SMS_UPDATEDATE', "to_date('$time', 'dd/mm/yyyy HH24:MI:SS')", false);
        $this->db->where('SMS_ID', $input['SMS_ID']);
        if ($this->db->update('TCSAPPO.PA_SMS_TEMPLATE', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function update_article($input) {

        $this->db->where('ARTICLE_ID', $input['ARTICLE_ID']);
        if ($this->db->update('TCSAPPO.PA_ARTICLE', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function update_customfield($input) {

        $this->db->where('CUSTOM_FIELD_ID', $input['CUSTOM_FIELD_ID']);
        if ($this->db->update('TCSAPPO.PA_CUSTOM_FIELD', $input)):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

}

?>