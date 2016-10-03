<div id="signup_form">

<? if (Auth::has_role()) {

    echo '  <h2>' . lang('dakota_auth_already') .'</h2>';
    echo  '<h3>' . anchor('logout' ,lang('dakota_exit') ) . '</h3>';

} else {


    echo ' <h2  class="margin-bottom">' . lang('dakota_reg') .'</h2>';


    echo form_open('register/submit');
    echo validation_errors('<p class="error">', '</p>');


    echo '   <p>'. lang('dakota_user_firstname') . colon() .' </p>';
    echo '<p>';
    echo form_input('firstname', set_value('firstname'));
    echo '  </p>';

    echo '   <p>'. lang('dakota_user_lastname') . colon() .' </p>';
    echo '<p>';
    echo form_input('lastname', set_value('lastname'));
    echo '   </p>';

    echo '  <p> Email:</p>';
    echo '<p>';
    echo form_input('email', set_value('email'));
    echo '   </p>';


    echo '   <p>'. lang('dakota_password') . ' ('  .  lang('dakota_password_limit') . ')'.  colon() .' </p>';
    echo '<p>';
    echo form_password('password');
    echo '    </p> ';


    echo form_submit('submit', 'OK');


    echo form_close();


    echo '    <p>   ';
    echo anchor('login',  lang('dakota_enter'));
    echo '    </p>   ';
}

echo '  </div>';

