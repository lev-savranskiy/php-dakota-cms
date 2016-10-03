<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

echo '<h2>' .lang('dakota_search') . '</h2> ';


echo '<div id="search-form">';
echo form_open('/search/index/');
echo lang('dakota_search_info') . colon();
echo form_input('q');
echo form_submit('submit', 'OK');
echo form_close();
echo '</div>';

if ($query) {
    echo '<h2 style="margin: 10px 0;">' . lang('dakota_search_result') . ' "' . $query . '"</h2> ';

    $query = mb_strtolower($query, "UTF-8");

    $i = 1;
    echo '<h3>' . lang('dakota_search_found_articles') . colon() . $articles->count() . '</h3> ';
    foreach ($articles as $article) {


        echo '<div>';

        echo  $i++ . '. ' . anchor('/articles/title/' . $article->url . '/' . $query, $article->title);

        echo '</div>';


    }

    echo '<h3 style="margin-top: 30px;">' . lang('dakota_search_found_threads') . colon() .  $posts->count() . '</h3> ';

    $i = 1;

    foreach ($posts as $post) {


        echo '<div>';

        echo  $i++ . '. ' . anchor('/forums/thread/' . $post->thread_id . '/0/' . $query, $post->Thread->title);

        echo '</div>';


    }

}









