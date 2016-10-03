<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Forums extends MY_Controller {

    public function __construct() {
        parent::__construct();
   //define('HIDE_SIDEBAR', true);
    }


    /**
     * @method get categories data
     * @return void
     */

    public function index() {
        $f = new Forum();

        $this->vars['categories'] = $f->getCategoryList();

        $this->vars['title'] = TITLE . colon()  . lang('dakota_forums');

        $this->vars['content_view'] = 'all_forums_view';

        $this->vars['site_thread_cases'] = $this->config->item('site_thread_cases');

        $this->load->view('tpl/template', $this->vars);
    }

    /***
     * @method get forums array
     * @param  $id
     * @param int $offset
     * @return data
     */

    public function display($id = null, $offset = 0) {

        if (is_unsigned_int($id)) {

            $limit = 20;

            $forum = Doctrine::getTable('Forum')->find($id);
            if (!isset ($forum['title'])) {
                redirect('/forums/');
            }

            $this->vars['title'] = TITLE . colon() . $forum['title'];

            $this->vars['threads'] = $forum->getThreadsArray(
                $offset,
                $limit
            );

            // $this->vars['category'] = $forum->getCategory($forum->category_id);
            $this->vars['forum'] = $forum;


            $this->vars['content_view'] = 'one_forum_view';
            $this->vars['site_replies_cases'] = $this->config->item('site_replies_cases');

            $num_threads = $forum->numThreads();

            // do we have enough to paginate
            if ($num_threads > $limit) {
                // PAGINATION
                $this->load->library('pagination');
                $config['base_url'] = base_url() . "forums/display/$id";
                $config['total_rows'] = $num_threads;
                $config['per_page'] = $limit;
                $config['uri_segment'] = 4;
                $this->pagination->initialize($config);

                $this->vars['pagination'] = $this->pagination->create_links();
            }

            $this->load->view('tpl/template', $this->vars);
        }

        else {
            redirect('/forums/');
        }

    }

    /**
     * @method get posts array
     * @param int  $id
     * @param int $offset
     * @param str $query
     * @return data
     */

    public function thread($id = null, $offset = 0, $query = null) {
        if (is_unsigned_int($id)) {
            $limit = 10;
            $thread = Doctrine::getTable('Thread')->find($id);

            if (!isset ($thread['title'])) {
                redirect('/forums/');
            }




            $this->vars['forum'] = $thread->Forum;

            $num_posts = $thread->numPosts();

            $this->vars['title'] = TITLE . colon() . $thread['title'];
            $this->vars['thread'] =  $thread;

            $this->vars['first_post'] = $thread->getFirstPost();


            $data = $thread->getPostsArray(
                $offset,
                $limit
            );



            // do we have enough to paginate
            if ($num_posts > $limit) {
                // PAGINATION
                $this->load->library('pagination');
                $config['base_url'] = base_url() . "forums/thread/$id";
                $config['total_rows'] = $num_posts;
                $config['per_page'] = $limit;
                $config['uri_segment'] = 4;
                $this->pagination->initialize($config);

                $this->vars['pagination'] = $this->pagination->create_links();
            }

  
            if ($offset >= $limit) {
              array_unshift( $data , $this->vars['first_post'][0]);
            }



            $this->vars['data'] =$data;
            $this->vars['content_view'] = 'one_thread_view';

//            print_r( $this->vars['first_post']  );
//            print_r( '<hr/>' );
//            print_r( $data  );


            $this->load->view('tpl/template', $this->vars);
        }
        else {
            redirect('/forums/');
        }
    }


    /**
     * @method  post addthread
     * @param int  $forum_id
     * @return validation_errors
     */


    public function addthread($forum_id = null) {

        if (is_unsigned_int($forum_id)) {


            if (!Auth::has_role()) return Auth::return_not_auth();


            $this->vars['content_view'] = 'add_thread_view';
            $this->vars['title'] = TITLE . colon() .lang('dakota_forums_create_topic') ;
            $this->vars['forum'] = Doctrine::getTable('Forum')->find($forum_id);

            if (!isset ($this->vars['forum']['title'])) {
                redirect('/forums/');
            }


            if ($this->_submit_validate('thread') === FALSE) {
                $this->session->set_flashdata('validation_errors', validation_errors('<span class="error">', '</span>'));

            }
            else {

                $t = new Thread();
                $t->title = $this->input->post('title');
                $t->forum_id = $forum_id;
                $t->save();

                $p = new Post();

                $p->thread_id = $t->id;
                $p->user_id = ID;
                $p->content = $this->input->post('content');
                $p->save();

                $this->session->set_flashdata('validation_errors', lang('dakota_forums_topic_created'));

                redirect('/forums/thread/' . $t->id);

            }

            $this->load->view('tpl/template', $this->vars);
        } else {
            redirect('/forums/');
        }

    }


    /**
     * @method  post addpost
     * @return validation_errors
     */


    public function addpost() {

       // if (!Auth::has_role()) return Auth::return_not_auth();

        if ($this->_submit_validate() === FALSE) {

            $this->session->set_flashdata('validation_errors', validation_errors('<span class="error">', '</span>'));

        }
        else {

            $u = new Post();
            $u->content = $this->input->post('content');
            $u->user_id = ID  ;
            $u->thread_id = $this->input->post('thread_id');


            $u->save();

            $this->session->set_flashdata('validation_errors', lang('dakota_forums_comment_created'));

        }
        redirect('/forums/thread/' . $this->input->post('thread_id') . '#comments');

    }

    /**
     * @method   delete post
     * @return validation_errors
     */


    public function deletepost($id = null) {
        if (is_unsigned_int($id)) {
            $p = Doctrine::getTable('Post')->find($id);

            if (($p['user_id'] == ID && ID != ANONYMOUS_ID )|| Auth::is_admin()) {
                $p->destroy();
            }
            redirect('/forums/thread/' . $p['thread_id'] . '/#comments');
        }
        else {
            redirect('/forums/');
        }

    }


    /**
     * @method  delete thread
     * @return validation_errors
     */


    public function deletethread($id = null, $token = null) {

        if (! check_form_token($token)) return Auth::return_not_auth();
        if (is_unsigned_int($id)) {
            $thread = Doctrine::getTable('Thread')->find($id);
            $firstPost = $thread->firstPost();

            if (($firstPost['user_id'] == ID &&  ID != ANONYMOUS_ID )|| Auth::is_admin()) {

                $thread->destroy();

            }
        }
        redirect('/forums/');

    }

    /**
     * @param string $type
     * @return boolean
     */
    private function _submit_validate($type = 'post') {
        


        if ($type == 'thread') {
             $this->form_validation->set_rules('token', 'token',        'required|check_referer|check_token');
            $this->form_validation->set_rules('title', lang('dakota_forums_topic'), 'trim|required|min_length[3]|max_length[80]');
        }

        $this->form_validation->set_rules('content', lang('dakota_message'), 'trim|required|min_length[10]');
        $this->form_validation->set_rules('captcha', lang('dakota_captcha'), 'trim|required|check_captcha');

        return $this->form_validation->run();

    }

}