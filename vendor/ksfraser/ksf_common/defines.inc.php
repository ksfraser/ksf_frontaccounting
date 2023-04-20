<?php

$path_to_faroot= dirname ( realpath ( __FILE__ ) ) . "/../..";
//$path_to_faroot = __DIR__ . "/../../";
$path_to_ksfcommon = __DIR__ . "/";

//require_once( $path_to_faroot . '/includes/db/connect_db.inc' ); //db_query, ...
//require_once( $path_to_faroot . '/includes/errors.inc' ); //check_db_error, ...
if( !$log_included = @include_once( 'Log.php' ))	//PEAR Logging
{
	define( 'PEAR_LOG_EMERG', 0 );
	define( 'PEAR_LOG_ALERT', 1 );
	define( 'PEAR_LOG_CRIT', 2 );
	define( 'PEAR_LOG_ERR', 3 );
	define( 'PEAR_LOG_WARNING', 4 );
	define( 'PEAR_LOG_NOTICE', 5 );
	define( 'PEAR_LOG_INFO', 6 );
	define( 'PEAR_LOG_DEBUG', 7 );

}
//LOG LEVELS
if( !defined( 'PEAR_LOG_CRIT' ))
{
	define( 'PEAR_LOG_EMERG', 0 );
	define( 'PEAR_LOG_ALERT', 1 );
	define( 'PEAR_LOG_CRIT', 2 );
	define( 'PEAR_LOG_ERR', 3 );
	define( 'PEAR_LOG_WARNING', 4 );
	define( 'PEAR_LOG_NOTICE', 5 );
	define( 'PEAR_LOG_INFO', 6 );
	define( 'PEAR_LOG_DEBUG', 7 );
}

define( 'NOT_SELECTED', -1 );
define( 'PRIMARY_KEY_NOT_SET', 5730 );


function currentdate()
{
	return date( 'Y-m-d' );
}

function currenttime()
{
	return date( 'Y-m-d H:i:s' );
}

define( 'SUCCESS', TRUE );
define( 'FAILURE', FALSE );


/**************************************************************************//**
 *Error Handling for try/throw/catch/finally
 *
 *
 * ****************************************************************************/
$eventcount = 573000;
define( 'KSF_FIELD_NOT_SET', $eventcount ); $eventcount++;	//Class Fields
define( 'KSF_VALUE_NOT_SET', $eventcount ); $eventcount++;	//var set to NULL
define( 'KSF_VALUE_SET_NO_REPLACE', $eventcount ); $eventcount++;
define( 'KSF_VALUE_SET', $eventcount ); $eventcount++;
define( 'KSF_VALUE_REPLACED', $eventcount ); $eventcount++;
define( 'KSF_VAR_NOT_SET', $eventcount ); $eventcount++;	//Function VARs
define( 'KSF_RESULT_NOT_SET', $eventcount ); $eventcount++;	//For when we are expecting a result from a call and it came back NULL unexpectedly
define( 'KSF_FIELD_NOT_CLASS_VAR', $eventcount ); $eventcount++;
define( 'KSF_PRIKEY_NOT_SET', $eventcount ); $eventcount++;
define( 'KSF_PRIKEY_NOT_DEFINED', $eventcount ); $eventcount++;
define( 'KSF_TABLE_NOT_DEFINED', $eventcount ); $eventcount++;
define( 'KSF_NO_MATCH_FOUND', $eventcount ); $eventcount++;
define( 'KSF_INVALID_DATA_TYPE', $eventcount ); $eventcount++;
define( 'KSF_INVALID_DATA_VALUE', $eventcount ); $eventcount++;
define( 'KSF_UNKNOWN_DATA_TYPE', $eventcount ); $eventcount++;
define( 'KSF_FCN_NOT_OVERRIDDEN', $eventcount ); $eventcount++;
define( 'KSF_FCN_PATH_OVERRIDE', $eventcount ); $eventcount++;
define( 'KSF_FCN_NOT_EXIST', $eventcount ); $eventcount++;
define( 'KSF_LOST_CONNECTION', $eventcount ); $eventcount++;
define( 'KSF_CONFIG_NOT_EXIST', $eventcount ); $eventcount++;
define( 'KSF_SEARCHED_VALUE_NOT_FOUND', $eventcount ); $eventcount++;
define( 'KSF_FCN_REFACTORED', $eventcount ); $eventcount++;
define( 'KSF_FILE_OPEN_FAILED', $eventcount ); $eventcount++;

/************************************************************************//**
 * Data Access levels
 *  Think filesystem RWX values R = 0/1, W = 0/2 and X = 0/4
 *
 * *************************************************************************/
define( 'KSF_DATA_ACCESS_DENIED', 573320 );
define( 'KSF_DATA_ACCESS_READ', 573321 );
define( 'KSF_DATA_ACCESS_WRITE', 573322 );
define( 'KSF_DATA_ACCESS_READWRITE', 573323 );
define( 'KSF_MODULE_ACCESS_DENIED', 573620 );
define( 'KSF_MODULE_ACCESS_READ', 573621 );
define( 'KSF_MODULE_ACCESS_WRITE', 573622 );
define( 'KSF_MODULE_ACCESS_READWRITE', 573623 );
define( 'KSF_MAX_MODULES', 10 );	//Fixing modarray and tabarray sizes in eventloop.  Of course we could always detect that this is defined, undefine, and redefine if we need more
define( 'KSF_MAX_LOADPRIORITY', KSF_MAX_MODULES * 2 );	//Fixing modarray and tabarray sizes in eventloop.  Of course we could always detect that this is defined, undefine, and redefine if we need more
define( 'KSF_DUMMY_EVENT', $eventcount ); $eventcount++;

function exceptionErrorHandler($errNumber, $errStr, $errFile, $errLine ) {
        throw new ErrorException($errStr, 0, $errNumber, $errFile, $errLine);
    }
//set_error_handler('exceptionErrorHandler');

interface IException
{
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message 
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace
    
    /* Overrideable methods inherited from Exception class */
    public function __toString();                 // formated string for display
    public function __construct($message = null, $code = 0);
}

abstract class CustomException extends Exception implements IException
{
    protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

    public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }
    
    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}

//Can now create custom Exceptions:
//	class TestException extends CustomException {}

?>

