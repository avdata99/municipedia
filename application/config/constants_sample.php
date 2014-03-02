<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Application constants for application/config/database.php
 */
define('DATABASE_HOST','');
define('DATABASE_NAME','');
define('DATABASE_USER', '');
define('DATABASE_PASS', '');
// Only if you'll use a development environment
define('DATABASE_HOST_DEVEL','');
define('DATABASE_NAME_DEVEL','');
define('DATABASE_USER_DEVEL', '');
define('DATABASE_PASS_DEVEL', '');
//You twitter app data for register twitter users
define('TWT_CONSUMER_KEY', '');
define('TWT_CONSUMER_SECRET', '');
define('TWT_OAUTH_CALLBACK', '');


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

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */