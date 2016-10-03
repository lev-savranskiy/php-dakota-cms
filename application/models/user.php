<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */

class User extends Doctrine_Record {

    public function setTableDefinition() {

        $this->hasColumn('email', 'string', 255, array('unique' => 'true', 'notnull' => true));
        $this->hasColumn('password', 'string', 255, array('notnull' => true));
        $this->hasColumn('firstname', 'string', 255);
        $this->hasColumn('lastname', 'string', 255);
        $this->hasColumn('role', 'integer', 3, array('default' => 10, 'notnull' => true));
        $this->hasColumn('ip', 'string', 255);
        $this->hasColumn('country', 'string', 255);
        $this->hasColumn('city', 'string', 255);
        $this->hasColumn('settings', 'string', 1000);
        $this->hasColumn('active', 'boolean', 4, array('default' => false));
        $this->hasColumn('reset_pass_key',  'string', 255);
        $this->hasColumn('last_login', 'timestamp');
    }

    public function setUp() {
        $this->setTableName('dakota_user');
        $this->actAs('Timestampable');
        $this->hasMutator('password', '_encrypt_password');

        $this->hasMany('Comment as Comments', array(
            'local' => 'id',
            'foreign' => 'author_id',
            'onDelete' => 'CASCADE'
        ));

        $this->hasMany('Article as Articles', array(
            'local' => 'id',
            'foreign' => 'author_id',
            'onDelete' => 'CASCADE'
        ));

        $this->hasMany('Post as Posts', array(
            'local' => 'id',
            'foreign' => 'user_id'
        ));

    }

    public function _total($include_non_active = false) {

        if ($include_non_active) {

            $result = Doctrine_Query::create()
                    ->select('COUNT(*) as total')
                    ->from('User')
                    ->fetchOne();
        }
        else {
            $result = Doctrine_Query::create()
                    ->select('COUNT(*) as total')
                    ->where('active = ?', true)
                    ->from('User')
                    ->fetchOne();
        }


        return $result['total'];

    }

    public function find_publications($userid) {
        return Doctrine::getTable('Article')->findByAuthor_id($userid, 3);
    }


    public function find_comments($userid) {
        return Doctrine::getTable('Comment')->findByAuthor_id($userid, 3);
    }

    public function find_posts($userid) {
        return Doctrine::getTable('Post')->findByUser_id($userid, 3);
    }


    protected function _encrypt_password($value) {
        $CI = & get_instance();
        $salt = $CI->config->item('salt');
        $this->_set('password', md5($salt . $value));
    }
}
