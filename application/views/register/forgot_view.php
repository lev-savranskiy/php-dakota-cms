<div id="signup_form">

<? if (Auth::has_role()) {
    echo '  <h2>' . lang('dakota_auth_already') .'</h2>';
    echo  '<h3>' . anchor('logout' ,lang('dakota_exit') ) . '</h3>';

} else {



    echo ' <h2  class="margin-bottom">'. lang('dakota_password_reset') .'</h2>';


    echo form_open('login/submit_forgot');
    echo validation_errors('<p class="error">', '</p>');
    echo '<p class="error">' . $message .'</p>';

    echo '<p>Email:</p>';
    echo '<p>';
    echo form_input('email', set_value('email'));
    echo '   </p>';




    echo form_submit('submit', 'OK');


    echo form_close();


    echo '    <p>   ';
    echo anchor('login', lang('dakota_enter'));
    echo '    </p>   ';
}

echo '  </div>';

