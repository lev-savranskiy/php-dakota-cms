<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



if (safe_count($articles)) {

    foreach ($articles as $article) {

        if ($article['found']) {

            $more_link = anchor('/articles/title/' . $article['url'],  lang('dakota_more') . '...', ' title="'.lang('dakota_more').'" class="bold" ');

            include('tpl/one_article_tpl.php');

            if ( $article['is_main']){
                    if (VK_API_ID > 0 ) {
                        require_once('./templates/common/init_vk_comments.tpl');
                    } else {
                        require_once('tpl/add_comment_tpl.php');
                    }
            };
        }

    }
}


else {
    echo '<h1>' . lang('dakota_reg_welcome') . ' &laquo;' . TITLE . '&raquo;</h1>';
    echo '<h3>' . lang('dakota_go_edit'). nbs() . anchor('/admin/', lang('dakota_admin_center') );
    echo '</h3>';

}








