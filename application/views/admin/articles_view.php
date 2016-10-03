<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">' . lang('dakota_articles') .'</h2>';
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('articles').' </h3>';
echo '<a class="clear create-button" href="/admin/articles/add/" title="' . lang('dakota_create') .'">' . lang('dakota_create') .'</a>';

echo '<div>';
echo $this->session->flashdata('message');
echo validation_errors('<span class="error">', '</span>');
echo '</div>';

echo '<table  id="articles-table">';

echo '<tr class="table-head" >';
echo '<td>' . lang('dakota_title') .'</td>';
echo '<td>' . lang('dakota_created') .'</td>';
echo '<td>' . lang('dakota_show_on_site') .'</td>';
echo '<td>' . lang('dakota_article_is_main') .'</td>';
echo '<td>' . lang('dakota_article_is_news') .'</td>';
echo '<td>' . lang('dakota_comments') .'</td>';
echo '<td>' . lang('dakota_actions') .'</td>';
echo '</tr>';

foreach ($articles as $article) {

    $is_news = !$article->is_page;
    $formatted_date = format_to_words( $article->created_at );


    echo '<tr style="">';

    echo '<td width="30%" class="text-left">' . anchor('/articles/title/' . $article->url, $article->title, ' title="' . lang('dakota_see_on_site') .'" target="_blank" ') . '</td>';

    if (safe_count($formatted_date)> 0){
       echo '<td width="20%" class="small">' . $formatted_date[0]  . ', '.  $formatted_date[1] . '</td>';

    }
    else{
       echo '<td width="20%" class="small">' . $article->created_at . '</td>';    
    }




/*
     *  TAGS ARE OFF
    echo '<td style = "max-width:500px;">';
    for ($i = 1; $i <= 5; $i++) {
        $this_tag = 'tag' . $i;
        if ($article->$this_tag != '') {
             //       echo $i . ' ';
            echo ICON_BULL;
            echo  anchor('/articles/tag/' . $article->$this_tag, $article->$this_tag, ' title="View (new tab)" target="_blank" ');

            //  echo '<br />';
        }
    }
    echo '</td>';
*/


    echo '<td width="8%">' . img(TEMPLATES_FOLDER . 'common/img/icon_' . $article->is_visible . '.png') . '</td>';
    echo '<td width="8%">' . img(TEMPLATES_FOLDER . 'common/img/icon_' . $article->is_main . '.png') . '</td>';
    echo '<td width="8%">' . img(TEMPLATES_FOLDER . 'common/img/icon_' . $is_news . '.png') . '</td>';

    if ($article->can_be_commented * 1) {

        $comments = count($article->Comments);

    } else {

       // $comments = img(TEMPLATES_FOLDER . 'common/img/icon_0.png', ' title = "off" ');
        $comments = lang('dakota_off') ;
    }

    echo '<td width="8%">' . $comments . '</td>';
    echo '<td width="20%">';

    echo anchor_img('admin/articles/update/' . $article->id, ' title="'  . lang('dakota_edit') . '" ', ICON_EDIT);
    echo nbs(4);
    $del_link = '/admin/articles/delete/' . $article->id . '/' . TOKEN ;
    echo anchor_img('#' , ' title="'  . lang('dakota_delete') . '" onclick="goConfirm(\''.$del_link.'\' ); return false; "', ICON_DELETE);


    echo '</td >';
    echo '</tr > ';


}

echo '</table > ';
echo '</div >';





