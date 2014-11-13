<?php

class user_model extends CI_Model {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
    }

    function getauthen($input) {
        $username = trim($input['username']);
        $password = trim($input['password']);
        $empid = $input['empid'];
        //$query = $this->db->query("SELECT  * FROM tcsappo.pa_user a"
        // . " inner join tcsappo.pa_permission b on a.user_permissionid = b.permission_id WHERE a.user_empid = " . $empid);
        $query = $this->db->query("SELECT  * FROM tcsappo.pa_user a"
                . " inner join tcsappo.pa_permission b on a.user_permissionid = b.permission_id WHERE a.user_empid = '$empid'");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $expires = ( 60 * 60 * 24 * 365) / 12;
            $user['user_id'] = $row->USER_ID;
            $user['user_name'] = $row->USER_NAME;
            $user['user_fullname'] = $row->USER_FULLNAME;
            $user['user_empid'] = $row->USER_EMPID;
            $user['user_groupid'] = $row->USER_GROUPID;
            $user['user_lastlogin'] = $row->USER_LASTLOGIN;
            $user['user_permissionid'] = $row->USER_PERMISSIONID;
            $user['user_createdate'] = $row->USER_CREATEDATE;

            $user['isadmin'] = $row->USER_PERMISSIONID == 1 ? TRUE : FALSE;
            $user['isview'] = $row->PERMISSION_ISVIEW == 1 ? TRUE : FALSE;
            $user['isedit'] = $row->PERMISSION_ISEDIT == 1 ? TRUE : FALSE;
            $user['isreviewer'] = $row->PERMISSION_ISREVIEWER == 1 ? TRUE : FALSE;



            $user = $this->encrypt->encode(serialize($user));
            set_cookie('user_account', $user, $expires);

            $this->login_stamp($row->USER_ID);
            $this->db->close();
            return true;
        } else {
            return false;
        }
    }

    function login_stamp($user_id) {
        $time = date('d/m/Y H:i:s');
        $sql = "UPDATE TCSAPPO.PA_USER SET USER_LASTLOGIN = to_date('$time','dd/mm/yyyy HH24:MI:SS') WHERE USER_ID = $user_id";
        $this->db->query($sql);
        $this->db->close();
    }

    function logout() {
        $time = date('d/m/Y H:i:s');
        $user_account = $this->get_account_cookie();
        $user_id = $user_account['user_id'];
        $sql = "UPDATE TCSAPPO.PA_USER SET USER_LASTLOGOUT = to_date('$time','dd/mm/yyyy HH24:MI:SS') WHERE USER_ID = $user_id ";
        $this->db->query($sql);
        $this->db->close();
        $this->load->helper(array('cookie'));
        delete_cookie('user_account');
    }

    function is_login() {
        $user = $this->get_account_cookie();
        if (!isset($user['user_name']) || !isset($user['user_id'])) {
            return false;
        } else
        if ($this->get_by_id($user['user_id']) != false)
            return true;
        else
            return false;
    }

    function get_account_cookie() {
        // get cookie
        $c_account = get_cookie('user_account', true);
        if ($c_account != null) {
            $c_account = $this->encrypt->decode($c_account);
            $c_account = @unserialize($c_account);
            return $c_account;
        }
        return null;
    }

    function get_by_id($id) {
        $query = $this->db->query("SELECT * FROM tcsappo.pa_user WHERE user_id = '$id'");
        $this->db->close();
        return $query;
    }

    function _get_prod_info($accesstoken, $thaiid) {
        $xml = "<Request>
	<Method>GETPRODUCTINFO</Method>
	<OS>personal_assistant</OS>
	<Parameter>
 <AccessToken>$accesstoken</AccessToken>
	 <ThaiID>$thaiid</ThaiID>
	</Parameter>
</Request>
";
        //-------------------------------------------------

        try {
            $url = "http://truecardfn.truelife.com/services/mobile_api.aspx";
            $result = $this->_post_xml2($url, $xml);

            $dom = new DOMDocument;
            $dom->loadXML($result);
            $emp = $dom->getElementsByTagName('Response');
            $Products = array();
            foreach ($emp as $row) {

                $iServiceID = $row->getElementsByTagName('iServiceID');
                $iServiceID = $iServiceID->item(0)->nodeValue;

                $item = $row->getElementsByTagName('item');

                foreach ($item as $row) {
                    $ProductID = $row->getElementsByTagName('ProductID');
                    $UsageLabel = $row->getElementsByTagName('UsageLabel');
                    $data['ProductID'] = $ProductID->item(0)->nodeValue;
                    $data['UsageLabel'] = $UsageLabel->item(0)->nodeValue;
                    array_push($Products, $data);
                }
            }

            return array('iServiceID' => $iServiceID, 'Products' => $Products);
        } catch (DOMException $exc) {
            return array('iServiceID' => '', 'Products' => '');
        }


        //return $result;
    }

    function _get_card_info($accesstoken, $thaiid) {
        $xml = "<Request>
  <Method>GETCARDINFO</Method>
  <OS>personal_assistant</OS>
	<Parameter>
      <AccessToken>$accesstoken</AccessToken>
      <ThaiID>$thaiid</ThaiID> 
	</Parameter>
</Request>
";
        //-------------------------------------------------

        try {
            $url = "http://truecardfn.truelife.com/services/mobile_api.aspx";
            $result = $this->_post_xml2($url, $xml);
            if ($result != null) {
                $dom = new DOMDocument;
                $dom->loadXML($result);
                $emp = $dom->getElementsByTagName('Response');
                $Products = array();
                $ErrorCode = '';
                foreach ($emp as $row) {

                    $ErrorCode = $row->getElementsByTagName('ErrorCode');
                    $ErrorCode = $ErrorCode->item(0)->nodeValue;

                    $ThaiID = $row->getElementsByTagName('ThaiID');
                    $ThaiID = $ThaiID->item(0)->nodeValue;


                    $CardName = $row->getElementsByTagName('CardName');
                    $CardName = $CardName->item(0)->nodeValue;

                    $CardAddress = $row->getElementsByTagName('CardAddress');
                    $CardAddress = $CardAddress->item(0)->nodeValue;

                    $TrueCardNr = $row->getElementsByTagName('TrueCardNr');
                    $TrueCardNr = $TrueCardNr->item(0)->nodeValue;

                    $CardType = $row->getElementsByTagName('CardType');
                    $CardType = $CardType->item(0)->nodeValue;

                    $CardExpired = $row->getElementsByTagName('CardExpired');
                    $CardExpired = $CardExpired->item(0)->nodeValue;

                    $Card10 = $row->getElementsByTagName('Card10');
                    $Card10 = $Card10->item(0)->nodeValue;
                }

                return array('ErrorCode' => $ErrorCode
                    , 'ThaiID' => $ThaiID
                    , 'CardName' => $CardName
                    , 'CardAddress' => $CardAddress
                    , 'TrueCardNr' => $TrueCardNr
                    , 'CardType' => $CardType
                    , 'CardExpired' => $CardExpired
                    , 'Card10' => $Card10);
            } else {
                return array('ErrorCode' => 1
                    , 'ThaiID' => ''
                    , 'CardName' => ''
                    , 'CardAddress' => ''
                    , 'TrueCardNr' => ''
                    , 'CardType' => ''
                    , 'CardExpired' => ''
                    , 'Card10' => '');
            }
        } catch (DOMException $exc) {
            return array('ErrorCode' => 1
                , 'ThaiID' => ''
                , 'CardName' => ''
                , 'CardAddress' => ''
                , 'TrueCardNr' => ''
                , 'CardType' => ''
                , 'CardExpired' => ''
                , 'Card10' => '');
        }
    }

    function _sendSMS($number, $message, $sender) {
        $xml = '<message>
            <sms type="mt">
            <service-id>2310810001</service-id>
            <destination>
            <address>
            <number type="international">' . $number . '</number>
            </address>
            </destination>
            <source>
            <address>
            <number type="abbreviated">964552</number>
            <originate type="international">' . $number . '</originate>
            <sender>' . $sender . '</sender>
            </address>
            </source>
            <ud type="text" encoding="TIS-620">' . $message . '</ud>
            <dro>false</dro>
            </sms>
            </message>';
        $url = "10.95.78.23:55000";
        $result = $this->_post_xmlSMS($url, $xml);
        return $result;
    }

    function _post_xml($url, $xml) {
        $cnt = 0;
        for ($i = 1; $i <= 10; $i++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml; charset=utf-8"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            $data = curl_exec($ch);
            if ($data || $data != 'Http/1.1 Service Unavailable') { // ?? - if request and data are completely received
                curl_close($ch);
                break;
            }
            $cnt++;
        }

        return $data;
    }

    function _post_xml2($url, $xml) {
        $loginpassw = 'user:pass';  //your proxy login and password here
        $proxy_ip = 'proxy'; //proxy IP here
        $proxy_port = 80; //proxy port from your proxy list
        for ($i = 1; $i <= 10; $i++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml; charset=utf-8"));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_HEADER, 0); // no headers in the output
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // output to variable
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
            curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            $data = curl_exec($ch);
            if ($data) { // ?? - if request and data are completely received
                curl_close($ch);
                break;
            }
        }

        return $data;
    }

    function _post_xmlSMS($url, $xml) {
        $loginpassw = 'user:pass';  //your proxy login and password here
        $proxy_ip = 'proxy'; //proxy IP here
        $proxy_port = 80; //proxy port from your proxy list
        $ch = curl_init();
        $headers = array(
            'Content-Type:text/xml',
            'charset=TIS-620',
            'Host:10.95.78.23:55000;',
            'Connection:Close',
            'Authorization: Basic MjMxMDgxMDAwMTpBcnRnNTY3RA==',
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HEADER, 1); // no headers in the output
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // output to variable
        curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function _post_xmlSMS2($url, $xml) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array(
            'Content-Type:text/xml',
            'charset=TIS-620',
            'Host:10.95.78.23:55000;',
            'Connection:Close',
            'Authorization: Basic MjMxMDgxMDAwMTpBcnRnNTY3RA==',
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1); // no headers in the output
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        $result = curl_exec($ch);

        curl_close($ch);


        return $result;
    }

}

?>