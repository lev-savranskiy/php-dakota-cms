<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Global_Settings extends Doctrine_Record {

	public function setTableDefinition() {

        $this->hasColumn('title', 'string', 1000, array( 'notnull' => true));
		$this->hasColumn('meta_keywords', 'string', 1000 , array('notnull' => true));
	    $this->hasColumn('meta_description', 'string', 1000);
	    $this->hasColumn('meta_extra', 'string', 1000);
        $this->hasColumn('show_profile_link', 'boolean', 1,  array('default' => true));
        $this->hasColumn('registration_enabled', 'boolean', 1,  array('default' => true));
        $this->hasColumn('template', 'string', 1000 ,array('default' => 'default'));
        $this->hasColumn('cache_ttl', 'integer', 8  ,array('default' => 0));
        $this->hasColumn('vk_api_id', 'integer', 8  ,array('default' => 0));

	}
	
	public function setUp() {
		$this->setTableName('dakota_settings');
		$this->actAs('Timestampable');
	}

}
