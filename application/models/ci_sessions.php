<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Ci_Sessions extends Doctrine_Record {

	public function setTableDefinition() {

        $this->hasColumn('session_id', 'string', 40, array( 'default' => '0', 'notnull' => true));
		$this->hasColumn('ip_address', 'string', 16 , array('default' => '0',  'notnull' => true));
	    $this->hasColumn('user_agent', 'string', 50 , array('notnull' => true));
        $this->hasColumn('last_activity', 'integer', 10 ,  array('default' => '0', 'default' => true));
        $this->hasColumn('last_activity', 'string', 1000 ,  array('default' => true));

	}
	
	public function setUp() {
		$this->setTableName('ci_sessions');
		$this->actAs('Timestampable');
	}

}
