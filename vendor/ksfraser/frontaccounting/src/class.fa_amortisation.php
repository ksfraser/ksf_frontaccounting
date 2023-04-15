<?php

require_once( 'class.table_interface.php' );

$path_to_root = "../..";
/*
include_once($path_to_root . "/includes/date_functions.inc");
include_once($path_to_root . "/includes/banking.inc");
include_once($path_to_root."/sales/inquiry/customer_inquiry.php");

require_once( $path_to_root . '/sales/includes/db/customers_db.inc' ); //add_customer
require_once( $path_to_root . '/sales/includes/db/branches_db.inc' ); //add_branch
require_once( $path_to_root . '/includes/db/crm_contacts_db.inc' ); //add_crm_*
 */
require_once( $path_to_root . '/includes/db/connect_db.inc' ); //db_query, ...
require_once( $path_to_root . '/includes/errors.inc' ); //check_db_error, ...

class amortisation extends table_interface
{
	/************************************************
	 * This is the FA attachments table
	 
	 * *********************************************/
	/*
+-------------------+---------------------+------+-----+---------+----------------+
| Field             | Type                | Null | Key | Default | Extra          |
+-------------------+---------------------+------+-----+---------+----------------+
| amortisation_id   | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| asset_id          | int(11)             | YES  | MUL | NULL    |                |
| amortisation_year | int(11)             | YES  |     | NULL    |                |
| asset_value       | double              | YES  |     | NULL    |                |
| amount            | double              | YES  |     | NULL    |                |
| posted            | int(11)             | NO   |     | 0       |                |
| inactive          | tinyint(4)          | NO   |     | 0       |                |
| details           | text                | YES  |     | NULL    |                |
+-------------------+---------------------+------+-----+---------+----------------+

	 */ 
	protected $amortisation_id;
	protected $asset_id;
	protected $amortisation_year;
	protected $asset_value;
	protected $amount;
	protected $posted;
	protected $inactive;
	protected $details; 

	function __construct( $caller = null )
	{
		parent::__construct( $caller );
		$descl = 'varchar(' . DESCRIPTION_LENGTH . ')';
		$this->table_details['tablename'] = TB_PREF . get_class( $this );

		$this->fields_array[] = array( 'name' => 'amortisation_id', 'label' => '', 'type' => 'bigint(20)', 'null' => 'NOT NULL', 'readwrite' => 'readwrite', 'default' => 'NULL', 'auto_increment' => true );
		$this->fields_array[] = array( 'name' => 'asset_id', 'label' => '', 'type' => 'int(11)', 'null' => 'NULL', 'readwrite' => 'readwrite', 'default' => 'NULL' );
		$this->fields_array[] = array( 'name' => 'amortisation_year', 'label' => '', 'type' => 'int(11)', 'null' => 'NULL', 'readwrite' => 'readwrite', 'default' => 'NULL' );
		$this->fields_array[] = array( 'name' => 'asset_value', 'label' => '', 'type' => 'double', 'null' => 'NULL', 'readwrite' => 'readwrite', 'default' => 'NULL' );
		$this->fields_array[] = array( 'name' => 'amount', 'label' => '', 'type' => 'double', 'null' => 'NULL', 'readwrite' => 'readwrite', 'default' => 'NULL' );
		$this->fields_array[] = array( 'name' => 'posted', 'label' => '', 'type' => 'int(11)', 'null' => 'NOT NULL', 'readwrite' => 'readwrite', 'default' => '0' );
		$this->fields_array[] = array( 'name' => 'inactive', 'label' => '', 'type' => 'tinyint(4)', 'null' => 'NOT NULL', 'readwrite' => 'readwrite', 'default' => '0' );
		$this->fields_array[] = array( 'name' => 'details', 'label' => '', 'type' => 'text', 'null' => 'NULL', 'readwrite' => 'readwrite', 'default' => 'NULL' );

		$this->table_details['primarykey'] = "amortisation_id";
	}


}

