<?php

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">' .lang('dakota_forums') .'</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('forums').' </h3>';
echo '<div class="clear">';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';
echo '<div class=error>' . $message . '</div>';


echo '<div id ="admin_form" >';
echo '<strong>' . lang('dakota_forums_create_cat') .'</strong>';
echo form_open('admin/forums/category_create/');
echo form_input('title',  $this->uri->segment(3) == 'category_create' ? set_value('title'): '');
echo '<br />';
echo form_submit('submit', 'OK');
echo form_close();
echo '</div>';

 echo '<h4>' . lang('dakota_forums_cats_exists') .'</h4>';

echo '<table style = "margin-top:  5px">';

echo '<tr class="table-head">';
//echo  '<td>id</td>';
echo  '<td style = "min-width:  300px">' .   lang('dakota_title') .'</td>';
echo '<td>' .   lang('dakota_actions') .'</td>';
echo '</tr>';

foreach($categories as $category){
echo '<tr>';
//echo '<td>' . $category->id . '</td>';
echo '<td>' . $category->title . '</td>';
echo '<td>';
    echo anchor_img('/admin/forums/category_display/' . $category->id, ' title="' .   lang('dakota_view') .'" ', ICON_GO);
    echo nbs(3);
    echo anchor_img('/admin/forums/category_update/' . $category->id, ' title="' .   lang('dakota_edit') .'" ', ICON_EDIT);
    echo nbs(3);

    $del_link = '/admin/forums/category_delete/' . $category->id . '/' . TOKEN ;
    echo anchor_img('#' , ' title="' .   lang('dakota_delete') .'" onclick="goConfirm(\''.$del_link.'\' ); return false; "', ICON_DELETE);

echo '</td>';
echo '</tr > ';
}
echo '</table > ';


echo '</div>';