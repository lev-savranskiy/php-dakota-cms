<?php
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Load_fixtures extends Controller {

    function Load_fixtures() {



        parent::Controller();

        // if system is installed only admin can Load fixtures


        if ($this->db->table_exists('dakota_settings') && !Auth::is_admin()) {

         Auth::return_not_auth();
        }


    }



    /**
   * @method  Try Clear all tables and Load fixtures
   * @return redirect
   */

    public function index($token = null) {


        if (Auth::is_admin() && ! check_form_token($token)) {

         Auth::return_not_auth();
        }


        // setting site lock
        fopen(LOCK_FILE_NAME, 'w') or die("can't create lock file");



        try {
            $this->load->dbforge();
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

            foreach ($this->config->item('doctrine_db_tables') as $table) {


                if ($this->db->table_exists($table)) {


                    $this->dbforge->drop_table($table);
                }

            }


            Doctrine::createTablesFromModels();
            Doctrine::loadData(APPPATH . '/fixtures');
        } catch (Exception $e) {
            exit($e->getMessage());
        }

        unlink(LOCK_FILE_NAME);

        if (Auth::is_admin()) {
            redirect('/admin/settings/');
        }
        else {
            redirect('/login/');
        }


    }

}
