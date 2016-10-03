<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Search extends MY_Controller {

    public function __construct() {
        parent::__construct();



        if ( $this->input->post('q') !='' ){

            redirect("/search/index/"  .  $this->input->post('q'));
        }
            $this->vars['title'] = TITLE . colon() . lang('dakota_search');
            $this->vars['query'] = null;
    }

    /**
      * @method search
     * @param  $id
     * @return  found data
     */

    public function index($query = null, $offset = 0) {


        $query = rawurldecode($query);


        if (isset($query) && strlen($query) > 2) {


            $q = Doctrine_Query::create()
                    ->select()
                    ->from('Article a')
                    ->where('a.title LIKE ?', '%' . $query . '%')
                    ->orWhere('a.text LIKE ?', '%' . $query . '%')
                    ->andWhere('a.is_visible = ?', 1)
                    ->limit(25)
                    ;

          //  echo $q->getSqlQuery();

            $q_forum = Doctrine_Query::create()
                    ->select()
                    ->from('Post p')
                    ->where('p.content LIKE ?', '%' . $query . '%')
                    ->limit(25)
                     ;


            $this->vars['articles'] = $q->execute();
            $this->vars['posts'] = $q_forum->execute();

            $this->vars['query'] = $query;



        }

            $this->vars['content_view'] = 'search_view';

           $this->load->view('tpl/template', $this->vars);
    }


}