<?php

/***************************************//*
* Example from google on github 
* https://github.com/googleapis/google-api-php-client
*
********************************************

// include your composer dependencies
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName("Client_Library_Examples");
$client->setDeveloperKey("YOUR_APP_KEY");

$service = new Google_Service_Books($client);
$optParams = array('filter' => 'free-ebooks');
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

foreach ($results->getItems() as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}

********************************************/
/**My code...
*/

session_start();

global $eventloop;

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

//require_once( 'class.isbndb_com.php' );
//$isbn = new isbndb_book( $argv[1] );
//var_dump( $isbn->run() );

class googlebook extends origin
{
	protected $client;
	protected $service;
	protected $result;
	protected $google_app_name;
	protected $google_api_key;
	function __construct()
	{
		$this->tell_eventloop( $this, "SETTINGS_QUERY", "google_api_key" );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", "google_app_name" );
		$this->client = new Google_Client();
		$this->client->setApplicationName( $this->google_app_name );
		$this->client->setDeveloperKey( $this->google_api_key );
		$this->service = new Google_Service_Books( $this->client );
	}
	function run( array $optParams, string $author )
	{
		/*
			$optParams = array(
			  'filter' => 'free-ebooks',
			  'q' => 'Henry David Thoreau'
			);
		*/
		$this->result = $this->service->volumes->listVolumes( $optParams);

		foreach ($this->results->getItems() as $item) {
		  echo $item['volumeInfo']['title'], "<br /> \n";
		}
	}
	

}


