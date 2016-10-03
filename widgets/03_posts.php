<?

$comments_count = 3 ;

$widget_info['active'] = 1;
$widget_info['title'] = lang('dakota_forums_posts');
$widget_info['description'] = lang('dakota_forums_posts') .  " (" . lang('dakota_last') . " $comments_count)";
$widget_info['url'] = 'http://dakota-cms.com';
$widgets_info[] = $widget_info;


if (!defined('SHOW_WIDGET_INFO') && $widget_info['active']) {

       echo '<li id="widget_posts">';
/*------------------------  start your code here  ----------- */

    $CI = & get_instance();
    $query = $CI->db->query("SELECT * FROM dakota_forum_posts ORDER BY created_at DESC LIMIT $comments_count");


    echo '   <h2>' . lang('dakota_forums_posts') .'</h2> ';
    echo '  <ul>';


    $i = 0;
    foreach ($query->result() as $comment)
    {
         echo ' <p style="margin: 5px 0;">';
        echo '<a href="/forums/thread/' . $comment->thread_id . '#post' . $comment->id .'" title="' .lang('dakota_article_see_full') .'">' . strip_tags(character_limiter($comment->content, 30)) . '</a>';

        echo ' </p>';
        $i++;
    }
    if ($i == 0){
        echo lang('dakota_not_data_to_view');
    }
            echo ' <p>';
        echo '<a class="more" href="/forums/">'. lang('dakota_forums_back'). '</a>';
        echo ' </p>';

    echo ' </ul>';

/*------------------------  end your code here ----------- */
      echo '</li>';
}




