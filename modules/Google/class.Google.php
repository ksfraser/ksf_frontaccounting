<?php


//20200807 This class has been depreciated in favor of data_google and google_com



/*
*
*	This class is designed to work with Quickform2 as a datasource
*
*/

//https://www.googleapis.com/books/v1/volumes/zyTCAlFPjgYC?key=yourAPIKey  for getting a specific volume (zy...)


/**
 * Interface for data sources used by HTML_QuickForm2 objects
 */
require_once( dirname( __FILE__ ) . '/../../class.base.php' );

class search_Google extends base 
{
	var $url;
	var $barcode;
	var $accesskey;
	var $awssecret;
	var $awsassoc;
	var $fp;
	var $values = array();
	var $api;
	var $IdType;
	var $request;
	var $response;
	var $connected;
	var $details = array();
	function __construct ( $dispatcher, $barcode = "", $access_key = "AIzaSyCsvXz4TDq6ShUV_oJ4aOVlJerrvP6lZkI" )
	{
		parent::__construct( $dispatcher );
		$this->ObserverRegister( $this, "NOTIFY_SEARCH_REMOTE_UPC", 1 );
		$this->ObserverRegister( $this, "NOTIFY_SEARCH_AMAZON", 1 );
		$this->connected = 0;


		$this->details = array();
 
                $this->setBarcode( $barcode );
                $this->setAccessKey( $access_key );
                $this->setURL();

                $this->connect();
                $this->getData();
	}
	function __destruct()
	{
		$this->disconnect();
	}
        function notified( $obj, $event, $msg )
        {
                if( $event == "NOTIFY_SEARCH_GOOGLE" )
                {
	                if( isset( $obj->UPC ) )
	                        $this->setBarcode( $obj->UPC );
	                else if( isset( $msg->UPC ) )
	                        $this->setBarcode( $msg->UPC );
			if( isset( $this->IdType ) )
			{
				if( $this->getData() )
					$this->Google2details();
			} 
                }
                if( $event == "NOTIFY_SEARCH_REMOTE_UPC" )
                {
	                if( isset( $obj->UPC ) )
	                        $this->setBarcode( $obj->UPC );
	                else if( isset( $msg->UPC ) )
	                        $this->setBarcode( $msg->UPC );
			if( isset( $this->IdType ) )
			{
				if( $this->getData() )
					$this->Google2details();
			} 
                }
        }
        function setURL()
        {
                $this->url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $this->getBarcode() . "&key=" . $this->getAccessKey();
        }
        function getURL()
        {
                return $this->url;
        }
        function getBarcode()
        {
                return $this->barcode;
        }
        function setAccessKey( $accesskey )
        {
                $this->accesskey = $accesskey;
        }
        function getAccessKey()
        {
                return $this->accesskey;
        }

