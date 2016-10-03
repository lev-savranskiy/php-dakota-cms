<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Auth {

   


    /***
     *   @method is_admin
     *  @return bool
     */
    static function is_admin() {

        if (self::has_role() >= 50) {
            return true;
        }
    }

    /*** compare_user_role
     *  @param int
     *  @return boolean
     */
    static function compare_user_role($user_id) {

        $user = Doctrine::getTable('User')->find($user_id, 3);

        return self::check_role($user['role']);


    }


    /*** check role
     *
     *  @param int
     *  @return boolean
     */
    static function check_role($role) {
        $CI = & get_instance();
        $site_roles = $CI->config->item('site_roles');
        return array_key_exists($role, $site_roles) && $role < ROLE;


    }

    /*** has_role
     *  @return int
     */
    static function has_role() {

        $CI =& get_instance();
        $user = $CI->session->userdata('user');
        return isset($user['role']) ? $user['role'] : 0;


    }

    static function has_id() {

        $CI =& get_instance();
        $user = $CI->session->userdata('user');
        return isset($user['id']) ? $user['id'] : 2;


    }


    static function return_not_auth() {

        show_error(lang('dakota_not_auth'));
    }


     static function return_register_is_off() {

        show_error(lang('dakota_register_is_off'));
    }

    static function return_Anonymous_login_attempt() {

        show_error(lang('dakota_Anonymous_login_attempt'));
    }

    static function return_wrong_data() {

        show_error(lang('dakota_wrong_data'));
    }

}
