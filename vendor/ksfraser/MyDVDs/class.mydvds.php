<?php


/*********************************************************
*
*       20110114 KF
*       Mydvds program downloads a complete DVD database
*       from the net.  Search its list
*| DVD Title       | text    | YES  |     | NULL    |       |
*| Studio          | text    | YES  |     | NULL    |       |
*| Released        | text    | YES  |     | NULL    |       |
*| Status          | text    | YES  |     | NULL    |       |
*| Sound           | text    | YES  |     | NULL    |       |
*| Versions        | text    | YES  |     | NULL    |       |
*| Price           | text    | YES  |     | NULL    |       |
*| Rating          | text    | YES  |     | NULL    |       |
*| Year            | text    | YES  |     | NULL    |       |
*| Genre           | text    | YES  |     | NULL    |       |
*| Aspect          | text    | YES  |     | NULL    |       |
*| UPC             | text    | YES  |     | NULL    |       |
*| DVD ReleaseDate | text    | YES  |     | NULL    |       |
*| ID              | int(11) | NO   | PRI |         |       |
*| Timestamp
*
**********************************************************/

require_once( '../LocalStore/class.localdatagrid.php' );
class mydvds extends localdatagrid
{
	protected $DVD_Title;
	protected $Studio;  
	protected $Release;
	protected $Status;
	protected $Sound;
	protected $Versions;
	protected $Price;  
	protected $Rating;
	protected $Year; 
	protected $Genre;
	protected $Aspect;
	protected $UPC;  
	protected $DVD_ReleaseDate;
	protected $ID;            
	protected $Timestamp;
	protected $format;
	protected $media;

	function __construct()
	{
		$this->ini = "/../../mydvds.ini";
		parent::__construct();
		/*
		$this->tell_eventloop( $this, "READ_INI", dirname( __FILE__ ) . "/../../mydvds.ini" );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'dbhost' );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'dbuser' );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'dbpass' );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'dbdb' );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'dbtable' );
		 */
		$this->format = "DVD";
		$this->media = "DVD";
	}
	/*********************************************//**
	 * Build the array used by kalli_data copy_from_source
	 *
	 * kalli_data will copy each of it's fields from ours
	 * using ->get but we have to tell it our field names
	 * The generic way to do that is to pass in an array 
	 * with the equivalencies.
	 *
	 * @param none
	 * @return null
	 * ***********************************************/
	function build_conversion_array()
	{
		$this->conversion_array['etag'] = "";
		$this->conversion_array['author'] = "authors";
		$this->conversion_array['id'] = "";
		$this->conversion_array['Title'] = "DVD_Title";
		$this->conversion_array['publisher'] = "Studio";
		$this->conversion_array['year'] = "Year";
		$this->conversion_array['category'] = "Genre";
		$this->conversion_array['releasedate'] = "DVD_ReleaseDate";
		$this->conversion_array['keywords'] = "Sound";
		$this->conversion_array['comments'] = "Status";
		$this->conversion_array['Summary'] = "Release";
		$this->conversion_array['chaptersURL'] = "";
		$this->conversion_array['azDetailPageURL'] = "";
		$this->conversion_array['isbn13'] = "";
		$this->conversion_array['isbn'] = "";
		$this->conversion_array['upc'] = "UPC";
		$this->conversion_array['pages'] = "";
		$this->conversion_array['numberofdisks'] = "";
		$this->conversion_array['Length'] = "";
		$this->conversion_array['Media'] = "media";
		$this->conversion_array['format'] = "format";
		$this->conversion_array['rating'] = "Rating";
		$this->conversion_array['image'] = "";
		$this->conversion_array['Image'] = "";
		$this->conversion_array['coverimage'] = "";
		$this->conversion_array['imdbnumber'] = "";
		$this->conversion_array['ASIN'] = "";
		$this->conversion_array['GoogleDetailspage'] = "";
		$this->conversion_array['Coverimage'] = "";
		$this->conversion_array['fields_set'] = "";
		
		//averagerating, language
		return;
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
		parent::build_interestedin();
                $this->interestedin["NOTIFY_SEARCH_MYDVDS"]['function'] = "seek_UPC";	
                $this->interestedin["NOTIFY_SEARCH_MYDVD"]['function'] = "seek_UPC";	
        }
        /******************************************************//**
	 * Search for a UPC
	 *
	 * Requires the UPC class.
        *
        * @param caller
        * @param $data
        * @returns array
        ********************************************************/
	/*INHERITED function seek_UPC( $caller, $data )*/

	/**************************************************//**
	 * Query a database for data on our UPC.
	 *
	 * @param none
	 * @return null
	 * ****************************************************/
	/*INHERITED function run() */
	/******************************************//**
	 * Extract returned datagrid values into our variables
	 *
	 * @param datagrid object structures_datagrid from PEAR
	 * @return null
	 * *********************************************/
	function datagrid2var( $datagrid )
	{
		if( isset( $datagrid->recordSet[0]["DVD Title"] ) )
		 	$this->set( "DVD_Title", $datagrid->recordSet[0]["DVD Title"] );
		if( isset( $datagrid->recordSet[0]["Genre"] ) )
		 	$this->set( "Genre", $datagrid->recordSet[0]["Genre"] );
		if( isset( $datagrid->recordSet[0]["Released"] ) )
		 	$this->set( "Released", $datagrid->recordSet[0]["Released"] );
		if( isset( $datagrid->recordSet[0]["UPC"] ) )
		 	$this->set( "UPC", $datagrid->recordSet[0]["UPC"] );
		if( isset( $datagrid->recordSet[0]["Studio"] ) )
		 	$this->set( "Studio", $datagrid->recordSet[0]["Studio"] );
		if( isset( $datagrid->recordSet[0]["Rating"] ) )
		 	$this->set( "Rating", $datagrid->recordSet[0]["Rating"] );
		if( isset( $datagrid->recordSet[0]["DVD Releasedate"] ) )
		 	$this->set( "DVD_ReleaseDate", $datagrid->recordSet[0]["DVD ReleaseDate"] );
		if( isset( $datagrid->recordSet[0]["Studio"] ) )
		 	$this->set( "Studio", $datagrid->recordSet[0]["Studio"] );
		if( isset( $datagrid->recordSet[0]["Rating"] ) )
		 	$this->set( "Rating", $datagrid->recordSet[0]["Rating"] );
		if( isset( $datagrid->recordSet[0]["Year"] ) )
		 	$this->set( "Year", $datagrid->recordSet[0]["Year"] );
		if( isset( $datagrid->recordSet[0]["Genre"] ) )
		 	$this->set( "Genre", $datagrid->recordSet[0]["Genre"] );
		if( isset( $datagrid->recordSet[0]["Aspect"] ) )
		 	$this->set( "Aspect", $datagrid->recordSet[0]["Aspect"] );
		if( isset( $datagrid->recordSet[0]["Timestamp"] ) )
			$this->set( "Timestamp", $datagrid->recordSet[0]["Timestamp"] );
		$this->tell_eventloop( $this, "NOTIFY_LOG_DEBUG", "Set a bunch of records" );
		return;
	}
}


?> 
