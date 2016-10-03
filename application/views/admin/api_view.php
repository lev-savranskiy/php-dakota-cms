<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">API</h2>'  ;
echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('api').' </h3>';


echo '<h4 class="clear red">' . $message ;
echo $this->session->flashdata('message');
echo validation_errors('<p class="error">', '</p>');
echo '</h4>';





echo form_open('admin/api/update/');

$icon = '/' .TEMPLATES_FOLDER . 'common/img/icon_google.png';
echo '<h3>' . img($icon) . ' Google</h3>';

$data = array(
  'name'        => 'show_translation_option',
  'id'          => 'show_translation_option',
  'style'       => '',
  'checked'     => SHOW_TRANSLATION_OPTION,
  'value'       => 1
  );

  echo form_checkbox($data). nbs(3);
  echo '<label for="show_translation_option">' . lang('dakota_show_on_site') . '  Google Translate (eng, deutch, french) </label>';
  echo '<br />';


$icon = '/' .TEMPLATES_FOLDER . 'common/img/icon_vk.png';
echo '<h3>' . img($icon) . ' Vkontakte</h3>';

echo ' <p><b> ' . lang('dakota_api_id_vk') . '</b></p>  ';
echo ' <p>  ' . lang('dakota_use_own_api');
echo nbs(2);
echo form_input('vk_api_id', VK_API_ID , ' size="15" ');
echo '</p>';


echo ' <p><b>' . lang('dakota_group_widget') .'</b></p>  ';

echo ' <p>  ' . lang('dakota_group_id_vk'). nbs(2) . lang('dakota_leave_blank');
echo nbs(2);
echo form_input('vk_api_widget_club_id', VK_API_WIDGET_CLUB_ID , ' size="15" ');
echo '</p>';

echo ' <p> ' . lang('dakota_group_widget_width');
echo nbs(2);
echo form_input('vk_api_widget_club_width', VK_API_WIDGET_CLUB_WIDTH , ' size="4" ');
echo '</p>';


  $data = array(
    'name'        => 'use_vk_share',
    'id'          => 'use_vk_share',
    'style'       => '',
    'checked'     => USE_VK_SHARE,
    'value'       => 1
    );


echo form_checkbox($data) . nbs(3);
echo '<label for="use_vk_share">' . lang('dakota_show_on_site') . ' Vkontakte share</label>';


//echo '<hr />';


  $data = array(
    'name'        => 'use_facebook_share',
    'id'          => 'use_facebook_share',
    'style'       => '',
    'checked'     => USE_FACEBOOK_SHARE,
    'value'       => 1
    );
$icon = '/' .TEMPLATES_FOLDER . 'common/img/icon_facebook.png';
echo '<h3>'  . img($icon) . ' facebook</h3>';


echo form_checkbox($data) . nbs(3);
echo '<label for="use_facebook_share">' . lang('dakota_show_on_site') . ' facebook share</label>';
echo '<br />';

//echo '<hr />';
  $data = array(
    'name'        => 'use_twitter_share',
    'id'          => 'use_twitter_share',
    'style'       => '',
    'checked'     => USE_TWITTER_SHARE,
    'value'       => 1
    );
$icon = '/' .TEMPLATES_FOLDER . 'common/img/icon_twitter.png';
echo '<h3>'  . img($icon) . ' twitter</h3>';


echo form_checkbox($data) . nbs(3);
echo '<label for="use_twitter_share">' . lang('dakota_show_on_site') . ' twitter share</label>';
echo '<br />';



echo form_submit('submit', 'OK');
echo form_close();




echo '</div>';











