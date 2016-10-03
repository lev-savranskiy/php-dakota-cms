<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

echo '<div id="admin-main">';

require_once('dash_menu.php');


echo '<h2 class="left">  ' .  anchor('admin/users/', lang('dakota_users')) . ICON_BULL  .  lang('dakota_edit') .'</h2>'  ;


echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('users').' </h3>';

echo '<div style = "margin-top: 30px" class="clear">';
//  echo anchor('admin/users/create/', 'Create new');
echo '</div>';

echo form_open('admin/users/update/' . $user->id);

echo validation_errors('<p class="error">', '</p>');






if ($is_online){
echo '<p class ="red bold">'. lang('dakota_user').  ' online ' . anchor_img('admin/users/disconnect/' . $user->id, ' title="' . lang('dakota_user_kick') .'" ', ICON_DISCONNECT) . '</p>';
}
else{
  echo '<p class ="bold">'. lang('dakota_user').  ' offline</p>';

}
 echo '<br />';
echo '<label class="label-left" for="login">email:</label> ' . $user->email . ' ';
// echo ' ';
// echo anchor_img('admin/users/delete/' . $user->id , ' title="Delete" ', ICON_DELETE);
 echo '<br />';
 echo '<br />';

echo '	<label for="firstname" class="label-left">' .lang('dakota_user_firstname') .': </label>';
echo form_input('firstname', $user->firstname);
echo '	<br />';

echo '	<label for="lastname" class="label-left">' .lang('dakota_user_lastname') .': </label>';
echo form_input('lastname', $user->lastname);
echo '	<br />';

echo '	<label for="role" class="label-left">' .lang('dakota_role') .': </label>';
echo form_dropdown('role', $site_roles_prepared, $user->role);
echo '	<br />';

echo '	<label for="active" class="label-left">' .lang('dakota_active') .': </label>';
echo form_dropdown('active', array('0' , '1'), $user->active);

echo '	<br />';


echo form_submit('submit', lang('dakota_update'));
echo form_close();


echo '</div >';





