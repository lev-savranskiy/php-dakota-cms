<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('./templates/common/init_autocomplete_ui.tpl');

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">  ' . anchor('admin/menu/', lang('dakota_menu')) . ICON_BULL . lang('dakota_add') . '</h2>';


echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('menu') . ' </h3>';


echo '<h4 class="clear">' . $message . '</h4>';
echo validation_errors('<p class="error">', '</p>');


echo '<div  id="add_menu">';


echo form_open('admin/menu/create/');

echo '<p style="margin: 20px 0;">' . lang('dakota_menu_enter_or_select');
//echo form_dropdown('site_urls', $site_urls , '#none#',  'id="site_urls" onChange="selectMenu( $(\'#site_urls :selected\').text() , $(this).val()   );" ');

echo '<select name="site_urls" id="site_urls" onChange="selectMenu( $(\'#site_urls :selected\').text() , $(this).val()  , $(\'#site_urls :selected\').attr(\'rel\') );" >';
echo '<option value="#none#" selected="selected">-- Not Selected --</option>';

foreach ($site_urls as $k=>$v){
echo '<option value="'.$k .'" rel="' . $v['lang'] . '">' . $v['title'] . '</option>';
}


echo '</select> ';

echo '  </p> ';


echo '	<p>' . lang('dakota_title') . ':  <br />';
echo form_input('title', '', ' style="width:400px;" id="menu_title" ');
echo '</p>';

echo '	<p>' . lang('dakota_link') . lang('dakota_menu_link_info') . ' : <br />';
echo form_input('url', '/', ' style="width:400px;" id="menu_url"  ');
echo '</p>';


echo '	<p>' . lang('dakota_menu_where_to_add') . ' <br />';
echo form_dropdown('parent_id', $menu_prepared);
echo '</p>';
echo form_submit('submit', lang('dakota_add'));
echo form_reset('reset', lang('dakota_reset'));

echo form_close();
echo '</div >';


echo '</div>';











