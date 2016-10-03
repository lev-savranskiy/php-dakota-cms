<div id="signup_form">

<? if (Auth::has_role()) {

    echo '  <h2>' . lang('dakota_auth_already') . '</h2>';
    echo  '<h3>' . anchor('logout', lang('dakota_exit')) . '</h3>';

} else {


    echo ' <h2  class="margin-bottom">' . lang('dakota_password_reset') . '</h2>';


    switch ($result) {
        case 1:
            {
                $result_text = lang('dakota_password_reset_success ') . br()  . anchor('login', lang('dakota_enter'));
                break;
            }
        default:
            {
                $result_text = lang('dakota_error_general');
            }
    }



    echo '<h3>' . $result_text . '</h3>';

    echo '<h3>' . lang('dakota_support') . colon() . safe_mailto($support_email) . '</h3>';

   echo '<h3><a href="javascript:history.back()">' . lang('dakota_back') . '</a></h3>';
}

echo '  </div>';

