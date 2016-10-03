<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.4
 */

class Menu extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();

        $this->m = new Menu_model();

        $this->vars['title'] = TITLE_AC .  lang('dakota_menu');
        $this->vars['message'] = $this->session->flashdata('validation_errors') ? $this->session->flashdata('validation_errors') : '';
        $this->vars['menu'] = $this->m->getMenuArray();
        $this->vars['menu_prepared_ul'] = $this->m->getListedMenu(true);


        $this->vars['menu_prepared'][0] = lang('dakota_menu_is_root');
        foreach ($this->m->getMenuArray() as $k => $v) {
            if ($v['parent_id'] == 0) {
                $this->vars['menu_prepared'][$v['id']] = '->' . $v['title'];
            }
        }


    }

    /**
     * @method   Menu  move
     * @param  $id
     * @return data to tpl
     */


    public function move($where, $id, $token = null) {

        if (!is_unsigned_int($id))  return Auth::return_wrong_data();
        if (!check_form_token($token)) return Auth::return_not_auth();

        $error = false;
        $element = Doctrine::getTable('Menu_model')->find($id, 3);

        if ($where == 'up') {
            $error = $this->m->moveUp($element);
        }


        if ($where == 'down') {
            $error = $this->m->moveDown($element);
            // exit($error);

        }

        $text = lang('dakota_changes_saved');
        if ($error === false) {

            $text = lang('dakota_error_general');
        }


        $this->session->set_flashdata('validation_errors', $text);
        redirect('/admin/menu/');

    }


    /**
     * @method   Menu index
     * @return data to tpl
     */

    public function index() {


        $this->vars['content_view'] = 'admin/menu_view';
        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method   Menu  add
     * @param string $type
     * @return data to tpl
     */


    public function create() {

        if ($this->_submit_validate() === FALSE) {
            $this->add();
            return;
        }


        $this->m->title = $this->input->post('title');
        $this->m->url = $this->input->post('url');
        $this->m->parent_id = $this->input->post('parent_id');
        $this->m->order_id = safe_count($this->m->getSublingsByParentId($this->m->parent_id)) + 1;
        $this->m->save();

        $this->session->set_flashdata('validation_errors', lang('dakota_changes_saved'));
        redirect('/admin/menu/');

    }


    /**
     * @method   Menu  delete
     * @param  $id
     * @return data to tpl
     */


    public function delete($id, $token = null) {

        if (!is_unsigned_int($id))  return Auth::return_wrong_data();
        if (!check_form_token($token)) return Auth::return_not_auth();
        $this->session->set_flashdata('validation_errors', lang('dakota_changes_saved'));
        $this->m->delete($id);

        redirect('/admin/menu/');
    }


    /**
     * @method   Menu  add
     * @param string $type
     * @return data to tpl
     */


    public function add() {
        $this->vars['site_urls'] = $this->m->getSiteUrls();
        $this->vars['content_view'] = 'admin/menu_add_view';


        $this->load->view('tpl/template', $this->vars);
    }

    /**
     * @method   Menu update
     * @return data to tpl
     */
    public function update($id) {


        if (!is_unsigned_int($id)) {
            $this->session->set_flashdata('validation_errors', lang('dakota_wrong_data'));
            redirect('/admin/menu/');
        }

        $this->vars['element'] = Doctrine::getTable('Menu_model')->find($id, 3);
        $this->vars['content_view'] = 'admin/menu_update_view';

        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method   Menu change
     * @return data to tpl
     */
    public function change($id) {


        if ($this->_update_validate() === FALSE) {
            $this->update($id);
            return;
        }

        $element = Doctrine::getTable('Menu_model')->find($id);

        $element->url = trim($this->input->post('url'));
        $element->title = trim($this->input->post('title'));
        //$element->parent_id = trim($this->input->post('parent_id'));
        $element->save();

        $this->session->set_flashdata('validation_errors', lang('dakota_changes_saved'));
        $this->vars['element'] = Doctrine::getTable('Menu_model')->find($id, 3);
          redirect('/admin/menu/');

        //$this->vars['content_view'] = 'admin/menu_view';
       // $this->load->view('tpl/template', $this->vars);

    }


    private function _update_validate() {

        $this->_submit_validate();

        return $this->form_validation->run();

    }


    private function _submit_validate() {

        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');

        $this->form_validation->set_rules('title', 'title',
            'trim|required|min_length[1]');

        $this->form_validation->set_rules('url', 'url',
            'trim|required|min_length[1]');


        return $this->form_validation->run();

    }

}