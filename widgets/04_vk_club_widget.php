<?


$widget_info['active'] = VK_API_WIDGET_CLUB_ID > 0 ? 1 : 0;
$widget_info['title'] = 'Vkontakte';
$widget_info['description'] = 'Community widget';
$widget_info['url'] = 'http://vkontakte.ru/developers.php?o=-1&p=Groups';
$widgets_info[] = $widget_info;


if (!defined('SHOW_WIDGET_INFO') && $widget_info['active']) {

  //  echo '<script type="text/javascript" src="http://vkontakte.ru/js/api/openapi.js" charset="windows-1251"></script>';
    echo '<li id="widget_vk_club" style="min-height: 220px;">';

/*------------------------  start your code here  ----------- */

    ?>
    <!-- VK Widget -->
    <ul id="vk_groups">
    <script type="text/javascript">
        VK.Widgets.Group("vk_groups", {mode: 0, width: "<?=VK_API_WIDGET_CLUB_WIDTH?>"}, <?=VK_API_WIDGET_CLUB_ID?>);
    </script>
        </ul>
    <?
/*------------------------  end your code here ----------- */

    echo '</li>';
}




