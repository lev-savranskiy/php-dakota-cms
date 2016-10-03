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
 * Recusive alternative to ksort
 *
 * @param array $array
 */
function ksort_r( &$array )
{
    if (!is_array($array)) {
        return false;
    }

    ksort($array);
    foreach ($array as $k=>$v) {
        ksort_r($array[$k]);
    }
    return true;
}




/**

 * @method  function to remove an element from a list(numerical array)

 *  @param    $arr - The array that should be edited

 *   @param    $value - The value that should be deleted.

 * @return   : The edited array

 */

function array_remove_value($arr,$value) {

   return array_values(array_diff($arr,array($value)));

}


/**
 *  @method  splits array to store as a string
 *  @return splitted string
 *
 */
function split_array($input) {
    return http_build_query($input);
}

/**
 *  @method  unsplit string to return an array
 *  @return array
 *
 */
function unsplit_string($str) {
    parse_str($str, $output);
  //  Debugger::show($output , 'unsplit_string');
    return $output;
}

/**
 *  @method finds and splits array by key name
 *  @param  $input array
 * @param  $key to split
 * @return formatted array with updated $input[key]
 *
 */

function implode_by_key($input, $key) {
    $newdata = array();
    if (safe_count($input) > 0) {
        foreach ($input as $d) {

            if (isset($d[$key]) && safe_count($d[$key]) > 0) {
                $d[$key] = implode(",", $d[$key]);
            }
            $newdata[] = $d;
        }
    }

    return $newdata;
}

/**
 *  @method finds and converts to array string value
 *  @param  $str string
 * @param  $forced_value = value to insert (not required)
 * @return array
 *
 */

function explode_by_key($str,  $forced_value = null) {
    
    $newdata = array();

    if (is_string($str) && $str != '') {

        $pieces = explode(",", $str);

        if (safe_count($pieces) > 0) {
            foreach ($pieces as $piece) {
               $newdata[] = $piece;
            }
        }
    }

    if (isset($forced_value)) $newdata[] = $forced_value;

    return $newdata;
}


/**
 * create_splitted_string
 *  @param  $input array
 * @param  $splitter
 *  @return splitted_string
 *
 */
function split_array_2($input, $splitter = '|') {


    $result = '';
    $i = 0;

    if (safe_count($input) > 0) {

        foreach ($input as $key => $value) {

            $value = str_replace($splitter, "", $value);

            if ($i > 0) $result .= $splitter;
            $result .= $value;

            $i++;
        }

    }

    return $result;

}


/**
Check ONE needle  recursive in ARRAY
 * @param  $needle
 * @param  $haystack
 * @return bool
 *
 */
function needle_exists_r($needle, $haystack) {

    //   Debugger::show(isset($haystack[$needle]) , $haystack . '->' .$needle);

    $result = isset($haystack[$needle]) && $haystack[$needle] != '';
    if ($result) return $result;
    foreach ($haystack as $v) {
        if (is_array($v)) {
            $result = needle_exists_r($needle, $v);
        }
        if ($result) return $result;
    }

    return $result;

}

/*
* @method Check  fields ARRAY  recursive  in another ARRAY
* @param  $InputArray
* @param  $RequiredFields
* @return array of missing fields
*/

function array_keys_exists_r($inputArray, $requiredArray) {
    Debugger::show($requiredArray, 'Required Fields ');
    // Debugger::show(count($inputArray) , '$inputArray');

    $found = array();

    foreach ($requiredArray as $requiredKey => $requiredVal) {

        if (needle_exists_r($requiredVal, $inputArray)) $found[] = $requiredVal;

    }
    Debugger::show($found, 'Found fields ');
    return array_diff($requiredArray, $found);
}


/**
 * @method Update  array merge recursive
 * @return  merged  array
 *
 * Merges any number of arrays / parameters recursively, replacing
 * entries with string keys with values from latter arrays.
 * If the entry or the next value to be assigned is an array, then it
 * automagically treats both arguments as an array.
 * Numeric entries are appended, not replaced, but only if they are
 * unique
 *
 * calling: result = array_merge_recursive_distinct(a1, a2, ... aN)
 **/

function array_merge_recursive_distinct() {
    $arrays = func_get_args();
    $base = array_shift($arrays);
    if (!is_array($base)) $base = empty($base) ? array() : array($base);
    foreach ($arrays as $append) {
        if (!is_array($append)) $append = array($append);
        foreach ($append as $key => $value) {
            if (!array_key_exists($key, $base) and !is_numeric($key)) {
                $base[$key] = $append[$key];
                continue;
            }
            if (is_array($value) or is_array($base[$key])) {
                $base[$key] = array_merge_recursive_distinct($base[$key], $append[$key]);
            } else if (is_numeric($key)) {
                if (!in_array($value, $base)) $base[] = $value;
            } else {
                $base[$key] = $value;
            }
        }
    }
    return $base;
}


/***
 *  @method gets fields values from one ARRAY and stores in NEW ARRAY
 *  @param $needle - needle to find
 *  @param $haystack - input array
 *  @option search WHERE $conditionField == $conditionValue
 *  @return array
 */
function get_fields_from_list($needle, $haystack, $conditionField = null, $conditionValue = null) {

    $result = array();

    if (element($needle, $haystack)) {

        $result[0] = $haystack[$needle];
    }
    else {

        if (safe_count($haystack) > 0) {

            foreach ($haystack as $item) {

                if (element($needle, $item)) {
                    if (!$conditionField || (element($conditionField, $item) && $item[$conditionField] == $conditionValue)) {

                        $result[] = $item[$needle];
                    }

                }

            }
        }

    }

    return $result;
}


/**
 * @method safe count $array
 * @param    $array
 * @return   int count $array or 0
 */
function safe_count($array) {

    if (isset($array) && is_array($array)) {

            return count($array);

    }
    else {
        return 0;
    }
}


/**
 * @method convert_to_array
 * @param    $input $array
 * @return   $array
 */
function convert_to_array($input) {

    if (!is_array($input) || !preg_match('/^\d+$/', implode('', array_keys($input)))) {
        $temp = array();
        $temp[0] = $input;
        return $temp;
    }

    return $input;
}


/**
 * @method checks if array  contains only one INT value
 * @info  USE IT ONLY FOR DELETE AND ITEM !!!!
 * @param    $array
 * @return   boolean
 */

function check_id($input) {

    if (isset($input[0]) && intval($input[0]) && safe_count($input) == 1) {

        return true;
    }


}


/* End of file */