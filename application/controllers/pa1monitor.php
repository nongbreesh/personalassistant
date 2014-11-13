<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pa1monitor extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    public function index() {
        echo "<h1>SERVER OK</h1>";
    }

}
