<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Captcha extends MY_Controller {


    public function __construct() {
        parent::__construct();
    }


    /***
     * @method  creates Captcha
     * @return  image/png
     */

    public function index() {

        $this->load->library('captcha_lib');
        header("Content-Type: image/png");
        Captcha_lib::create();

    }


}

