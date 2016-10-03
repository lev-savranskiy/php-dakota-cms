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
 * @param    string   $search
 * @param    string    $replace
 * @param    string   $subject
 * @return   string
 * 
 * Example 1: find_and_replace('%cut%', '<a href = "/news/1/">more</a>', text)
  */

function find_and_replace($search, $replace, $subject) {

    // $bodytag = str_replace("%body%", "black", "<body text='%body%'>");

    $strpos = strpos($subject, $search);

    if ($strpos > 0) {

        return substr($subject, 0, $strpos) . $replace;

    }

    return $subject;
}
