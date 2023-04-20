<?php

/**************************************************//**
* Front Accounting specific Defines
*
*********************************************************/

$path_to_faroot= dirname ( realpath ( __FILE__ ) ) . "/../..";
//$path_to_faroot = __DIR__ . "/../../";
$path_to_ksfcommon = __DIR__ . "/";

require_once( 'defines.inc.php' );


//Dream Payments
define( 'DREAM_VARCHAR_SIZE', 255 );

define( 'NOT_SELECTED', -1 );
define( 'PRIMARY_KEY_NOT_SET', 5730 );


//table stock_master
define( 'STOCK_ID_LENGTH_ORIG', 20 );
define( 'STOCK_ID_LENGTH', 64 );
define( 'DESCRIPTION_LENGTH', 200 );
define( 'ACCOUNTCODE_LENGTH', 15 );
define( 'GL_ACCOUNT_NAME_LENGTH', 32 );
//prod_variables
define( 'SLUG_LENGTH', 5 );

define( 'REFERENCE_LENGTH', 40 );
define( 'LOC_CODE_LENGTH', 5 );
//table stock_category
define( 'CAT_DESCRIPTION_LENGTH', 20 );
define( 'MAX_UPC_LEN', 14 );
define( 'MIN_UPC_LEN', 4 );

//table suppliers
define( 'SUPP_NAME_LENGTH', 60 );
define( 'SUPP_WEBSITE_LENGTH', 100 );
define( 'SUPP_REF_LENGTH', 30 );
define( 'SUPP_ACCOUNT_NO_LENGTH', 40 );

//EVENTLOOP Events
$eventcount = 5730;
define( 'KSF_DUMMY_EVENT', $eventcount ); $eventcount++;	//Used by woo_interface:build_interestedin as example
define( 'WOO_DUMMY_EVENT', $eventcount ); $eventcount++;	//Used by woo_interface:build_interestedin as example
define( 'WOO_PRODUCT_INSERT', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_UPDATE', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_PRICE_UPDATE', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_QOH_UPDATE', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_SPECIALS_UPDATE', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_TAXDATA_UPDATE', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_SHIPDIM_UPDATE', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_CROSSSELL_UPDATE', $eventcount ); $eventcount++;
define( 'WOO_PRODUCT_CATEGORY_UPDATE', $eventcount ); $eventcount++;
define( 'FA_PRODUCT_PRICE_UPDATE', $eventcount ); $eventcount++;
define( 'FA_PRODUCT_QOH_UPDATE', $eventcount ); $eventcount++;
define( 'FA_PRODUCT_CATEGORY_UPDATE', $eventcount ); $eventcount++;
define( 'FA_CUSTOMER_CREATED', $eventcount ); $eventcount++;

//More EVENTS
define( 'FA_NEW_STOCK_ID', $eventcount ); $eventcount++;
define( 'FA_PRODUCT_UPDATED', $eventcount ); $eventcount++;
define( 'FA_PRODUCT_LINKED', $eventcount ); $eventcount++;
define( 'FA_PRICE_UPDATED', $eventcount ); $eventcount++;
define( 'KSF_WOO_RESET_ENDPOINT', $eventcount ); $eventcount++;
define( 'KSF_WOO_INSTALL', $eventcount ); $eventcount++;
define( 'KSF_SALE_ADDED', $eventcount ); $eventcount++;
define( 'KSF_SALE_REMOVED', $eventcount ); $eventcount++;
define( 'KSF_SALE_EXPIRED', $eventcount ); $eventcount++;
define( 'KSF_WOO_GET_PRODUCT', $eventcount ); $eventcount++;
define( 'KSF_WOO_GET_PRODUCTS_ALL', $eventcount ); $eventcount++;


//set_global_stock_item(), get_global_stock_item()
//Need to check following functions
//write_customer_trans_detail_item()
//add_grn_to_trans() 
if( !defined( 'TB_PREF' ) )
	define( 'TB_PREF', "1_" );
$stock_id_tables = array();	//stock_id, item_code, stk_code, idx_stock_id, master_stock_id, child_stock_id, sku, barcode, slug, item_img_name
$stock_id_tables[] = array( 'table' => TB_PREF . 'bom', 'column' => 'parent', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );//Need to dbl check this one!
$stock_id_tables[] = array( 'table' => TB_PREF . 'bom', 'column' => 'component', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );//Need to dbl check this one!
$stock_id_tables[] = array( 'table' => TB_PREF . 'debtor_trans_details', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'grn_items', 'column' => 'item_code', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'item_codes', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'item_codes', 'column' => 'item_code', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'loc_stock', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'prices', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'purch_data', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH  );
$stock_id_tables[] = array( 'table' => TB_PREF . 'purch_order_details', 'column' => 'item_code', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'qoh', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'sales_order_details', 'column' => 'stk_code', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'stock_master', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'stock_moves', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'supp_invoice_items', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'wo_issue_items', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'wo_requirements', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'workorders', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
$stock_id_tables[] = array( 'table' => TB_PREF . 'woo', 'column' => 'stock_id', 'type' => 'VARCHAR', 'length' => STOCK_ID_LENGTH );
//$stock_id_tables[] = array( 'table' => TB_PREF . '', 'column' => 'stock_id' );


global $path_to_ksfcommon;
$path_to_ksfcommon = __DIR__;

?>

