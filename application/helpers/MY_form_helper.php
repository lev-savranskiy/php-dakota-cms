<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

// ------------------------------------------------------------------------


/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @access    public
 * @param    string    the URI segments of the form destination
 * @param    array    a key/value pair of attributes
 * @param    array    a key/value pair hidden data
 * @return    string
 */
if (!function_exists('form_open')) {
    function form_open($action = '', $attributes = '', $hidden = array()) {
        $CI =& get_instance();

        if ($attributes == '') {
            $attributes = 'method="post"';
        }

        $action = (strpos($action, '://') === FALSE) ? $CI->config->site_url($action) : $action;

        $form = '<form action="' . $action . '"';

        $form .= _attributes_to_string($attributes, TRUE);

        $form .= '>';

        if ($CI->session->sess_read()){
           $form .= form_hidden('token', create_form_token());   
        }


        if (is_array($hidden) AND count($hidden) > 0) {
            $form .= form_hidden($hidden);
        }

        return $form;
    }
}

// ------------------------------------------------------------------------

/**
 * Form Declaration - Multipart type
 *
 * Creates the opening portion of the form, but with "multipart/form-data".
 *
 * @access    public
 * @param    string    the URI segments of the form destination
 * @param    array    a key/value pair of attributes
 * @param    array    a key/value pair hidden data
 * @return    string
 */
  if (!function_exists('form_open_multipart')) {
    function form_open_multipart($action, $attributes = array(), $hidden = array()) {
        $attributes['enctype'] = 'multipart/form-data';
        return form_open($action, $attributes, $hidden);
    }
}


    function create_form_token() {
      $CI =& get_instance();
     // $new_token  = isset($CI->session->userdata['user']['email']) ? $CI->session->userdata['user']['email'] : $CI->session->get_session_id() ;

       return md5($CI->input->ip_address() . $CI->config->item('salt'));
    }
                   
     function check_form_token($token) {
        return $token == create_form_token();
    }


/* Location: ./system/helpers/form_helper.php */