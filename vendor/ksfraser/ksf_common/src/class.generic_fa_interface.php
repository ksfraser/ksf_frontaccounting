<?php

global $path_to_root;
/*
if( strlen( $path_to_root ) < 5 )
	$path_to_root = dirname( __FILE__ ) . "/../../";
else
require_once( $path_to_root . '/modules/ksf_modules_common/db_base.php' );	//Needed the ksf_modules_common otherwise a module directory local file was included.
require_once( $path_to_root . '/modules/ksf_modules_common/defines.inc.php' );
*/
	$path_to_root = dirname( __FILE__ ) ;

require_once( $path_to_root . '/db_base.php' );	//Needed the ksf_modules_common otherwise a module directory local file was included.
require_once( $path_to_root . '/defines.inc.php' );

if( ! class_exists( 'generic_fa_interface' ) )
{

	/**************************************************************************************************//**
	 *
	 *
	 * Function List:
                function __construct( $host, $user, $pass, $database, $pref_tablename )
                function eventloop( $event, $method )
                function eventregister( $event, $method )
                function add_submodules()
                function module_install()
                function install()
                function loadprefs()
                function updateprefs()
                function checkprefs()
                function call_table( $action, $msg )
                function action_show_form()
                function show_config_form()
                function form_export()
                function related_tabs()
                function show_form()
                function base_page()
                function display()
                function run()
                function modify_table_column( $tables_array )
                / *@fp@* /function append_file( $filename )
                /*@fp@* /function overwrite_file( $filename )
                /*@fp@* /function open_write_file( $filename )
                function write_line( $fp, $line )
                function close_file( $fp )
                function file_finish( $fp )
                function backtrace()
                function write_sku_labels_line( $stock_id, $category, $description, $price )
                function show_generic_form($form_array)
	 * 
	 *
	 * ****************************************************************************************************/	
	class generic_fa_interface extends db_base
	//class generic_fa_interface 
	//class generic_orders
	{
	        var $db_Host;
	    	var $db_User;
	    	var $db_Password;
	    	var $db_Name;
		var $tabs = array();
		var $found;
		var $config_values = array();	//What fields to be put on config screen
		var $help_context;		//$help_context = " HUMAN TEXT  <a href='linked.html'>Help: LINKED</a>"; 
		var $action;			//for choosing what to do, forms
		var $redirect_to;		//script name to redirect to on install
		var $preftable;
		var $ui_class;			//!<the UI class in MVC (refactoring)
		var $errors;
		var $javascript;
		var $page_title;

		var $debug;	//set in many inheriting classes - needs cleanup
		//var $table_interface;		//!<Object class.table_interface for doing db work to better separate out the MVC functions.
		var $edit;			//!< int ID of row to edit
		var $delete;			//!< int ID of row to delete
		var $selected_id;		//!< int ID of row to edit/delete
		var $eventloop;			//!< object eventloop
		/*********************************************************************
		 *
		 *	This function must be overridden to work correctly
		 *	The inheriting class MUST set customer_index_name,
		 *	customer_table_name and vendor
		 *
		 *********************************************************************/
		function __construct( $host, $user, $pass, $database, $pref_tablename )
		{
			if( !isset( $this->debug ) )
				$this->debug = 0;
			require_once( dirname( __FILE__ ) . '//class.eventloop.php' );

			/* Mantis 214 bad moduledir on eventloop constructor leading to failed loading.
							//moduledir, caller
			//$this->eventloop = new eventloop(  null, $this );
			*/
			$this->eventloop = new eventloop( dirname( __FILE__ ), $this );

			if(isset( $pref_tablename ) )
			{
				parent::__construct( $host, $user, $pass, $database, $pref_tablename );
				$this->preftable = $pref_tablename;
			        $this->loadprefs();
			}
			$this->edit = find_submit( 'Edit', true );
			$this->delete = find_submit( 'Delete', true );
			//Edit OR Delete OR NOT_SET (-1)
			$this->selected_id = ( ($this->edit >= 0) ? $this->edit : 
						( ($this->delete >= 0) ? $this->delete : NOT_SELECTED ) );
			$this->tabs[] = array( 'title' => 'Default Action', 'action' => 'default', 'form' => 'default_form', 'hidden' => TRUE );
			$this->ui_class = null;
		}
	        /**********************************************************//**
	         * Log to screen depending on level
	         *
	         * Levels
	         *      ERROR (display error on screen)
	         *      WARN (debug level 1)
	         *      NOTIFY (debug level 2)
	         *      DEBUG (debug level 3)
	         *
	         * ***********************************************************/
	        function notify( $msg, $level = "ERROR" )
	        {
	                if( "ERROR" == $level )
	                {
	                        display_error( $msg );
	                }
	                else if( "WARN" == $level AND $this->debug >= 1)
	                {
	                        display_notification( $msg );
	                }
	                else if( "NOTIFY" == $level AND $this->debug >= 2)
	                {
	                        display_notification( $msg );
	                }
	                else if( "DEBUG" == $level AND $this->debug >= 3)
	                {
	                        display_notification( $msg );
	                }
	                else
	                {
	                        display_notification( $msg );
	                }
	
	        }

		function eventregister( $event, $method )
		{
		}

		/****************************************************************************//**
		 * Load class files that have a related conf file
		 *
		 *
		 * ********************************************************************************/
		function add_submodules( $moduledir = null )
		{
			//assumption this is an inherited class calling, and not from within ksf_modules_common but on an equivalent depth
			if( ! isset( $moduledir ) ) 
				$moduledir = dirname( __FILE__ ) . '/modules';
			$this->eventloop->set_moduledir(  $moduledir );
			$this->eventloop->load_modules();
			

			//global $configArray = array();
			$addondir = "./";
			foreach (glob("{$addondir}config.*.php") as $filename)
	                {
	                        include_once( $filename );
	                }
	                /*
			 * Loop through the $configArray to set loading modules in right order
			 * The loadpriority is in case you know there are dependencies
			 */
			$modarray = array();
			$tabarray = array();
			if( isset( $configArray ) )
			{
	                	foreach( $configArray as $carray )
	                	{
					$modarray[$carray['loadpriority']][] = $carray;
					//Add to tabs...
					$tabarray[$carray['taborder']][] = $carray;
	        	        }
			}
		        /*
	                 * locate Module class files to open
	                 */
	                foreach( $modarray as $priarray )
	                {
	                        foreach( $priarray as $marray )
	                        {
	                                $res = include_once( $addondir . "/" . $marray['loadFile'] );
	                                if( TRUE == $res )
					{
						//Is there any benefit to loading all these classes?
						//$marray['objectName'] = new $marray['className'];
						/* The below comes from CONTROLLER which may not apply here...
	                                        if( isset( $marray['objectName']->observers ) )
	                                        {
	                                                foreach( $marray['objectName']->observers as $obs )
	                                                {
	                                                        $this->observers[] = $obs;
	                                                }
						}
						 */
	                                }
	                                else
	                                {
	                                        echo "Attempt to open " . $addondir . "/" . $marray['loadFile'] . " FAILED!<br />";
	                                }
				}
	                }
			foreach( $tabarray as $tabpri )
			{
				foreach ($tabpri as $tabinc)
				{
					$this->tabs[] = array( 'title' => $tabinc['tabdata']['tabtitle'], 'action' => $tabinc['tabdata']['action'], 'form' => $tabinc['tabdata']['form'], 'hidden' => $tabinc['tabdata']['hidden'], 'class' => $tabinc['tabdata']['class'] );
				}
			}
		}
		function module_install()
		{
			//display_notification( __FILE__ . "::" . __CLASS__ . "::"  . __METHOD__ . ":" . __LINE__, "WARN" );
			if( isset( $this->preftable ) )
				return $this->create_prefs_tablename();
			else
				throw new Exception( "Prefs Table name note set", KSF_FIELD_NOT_SET );
		}
		function install()
		{
			//echo __FILE__ . ":" . __LINE__ . "<br />\n";	
			if( !isset( $this->preftable ) )
				return;
			$this->create_prefs_tablename();
	        	$this->loadprefs();
	        	$this->checkprefs();
			if( isset( $this->redirect_to ) )
			{
	        		header("Location: " . $this->redirect_to );
			}
		}
		function checkprefs()
		{
			return $this->updateprefs();
		}
		function call_table( $action, $msg )
		{
	                start_form(true);
	                start_table(TABLESTYLE2, "width=40%");
	                table_section_title( $msg );
	                hidden('action', $action );
	                end_table(1);
	                submit_center( $action, $msg );
	                end_form();
		}
		function action_show_form()
		{
			return $this->show_config_form();
		}
		function show_config_form()
		{
			start_form(true);
		 	start_table(TABLESTYLE2, "width=40%");
			$th = array("Config Variable", "Value");
			table_header($th);
			$k = 0;
			alt_table_row_color($k);
				/* To show a labeled cell...*/
				//label_cell("Table Status");
				//if ($this->found) $table_st = "Found";
				//else $table_st = "<font color=red>Not Found</font>";
				//label_cell($table_st);
				//end_row();
			foreach( $this->config_values as $row )
			{
				//Original version of this function only displays text boxes for values.
				//What if the values should be boolean, or enum, or a selection from a
				//drop down list like a list of locations?
				if( isset( $row['integration_module'] ) AND strlen($row['integration_module']) > 3 )
				{		
				}
				else if( isset( $row['type'] ) AND strlen($row['type']) > 3 )
				{		
					if( strncasecmp( "bool", $row['type'], 4 ) )
					{
					//Type BOOL
						//label, name, value, submit_on_change, title
						checkbox( $row['label'], $row['pref_name'], $this->$row['pref_name'], false, $row['label'] );
					}
					else if( strncasecmp( "enum", $row['type'], 4 ) )
					{
					//Type ENUM (Select)
						//$label, $name, $value, $selected=null, $submit_on_change=false
						radio($row['label'], $row['pref_name'], $this->$row['pref_name'], false, $row['label']);
					}
					else if( strncasecmp( "enum", $row['type'], 4 ) )
					{
						//Type from another table
						combo_input($name, $selected_id, $sql, $valfield, $namefield, $options=null );
					}
					else if( strncasecmp( "file", $row['type'], 4 ) )
					{
						//Type from another table
						file_row($row['label'], $row['pref_name'], $this->$row['pref_name']);
					}
					else if( strncasecmp( "location", $row['type'], 4 ) )
					{
						//Type from another table
						locations_list_row( $row['label'], $row['pref_name'], $this->$row['pref_name'], false, false);
					}

					//All other types
					text_row($row['label'], $row['pref_name'], $this->$row['pref_name'], 20, 60);
				}
				else
					//supplier_list_row
					//customer_list_row
					//currencies_list_row 
					//fiscalyears_list_row
					//dimensions_list_row
					//sales and stock lists
					//currences
					//tax_types_list_row and tax_groups
					//shippers_list_row
					//sales_persons_list_row

					text_row($row['label'], $row['pref_name'], $this->$row['pref_name'], 20, 60);
			}
			end_table(1);
			if (!$this->found) {
			    hidden('action', 'create');
			    submit_center('create', 'Create Table');
			} else {
			    hidden('action', 'update');
			    submit_center('update', 'Update Configuration');
			}
			end_form();
			
		}
		function form_export()
		{
			$selected_id = 1;
			$none_option = "";
			$submit_on_change = FALSE;
			$all = FALSE;
			$all_items = TRUE;
			$mode = 1;
			$spec_option = "";
			 start_form(true);
	
			 start_table(TABLESTYLE2, "width=40%");
	
			 table_section_title("Export Purchase Order");
	
			 $company_record = get_company_prefs();
	
			$this->get_id_range();
	
			//$sql = "SELECT supp_name, order_no FROM " . $this->company_prefix . "purch_orders o, " . $this->company_prefix . "suppliers s where s.supplier_id = o.supplier_id";
			//echo combo_input("SupplierPO", $selected_id, $sql, 'supplier_id', 'supp_name',
	/*
			echo combo_input("order_no2", $this->order_no, $sql, 'supp_name', 'order_no',
	        		array(
	                		//'format' => '_format_add_curr',
	            			'order' => array('order_no'),
	                		//'search_box' => $mode!=0,
	                		'type' => 1,
	        			//'search' => array("order_no","supp_name"),
	                		//'spec_option' => $spec_option === true ? _("All Suppliers") : $spec_option,
	                		'spec_id' => $all_items,
	                		'select_submit'=> $submit_on_change,
	                		'async' => false,
	                		//'sel_hint' => $mode ? _('Press Space tab to filter by name fragment') :
	                		//_('Select supplier'),
	                		//'show_inactive'=>$all
	                	)
			);
	*/
	
			 text_row("Export " . $this->vendor . " Purchase Order ID:", 'order_no', $this->order_no, 10, 10);
	
			 end_table(1);
	
			 hidden('action', 'c_export');
			 submit_center('cexport', "Export  " . $this->vendor . " Purchase Orders");
	
			 end_form();
		}
		function related_tabs()
		{
			$action = $this->action;
			/*
			if( isset( $this->ui_class ) )
				$this->tabs = $this->ui_class->tabs;
			 */
			foreach( $this->tabs as $tab )
			{
				if( $action == $tab['action'] )
				{
					echo $tab['title'];
					echo '&nbsp;|&nbsp;';
				}
				else
				{
					if( $tab['hidden'] == FALSE )
					{
						hyperlink_params($_SERVER['PHP_SELF'], 
							_("&" .  $tab['title']), 
							"action=" . $tab['action'], 
							false);
						echo '&nbsp;|&nbsp;';
					}
				}
			}
		}
		function show_form()
		{
			$action = $this->action;
			if( isset( $this->view ) )
			{
				$this->view->action = $this->action;
				$this->view->show_form();
				return;
			}
			/*
			if( isset( $this->ui_class ) )
				$this->tabs = $this->ui_class->tabs;
			 */
			foreach( $this->tabs as $tab )
			{
				//We have a tab w/o action/form
				//print_r( "TAB missing action/form <br />" );
				//var_dump( $tab );
				if( $action == $tab['action'] )
				{
					if( isset( $tab['class'] ) )
					{
						$objname = $tab['class'];
						//action/form added by module.  Will be external to 
						//controller...
						$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_DEBUG', "Class name set for tab " . $objname  );
					}
					//Call appropriate form
					$form = $tab['form'];
					$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_DEBUG', "Should be calling form " . $form  );
					if( $this->debug > 2 )
						echo "<br />" . __FILE__ . ":" . __LINE__ . " " .$form . "<br />";
					if( ! isset( $objname ) )
					{
						$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_DEBUG', "No external object set, so try calling internal form: " . $form  );
						if( method_exists( $this, $form) )
						{
							if( is_callable( array( $this, $form ) ) )
							{
								$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_DEBUG', __FILE__ . ":" . __LINE__ . " Calling non-UI class " .$form );
								$this->$form();
							}
							else
							{
								$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_ERROR', "FORM not callable!! " . $form . ":: We shouldn't be here unless during development and the form hasn't been coded!"  );
							}
						}
						else
						{
							$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_ERROR', "FORM doesn't exist!! " . $form . ":: We shouldn't be here unless during development and the form hasn't been coded!"  );
						}
					}
					else
					{
						//create and call the module.
						//Odds it already exists?  As this is a web based app and not continous,
						// slim unless it was serialized.  Since we aren't doing that currenty...
						$obj = new $objname();
						if( method_exists( $obj, $form) )
						{
							if( is_callable( array( $obj, $form ) ) )
							{
								$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_DEBUG', "Calling " . $objname . "::" . $form );
								$obj->$form();
							}
							else
							{
								$this->notify( "Object Class set for action but not callable: " . $objname . "::" . $form, "WARN" );
								$this->eventloop->ObserverNotify( $this, 'NOTIFY_OBJECT_NOT_CALLABLE', $objname . "::" . $form  );
							}
						}
						else
						{
								$this->notify( "Method doesn't exist: " . $objname . "::" . $form, "WARN" );
								$this->eventloop->ObserverNotify( $this, 'NOTIFY_OBJECT_NOT_CALLABLE', $objname . "::" . $form  );
						}
					}
				}
				else
				{	
							$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_DEBUG', "No Match between " . $action . "::" . $tab['action']  );
				}
	
			}
		}
		function base_page()
		{
			/*
			if( isset( $this->ui_class ) )
				page(_($this->ui_class->help_context));
			else
			 */
			global $use_popup_windows;
			global $js;
			if ($use_popup_windows) 
			{
				$js .= get_js_open_window(800, 500);
			}
			else
			{
				$js='';
			}

			//page(_($help_context), false, false, "", $js);
			/* Mantis 210 
			 * Cannot redeclare help_url() (previously declared in /var/www/html/devel/fhs/frontaccounting/includes/page/header.inc:15) in /var/www/html/devel/fhs/frontaccounting/includes/page/header.inc on line 15
				page(_($this->help_context), false, false, "", $js);
			*/
			//page(_($this->help_context));
			$this->related_tabs();
		}
		function display()
		{
			$this->base_page();
			$this->show_form();
			end_page();
		}
		function run()
		{
			if ($this->found) {
			  	$this->loadprefs();
			}
			else
			{
			        $this->install();
			        $this->set_var( 'action', "default" );
			}
			
			if (isset($_POST['action']))
			{
			        $this->set_var( 'action', $_POST['action'] );
			}
			else if (isset($_GET['action']) && $this->found)
			{
			        $this->set_var( 'action', $_GET['action'] );
			}
			else
			{
				if( isset( $this->view ) )
					$this->view->run();
				else
				{
					//action not set, so we passed in a Button
					foreach( $this->tabs as $row )
					{
						if( isset( $row['action'] ) AND isset( $_POST ) AND isset( $_POST[$row['action']] ) )
						{
							$this->set_var( 'action', $row['action'] );
							//echo "Set action to " . $row['action'] . " <br />";
							$this->eventloop->ObserverNotify( $this, 'NOTIFY_LOG_INFO',  "Set action to " . $row['action'] );
							continue;
						}
					}
				}
			}
			//Make sure the UI has all the set values...
			/*
			if( isset( $this->ui_class ) )
			{
				foreach( $this->ui_class->config_values as $val )
				{
					$this->ui_class->set_var( $val, $this->get_var( $val ) );
				}
			}
			 */
			//echo __FILE__ . ":" . __LINE__ . "<br />\n"; 
			$this->display();
		}
		/**********************************************************************************************//**
		 *
		 * Must have table, column and type set
		 *
		 * @params $tables_array array with values
		 * 	table		(required)
		 * 	column		(required)
		 * 	type		(required)
		 * 	length		(optional)
		 * 	nullnotnull	(optional)
		 * 	default		(optional)
		 * 	auto_increment	(optional) value unimportant.  If set, field set to auto_increment
		 * 	comment		(optional)
		 *
		 * *********************************************************************************************/
		function modify_table_column( $tables_array )
		{
			foreach( $tables_array as $row )
			{
					//ALTER TABLE t1 MODIFY b BIGINT NOT NULL;
				$sql = "ALTER TABLE " . $row['table'] . " MODIFY " . $row['column'] . " " . $row['type'];
				if( isset( $row['length'] ) )
					$sql .= "(" . $row['length']  . ")";
				if( isset( $row['nullnotnull'] ) )
					$sql .= " " . $row['nullnotnull'] . " ";
				if( isset( $row['default'] ) )
					$sql .= " DEFAULT '" . $row['default'] . "' ";
				if( isset( $row['autoincrement'] ) )
					$sql .= " AUTO_INCREMENT ";
				if( isset( $row['comment'] ) )
					$sql .= " COMMENT '" . $row['comment']  . "' ";
				$res = db_query( $sql, "Couldn't alter STOCK_ID length in " . $row['table'] );
				if( false !== $res )
				{
					//$this->notify( "Altered " . $row['table'] . " Column " . $row['column'], "WARN" );
					//display_notification( __FILE__ . " Altered " . $row['table'] . ", Column " . $row['column'] . "::Statement: " . $sql );
				}
			}
		}
		/*@fp@*/function append_file( $filename )
		{
			return fopen( $filename, 'a' );
		}
		/*@fp@*/function overwrite_file( $filename )
		{
			return $this->open_write_file( $filename );
		}
		/*@fp@*/function open_write_file( $filename )
		{
			return fopen( $filename, 'w' );
		}
		/*@int or FALSE@*/function write_line( $fp, $line )
		{
			return fwrite( $fp, $line . "\n" );
		}
		/*@nada@*/function close_file( $fp )
		{
			$this->file_finish( $fp );
			$fp = null;	//Does this do anything?  Pass by value or reference?
		}
		/*@nada@*/function file_finish( $fp )
		{
			fflush( $fp );
			fclose( $fp );
			$fp = null;	//Does this do anything?  Pass by value or reference?
		}
		function backtrace()
		{
			echo "<br />";
			array_walk(debug_backtrace(),create_function('$a,$b','print "{$a[\'function\']}()(".basename($a[\'file\']).":{$a[\'line\']});<br /> ";'));
		}
		/******************************************************************************//**
		* Generate a line in a CSV to be used to print labels
		*
		*
		*	This function is being use to create a CSV for both labels and pricebook.
		*	To make the sku readable, we need the font to be at least 24 points
		*	 which limits the SKU length to around 17 characters.  The leading
		*	 characters in a variable product (broach-...-...-...) is pretty
		*	 much redundant as far as the product search is concerned. FIX is 
		*	 to count the number of dashes, and ensure we wrap a few dashes since
		*	 the odds of g-abc-def duplicating is low.  However abc-def might repeat
		*	 in size-color attribute type pairings.  Safe to cut off 1 chunck...
		*
		* @param string stock_id
		* @param string category
		* @param string description
		* @param float price
		*
		* @returns null
		**************************************************************************************/
		function write_sku_labels_line( $stock_id, $category, $description, $price )
		{
			$barcode_max_length = 17;
	 		$line  = '"' . $stock_id . '",';
			$line .= '"' . $description . '",';
			/*********************
			 * 20180828 strlen check and dash count...
			 * *******************/
			$trimcase = 0;
			$sku_length = strlen( $stock_id );
			if( $sku_length > $barcode_max_length )
			{
				$highest_offset = $sku_length - $barcode_max_length;
				//$pieces = explode(" ", $string, (optional) MAXPIECECOUNT);
				$pieces_array = explode( "-", $stock_id );
				//broach-d-ths-stn-pnk
				//kilt-rs-48
				//buckle-celtic-msg
				//hd-ghillies-19.5-dw
				//U-HT-B-M
				//beermug-dancer-irish
				//1234-5678-9012-3456   	19char
				//1234-5678-9012-3456-7890   	24char
				$pieces_count = count( $pieces_array );
				//zero based array
				for( $i = $pieces_count - 1; $i > 0; $i-- )	//don't need 0, that is sku_length
				{
					$chunklength[$i] = strlen( $pieces_array[$i] );
					if( isset( $backlength[$i + 1] ) )
						$backlength[$i] = $backlength[$i + 1] + $chunklength[$i] + 1;	//If we cut the sku here...
					else
						$backlength[$i] = $chunklength[$i] + 1; //missing leading separator from chunk
				}
				if( !isset( $backlength[1]  ) )
				       $backlength[1] = $barcode_max_length - 1;	
				//TODO
				//Find the last n-1 chuncks.
				//The following algo can certainly be improved GREATLY!!
				//
				//Could also do a Foreign Code search and replace if exists...
				if( $backlength[1] < $barcode_max_length ) 
				{
					//19char would work
					$stock_id = substr( $stock_id, -$barcode_max_length );	//last 17 chars
					$trimcase = 1;
				}
				else
				{
					//need to find a good middle e.g. 24char
					//						4-5678-9012-3456-7
					if( ( $sku_length - strlen( $pieces_array[0] ) + 1 - $backlength[ $pieces_count - 1 ] + 1 ) < $barcode_max_length )
					{
						//u-balmoral-navy-75
						/*
						if( $sku_length - $barcode_max_length < 2 )
							$offset = 1;
						else
							$offset = strlen( $pieces_array[0] ) - 2 );
	 					*/
						$offset = floor( (strlen( $pieces_array[0] ) + $backlength[ $pieces_count - 1 ])/2) ;
						if( $offset > strlen( $pieces_array[0] ) AND $pieces_count > 3 )	//want 1 char of first piece
							$offset = strlen( $pieces_array[0] );

						$trimcase = 2;
						$stock_id = substr( $stock_id, $offset , $barcode_max_length );	
					}
					else	//exact middle			24char => 12 - 8 => -5678-9012-3456-7
					{
						//Risk is prod-6789012345-21 and prod-6789012345-22 will end up with same barcode
						//At least it gets us into the right products...
						$offset = floor($sku_length/2) - floor($barcode_max_length/2);
						$stock_id = substr( $stock_id, $offset , $barcode_max_length );	
						$trimcase = 3;
					}
				}
			}
			/*********************
			 * !20180828 strlen check and dash count...
			 * *******************/
                        $line  .= '"*' . strtoupper( $stock_id ) . '*",';        //For 3of9 Barcode
                        $line .= '"' . $category . '",';
                        $line .= '"' . $price . '",';
                        $line .= '"' . $trimcase . '",';
                        $this->write_file->write_line( $line );
			return null;
		}
		function show_generic_form($form_array)
		{
			start_form(true);
		 	start_table(TABLESTYLE2, "width=40%");
			$th = $form_array['header'];
			table_header($th);
			$k = 0;
			alt_table_row_color($k);
				/* To show a labeled cell...*/
				//label_cell("Table Status");
				//if ($this->found) $table_st = "Found";
				//else $table_st = "<font color=red>Not Found</font>";
				//label_cell($table_st);
				//end_row();
			foreach( $form_array['rows'] as $row )
			{
				//Original version of this function only displays text boxes for values.
				//What if the values should be boolean, or enum, or a selection from a
				//drop down list like a list of locations?
				if( isset( $row['integration_module'] ) AND strlen($row['integration_module']) > 3 )
				{		
				}
				else if( isset( $row['type'] ) AND strlen($row['type']) > 3 )
				{		
					if( strncasecmp( "bool", $row['type'], 4 ) )
					{
					//Type BOOL
						//label, name, value, submit_on_change, title
						checkbox( $row['label'], $row['row_name'], $this->$row['row_name'], false, $row['label'] );
					}
					else if( strncasecmp( "enum", $row['type'], 4 ) )
					{
					//Type ENUM (Select)
						//$label, $name, $value, $selected=null, $submit_on_change=false
						radio($row['label'], $row['row_name'], $this->$row['row_name'], false, $row['label']);
					}
					else if( strncasecmp( "enum", $row['type'], 4 ) )
					{
						//Type from another table
						combo_input($name, $selected_id, $sql, $valfield, $namefield, $options=null );
					}
					else if( strncasecmp( "file", $row['type'], 4 ) )
					{
						//Type from another table
						file_row($row['label'], $row['row_name'], $this->$row['row_name']);
					}
					else if( strncasecmp( "location", $row['type'], 4 ) )
					{
						//Type from another table
						locations_list_row( $row['label'], $row['row_name'], $this->$row['row_name'], false, false);
					}

					//All other types
					text_row($row['label'], $row['row_name'], $this->$row['row_name'], 20, 60);
				}
				else
					//supplier_list_row
					//customer_list_row
					//currencies_list_row 
					//fiscalyears_list_row
					//dimensions_list_row
					//sales and stock lists
					//currences
					//tax_types_list_row and tax_groups
					//shippers_list_row
					//sales_persons_list_row

					text_row($row['label'], $row['row_name'], $this->$row['row_name'], 20, 60);
			} //foreach
			end_table(1);
			foreach( $form_array['button'] as $buttons )
			    submit_center( $buttons['name'], $buttons['label']);
			end_form();
			
		}

	
	} //!class

	
}//!file if

