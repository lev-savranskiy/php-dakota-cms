<div id="signup_form">

<? if (Auth::has_role()) {


    echo '  <h2>' . lang('dakota_auth_already') . '</h2>';
    echo  '<h3>' . anchor('logout', lang('dakota_exit')) . '</h3>';

} else {


    if ($result) {

        echo ' <h2  class="margin-bottom">' . lang('dakota_reg_success') . '</h2>';

        echo '<h3>' . lang('dakota_reg_success_text') . $created_user->email . '</h3>';


    } else {

        echo ' <h2  class="margin-bottom">' . lang('dakota_reg_fail') . '</h2>';
        echo '<h3><a href="javascript:history.back()">' . lang('dakota_back') . '</a></h3>';
        echo '<h3>' . lang('dakota_support') . colon() . safe_mailto($support_email) . '</h3>';

    }


}

echo '  </div>';

