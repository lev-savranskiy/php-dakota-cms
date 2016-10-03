<?php

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Login extends MY_Controller {


    /**
     * @method Login index
     * @return data to tpl
     */


    public function index($message = '') {

        $u =  Doctrine::getTable('User')->findOneByEmail(ADMIN_DEMO_EMAIL,3);

        $this->vars['demo_text'] = '';
        if(isset($u['email'])){

            if (LANG =='russian'){
                    $this->vars['demo_text'] = '<p>Для использования демо админ-панели залогиньтесь с данными: </p> <p>логин - admin@example.com <br />пароль - admin </p><p>&nbsp;</p><p>При инсталляции создайте администратора с реальными данными, чтобы скрыть это сообщение.</p><p>&nbsp;</p>';
                }
            else{
                $this->vars['demo_text'] = '<p>  Use demo admin panel data: </p> <p> login - admin@example.com <br /> password - admin </p> <p>&nbsp;</p> <p> Create real  admin during installation to hide this message. </p><p>&nbsp;</p> ';
            }
            
        }

        $this->vars['content_view'] = 'register/login_view';
        $this->vars['title'] = TITLE . colon() . lang('dakota_auth');
        $this->vars['message'] = $message;

        $this->vars['site_roles'] = $this->CI->config->item('site_roles');

        $this->load->view('tpl/template', $this->vars);
    }

    /**
     * @method submit reset password
     * @return data to tpl
     */


    public function submit_reset() {

        $this->vars['content_view'] = 'register/reset_result_view';

        $reset_pass_key = $this->input->post('reset_pass_key');


          $this->vars['result']  = FALSE;

        if ($this->_reset_validate() === FALSE) {

            redirect('/login/reset/' . $reset_pass_key);

        } else {

            $u = Doctrine::getTable('User')->findOneBy('reset_pass_key', $reset_pass_key);


             $this->vars['result']  =  Current_User::resetpass($reset_pass_key , $this->input->post('password'));

        }

        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method initiate reset password
     * @return data to tpl
     */


    public function reset($reset_pass_key = null) {

        $u = null;
        $this->vars['content_view'] = 'register/reset_view';
        $this->vars['message'] = '';

        $wrong = false;

        if (!isset($reset_pass_key)) {
            // reset_pass_key not found in URL
            $wrong = true;
        }

        else {

            $u = Doctrine::getTable('User')->findOneBy('reset_pass_key', $reset_pass_key);


            if (!isset($u->active)) {
                // reset_pass_key not found in DB
                $wrong = true;
            }
            else {
                   // reset_pass_key  found and not active
                $this->vars['result'] = 2;

                if ($u->active) {
                    // not   active  !
                         // reset_pass_key  found and active
                    $this->vars['result'] = 1;
                }

            }

        }

        if ($wrong) {
            $this->vars['message'] = lang('dakota_wrong_data') . br() . lang('dakota_send_again') . br();
            $this->vars['content_view'] = 'register/forgot_view';
        }


        $this->vars['user'] = $u;
        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method submit login
     * @return data to tpl
     */


    public function submit() {

      if ($this->input->post('email')== 'anonymous@example.com') {
         return Auth::return_Anonymous_login_attempt();
      }


        if ($this->_submit_validate() === FALSE) {
            $this->index();
            return;
        }

        redirect('/');

    }



    /**
     * @method submit forgot password
     * @return data to tpl
     */

    public function submit_forgot() {

        if ($this->_forgot_validate() === FALSE) {
            $this->forgot();
            return;
        }
        $u = Doctrine::getTable('User')->findOneBy('email', $this->input->post('email'));

        $this->vars['user'] = $u;
        $this->vars['content_view'] = 'register/forgot_result_view';
        // not found
        $this->vars['result'] = 0;


        if (isset($u->active)) {

            if (!$u->active) {
                // not active
                $this->vars['result'] = 3;
                $this->load->view('tpl/template', $this->vars);
                return;

            }


            $this->load->library('email');

            $config['protocol'] = 'sendmail';
            $config['useragent'] = 'Dakota CMS';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['validate'] = TRUE;
            $config['mailtype'] = 'html';
            $config['mailpath'] = '/usr/sbin/sendmail';

            $this->email->initialize($config);


            $this->email->from($this->CI->config->item('reg_robot_email') );
            $this->email->to($u->email);


            $this->email->subject(lang('dakota_password_new') . ' ' . TITLE );


            $reset_pass_key = md5($this->CI->config->item('salt') . uniqid());
            $reset_pass_link = base_url() . 'login/reset/' . $reset_pass_key . '/';

            $message = '<h2>' . lang('dakota_password_new') . base_url() . '</h2>
                        <h3>' . lang('dakota_password_reset_go')  .  '
                         <a href="' . $reset_pass_link . '">' . $reset_pass_link . '</a>
                        </h3>
                        <p>' . lang('dakota_reg_ignore') .    '</p>
               ';


            $this->email->message($message);

            if ($this->email->send()) {
                // ok
                $this->vars['result'] = 1;
                $u->reset_pass_key = $reset_pass_key;
                $u->save();

            } else {
                // error
                $this->vars['result'] = 2;
            }


        }
        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method intitiate forgot password
     * @return data to tpl
     */

    public function forgot() {
        $this->vars['message'] = '';
        $this->vars['title'] = TITLE . colon() . lang('dakota_password_reset');
        $this->vars['content_view'] = 'register/forgot_view';
        $this->load->view('tpl/template', $this->vars);
    }

    /**
     * @method _forgot_validate
     * @return bool
     */

    private function _forgot_validate() {

        $this->form_validation->set_rules('email', 'Email',
            'trim|required|valid_email');

        return $this->form_validation->run();

    }

    /**
     * @method _reset_validate
     * @return bool
     */

    private function _reset_validate() {

        $this->form_validation->set_rules('password', 'Password',
            'trim|required|min_length[6]|max_length[12]');

        return $this->form_validation->run();

    }

    /**
     * @method _submit_validate
     * @return bool
     */

    private function _submit_validate() {


        $this->form_validation->set_rules('email', 'Email',
            'trim|required|valid_email|callback_authenticate');

        $this->form_validation->set_rules('password', 'Password',
            'trim|required');

        $this->form_validation->set_message('authenticate', lang('dakota_auth_fail'));

        return $this->form_validation->run();

    }

    public function authenticate() {

        return Current_User::login($this->input->post('email'), $this->input->post('password'));

    }


}
