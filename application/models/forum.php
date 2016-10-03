<?php
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Forum extends Doctrine_Record {

    public function setTableDefinition() {
        $this->hasColumn('title', 'string', 255);
        $this->hasColumn('description', 'string', 255);
        $this->hasColumn('category_id', 'integer', 4, array('unsigned' => true, 'notnull' => true));
    }

    public function setUp() {
        $this->setTableName('dakota_forum');

        $this->hasOne('Forum_category', array(
            'local' => 'category_id',
            'foreign' => 'id'
        ));
        $this->hasMany('Thread as Threads', array(
            'local' => 'id',
            'foreign' => 'forum_id'
        ));
    }


    public function getCategoryList() {

        return Doctrine_Query::create()
                ->select('c.title, f.title, f.description')
                ->addSelect('t.id, COUNT(t.id) as num_threads')
                ->from('Forum_category c, c.Forums f')

                ->leftJoin('f.Threads t')
                ->groupBy('f.id')
                ->execute();

    }


    public function getCategory($id) {

        return Doctrine::getTable('Forum_category')->find($id);

    }


    public function getCategoryForums($id) {


        return Doctrine_Query::create()
                ->select('*')
                ->from('Forum')
                ->where('category_id = ?', $id)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();

    }

    public function numThreads() {

        $result = Doctrine_Query::create()
                ->select('COUNT(*) as num_threads')
                ->from('Thread')
                ->where('forum_id = ?', $this->id)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->fetchOne();

        return $result['num_threads'];

    }


    public function getThreadsArray($offset, $limit) {

        $threads = Doctrine_Query::create()
                ->select('t.title')
                ->addSelect('p.id, (COUNT(p.id) - 1) as num_replies')
                ->addSelect('MIN(p.id) as first_post_id')
                ->addSelect('MAX(p.created_at) as last_post_date')
                ->from('Thread t, t.Posts p')
                ->where('t.forum_id = ?', $this->id)
                ->groupBy('t.id')
                ->orderBy('last_post_date DESC')
                ->limit($limit)
                ->offset($offset)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();

        foreach ($threads as &$thread) {

            $post = Doctrine_Query::create()
                    ->select('p.created_at, u.firstname, u.lastname')
                    ->from('Post p, p.User u')
                    ->where('p.id = ?', $thread['Posts'][0]['first_post_id'])
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->fetchOne();

            $thread['num_replies'] = $thread['Posts'][0]['num_replies'];
            $thread['created_at'] = $post['created_at'];
            $thread['username'] = $post['User']['firstname'] . ' ' . $post['User']['lastname'];
            $thread['user_id'] = $post['User']['id'];
            unset($thread['Posts']);

        }

        return $threads;

    }


}
