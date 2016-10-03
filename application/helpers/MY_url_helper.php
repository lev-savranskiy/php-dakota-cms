<?php

/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */


/**
 * @param  $user( id , firstname,    lastname)
 * @return  formatted name
 */

function _create_user_link_by_user($user, $attr = '') {

    $attr .= ' class="notranslate" ';

    return anchor('/users/id/' . $user['id'], $user['firstname'] . ' ' . $user['lastname'], $attr);

}

/**
 * @param  $str
 * @return  formatted name
 */

function bbcode($string) {

    $search = array(
        '/[b\](.*?)\[\/b\]/is',
        '/[i\](.*?)\[\/i\]/is',
        '/[u\](.*?)\[\/u\]/is',
        '/[img\](.*?)\[\/img\]/is',
        '/[url\=(.*?)\](.*?)\[\/url\]/is',
        '/[code\](.*?)\[\/code/]/is'
    );
    $replace = array(
        '<b>\\1</b>',
        '<i>\\1</i>',
        '<u>\\1</u>',
        '<img src="\\1" />',
        '<a href="\\1">\\2</a>',
        '<code>\\1</code>'
    );
    return preg_replace($search, $replace, $string);

}


/* fixed   auto_link */

function auto_link($str, $type = 'both', $blank = FALSE) {

    $blank_text = $blank ? ' target ="_blank"' : '';

    if ($type != 'email') {

        $str = preg_replace("#(https?://|www.)+[a-z0-9-]+[\.a-z]+[\/a-z0-9_\#\@\?\&\=\.\-]*#i", ("$1" != 'www.') ? "<a href='$0' $blank_text>$0</a>" : "<a href='http://$0' $blank_text>$0</a>", $str);

    }

    if ($type != 'url') {

        if (preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches)) {
            for ($i = 0; $i < count($matches['0']); $i++)
            {
                $period = '';
                if (preg_match("|\.$|", $matches['3'][$i])) {
                    $period = '.';
                    $matches['3'][$i] = substr($matches['3'][$i], 0, -1);
                }

                $str = str_replace($matches['0'][$i], safe_mailto($matches['1'][$i] . '@' . $matches['2'][$i] . '.' . $matches['3'][$i]) . $period, $str);
            }
        }
    }

    return $str;

}

/* eng to RUS converter */

function url_title_rus($title) {

    $iso = array(
        "Є" => "YE", "І" => "I", "Ѓ" => "G", "і" => "i", "№" => "#", "є" => "ye", "ѓ" => "g",
        "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
        "Е" => "E", "Ё" => "YO", "Ж" => "ZH",
        "З" => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L",
        "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
        "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "X",
        "Ц" => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
        "Ы" => "Y", "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
        "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
        "е" => "e", "ё" => "yo", "ж" => "zh",
        "з" => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l",
        "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "x",
        "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
        "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", "«" => "", "»" => "", "—" => "-"
    );


    $temp = strtr($title, $iso);
    $result = url_title($temp, 'underscore', TRUE);


    return strlen($result) > 51 ? substr($result, 0, 50) : $result;


}


/**
 * @param    string   identical to the 1st param of anchor()
 * @param    mixed    identical to the 3rd param of anchor()
 * @param    string   the path to the image; it can be either an external one
 *                    starting by "http://", or internal to your application
 * @param    mixed    image attributes that have similar structure as the 3rd param of anchor()
 * @return   string
 *
 * Example 1: anchor_img('controller/method', 'title="My title"', 'path/to/the/image.jpg', 'alt="My image"')
 * Example 2: anchor_img('http://example.com', array('title' => 'My title'), 'http://example.com/image.jpg', array('alt' => 'My image'))
 */

function anchor_img($uri = '', $anchor_attributes = '', $img_src = '', $img_attributes = '') {
    if (!is_array($uri)) {
        $site_url = (!preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
    }
    else
    {
        $site_url = site_url($uri);
    }

    if ($anchor_attributes != '') {
        $anchor_attributes = _parse_attributes($anchor_attributes);
    }

    if (strpos($img_src, '://') === FALSE) {
        $CI =& get_instance();
        $img_src = $CI->config->slash_item('base_url') . $img_src;
    }

    if ($img_attributes != '') {
        $img_attributes = _parse_attributes($img_attributes);
    }

    return '<a href="' . $site_url . '" ' . $anchor_attributes . '>' . '<img src="' . $img_src . '" ' . $img_attributes . ' />' . '</a>';
}


/**
 * @param string $page
 * @return   string
 *
 */

function anchor_help($page = 'index') {

    $lang_suffix = LANG == 'russian' ? '' : '_english';
    $link = '/user_guide_dakota' . $lang_suffix . '/' . $page . '.html';

    if (! read_file('.' .$link) ){

        $link = '/user_guide_dakota/index.html';
    }

    return anchor($link, lang('dakota_help'), ' target="_blank" ');
}

/* trim and remove slashes */

function prepare_tag($input) {
    $input = trim($input);
    $input = str_replace("\\", "", $input);
    $input = str_replace('/', "", $input);
    $input = str_replace('?', "", $input);
    $input = str_replace('&', "", $input);
    $input = str_replace('=', "", $input);
    return $input;
} 