class generic_fa_interface_view extends generic_fa_interface
{
	var $controller;	//!< object where we will get config values from, etc
	var $header_arr;	//!< array header array for edit tables
	var $show_inactive;	//!< bool constructor default false
	function __construct( $host, $user, $pass, $database, $pref_tablename, $controller = null, $show_inactive = false  )
	{
		parent::__construct( $host, $user, $pass, $database, $pref_tablename );
		$this->show_inactive = $show_inactive;
		$this->controller = $controller;
	}
	/***********************************************************************************//**
	 * Block menu/shortcut links during transaction procesing.
	 *
	 * @param bool
	 * @return none
	*/
	function page_processing($msg = false)
	{
	        global $Ajax;
	        if ($msg === true)
	                $msg = _('Entered data has not been saved yet.\nDo you want to abandon changes?');
	
	        $js = "_validate._processing=" . (
	                $msg ? '\''.strtr($msg, array("\n"=>'\\n')) . '\';' : 'null;');
	        if (in_ajax()) {
	                $Ajax->addScript(true, $js);
	        } else
	                add_js_source($js);
	}
	function usage_form()
	{
		$this->title = "How to Use this Module";
		start_form(true);
                start_table(TABLESTYLE2, "width=40%");
                table_section_title( "How to use this module" );
		table_section(1);
		label_row( "Config", "Configuration screen for things like DEBUG level." );
		label_row( "TAB 2", "TAB 2 Usage summary" );
		label_row( "blank1", "" );
		//end_table(1);
                //start_table(TABLESTYLE2, "width=40%");
                table_section_title( "Known Bugs" );
		label_row( "Tab1", "Known Bug" );
		//end_table(1);
                //start_table(TABLESTYLE2, "width=40%");
                table_section_title( "Roadmap" );
		label_row( "V2", "No Planned enhancements other than bug fixes." );
                table_section_title( "Developer Documentation" );
		label_row( "Documentation", '<a href="html/index.html">Class and member Documentation</a>' );
		end_table(1);
		end_form();
		$msg = __FILE__ . "::" . __LINE__ . " Author goofed!";
		throw new Exception( $msg , 99 );
	}

