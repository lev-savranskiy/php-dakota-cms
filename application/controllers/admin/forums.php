<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */

class Forums extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();
        $this->vars['title'] = TITLE_AC .  lang('dakota_forums');
         $this->vars['content_view'] = 'admin/forums_view';
        $this->vars['message'] = '';
    }

    /**
     * @method   Forum index
     * @return data to tpl
     */

    public function index($message = '') {

        $this->vars['message'] = $message;

        $this->vars['categories'] = Doctrine::getTable('Forum_category')->findAll();

        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method   Forum index
     * @param  $id
     * @param string $message
     * @return data to tpl
     */

    public function  category_display($id = null, $message = '') {
        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    

        $f = new Forum();
        $this->vars['forums_in_cat'] = $f->getCategoryForums($id);
        $this->vars['category'] = $f->getCategory($id);
        $this->vars['content_view'] = 'admin/forums_one_category_view';
        $this->vars['message'] = $message;

        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method    one_forum_update
     * @param  $id
     * @return data to tpl
     */

    public function  one_forum_update($id = null) {
        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }

        $f = Doctrine::getTable('Forum')->find($id);
        $c = $f->Forum_category;

        $this->vars['forum'] = $f;
        $this->vars['category'] = $c;
        $this->vars['content_view'] = '/admin/forums_one_forum_update_view';

        if ($this->input->post('title')) {

            if ($this->_forum_submit_validate() === TRUE) {

                try {

                    $f->title = $this->input->post('title');
                    $f->description = $this->input->post('description');
                    $f->save();
                    $this->category_display($c->id,   lang('dakota_updated'). nbs().   $f->title );
                    return;

                } catch (Exception $e) {

                    $this->vars['message'] =  lang('dakota_error_general');
                }

            }
            else {
                $this->vars['message'] =  lang('dakota_error_general');
            }
        }

        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method    add_forum_in_category
     * @param  $id
     * @return data to tpl
     */

    public function  add_forum_in_category($id, $message = '') {
        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    
        $f = new Forum();

        if ($this->_forum_submit_validate() === TRUE) {


            try {

                $f->title = $this->input->post('title');
                $f->description = $this->input->post('description');
                $f->category_id = $id;
                $f->save();
                redirect('/admin/forums/category_display/' . $id);
                $this->vars['message'] = lang('dakota_created') . nbs() .  $f->title  ;
            } catch (Exception $e) {
                   $this->vars['message'] =  lang('dakota_error_general');

            }
        }


        $this->vars['forums_in_cat'] = $f->getCategoryForums($id);
        $this->vars['category'] = $f->getCategory($id);
        $this->vars['content_view'] = 'admin/forums_one_category_view';

        $this->load->view('tpl/template', $this->vars);


    }


    /**
     * @method    category_create
     * @return data to tpl
     */


    public function  category_create() {

        if ($this->_cat_submit_validate() === FALSE) {
            $this->index();
            return;
        }

        try {
            $c = new Forum_category();
            $c->title = $this->input->post('title');
            $c->save();
            $this->vars['message'] = lang('dakota_created') . nbs() .  $c->title  ;


        } catch (Exception $e) {

                   $this->vars['message'] =  lang('dakota_error_general');
        }

        $this->vars['categories'] = Doctrine::getTable('Forum_category')->findAll();
        $this->vars['content_view'] = 'admin/forums_view';

        $this->load->view('tpl/template', $this->vars);

    }


    /**
     *  @method    category_create
     * @param  $id
     * @return data to tpl
     */

    public function  category_update($id = null) {
        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    
        $c = Doctrine::getTable('Forum_category')->find($id);


        $this->vars['category'] = $c;
        $this->vars['message'] = '';

        if ($this->input->post('title')) {
            if ($this->_cat_submit_validate() === FALSE) {
                $this->index();
                return;
            }
            try {

                $c->title = $this->input->post('title');
                $c->save();

                $this->index( lang('dakota_updated') . nbs() . $c->title  );
                return;

            } catch (Exception $e) {
                $this->vars['content_view'] = 'admin/forums_category_update_view';
                   $this->vars['message'] =  lang('dakota_error_general');
            }

        }
        else {

            $this->vars['content_view'] = 'admin/forums_category_update_view';
        }


        $this->load->view('tpl/template', $this->vars);

    }


    /**
     *  @method   delete  one forum
     * @param  $id
     * @return data to tpl
     */

    public function  one_forum_delete($id = null, $token = null) {

        if (! check_form_token($token)){
           return Auth::return_not_auth();
        }
        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    

        try {
            $f = Doctrine::getTable('Forum')->find($id);
            $cat_id = $f->category_id;
            $f->delete();
            redirect('/admin/forums/category_display/' . $cat_id);

        } catch (Exception $e) {

            $message =  lang('dakota_error_general') . br() . lang('dakota_error_cant_delete') . $e->getMessage();
        }
        $this->category_display($cat_id, $message);


    }


    /**
     *  @method   delete  one category
     * @param  $id
     * @return data to tpl
     */

    public function  category_delete($id = null, $token = null) {


        if (! check_form_token($token)){
           return Auth::return_not_auth();
        }
        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    

        try {
            $c = Doctrine::getTable('Forum_category')->find($id);
            $c->delete();
            $this->vars['message'] = lang('dakota_deleted');

        } catch (Exception $e) {

            //  exit($e->getMessage());

            $this->vars['message'] = lang('dakota_error_general') . br() . lang('dakota_error_cant_delete') . $e->getMessage();
        }
        $this->vars['categories'] = Doctrine::getTable('Forum_category')->findAll();
        $this->vars['content_view'] = 'admin/forums_view';

        $this->load->view('tpl/template', $this->vars);

    }

    /**_cat_submit_validate
     * @return bool
     * @method
     */
    private function _cat_submit_validate() {
        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');
        
        $this->form_validation->set_rules('title', 'title',
            'trim|required|min_length[3]');

        return $this->form_validation->run();

    }

    /**_forum_submit_validate
     * @return bool
     */
    
    private function _forum_submit_validate() {
        
        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');


        $this->form_validation->set_rules('title', 'title',
            'trim|required|min_length[3]');

        $this->form_validation->set_rules('description', 'description',
            'trim|required|min_length[10]');

        return $this->form_validation->run();

    }

}