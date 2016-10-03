<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');




echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('phpinfo').' </h3>';
echo '<div class="clear"></div>'  ;
//echo '<h4> Путь к  <i>php.ini</i> указан в строке <b>Loaded Configuration File</b> . Обратитесь к администратору, если у Вас нет туда доступа.</h4>';


  phpinfo();



echo '</div>';

