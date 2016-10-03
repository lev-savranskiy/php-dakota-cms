<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

 echo  '<h2>' .anchor('/users/',  lang('dakota_users') ) . '</h2>';
if (isset($user->active) && $user->active) {




    echo   '<h3 class="title notranslate"><strong>' . $user->firstname . ' ' . $user->lastname . '</strong>  ';

    if ($user->id == ID && ID != ANONYMOUS_ID) {
        echo    anchor_img('/users/update/', ' title="'  . lang('dakota_edit') .'" ', ICON_EDIT);
    }
    elseif (Auth::is_admin()) {
        echo    anchor_img('/admin/users/update/' . $user->id, ' title="'  . lang('dakota_edit') .' " ', ICON_EDIT);
    }


    echo  '</h3>';

    echo '<div  class="error">';
    echo $this->session->flashdata('message');
    echo validation_errors('<p class="error">', '</p>');
    echo '</div>';


    echo '<div  id="profile">';
    echo   '<p><strong>' .lang('dakota_role') . colon() .'</strong> ' . $site_roles[$user->role] . '</p>';
    echo   '<p><strong>' .lang('dakota_country') . colon() .'</strong> ' . $country . '</p>';
    echo   '<p><strong>' .lang('dakota_city') . colon() .'</strong> ' . $city . '</p>';


    if ($user_birthday_prepared != '') {

        echo   '<p><strong>' . lang('dakota_birthday') . colon() .'</strong> ' . $user_birthday_prepared . '</p>';
    }


    echo   '<h3 style="margin: 10px 0;">' . lang('dakota_stat').'</h3>';  
    echo   '<p><strong>' . lang('dakota_registered_at') . colon() . '</strong> ' . $user->created_at . '</p>';


    $activity = $user->last_login;

    if ($user->id == ANONYMOUS_ID) {
            $activity = lang('dakota_permanent');
    }

    echo   '<p><strong>' . lang('dakota_activity') .colon() .'</strong> ' . $activity . '</p>';




    echo   '<p><strong>' . lang('dakota_user_news') . colon() . '</strong> ' . safe_count($user->find_publications($user->id)) . '</p>';
    echo   '<p><strong>' . lang('dakota_user_comments') . colon() . ' </strong> ' . safe_count($user->find_comments($user->id)) . '</p>';
    echo   '<p><strong>' . lang('dakota_user_posts') . colon() . '</strong> ' . safe_count($user->find_posts($user->id)) . '</p>';


    echo   '<p style="margin: 10px 0"></p>';


    foreach ($user_settings_prepared as $s => $v) {

        if (strip_tags($v[1]) != '') {
            if ($s == 'about' && strip_tags($v[1])) {
                echo   '<p style="margin: 10px 0"></p>';
                echo   '<p><strong>' . $v[0] . ':</strong> ' . strip_tags($v[1]) . '</p>';
            }
            else {

                $icon = '/' .TEMPLATES_FOLDER . 'common/img/icon_' . $s . '.png';


                if ($s == 'skype') {

                    echo   '<p><img src="' . $icon .'" alt="' . $s .'">' . nbs(2) . '<a  href="skype:' . $v[1] . '?chat">' . $v[1] . '</a> </p>';

                }
                else {
                    echo   '<p><img src="' . $icon .'" alt="' . $s .'">' . nbs(2) . auto_link($v[1], 'both', true) . '</p>';
                }

            }
        }

    }


}
else {

    echo '<h3 class="error">' .  lang('dakota_users_not_found'). '</h3>';
}

echo '</div>';


















