<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SYNTAX HIGHLIGHT IN IDE
 *
 * enables $this->method->,,, highlight in controllers
 *
 * Add any classes - standart and custom
 *
 * @property CI_Benchmark $benchmark
 * @property CI_Calendar $calendar
 * @property CI_Cart $cart
 * @property CI_Config $config
 * @property CI_DB_active_record $db
 * @property CI_Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property CI_FTP $ftp
 * @property CI_Table $table
 * @property CI_Image_lib $image_lib
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_Language $lang
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Session $session
 * @property CI_Trackback $trackback
 * @property CI_Parser $parser
 * @property CI_Typography $typography
 * @property CI_Unit_test $unit
 * @property CI_URI $uri
 * @property CI_User_agent $agent
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Xmlrpcs $xmlrpcs
 * @property CI_Zip $zip
 * @property CI_Template $template
 */


/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */
class MY_Controller extends Controller {

    var $USERDATA;
    var $CI;


    function MY_Controller() {


        parent::Controller();

        $this->CI = & get_instance();


         define('LANG',$this->CI->config->item('language') );

    //   define('USER_LANG',isset($_SESSION['dakota_pref_language'])? $_SESSION['dakota_pref_language'] : LANG );

        


        if (file_exists(LOCK_FILE_NAME)) {

            if (LANG == 'russian') {
                $message = ' Идет процесс обновления данных. <br /> <br />Попробуйте ' . anchor('/', 'Обновить страницу') . '
                <br /><br />Удалите файл  <i>' . LOCK_FILE_NAME . '</i> в корне сайта, если вы уверены, что это ошибка.<br /><br /> ' . anchor(CMS_HOME . 'user_guide_dakota/', 'Документация Dakota CMS');
            }
            else {
                $message = ' Dakota CMS is now reloading DB. <br /> Try ' . anchor('/', ' reloading page') . '<br /><br />Delete file <i>' . LOCK_FILE_NAME . '</i>
             if you have admin rights and consider this as a  technical issue. <br /><br />  ' . anchor(CMS_HOME . 'user_guide_dakota/', 'Manual Dakota CMS');

            }
            show_error($message);
            exit;

        }

        $missing_table = null;
        if (!$this->CI->db->table_exists($this->CI->config->item('sess_table_name'))) {
            $missing_table = $this->CI->config->item('sess_table_name');
        }

        if (!$this->CI->db->table_exists('dakota_settings')) {
            $missing_table = 'dakota_settings';
        }

        if ($missing_table) {
            if (LANG == 'russian') {
                $message = 'Таблица "' . $missing_table . '" не существует. <br /> <br /> ' . anchor(CMS_HOME . 'user_guide_dakota/', 'Документация Dakota CMS');
            }
            else {
                $message = 'Table "' . $missing_table . '" does not exists. System is not installed. <br /> <br /> ' . anchor(CMS_HOME . 'user_guide_dakota/', 'Manual Dakota CMS');

            }
            show_error($message);
            exit;
        }


        if ($this->CI->uri->segment(1) == 'admin') {
            define('HIDE_SIDEBAR', true);
            define('ADMIN_CENTER', true);
        } else {
            define('ADMIN_CENTER', false);
        }


        define('ROLE', Auth::has_role());
        define('ID', Auth::has_id());
        define('TOKEN', create_form_token());

        // SETTINGS CONSTANTS

        $data = $this->CI->db->get('dakota_settings');
        foreach ($data->result() as $row)
        {

            define('TITLE', $row->title);
            define('TITLE_AC', $row->title . colon() . lang('dakota_admin_center') . nbs() . colon());
            define('META_KEYWORDS', $row->meta_keywords);
            define('META_DESCRIPTION', $row->meta_description);
            define('META_EXTRA', $row->meta_extra);
            define('SHOW_PROFILE_LINK', $row->show_profile_link);
            define('REGISTRATION_ENABLED', $row->registration_enabled);
            define('MY_TEMPLATE', !empty($row->template) ? $row->template : 'default');
            define('CACHE_TTL', is_unsigned_int($row->cache_ttl) ? $row->cache_ttl : 0);

        }


        // API CONSTANTS
        $data = $this->CI->db->get('dakota_api_settings');
        foreach ($data->result() as $row)
        {


          //  define('VK_API_ACTIVE', is_unsigned_int($row->vk_api_active) ? $row->vk_api_active : 0);
            define('VK_API_ID', is_unsigned_int($row->vk_api_id) ? $row->vk_api_id : 0);
            define('VK_API_WIDGET_CLUB_ID', is_unsigned_int($row->vk_api_widget_club_id) ? $row->vk_api_widget_club_id : 0);
            define('VK_API_WIDGET_CLUB_WIDTH', is_unsigned_int($row->vk_api_widget_club_width) ? $row->vk_api_widget_club_width : 0);
            define('USE_VK_SHARE', $row->use_vk_share);
            define('USE_TWITTER_SHARE', $row->use_twitter_share );
            define('USE_FACEBOOK_SHARE', $row->use_facebook_share );
            define('SHOW_TRANSLATION_OPTION', $row->show_translation_option);

        }


        $m = new Menu_model();
        define('MENU', $m->getListedMenu());


        $this->vars = array();
        $this->vars['USERDATA'] = $this->CI->session->userdata;
        $this->vars['support_email'] = $this->CI->config->item('support_email');
        $this->vars['title'] = defined(TITLE) ? TITLE : 'Powered by Dakota CMS';


    }

