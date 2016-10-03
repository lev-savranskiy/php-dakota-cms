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

 * @method  format date
 *  @param    $date
 * @return    $string

 */

function format_to_words($date, $remove_seconds = true)
{




$arr = str_split($date, 10);

$year = $arr[0][0] . $arr[0][1] . $arr[0][2] . $arr[0][3];
$month = $arr[0][5] . $arr[0][6] ;
$day = $arr[0][8] . $arr[0][9] ;
$CI= & get_instance();


$month_text = $CI->lang->line('cal_' . $month) ;

$arr[0] = $day . ' '  .  $month_text  . ' ' .  $year ;

if ($remove_seconds){

 $arr[1] =  substr_replace( $arr[1] ,"",-3);
}


 return $arr;


}

/* End of file */