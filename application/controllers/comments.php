<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Comments extends MY_Controller {

    public function __construct() {
        parent::__construct();

       // if (!Auth::has_role())  Auth::return_not_auth();

    }

    /**
     * @method delete comment
     * @param  $id
     * @return void
     */

    public function delete($id = null) {

      if (is_unsigned_int($id)) {
            $c = Doctrine::getTable('Comment')->find($id, 3);

            if (($c['author_id'] == ID && ID != ANONYMOUS_ID )|| Auth::is_admin()) {
                Doctrine_Query::create()
                        ->delete('Comment c')
                        ->where('c.id = ' . $id)
                        ->execute();
            }
            redirect('/articles/id/' . $c['article_id'] . '/#comments');
        }
        else {
            redirect('/articles/');
        }

    }


    /**
     * @method add comment
     * @param  $id
     * @return void
     */


    public function add($id = null) {
       if (is_unsigned_int($id)) {
            if ($this->_submit_validate() === FALSE) {

                $this->session->set_flashdata('validation_errors', validation_errors('<span class="error">', '</span>'));
                redirect('/articles/title/' . $this->input->post('article_url') . '#comments');
                //   $this->title($this->input->post('article_url'));

            }
            else {

                $u = new Comment();
                $u->comment = $this->input->post('comment');
                $u->author_id = ID;
                $u->article_id = $id;
                $u->save();

                $this->session->set_flashdata('validation_errors', lang('dakota_added'));
                redirect('/articles/title/' . $this->input->post('article_url') . '#comments');
            }
         }
        else {
             redirect('/articles/');
        }

    }

   /**
    * @method _submit_validate
    * @return bool
    */
    private function _submit_validate() {

        $this->form_validation->set_rules('comment',lang('dakota_comment'), 'trim|required|');
        $this->form_validation->set_rules('captcha', lang('dakota_captcha'), 'trim|required|check_captcha');

        return $this->form_validation->run();

    }

}