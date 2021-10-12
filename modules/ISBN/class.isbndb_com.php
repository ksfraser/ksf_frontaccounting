<?php

 $baseurl = 'https://api2.isbndb.com/';  
 $endpoint = 'book';
 $isbn = '9780441018697';
 $queryval = $isbn;

require_once( '../class.origin.php' );

class isbndb_com extends origin {
	protected $baseurl;
	protected $endpoint;
	protected $queryval;
	protected $key;
	protected $header;
	protected $curl;
	protected $response_raw;
	protected $response_decoded;
	protected $url;

	function __construct( $baseurl, $endpoint, $queryval, $key )
	{
		$this->set( 'baseurl', $baseurl );
		$this->set( 'endpoint', $endpoint );
		$this->set( 'queryval', $queryval );
		$this->set( 'key', $key );
		$this->tell_eventloop( $this, "READ_INI", dirname( __FILE__ ) . "/../../isbndb_com.ini" );
	}
	function __destruct()
	{
		if( isset( $this->curl ) )
			curl_close( $this->curl );
	}
	function set_header()
	{
 		$this->header = array(  "Content-Type: application/json",  "Authorization: " . $this->key  );  
	}
	function build_url()
	{
		$this->url = $this->baseurl . '/' . $this->endpoint . '/' . $this->queryval; //'https://api2.isbndb.com/book/9780134093413';
	}
	function init_curl()
	{
		$this->curl = curl_init();
 		curl_setopt($this->curl,CURLOPT_URL,$this->url);  
 		curl_setopt($this->curl,CURLOPT_HTTPHEADER,$this->header);  
 		curl_setopt($this->curl,CURLOPT_RETURNTRANSFER, true);  
	}
	function curl_query()
	{
		$this->response_raw = curl_exec( $this->curl );
	}
	function decode_json()
	{
		if( isset( $this->response_raw ) )
		{
			$this->response_decoded = json_decode( $this->response_raw, true );
			return TRUE;
		}
		else
			return FALSE;
	}
   	/***************************************************************//**
         *build_interestedin
         *
         *      DEMO function that needs to be overridden
         *      This function builds the table of events that we
         *      want to react to and what handlers we are passing the
         *      data to so we can react.
         * ******************************************************************/
        function build_interestedin()
        {
                //This NEEDS to be overridden
                $this->interestedin[KSF_DUMMY_EVENT]['function'] = "dummy";
        //      throw new Exception( "You MUST override this function, even if it is empty!", KSF_FCN_NOT_OVERRIDDEN );
        }
	function dummy( $v, $y )
	{
	}

	function run()
	{
		$this->build_url();
		$this->set_header();
		$this->init_curl();
		$this->curl_query();
		if( $this->decode_json() )
			return $this->response_decoded;
		else
			return NULL;
	}
}


/*
 $url = $baseurl . '/' . $endpoint . '/' . $queryval; //'https://api2.isbndb.com/book/9780134093413';  
 $restKey = 'YOUR_REST_KEY';  
 
 $headers = array(  
   "Content-Type: application/json",  
   "Authorization: " . $restKey  
 );  
 
 $rest = curl_init();  
 curl_setopt($rest,CURLOPT_URL,$url);  
 curl_setopt($rest,CURLOPT_HTTPHEADER,$headers);  
 curl_setopt($rest,CURLOPT_RETURNTRANSFER, true);  
 
 $response = curl_exec($rest);  
 
 echo $response;  
 print_r($response);  
 curl_close($rest);
*/

$key = "HZEAG6KT";
$isbndb = new isbndb_com( $baseurl, $endpoint, $queryval, $key );
$decoded = $isbndb->run();

class isbndb_book extends isbndb_com
{
	var $description;	//!< string
	var $title;		//!< string
	var $title_long;	//!< string
	var $isbn;		//!< string
	var $isbn13;		//!< string
	var $dewey_decimal;	//!< string
	var $binding;		//!< string
	var $publisher;		//!< string
	var $language;		//!< string
	var $date_published;	//!< date-time
	var $edition;		//!< string
	var $pages;		//!< integer
	var $dimensions;	//!< string
	var $overview;		//!< string
	var $image;		//!< image link
	var $msrp;		//!< number
	var $excerpt;		//!< string
	var $synopsys;		//!< string
	var $authors;		//!< structure
	var $subjects;		//!< structure
	var $reviews;		//!< structure
	var $prices;		//!< structure
	function __construct( $upc )
	{
		echo __METHOD__ . "\n\r";
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'isbndb_url' );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'isbndb_key' );
		parent::__construct( $this->baseurl, 'book', $upc, $this->key );
	}
	function isbndb_url( $val )
	{
		echo __METHOD__ . "\n\r";
		$this->set( 'baseurl', $val );
	}
	function isbndb_key( $val )
	{
		echo __METHOD__ . "\n\r";
		$this->set( 'key', $val );
	}
	function run()
	{
		echo __METHOD__ . "\n\r";
		$data = parent::run();
		var_dump( $data );
		foreach( $data as $key=>$val )
		{
			$this->set( $key, $val, true );
		}
		if( strlen( $this->title_long ) > 2 )
		{
			$this->tell_eventloop( $this, 'NOTIFY_BOOK_FOUND', $data );
		}
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
		echo __METHOD__ . "\n\r";
                //This NEEDS to be overridden
                $this->interestedin["SEEK_UPC"]['function'] = "seek_upc";
        //      throw new Exception( "You MUST override this function, even if it is empty!", KSF_FCN_NOT_OVERRIDDEN );
        }
	/******************************************************//**
	* Search for a UPC
	*
	* Handle the following:
	* data = UPC
	* data = array( 'upc/isbn/label' => UPC )
	* data = array( UPC, UPC, UPC, ...)
	* data = array( array( 'label' => UPC ), array...)
	* WON'T Handle array( UPC, array()... )
	*
	* NOTIFY_BOOK_FOUND on each entry
	*
	* @param caller
	* @param $data
	* @returns none
	********************************************************/
	function seek_upc( $caller, $data )
	{
		echo __METHOD__ . "\n\r";
		if( is_array( $data ) )
		{
			if( is_array( $data[0] ) )
			{
				foreach( $data as $row )
				{
					$this->seek_upc( $this, $row );
				}
			}
		}
		else
		{
			//assuming single UPC
			$this->set( 'queryval', $data );
			$this->run();
		}
	}

}
		
