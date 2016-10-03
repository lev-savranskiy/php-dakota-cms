<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */




/**

 * @method  num2word
 *  @param    $num - input number
 *  @param    $words - array of russian words.
 * @return    word

 */

function num2word($num, $words)
{
$num = $num % 100;
if ($num > 19) {
$num = $num % 10;
}
switch ($num) {
case 1: {
return($words[0]);
}
case 2: case 3: case 4: {
return($words[1]);
}
default: {
return($words[2]);
}
}
}


/* End of file */