<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */
class MY_Form_validation extends CI_Form_validation {

    function unique($value, $params) {
        $CI =& get_instance();
        $CI->form_validation->set_message('unique', ' %s ' . lang('dakota_nv_taken'));

        list($model, $field) = explode(".", $params, 2);

        $find = "findOneBy" . $field;

        if (Doctrine::getTable($model)->$find($value)) {
            return false;
        } else {
            return true;
        }
    }


     function check_day($str) {
         $CI =& get_instance();
         $CI->form_validation->set_message('check_day', lang('dakota_nv_date'));
            return $str > 0 && $str < 32;
    }

    function check_month($str) {
         $CI =& get_instance();
         $CI->form_validation->set_message('check_month', lang('dakota_nv_month') );
            return $str > 0 && $str < 13;
    }

    function check_year($str) {
         $CI =& get_instance();
         $CI->form_validation->set_message('check_year', lang('dakota_nv_year'));
            return $str >=  $CI->config->item('birth_year_start') && $str <=  $CI->config->item('birth_year_end');
    }

    function valid_url($str) {
        $CI =& get_instance();
        $CI->form_validation->set_message('valid_url', lang('dakota_nv_url'));

       	return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str)) ? FALSE : TRUE;

    }



    function check_role($role) {
        $CI =& get_instance();

        $CI->form_validation->set_message('check_role', lang('dakota_nv_role'));

        return $role < ROLE ? true : false;
    }


    function check_captcha($text) {
        $CI =& get_instance();

        $CI->form_validation->set_message('check_captcha',  lang('dakota_nv_captcha'));

        return $CI->session->userdata('captcha') == $CI->input->post('captcha') ? true : false;
    }

     function check_referer() {
        $p =  parse_url($_SERVER['HTTP_REFERER']);

        $CI =& get_instance();
        $CI->form_validation->set_message('check_referer', lang('dakota_nv_server') . nbs() .  $_SERVER['HTTP_REFERER'] . '. IP = ' . $CI->input->ip_address()  . nbs() .   lang('dakota_ask_for_support')  );

        return isset($p['host']) && $p['host'] == $_SERVER['HTTP_HOST']  ? true : false;
    }


    function check_token($text) {


        $CI =& get_instance();
        $CI->form_validation->set_message('check_token',  lang('dakota_nv_token')  . nbs() .   lang('dakota_ask_for_support'));
        

        return    create_form_token() == $CI->input->post('token') ? true : false;
    }
}