	function setBarcode( $barcode )
	{
		if( strlen( $barcode ) == 12 )
		{
		        //convert to EAN
        		$barcode = "0" . $barcode;
        		$this->IdType= "EAN";
		}
		else
		if( strlen( $barcode ) == 10 AND strncasecmp( $barcode, "B00", 3  ) == 0 )
		{
		        $this->IdType= "ASIN";
		}
		else
		{
        		$this->IdType= "EAN";
		}
		$this->barcode = $barcode;
	}
	function connect()
	{
		$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Connecting to Google", $this );
                if(!( $this->fp = fopen( $this->getURL(), "r" ) ) )
                {
                        //set error
			return FALSE;
                }
		$this->connected = 1;
	}
	function disconnect()
	{
		if(get_resource_type($this->fp) == 'file')
			fclose( $this->fp );
	}
	function getData()
	{
		//Google Books doesn't understand anything not a book.
		if( strncmp( $this->getBarcode(), "978", 3 ) != 0 )
		{
			$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Google doesn't understand non bookland (978) UPCs:: " . $this->getBarcode(), $this );
			return FALSE;
		}
                require_once( dirname( __FILE__ ) . '/../../Google/src/Google_Client.php' );
                require_once( dirname( __FILE__ ) . '/../../Google/src/contrib/Google_BooksService.php' );

		try
		{

                	$client = new Google_Client();
                	$client->setApplicationName("My_Books_API_Example");
                	$service = new Google_BooksService($client);

	        //      $optParams = array('filter' => 'free-ebooks');
	        //      $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
	
	               	$results = $service->volumes->listVolumes('isbn:' . $this->getBarcode() );
	                //var_dump( $results );
	                if( $results['totalItems'] == 0 )
			{
				$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Google returned 0 rows:: " . $results['totalItems'], $this );
	                        return FALSE;
			}
			else
				$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Google sent " . $results['totalItems'] . " rows of data", $this );
	
			//Should we be iterating through Google's returns?  Or do we just take the first result?
	                $count=0;
	
	                if( isset( $results['items'][$count]['volumeInfo']['title'] ) )
	                {
	                        $this->values[$count]['Title'] = $results['items'][$count]['volumeInfo']['title'];
	                }
	                else if( isset( $results['items'][$count]['volumeInfo']['subtitle'] ) )
	                {
	                        $this->values[$count]['Title'] = $results['items'][$count]['volumeInfo']['subtitle'];
	                }
	                if( isset( $results['items'][$count]['volumeInfo']['authors'] ))
	                        $this->values[$count]['author'] = implode( ", ", $results['items'][$count]['volumeInfo']['authors']);
	                if( isset( $results['items'][$count]['volumeInfo']['publisher'] ))
	                        $this->values[$count]['publisher'] = $results['items'][$count]['volumeInfo']['publisher'];
	                if( isset( $results['items'][$count]['volumeInfo']['publishedDate'] ))
	                        $this->values[$count]['releasedate'] = $results['items'][$count]['volumeInfo']['publishedDate'];
	                if( isset( $results['items'][$count]['volumeInfo']['title'] ))
	                        $this->values[$count]['TitleLong'] = $results['items'][$count]['volumeInfo']['title'];
	                if( isset( $results['items'][$count]['volumeInfo']['subtitle'] ) )
	                {
	                        $this->values[$count]['TitleLong'] .= " - " . $results['items'][$count]['volumeInfo']['subtitle'];
	                        $this->values[$count]['comments'] = $results['items'][$count]['volumeInfo']['title'] . " - " .$results['items'][$count]['volumeInfo']['subtitle'];
	                }
	                else
	                {
				if( isset( $results['items'][$count]['volumeInfo']['title'] ) )
	                        	$this->values[$count]['comments'] = $results['items'][$count]['volumeInfo']['title'];
	                }
			if( isset( $results['items'][$count]['volumeInfo']['description'] ) )
			{
	                	$this->values[$count]['summary'] = $results['items'][$count]['volumeInfo']['description'];
	                }
			if( isset( $results['items'][$count]['searchInfo']['textSnippet'] ) )
			{
	                	$this->values[$count]['Notes'] = $results['items'][$count]['searchInfo']['textSnippet'];
	                }
			if( isset( $results['items'][$count]['volumeInfo']['infoLink'] ) )
			{
	                	$this->values[$count]['url'] = $results['items'][$count]['volumeInfo']['infoLink'];
			}
	                foreach( $results['items'][$count]['volumeInfo']['industryIdentifiers'] as $isbn )
	                {
	                        if( $isbn['type'] == "ISBN_13" )
	                                $this->values[$count]['isbn13'] = $isbn['identifier'];
	                        if( $isbn['type'] == "ISBN_10" )
	                                $this->values[$count]['isbn'] = $isbn['identifier'];
	                }
	                $this->values[$count]['upc'] = $this->getBarcode();
			if( strncasecmp( $this->getBarcode(), "978", 3 ) == 0 )
	                	$this->values[$count]['isbn'] = $this->getBarcode();
	                //$this->values[$count]['keywords'] = $results['items'][$count]['volumeInfo'][''];
	                $this->values[$count]['pages'] = $results['items'][$count]['volumeInfo']['pageCount'];
	                $this->values[$count]['Media'] = $results['items'][$count]['volumeInfo']['printType'];
	                $this->values[$count]['thumbnail'] = $results['items'][$count]['volumeInfo']['imageLinks']['thumbnail'];
	                $this->values[$count]['coverimage'] = $results['items'][$count]['volumeInfo']['imageLinks']['thumbnail'];
	                //Genre, year,
			//var_dump( $this->values );
		}
		catch( Exception $e )
		{
			return FALSE;
		}
	


/***************************************************************************************
*		// Send Request
*		$this->response = $this->api->execute( $this->request );
*		$count = 0;
*		foreach( $this->response->getIterator() as $item ) {
*			$bookarray[$count]['ASIN'] = $item->get( "ASIN" );
*			$bookarray[$count]['azDetailPageURL'] = $item->get( "DetailPageURL" );
*			$Large = $item->get( "LargeImage" );
*			if( isset( $Large ))
*			{
*				$bookarray[$count]['coverimage'] = $Large->get( "URL" );
*			}
*			$thumb = $item->get( "LargeImage" );
*			if( isset( $thumb ))
*			{
*				$bookarray[$count]['thumbnail'] = $thumb->get( "URL" );
*			}
*			$attributes = $item->get( "ItemAttributes" );
*			if( isset( $attributes ))
*			{
*				$actors = $attributes->get( "Actor" );
*				if( !isset( $bookarray[$count]['comments'] ))
*				{
*					$bookarray[$count]['comments'] = "";
*				}
*				if( isset( $actors ) and is_array( $actors ) )
*				{
*					foreach( $actors as $actor )
*					{
*						$bookarray[$count]['comments'] = $bookarray[$count]['comments'] . $actor . ", ";
*					}
*				}
*				$bookarray[$count]['author'] = $attributes->get( "Author" );
*				$bookarray[$count]['mpaarating'] = $attributes->get( "AudienceRating" );
*				$bookarray[$count]['Media'] = $attributes->get( "Binding" );
*				$bookarray[$count]['publisher'] = $attributes->get( "Brand" );
*				$bookarray[$count]['EAN'] = $attributes->get( "EAN" );
*				$bookarray[$count]['isbn'] = $attributes->get( "ISBN" );
*				$bookarray[$count]['numberofdisks'] = $attributes->get( "NumberOfDiscs" );
*				$bookarray[$count]['publisher'] = $attributes->get( "Publisher" );
*				$bookarray[$count]['releasedate'] = $attributes->get( "ReleaseDate" );
*				$bookarray[$count]['Length'] = $attributes->get( "RunningTime" );
*				$bookarray[$count]['Title'] = $attributes->get( "Title" );
*				$bookarray[$count]['upc'] = $attributes->get( "UPC" );
*			}
*			$count++;
*		}
**************************************************************************************/	
		return TRUE;
	}
	public function getValue( $name )
    	{
	//Adapted from html/quickform2/datasource/array.php
    	    	if (empty($this->values)) {
    	        	return null;
    	    	}
		if( is_array( $this->values ))
		{
			foreach( $this->values as $value )
			{
				if( isset( $value[$name] ))
				{
					return $value[$name];
				}
			}
		}
    	     	elseif (isset($this->values[$name])) {
    	        	return $this->values[$name];
    	    	} else {
    	        	return null;
    	    	}
    	}
	function Google2details()
	{
		if( isset( $this->values[0]['Title'] ))
		        $this->details['Title'] = $this->values[0]['Title'];
		if( isset( $this->values[0]['author'] ))
		        $this->details['author'] = $this->values[0]['author'];
		if( isset( $this->values[0]['publisher'] ))
		        $this->details['publisher'] = $this->values[0]['publisher'];
		if( isset( $this->values[0]['releasedate'] ))
		        $this->details['year'] = $this->values[0]['releasedate'];
		if( isset( $this->values[0]['releasedate'] ))
		        $this->details['releasedate'] = $this->values[0]['releasedate'];
		if( isset( $this->values[0]['TitleLong'] ))
		        $this->details['keywords'] = $this->values[0]['TitleLong'];
		if( isset( $this->values[0]['comments'] ))
		        $this->details['comments'] = $this->values[0]['comments'];
		if( isset( $this->values[0]['summary'] ))
		        $this->details['Summary'] = $this->values[0]['summary'];
		if( isset( $this->values[0]['Notes'] ))
		        $this->details['comments'] .= $this->values[0]['Notes'];
		//if( isset( $this->values[0]['url'] ))
		        //$this->details['chaptersURL'] = $this->values[0]['url'];
		if( isset( $this->values[0]['ASIN'] ))
		        $this->details[''] = $this->values[0]['ASIN'];
		if( isset( $this->values[0]['azDetailPageURL'] ))
		        $this->details['azDetailPageURL'] = $this->values[0]['azDetailPageURL'];
		if( isset( $this->values[0]['isbn13'] ))
		        $this->details['isbn13'] = $this->values[0]['isbn13'];
		if( isset( $this->values[0]['isbn'] ))
		        $this->details['isbn'] = $this->values[0]['isbn'];
		if( isset( $this->values[0]['upc'] ))
		        $this->details['upc'] = $this->values[0]['upc'];
		if( isset( $this->values[0]['keywords'] ))
		        $this->details['keywords'] .= "::" . $this->values[0]['keywords'];
		if( isset( $this->values[0]['pages'] ))
		{
		        $this->details['pages'] = $this->values[0]['pages'];
		}
		if( isset( $this->values[0]['numberofdisks'] ))
		{
		        $this->details['numberofdisks'] = $this->values[0]['numberofdisks'];
		}
		if( isset( $this->values[0]['Length'] ))
		{
		        $this->details['Length'] = $this->values[0]['Length'];
		}
		if( isset( $this->values[0]['Media'] ))
		        $this->details['Media'] = $this->values[0]['Media'];
		if( isset( $this->values[0]['Media'] ))
		        $this->details['format'] = $this->values[0]['Media'];
		if( isset( $this->values[0]['thumbnail'] ))
		{
		        $this->details['Image'] = $this->values[0]['thumbnail'];
		        $this->details['image'] = $this->values[0]['thumbnail'];
		        $this->details['coverimage'] = $this->values[0]['thumbnail'];
			//getImage( $this->getBarcode(), $this->values[0]['thumbnail'] );
		}
	                $this->details['imdbnumber'] = "";
	                //$this->details['ASIN'] = "";
	                //$this->details['Google Details page'] = "";
	                //$this->details['Cover Image'] = "";
		$this->ObserverNotify( 'NOTIFY_DETAILS_SET', $this, $this );
		return $this->details;
	}
}

//$g = new googlebooks( "9781451638905" ); //star trader
//$g = new googlebooks( "9781439133446" ); //star trader
//$g = new googlebooks( "628261224722" ); //celtic music CD
//$g = new Google( "883904321095" ); //covert affairs
//var_dump( $g->Google2details() );
//var_dump( $g );
