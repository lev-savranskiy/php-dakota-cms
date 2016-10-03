<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

      if (Auth::has_role()) {
                      echo '<h3>' . lang('dakota_add_comment') . '</h3>';

      }
        else{
            echo '<h3>' . lang('dakota_add_anonymous_comment') . '</h3>';
            echo '<h3><a href ="/register/">' . lang('dakota_reg') . '</a></h3>';
        }

        echo '<div  class="error">';
        echo validation_errors();
        echo $this->session->flashdata('validation_errors');
        echo '</div>';


        echo '<div style="margin: 10px 0 20px 0;">';
        echo form_open('/comments/add/' . $article['id']);


        echo       form_textarea(array(
            'name' => 'comment',
            'id' => 'comment',
            'value' => set_value('comment'),
            'cols' => '50',
            'rows' => '5',

        ));
        echo   form_hidden('article_url', $article['url']);

        echo '<p>';
        echo lang('dakota_captcha'). colon() . img('/tools/captcha/');
        echo form_input(array('name' => 'captcha', 'maxlength' => 2, 'size' => 2));
        echo '</p>';


        echo form_submit('submit', lang('dakota_add'));
        echo form_close();
        echo '</div>';



    if (is_array($article['comments'])) {

        foreach ($article['comments'] as $comment) {

            echo    '<div class ="author_info">';
            echo    $comment['author_link'];
               if (Auth::is_admin()) {
                echo  anchor_img('/admin/users/update/' . $comment['author_id'], ' title="' . lang('dakota_edit') . '" ', ICON_EDIT);

            }
            echo  nbs(). lang('dakota_commenting') . ' ...   ';
            echo    '<small>' . $comment['updated_at'] . '</small>';



            if (($comment['author_id'] == ID && ID != ANONYMOUS_ID ) || Auth::is_admin()) {

                echo  anchor_img('/comments/delete/' . $comment['id'], ' title ="' . lang('dakota_delete') . '"', ICON_DELETE);
            }


            echo  '</div>';


            echo    '<div style="margin:5px 0 15px 0;">';
            echo    $comment['comment'];
            echo    '</div>';
        }
    }