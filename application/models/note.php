<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Note  extends Doctrine_Record {

	public function setTableDefinition() {

		$this->hasColumn('text', 'string', 1000 , array('notnull' => true));
		$this->hasColumn('author_id', 'integer' , 4 , array('notnull' => true));

	}

	public function setUp() {
		$this->setTableName('dakota_notepad');
		$this->actAs('Timestampable');

        $this->hasOne('User', array(
			'local' => 'author_id',
			'foreign' => 'id'
		));

	}


}
