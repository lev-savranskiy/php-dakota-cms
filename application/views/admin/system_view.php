<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



echo '<div id="admin-main">';

require_once('dash_menu.php');

echo '<h2 class="left">' .lang('dakota_system') . '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('system').' </h3>';

echo '<h4 class="clear">' . $message . '</h4>';

echo '	<h3>Dakota CMS</h3>';
echo '	<div>' . lang('dakota_user'). colon() . $USERDATA['user']['firstname'] . nbs() . $USERDATA['user']['lastname']   .   anchor_img('/users/update/', ' title="' . lang('dakota_my_profile').'" ', ICON_EDIT)  .  ' </div>';


echo '	<div>' .lang('dakota_version'). colon() .CMS_VERSION .  ', ' . CMS_RELEASE_DATE . '</div>';

echo '<div><script src="'.CMS_HOME. 'download.php?type=checkver&ver='. CMS_VERSION . '&lang='. LANG .'"></script></div>';


echo br();



echo '<div>' . lang('dakota_goto') .' <a href="'.CMS_HOME. '"  target=\"_blank\"> Dakota-CMS.com</a></div>';
echo '<div>' . lang('dakota_read') .'  <a href="'.CMS_HOME. 'rss/" > rss</a></div>';



echo '	<h3>System</h3>';

echo '<div>OS: ' . $SYS_OS . '</div>';
 if ($SYS_USERNAME)  echo '<div>User: ' . $SYS_USERNAME . '</div>';
 if ($SYS_USERDOMAIN)  echo '<div>Domain: ' . $SYS_USERDOMAIN . '</div>';


echo '	<h3>Server</h3>';


 if ($SERVER_SIGNATURE)  echo '<div>' . $SERVER_SIGNATURE . '</div>';        
echo '<div> PHP Version: ' . phpversion() .   anchor_img('/admin/phpinfo/', ' title="' . lang('dakota_view') .'" ', ICON_EDIT) . '</div>';
echo '<div> mysql Version: ' .  mysql_get_server_info() . anchor_img(PHP_MY_ADMIN_LINK , ' title="' . lang('dakota_view') .'" ', ICON_EDIT) .  '</div>';





echo '</div>';











