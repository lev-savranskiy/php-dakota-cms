<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */

class Index extends MY_Controller {


    public function __construct() {



        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();

        // home view is Under Construction
       redirect('/admin/articles');
    }


    /**
     * @method   Admin panel index
     * @return data to tpl
     */


    public function index() {


        $this->vars['content_view'] = 'admin/home_view';
        $this->vars['title'] = TITLE_AC ;

        $this->load->view('tpl/template', $this->vars);


    }

}

