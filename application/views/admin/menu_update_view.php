<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('./templates/common/init_autocomplete_ui.tpl');

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">  ' .  anchor('admin/menu/', lang('dakota_menu'))   . ICON_BULL .  lang('dakota_edit') .'</h2>'  ;


echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('menu').' </h3>';

echo '<h4 class="clear">' . $message . '</h4>';
echo validation_errors('<p class="error">', '</p>');


echo '<div  id="add_menu">'  ;



echo form_open('admin/menu/change/' .  $element['id']);




echo '	<p>' . lang('dakota_title') . ':  <br />';
echo form_input('title',  $element['title'] , ' style="width:400px;" id="menu_title" ');
echo '</p>';

echo '	<p>' . lang('dakota_link') . ' ' . lang('dakota_menu_link_info') .' : <br />';
echo form_input('url',  $element['url']  , ' style="width:400px;" id="menu_url"  ');
echo '</p>';


echo '	<p>';
//echo '	<p>Куда добавлен пункт? <br />';
//echo form_dropdown('parent_id', $menu_prepared , $element['parent_id']);
if ($element['parent_id']> 0 ){
  echo  lang('dakota_el_in_section') ;
}

   echo   $menu_prepared[$element['parent_id']];     



echo '</p>';
echo form_submit('submit', 'OK');


echo form_close();
echo '</div >'  ;




echo '</div>';











