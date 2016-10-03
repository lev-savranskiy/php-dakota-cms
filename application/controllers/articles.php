<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Articles extends MY_Controller {

    public function __construct() {
        parent::__construct();

    }

    /**
     * @method articles list
     * @param  int $offset
     * @return data to tpl
     */

    public function index($offset = 0) {
        $this->output->cache(CACHE_TTL);
        $limit = 5;

        $a = new Article();

        $this->vars['total'] = $a->total_articles();
        $articles_all = $a->get_articles($limit, $offset);


        if ($this->vars['total'] > $limit) {
            $config['base_url'] = base_url() . "articles/index/";
            $config['total_rows'] = $this->vars['total'];
            $config['per_page'] = $limit;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $this->vars['pagination'] = $this->pagination->create_links();
        }

        $this->vars['articles'] = array();
        foreach ($articles_all as $article_found) {

            if (!$article_found['is_page']) {

                $a = $this->_prepare_article($article_found);

                if ($a['can_be_commented']) {
                    $a['comments'] = $this->_find_comments($a['id'], true);
                }

                $this->vars['articles'][] = $a;
            }
        }

        $this->vars['content_view'] = 'all_articles_view';
        $this->vars['title'] = TITLE . colon() . lang('dakota_articles');
        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method articles by tag
     * @param  str $tag
     * @return data to tpl
     */


    public function tag($tag = null) {
        $this->output->cache(CACHE_TTL);
        if (isset($tag)) {
            $tag = rawurldecode($tag);

            $q = Doctrine_Query::create()
                    ->select()
                    ->from('Article a')
                    ->where('a.tag1 = ?', $tag)
                    ->orWhere('a.tag2 = ?', $tag)
                    ->orWhere('a.tag3 = ?', $tag)
                    ->orWhere('a.tag4 = ?', $tag)
                    ->orWhere('a.tag5 = ?', $tag)
                    ->setHydrationMode(3);

            //  echo $q->getSqlQuery();

            $articles_all = $q->execute();

            $this->vars['articles'] = array();
            foreach ($articles_all as $article_found) {

                $a = $this->_prepare_article($article_found);

                if ($a['can_be_commented']) {
                    $a['comments'] = $this->_find_comments($a['id'], true);
                }

                $this->vars['articles'][] = $a;

            }

            //   var_dump($article_found)  ;

            $this->vars['content_view'] = 'all_articles_view';

            $this->vars['title'] = TITLE . colon() . lang('dakota_articles') . lang('dakota_in_category') . $tag;


            $this->load->view('tpl/template', $this->vars);

        }
        else {
            redirect('/articles/');
        }

    }

    /**
     * @method one article by title
     * @param  str $url
     * @param  str $query
     * @return data to tpl
     */


    public function title($url = null , $query = null) {

        $this->vars['article']['found'] = false;
        $this->vars['content_view'] = 'one_article_view';
        $article_found['comments'] = array() ;

        if (isset($url)) {

            $article_found = Doctrine::getTable('Article')->findOneByUrl($url, 3);
            $article_found = $this->_prepare_article($article_found , $query);


            if (isset($article_found['can_be_commented'])) {
                $article_found['comments'] = $this->_find_comments($article_found['id']);

                // cache if  can not be commented
                if (! $article_found['can_be_commented']){
                 $this->output->cache(CACHE_TTL);
                }

            }


            $this->vars['article'] = $article_found;
             if (isset($article_found['title'])) {
                 $this->vars['title'] .= colon() . $article_found['title'];
            }

        }
        else {
            redirect('/articles/');
        }
        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method one article by $id
     * @param  $id
     * @return data to tpl
     */


    public function id($id = null) {

        $this->vars['article']['found'] = false;
        $this->vars['content_view'] = 'one_article_view';
        $this->vars['title'] = TITLE;

        if (isset($id)) {

            $article_found = Doctrine::getTable('Article')->find($id, 3);
            $article_found = $this->_prepare_article($article_found);

            if (isset($article_found['can_be_commented'])) {
                $article_found['comments'] = $this->_find_comments($article_found['id']);

                // cache if  can not be commented
                if (! $article_found['can_be_commented']){
                 $this->output->cache(CACHE_TTL);
                }
            }

            $this->vars['article'] = $article_found;

             if (isset($article_found['title'])) {
                 $this->vars['title'] .=  colon() . $article_found['title'];
            }
        }
        else {
            redirect('/articles/');
        }

        $this->load->view('tpl/template', $this->vars);

    }


}