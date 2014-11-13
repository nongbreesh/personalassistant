<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
    }

    function __destruct() {
        parent::__destruct();
    }

    public function index() {
        $this->config->set_item('enable_query_strings', TRUE);
        if (!$this->user_model->is_login()) {
            redirect(base_url() . 'login');
        } else {
            $data['user'] = $this->user_model->get_account_cookie();
        }
        $data['prm'] = "";
        $data['privilege'] = null;

        $data['engchar'] = range('A', 'Z');

        $data['thaichar'] = array('ก', 'ข', 'ค', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ฌ', 'ญ', 'ฐ', 'ฑ', 'ฒ'
            , 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น', 'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร', 'ล'
            , 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ');





        if ($_POST) {
            $data['prm'] = $this->input->post('input_search');
            /* Get the page number from the URI (/index.php/pagination/index/{pageid}) */
            /* Load the 'pagination' library */
            $this->load->library('pagination');

            /* Set the config parameters */
            $data['page'] = $this->input->get('per_page') == '' ? '0' : $this->input->get('per_page');
            $data['prefix'] = $this->input->get('prefix') == '' ? 'false' : $this->input->get('prefix');
            $config['uri_segment'] = 3;
            $config['per_page'] = 10;
            $config['base_url'] = base_url() . '/dashboard/index?prm=' . $data['prm'];
            $config['total_rows'] = $this->select_model->get_search_count($data['prm'], null, null, $data['prefix'])->COUNT;


            /* Initialize the pagination library with the config array */
            $this->pagination->initialize($config);

            $data['privilege'] = $this->select_model->get_search_privilege($data['prm'], $data['page'], $config['per_page'] + $data['page'], $data['prefix']);
        } else {
            $data['prm'] = $this->input->get('prm');
            /* Get the page number from the URI (/index.php/pagination/index/{pageid}) */
            /* Load the 'pagination' library */
            $this->load->library('pagination');

            /* Set the config parameters */
            /* Set the config parameters */
            $data['page'] = $this->input->get('per_page') == '' ? '0' : $this->input->get('per_page');
            $data['prefix'] = $this->input->get('prefix') == '' ? 'false' : $this->input->get('prefix');
            $config['uri_segment'] = 3;
            $config['per_page'] = 30;
            $config['num_links'] = 20;
            $config['base_url'] = base_url() . '/dashboard/index?prm=' . $data['prm'];
            $config['total_rows'] = $this->select_model->get_search_count($data['prm'], null, null, $data['prefix'])->COUNT;
            /* Initialize the pagination library with the config array */
            /* This Application Must Be Used With BootStrap 3 *  */
            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] = "</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";
            $this->pagination->initialize($config);
            if ($this->input->get('per_page')) {
                $data['privilege'] = $this->select_model->get_search_privilege($data['prm'], $data['page'], $config['per_page'] + $data['page'] - 1, $data['prefix']);
            } else {
                $data['privilege'] = $this->select_model->get_search_privilege($data['prm'], $data['page'], $config['per_page'] + $data['page'], $data['prefix']);
            }
        }
        $data['menu'] = 'dashboard';
        $data['body'] = 'dashboard/index';
        $this->load->view('template/index', $data);
    }

    function testsms() {
        $rs = $this->user_model->_sendSMS('66863647397', 'TEST SMS', 'TRUEYOU');
        //header('Content-type: text/xml');
        echo $rs;
    }

    function testcard() {
        $rs = $this->user_model->_get_card_info('175|1.654132a3b1bdc765b05555__3600.1420538197-5076893|a2b7e1b3f0d22b387217845d4df', '1200900063315');
        print_r($rs);
    }

    function kill_all_session() {
        $rs = $this->select_model->getdbsession("'TCSAPPC'");

        foreach ($rs as $each) {
            $this->delete_model->kill_session($each->SID, $each->SERIAL);
        }
    }

    function phpinfo() {
        echo phpinfo();
    }

    function testldap() {
//error line 645;
        include_once APPPATH . 'libraries/adLDAP.php';
        $username = 'U-SVC-Concierge';
        $password = 'Fd483#ntPa';
        try {

            $adldap = new adLDAP(array('admin_username' => $username, 'admin_password' => $password));
            $attributes['proxyAddresses'] = 'proxy:80';
            $adldap->adldap_schema($attributes);
        } catch (adLDAPException $e) {
            $data['message'] = "Username OR Password is incorrect";
            $data['result'] = false;
            $rs = false;
        }
        $rs = true;
        if ($rs) {
            if ($adldap->authenticate($username, $password)) {
                $result = $adldap->user()->info($username, array('*'));
                $data['result'] = array('title' => $result[0]['title'][0], 'empid' => $result[0]['description'][0], 'fullname' => $result[0]['cn'][0], 'email' => $result[0]['mail'][0]);
            } else {
                $data['result'] = false;
            }
        }


        print_r($data);
    }

    function testemail() {
        $data['email'] = explode(',', 'mpitchya@gmail.com,pisamai_bua@truecorp.co.th,veerayut_tasu@truecorp.co.th,breesh.comsci@gmail.com,subble_comsci@hotmail.com');
        print_r($data['email']);
        $subject = 'test';
        $msg = 'xxx';
        $email = array('pitchya_pon@truecorp.co.th,veerayut_tasu@truecorp.co.th,breesh.comsci@gmail.com,subble_comsci@hotmail.com,m_pitchya@hotmail.com,mpitchya@gmail.com');
        print_r($email);
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
        //$this->email->cc();
        $this->email->subject($subject); //หัวข้อของอีเมล
        $this->email->message($msg); //เนื้อหาของอีเมล
        $this->email->send();
        echo $this->email->print_debugger();
    }

    function testnum() {
        $no = '66863647397,66916964213,0899008226';
        $no = explode(',', $no);
        $mobileno = '';
        foreach ($no as $each) {
            $fstdigit = substr($each, 0, 1);
            if ($fstdigit == 0) {
                if (strlen($each) == 10) {
                    $mobileno .= '66' . substr($each, 1, 9) . ",";
                }
            } elseif ($fstdigit == 6) {
                if (strlen($each) == 11) {
                    $mobileno .= $each . ",";
                }
            }
        }

        echo rtrim($mobileno, ",");
    }

    function testldap2() {

        $username = 'veeray5';
        $pass = 'Breesh1112';

        if ($username != null and $pass != null) {
            $server = "172.19.0.124:";
            $user = $username;
            // connect to active directory
            $ad = ldap_connect($server);

            if (!$ad) {
                die("Connect not connect to " . $server);
                echo "ไม่สามารถติดต่อ server  ได้";
                exit();
            } else {
                $b = @ldap_bind($ad, $user, $pass);
                if (!$b) {
                    die("<br><br>
							<div align='center'>    ท่านกรอกรหัสผ่านผิดพลาด
							<br>
							</div>");
                } else {
                    echo 'success';
                }


                exit();
            }
        }
    }

    function testldap3() {
        $this->load->view('ldap');
    }

}
