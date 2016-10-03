<?php


$dakota_db_config = '/application/config/database.php';



if( file_exists( $_SERVER{'DOCUMENT_ROOT'} .$dakota_db_config))  {
require( $_SERVER{'DOCUMENT_ROOT'} .$dakota_db_config);

global $sql_host;
global $sql_login;
global $sql_passe;
global $sql_dbase;
global $sql_table;
$sql_host  =     $db['default']['hostname'];
$sql_login =     $db['default']['username'];
$sql_passe =     $db['default']['password'];
$sql_dbase =     $db['default']['database'];
$sql_table = "dakota_stat";

}
else{
echo '<span class="error">Error in file ' . __FILE__ . '  '. $dakota_db_config . ' not found.</span> ' ;   
}


?>
