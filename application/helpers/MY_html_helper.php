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
 * @param  _min_width
 * @return  formatted _min_width css
 */

 function min_size($width, $height = null) {

   $minheight =  $height ?   ' min-height: ' . $height. 'px;'  : '';
   return ' style="min-width: ' . $width. 'px; '. $minheight . '"';

}
/**
 * @return  colon
 */
 function colon() {

   return ': ';

}
