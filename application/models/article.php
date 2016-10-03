<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class Article extends Doctrine_Record {

    public function setTableDefinition() {

        $this->hasColumn('title', 'string', 255, array('notnull' => true));
        $this->hasColumn('text', 'string', 10000, array('notnull' => true));
        $this->hasColumn('url', 'string', 255, array('unique' => 'true', 'notnull' => true));
        $this->hasColumn('tag1', 'string', 50);
        $this->hasColumn('tag2', 'string', 50);
        $this->hasColumn('tag3', 'string', 50);
        $this->hasColumn('tag4', 'string', 50);
        $this->hasColumn('tag5', 'string', 50);
        $this->hasColumn('author_id', 'integer', 4, array('notnull' => true));
        $this->hasColumn('is_main', 'boolean', 1, array('default' => false));
        $this->hasColumn('is_visible', 'boolean', 1, array('default' => false));
        $this->hasColumn('is_page', 'boolean', 1, array('default' => false));
        $this->hasColumn('can_be_commented', 'boolean', 1, array('default' => false));

    }

    public function setUp() {
        $this->setTableName('dakota_article');
        $this->actAs('Timestampable');

        $this->hasOne('User', array(
            'local' => 'author_id',
            'foreign' => 'id',
            'onDelete' => 'CASCADE'
        ));

        $this->hasMany('Comment as Comments', array(
            'local' => 'id',
            'foreign' => 'article_id',
            'onDelete' => 'CASCADE'
        ));


//        $this->actAs('Searchable',
//            array(
//                'fields' => array('title', 'text'),
//                'batchUpdates' => true
//            )
//        );
  


    }


    /*
     *  Total Article number     includes    non visible
     *
     */
    public function total() {

        $result = Doctrine_Query::create()
                ->select('COUNT(*) as total')
                ->from('Article')
                ->fetchOne();

        return $result['total'];

    }

    /*
    *  Total Article number    - only     is_visible and no_page
    *
    */

    public function total_articles() {

        $result = Doctrine_Query::create()
                ->select('COUNT(*) as total')
                ->from('Article a')
                ->where('a.is_visible = 1')
                ->andWhere('a.is_page = 0')
                ->fetchOne();

        return $result['total'];

    }

     /*
    *  get_articles list    only     is_visible and no_page
    *  @param $limit
    *  @param $offset
    */

    public function get_articles($limit, $offset) {

        return Doctrine_Query::create()
                ->select()
                ->from('Article a')
                ->where('a.is_visible = 1')
               // ->andWhere('a.is_page = 0')
                ->orderBy('a.updated_at DESC')
                ->setHydrationMode(3)
                ->limit($limit)
                ->offset($offset)
                ->execute();

    }


    /*
   *  get_articles list    only     is_visible and no_page
   *  @param $limit
   *  @param $offset
   */

   public function get_tags() {


         $CI = & get_instance();
        $query = $CI->db->query('SELECT * FROM dakota_article');
        $availableTags = array();

        foreach ($query->result() as $row)
        {
            for ($i = 1; $i < 6; $i++) {
                $tagname = 'tag' . $i;
                if (isset($row->$tagname) && $row->$tagname != '') {
                    $availableTags[] = $row->$tagname;
                }
            }
        }
       return $availableTags;

   }



      /*
    *      main article
    */

    public function get_main() {

        return Doctrine_Query::create()
                ->select()
                ->from('Article a')
                ->where('a.is_main = 1')
                ->andWhere('a.is_visible = 1')
                ->setHydrationMode(3)
                 ->execute() ;


    }
}
