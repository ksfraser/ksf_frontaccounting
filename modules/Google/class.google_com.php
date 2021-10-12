<?php

	//https://www.googleapis.com/books/v1/volumes?q=isbn:9780441018697&key=AIzaSyCsvXz4TDq6ShUV_oJ4aOVlJerrvP6lZkI
 //$baseurl = 'https://www.googleapis.com'; 
 //$endpoint = '/books/v1/volumes';
 //$endpoint = '/books/v1/volumes?key=AIzaSyCsvXz4TDq6ShUV_oJ4aOVlJerrvP6lZkI&q=isbn:';
 //$isbn = '9780441018697';
 //$queryval = $isbn;

require_once( '../class.origin.php' );
require_once( '../class.rest_interface.php' );

//class google_rest extends origin {
class google_rest extends rest_interface {
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
		parent::__destruct();
	}
	function build_url()
	{
		$this->url = $this->baseurl . '/' . $this->endpoint . '/' . $this->queryval; 
		$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', 'URL ' . $this->url );
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


class google_book extends google_rest
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
                $this->interestedin["SEEK_UPC"]['function'] = "seek_ISBN";
        }
	/******************************************************//**
	* Search for a UPC
	*
	* @param caller
	* @param $data (UPC)
	* @returns none
	********************************************************/
	function seek_ISBN( $caller, $data )
	{

                $this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
                require_once( '../class.UPC.php' );
                $upc = new UPC();
                $ret = $upc->setUPC( $caller, $data );
                if( $ret )
                {
                        $this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', "Set UPC" );
                        $this->set( 'queryval', $upc->get( 'UPC' ) );
                        $ret = $this->run();
                        if( count( $ret ) > 1 )
                                $this->tell_eventloop( $this, 'NOTIFY_GOOGLE_BOOK_RESULTS', $ret );
                        return $ret;
                }
                else
                        return "";
	}
	function run()
	{
		$data = parent::run();
		return $data;
	}

}
		
