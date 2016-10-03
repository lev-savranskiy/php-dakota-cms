<?php
/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */


class Menu_model extends Doctrine_Record {

    public function setTableDefinition() {
        $this->hasColumn('title', 'string', 255, array('notnull' => true));
        $this->hasColumn('url', 'string', 255, array('notnull' => true));
        $this->hasColumn('parent_id', 'integer', 4, array('unsigned' => true, 'default' => 0));
        $this->hasColumn('order_id', 'integer', 4, array('unsigned' => true, 'notnull' => true));
    }

    public function setUp() {
        $this->setTableName('dakota_menu');
    }


    public function getMenuArray() {
        return Doctrine_Query::create()
                ->select('*')
                ->from('Menu_model')
                ->orderby('order_id')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();

    }

    /**
     * getSiteUrls defined in config_russian and add articles and forum links
     * @return  menu prepared
     */


    public function getSiteUrls() {

        $CI = & get_instance();


        $urls_array_raw = $CI->config->item('site_urls');


        if (safe_count($urls_array_raw) > 0) {
            foreach ($urls_array_raw as $k => $v) {

                $urls_array[$k] = array( 'title' => $this->_prepare_title($v, 0) , 'lang' => $v);
            }
        }


      //  $urls_array['#none#'] = '-- Not Selected --';

        // add Articles to menu
        $a = new Article();
        $articles_visible = $a->get_articles(100, 0);

        //print_r($articles_visible);
        if (safe_count($articles_visible) > 0) {

            foreach ($articles_visible as $av) {
                $temp_url = '/articles/id/' . $av['id'];

                $urls_array[$temp_url] = array( 'title' => '->' . $av['title'] , 'lang' => '');

                     }
        }

        // add Articles to menu
        $f = new Forum();
        $CategoryList = $f->getCategoryList();

        foreach ($CategoryList as $category) {
            foreach ($category->Forums as $forum) {
                $temp_url = '/forums/display/' . $forum->id;
                $urls_array[$temp_url] = array( 'title' => '->' .$forum->title , 'lang' => '');

            }
        }

        ksort_r($urls_array);
       // print_r($urls_array);
        return $urls_array;
    }

    /**
     * getListedMenu
     * @param  $admin_mode bool
     * @return  menu prepared
     */

    public function getListedMenu($admin_mode = false) {

        ksort_r($this->getMenuArray());

        $list_type = $admin_mode ? 'ol' : 'ul';

        $MenuArray = $this->getMenuArray();

        $RootArray = array();

        foreach ($MenuArray as $k => $v) {
            if ($v['parent_id'] == 0) {
                $RootArray[] = $v;
            }
        }
        //  print_r($RootArray);


        $lm = '<' . $list_type . '>';

        foreach ($MenuArray as $k => $v) {
            if ($v['parent_id'] == 0) {


                $last = $v['order_id'] == safe_count($RootArray) ? '_last' : '';


                $lm .= '<li  class="menu_root' . $last . '" id="menu_' . $v['order_id'] . '" >' . anchor($v['url'], $this->_prepare_title($v['title'], $admin_mode), $this->_create_attr_links($v, $admin_mode));

                if ($admin_mode) {
                    $lm .= $this->_create_edit_links($v);
                }

            }

            $sub = array();
            foreach ($MenuArray as $k1 => $v1) {
                if ($v1['parent_id'] == $v['id']) {

                    $sub[$v1['order_id']] = $v1;
                }

            }
            //    print_r($sub);
            ksort($sub);
            if (safe_count($sub) > 0) {

                $lm .= '<' . $list_type . '>';
                foreach ($sub as $s) {
                    $lm .= '<li>' . anchor($s['url'], $this->_prepare_title($s['title'], $admin_mode), $this->_create_attr_links($s, $admin_mode));

                    if ($admin_mode) {
                        $lm .= $this->_create_edit_links($s);
                    }

                    $lm .= '</li>';

                }

                $lm .= '</' . $list_type . '>';
            }


            if ($v['parent_id'] == 0) {
                $lm .= '</li>';
            }

        }
        $lm .= '</' . $list_type . '>';

        return $lm;

    }

    /**
     * getSublingsByParentId
     * @param  $ParentId
     * @return  Sublings Collection
     */

    public function getSublingsByParentId($ParentId) {
        return Doctrine::getTable('Menu_model')->findByParent_id($ParentId, 3);
    }


    /**
     * getPrevElement
     * @param  $Element
     * @return  PrevElement
     */

    public function getPrevElement($element) {

        $new_pos = $element['order_id'] - 1;

        $q = Doctrine_Query::create()
                ->select()
                ->from('Menu_model')
                ->where('parent_id =  ' . $element['parent_id'])
                ->andWhere('order_id  =   ' . $new_pos)
                ->setHydrationMode(3)
                ->execute();
        //  echo $q->getSqlQuery();
        return $q;

    }

    /**
     * getNxtElement
     * @param  $Element
     * @return  PrevElement
     */

