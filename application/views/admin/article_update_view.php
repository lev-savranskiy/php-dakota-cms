<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('./templates/common/init_wysiwyg.tpl');

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">  ' .  anchor('admin/articles/', lang('dakota_articles'))   . ICON_BULL .  lang('dakota_edit') .'</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('articles').' </h3>';

echo '<div class="clear">';
echo $this->session->flashdata('message');
echo validation_errors('<span class="error">', '</span>');
echo '</div>';


echo form_open('admin/articles/update/' . $article->id  );

require_once('article_form.php');

echo form_submit('submit', 'Update');
echo form_close();


echo '</div >';

?>


<script type="text/javascript" src="/templates/common/js/jquery.wysiwyg.create.js"></script>






