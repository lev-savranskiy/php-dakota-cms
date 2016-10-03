<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// NOT IN USE!

echo '<div class="admin-home text-center">';



echo anchor_img('/', 'title="View Site" ' , TEMPLATES_FOLDER . 'common/img/home.png' );



echo anchor_img('/admin/articles/', 'title="News and Pages" ' , TEMPLATES_FOLDER . 'common/img/news.png' );
echo anchor_img('/admin/gallery/', 'title="Gallery" ', TEMPLATES_FOLDER . 'common/img/gallery.png' );
echo anchor_img('/admin/files/', 'title="Files" '  , TEMPLATES_FOLDER . 'common/img/files.png' );
echo anchor_img('/admin/templates/', 'title="Templates" '  , TEMPLATES_FOLDER . 'common/img/templates.png' );
echo '<br />';

echo anchor_img('/admin/users/', 'title="Users" '  , TEMPLATES_FOLDER . 'common/img/users.png' );
echo anchor_img('/admin/forums/', 'title="Forum" '  , TEMPLATES_FOLDER . 'common/img/forum.png' );
echo anchor_img('/admin/widgets/', 'title="Widgets" '  , TEMPLATES_FOLDER . 'common/img/widgets.png' );
echo anchor_img('/admin/notepad/', 'title="Notepad" '  , TEMPLATES_FOLDER . 'common/img/notepad.png' );
echo anchor_img('/admin/settings/', 'title="Global settings" '  , TEMPLATES_FOLDER . 'common/img/settings.png' );

echo '<br />';


echo anchor_img('/admin/phpinfo/', 'title="PHP info" '  , TEMPLATES_FOLDER . 'common/img/phpinfo.png' );
echo anchor_img(PHP_MY_ADMIN_LINK , 'title="Database"  target="_blank" '  , TEMPLATES_FOLDER . 'common/img/sql.png' );

echo anchor_img('/stats/', 'title="Stat Info"  '  , TEMPLATES_FOLDER . 'common/img/stats.png' );
echo anchor_img('/admin/system/', 'title="System Info" '  , TEMPLATES_FOLDER . 'common/img/system.png' );
echo anchor_img('/user_guide_dakota/index.html', 'title="Help"  target="_blank" '  , TEMPLATES_FOLDER . 'common/img/help.png' );
//echo anchor_img('/logout', 'title="Exit"  '  , TEMPLATES_FOLDER . 'common/img/exit.png' );




echo    '</div>';






