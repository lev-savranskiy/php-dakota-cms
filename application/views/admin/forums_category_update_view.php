<?php

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">  ' .  anchor('admin/forums/',   lang('dakota_forums') )   . ICON_BULL . nbs() .  lang('dakota_edit') . '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('forums').' </h3>';




echo '<div class="clear">';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';

echo '<div id ="admin_form" >';
echo '<div class=error>' . $message . '</div>';
echo '<strong> ' .  lang('dakota_edit') . '</strong>';
echo form_open('admin/forums/category_update/' .  $category->id);
if ($this->input->post('title'))   {
echo form_input('title', set_value('title'));
}
else{
echo form_input('title', $category->title);        
}
echo '<br />';
echo form_submit('submit', 'OK');
echo form_close();
echo '</div>';

echo '</div>';