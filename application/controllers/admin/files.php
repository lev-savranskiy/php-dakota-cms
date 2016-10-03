<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */


class Files extends MY_Controller {

    
    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();

        $this->load->model('file');

        $this->vars['files'] = $this->file->build();
        $this->vars['files_count'] = $this->file->files_count;
        $this->vars['files_total_size'] = $this->file->formatBytes($this->file->files_total_size);
        $this->vars['content_view'] = '/admin/file_view';
        $this->vars['title'] = TITLE_AC .  lang('dakota_files');
    }


    /**
       * @method   Admin Files index
       * @return data to tpl
       */



    public function index() {

        $this->vars['error'] = '';
        $this->load->view('tpl/template', $this->vars);

    }


        /**
     * @method   Admin Files delete
     * @param  $file
     * @return data to tpl
     */
    
    function delete($file, $token = null) {
        
        if (! check_form_token($token)) return Auth::return_not_auth();

        $this->vars['error'] = @unlink(UPLOAD_FOLDER . $file) ? lang('dakota_file_deleted') : lang('dakota_error_general');
        $f =  new File();
        $this->vars['files'] = $f->build();
        $this->vars['files_count'] = $f->files_count;
        $this->vars['files_total_size'] = $f->formatBytes($this->file->files_total_size);

        $this->load->view('tpl/template', $this->vars);


    }

    /**
     * @method   Admin Files upload
     * @return data to tpl
     */


    function do_upload() {

        if (! check_form_token($this->input->post('token'))) return Auth::return_not_auth();


        if (!$this->file->upload()) {



            $this->vars['error'] = $this->upload->display_errors();

            $this->load->view('tpl/template', $this->vars);
        }
        else
        {
            redirect('/admin/files/');

        }
    }

}