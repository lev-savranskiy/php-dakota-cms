<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (!Auth::is_admin())   Auth::return_not_auth();
        $this->vars['message'] = '';
        $site_roles = $this->CI->config->item('site_roles');
        $this->vars['site_roles'] = $site_roles;
        $this->vars['site_roles_prepared'] = array();
        $this->vars['title'] = TITLE_AC .  lang('dakota_users');
        $this->vars['moderators'] = 0;

        foreach ($site_roles as $k => $v) {
            if (Auth::check_role($k))  $this->vars['site_roles_prepared'][$k] = $v;
        }
    }

    /**
     * @method   Users index
     * @param int $offset
     * @param  $message
     * @return data to tpl
     */

    public function index($offset = 0, $message = null) {



        // print_r($this->uri->uri_to_assoc(3));

        $u = new User();

        $limit = 50;
        $this->vars['users'] = Doctrine_Query::create()
                ->select('*')
                ->from('User')
                ->limit($limit)
                ->offset($offset)
                 ->orderby('created_at')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
        $this->vars['total'] = $u->_total(true);
        if ($u->_total() > $limit) {
            $config['base_url'] = base_url() . "admin/users/index/";
            $config['total_rows'] = $u->_total();
            $config['per_page'] = $limit;
            $config['uri_segment'] = 4;
            $this->pagination->initialize($config);
            $this->vars['pagination'] = $this->pagination->create_links();
        }


        $this->vars['content_view'] = 'admin/users_view';
        if ($message != null)           $this->vars['message'] = $message;


        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method   Users create
     * @return data to tpl
     */

    public function create() {

        if ($this->_submit_validate() === FALSE) {
            $this->index();
            return;
        }

        $u = new User();
        $u->firstname = $this->input->post('firstname');
        $u->lastname = $this->input->post('lastname');
        $u->password = $this->input->post('password');
        $u->email = $this->input->post('email');
        $u->role = $this->input->post('role');
        // $u->active = $this->input->post('active');
        $u->ip = $this->input->ip_address();
        $u->save();
        $message =   lang('dakota_created') . nbs() .  $u->lastname ;
        $this->index(0, $message);


    }


    /**
     * @method   User update
     * @param int $id
     * @return data to tpl
     */

    public function update($id = null) {
        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    

        if ($id == ID) redirect('/users/update/');

        if (!Auth::compare_user_role($id)) {
            Auth::return_not_auth();
            die();
        }


        if ($this->input->post('role')) {

            if ($this->_update_validate() === FALSE) {
                $this->index();
                return;
            }
            $u = Doctrine::getTable('User')->find($id);
            $u->firstname = $this->input->post('firstname');
            $u->lastname = $this->input->post('lastname');
            $u->active = $this->input->post('active');
            $u->role = $this->input->post('role');
            $u->save();
            $message =  lang('dakota_updated') . nbs() .  $u->lastname ;
            $this->index(0, $message);
        }
        else {

            $this->vars['user'] = Doctrine::getTable('User')->find($id);

            $this->vars['is_online'] = $this->session->is_online($id);
            $this->vars['content_view'] = 'admin/user_update_view';


            $this->load->view('tpl/template', $this->vars);

        }


        //  redirect('/admin/users/');
    }


     /**
     * @method   Users delete
     * @param int $id
     * @return data to tpl
    * WE NEVER DELETE USERS

    public function delete($id = null) {

        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    

        if (Auth::compare_user_role($id)) {
            $u = Doctrine::getTable('User')->find($id);
            $u->delete();

            $message = 'Пользователь id ' . $id . ' удален или не существует';

        } else {
            $message = 'У вас нет прав на  Пользователя id ' . $id;

        }

        $this->index(0, $message);
    }
    */

    /**
    * @method   User disconnect from site
    * @param int $id
    * @return data to tpl
    */

    public function disconnect($id = null) {

        if (!is_unsigned_int($id))  {
             return Auth::return_wrong_data();
        }    

        if (Auth::compare_user_role($id)) {

            $sessions = 0;
            $query = $this->db->query("SELECT * FROM ci_sessions");

            foreach ($query->result_array() as $row) {

                $userData = (unserialize($row['user_data']));

                if (isset($userData['user']['id']) && $userData['user']['id'] == $id) {
                    $this->db->delete('ci_sessions', array('session_id' => $row['session_id']));
                    $sessions++;
                }

            }
            $message = $sessions ? lang('dakota_user') . nbs() . '  id ' . $id . lang('dakota_user_kicked') : lang('dakota_user') . nbs() . ' id ' . $id .  lang('dakota_user_not_online');

        } else {
            Auth::return_not_auth();
            die();

        }


        $this->index(0, $message);
    }


     /**
    * @method   User find by type
    * @param str $type
    * @return data to tpl
    */


    public function findby($type) {

        $query = 'findBy' . $type;

        

        if ($this->_search_validate($type) === FALSE) {
            $this->index();
            return;
        }


        $this->vars['users'] = Doctrine::getTable('User')->$query($this->input->post('q'), false, 3);

        //  print_r($this->vars['users'] )      ;
        //   exit;

        $this->vars['content_view'] = 'admin/users_view';


        $this->vars['message'] = lang('dakota_search_query'). colon() . $type . '=' . $this->input->post('q');


        $this->load->view('tpl/template', $this->vars);

        // $this->index($message);


    }

    /**
   * @method   Users find moderators
   * @return data to tpl
   */

    public function moderators() {

        $this->vars['users'] = Doctrine::getTable('User')->findBySql('  role > 49 ', null, 3);
        $this->vars['moderators'] = 1;
        $this->vars['content_view'] = 'admin/users_view';


        $this->load->view('tpl/template', $this->vars);

    }

    /**
     * @return bool
     */
    private function _submit_validate() {

        $this->form_validation->set_rules('token', 'token', 'required|check_referer|check_token');

                // validation rules
        $this->form_validation->set_rules('email', 'Email',
            'trim|required|valid_email|unique[User.email]');

        $this->form_validation->set_rules('password', 'Password',
            'trim|required|min_length[6]|max_length[12]');


        $this->form_validation->set_rules('firstname', lang('dakota_user_firstname'),
            'trim|required|min_length[3]|max_length[25]');

        $this->form_validation->set_rules('lastname', lang('dakota_user_lastname'),
            'trim|required|min_length[3]|max_length[25]');

        $this->form_validation->set_rules('role', 'Role',
            'trim|required|check_role');


        return $this->form_validation->run();

    }


    /**
     * @return bool
     */
    private function _update_validate() {

        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');


        $this->form_validation->set_rules('role', 'Role',
            'trim|required|check_role');


        $this->form_validation->set_rules('firstname', lang('dakota_user_firstname'),
            'trim|required|min_length[3]|max_length[25]');

        $this->form_validation->set_rules('lastname', lang('dakota_user_lastname'),
            'trim|required|min_length[3]|max_length[25]');

        return $this->form_validation->run();

    }

    /**
     * @return bool
     */
    private function _search_validate($type) {



        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');

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