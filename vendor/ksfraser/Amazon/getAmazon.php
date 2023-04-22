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
require_once 'HTML/QuickForm2/DataSource.php';
require_once( 'getImage.php' );

require('../../vendor/autoload.php');

use MarcL\AmazonAPI;
use MarcL\AmazonUrlBuilder;
//require_once( 'data/AmazonProductAPI/AmazonProductAPI.php' );
//spl_autoload_register(array('AmazonProductAPI', 'autoload'));

class Amazon implements HTML_QuickForm2_DataSource
{
	var $url;
	var $barcode;
	var $accesskey;
	var $fp;
	var $values;
	var $api;
	var $IdType;
	var $request;
	var $response;
	function __construct ( $barcode, $access_key, $awssecret, $awsassoc )
	{

		$api = new AmazonProductAPI();
		$api->setAccessKey( $access_key );
		$api->setSecretKey( $awssecret );
		$api->setAssociateId( $awsassoc );
		$this->api = $api;


		$this->setBarcode( $barcode );
		$this->setAccessKey( $access_key );
		$this->setURL();
	
		$this->connect();
		$this->getData();
		$this->disconnect();
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
		$request = new AmazonProduct_Request();
		$request->Operation = AmazonProduct_Operation::ITEM_LOOKUP;
		$request->SearchIndex="Books";
		$request->IdType = $this->IdType;
		//$request->ResponseGroup = "MEDIUM," . AmazonProduct_ResponseGroup::IMAGES;
		$request->ResponseGroup = AmazonProduct_ResponseGroup::LARGE;
		$request->ItemId = $this->getBarcode();
		$this->request = $request;
	}
	function disconnect()
	{
		//fclose( $this->fp );
	}
	function getData()
	{

		// Send Request
		$bookarray = array();
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
		        $details['Title'] = $this->values[0]['Title'];
		if( isset( $this->values[0]['author'] ))
		        $details['author'] = $this->values[0]['author'];
		if( isset( $this->values[0]['publisher'] ))
		        $details['publisher'] = $this->values[0]['publisher'];
		if( isset( $this->values[0]['releasedate'] ))
		        $details['year'] = $this->values[0]['releasedate'];
		if( isset( $this->values[0]['releasedate'] ))
		        $details['releasedate'] = $this->values[0]['releasedate'];
		if( isset( $this->values[0]['TitleLong'] ))
		        $details['keywords'] = $this->values[0]['TitleLong'];
		if( isset( $this->values[0]['comments'] ))
		        $details['comments'] = $this->values[0]['comments'];
		if( isset( $this->values[0]['summary'] ))
		        $details['Summary'] = $this->values[0]['summary'];
		if( isset( $this->values[0]['Notes'] ))
		        $details['comments'] .= $this->values[0]['Notes'];
		//if( isset( $this->values[0]['url'] ))
		        //$details['chaptersURL'] = $this->values[0]['url'];
		if( isset( $this->values[0]['ASIN'] ))
		        $details[''] = $this->values[0]['ASIN'];
		if( isset( $this->values[0]['azDetailPageURL'] ))
		        $details['azDetailPageURL'] = $this->values[0]['azDetailPageURL'];
		if( isset( $this->values[0]['isbn13'] ))
		        $details['isbn13'] = $this->values[0]['isbn13'];
		if( isset( $this->values[0]['isbn'] ))
		        $details['isbn'] = $this->values[0]['isbn'];
		if( isset( $this->values[0]['upc'] ))
		        $details['upc'] = $this->values[0]['upc'];
		if( isset( $this->values[0]['keywords'] ))
		        $details['keywords'] .= "::" . $this->values[0]['keywords'];
		if( isset( $this->values[0]['pages'] ))
		{
		        $details['pages'] = $this->values[0]['pages'];
		}
		if( isset( $this->values[0]['numberofdisks'] ))
		{
		        $details['numberofdisks'] = $this->values[0]['numberofdisks'];
		}
		if( isset( $this->values[0]['Length'] ))
		{
		        $details['Length'] = $this->values[0]['Length'];
		}
		if( isset( $this->values[0]['Media'] ))
		        $details['Media'] = $this->values[0]['Media'];
		if( isset( $this->values[0]['Media'] ))
		        $details['format'] = $this->values[0]['Media'];
		if( isset( $this->values[0]['thumbnail'] ))
		{
		        $details['Image'] = $this->values[0]['thumbnail'];
		        $details['image'] = $this->values[0]['thumbnail'];
		        $details['coverimage'] = $this->values[0]['thumbnail'];
			getImage( $this->getBarcode(), $this->values[0]['thumbnail'] );
		}
	                $details['imdbnumber'] = "";
	                //$details['ASIN'] = "";
	                //$details['Amazon Details page'] = "";
	                //$details['Cover Image'] = "";
		return $details;
	}
}

//$g = new googlebooks( "9781451638905" ); //star trader
//$g = new googlebooks( "9781439133446" ); //star trader
//$g = new googlebooks( "628261224722" ); //celtic music CD
$g = new Amazon( "786936831993" ); //covert affairs
//var_dump( $g->Amazon2details() );
var_dump( $g );
