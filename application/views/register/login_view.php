<div id="signup_form">

<? if (Auth::has_role()) {

    echo '  <h2>' . lang('dakota_auth_already') .'</h2>';
    echo  '<h3>' . anchor('logout' ,lang('dakota_exit') ) . '</h3>';

} else {


    echo ' <h2  class="margin-bottom">' .lang('dakota_auth') . '</h2>';


    echo form_open('login/submit');


    echo validation_errors('<p class="error" style="margin: 10px 0;">', '</p>');
    if ($message != ''){
         echo '<p class="error" style="margin: 10px 0;">' . $message .'</p>';  

    }

echo $demo_text;

    echo '   <p>    <label class="label-left" for="email">Email: </label>';
    echo form_input('email', set_value('email'));
    echo '   </p>';


    echo '   <p>  <label class="label-left" for="password">' .lang('dakota_password') . ': </label>';

    echo form_password('password');
    echo '    </p> ';


    echo form_submit('submit', lang('dakota_enter'));


    echo form_close();

    echo '    <p>   ';
    echo anchor('register', lang('dakota_reg'));
    echo ICON_BULL;
    echo anchor('/login/forgot/', lang('dakota_password_reset'));
    echo '    </p>   ';
}

echo '  </div>';


