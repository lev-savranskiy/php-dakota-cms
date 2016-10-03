<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Api_Settings extends Doctrine_Record {

	public function setTableDefinition() {
      //  $this->hasColumn('vk_api_active', 'integer', 8  ,array('default' => 0));
        $this->hasColumn('vk_api_id', 'integer', 8  ,array('default' => 0));
        $this->hasColumn('vk_api_widget_club_id', 'integer', 8  ,array('default' => 0));
        $this->hasColumn('vk_api_widget_club_width', 'integer', 8  ,array('default' => 0));
        $this->hasColumn('use_facebook_share', 'integer', 1  ,array('default' => 1));
        $this->hasColumn('use_vk_share', 'integer', 1  ,array('default' => 1));
        $this->hasColumn('use_twitter_share', 'integer', 1  ,array('default' => 1));
        $this->hasColumn('show_translation_option', 'boolean', 1,  array('default' => 0));



	}
	
	public function setUp() {
		$this->setTableName('dakota_api_settings');
		$this->actAs('Timestampable');
	}

}
