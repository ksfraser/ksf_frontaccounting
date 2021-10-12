<?php

/*
*
*	This class is designed to work with Quickform2 as a datasource
*
*/

/***************************************
*
*	This class takes a response from Google and formats it as an array:
		array(1) {
			  [0]=>
			  array(15) {
			    ["Title"]=>
			    string(26) "The Lost Fleet: Victorious"
			    ["publisher"]=>
			    string(7) "Penguin"
			    ["releasedate"]=>
			    string(4) "2010"
			    ["TitleLong"]=>
			    string(26) "The Lost Fleet: Victorious"
			    ["comments"]=>
			    string(26) "The Lost Fleet: Victorious"
			    ["summary"]=>
			    string(210) "When he leads his fleet back into Syndic space to convince the Syndics, who have suffered tremendous losses, to surrender, Captain Jon "Black Jack" Geary is confronted by an even greater alien threat. Original."
			    ["Notes"]=>
			    string(220) "When he leads his fleet back into Syndic space to convince the Syndics, who have suffered tremendous losses, to surrender, Captain Jon &quot;Black Jack&quot; Geary is confronted by an even greater alien threat. Original."
			    ["url"]=>
			    string(86) "http://books.google.com/books?id=p8OLDQAAQBAJ&dq=isbn:9780441018697&hl=&source=gbs_api"
			    ["isbn13"]=>
			    string(13) "9780441018697"
			    ["isbn"]=>
			    NULL
			    ["upc"]=>
			    string(13) "9780441018697"
			    ["pages"]=>
			    int(331)
			    ["Media"]=>
			    string(4) "BOOK"
			    ["thumbnail"]=>
			    string(111) "http://books.google.com/books/content?id=p8OLDQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api"
			    ["coverimage"]=>
			    string(111) "http://books.google.com/books/content?id=p8OLDQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api"
			  }
			}
******************************************/

