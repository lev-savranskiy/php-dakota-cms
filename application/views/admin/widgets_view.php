<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">' .lang('dakota_widgets') . '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('widgets').' </h3>';


echo '<h4 class="clear">' . lang('dakota_widget_info').  anchor_help('widgets').' </h4>'  ;

if (safe_count($widgets) > 0){

echo '<table style = "margin-top:  10px">';

echo '<tr class="table-head">';

    echo  '<td>' . lang('dakota_title') . '</td>';
    echo  '<td>' . lang('dakota_descr') . '</td>';
    echo  '<td>' . lang('dakota_developer') . '</td>';
    echo  '<td>' . lang('dakota_active') . '</td>';

echo '</tr>';



foreach ($widgets as $widget) {

    echo '<tr>';
    echo '<td>' . $widget['title'] . '</td>';
    echo '<td class="small">' .  $widget['description']  . '</td>';
    echo '<td><a href ="' .  $widget['url']  . '" target="_blank">'.$widget['url']. '</a></td>';
    echo '<td>' . img(TEMPLATES_FOLDER . 'common/img/icon_' . $widget['active']  *1 . '.png')   . '</td>';


    echo '</td >';
    echo '</tr > ';

}



echo '</table > ';

}
else{
 echo '<p class="error">' . lang('dakota_not_data_to_view') . '<p>';
}



echo '</div>';