    public function getNextElement($element) {

        $new_pos = $element['order_id'] + 1;

        $q = Doctrine_Query::create()
                ->select()
                ->from('Menu_model')
                ->where('parent_id =  ' . $element['parent_id'])
                ->andWhere('order_id  =   ' . $new_pos)
                ->setHydrationMode(3)
                ->execute();
        //  echo $q->getSqlQuery();
        return $q;
    }


    /**
     * move Menu element  down
     * @param  $Element
     * @return  void
     */

    public function moveDown($element) {


        $point_next = $this->getNextElement($element);
        $point_next_id = isset($point_next[0]['id']) ? $point_next[0]['id'] : null;
        $point_next_order = isset($point_next[0]['order_id']) ? $point_next[0]['order_id'] : null;

        if ($this->_is_last($element) || !$point_next_id || !$point_next_order) {
            return false;

        }

        else {
            $q = Doctrine_Query::create()
                    ->update('Menu_model')
                    ->set('order_id', $point_next_order)
                    ->where('id = ' . $element['id'])
                    ->execute();
            //  echo $q->getSqlQuery();

            $q = Doctrine_Query::create()
                    ->update('Menu_model')
                    ->set('order_id', $point_next_order - 1)
                    ->where('id = ' . $point_next_id)
                    ->execute();
        }
        //   exit($error);
        return true;
    }


    /**
     * move Menu element  up
     * @param  $Element
     * @return  void
     */

    public function moveUp($element) {


        $point_prev = $this->getPrevElement($element);
        $point_prev_id = isset($point_prev[0]['id']) ? $point_prev[0]['id'] : null;
        $point_prev_order = isset($point_prev[0]['order_id']) ? $point_prev[0]['order_id'] : null;


        if ($this->_is_first($element) || !$point_prev_id || !$point_prev_order) {
            return false;
        }

        else {
            $q = Doctrine_Query::create()
                    ->update('Menu_model')
                    ->set('order_id', $point_prev_order)
                    ->where('id = ' . $element['id'])
                    ->execute();
            //  echo $q->getSqlQuery();

            $q = Doctrine_Query::create()
                    ->update('Menu_model')
                    ->set('order_id', $point_prev_order + 1)
                    ->where('id = ' . $point_prev_id)
                    ->execute();

        }

        return true;
    }


    /**
     * delete menu
     * @param  $id
     * @return  void
     */


    public
    function delete($id) {
        Doctrine_Query::create()
                ->delete('Menu_model m')
                ->where('m.parent_id = ' . $id)
                ->orWhere('m.id = ' . $id)
                ->execute();
    }


    /**
     * _is_first
     * @param  $id
     * @return  bool
     */
    public
    function _is_first($s) {
        return $s['order_id'] == 1;
    }


    /**
     * _is_last
     * @param  $id
     * @return  bool
     */
    public
    function _is_last($s) {
        return $s['order_id'] == safe_count($this->getSublingsByParentId($s['parent_id']));
    }


    /**
     * _create_attr_links
     * @param  menu
     * @return  html
     */
    private
    function _create_attr_links($s, $admin_mode = false) {

        $attr = '';


//         if (isset($s['parent_id']) && $s['parent_id'] == 0) {
//
//             $attr .= '  class="menu_root" ';
//         }


        if ($admin_mode && isset($s['order_id'])) {

            $attr .= ' rel="' . $s['order_id'] . '"';
        }

        if (isset($s['url']) && (substr($s['url'], 0, 4) == 'http')) {
            $attr .= ' target="_blank"';
        }

        return $attr;
    }

    /**
     * _prepare_title
     * @param  title
     * @return  prepared title
     */
    private function _prepare_title($title, $admin_mode = true) {


        if (!$admin_mode && strpos($title, '%') === 0) {

            $clean_title = str_replace('%', '', $title);

            $title = lang($clean_title);
        }


        return $title;
    }


    /**
     * _create_edit_links
     * @param  menu
     * @return  html
     */

    private
    function _create_edit_links($s) {

        $id = $s['id'];
        $text = null;
        $del_link = '/admin/menu/delete/' . $id . '/' . TOKEN;


        $links = nbs(2);

        if (!$this->_is_first($s)) {

            $links .= nbs(2) . anchor_img('/admin/menu/move/up/' . $id . '/' . TOKEN, ' title="' . lang('dakota_up') . '"', ICON_UP);
        }

        if (!$this->_is_last($s)) {
            $links .= nbs(1) . anchor_img('/admin/menu/move/down/' . $id . '/' . TOKEN, ' title="' . lang('dakota_down') . '"', ICON_DOWN);
        }


        $links .= nbs(1) . anchor_img('admin/menu/update/' . $id, ' title="' . lang('dakota_edit') . '" ', ICON_EDIT);
        $links .= nbs(3) . anchor_img('#', ' title="' . lang('dakota_delete') . '" onclick="goConfirm(\'' . $del_link . '\'   ' . $text . ' ); return false; "', ICON_DELETE);


        return $links;


    }


}
