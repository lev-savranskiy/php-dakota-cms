<?

$widget_info['active'] = 0;
$comments_count = 3;
$widget_info['title'] =  lang('dakota_comments_articles');
$widget_info['description'] = lang('dakota_comments_articles') .  " (" . lang('dakota_last') . " $comments_count)";
$widget_info['url'] = 'http://dakota-cms.com';
$widgets_info[] = $widget_info;


if (!defined('SHOW_WIDGET_INFO') && $widget_info['active']) {

    echo '<li id="widget_comments">';
/*------------------------  start your code here  ----------- */

    $CI = & get_instance();
    $query = $CI->db->query("SELECT * FROM dakota_comment ORDER BY created_at DESC LIMIT $comments_count");


    echo '   <h2>' .  lang('dakota_comments_articles'). '</h2> ';
    echo '  <ul>';


    $i = 0;
    foreach ($query->result() as $comment)
    {
        // TODO fix
       // if ($comment->article->is_visible) {
            echo ' <p style="margin: 5px 0;">';
            echo '<a href="/articles/id/' . $comment->article_id . '#comment' . $comment->id .'" title="' . lang('dakota_article_see_full') .'">' . strip_tags(character_limiter($comment->comment, 30)) . '</a>';
            echo ' </p>';
            $i++;
       // }

    }
    if ($i == 0) {
        echo lang('dakota_not_data_to_view');
    }
    echo ' <p>';
    echo '<a class="more" href="/articles/">' . lang('dakota_articles_back') .'</a>';
    echo ' </p>';

    echo ' </ul>';

/*------------------------  end your code here ----------- */
    echo '</li>';
}




