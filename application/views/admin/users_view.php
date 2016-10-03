<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');





echo '<div id="admin-main">';

require_once('dash_menu.php');

echo '<h2 class="left">' .lang('dakota_users') .  ICON_BULL ;

if ($moderators) {
    echo  anchor('/admin/users/', lang('dakota_all')) . ICON_BULL . lang('dakota_moderators');
} else {
    echo lang('dakota_all') . ICON_BULL . anchor('/admin/users/moderators', lang('dakota_moderators')) ;
}

echo '</h2>'  ;

echo '<h3 class="right help-button">' . img(ICON_HELP) . nbs(1) . anchor_help('users').' </h3>';


echo '<div class="clear"> ';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';


echo '<div class="left" >';
echo '<strong>' .lang('dakota_user_create') .'</strong>';
echo form_open('admin/users/create/');


echo '	<label for="firstname" class="label-left">' .lang('dakota_user_firstname') .': </label>';
echo form_input('firstname', set_value('firstname'));
echo '	<br />';

echo '	<label for="lastname" class="label-left">' .lang('dakota_user_lastname') .': </label>';
echo form_input('lastname', set_value('lastname'));
echo '	<br />';


echo '	<label for="email" class="label-left">E-mail: </label>';
echo form_input('email', set_value('email'));
echo '	<br />';

echo '	<label for="password" class="label-left">' .lang('dakota_password') .': </label>';
echo form_password('password');
echo '	<br />';


echo '	<label for="role" class="label-left">' .lang('dakota_role') .': </label>';
echo form_dropdown('role', $site_roles_prepared);
echo '	<br />';


echo form_submit('submit',lang('dakota_add'));
echo form_close();

echo '	<br />';

echo '	<br />';

echo '<strong>' . lang('dakota_user_find') . '</strong>';

echo form_open('admin/users/findby/id/');
echo '	<label for="id" class="label-left">id: </label>';
echo form_input('q');
echo form_submit('submit', 'OK');
echo form_close();


echo form_open('admin/users/findby/email/');
echo '	<label for="email" class="label-left"> email: </label>';
echo form_input('q');
echo form_submit('submit', 'OK');
echo form_close();


echo form_open('admin/users/findby/lastname/');
echo '	<label for="lastname" class="label-left"> ' .lang('dakota_user_lastname') .': </label>';
echo form_input('q');
echo form_submit('submit', 'OK');
echo form_close();

echo form_open('admin/users/findby/ip/');
echo '	<label for="ip" class="label-left"> IP: </label>';
echo form_input('q');
echo form_submit('submit', 'OK');
echo form_close();


echo '</div>';


echo '<div class="left" style="margin-left: 50px;">';
//print_r($users);


echo '<div class=error>' . $message . '</div>';

if (safe_count($users) > 0) {

    $records_count = isset($total) ? $total : safe_count($users);

    echo '<div style = "margin:  12px 0;">'. lang('dakota_users_found') . colon() . $records_count . ' </div>';
    echo '<table >';

    echo '<tr class="table-head">';
    echo  '<td >id</td>';
    echo  '<td>' . lang('dakota_user_firstname') . '</td>';
    echo  '<td>' . lang('dakota_user_lastname') . '</td>';
    echo '<td>Email (login)</td>';
    echo  '<td>' . lang('dakota_created') . '</td>';
    echo '<td>ip</td>';
    echo  '<td>' . lang('dakota_role') . '</td>';
    echo  '<td>' . lang('dakota_active') . '</td>';
    echo  '<td>' . lang('dakota_actions') . '</td>';
    echo '</tr>';

    foreach ($users as $user) {

        echo '<tr>';
        echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['firstname'] . '</td>';
        echo '<td>' . $user['lastname'] . '</td>';
        echo '<td class="small">' . $user['email'] . '</td>';
        echo '<td  class="small">' . $user['created_at'] . '</td>';
        echo '<td  class="small">' . $user['ip'] . '</td>';
        echo '<td  class="small">' . $site_roles[$user['role']] . '</td>';
        echo '<td  class="small text-center">' . img(TEMPLATES_FOLDER .'common/img/icon_' . $user['active']   . '.png') . '</td>';


        echo '<td class="small text-center">';

//        echo anchor_img('/users/id/' . $user['id'], ' title="View full profile (new  tab)" target="_blank" ', ICON_GO);

        if ($user['role'] < ROLE) {
            echo anchor_img('admin/users/update/' . $user["id"], ' title="' . lang('dakota_edit') . '" ', ICON_EDIT);
//            echo ' ';
//            echo anchor_img('admin/users/disconnect/' . $user["id"], ' title="Kick from site" ', ICON_DISCONNECT);
//            echo ' ';
//            echo anchor_img('admin/users/delete/' . $user["id"], ' title="Delete" ', ICON_DELETE);
        }
        if ($user['id'] == ID) {
            echo anchor_img('/users/update/', ' title="' . lang('dakota_user_profile') . '" ', ICON_EDIT);
 
        }


        echo '</td >';
        echo '</tr > ';


    }

    echo '</table > ';

}
else {
    echo '<div>' . lang('dakota_users_not_found');
}

echo '</div > ';
echo '</div > ';

echo '<div class = "clear"></div>';




