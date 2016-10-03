<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('./templates/common/init_autocomplete_ui.tpl');

echo '<div id="admin-main">';

require_once('dash_menu.php');

echo '<h2 class="left">' .lang('dakota_menu') . '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('menu').' </h3>';

echo '<h4 class="clear">' . $message . '</h4>';
echo validation_errors('<p class="error">', '</p>');


echo '<a class="clear create-button" href="/admin/menu/add/" title="' .lang('dakota_create') . '">' .lang('dakota_create') . '</a>';

echo '<h3>' . lang('dakota_menu_el_list') .'</h3>'  ;

echo '<ul>';
echo $menu_prepared_ul;
echo '</ul>';
echo '</div>';











