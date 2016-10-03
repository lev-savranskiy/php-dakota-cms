<?php
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Thread extends Doctrine_Record {

    public function setTableDefinition() {
        $this->hasColumn('title', 'string', 255);
        $this->hasColumn('forum_id', 'integer', 4, array('unsigned' => true, 'notnull' => true));
    }

    public function setUp() {

        $this->setTableName('dakota_forum_threads');

        $this->hasOne('Forum', array(
            'local' => 'forum_id',
            'foreign' => 'id'
        ));
        $this->hasMany('Post as Posts', array(
            'local' => 'id',
            'foreign' => 'thread_id'
        ));
    }

     public function getFirstPost() {

        return $this->getPostsArray(0,1);

    }


    public function getPostsArray($offset, $limit) {

        $posts = Doctrine_Query::create()
                ->select()
                ->from('Post p, p.User')
                ->where('p.thread_id = ?', $this->id)
                ->groupBy('p.id')
                ->limit($limit)
                ->offset($offset)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ;



      // print_r($posts->getSqlQuery());
        return $posts->execute();

    }


    public function firstPost() {

        $result = Doctrine_Query::create()
                ->select()
                ->from('Post')
                ->where('thread_id = ?', $this->id)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->fetchOne();

        return $result;

    }

    public function numPosts() {

        $result = Doctrine_Query::create()
                ->select('COUNT(*) as num')
                ->from('Post')
                ->where('thread_id = ?', $this->id)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->fetchOne();

        return $result['num'];

    }

    public function destroy() {

        try {
            Doctrine_Query::create()
                    ->delete('Post c')
                    ->where('c.thread_id = ' . $this->id)
                    ->execute();

            Doctrine_Query::create()
                    ->delete('Thread t')
                    ->where('t.id = ' . $this->id)
                    ->execute();
            return true;
        }
        catch (Exception $e) {

            return $e;

        }

    }

}