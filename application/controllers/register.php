<?php

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Register extends MY_Controller {

    /**
      * @method __construct
     * @return void
     */

    public function __construct() {
        parent::__construct();

        if (!REGISTRATION_ENABLED) {
            Auth::return_register_is_off();
        }

    }


    /**
      * @method index
     * @return data to tpl
     */

    public function index() {

        $this->vars['content_view'] = 'register/register_view';
        $this->vars['title'] = TITLE . colon() . lang('dakota_reg');
        $this->vars['site_roles'] = $this->CI->config->item('site_roles');

        $this->load->view('tpl/template', $this->vars);
    }

    /**
      * @method submit  registration
     * @return data to tpl
     */

    public function submit() {

        if ($this->_submit_validate() === FALSE) {
            $this->index();
            return;
        }

        $u = new User();
        $u->firstname = $this->input->post('firstname');
        $u->lastname = $this->input->post('lastname');
        $u->password = $this->input->post('password');
        $u->email = $this->input->post('email');
        $u->role = 10;
        // $u->active = $this->input->post('active');
        $u->ip = $this->input->ip_address();


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
//        $this->email->cc('another@another-example.com');
//        $this->email->bcc('them@their-example.com');

        $this->email->subject(TITLE . ' ' .  lang('dakota_reg'));

        $salt_part = md5($this->CI->config->item('salt') . $u->email);

        $salt_link = base_url() . 'register/confirm/' . $u->email . '/' . $salt_part;

        $message = '<h2>' . lang('dakota_reg_welcome') .  base_url() . '</h2>
                    <h3>' . lang('dakota_reg_confirm') .  ' <a href="' . $salt_link . '">' . $salt_link . '</a>                    </h3>
                    <p>' . lang('dakota_reg_ignore') .   '</p>';


        $this->email->message($message);


        if ($this->email->send()) {
            $u->save();
            $this->result($u , true);

        }
        else
        {
            $u->delete();
             $this->result($u , false);
            //   echo $this->email->print_debugger();

        }


    }

        /**
         * @method confirm  registration
         * @param  $email_from_link
         * @param  $salt_part_from_link
         * @return data to tpl
         */

    public function confirm($email_from_link = null, $salt_part_from_link = null) {


        if (!(isset($email_from_link) && isset($salt_part_from_link))) {
            return $this->index();

        }

        $salt_part = md5($this->CI->config->item('salt') . $email_from_link);
        $u = Doctrine::getTable('User')->findOneBy('email', $email_from_link);


        if (!isset($u->active)) {
            // email not found  !
            $this->vars['result'] = 0;
        }
        else {

            if ($u->active == true) {
                // already   active  !
                $this->vars['result'] = 2;
            }


            if ($salt_part != $salt_part_from_link) {
                // wrong salt!
                $this->vars['result'] = 3;
            }

            if ($salt_part == $salt_part_from_link && $u->active == false) {

                if ($u->last_login == '0000-00-00 00:00:00') {
                    // activate!
                    $this->vars['result'] = 1;
                    $u->active = true;
                    $u->save();
                }
                else {
                    // banned  !
                    $this->vars['result'] = 4;
                }


            }
        }

        $this->vars['content_view'] = 'register/confirm_view';
        $this->vars['email_from_link'] = $email_from_link;
        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @method   registration results
     * @param  $u
     * @param  $result
     * @return data to tpl
     */

    public function result($u , $result) {

        $this->vars['content_view'] = 'register/register_result_view';
        $this->vars['created_user'] = $u;
        $this->vars['result'] = $result;
        $this->load->view('tpl/template', $this->vars);

    }



    private function _submit_validate() {

        // validation rules
        $this->form_validation->set_rules('email', 'Email',
            'trim|required|valid_email|unique[User.email]');

        $this->form_validation->set_rules('password', 'Password',
            'trim|required|min_length[6]|max_length[12]');


        $this->form_validation->set_rules('firstname', lang('dakota_user_firstname'),
            'trim|required|min_length[3]|max_length[25]');

        $this->form_validation->set_rules('lastname',lang('dakota_user_lastname'),
            'trim|required|min_length[3]|max_length[25]');

        return $this->form_validation->run();

    }


}
