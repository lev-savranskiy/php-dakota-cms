<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Gallery extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!Auth::is_admin())   Auth::return_not_auth();

        $this->load->model('Gallery_model');
        $this->vars['error'] = '';
        $this->vars['title'] = TITLE_AC .  lang('dakota_gallery');
        $this->vars['thumb_types_prepared']['crop'] = 'Crop center';
        $this->vars['thumb_types_prepared']['resize'] = 'Resize';
   
    }


    /**
       * @method   Admin gallery index
       * @return data to tpl
       */


    public function index() {


        if ($this->input->post('upload')) {


            if (! check_form_token($this->input->post('token'))) return Auth::return_not_auth();
            
            if (!$this->Gallery_model->do_upload()) {
                  if ($this->Gallery_model->error) {

                 $this->vars['error'] = $this->Gallery_model->error;
                  }



             }
        }



        $this->vars['images'] = $this->Gallery_model->get_images();

        $this->vars['gallery_config'] = $this->Gallery_model->get_config();



        $this->vars['content_view'] = '/admin/gallery_view';

        $this->load->view('tpl/template', $this->vars);

    }


    /**
     * @method  Admin Gallery delete file
     * @param  $file
     * @return data to tpl
     */
    
    function delete($file, $token = null) {

        if (! check_form_token($token)) return Auth::return_not_auth();


        $this->vars['content_view'] = '/admin/gallery_view';

        $this->vars['error'] = @unlink(GALLERY_FOLDER . $file) && @unlink(GALLERY_FOLDER . '/thumbs/' . $file) ? lang('dakota_file_deleted') : lang('dakota_error_general');
        $this->vars['images'] = $this->Gallery_model->get_images();

        $this->load->view('tpl/template', $this->vars);


    }


}