<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class System extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();
    }

     /**
     * @method   System index
     * @return data to tpl
     */

    public function index() {


        $this->vars['content_view'] = 'admin/system_view';
        $this->vars['title'] = TITLE_AC .  lang('dakota_system');

        $this->vars['message'] = '';

        $this->load->library('user_agent');


        $this->vars['SYS_OS'] = $this->agent->platform();
        $this->vars['SYS_USERNAME'] = isset($_ENV['USERNAME']) ? $_ENV['USERNAME'] : null;
        $this->vars['SYS_USERDOMAIN'] = isset($_ENV['USERDOMAIN']) ? $_ENV['USERDOMAIN'] : null;
        $this->vars['SERVER_SIGNATURE'] = isset($_SERVER['SERVER_SIGNATURE']) ? $_SERVER['SERVER_SIGNATURE'] : null;



        $this->load->view('tpl/template', $this->vars);

    }


}