    /**
     * _prepare_article
     * @param  $article_found
     * @return  article prepared
     */

    protected function _prepare_article($article_found, $query = null) {

        $a = isset($article_found[0]) ? $article_found[0] : $article_found;

        $a['found'] = false;

        if (isset($a['id'])) {

            if (isset($a['is_visible']) || Auth::is_admin()) {

                $a['found'] = true;

                if (isset($a['title'])) {
                    //      $this->vars['title'] .= ': ' . $a['title'];
                }

                if (isset($a['can_be_commented'])) {

                    $a['author_name'] = $this->_create_user_link_by_id($a['author_id']);

                }
            }


        }


        //$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
        $month = "%m";
        $day = "%d";
        $year = "%Y";
        $created_at = isset($a['created_at']) ? strtotime($a['created_at']) : now();
        $a['month'] = mdate($month, $created_at);
        $a['day'] = mdate($day, $created_at);
        $a['year'] = mdate($year, $created_at);

        if (strlen($query) > 2) {

            $a['text'] = mb_strtolower(htmlspecialchars($article_found['text']), "UTF-8");
            $query = mb_strtolower($query, "UTF-8");
            $a['text'] = highlight_phrase($a['text'], $query, '<span style="color:#990000; background-color:yellow; padding: 0 1px;">', '</span>');
            $a['title'] = highlight_phrase($a['title'], $query, '<span style="color:#990000; background-color:yellow; padding: 0 1px;">', '</span>');
            $a['has_query'] = true;
        }

        $a['comments'] = 0;

        return $a;


    }


    /**
     * @param  $id
     * @param bool $return_count   - return just count or all records
     * @return  mixed
     */

    protected function _find_comments($id, $return_count = false) {

        $comments_all = Doctrine_Query::create()
                ->select()
                ->from('Comment c')
                ->where('c.article_id = ?', $id)
                ->setHydrationMode(3)
                ->execute();

        if (!$return_count) {

            $comments_all_prepared = array();
            foreach ($comments_all as $c) {
                $c['author_link'] = $this->_create_user_link_by_id($c['author_id'] , ' name="comment' . $id  .'"');
                $comments_all_prepared[] = $c;

            }


        }
        return $return_count ? count($comments_all) : $comments_all_prepared;
    }


    /**
     * @param  $id
     * @return  formatted name
     */

    protected function _create_user_link_by_id($id , $attr = '') {

        $author = Doctrine::getTable('User')->find($id, Doctrine_Core::HYDRATE_ARRAY);
        return _create_user_link_by_user($author , $attr);

    }

}