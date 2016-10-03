<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


$comments_count = is_array($article['comments']) ? count($article['comments']) : $article['comments'];
$one_item = $this->uri->segment(2) == 'title' ? true : false;
$month_text = 'cal_' . $article['month'];


if ($article['found']) {

    $only_admin_can_see = Auth::is_admin() && !$article['is_visible'] ? true : false;


    if ($article['is_visible'] || $only_admin_can_see) {


        /* video links parser */

        //instantiate EmbeVi class
        $embevi = new Embed_Video();

        $article['text'] = $embevi->parseText($article['text'], 425, 344);
        if (!isset($article['has_query'])) {

            $article['text'] = auto_link($article['text'], 'email', TRUE);
        }


        ?>


        <div class="post">


        <?


        if ($only_admin_can_see) {

            echo "  <p class='error-border'>" . lang('dakota_article_is_hidden') . br() .
       lang('dakota_go_edit').  anchor('/admin/articles/update/' . $article['id'], lang('dakota_admin_center'))
                    . " </p>";
        }


        if (!empty($article['has_query'])) {
            echo '<h3 class="highlight">' .
                    lang('dakota_article_is_in_search_mode'). br().
                    anchor('/articles/id/' . $article['id'], lang('dakota_article_see_in_normal_mode')) . '</h3>';
        }
        ?>
            <h2 class="title">
            <? if ($one_item) {
                echo $article['title'];
            }
            else {
                echo  anchor('/articles/title/' . $article['url'], $article['title'], ' title="' . lang('dakota_article_see_full') . '" ');
            }

            ?>
            </h2>


            <p class="byline">

            <?= lang('dakota_author'). colon() . anchor('/users/id/' . $article['author_id'], $article['author_name'], ' class="notranslate" '); ?>

            </p>

            <p class="date">
                <span class="day"><?=$article['day'] ?></span>
                <span class="month"><?= lang($month_text);?></span>
                <span class="year"><?=$article['year'] ?></span>
            </p>


            <div class="entry" style="min-height: 100px;">

            <? if (isset ($more_link)) {
                echo  find_and_replace('%cut%', $more_link, $article['text']);
            } else {
                echo  str_replace('%cut%', '', $article['text']);
            }
            ?>

            </div>


            <div class="links">

            <?

            if (!$one_item) {
                echo '<p class="left">';
                echo  anchor('/articles/title/' . $article['url'], lang('dakota_article_see_full'), ' title="' . lang('dakota_article_see_full') .'" class="more" ');
                echo nbs(3);
                echo '</p>';

            }

            echo '<p class="left">';
            if ($article['can_be_commented']) {
                if (!$one_item) {


                    if (defined('VK_API_ID') && VK_API_ID > 0) {
                        echo  anchor('/articles/title/' . $article['url'] . '#comments',  lang('dakota_comments') , ' name="comments" title="'.lang('dakota_comments').'" class="comments" ');
                    }
                    else {
                        echo  anchor('/articles/title/' . $article['url'] . '#comments',  $comments_count , ' name="comments" title="'.lang('dakota_comments').'" class="comments" ');

                    }


                }
            }
            else {
                echo ' <span class="comments"> off </span>';
            }

            echo '</p>';

            echo nbs(3);

            if ($one_item) {
                if (USE_TWITTER_SHARE) {
                    echo '<p class="left" style="margin-left: 20px;">';
                    include('./templates/common/init_tweet.tpl');
                    echo '</p>';
                }

                if (VK_API_ID > 0 && isset($title)) {
                    //  include('./templates/common/init_vk_like.tpl');
                }
                if (USE_VK_SHARE) {
                    echo '<p class="left">';
                    include('./templates/common/init_vk_share.tpl');
                    echo '</p>';
                }
            }
 

            echo '<p class="left">' . nbs(3). '<a href="/rss/" class="rss">RSS</a></p>';


            echo ' </div><p class="tags"> ' . lang('dakota_tags') .colon();

            for ($i = 1;
                 $i <= 5;
                 $i++) {
                $this_tag = 'tag' . $i;
                $this_tag_i = $i + 1;
                $next_tag = 'tag' . $this_tag_i;


                if ($article[$this_tag] != '') {

                    echo  anchor('/articles/tag/' . $article[$this_tag], $article[$this_tag], ' title="'. lang('dakota_articles_by_tag') . nbs() . $article[$this_tag] . '" ');
                    if (isset($article[$next_tag]))    echo  ICON_BULL;
                }
            }

            echo ' </p>';

            if ($one_item && USE_FACEBOOK_SHARE) {
                include('./templates/common/init_facebook_like.tpl');
            }

            ?>


                <a name="comments"></a>
            </div>

        <?
    }
    else {
        echo lang('dakota_not_found');
    }

}
else {
    echo lang('dakota_not_found');
}
