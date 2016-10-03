<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Templates extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();
    }

     /**
     * @method   Templates index
     * @return data to tpl
     */

    public function index() {


        $this->vars['content_view'] = 'admin/templates_view';
        $this->vars['title'] = TITLE_AC .  lang('dakota_templates');

        $this->vars['message'] = '';


        $templates_dirs = directory_map('./' . TEMPLATES_FOLDER, TRUE);

        $templates_dirs_formatted = array();

        if (safe_count($templates_dirs) > 0) {

            foreach ($templates_dirs as $templates_dir) {
                if ($templates_dir != 'common' && read_file('./' . TEMPLATES_FOLDER . $templates_dir . '/img/full.png')) {
                     $templates_dirs_formatted[] = $templates_dir;
                }
            }
        }

         $this->vars['templates'] =$templates_dirs_formatted;


        $this->load->view('tpl/template', $this->vars);

    }



     /**
     * @method   Set template
     * @return data to tpl
     */
    public function set($template , $token = null) {


        $templates_dirs = directory_map('./' . TEMPLATES_FOLDER, TRUE);
        $template_found = FALSE;

        if (safe_count($templates_dirs) > 0) {

            foreach ($templates_dirs as $templates_dir) {
                if (  $template == $templates_dir) {
                 $template_found = TRUE;
                }
            }
        }

       if (! $template_found ) return Auth::return_wrong_data();

        if (! check_form_token($token)) return Auth::return_not_auth();
        
       Doctrine_Query::create()
                ->update('global_settings')
                ->set('template', '?', $template)
                ->execute();


        redirect('/admin/templates/');



    }


}