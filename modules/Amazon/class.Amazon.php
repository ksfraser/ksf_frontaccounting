<?php

/*
*
*	This class is designed to work with Quickform2 as a datasource
*
*/

//https://www.googleapis.com/books/v1/volumes/zyTCAlFPjgYC?key=yourAPIKey  for getting a specific volume (zy...)


/**
 * Interface for data sources used by HTML_QuickForm2 objects
 */

//require_once( dirname( __FILE__ ) . '/../../AmazonProductAPI/AmazonProductAPI.php' );
//spl_autoload_register(array('AmazonProductAPI', 'autoload'));
require('vendor/autoload.php');

use MarcL\AmazonAPI;
use MarcL\AmazonUrlBuilder;

require_once( dirname( __FILE__ ) . '/../../class.base.php' );

class search_Amazon extends base
{
	var $url;
	var $barcode;
	var $accesskey;
	var $awssecret;
	var $awsassoc;
	var $fp;
	var $values;
	var $api;
	var $IdType;
	var $request;
	var $response;
	var $connected;
	var $details;
	function __construct ( $dispatcher, $access_key, $awssecret, $awsassoc )
	{
		parent::__construct( $dispatcher );
		$this->ObserverRegister( $this, "NOTIFY_SEARCH_REMOTE_UPC", 1 );
		$this->ObserverRegister( $this, "NOTIFY_SEARCH_AMAZON", 1 );
		$api = new AmazonProductAPI();
		$api->setAccessKey( $access_key );
		$api->setSecretKey( $awssecret );
		$api->setAssociateId( $awsassoc );
		$this->api = $api;
		$this->connected = 0;


		$this->setAccessKey( $access_key );
		$this->setURL();
		$this->details = array();
	
	}
	function __destruct()
	{
		$this->disconnect();
	}
        function notified( $obj, $event, $msg )
        {
                if( $event == "NOTIFY_SEARCH_AMAZON" )
                {
	                if( isset( $obj->UPC ) )
	                        $this->setBarcode( $obj->UPC );
	                else if( isset( $msg->UPC ) )
	                        $this->setBarcode( $msg->UPC );
			if( isset( $this->IdType ) )
			{
				$this->getData();
				$this->Amazon2details();
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
				$this->getData();
				$this->Amazon2details();
			} 
                }
        }
	function setURL()
	{
		//$this->url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $this->getBarcode() . "&key=" . $this->getAccessKey();
		$this->url = "";
	}
	function getURL()
	{
		return $this->url;
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
	function connect()
	{
		$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Connecting to Amazon", $this );
		$request = new AmazonProduct_Request();
		$request->Operation = AmazonProduct_Operation::ITEM_LOOKUP;
		$request->SearchIndex="Books";
		$request->IdType = $this->IdType;
		//$request->ResponseGroup = "MEDIUM," . AmazonProduct_ResponseGroup::IMAGES;
		$request->ResponseGroup = AmazonProduct_ResponseGroup::LARGE;
		$request->ItemId = $this->getBarcode();
		$this->request = $request;
		$this->connected = 1;
	}
	function disconnect()
	{
		//fclose( $this->fp );
	}
	function getData()
	{
		if( !$this->connected )
		{
			$this->connect();
		}
		// Send Request
		$bookarray = array();
		$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Requesting data from Amazon", $this );
		$this->response = $this->api->execute( $this->request );
		$count = 0;
		//var_dump( $this->response->_values );
		foreach( $this->response->getIterator() as $item ) {
		       	//print_r( $item ); //returns the item
		       	//var_dump( $item->get( "ASIN" ) ); //returns the ASIN
				//ASIN
			$bookarray[$count]['ASIN'] = $item->get( "ASIN" );
				//DetailPageURL
			$bookarray[$count]['azDetailPageURL'] = $item->get( "DetailPageURL" );
				//ItemLinks - array of URL Link items
				//SalesRank
				//SmallImage
				//MediumImage
				//LargeImage
			$Large = $item->get( "LargeImage" );
			if( isset( $Large ))
			{
				$bookarray[$count]['coverimage'] = $Large->get( "URL" );
			}
				//ImageSets - ImageSet object is array of images
			$thumb = $item->get( "LargeImage" );
			if( isset( $thumb ))
			{
				$bookarray[$count]['thumbnail'] = $thumb->get( "URL" );
			}
				//ItemAttributes - array
			$attributes = $item->get( "ItemAttributes" );
			if( isset( $attributes ))
			{
				//var_dump( $attributes );
					//Actor is an array
				$actors = $attributes->get( "Actor" );
				if( !isset( $bookarray[$count]['comments'] ))
				{
					$bookarray[$count]['comments'] = "";
				}
				if( isset( $actors ) and is_array( $actors ) )
				{
					foreach( $actors as $actor )
					{
						$bookarray[$count]['comments'] = $bookarray[$count]['comments'] . $actor . ", ";
					}
				}
				$bookarray[$count]['author'] = $attributes->get( "Author" );
					//Audience-Rating
				$bookarray[$count]['mpaarating'] = $attributes->get( "AudienceRating" );
					//Binding (eg DVD
				$bookarray[$count]['Media'] = $attributes->get( "Binding" );
					//Brand (publisher
				$bookarray[$count]['publisher'] = $attributes->get( "Brand" );
				$bookarray[$count]['EAN'] = $attributes->get( "EAN" );
				$bookarray[$count]['isbn'] = $attributes->get( "ISBN" );
				//$bookarray[$count]['Title'] = $attributes->get( "Manufacturer" );
				$bookarray[$count]['numberofdisks'] = $attributes->get( "NumberOfDiscs" );
				//$bookarray[$count]['Title'] = $attributes->get( "PictureFormat" );
				$bookarray[$count]['publisher'] = $attributes->get( "Publisher" );
				$bookarray[$count]['releasedate'] = $attributes->get( "ReleaseDate" );
				$bookarray[$count]['Length'] = $attributes->get( "RunningTime" );
				//$bookarray[$count]['Title'] = $attributes->get( "Studio" );
				$bookarray[$count]['Title'] = $attributes->get( "Title" );
				$bookarray[$count]['upc'] = $attributes->get( "UPC" );
					//EditorialReviews (array)
						//Content
				//$bookarray[$count]['summary'] = $attributes->get( "Title" );
			}
			$count++;
		}
		
		//	$bookarray[$count]['author'] = implode( ", ", $results['items'][0]['volumeInfo']['authors']);
		//	$bookarray[$count]['TitleLong'] .= " - " . $results['items'][0]['volumeInfo']['subtitle'];
		//	$bookarray[$count]['comments'] = $results['items'][0]['volumeInfo']['title'] . " - " .$results['items'][0]['volumeInfo']['subtitle'];
		//$bookarray[$count]['Notes'] = $results['items'][0]['searchInfo']['textSnippet'];
		//$bookarray[$count]['keywords'] = $results['items'][0]['volumeInfo'][''];
		//$bookarray[$count]['pages'] = $results['items'][0]['volumeInfo']['pageCount'];
		//Genre, year, 
		//var_dump( $bookarray );
		$this->values = $bookarray;
		$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Amazon sent " . $count . " rows of data", $this );
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
	function Amazon2details( $details = array() )
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
		if( isset( $this->values[0]['EditorialReviews'] ))
		        $this->details['comments'] .= $this->values[0]['EditorialReviews'][0]["_values"]["Content"];
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
	                //$this->details['Amazon Details page'] = "";
	                //$this->details['Cover Image'] = "";
		$this->ObserverNotify( 'NOTIFY_DETAILS_SET', $this, $this );
		return $this->details;
	}
}

//$g = new googlebooks( "9781451638905" ); //star trader
//$g = new googlebooks( "9781439133446" ); //star trader
//$g = new googlebooks( "628261224722" ); //celtic music CD
//$g = new search_Amazon( "786936831993" ); //covert affairs
//var_dump( $g->Amazon2details() );
//var_dump( $g );
