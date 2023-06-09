<?php

//require_once( 'class.generic_orders.php' ); 
require_once( 'class.pricebook_file.php' ); 
global $path_to_root;

/*******************************************************//**
 * Generate an import CSV for SquareUp
 *
 * This class is only for data extraction and file creation.
 * There shouldn't be any UI.
 *
 * ********************************************************/
class square_catalog extends pricebook_file
{
	function __construct( $pref_tablename )
	{
		parent::__construct( null, null, null, null, $pref_tablename );
		$this->filename = "square_catalog.csv";
		$this->hline  = '"Token", "Item Name", "Description", "Category", "SKU", "Variation Name", "Price", "Enabled Fraser Highland Shoppe", "Current Quantity Fraser Highland Shoppe", "New Quantity Fraser Highland Shoppe", "Stock Alert Enabled Fraser Highland Shoppe", "Stock Alert Count Fraser Highland Shoppe", "Price Fraser Highland Shoppe", "Enabled DEVEL", "Current Quantity DEVEL", "New Quantity DEVEL", "Stock Alert Enabled DEVEL", "Stock Alert Count DEVEL", "Price DEVEL", "Tax - GST (5%)"';
		$this->query = "select s.stock_id as stock_id, s.description as description, s.long_description as long_description, q.instock as instock, c.description as category, p.price as price, r.reorder_level as lowstock from " . TB_PREF . "stock_master s, " . TB_PREF . "ksf_qoh q, " . TB_PREF . "stock_category c, " . TB_PREF . "prices p, " . TB_PREF . "loc_stock r where s.inactive=0 and s.stock_id=q.stock_id and s.category_id = c.category_id and s.stock_id=p.stock_id and p.curr_abrev='CAD' and p.sales_type_id=1 and r.loc_code='HG' and r.stock_id=s.stock_id order by c.description, s.description";
		//$this->query = "select s.stock_id as stock_id, s.description as description, s.long_description as long_description, q.instock as instock, c.description as category, p.price as price, from " . TB_PREF . "stock_master s, " . TB_PREF . "ksf_qoh q, " . TB_PREF . "stock_category c, " . TB_PREF . "prices p where s.inactive=0 and s.stock_id=q.stock_id and s.category_id = c.category_id and s.stock_id=p.stock_id and p.curr_abrev='CAD' and p.sales_type_id=1 order by c.description, s.description";
		
	}
	
	//INHERIT function prep_write_file()	
	/*************************************//**
	 * Get the details for labels from stock_master, stock_category, prices
	 *
	 * @return db_result
	 * ****************************************/
	function get_catalog_details_all()
	{
		require_once( '../ksf_modules_common/class.fa_stock_master.php' );
		$sm = new fa_stock_master( $this->pref_tablename );
		$sm->getAll( true );	//->stock_array
		return $sm->stock_array; 
	}
	/******************************************************//**
	 * This function creates the csv file for upload to Square
	 *
	 * Due to the query used in this class, we might not get all
	 * of the items from inventory if the REORDER level isn't set.
	 * This can be fixed with a query like
	 * 	insert ignore into 1_loc_stock( loc_code, reorder_level, stock_id ) select 'HG', 0, stock_id from 1_stock_master;
	 *
	 * @param internal hline
	 * @param internal query
	 * @param internal write_file (object)
	 * @param internal email_file (object)
	 * *******************************************************/
	/*@int@*/function create_file()
	{
		/*
		require_once( '../ksf_modules_common/class.fa_stock_category.php' ); 
		$sc = new fa_stock_category( $this );
		require_once( '../ksf_modules_common/class.fa_prices.php' ); 
		$sp = new fa_prices( $this );
		require_once( '../ksf_qoh/class.ksf_qoh.php' ); 
		$qoh = new ksf_qoh( $this->pref_tablename );
		require_once( $path_to_root . '/includes/db/inventory_db.inc' );	//get_qoh_on_date($stock_id, $location=null, $date_=null) 
		 */

		$this->prep_write_file();
		$this->write_file->write_line( $this->hline );

		//$result = $this->get_catalog_details_all();	//Pass this func name in as param allows a generic version...
		$result = db_query( $this->query, "Couldn't grab inventory to export to square" );

		$rowcount=0;
/*
		foreach( $result as $row ) 
		{
			$sp->set( 'stock_id', $row['stock_id'] );
			$sp->set( 'sales_type_id', "1" );	//Retail]
			$sp->set( 'curr_abrev', "CAD" );
			$price_array = $sp->get_stock_price();
			$sc->set( 'category_id', $row['category'] );
			$cat = $sc->get_category_name();
			$qoh = get_qoh_on_date( $row['stock_id'] );
			$this->write_sku_catalogs_line( "",	//Token
				$row['description'],
				$row['long_description'],
				$cat['description'],	//Category
				$row['stock_id'],
				'Regular', //Variation Name
				$price_array['price'],
				'Y', 
				$qoh,	//current
				$qoh,	//new
				'Y', //Stock Alert Enabled Fraser Highland Shoppe
				'1', //Stock Alert Count Fraser Highland Shoppe
				'', //Price Fraser Highland Shoppe
				'N', //Enabled DEVEL
				'', //$row[''],Current Quantity DEVEL 
				'', //$row[''],New Quantity DEVEL 
				'', //$row[''],Stock Alert Enabled DEVEL 
				'', //$row[''],Stock Alert Count DEVEL 
				'', //$row[''],Price DEVEL 
				'Y' //Tax - GST (5%)
			);
 */
		while( $row = db_fetch( $result ) )
		{
			$price = number_format( $row['price'], 2, ".", "" ); 
			if( $price < 10000 )
			{
				$this->write_file->write_array_to_csv( array( "",	//Token
					html_entity_decode ( $row['description'] ),
					html_entity_decode ( $row['long_description'] ),
					html_entity_decode ( $row['category'] ),	//Category
					$row['stock_id'],
					'Regular', 		//Variation Name
					$price,
					'Y', 
					$row['instock'],	//current
					$row['instock'],	//new
					'Y', //Stock Alert Enabled Fraser Highland Shoppe
					$row['lowstock'], //'1', //Stock Alert Count Fraser Highland Shoppe
					'', //Price Fraser Highland Shoppe
					'N', //Enabled DEVEL
					'', //$row[''],Current Quantity DEVEL 
					'', //$row[''],New Quantity DEVEL 
					'', //$row[''],Stock Alert Enabled DEVEL 
					'', //$row[''],Stock Alert Count DEVEL 
					'', //$row[''],Price DEVEL 
					'Y' //Tax - GST (5%) 
					)
				);
				$rowcount++;
			}
		}
		$this->write_file->close();
		if( $rowcount > 0 )
			$this->email_file( "Square Catalog" );
		return $rowcount++;
	}
}

?>

