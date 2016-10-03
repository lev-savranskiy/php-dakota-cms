<div id="signup_form">

<? if (Auth::has_role()) {

    echo '  <h2>' . lang('dakota_auth_already') .'</h2>';
    echo  '<h3>' . anchor('logout' ,lang('dakota_exit') ) . '</h3>';

} else {


 echo ' <h2 class="margin-bottom">' . lang('dakota_reg') .'</h2>';


switch ($result) {
case 0: {
$result_text =  lang('dakota_email_not_found'). colon() . $email_from_link . br() . lang('dakota_support') . colon(). safe_mailto($support_email);
break;
break;
}
case 1: {
$result_text =  lang('dakota_auth_first'). nbs(2) . anchor('login', lang('dakota_enter') );
break;
}
case 2 : {
$result_text =  lang('dakota_auth_confirm_not_needed'). nbs(2) . anchor('login', lang('dakota_enter') );
break;
}
case 3 : {
$result_text =  lang('dakota_auth_wrong_code') . br() . lang('dakota_support') . colon() . safe_mailto($support_email);
break;
}
case 4 : {
$result_text = lang('dakota_auth_is_banned'). br() . lang('dakota_support') . colon() . safe_mailto($support_email);
break;
}
default: {
$result_text = lang('dakota_error_general'). br() . lang('dakota_support') . colon() . safe_mailto($support_email);
} }





 echo '<h3>' .$result_text . '</h3>' ;
}

echo '  </div>';

