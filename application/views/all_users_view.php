<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');



echo '<div>';

        echo '<h2 class="title">';
if ($message !=''){
 echo  anchor('/users/',  lang('dakota_users') );
}    else{
   echo lang('dakota_users');
}
         echo '</h2>';
//echo form_open('admin/users/findby/id/');
//echo '	<label for="id" class="label-left">По id: </label>';
//echo form_input('q');
//echo form_submit('submit', 'OK');
//echo form_close();
//
//
//echo form_open('admin/users/findby/email/');
//echo '	<label for="email" class="label-left">По email: </label>';
//echo form_input('q');
//echo form_submit('submit', 'OK');
//echo form_close();



echo '<div>';
 echo '<div class=error>' . $message . '</div>';
echo validation_errors('<span class="error">', '</span>');
echo '</div>';

echo form_open('/users/findby/lastname/');
echo '	<label for="lastname" class="label-left">' . lang('dakota_users_find_by_lastname') . colon() . '</label>';
echo form_input('q');
echo form_submit('submit', 'OK');
echo form_close();
 echo '</div>';


echo '<div  style="margin-left: 0;">';


if (safe_count($users) > 0) {


    $records_count = isset($total) ? $total : safe_count($users);

    echo '<div style = "margin:  12px 0;">' .  lang('dakota_users_found'). colon() . $records_count . ' </div>';

    foreach ($users as $user) {


        echo '<div style="height:30px;">';
        echo '<p class="left bold" ' . min_size(200).'><a  class="notranslate" href="/users/id/'.$user['id']. '">' . $user['firstname'] . ' '  . $user['lastname'] . '</a></p>';
        echo '<p class="left small" ' . min_size(100).'>' . $site_roles[$user['role']] . '</p>';
         echo '<p class="left small"' . min_size(100).' >' . $user['created_at'] . '</p>';
        echo '<p class="clear"></p>';
        echo '</div>';



    }


}
else {
    echo '<div>' . lang('dakota_users_not_found') .'</div >';
}

echo '</div > ';





