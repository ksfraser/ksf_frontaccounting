<?php

session_start();

global $eventloop;

require('../../vendor/autoload.php');

use MarcL\AmazonAPI;
use MarcL\AmazonUrlBuilder;

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

$ini->read_ini( null, "../../amazon.ini" );

var_dump( $_SESSION );


class stump extends origin
{
	protected $aws_access_key;
	protected $awssecret;
	protected $awsassoc;
	protected $awscountry;
	protected $urlbuilder;
	protected $amazonAPI;
	protected $upc;
	//protected $data;
	function __construct()
	{
		$this->aws_access_key = $this->awssecret = $this->awsassoc = "";
		$this->tell_eventloop( $this, "SETTINGS_QUERY", "aws_access_key" );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", "awssecret" );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", "awsassoc" );
		$this->tell_eventloop( $this, "SETTINGS_QUERY", "awscountry" );
		parent::__construct();
		// Setup a new instance of the AmazonUrlBuilder with your keys
		$this->urlBuilder = new AmazonUrlBuilder(
    			$this->aws_access_key,
    			$this->awssecret,
    			$this->awsassoc,
    			$this->awscountry );
		// Setup a new instance of the AmazonAPI and define the type of response
		$this->amazonAPI = new AmazonAPI($this->urlBuilder, 'simple');

	}
	function awssecret( $val )
	{
		$this->set( 'awssecret', $val );
	}
	function awsassoc( $val )
	{
		$this->set( 'awsassoc', $val );
	}
	function aws_access_key( $val )
	{
		$this->set( 'aws_access_key', $val );
	}
	function awscountry( $val )
	{
		$this->set( 'awscountry', $val );
	}
	function run()
	{
		//searchitem, category, default_sort
		//$items = $amazonAPI->ItemSearch( 'Harry Potter', 'Books', 'price' );
		$this->tell_eventloop( $this, "NOTIFY_LOG_DEBUG", __FUNCTION__ );
		$items = $this->amazonAPI->ItemSearch( $this->upc );
		return $items;
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
		$this->tell_eventloop( $this, "NOTIFY_LOG_DEBUG", __FUNCTION__ );
                if( is_array( $data ) )
                {
                        if( is_array( $data[0] ) )
                        {
                                foreach( $data as $row )
                                {
                                        $this->seek_ISBN( $this, $row );
                                }
                        }
                }
                else
                {
                        //assuming single UPC
                        $this->set( 'upc', $data );
                        $this->data = $this->run();
                        if( count( $this->data ) > 1 )
			{
                                $this->tell_eventloop( $this, 'NOTIFY_AMAZON_RESULTS', $this->data );
			}
                        return $this->data;
		
                }
        }

}



//require_once( 'class.amazon_com.php' );
$isbn = new stump();
$isbn->register_with_eventloop();
$isbn->tell_eventloop( $isbn, "SEEK_UPC", "Harry Potter" );
//$isbn->tell_eventloop( $isbn, "SEEK_UPC", "9780765348210" );

var_dump( $isbn->data );
