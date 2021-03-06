<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Logout extends MY_Controller {


    public function __construct() {
        parent::__construct();

        if (!Auth::has_role()) {
            Auth::return_not_auth();
        }
    }

    /**
     * @method Logout index
     * @return void
     */

    public function index() {

            $this->session->sess_destroy();
            redirect('/');

    }

}
