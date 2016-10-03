<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Gallery extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Gallery_model');

  // define('HIDE_SIDEBAR', true);
    }

    /**
     * @method  build gallery data
     * @return data to tpl
     */



    public function index() {
         $this->output->cache(CACHE_TTL);

        $this->vars['images'] =  $this->Gallery_model->get_images();

        $this->vars['content_view'] = '/all_gallery_view';
        $this->vars['title'] = TITLE . colon() . lang('dakota_gallery');
        $this->vars['error'] = '';


        $this->load->view('tpl/template', $this->vars);

    }




}