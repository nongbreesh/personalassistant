<?php

class delete_model extends CI_Model {

    function delete_group($id) {

        $this->db->where('USERGROUP_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_USERGROUP')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_user($id) {

        $this->db->where('USER_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_USER')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_customf($id) {

        $this->db->where('CUSTOM_FIELD_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_CUSTOM_FIELD')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_permission($id) {

        $this->db->where('PERMISSION_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_PERMISSION')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_partner($id) {

        $this->db->where('PARTNER_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_PARTNER')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_article($id) {

        $this->db->where('ARTICLE_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_ARTICLE')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_service($id) {

        $this->db->where('PARTNER_SERVICEID', $id);
        $this->db->delete('TCSAPPO.PA_PARTNER');

        $this->db->where('SERVICE_ID', $id);
        $this->db->delete('TCSAPPO.PA_ARTICLE');

        $this->db->where('SERVICE_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_SERVICE')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_email($id) {
        $this->db->where('EMAIL_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_EMAIL_TEMPLATE')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function delete_sms($id) {
        $this->db->where('SMS_ID', $id);
        if ($this->db->delete('TCSAPPO.PA_SMS_TEMPLATE')):
            $this->db->close();
            return true;
        else:
            return false;
        endif;
    }

    function kill_session($sid, $serial) {
        $this->db->query("CALL SYS.KILL_APP_SESSION($sid,$serial)");
        return true;
    }

}

?>