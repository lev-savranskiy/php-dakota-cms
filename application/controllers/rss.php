<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */
class Rss extends MY_Controller {


    public function __construct() {
        parent::__construct();
                $this->load->helper('xml');


    }

    /**
      * @method index
     * @return  rss data
     */

    function index() {

        $data['feed_name'] = TITLE;
        $data['feed_url'] = base_url();
        $data['page_description'] = META_DESCRIPTION;

        $a = new Article();
        $data['updates'] = $a->get_articles(20, 0);

       $this->output->set_header("Content-Type: application/rss+xml");
       // header('Content-Type: application/rss+xml');
        $this->load->view('rss_view', $data);

    }

}
