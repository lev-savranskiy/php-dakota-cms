<?php


$has_query = strlen($this->uri->segment(5)) > 2 ? true : false;


echo '<div class="forum-category-title">';

echo anchor('/forums/', lang('dakota_forums'))     . ICON_BULL . anchor('/forums/display/' . $forum['id'], $forum['title']);

echo '</div> ';



echo '<h2>' . $thread['title'] . '</h2>';

//print_r($data);

$i = 0;
foreach ($data as $post) {

    if ($has_query && $i == 0) {

        echo '<h3 class="highlight">' .
        lang('dakota_article_is_in_search_mode'). br().
        anchor('/forums/thread/' . $thread['id'], lang('dakota_article_see_in_normal_mode')) . '</h3>';

    }


    echo '<div class="forum-post">';
    echo '<div class="byline"> ';
    echo  _create_user_link_by_user($post['User'] , ' name="post' . $post['id'] .'" ' );
     echo  nbs(2);
    if (Auth::is_admin()) {
        echo  anchor_img('/admin/users/update/' . $post['user_id'], ' title="' .lang('dakota_edit') . '"  ', ICON_EDIT);

    }
    echo  nbs(3) . $post['updated_at'] . nbs(3);

    if (($post['user_id'] == ID && ID != ANONYMOUS_ID) || Auth::is_admin()) {

        if ($i == 0) {

            $del_link = '/forums/deletethread/' . $thread['id'] . '/ '. TOKEN ;
             echo anchor_img('#' , ' title="' .lang('dakota_delete') . '" onclick="goConfirm(\''.$del_link.'\' ); return false; "', ICON_DELETE);


        }
        else {
            echo  anchor_img('/forums/deletepost/' . $post['id'], ' title="' .lang('dakota_delete') . '" ', ICON_DELETE);
        }


    }

    echo '</div> ';
    echo '<div class="entry">  ';

    if ($has_query) {

        $content = mb_strtolower(htmlspecialchars($post['content']), "UTF-8");
        $query = mb_strtolower($this->uri->segment(5), "UTF-8");
        $content = highlight_phrase($content, $query, '<span class="highlight">', '</span>');

    }
    else {
        //instantiate EmbeVi class
        $embevi = new Embed_Video();
        $content = $embevi->parseText($post['content'], 425, 344);
    }


    echo nl2br($content);
    echo '</div>';
    echo '</div>';


    if ($i == 0) {
        echo '<a name ="comments"></a>';

      if (Auth::has_role()) {
                      echo '<h3>' . lang('dakota_add_comment') . '</h3>';

      }
        else{
            echo '<h3>' . lang('dakota_add_anonymous_comment') . '</h3>';
            echo '<h3><a href ="/register/">' . lang('dakota_reg') . '</a></h3>';
        }

            require_once('./templates/common/init_ed.tpl');

            echo '<div  class="error">';
            echo validation_errors();
            echo $this->session->flashdata('validation_errors');
            echo '</div>';

            echo '<div style="margin: 10px 0 20px 0;">';
            echo form_open('/forums/addpost/');


            echo form_textarea(array(
                'name' => 'content',
                'id' => 'ed',
                'value' => set_value('content'),
                'cols' => '50',
                'rows' => '5',

            ));
            echo   form_hidden('thread_id', $thread['id']);

            echo '<p>';
            echo lang('dakota_captcha'). colon() . img('/tools/captcha/');
            echo form_input(array('name' => 'captcha', 'maxlength' => 2, 'size' => 2));
            echo '</p>';


            echo form_submit('submit', lang('dakota_add'));
            echo form_close();
            echo '</div>';

//        }
//        else {
//
//            include('tpl/comment_not_allowed.php');
//        }


    }
    $i++;
}
?>

