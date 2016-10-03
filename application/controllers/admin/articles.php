<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */


class Articles extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())  Auth::return_not_auth();


        $a = new Article();
        $this->vars['availableTags'] = $a->get_tags();
        $this->vars['title'] = TITLE_AC .  lang('dakota_articles');
    }


    /**
     * @method   Admin Articles index
     * @param int $offset
     * @param  $message
     * @return data to tpl
     */


    public function index($offset = 0, $message = null) {


        $limit = 10;
        $this->vars['articles'] = Doctrine_Query::create()
                ->select('*')
                ->from('Article')
                ->limit($limit)
                ->offset($offset)
                ->execute();

        $a = new Article();

        $this->vars['total'] = $a->total();


        if ($this->vars['total'] > $limit) {
            $config['base_url'] = base_url() . "admin/articles/index/";
            $config['total_rows'] = $this->vars['total'];
            $config['per_page'] = $limit;
            $config['uri_segment'] = 4;
            $this->pagination->initialize($config);
            $this->vars['pagination'] = $this->pagination->create_links();
        }


        $this->vars['content_view'] = 'admin/articles_view';


        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method   Admin Articles add
     * @param string $type
     * @return data to tpl
     */


    public function add($type = 'wysiwyg') {
        $this->vars['content_view'] = 'admin/article_add_view';

        $this->vars['type'] = $type;


        $this->vars['form_data'] = array(
            'title' => set_value('title'),
            'text' => set_value('text'),
            'url' => set_value('url'),
            'tag1' => set_value('tag1'),
            'tag2' => set_value('tag2'),
            'tag3' => set_value('tag3'),
            'tag4' => set_value('tag4'),
            'tag5' => set_value('tag5'),
            'is_visible' => set_value('is_visible'),
            'is_main' => set_value('is_main'),
            'is_page' => set_value('is_page'),
            'can_be_commented' => set_value('can_be_commented')
        );

        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method   Admin Articles create new
     * @return data to tpl
     */

    public function create() {

        if ($this->_submit_validate() === FALSE) {
            $this->add();
            return;
        }

            // reset previuos main page

            if ($this->input->post('is_main') == 1) {

                Doctrine_Query::create()
                        ->update('article')
                        ->set('is_main', 0)
                        ->where('is_main  = 1  ')
                        ->execute();

            }


        $u = new Article();
        $u->title = $this->input->post('title');
        $u->text = $this->input->post('text', FALSE);
        $u->url = $this->input->post('url') != '' ? url_title_rus($this->input->post('url')) : url_title_rus($u->title);
        $u->tag1 = prepare_tag($this->input->post('tag1'));
        $u->tag2 = prepare_tag($this->input->post('tag2'));
        $u->tag3 = prepare_tag($this->input->post('tag3'));
        $u->tag4 = prepare_tag($this->input->post('tag4'));
        $u->tag5 = prepare_tag($this->input->post('tag5'));
        $u->is_main = trim($this->input->post('is_main'));
        $u->is_visible = trim($this->input->post('is_visible'));
        $u->is_page = trim($this->input->post('is_page'));
        $u->can_be_commented = trim($this->input->post('can_be_commented'));
        $u->author_id = ID;
        $u->save();



        $this->session->set_flashdata('message',  lang('dakota_created'));
        redirect('/admin/articles/');


    }

    /**
     * @method   Admin Articles create new
     * @param  $id
     * @param string $type
     * @return data to tpl
     */


    public function update($id = null, $type = 'wysiwyg') {

        if (!is_unsigned_int($id)) {
            return Auth::return_wrong_data();
        }

        if ($this->input->post('url')) {

            if ($this->_update_validate() === FALSE) {
                $this->index();
                return;
            }


            $url = url_title_rus($this->input->post('url'));


            // reset previuos main page

            if ($this->input->post('is_main') == 1) {

                Doctrine_Query::create()
                        ->update('article')
                        ->set('is_main', 0)
                        ->where('is_main  = 1  ')
                        ->execute();

            }


            Doctrine_Query::create()
                    ->update('article')
                    ->set('title', '?', $this->input->post('title'))
                    ->set('url', '?', $url)
                    ->set('text', '?', trim($this->input->post('text')))
                    ->set('tag1', '?', prepare_tag($this->input->post('tag1')))
                    ->set('tag2', '?', prepare_tag($this->input->post('tag2')))
                    ->set('tag3', '?', prepare_tag($this->input->post('tag3')))
                    ->set('tag4', '?', prepare_tag($this->input->post('tag4')))
                    ->set('tag5', '?', prepare_tag($this->input->post('tag5')))
                    ->set('is_main', '?', trim($this->input->post('is_main')))
                    ->set('is_visible', '?', trim($this->input->post('is_visible')))
                    ->set('is_page', '?', trim($this->input->post('is_page')))
                    ->set('can_be_commented', '?', trim($this->input->post('can_be_commented')))
                    ->where('id  = ' . $id)
                    ->execute();

        $this->session->set_flashdata('message',  lang('dakota_updated'));
        redirect('/admin/articles/update/' . $id);
        }
        else {


            $this->vars['type'] = $type;
            $this->vars['article'] = Doctrine::getTable('article')->find($id);
            $this->vars['content_view'] = 'admin/article_update_view';

            $this->vars['form_data'] = array(
                'title' => $this->vars['article']->title,
                'text' => $this->vars['article']->text,
                'url' => $this->vars['article']->url,
                'tag1' => $this->vars['article']->tag1,
                'tag2' => $this->vars['article']->tag2,
                'tag3' => $this->vars['article']->tag3,
                'tag4' => $this->vars['article']->tag4,
                'tag5' => $this->vars['article']->tag5,
                'is_main' => $this->vars['article']->is_main,
                'is_visible' => $this->vars['article']->is_visible,
                'is_page' => $this->vars['article']->is_page,
                'can_be_commented' => $this->vars['article']->can_be_commented,
            );

            $this->load->view('tpl/template', $this->vars);

        }


        //  redirect('/admin/users/');
    }


    /**
     * @method   Admin Articles delete
     * @param  $id
     * @return data to tpl
     */


    public function delete($id, $token = null) {

        if (!is_unsigned_int($id))  redirect('/admin/articles/');
        if (!check_form_token($token)) return Auth::return_not_auth();


        Doctrine_Query::create()
                ->delete('Article a')
                ->where('a.id = ' . $id)
                ->execute();

        redirect('/admin/articles/');
    }


    /**
     * @method  _submit_validate
     * @return bool
     */

    private function _submit_validate() {

        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');
        // validation rules
        $this->form_validation->set_rules('title', 'title',
            'trim|required|');

        $this->form_validation->set_rules('text', 'text',
            'trim|required|min_length[10]');


        $this->form_validation->set_rules('url', 'url',
            'trim|unique[Article.url]');

        $this->form_validation->set_rules('tag1', 'tag1',
            'trim|required');

        $this->form_validation->set_rules('is_main', 'is_main',
            'trim|matches[is_visible]');
        return $this->form_validation->run();

    }

    /**
     * @method  _update_validate
     * @return bool
     */

    private function _update_validate() {

        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');

        // validation rules
        $this->form_validation->set_rules('title', 'title',
            'trim|required|');

        $this->form_validation->set_rules('text', 'text',
            'trim|required|min_length[10]');


        $this->form_validation->set_rules('url', 'url',
            'trim|required');

        $this->form_validation->set_rules('tag1', 'tag1',
            'trim|required');

    

        $this->form_validation->set_rules('is_main', 'is_main',
            'trim|matches[is_visible]');

        return $this->form_validation->run();

    }


}