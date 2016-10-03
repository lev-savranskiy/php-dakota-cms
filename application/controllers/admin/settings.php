<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Settings extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();

        $this->vars['content_view'] = 'admin/settings_view';
        $this->vars['title'] = TITLE_AC .  lang('dakota_settings');
    }


     /**
     * @method   Settings index
     * @return data to tpl
     */

    public function index() {



        $this->vars['message'] = '';


        $this->load->view('tpl/template', $this->vars);

    }


     /**
     * @method   Clear cache
     * @return data to tpl
     */

    public function  clear_cache() {


        $this->vars['message'] = lang('dakota_updated');

        delete_files(BASEPATH .'/cache/');

        $this->load->view('tpl/template', $this->vars);

    }



     /**
     * @method   Settings update
     * @return data to tpl
     */
    public function update() {

        if ($this->_update_validate() === FALSE) {
                $this->index();
                return;
            }


         Doctrine_Query::create()
                ->update('global_settings')
                ->set('title', '?', $this->input->post('title'))
                ->set('meta_keywords', '?', trim($this->input->post('meta_keywords')))
                ->set('meta_description', '?', trim($this->input->post('meta_description')))
                ->set('meta_extra', '?', $this->input->post('meta_extra'))
                ->set('show_profile_link', '?', trim($this->input->post('show_profile_link')))
                ->set('registration_enabled', '?', trim($this->input->post('registration_enabled')))
                ->set('cache_ttl', '?', trim($this->input->post('cache_ttl')))
                ->execute();



        // USE REDIRECT TO GET NEW VALUES!!
        $this->session->set_flashdata('message',  lang('dakota_updated'));
        redirect('/admin/settings/');

        //$this->load->view('tpl/template', $this->vars);

    }


     /**
     * @method   backup SQL data
     * @return data to tpl
     */

    public function backup() {
        // Load the DB utility class
        $this->load->dbutil();

        $prefs = array(
            'format' => 'txt', // gzip, zip, txt
             'ignore'      => array('dakota_stat'), 
            'filename' => 'mybackup.sql', // File name - NEEDED ONLY WITH ZIP FILES
             'add_drop'    => false,              // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n" // Newline character used in backup file
        );


        // Backup your entire database and assign it to a variable
        $backup =& $this->dbutil->backup($prefs);

        // Load the file helper and write the file to your server
        write_file('mybackup.sql', $backup);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        $time = str_replace(' ', '_', unix_to_human(time()));
        force_download($_SERVER['SERVER_NAME'] . '_backup_' . $time . '.sql', $backup);

    }

     /**
     * @method   create sitemap
     * @return data to tpl
     */

    function create_sitemap() {

        $this->load->library('sitemap');
        $time = explode(" ", microtime());
        $time = $time[1];

        $base_url = base_url();

        // create object
        $sitemap = new Sitemap($base_url , '');

        // will create also compressed (gzipped) sitemap
        $sitemap->createGZipFile = true;

        // determine how many urls should be put into one file
        $sitemap->maxURLsPerSitemap = 10000;

        // sitemap file name
        $sitemap->sitemapFileName = "sitemap.xml";

        // sitemap index file name
        $sitemap->sitemapIndexFileName = "sitemap-index.xml";

        // robots file name
        $sitemap->robotsFileName = "robots.txt";

        $urls = array(
            array(base_url(), date('c'), 'daily', '1'),
            array(base_url() . "articles", date('c'), 'daily', '0.8'),
            array(base_url() . "forum", date('c'), 'monthly', '0.8'),
            array(base_url() . "gallery", date('c'), 'daily', '0.5')
        );


        // add visible articles

        $articles =    Doctrine::getTable('Article')->findBySql(' is_visible  = 1 ');

        foreach ($articles as $article) {
          $urls[] =      array(base_url() . 'articles/title/' . $article['url'], date('c'), 'monthly', '0.3');

        }
        

         // add Forum Category List

         $f = new Forum();
         $forum_categories =  $f->getCategoryList();

        foreach ($forum_categories as $fc) {



           foreach($fc->Forums as $f){
               $urls[] =    array(base_url() . 'forums/display/' . $f->id , date('c'), 'daily', '0.8');   
           }



        }


        // add many URLs at one time
        $sitemap->addUrls($urls);


        try {
            // create sitemap
            $sitemap->createSitemap();

            // write sitemap as file
            $sitemap->writeSitemap();

            // update robots.txt file
            $sitemap->updateRobots();

            // submit sitemaps to search engines
            $result = $sitemap->submitSitemap(YAHOO_APP_ID);
            // shows each search engine submitting status



        }
        catch (Exception $exc) {
            die($exc->getTraceAsString());
        }


        $this->vars['message'] = lang('dakota_updated');
        $this->vars['sitemap_result'] = $result;


        $this->vars['memory'] = "Memory peak usage: " . number_format(memory_get_peak_usage() / (1024 * 1024), 2) . "MB";

        $this->load->view('tpl/template', $this->vars);


    }



    private function _update_validate() {

        $this->form_validation->set_rules('token', 'token',
            'required|check_referer|check_token');

           $this->form_validation->set_rules('title', 'title',
            'trim|required|min_length[3]');



        return $this->form_validation->run();

    }


}