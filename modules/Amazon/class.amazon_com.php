<?php

	//https://www.googleapis.com/books/v1/volumes?q=isbn:9780441018697&key=AIz aS yC sv Xz4TDq6ShUV_oJ4aOVlJerrvP6lZkI
 //$baseurl = 'https://www.googleapis.com'; 
 //$endpoint = '/books/v1/volumes';
 //$endpoint = '/books/v1/volumes?key=AIzaSyCsvXz4T Dq 6Sh UV_oJ4aOVlJerrvP6lZkI&q=isbn:';
 //$isbn = '9780441018697';
 //$queryval = $isbn;

require_once( '../class.origin.php' );

require('../../vendor/autoload.php');

use MarcL\AmazonAPI;
use MarcL\AmazonUrlBuilder;



class amazon_rest extends origin {
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
	}
	function __destruct()
	{
		if( isset( $this->curl ) )
			curl_close( $this->curl );
	}
	function set_header()
	{
 		$this->header = array();  
	}
	function build_url()
	{
		$this->url = $this->baseurl . '/' . $this->endpoint . '/' . $this->queryval; 
		$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', 'URL ' . $this->url );
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
         *      This function builds the table of events that we
         *      want to react to and what handlers we are passing the
         *      data to so we can react.
         * ******************************************************************/
        function build_interestedin()
        {
        }
	function run()
	{
		$this->build_url();
		$this->set_header();//Google vice isbn
		$this->init_curl();
		$this->curl_query();
		if( $this->decode_json() )
			return $this->response_decoded;
		else
			return $this->response_raw;
			//return NULL;
	}
}


class amazon_book extends amazon_rest
{
	protected $google_baseurl;
	protected $google_endpoint;
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
		//Set defaults in case we don't have the SETTINGs/INI plugins.
 		$this->google_baseurl = 'https://www.googleapis.com'; 
 		$this->google_endpoint = '/books/v1/volumes';
		$this->key = "";
		
		$this->tell_eventloop( $this, "READ_INI", dirname( __FILE__ ) . "/../../google.ini" );	//Google vice isbn
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'google_api_key' );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'google_baseurl' );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", 'google_endpoint' );
		parent::__construct( $this->google_baseurl, $this->google_endpoint, $upc, $this->key );
	}
	/*****************************************************//**
	* SETTINGS_QUERY handler checks for fcn to set value based upon query
	*
	* @param val the Returned setting value
	* @return NONE
	********************************************************/
	function google_api_key( $val )
	{
		$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', 'Setting Google Api Key to ' . $val );
		$this->set( 'key', $val );
	}
	/*****************************************************//**
	* SETTINGS_QUERY handler checks for fcn to set value based upon query
	*
	* @param val the Returned setting value
	* @return NONE
	********************************************************/
	function google_baseurl( $val )
	{
		$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', 'Setting Google Base URL to ' . $val );
		$this->set( 'google_baseurl', $val );
	}
	/*****************************************************//**
	* SETTINGS_QUERY handler checks for fcn to set value based upon query
	*
	* @param val the Returned setting value
	* @return NONE
	********************************************************/
	function google_endpoint( $val )
	{
		$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', 'Setting Google End Point to ' . $val );
		$this->set( 'google_endpoint', $val );
	}
	function build_url()
	{
		$this->url = $this->baseurl . '/' . $this->endpoint . '?' . 'key=' . $this->key . '&q=isbn:' . $this->queryval; 
		$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', 'URL ' . $this->url );
	}
	function run()
	{
		$data = parent::run();
		//var_dump( $data );
		/*
		foreach( $data as $key=>$val )
		{
			$this->set( $key, $val, true );
		}
		if( strlen( $this->title_long ) > 2 )
		{
			$this->tell_eventloop( $this, 'NOTIFY_BOOK_FOUND', $data );
		}
		*/
		return $data;
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
                $this->interestedin["SEEK_ISBN"]['function'] = "seek_ISBN";
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
	function seek_ISBN( $caller, $data )
	{
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
			$data = $this->run();
			if( count( $data ) > 1 )
				$this->tell_eventloop( $this, 'NOTIFY_GOOGLE_BOOK_RESULTS', $data );
			return $data;
		}
	}

}
		
