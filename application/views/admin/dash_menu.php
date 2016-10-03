<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo '<div class="left" style="min-width: 200px; width: 19%;" >';
echo anchor_img(CMS_HOME , ' title="Dakota SMC Home" target="_blank" ' , TEMPLATES_FOLDER .'common/img/logo.png');
echo '</div>';


if (!  is_writable(UPLOAD_FOLDER)) echo '<div class="error">' . lang('dakota_folder') . ' UPLOAD_FOLDER ' .UPLOAD_FOLDER . colon().  lang('dakota_error_cant_write') . '</div>';
if (! is_writable(GALLERY_FOLDER)) echo '<div class="error">' . lang('dakota_folder') . ' GALLERY_FOLDER ' .GALLERY_FOLDER .  colon(). lang('dakota_error_cant_write') . '</div>';



echo '<div class="left" style=" width: 80%">';
echo anchor('/', base_url(), array('target' => '_blank'));
echo ICON_BULL;
//echo anchor('/admin/', 'MAIN');
//echo ICON_BULL;
echo anchor('/admin/articles/', lang('dakota_articles')  );
echo ICON_BULL;
echo anchor('/admin/users/', lang('dakota_users')  );
echo ICON_BULL;
echo anchor('/admin/gallery/', lang('dakota_gallery')  );
echo ICON_BULL;
echo anchor('/admin/files/', lang('dakota_files')  );
echo ICON_BULL;
echo anchor('/admin/forums/', lang('dakota_forums')  );
echo ICON_BULL;
echo anchor('/admin/widgets/', lang('dakota_widgets')  );
echo ICON_BULL;
echo anchor('/admin/templates/', lang('dakota_templates')  );
echo ICON_BULL;
echo anchor('/admin/menu/', lang('dakota_menu')  );
echo ICON_BULL;
echo anchor('/admin/settings/', lang('dakota_settings')  );
echo ICON_BULL;
echo anchor('/admin/api/', lang('dakota_api')  );
echo ICON_BULL;
echo anchor('/admin/phpinfo/', lang('dakota_phpinfo')  );
echo ICON_BULL;
echo anchor(PHP_MY_ADMIN_LINK , lang('dakota_db')    , ' target="_blank" ' );
echo ICON_BULL;
echo anchor('/stats/', lang('dakota_stats')  );
echo ICON_BULL;
echo anchor('/admin/system/', lang('dakota_system')  );
echo ICON_BULL;
echo anchor('/admin/notepad/',lang('dakota_notepad')  );
echo ICON_BULL;
echo anchor('/users/id/' . ID  , lang('dakota_my_profile')  );
echo ICON_BULL;
echo anchor('logout', lang('dakota_exit') );
echo '</div>';

echo '<div class="clear"></div>';




