<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class MY_Upload extends CI_Upload {

    // --------------------------------------------------------------------

    /**
     * List of Mime Types
     *
     * This is a list of mime types.  We use it to validate
     * the "allowed types" set by the developer
     *
     * @access    public
     * @param    string
     * @return    string
     */
    function mimes_types($mime) {
        global $mimes;

        if (count($this->mimes) == 0) {
            if (@include(APPPATH . 'config/mimes' . EXT)) {
                $this->mimes = $mimes;
                unset($mimes);
            }
        }

        return (!isset($this->mimes[$mime])) ? FALSE : $this->mimes[$mime];
    }


    /**
     * Display the error message
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    string
     */
    function display_errors($open = '<p class="error">', $close = '</p>') {
        $str = '';
        foreach ($this->error_msg as $val)
        {
            $str .= $open . $val . $close;
        }

        return $str;
    }


    /**
     * Verify that the filetype is allowed
     *
     * @access    public
     * @return    bool
     */
    function is_allowed_filetype() {


        if (@include(APPPATH . 'config/mimes' . EXT)) {

            if (in_array(str_replace('.', '', $this->file_ext), $bad_mimes))         return FALSE;

        }


        if ((isset($this->allowed_types[0]) && $this->allowed_types[0] == '') OR !is_array($this->allowed_types)) {
            $this->set_error('upload_no_file_types');
            return FALSE;

        }


        $image_types = array('gif', 'jpg', 'jpeg', 'png', 'jpe');

//    print_r($this->mimes_types($this->file_ext));
//    print_r($this->file_ext);
//    exit('zzz');

        foreach ($this->allowed_types as $val)
        {
            $mime = $this->mimes_types(strtolower($val));


            // Images get some additional checks
            if (in_array($val, $image_types) && $this->is_image()) {
                if (getimagesize($this->file_temp) === FALSE) {
                    return FALSE;
                }
            }

            if (is_array($mime)) {
                if (in_array($this->file_type, $mime, TRUE)) {
                    return TRUE;
                }

            }
            else
            {
                if ($mime == $this->file_type) {
                    return TRUE;
                }
            }
        }

        return FALSE;


    }

    // --------------------------------------------------------------------

}
// END Upload Class

/* End of file MY_Upload.php */
/* Location: ./system/application/libraries/MY_Upload.php */