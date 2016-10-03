<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Current_User extends Model {

    private static $user;

    public function __construct() {


        if (!isset(self::$user)) {

            if (!Auth::has_id()) {
                return FALSE;
            }

            if (!$u = Doctrine::getTable('User')->find(Auth::has_id())) {

                return FALSE;
            }

            foreach ($u as $k => $v) {
                $this->$k = $v;
            }

            self::$user = $u;
        }

        return self::$user;

    }


    public function update($site_user_settings) {
        $CI =& get_instance();
        $u = self::$user;
        $u->firstname = $CI->input->post('firstname');
        $u->lastname = $CI->input->post('lastname');
        $u->city = $CI->input->post('city');
        $u->country = $CI->input->post('country');

        $settings = array();
        $settings['sex'] = $CI->input->post('sex');

        foreach ($site_user_settings as $s => $v) {
            $settings[$s] = $CI->input->post($s);
        }
        $u->settings = serialize($settings);
        // update DB
        $u->save();
        // update Session
        $userdata['user'] = $u->toArray();
        $CI->session->set_userdata($userdata);

    }

    public static function resetpass($reset_pass_key, $password) {

        // get User object by reset_pass_key
        if ($u = Doctrine::getTable('User')->findOneBy('reset_pass_key', $reset_pass_key)) {

            if (!$u->active) {
                return FALSE;
            }

            $u->password = $password;
            $u->reset_pass_key = null;
            $u->save();

            return TRUE;
        }


        return FALSE;

    }


    public static function login($email, $password) {

        // get User object by username
        if ($u = Doctrine::getTable('User')->findOneBy('email', $email)) {
            $CI =& get_instance();

            if (!$u->active) {
                return FALSE;
            }


            // to get the mutated version of the input password
            $u_input = new User();
            $u_input->password = $password;


            // password match
            if ($u->password == $u_input->password && isset($u->role)) {

                $u->ip = $CI->input->ip_address();
                $u->last_login = unix_to_human(time(), TRUE, 'eu');
                $u->save();

                $userdata['auth'] = true;
                $userdata['user'] = $u->toArray();

                $CI->session->set_userdata($userdata);

                self::$user = $u;

                return TRUE;
            }

            unset($u_input);
        }

        // login failed
        return FALSE;

    }


    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

}
