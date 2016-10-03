<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */


/*
|--------------------------------------------------------------------------
| Dakota Specific Constants
|--------------------------------------------------------------------------
|
*/

//    Your Site template 'default' , 'decorative' , 'lightspeed'  or own
//define('MY_TEMPLATE', 'dakota');

//    LOCK_FILE_NAME for DB safe reloading 
define('LOCK_FILE_NAME', 'dblock');


//   Anonymous_ID for Anonymous COMMENTS
define('ANONYMOUS_ID', 2);

//   Example admin email
define('ADMIN_DEMO_EMAIL', 'admin@example.com');


//    Don`t touch anything below if you are not sure

define('TEMPLATES_FOLDER', 'templates/');
define('UPLOAD_FOLDER',  './uploads/files/');
define('GALLERY_FOLDER',  './uploads/images/main/' );
define('UPLOAD_MAX_SIZE', ini_get('upload_max_filesize')  );    //    Upload File Max Size in Mb
// не забудьте поменять настройки     php.ini  !!
// Maximum allowed size for uploaded files.
// upload_max_filesize = 10M


 // DAKOTA DATA
define('CMS_VERSION',	'0.4');
define('CMS_RELEASE_DATE',	'14.10.2010');
define('CMS_HOME',	'http://dakota-cms.com/');


 // database DATA
require('database.php');
define('MY_DATABASE', $db['default']['database']);
//define('PHP_MY_ADMIN_LINK',	'/phpmyadmin/index.php?&db=' . MY_DATABASE . '&pma_username=' . $db['default']['username'] . '&pma_password=' .  $db['default']['password'] );
define('PHP_MY_ADMIN_LINK',	'/sqlbuddy/#page=dboverview&topTabSet=1&db=' . MY_DATABASE );


// NOT IN USE
define('YAHOO_APP_ID',	NULL);

// ICONS
define('ICON_GO', TEMPLATES_FOLDER  . 'common/img/icon_go.png' );
define('ICON_DELETE', TEMPLATES_FOLDER  . 'common/img/icon_delete.png' );
define('ICON_EDIT', TEMPLATES_FOLDER  . 'common/img/icon_edit.png' );
define('ICON_UP', TEMPLATES_FOLDER  . 'common/img/icon_up.png' );
define('ICON_DOWN', TEMPLATES_FOLDER  . 'common/img/icon_down.png' );
define('ICON_DISCONNECT', TEMPLATES_FOLDER  . 'common/img/icon_disconnect.png' );
define('ICON_HELP', TEMPLATES_FOLDER  . 'common/img/icon_help.png' );
define('ICON_RU', TEMPLATES_FOLDER  . 'common/img/icon_ru.png' );
define('ICON_EN', TEMPLATES_FOLDER  . 'common/img/icon_en.png' );
// don't delete white  spaces in ICON_BULL!!
define('ICON_BULL', ' &nbsp;&bull;&nbsp; ' );


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./system/application/config/constants.php */