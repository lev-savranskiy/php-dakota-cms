<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Widget extends Model {

    public $widgets;


    public function Widget() {


        $this->widgets = get_filenames('widgets');


    }


    public function build() {

        if (safe_count($this->widgets) > 0) {
            foreach ($this->widgets as $widget) {

                include('widgets/' . $widget);

            }
        }


    }


    public function get_info() {
        $widgets_info = array();
        if (safe_count($this->widgets) > 0) {
            
            define('SHOW_WIDGET_INFO', true);

            foreach ($this->widgets as $widget) {

                include('widgets/' . $widget);

            }
        }
        return $widgets_info;

    }


}
