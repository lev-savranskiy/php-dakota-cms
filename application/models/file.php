<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class File extends Model {

    public $uploaded_files = array();
    public $files_count = 0;
    public $files_total_size = 0;


    public function File() {

        //Open directory for reading
        $dh = opendir(UPLOAD_FOLDER);
        $exclude   =array('.', '..', 'thumbs', '.svn' , 'Thumbs.db');

        //LOOP through the files
        while (($file = readdir($dh)) !== false)
        {
            if (! in_array( $file  , $exclude)) {
                $temp = array();
                $temp['filename'] = $file;
                $temp['size'] = $this->formatBytes(filesize(UPLOAD_FOLDER .  $temp['filename']));

                preg_match("/\.([^\.]+)$/", $temp['filename'], $matches);
                $temp['filetype'] = isset($matches[1]) ? $this->getFileType($matches[1]): 'Documents';
                $temp['added'] = date("F d Y H:i:s.", filemtime(UPLOAD_FOLDER .  $temp['filename']));


                $this->uploaded_files[] = $temp;
                $this->files_count++;
                $this->files_total_size += filesize(UPLOAD_FOLDER .  $temp['filename']);


            }
        }
        closedir($dh);


    }


    public function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


    function getFileType($extension) {
        $images = array('jpg', 'gif', 'png', 'bmp', 'jpeg');
        $arch = array('zip', 'rar', 'gtar', 'tar', 'gz', '7z');
        $video = array('mpeg', 'mpg', 'mpe', 'qt', 'mov', 'avi', 'movie', 'flv');
        $music = array('wma', 'mp3', 'ogg', 'flac', 'ram', 'aiff', 'mid');


        if (in_array($extension, $images)) return "Images";
        if (in_array($extension, $arch)) return "Archives";
        if (in_array($extension, $video)) return "Video";
        if (in_array($extension, $music)) return "Music";
        return "Documents";

    }
    

    public function build() {

        $files = '';

        if (safe_count($this->uploaded_files) > 0) {
            foreach ($this->uploaded_files as $uploaded_file) {



                    $atts = array(
                        'width' => '600',
                        'height' => '400',
                        'scrollbars' => 'yes',
                        'status' => 'no',
                        'resizable' => 'yes',
                        'screenx' => '0',
                        'screeny' => '0'
                    );


             $files .= "<li class=\"" . $uploaded_file['filetype'] . "\"><span style='display:block;'>";

              if ($uploaded_file['filetype'] == 'Images' || $uploaded_file['filetype'] == 'Documents') {
                  $files .= anchor_popup(base_url() . UPLOAD_FOLDER . $uploaded_file['filename'], $uploaded_file['filename'], $atts);
              }
              else {
                  $files .= anchor(base_url() . UPLOAD_FOLDER . $uploaded_file['filename'], $uploaded_file['filename']);
              }

             $files .= "</span>  Size: " . $uploaded_file['size'] .  "  Created: " . $uploaded_file['added'] . " "
              . anchor(base_url() . UPLOAD_FOLDER . $uploaded_file['filename'], lang('dakota_copy'), ' onclick="return copyTitleInLink(this);" style="background:none;"') . " "
                      . anchor('/admin/files/delete/' . $uploaded_file['filename'] . '/'. TOKEN , lang('dakota_delete') , ' style="background:none;"') . " "

                      . "</li> \n";
                }


            }


        return $files;


    }

     public function upload() {        
        $config['upload_path'] = UPLOAD_FOLDER;

        if (@require(APPPATH . 'config/mimes' . EXT)) {
            $temp = array_keys($safe_mimes);
            $config['allowed_types'] = implode('|', $temp);
        }

        $config['max_size'] = UPLOAD_MAX_SIZE * 1000;
        $config['max_width'] = '2560';
        $config['max_height'] = '1600';


        $file_name = $_FILES['userfile']['name'];
//        $ext = strrchr($_FILES['userfile']['name'], '.');
//        if ($ext !== false) {
//            $file_name = substr($_FILES['userfile']['name'], 0, -strlen($ext));
//        }

        $config['file_name'] = url_title_rus($file_name)  ;

        $this->load->library('upload', $config);

         return $this->upload->do_upload();
       }


}