/*
array(3) {
  ["kind"]=>
  string(13) "books#volumes"
  ["totalItems"]=>
  int(1)
  ["items"]=>
  array(1) {
    [0]=>
    array(8) {
      ["kind"]=>
      string(12) "books#volume"
      ["id"]=>
      string(12) "p8OLDQAAQBAJ"
      ["etag"]=>
      string(11) "bVbb9e2MXdM"
      ["selfLink"]=>
      string(56) "https://www.googleapis.com/books/v1/volumes/p8OLDQAAQBAJ"
      ["volumeInfo"]=>
      array(20) {
        ["title"]=>
        string(26) "The Lost Fleet: Victorious"
        ["publisher"]=>
        string(7) "Penguin"
        ["publishedDate"]=>
        string(4) "2010"
        ["description"]=>
        string(210) "When he leads his fleet back into Syndic space to convince the Syndics, who have suffered tremendous losses, to surrender, Captain Jon "Black Jack" Geary is confronted by an even greater alien threat. Original."
        ["industryIdentifiers"]=>
        array(2) {
          [0]=>
          array(2) {
            ["type"]=>
            string(7) "ISBN_13"
            ["identifier"]=>
            string(13) "9780441018697"
          }
          [1]=>
          array(2) {
            ["type"]=>
            string(7) "ISBN_10"
            ["identifier"]=>
            string(10) "0441018696"
          }
        }
        ["readingModes"]=>
        array(2) {
          ["text"]=>
          bool(false)
          ["image"]=>
          bool(false)
        }
        ["pageCount"]=>
        int(331)
        ["printType"]=>
        string(4) "BOOK"
        ["categories"]=>
        array(1) {
          [0]=>
          string(7) "Fiction"
        }
        ["averageRating"]=>
        int(4)
        ["ratingsCount"]=>
        int(14)
        ["maturityRating"]=>
        string(10) "NOT_MATURE"
        ["allowAnonLogging"]=>
        bool(false)
        ["contentVersion"]=>
        string(17) "0.1.0.0.preview.0"
        ["panelizationSummary"]=>
        array(2) {
          ["containsEpubBubbles"]=>
          bool(false)
          ["containsImageBubbles"]=>
          bool(false)
        }
        ["imageLinks"]=>
        array(2) {
          ["smallThumbnail"]=>
          string(111) "http://books.google.com/books/content?id=p8OLDQAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api"
          ["thumbnail"]=>
          string(111) "http://books.google.com/books/content?id=p8OLDQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api"
        }
        ["language"]=>
        string(2) "en"
        ["previewLink"]=>
        string(111) "http://books.google.com/books?id=p8OLDQAAQBAJ&printsec=frontcover&dq=isbn:9780441018697&hl=&cd=1&source=gbs_api"
        ["infoLink"]=>
        string(86) "http://books.google.com/books?id=p8OLDQAAQBAJ&dq=isbn:9780441018697&hl=&source=gbs_api"
        ["canonicalVolumeLink"]=>
        string(87) "https://books.google.com/books/about/The_Lost_Fleet_Victorious.html?hl=&id=p8OLDQAAQBAJ"
      }
      ["saleInfo"]=>
      array(3) {
        ["country"]=>
        string(2) "US"
        ["saleability"]=>
        string(12) "NOT_FOR_SALE"
        ["isEbook"]=>
        bool(false)
      }
      ["accessInfo"]=>
      array(10) {
        ["country"]=>
        string(2) "US"
        ["viewability"]=>
        string(7) "PARTIAL"
        ["embeddable"]=>
        bool(true)
        ["publicDomain"]=>
        bool(false)
        ["textToSpeechPermission"]=>
        string(25) "ALLOWED_FOR_ACCESSIBILITY"
        ["epub"]=>
        array(1) {
          ["isAvailable"]=>
          bool(false)
        }
        ["pdf"]=>
        array(1) {
          ["isAvailable"]=>
          bool(false)
        }
        ["webReaderLink"]=>
        string(90) "http://play.google.com/books/reader?id=p8OLDQAAQBAJ&hl=&printsec=frontcover&source=gbs_api"
        ["accessViewStatus"]=>
        string(6) "SAMPLE"
        ["quoteSharingAllowed"]=>
        bool(false)
      }
      ["searchInfo"]=>
      array(1) {
        ["textSnippet"]=>
        string(220) "When he leads his fleet back into Syndic space to convince the Syndics, who have suffered tremendous losses, to surrender, Captain Jon &quot;Black Jack&quot; Geary is confronted by an even greater alien threat. Original."
      }
    }
  }
}

*/
//https://www.googleapis.com/books/v1/volumes/zyTCAlFPjgYC?key=yourAPIKey  for getting a specific volume (zy...)


/**
 * Interface for data sources used by HTML_QuickForm2 objects
 * 	20200805 this might no longer be true....
 */
require_once( dirname( __FILE__ ) . '/../class.origin.php' );

/*

require_once( '../class.origin.php' );
require_once( '../ksf_settings/class.ksf_settings.php' );
require_once( '../ksf_settings/class.ksf_ini.php' );
require_once( '../Log/class.Log.php' );

global $ini;
$ini = new ksf_ini();
$settings = new ksf_settings();
$l = new Log();

$ini->register_with_eventloop();
$settings->register_with_eventloop();
//$l->register_with_eventloop();

$ini->read_ini( null, "../../google.ini" );

var_dump( $_SESSION );

require_once( 'class.google_com.php' );
$isbn = new google_book( $argv[1] );
var_dump( $isbn->run() );

*/

