<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Comment extends Doctrine_Record {

	public function setTableDefinition() {

		$this->hasColumn('comment', 'string', 1000 , array('notnull' => true));
		$this->hasColumn('author_id', 'integer' , 4 , array('notnull' => true));
		$this->hasColumn('article_id', 'integer' , 4 , array('notnull' => true));

	}
	
	public function setUp() {
		$this->setTableName('dakota_comment');
		$this->actAs('Timestampable');

        $this->hasOne('User', array(
			'local' => 'author_id',
			'foreign' => 'id',
             'onDelete' => 'CASCADE'
		));

        $this->hasOne('Article', array(
			'local' => 'article_id',
			'foreign' => 'id',
             'onDelete' => 'CASCADE'
		));


	}

}
