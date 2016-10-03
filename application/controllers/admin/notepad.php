<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Notepad extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (! Auth::is_admin())  Auth::return_not_auth();
    }


    /**
       * @method   Notepad index
       * @return data to tpl
       */



    public function index($message = null) {

        $this->vars['notes'] = Doctrine::getTable('Note')->findAll();
        $this->vars['content_view'] = 'admin/notepad_view';
        $this->vars['title'] = TITLE_AC .  lang('dakota_notepad');
        $this->vars['message'] = $message != null ? $message: '';

        $this->load->view('tpl/template', $this->vars);

    }


        /**
       * @method   Notepad add record
       * @return data to tpl
       */


    public function create() {

        if ($this->_submit_validate() === FALSE) {
            $this->index();
            return;
        }
        
        $u = new Note();
        $u->text = $this->input->post('text');
        $u->author_id = ID;
        $u->save();

        redirect('/admin/notepad/');


    }


    /**
   * @method  Notepad clear
   * @return data to tpl
   */


    public function clear($token = null) {

        if (! check_form_token($token)) return Auth::return_not_auth();
            $u = Doctrine::getTable('Note')->findAll();
            $u->delete();

        redirect('/admin/notepad/');
    }



    private function _submit_validate() {
        
        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');


        $this->form_validation->set_rules('text', 'text',
            'trim|required|min_length[5]');



        return $this->form_validation->run();

    }





}