class data_Google extends origin
{
	protected $upc;
	protected $values;
	public $conversion_array;
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
		$this->conversion_array = array();
		$this->conversion_array['etag'] = "etag";
		$this->conversion_array['id'] = "id";
		$this->conversion_array['author'] = "author";
		$this->conversion_array['Title'] = "title";
		$this->conversion_array['publisher'] = "publisher";
		$this->conversion_array['year'] = "";
		$this->conversion_array['releasedate'] = "publishedDate";
		$this->conversion_array['keywords'] = "categories";
		$this->conversion_array['comments'] = "snippet";
		$this->conversion_array['Summary'] = "description";
		$this->conversion_array['chaptersURL'] = "";
		$this->conversion_array['azDetailPageURL'] = "";
		$this->conversion_array['isbn13'] = "ISBN_13";
		$this->conversion_array['isbn'] = "ISBN_10";
		$this->conversion_array['upc'] = "";
		$this->conversion_array['pages'] = "pagecount";
		$this->conversion_array['numberofdisks'] = "";
		$this->conversion_array['Length'] = "";
		$this->conversion_array['Media'] = "printType";
		$this->conversion_array['format'] = "";
		$this->conversion_array['image'] = "";
		$this->conversion_array['Image'] = "";
		$this->conversion_array['coverimage'] = "thumbnail";
		$this->conversion_array['imdbnumber'] = "";
		$this->conversion_array['ASIN'] = "";
		$this->conversion_array['GoogleDetailspage'] = "";
		$this->conversion_array['Coverimage'] = "";
		$this->conversion_array['fields_set'] = "";
		//averagerating, language
		return;
	}
	/***********************************************//**
	 * The interestedin array is used by eventloop to notify us of events
	 *
	 * @param none
	 * @return null
	 * ************************************************/
	function build_interestedin()
	{
		//SEEK_ISBN is looked after by google_book
		//SEEK_UPC is looked after by google_book
		//$this->interestedin["SEEK_UPC"]['function'] = "seek_upc";
		$this->interestedin["NOTIFY_SEARCH_REMOTE_UPC"]['function'] = "seek_upc";
		$this->interestedin["NOTIFY_SEARCH_REMOTE_ISBN"]['function'] = "seek_upc";
		$this->interestedin["NOTIFY_SEARCH_AMAZON"]['function'] = "seek_upc";
		$this->interestedin["NOTIFY_GOOGLE_BOOK_RESULTS"]['function'] = "convert_data";
		return;
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
        * @returns null
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
                        $this->set( 'upc', $data );
                        $this->getData();
		}
		return;
        }
	function __destruct()
	{
	}
	/***************************************//**
	 * Intermediate function for seek_upc on way to google_books class
	 *
	 * Google Books class also is interestedin UPC and ISBN.
	 * When this class was originally written it wasn't.  It
	 * just did the query of Google.
	 *
	 * @param none
	 * @return null
	 * *******************************************/
	function getData()
	{
		//Google Books doesn't understand anything not a book.
		/*
		if( strncmp( $this->getBarcode(), "978", 3 ) != 0 )
		{
			$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Google doesn't understand non bookland (978) UPCs:: " . $this->getBarcode(), $this );
			return FALSE;
		}
		*/
		$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
		try
		{
			$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
			/************************/
			/**SEEK_ISBN************/
			/* Could use tell... 'SEEK_ISBN', $this->upc ) as well...
			 */
			$isbn = new google_book( $this->upc );
			$results = $isbn->run();
			$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
			$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', print_r( $results, true ) );
		}
		return;
	}
	/******************************************//**
	 * Convert the xml return from Google into our own internal representation.
	 *
	 * Google data structure is such there could be multiple returns
	 * Since UPCs are supposed to be unique I am going to NOT iterate
	 * through the data and use only the first return.
	 *
	 * I suppose had the query been on author instead of UPC a list
	 * of books could have been returned.  Might be worth investigating
	 * in a future version.
	 *
	 * @param caller object of who passed the event
	 * @param data array of the data from the event
	 * @return bool Did the conversion succeed
	 * *******************************************/
	function convert_data( $caller, $data )
	{
		try {
			$this->build_conversion_array();
			$results = $data;
	                //var_dump( $results );
	                if( $results['totalItems'] == 0 )
			{
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
				$this->ObserverNotify( 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Google returned 0 rows:: " . $results['totalItems'], $this );
	                        return FALSE;
			}
			else
			{
				$this->tell_eventloop( $this, 'NOTIFY_LOG_INFO', __FILE__ . ":" . __LINE__ . ":" .  "Google sent " . $results['totalItems'] . " rows of data", $this );
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
			}
	
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
			//Should we be iterating through Google's returns?  Or do we just take the first result?
			$count=0;
			
			$this->set( 'etag', $results['items'][$count]['etag'] , false );
			$this->set( 'id', $results['items'][$count]['id'] , false );
			$this->set( 'title', $results['items'][$count]['volumeInfo']['title'] , false );
			$this->set( 'publisher', $results['items'][$count]['volumeInfo']['publisher'] , false );
			$this->set( 'publishedDate', $results['items'][$count]['volumeInfo']['publishedDate'] , false );
			$this->set( 'description', $results['items'][$count]['volumeInfo']['description'] , false );
			foreach( $results['items'][$count]['volumeInfo']['industryIdentifiers'] as $key=>$val )
			{
				//ISBN_13 and _10	
				$this->set( $key, $val, false );
			}
			$this->set( 'pagecount', $results['items'][$count]['volumeInfo']['pageCount'] , false );
			$this->set( 'printType', $results['items'][$count]['volumeInfo']['printType'] , false );
			$this->set( 'categories', $results['items'][$count]['volumeInfo']['categories'] , false );
			$this->set( 'averagerating', $results['items'][$count]['volumeInfo']['averageRating'] , false );
			$this->set( 'thumbnail', $results['items'][$count]['volumeInfo']['imageLinks']['thumbnail'] , false );
			$this->set( 'language', $results['items'][$count]['volumeInfo']['language'] , false );
			$this->set( 'snippet', $results['items'][$count]['searchInfo']['textSnippet'] , false );

	
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', print_r( $this, true) );
			$this->values = array();
	                if( isset( $results['items'][$count]['volumeInfo']['title'] ) )
	                {
	                        $this->values[$count]['Title'] = $results['items'][$count]['volumeInfo']['title'];
	                }
	                else if( isset( $results['items'][$count]['volumeInfo']['subtitle'] ) )
	                {
	                        $this->values[$count]['Title'] = $results['items'][$count]['volumeInfo']['subtitle'];
			}
			$this->set( 'Title', $this->values[$count]['Title'] );

	                if( isset( $results['items'][$count]['volumeInfo']['authors'] ))
	                        $this->values[$count]['author'] = implode( ", ", $results['items'][$count]['volumeInfo']['authors']);
			$this->set( 'author', $this->values[$count]['author'] );

	                if( isset( $results['items'][$count]['volumeInfo']['publisher'] ))
	                        $this->values[$count]['publisher'] = $results['items'][$count]['volumeInfo']['publisher'];
			$this->set( 'publisher', $this->values[$count]['publisher'] );

	                if( isset( $results['items'][$count]['volumeInfo']['publishedDate'] ))
	                        $this->values[$count]['releasedate'] = $results['items'][$count]['volumeInfo']['publishedDate'];
			$this->set( 'releasedate', $this->values[$count]['releasedate'] );

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
			$this->set( 'TitleLong', $this->values[$count]['TitleLong'] );
			$this->set( 'comments', $this->values[$count]['comments'] );


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
	                $this->values[$count]['upc'] = $this->upc;
			if( strncasecmp( $this->upc, "978", 3 ) == 0 )
	                	$this->values[$count]['isbn'] = $this->ISBN_13;
	                //$this->values[$count]['keywords'] = $results['items'][$count]['volumeInfo'][''];
	                $this->values[$count]['pages'] = $results['items'][$count]['volumeInfo']['pageCount'];
	                $this->values[$count]['Media'] = $results['items'][$count]['volumeInfo']['printType'];
	                $this->values[$count]['thumbnail'] = $results['items'][$count]['volumeInfo']['imageLinks']['thumbnail'];
	                $this->values[$count]['coverimage'] = $results['items'][$count]['volumeInfo']['imageLinks']['thumbnail'];
	                //Genre, year,
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', "SHOULD BE A VAR_DUMP HERE!" );
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', print_r( $this->values, true ) );
			var_dump( $this->values );
			$this->tell_eventloop( $this, 'NOTIFY_DATA_FOR_COPY', $this->conversion_array );

		}
		catch( Exception $e )
		{
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', "Caught Exception: " . print_r( $e, true ) );
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
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
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
				$this->tell_eventloop( $this, 'NOTIFY_LOG_DEBUG', get_class( $this ) . "::" . __FUNCTION__ . "::" . __LINE__ );
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
