<div id="signup_form">

<? if (Auth::has_role()) {

    echo '  <h2>' . lang('dakota_auth_already') . '</h2>';
    echo  '<h3>' . anchor('logout', lang('dakota_exit')) . '</h3>';

} else {


    echo ' <h2  class="margin-bottom">' .lang('dakota_password_reset_text') . $user->email . '  </h2>';
    echo ' <h3  class="margin-bottom">' . lang('dakota_password_limit') . '</h3>';


    echo form_open('login/submit_reset');
    echo validation_errors('<p class="error">', '</p>');
    echo '<p class="error">' . $message .'</p>';


    echo '<p>';
    echo form_input('password');
    echo form_hidden('reset_pass_key' , $this->uri->segment(3));
    echo '    </p> ';


    echo form_submit('submit', 'OK');


    echo form_close();


    echo '    <p>   ';
    echo anchor('login', lang('dakota_enter'));
    echo '    </p>   ';
}

echo '  </div>';

