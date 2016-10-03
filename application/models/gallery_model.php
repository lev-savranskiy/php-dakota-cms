<?php
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Gallery_model extends Model {

    var $gallery_path;
    var $gallery_path_url;
    var $config = array();

    function Gallery_model() {
        parent::Model();

        $this->gallery_path = GALLERY_FOLDER;
        $this->gallery_path_thumbs = GALLERY_FOLDER . 'thumbs/';
        $this->gallery_path_url = base_url() . GALLERY_FOLDER;
        $this->config['max_size'] = 3000;
        $this->config['max_width'] = 2048;
        $this->config['max_height'] = 2048;
        $this->config['allowed_types'] = 'jpg|jpeg|gif|png|tiff';
        $this->error = 0;
    }
    function get_config() {

        return $this->config;
    }
    
    function do_upload() {

       $thumb_type = $this->input->post('thumb_type');

        $config = array(
            'allowed_types' => $this->config['allowed_types'],
            'upload_path' => $this->gallery_path,
            'max_size' => $this->config['max_size'],
            'max_width' => $this->config['max_width'],
            'max_height' => $this->config['max_height']

        );

        if (!is_uploaded_file($_FILES['userfile']['tmp_name'])) {
            $this->error = lang('dakota_error_cant_upload');
            return;

        }


        $this->load->library('upload', $config);
        $this->upload->do_upload();
        if ($this->upload->display_errors()) {
            $this->error = $this->upload->display_errors();

        }

        $image_data = $this->upload->data();

        $name = uniqid() . '.jpg';

        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $name,
            'maintain_ratio' => true,
            'width' => 600,
            'height' => 400
        );

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();


        unset($config);


        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $this->gallery_path_thumbs . $name,
            'x_axis' => $image_data['image_width'] > 100 ? $image_data['image_width'] / 2 - 50 : 100,
            'y_axis' => $image_data['image_height'] > 100 ? $image_data['image_height'] / 2 - 50 : 100,
            'width' => 100,
            'height' => 100,
            'maintain_ratio' => false

        );

        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        $this->image_lib->$thumb_type();


        if (read_file($image_data['full_path'])) {
            unlink($image_data['full_path']);
        }


    }

    function get_images() {


        $files = array_diff(scandir($this->gallery_path_thumbs) , array('.', '..', 'thumbs', '.svn' , 'Thumbs.db'));

        $images = array();

        foreach ($files as $file) {


            if (file_exists($this->gallery_path . $file) && file_exists($this->gallery_path_thumbs . $file)) {
                $images [] = array(
                    'filename' => $file,
                    'url' => str_replace('./', '/', $this->gallery_path . $file),
                    'thumb_url' => str_replace('./', '/', $this->gallery_path_thumbs . $file),
                );

            }

        }

        return $images;
    }

}



