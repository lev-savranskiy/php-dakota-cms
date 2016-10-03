<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">' .lang('dakota_settings') . '</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('settings').' </h3>';

echo '<h4 class="clear red">' . $message ;
echo $this->session->flashdata('message');
echo validation_errors('<p class="error">', '</p>');
echo '</h4>';

if (isset($sitemap_result) && safe_count($sitemap_result)> 0) {


    foreach($sitemap_result as $r) {

      //  print_r($r);

        if ($r['http_code'] == 200) {
                echo '<p><b>' . $r['site'] . ': OK</b> ' . $r['message'] .  '</p>';
        }
        else{

       echo '<p class="error"><b>' . $r['site'] . '</b> ERROR:' . anchor( $r['fullsite'] ,  $r['fullsite']) .   '</p>';
      // echo '<p class="error"><b>' . $r['site'] . '</b><span > ERROR!</span></p><iframe src="' . $r['fullsite'] . '"></iframe>';
        }
    }

}





echo form_open('admin/settings/update/');

echo '	<p>TITLE:  <br />';
echo form_input('title', TITLE , ' style="width: 80%;" ');
echo '</p>';

echo '	<p>KEYWORDS:   <br />';
echo form_input('meta_keywords', META_KEYWORDS , ' style="width: 80%;" ');
echo '</p>';


echo '	<p>META_DESCRIPTION:  <br />';
echo form_input('meta_description', META_DESCRIPTION , ' style="width: 80%;" ');
echo '</p>';

echo '	<p>' . lang('dakota_settings_head_tags') . ':  <br />';
echo form_textarea('meta_extra', META_EXTRA , ' style="width: 80%;" ');
echo '</p>';


echo '	<p>' . lang('dakota_settings_ttl') . ': ';
echo nbs(2);
echo form_input('cache_ttl', CACHE_TTL , ' size="2" ');
echo nbs(2);
echo anchor('/admin/settings/clear_cache/' , lang('dakota_settings_cache_reset') );
echo '</p>';


  $data = array(
    'name'        => 'show_profile_link',
    'id'          => 'show_profile_link',
    'style'       => '',
    'checked'     => SHOW_PROFILE_LINK,
    'value'       => 1
    );

echo form_checkbox($data) . nbs(3);
echo '<label for="show_profile_link">' .  lang('dakota_show_profile_link').'</label>';
echo ' <span class = "prim"><a href="/user_guide_dakota/templates.html#profile-link">Help</a></span>	';
echo '<br />';







  $data = array(
    'name'        => 'registration_enabled',
    'id'          => 'registration_enabled',
    'style'       => '',
    'checked'     => REGISTRATION_ENABLED,
    'value'       => 1
    );

echo form_checkbox($data). nbs(3);
echo '<label for="registration_enabled">' .  lang('dakota_register_is_on').'</label>';
echo '<br />';



echo form_submit('submit', lang('dakota_update'));
echo form_close();

echo '<hr />';


echo '<p>';
echo form_open('admin/settings/backup/');
echo form_submit('backup', lang('dakota_backup_bd'));
echo form_close();
echo '</p>';
 echo '<br />';

// lock CMS_HOME rebuild 
if (read_file(APPPATH . '/controllers/admin/load_fixtures.php')  and base_url() != CMS_HOME){
echo '<p>';
$del_link = '/admin/load_fixtures/index/' . TOKEN ;
echo form_submit('load_fixtures', lang('dakota_reload_bd') , ' onclick="goConfirm(\''.$del_link.'\' , \''. lang('dakota_bd_alert').'\'  ); " ');
echo nbs(2) .anchor_help('settings');

echo '</p>';
}
else{
echo '<p>' . lang('dakota_file_not_found')  .' /controllers/admin/load_fixtures.php ' . lang('dakota_cant_reload_bd')  .' </p>';

}

 echo '<br />';
echo '<p>';
echo form_open('admin/settings/create_sitemap/');
echo form_submit('create_sitemap', lang('dakota_reload') . ' sitemap');
echo nbs(2);
echo anchor('/sitemap.xml' , lang('dakota_view')  .' sitemap' , ' target="_blank"');
echo form_close();
echo '<p>';



echo '</div>';











