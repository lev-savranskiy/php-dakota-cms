<?php

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">  ' .  anchor('admin/forums/',  lang('dakota_forums'))   . ICON_BULL .  lang('dakota_edit') . '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('forums').' </h3>';

echo '<div class="clear">';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';
echo '<div class=error>' . $message . '</div>';


echo '<strong> ' .lang('dakota_create') . nbs() .  lang('dakota_forums') . nbs() .  lang('dakota_in_category') . ' "' . $category->title  . '"</strong>';

echo '<br/ >';
echo '<br/ >';
echo '<div id ="admin_form" >';
echo form_open('admin/forums/add_forum_in_category/' . $category->id );
echo  lang('dakota_title');
echo '<br/ >';
echo form_input('title', $this->uri->segment(3) == 'add_forum_in_category'  ?  set_value('title') :'' );
echo '<br/ >';
echo  lang('dakota_descr');
echo '<br/ >';

echo form_textarea('description', $this->uri->segment(3) == 'add_forum_in_category'  ?  set_value('description') : '');
echo '<br/ >';
echo form_submit('submit', 'OK');
echo form_close();
echo '</div>';


echo '<br/ >';
echo '<br/ >';
echo '<strong>'. lang('dakota_forums_exists')   . nbs() .  lang('dakota_in_category') . ' "'. $category->title  . '"</strong>';

echo '<table style = "margin-top:  30px">';

echo '<tr class="table-head">';
//echo  '<td>id</td>';
echo  '<td >' .lang('dakota_title') .'</td>';
echo  '<td style = "min-width:  300px">' .lang('dakota_descr') .'</td>';
echo '<td>' .lang('dakota_actions') .'</td>';
echo '</tr>';


foreach($forums_in_cat as $forum_in_cat){
    

echo '<tr>';
//echo '<td>' . $forum_in_cat['id']. '</td>';
echo '<td><b>' . $forum_in_cat['title'] . '</b></td>';
echo '<td>' . $forum_in_cat['description'] . '</td>';
echo '<td>';
    echo anchor_img('/forums/display/' . $forum_in_cat['id'] , ' title="' . lang('dakota_see_on_site') .'"  target="_blank" ', ICON_GO);
    echo nbs(3);
    echo anchor_img('admin/forums/one_forum_update/' . $forum_in_cat['id'] , ' title="' . lang('dakota_edit') .'" ', ICON_EDIT);
    echo nbs(3);

    $del_link = '/admin/forums/one_forum_delete/' . $forum_in_cat['id'] . '/' . TOKEN ;
    echo anchor_img('#' , ' title="' . lang('dakota_delete') .'" onclick="goConfirm(\''.$del_link.'\' ); return false; "', ICON_DELETE);

echo '</td>';
echo '</tr > ';
}
echo '</table > ';
echo '</div>';