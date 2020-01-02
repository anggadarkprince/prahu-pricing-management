<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Super admin permission
defined('PERMISSION_ALL_ACCESS') OR define('PERMISSION_ALL_ACCESS', 'all-access');

// Account setting permission
defined('PERMISSION_ACCOUNT_EDIT') OR define('PERMISSION_ACCOUNT_EDIT', 'account-edit');
defined('PERMISSION_SETTING_EDIT') OR define('PERMISSION_SETTING_EDIT', 'setting-edit');

// Master role permission
defined('PERMISSION_ROLE_VIEW') OR define('PERMISSION_ROLE_VIEW', 'role-view');
defined('PERMISSION_ROLE_CREATE') OR define('PERMISSION_ROLE_CREATE', 'role-create');
defined('PERMISSION_ROLE_EDIT') OR define('PERMISSION_ROLE_EDIT', 'role-edit');
defined('PERMISSION_ROLE_DELETE') OR define('PERMISSION_ROLE_DELETE', 'role-delete');

// Master user permission
defined('PERMISSION_USER_VIEW') OR define('PERMISSION_USER_VIEW', 'user-view');
defined('PERMISSION_USER_CREATE') OR define('PERMISSION_USER_CREATE', 'user-create');
defined('PERMISSION_USER_EDIT') OR define('PERMISSION_USER_EDIT', 'user-edit');
defined('PERMISSION_USER_DELETE') OR define('PERMISSION_USER_DELETE', 'user-delete');

// Master marketing permission
defined('PERMISSION_MARKETING_VIEW') or define('PERMISSION_MARKETING_VIEW', 'marketing-view');
defined('PERMISSION_MARKETING_CREATE') or define('PERMISSION_MARKETING_CREATE', 'marketing-create');
defined('PERMISSION_MARKETING_EDIT') or define('PERMISSION_MARKETING_EDIT', 'marketing-edit');
defined('PERMISSION_MARKETING_DELETE') or define('PERMISSION_MARKETING_DELETE', 'marketing-delete');

// Master container type permission
defined('PERMISSION_CONTAINER_TYPE_VIEW') or define('PERMISSION_CONTAINER_TYPE_VIEW', 'container-type-view');
defined('PERMISSION_CONTAINER_TYPE_CREATE') or define('PERMISSION_CONTAINER_TYPE_CREATE', 'container-type-create');
defined('PERMISSION_CONTAINER_TYPE_EDIT') or define('PERMISSION_CONTAINER_TYPE_EDIT', 'container-type-edit');
defined('PERMISSION_CONTAINER_TYPE_DELETE') or define('PERMISSION_CONTAINER_TYPE_DELETE', 'container-type-delete');

// Master container type permission
defined('PERMISSION_CONTAINER_SIZE_VIEW') or define('PERMISSION_CONTAINER_SIZE_VIEW', 'container-size-view');
defined('PERMISSION_CONTAINER_SIZE_CREATE') or define('PERMISSION_CONTAINER_SIZE_CREATE', 'container-size-create');
defined('PERMISSION_CONTAINER_SIZE_EDIT') or define('PERMISSION_CONTAINER_SIZE_EDIT', 'container-size-edit');
defined('PERMISSION_CONTAINER_SIZE_DELETE') or define('PERMISSION_CONTAINER_SIZE_DELETE', 'container-size-delete');