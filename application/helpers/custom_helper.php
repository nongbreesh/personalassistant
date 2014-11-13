<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('read_clob')) {

    function read_clob($field) {
        if ($field == null || $field == "") {
            return "";
        } else {
            return $field->read($field->size());
        }
    }

}

if (!function_exists('mobile_format')) {

    function mobile_format($no) {
        $no = explode(',', $no);
        $mobileno = '';
        foreach ($no as $each) {
            $fstdigit = substr(trim($each), 0, 1);
            if ($fstdigit == 0) {
                if (strlen(trim($each)) == 10) {
                    $mobileno .= '66' . substr($each, 1, 9) . ",";
                }
            } elseif ($fstdigit == 6) {
                if (strlen(trim($each)) == 11) {
                    $mobileno .= $each . ",";
                }
            }
        }

        return rtrim($mobileno, ",");
    }

}