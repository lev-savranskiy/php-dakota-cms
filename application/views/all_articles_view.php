<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



foreach ($articles as $article) {


    if ($article['found']) {

        $more_link = anchor('/articles/title/' . $article['url'], lang('dakota_more') . '...', ' title="'.lang('dakota_more').'" class="bold" ');

        include('tpl/one_article_tpl.php');

    }



}








