<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */


class Users extends MY_Controller {

    /**
     * @method __construct
     * @return void
     */

    public function __construct() {

        parent::__construct();
        $this->vars['title'] = TITLE . colon() . lang('dakota_user_profile');
        $this->vars['site_roles'] = $this->config->item('site_roles');
        $this->vars['site_user_settings'] = $this->config->item('site_user_settings');

        $this->vars['citieslist'] = $this->config->item('citieslist');
        $this->vars['countrieslist'] = $this->config->item('countrieslist');

        $this->vars['message'] = '';

    }


    /**
    *  @method findby
     * @param   $type
      * @return data to view
     */

    public function findby($type = null) {

        // for now only findby    lastname

        $type = 'lastname';
       // $query = 'findBy' . $type;

        if ($this->_search_validate($type) === FALSE) {
            $this->index();
            return;
        }


        $this->vars['users'] = Doctrine_Query::create()
        ->select('*')
        ->from('User')
        ->where('active = 1' )
        ->andWhere($type . ' = ?' , $this->input->post('q'))
        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
        ->execute();

        $this->vars['content_view'] = 'all_users_view';
        $this->vars['message'] =  lang('dakota_search_query') . colon(). $type . '=' . $this->input->post('q');
        $this->load->view('tpl/template', $this->vars);
        // $this->index($message);


    }


    /**
     * @method myprofile
     * @return redirect
     */

    public function myprofile() {
        $this->id(ID);
    }


    /**
     * @method index
     * @param int $offset
      * @return data to view
     */

    public function index($offset = 0) {
         $this->output->cache(CACHE_TTL);
      
        $this->vars['content_view'] = 'all_users_view';
        $this->vars['title'] = TITLE . colon() . lang('dakota_users');

        $u = new User();

        $limit = 50;
        $this->vars['users'] = Doctrine_Query::create()
                ->select('*')
                ->from('User')
                ->where('active = 1')
                ->limit($limit)
                ->offset($offset)
                ->orderby('created_at')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();

        $this->vars['total'] = $u->_total();

        if ($u->_total() > $limit) {
            $config['base_url'] = base_url() . "/users/index/";
            $config['total_rows'] = $u->_total();
            $config['per_page'] = $limit;
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $this->vars['pagination'] = $this->pagination->create_links();
        }

        $this->load->view('tpl/template', $this->vars);

    }


    /**
    * @method user by id
     * @param  $id
      * @return data to view
     */
    public function id($id  = null) {

        if (! is_unsigned_int($id)){
            $this->index();
        }


        $this->vars['user'] = Doctrine::getTable('User')->find($id);
        $this->vars['country'] = $this->vars['user']['country'] != '' ? $this->vars['user']['country'] : lang('dakota_dont_use');
        $this->vars['city'] = $this->vars['user']['city'] != '' ? $this->vars['user']['city'] : lang('dakota_dont_use');
        $this->vars['content_view'] = 'one_user_view';


        if (isset($this->vars['user']->active) && $this->vars['user']->active) {


            $this_user_settings = unserialize($this->vars['user']->settings) ? unserialize($this->vars['user']->settings) : array();
            $user_settings_prepared = array();
            $user_birthday_prepared = '';


            foreach ($this->vars['site_user_settings'] as $s => $v) {

                if (isset($this_user_settings[$s])) {
                    if ($s != 'bday' && $s != 'bmonth' && $s != 'byear') {
                       // $user_settings_prepared[$v[0]] = $this_user_settings[$s];
                        $user_settings_prepared[$s] = array( $v[0] , $this_user_settings[$s]);
                    }
                }
            }

            // format birthday
            $user_birthday_prepared = '';
            if (isset($this_user_settings['bday']) &&  $this_user_settings['bday'] != '' && isset($this_user_settings['bmonth']) && $this_user_settings['bmonth'] != '') {
                 $month =  $this_user_settings['bmonth'];

                if(strlen($this_user_settings['bmonth'])< 2) $month = '0' . $this_user_settings['bmonth'];
                $month_text = 'cal_' . $month;
                $user_birthday_prepared = $this_user_settings['bday'] . ' ' . lang($month_text);

                if (isset($this_user_settings['byear']) ){
                   $user_birthday_prepared .= ' ' .  $this_user_settings['byear'];

                }
            }


            $this->vars['user_settings_prepared'] = $user_settings_prepared;
            $this->vars['user_birthday_prepared'] = $user_birthday_prepared;


        }

        $this->load->view('tpl/template', $this->vars);

    }

    /**
    * @method update current user
      * @return data to view
     */

    public function update() {

        if (!Auth::has_role()) Auth::return_not_auth();

        if (ID == ANONYMOUS_ID ) Auth::return_Anonymous_login_attempt();

        $u = new Current_User();

      // print_r($this->vars['site_user_settings']);

        if ($this->input->post('sent')) {

            if ($this->_update_validate() === FALSE || $this->_update_validate_settings() === FALSE) {
         
                $this->id(ID);
                return;
            }



                 $u->update($this->vars['site_user_settings']);


              //  $userdata['user'] = $u->toArray();



                $this->session->set_flashdata('message', lang('dakota_updated'));

                redirect('/users/id/' . ID);
      

        }

        $this->vars['user'] = $u;

        $this->vars['content_view'] = 'one_user_update_view';

        if (isset($this->vars['user']->role)) {

            $this_user_settings = unserialize($this->vars['user']->settings) ? unserialize($this->vars['user']->settings) : array();
            $this->vars['this_user_settings'] = $this_user_settings;
        }

        $this->load->view('tpl/template', $this->vars);

    }


    /*
    * dynamic form validator from 'site_user_settings'
    */
    private function _update_validate_settings() {


        foreach ($this->vars['site_user_settings'] as $s => $v) {

            eval("\$this->form_validation->set_rules(\$s, \$v[0],  \$v[1]);");
        }


        return $this->form_validation->run();

    }

    /*
    * update form validator
    */

    private function _update_validate() {
        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');
        
        $this->form_validation->set_rules('firstname', lang('dakota_user_firstname'),
            'trim|required|min_length[3]|max_length[25]');

        $this->form_validation->set_rules('lastname', lang('dakota_user_lastname'),
            'trim|required|min_length[3]|max_length[25]');

        return $this->form_validation->run();

    }

    /*
    * search form validator
    */
    private function _search_validate($type) {

        if ($type == 'id') {
            $this->form_validation->set_rules('q', $type,
                'trim|required|is_natural_no_zero');

        }
        elseif ($type == 'ip') {
            $this->form_validation->set_rules('q', $type,
                'trim|required|valid_ip');

        }
        elseif ($type == 'email') {
            $this->form_validation->set_rules('q', $type,
                'trim|required|valid_email');

        }
        else {
            $this->form_validation->set_rules('q', $type,
                'trim|required|min_length[3]');

        }


        return $this->form_validation->run();

    }

}