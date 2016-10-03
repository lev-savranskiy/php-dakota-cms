<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


require_once('tpl/one_article_tpl.php');

if ($article['found'] && $article['can_be_commented']) {

    if (VK_API_ID > 0 ) {
        require_once('./templates/common/init_vk_comments.tpl');
    } else {
        require_once('tpl/add_comment_tpl.php');
    }


}















