<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */
class MY_Loader extends CI_Loader {


    // --------------------------------------------------------------------

    /**
     *
     * This function is used to load a external  template file.
     *
     * @access    public
     * @param   $file The name of the  file to be included.
     * @param   $path The PATH to  file to be included.
     * @return    void
     */

    function external_tpl($file, $path = null) {


        if (!ADMIN_CENTER) {

            clearstatcache();

            if (!isset($path)) $path = TEMPLATES_FOLDER . MY_TEMPLATE;

            $ext_file = './' . $path . '/' . $file . '.tpl';
            if (file_exists($ext_file)) {
                include_once($ext_file);
            }
        }


    }


}