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
 * @method	public
 * @param	mixed	// will be cast as int
 * @return	boolean
 */


function is_unsigned_int($value) {
       // return ctype_digit((string) $value);
    return ctype_digit( $value);

}