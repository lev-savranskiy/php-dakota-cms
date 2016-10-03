<?

/**
 * Dakota CMS - An open source CMS
 *
 * @author        Lev Savranskiy
 * @copyright    Copyright (c) 2010, Dakota CMS
 * @link        http://dakota-cms.com/
 * @since        Version 0.1
 */


/**

 * @method  function to convert PHP array to JS Object

 *  @param    $myarray - The PHP array

 *   @param    $outputvarname - The JS  array
 *   @param    $level - The $level

 * @return   : The edited array

 */


function convert_to_js($myarray, $outputvarname, $level = 0) {

    $js_arrays[$outputvarname] = '';
    $pre = '';
    $outputstring = '';

    for ($i = 0; $i < $level; $i++) $pre .= '    ';
    $js_arrays[$outputvarname] .= $outputvarname . ' = new Object();' . "\n";
    //  print_r($js_arrays[$outputvarname])   ;
    foreach ($myarray as $key => $value) {
        if (!is_int($key))
            if ($key == "password" || $key == "settings" )  continue;
        $key = '"' . addslashes($key) . '"';
        if (is_array($value))
            convert_to_js($value, $outputvarname . '[' . $key . ']', $level + 1);
        else {
            $js_arrays[$outputvarname] .= '    ' . $outputvarname . '[' . $key . ']' . ' = ';

            if (is_int($value) or is_float($value))
                $js_arrays[$outputvarname] .= $value;
            elseif (is_bool($value))
                $js_arrays[$outputvarname] .= $value ? "true" : "false";
            elseif (is_string($value)) {
                $js_arrays[$outputvarname] .= '"' . addslashes($value) . '"';
            }
            else
                $js_arrays[$outputvarname] .= "Unknown Datatype for " . $outputvarname . "[$key] ";

        }

        $js_arrays[$outputvarname] .= ';';
    }


    //   $outputstring = '<script language="JavaScript" type="text/javascript">' . "\n";
    foreach ($js_arrays as $array) {
        $outputstring .= $array;
    }
    //  $outputstring .= '</script>' . "\n";

    return "\n" . $outputstring;

}


function convert_to_js_array($myarray, $title) {

    if (safe_count($myarray) > 0) {

        $str = ' var ' . $title . ' = ["';

        $str .= implode('","', $myarray);
        $str .= '"];';

        return $str;
    }


    return null;


}

