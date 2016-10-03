<?php

echo '<div id="admin-main">';

require_once('dash_menu.php');

echo '<h2 class="left">  ' .  anchor('admin/forums/', lang('dakota_forums')) . ICON_BULL  . anchor('/admin/forums/category_display/' . $category->id, ' ' . $category->title . ' ') . ICON_BULL .  lang('dakota_edit') .'</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('forums').' </h3>';
echo '<div class="clear"></div>';
echo '<br/ >';
echo '<div>';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';
echo '<div class=error>' . $message . '</div>';
echo '<strong>' .  lang('dakota_edit') .'</strong> &laquo;'  . $forum->title .'&raquo; ';

echo '<div id ="admin_form" >';

echo form_open('admin/forums/one_forum_update/' .  $forum->id);

echo  lang('dakota_title');
echo '<br/ >';
echo form_input('title', set_value('title') ?  set_value('title'): $forum->title);
echo '<br/ >';
echo  lang('dakota_descr');
echo  br();
echo form_textarea('description', set_value('description') ?  set_value('description'): $forum->description );

echo '<br/ >';
echo form_submit('submit', 'OK');
echo form_close();
echo '</div>';

echo '</div>';