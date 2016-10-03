<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */
class MY_URI extends CI_URI {
    function _filter_uri($str) {
        if ($str != '' AND $this->config->item('permitted_uri_chars') != '') {
            if (!preg_match("|^[" . preg_quote($this->config->item('permitted_uri_chars')) . "]+$|ui", $str)) {
                //   exit('The URI you submitted has disallowed characters.');
            }
        }

        return $str;
    }
}