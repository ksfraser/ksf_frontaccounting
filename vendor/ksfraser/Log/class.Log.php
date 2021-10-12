<?php

//The PEAR logging does include DB/SQL log destinations as well as files.

require_once( '../class.origin.php' );

//class ksf_Log extends controller
class ksf_Log extends origin
{
	var $fpLog;
/*
 *define('PEAR_LOG_TYPE_SYSTEM',  0);  Use PHP's system logger 
 *define('PEAR_LOG_TYPE_MAIL',    1);  Use PHP's mail() function 
 *define('PEAR_LOG_TYPE_DEBUG',   2);  Use PHP's debugging connection 
 *define('PEAR_LOG_TYPE_FILE',    3);  Append to a file 
 *define('PEAR_LOG_TYPE_SAPI',    4);  Use the SAPI logging handler 
 */
	var $pear_log;
	var $pear_log_file;
	var $pear_log_console;
	var $pear_log_system;
	var $pear_log_mail;
	var $pear_log_sapi;
	var $pear_log_debug;
	var $pear_log_sqlite;
	var $sqlite_db;
	var $pear_log_composite;

	function __construct()
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";
		parent::__construct();

		$this->tell_eventloop( $this, 'SETTINGS_QUERY', 'log_filename' );

		//Try to use PEAR/LOG
		//				$name, $ident = '', $conf = array(), $level = PEAR_LOG_DEBUG)
		$ret = include_once( 'Log.php' );	//PEAR
		if( TRUE == $ret )
		{
			echo "INIT PEAR LOGGING";
			$this->init_file();
			//$this->init_db_log();
			//$this->init_composite();
		}
			echo "INIT PEAR LOGGING FAILED!!!!";
	}
	/***************************************************************//**
         *build_interestedin
         *
         *      This function builds the table of events that we
         *      want to react to and what handlers we are passing the
         *      data to so we can react.
         * ******************************************************************/
        function build_interestedin()
        {
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

                $this->interestedin['NOTIFY_LOG_DEBUG']['function'] = "k_log";
                $this->interestedin['NOTIFY_LOG_INFO']['function'] = "k_log";
                $this->interestedin['NOTIFY_LOG_NOTICE']['function'] = "k_log";
                $this->interestedin['NOTIFY_LOG_WARNING']['function'] = "k_log";
                $this->interestedin['NOTIFY_LOG_ERR']['function'] = "k_log";
                $this->interestedin['NOTIFY_LOG_CRIT']['function'] = "k_log";
                $this->interestedin['NOTIFY_LOG_ALERT']['function'] = "k_log";
                $this->interestedin['NOTIFY_LOG_EMERG']['function'] = "k_log";
        }

	function __destruct()
	{
		 //when done need to close the db
		if( isset( $this->sqlite_db ))
		 	sqlite_close($this->sqlite_db);
	}
	function init_mail()
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

		/*
		 *$conf = array('subject' => 'Important Log Events');
		 *$logger = Log::singleton('mail', 'webmaster@example.com', 'ident', $conf);
		 */
		global $admin_email;
		$conf = array('subject' => 'Important Log Events');
		$this->pear_log_mail = Log::singleton('mail', $admin_email, 'ident', $conf);

	}
	function init_composite()
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

		/*
		 *
		 * //Then, construct a composite handler and add the individual handlers as children of the composite:
		 *
		 *$composite = Log::singleton('composite');
		 *$composite->addChild($console);
		 *$composite->addChild($file);
		 */
		$this->pear_log_composite = Log::singleton('composite');
		//$this->pear_log_composite->addChild( $this->pear_log_mail );
		//$this->pear_log_composite->addChild( $this->pear_log_console );
		$this->pear_log_composite->addChild( $this->pear_log_file );
		//$this->pear_log_composite->addChild( $this->pear_log_sqlite );
		//$this->pear_log_composite->addChild();
	}
	function init_console()
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

		/*
		 *$console = Log::factory('console', '', 'TEST');
		 */
		$this->pear_log_console = Log::factory('console', '', 'TEST');
	}
	function init_file()
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

		global $log_filename;
		/*
		 *$file = Log::factory('file', 'out.log', 'TEST');
		 */
			/*
			 *$conf = array('mode' => 0600, 'timeFormat' => '%X %x');
			 *$logger = Log::singleton('file', 'out.log', 'ident', $conf);
			 */
		 $this->pear_log_file = Log::factory('file', $log_filename, 'TEST');
	}
	function init_db_log()
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

			/*
			 *$conf = array('filename' => 'log.db', 'mode' => 0666, 'persistent' => true);
			 *$logger = Log::factory('sqlite', 'log_table', 'ident', $conf);
			 *$logger->log('logging an event', PEAR_LOG_WARNING);
			 *
			 * //Using an existing connection:
			 *
			 *$db = sqlite_open('log.db', 0666, $error);
			 *$logger = Log::factory('sqlite', 'log_table', 'ident', $db);
			 *$logger->log('logging an event', PEAR_LOG_WARNING);
			 *sqlite_close($db);
			 */
		//$this->sqlite_db = sqlite_open('log.db', 0666, $error);
		//$this->pear_log_sqlite = Log::factory('sqlite', 'log_table', 'ident', $db );
		  //when done need to close the db
		  //sqlite_close($this->sqlite_db);
	}
	/*
     	* @param mixed  $msg  String or object containing the message to log.
     	* @param string $priority The priority of the message.  Valid
     	*                  values are: PEAR_LOG_EMERG, PEAR_LOG_ALERT,
     	*                  PEAR_LOG_CRIT, PEAR_LOG_ERR, PEAR_LOG_WARNING,
     	*                  PEAR_LOG_NOTICE, PEAR_LOG_INFO, and PEAR_LOG_DEBUG.
     	* @return boolean  True on success or false on failure.
     	* @access public
	*/
	/*@bool@*/ function k_log( /* @object@ */ $caller, /*@string@*/ $msg, /*@string@*/ $priority )
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

		if( isset( $caller->tablename ) )
		{
			$message = $caller->tablename . ": " . $msg;
		}
		else
		{
			$message = get_class( $caller ) . ": " . $msg;
		}
/*
		if( is_callable( $this->pear_log_sqlite->log( $message, $priority ) ) )
		{
			$this->pear_log_sqlite->log( $message, $priority );
		}
*/
	}
	public function notified( $class, $event="", $msg="" )
	{
		echo get_class( $this ) . "::" . __METHOD__ . "\n\r";

		if( "NOTIFY_LOG_EMERG" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_EMERG );
		}
		if( "NOTIFY_LOG_ALERT" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_ALERT );
		}
		if( "NOTIFY_LOG_CRIT" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_CRIT );
		}
		if( "NOTIFY_LOG_ERR" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_ERR );
		}
		if( "NOTIFY_LOG_WARNING" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_WARNING );
		}
		if( "NOTIFY_LOG_NOTICE" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_NOTICE );
		}
		if( "NOTIFY_LOG_INFO" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_INFO );
		}
		if( "NOTIFY_LOG_DEBUG" == $event )
		{
			$this->k_log( $class, $msg, PEAR_LOG_DEBUG );
		}
	}
}
