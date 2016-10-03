<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */
class MY_Session extends CI_Session {


    public $error;
    public $db;

    public function MY_Session() {
        parent::CI_Session();

    }


  public function    check_token($token) {
          return create_form_token() == $token;
  }



    public function get_session_id() {
        $session_raw = $this->CI->input->cookie($this->sess_cookie_name);
        $session = $this->_unserialize($session_raw);
        return isset($session['session_id']) ? $session['session_id'] : null ;
    }

    public function is_online($id) {

        $CI = & get_instance();

        $query = $CI->db->query("SELECT * FROM ci_sessions");

        foreach ($query->result_array() as $row) {

            $userData =  isset($row['user_data']) ? (unserialize($row['user_data'])) : null;

            if (isset($userData['user']['id']) && $userData['user']['id'] == $id) {
                return true;
            }

        }


    }

}