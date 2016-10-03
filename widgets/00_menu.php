<?


$widget_info['active'] = 0;
$widget_info['title'] = lang('dakota_menu');
$widget_info['description'] = lang('dakota_menu_vertical');
$widget_info['url'] = 'http://dakota-cms.com';
$widgets_info[] = $widget_info;




if (!defined('SHOW_WIDGET_INFO') && $widget_info['active']) {

/*------------------------  start your code here  ----------- */
echo ' <li id="widget_menu" ><h2>' . lang('dakota_menu') . '</h2>' .  MENU . '</li>';
// end your code here
}

