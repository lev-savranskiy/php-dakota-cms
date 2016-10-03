<?php
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Forum_category  extends Doctrine_Record {
	
	public function setTableDefinition() {
		$this->hasColumn('title', 'string', 255);
	}

	public function setUp() {

        $this->setTableName('dakota_forum_categories');

		$this->hasMany('Forum as Forums', array(
			'local' => 'id',
			'foreign' => 'category_id'
		));
	}
}
