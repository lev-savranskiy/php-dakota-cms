<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.4
 */

class Api extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();

        $this->vars['content_view'] = 'admin/api_view';
        $this->vars['title'] = TITLE_AC .  'API';
    }


     /**
     * @method   Api  index
     * @return data to tpl
     */

    public function index() {



        $this->vars['message'] = '';


        $this->load->view('tpl/template', $this->vars);

    }





     /**
     * @method   api update
     * @return data to tpl
     */
    public function update() {

        if ($this->_update_validate() === FALSE) {
                $this->index();
                return;
            }


         Doctrine_Query::create()
                ->update('api_settings')
                ->set('vk_api_id', '?', trim($this->input->post('vk_api_id')))
                ->set('vk_api_widget_club_id', '?', trim($this->input->post('vk_api_widget_club_id')))
                ->set('vk_api_widget_club_width', '?', $this->input->post('vk_api_widget_club_width'))
                ->set('use_facebook_share', '?', trim($this->input->post('use_facebook_share')))
                ->set('use_twitter_share', '?', trim($this->input->post('use_twitter_share')))
                ->set('use_vk_share', '?', trim($this->input->post('use_vk_share')))
                ->set('show_translation_option', '?', trim($this->input->post('show_translation_option')))
                ->execute();



        $this->session->set_flashdata('message',  lang('dakota_updated'));

        // USE REDIRECT TO GET NEW VALUES!!
        redirect('/admin/api/');

        //$this->load->view('tpl/template', $this->vars);

    }





    private function _update_validate() {

        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');


        return $this->form_validation->run();

    }


}