<?php
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Post extends Doctrine_Record {
	
	public function setTableDefinition() {
		$this->hasColumn('content', 'string', 65535);
		$this->hasColumn('thread_id', 'integer', 4, array('unsigned' => true, 'notnull' => true));
		$this->hasColumn('user_id', 'integer', 4,array('unsigned' => true, 'notnull' => true));
	}

	public function setUp() {

       $this->setTableName('dakota_forum_posts');

		$this->actAs('Timestampable');
		$this->hasOne('Thread', array(
			'local' => 'thread_id',
			'foreign' => 'id'
		));
		$this->hasOne('User', array(
			'local' => 'user_id',
			'foreign' => 'id'
		));

//         $this->actAs('Searchable',
//            array(
//                'fields' => array('content'),
//                'batchUpdates' => true
//            )
//        );

	}


      public function destroy() {

        try {
            Doctrine_Query::create()
                    ->delete('Post c')
                    ->where('c.id = ' . $this->id)
                    ->execute();
            return true;
        }
        catch (Exception $e)  {

            return $e;

        }

    }
	
}
