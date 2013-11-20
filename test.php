$Id: 0Intro_Error_ENGLISH.txt 174 2011-03-15 04:51:10Z horseluke@126.com $


<?php
/*
Error.php is an independent file.
PHP VERSION MUST BE >= 5.0.0.
You should use Inter_Error_PHP4.php file while PHP >= 4.3.0 & < 5.0.0
*/
//Usage(Demo):
date_default_timezone_set('PRC');    //(PHP >= 5.1.0 MUST TO DO SO)Sets the default timezone used by all date/time functions in a script. This demo sets the PRC timezone
require_once("Error.php");     //require / require_once Error.php at a proper place as you wish
//Sets a user function (error_handler & exception_handler) to handle errors in a script
set_exception_handler(array('Inter_Error', 'exception_handler'));
set_error_handler(array('Inter_Error', 'error_handler'), E_ALL);
if(version_compare(PHP_VERSION, '5.2', '>=')){
    register_shutdown_function(array('Inter_Error', 'detect_fatal_error'));
}
//Setting Inter_Error::$conf : 
 /**
  * keys and the default value in static property Inter_Error::$conf :
     * debugMode:
     * Open debug mode? If true, it will show at the end of the webpage in web browser
     * option: false(default)/true
     * var type: bool
     *
     * friendlyExceptionPage:
     * while debugMode is false and occur an exception, which html file should be display (by using 'require')
     * leave it blank if you do not want to take effect.
     * option: ''(blank, default)/any directory value
     * var type: string
     * 
     * logType:
     * Define how to log the errors. 
     * 'detail': log with the trace info. Not recommend using this value in deploy environment unless you are facing a difficult problem
     * 'simple': log without the trace info.
     * false: do not log
     * option: false(default)/'detail'/'simple'
     * var type: bool|string
     * 
     * logDir:
     * The directory to save the log file. Do not have '/' or '\' at the end of the script
     * This setting is affected by 'logType'. If 'logType' is false, it will do nothing.
     * But if 'logType' is not false, and this setting is blank or is not a directory. it will log error by using setting in php.ini.
     * option: ''(blank, default)/any directory value
     * var type: string
     * 
     * suffix:
     * the suffix of the log file
     * option: '-Inter-ErrorLog.log'(default)
     * var type: string
     * 
     * variables:
     * the key you want to export and show variables in $GLOBALS
     * option: array("_GET", "_POST", "_SESSION", "_COOKIE")(default)
     * var type: array
     * 
     * ignoreERROR:
     * Some program can easily generate many E_NOTICEs and E_STRICTs. You can omit them by changing array setting 'ignoreERROR'
     * Predefined Constants in Error Handling: http://docs.php.net/manual/en/errorfunc.constants.php
     * By default, it will not log E_STRICT. But you should be careful not to overwrite the default setting.
     * Here is a example:
     * <pre>
     * Inter_Error::$conf['ignoreERROR'] = array(E_NOTICE, E_STRICT); //will overwrite ignoreERROR default setting, but remain not to log E_STRICT
     * </pre>
     * option: array(E_STRICT)(default)
     * var type: array
  */
Inter_Error::$conf['debugMode'] = true;
//Inter_Error::$conf['friendlyExceptionPage']='1234.htm';
//Inter_Error::$conf['logType'] = 'simple';
//Inter_Error::$conf['logDir'] = dirname(__FILE__).'/Log';
//Inter_Error::$conf['ignoreERROR'] = array(E_NOTICE, E_STRICT);

//demo code that can generate the error
$variable1 = '1111';

function a(){
    b();
}

function b(){
    echo $k;
    echo 1/0;
}

function c(){
	//sometimes you want to know how and where function c is called. 
	//Now you can use trigger_error to show the executing procedure at the end of the webpage.
	trigger_error('function c is running~', E_USER_WARNING);
	throw new exception('Exception Occur!');
}

a();

//If you want to export and show some variables in $GLOBALS, 
//you can use: Inter_Error::$conf['variables'] = array(xxxxxxxxxx, xxxxxx, ...);
//then: Inter_Error::show_variables();
//Attention: Inter_Error::show_variables() will be called automatically if any php error occurs and 'debugMode' is true.
/*
Inter_Error::$conf['variables'] = array("_GET", "_POST", "_SESSION", "_COOKIE", "variable1", "variable2");
echo '<hr />';
Inter_Error::show_variables();
echo '<hr />';
*/

c();
