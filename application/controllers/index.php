<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */

class Index extends MY_Controller {


    public function __construct() {
        parent::__construct();

    }

    /**
     * @method   read  1 main article (if set)  or 3 normal articles
     * @method   if lang set - stores lang
     * @return data to tpl
     */

    public function index($lang = null) {

        $a = new Article();
        $articles_all = $a->get_main();

        if (!isset($articles_all[0]['url'])) {

            $articles_all = $a->get_articles(3, 0);
        }

        $this->vars['articles'] = array();
        foreach ($articles_all as $article_found) {


            $a = $this->_prepare_article($article_found);

            if ($a['can_be_commented']) {
                $a['comments'] = $this->_find_comments($a['id'], true);
            }

            $this->vars['articles'][] = $a;

        }

        $this->vars['content_view'] = 'index_view';
        $this->vars['title'] = TITLE . colon() . lang('dakota_main');
        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method  set user language
     * @return rediret
     */

    public function lang($lang = 'russian') {

        //     session_start();
        if (dakota_pref_language_exists($lang)) {
            $_SESSION['dakota_pref_language'] = $lang;
            redirect('/');
        }
        else {
            exit("Language " . $lang . " not found");
        }


    }


}

