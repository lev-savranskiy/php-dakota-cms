<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Captcha_lib {


    /***
     * create captcha image
     */

    static function create($size = 2) {

        $width = 20;
        $height = 20;
        $string = rand(10, 99);

        $CI = & get_instance();
        $CI->session->set_userdata(array('captcha' => $string));

        $im = ImageCreate($width, $height);
        $bg = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 0, 0, 0);
        $grey = imagecolorallocate($im, 170, 170, 170);
        //imagerectangle($im,0, 0, $width-1, $height-1, $grey);

        imagestring($im, 5, $size, 5, $string, $black);
        imagepng($im);
        imagedestroy($im);

    }


}
