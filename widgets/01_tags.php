<?

$widget_info['active'] = 1;
$widget_info['title'] = lang('dakota_tags');
$widget_info['description'] = lang('dakota_list') . '/' . lang('dakota_tags_cloud');
$widget_info['url'] = 'http://dakota-cms.com';
$widgets_info[] = $widget_info;

$tags_type = 'cloud'; // list or cloud


if (!defined('SHOW_WIDGET_INFO') && $widget_info['active']) {

    echo '<li  id="widget_tags">';

/*------------------------  start your code here  ----------- */

    $CI = & get_instance();
    $query = $CI->db->query('SELECT * FROM dakota_article WHERE is_visible = 1');
    $tags = array();

    foreach ($query->result() as $row)
    {

        for ($i = 1; $i < 6; $i++) {
            $tagname = 'tag' . $i;

            if (isset($row->$tagname) && $row->$tagname != '') {

                if (array_key_exists($row->$tagname, $tags)) {
                    $tags[$row->$tagname] = $tags[$row->$tagname] + 1;
                }
                else {
                    $tags[$row->$tagname] = 1;
                }

            }

        }
    }


    echo '<h2 id="tags-1-a"  style="display:block;" >' .lang('dakota_tags_cloud') .' <a  class="more" style="font-size: 17px;" href ="#" onclick=" $(\'#tags-list\').fadeIn(\'slow\');  $(\'#tags-cloud\').fadeOut(\'slow\'); $(\'#tags-1-a\').hide();  $(\'#tags-2-a\').show(); return false;">' .lang('dakota_list') .'</a></h2>';
    echo '<h2  id="tags-2-a" style="display:none;">' .lang('dakota_list') .'  <a  style="font-size: 17px;" class="more" href ="#" onclick=" $(\'#tags-list\').fadeOut(\'slow\');  $(\'#tags-cloud\').fadeIn(\'slow\');  $(\'#tags-1-a\').show(); $(\'#tags-2-a\').hide(); return false;">' .lang('dakota_tags_cloud') .'</a></h2>';


    echo '<ul id="tags-list" style="display:none;">';
    foreach ($tags as $k => $v) {


        echo '<li><a href="/articles/tag/' . $k . '">' . $k . '</a> (' . $v . ')</li>';

    }
    echo '</ul>';

    echo '<ul id="tags-cloud">';
    foreach ($tags as $k => $v) {

        $font_size = 10 + $v * 2;
        echo ICON_BULL . '<a style="font-size: ' . $font_size . 'px" href="/articles/tag/' . $k . '">' . $k . '</a><span style="font-size: ' . $font_size . 'px;"></span>';

    }
    echo '</ul>';


// end your code here
    echo '</li>';
}



