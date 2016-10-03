<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

 require_once('./templates/common/init_wysiwyg.tpl');

echo '<div id="admin-main">';

require_once('dash_menu.php');

echo '<h2 class="left">  ' .  anchor('admin/articles/', lang('dakota_articles'))   . ICON_BULL . lang('dakota_create') .  '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('articles').' </h3>';

echo '<div class="clear" style="margin-top:10px;">';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';



echo form_open('admin/articles/create/'  );

require_once('article_form.php');

echo form_submit('submit', 'OK');
echo form_close();


  echo '</div>';
?>

<script type="text/javascript" src="/templates/common/js/jquery.wysiwyg.create.js"></script>