	/***************************************************//**
	 * Force a reload of the page through AJAX
	 *
	 * @param bool has the displayable page changed?
	 *
	 * *******************************************************/
	function page_modified($status = true)
	{
	        global $Ajax;
	        $js = "_validate._modified=" . ($status ? 1:0).';';
	        if (in_ajax()) {
	                $Ajax->addScript(true, $js);
	        } else
	                add_js_source($js);
		echo '<script>parent.window.location.reload(true);</script>';
	}
	function ajax_reload()
	{
		echo '<script>parent.window.location.reload(true);</script>';
	}
	function confirm_dialog($submit, $msg) 
	{
		if (find_post($submit)) 
		{
	                display_warning($msg);
	                br();
	                submit_center_first('DialogConfirm', _("Proceed"), '', true);
	                submit_center_last('DialogCancel', _("Cancel"), '', 'cancel');
	                return 0;
	        } else
	                return get_post('DialogConfirm', 0);
	}
	function processing_start()
	{
	    	$this->page_processing(false);
	    	$this->processing_end();
	    	$_SESSION['Processing'] = $_SERVER['PHP_SELF'];
	}
	function processing_end()
	{
	        $this->page_processing(true);
		unset($_SESSION['Processing']);
	}

	function default_form()
	{
		start_form(true);
	 	start_table(TABLESTYLE2, "width=40%");
		$th = array("Config Variable", "Value");
		table_header($th);
		$k = 0;
		alt_table_row_color($k);
		label_row( "Config", "Default Instructions" );
		label_row( "Config2", "Default Instructions 2" );
		label_row( "Config3", "" );
		label_row( "Config4", "The Class author should have overwritten this function or at least the default action!!!" );
		end_table(1);
		end_form();
		$msg = __FILE__ . "::" . __LINE__ . " Author goofed!";
		throw new Exception( $msg , 99 );
	}
	function show_config_form()
	{
		//display_notification( __FILE__ . "::" . __CLASS__ . "::"  . __METHOD__ . ":" . __LINE__, "WARN" );
		start_form(true);
	 	start_table(TABLESTYLE2, "width=40%");
		$th = array("Config Variable", "Value");
		table_header($th);
		$k = 0;
		alt_table_row_color($k);
			/* To show a labeled cell...*/
			//label_cell("Table Status");
			//if ($this->found) $table_st = "Found";
			//else $table_st = "<font color=red>Not Found</font>";
			//label_cell($table_st);
			//end_row();
		if( isset( $this->controller->config ) )
			$source = $this->controller->config;
		else
			$source = $this->controller;
		//var_dump( $source );
		foreach( $source->config_values as $row )
		{
			//Original version of this function only displays text boxes for values.
			//What if the values should be boolean, or enum, or a selection from a
			//drop down list like a list of locations?
			/*
			if( isset( $row['integration_module'] ) AND strlen($row['integration_module']) > 3 )
			{		
			}
			else*/ if( isset( $row['type'] ) AND strlen($row['type']) > 3 )
			{
				$type = strtoupper( $row['type'] );
				switch( $type )
				{
					case "bool":
						//label, name, value, submit_on_change, title
						checkbox( $row['label'], $row['pref_name'], $source->$row['pref_name'], false, $row['label'] );
						break;
					case "enum":
						//$label, $name, $value, $selected=null, $submit_on_change=false
						radio($row['label'], $row['pref_name'], $source->$row['pref_name'], false, $row['label']);
						break;
					case "foreign":
						//Type from another table
						combo_input($name, $selected_id, $sql, $valfield, $namefield, $options=null );
						break;
					case "file":
						//Type from another table
						file_row($row['label'], $row['pref_name'], $source->$row['pref_name']);
						break;
					case "location":
						locations_list_row( $row['label'], $row['pref_name'], $source->$row['pref_name'], false, false);
						break;
					default:
						text_row($row['label'], $row['pref_name'], $source->$row['pref_name'], 20, 60);
				}
				//supplier_list_row
				//customer_list_row
				//currencies_list_row 
				//fiscalyears_list_row
				//dimensions_list_row
				//sales and stock lists
				//currences
				//tax_types_list_row and tax_groups
				//shippers_list_row
				//sales_persons_list_row
			}

		}
		end_table(1);
		if (!$source->found) {
		    hidden('action', 'create');
		    submit_center('create', 'Create Config Table');
		} else {
		    hidden('action', 'update');
		    submit_center('update', 'Update Config Configuration');
		}
		end_form();
	}
	function tabledef2headers()
	{
		$this->header_arr = array();
		if( isset( $this->controller->model ) )
		{
			foreach( $this->controller->model->table_interface->fields_array as $row )
			{
				$this->header_arr[$row['name']] = _($row['label']);
			}
		}
		$this->header_arr['edit'] = "";
		$this->header_arr['delete'] = "";
		if( $this->show_inactive )
			$this->header_arr['inactive'] = "";
	}
}

require_once( 'class.generic_fa_interface_model.php');

class generic_fa_interface_controller extends generic_fa_interface
{
	var $model;	//!< Object To be set in inheriting class
	var $view;	//!< Object To be set in inheriting class
	var $config;	//!< Object To be set in inheriting class
}

?>
