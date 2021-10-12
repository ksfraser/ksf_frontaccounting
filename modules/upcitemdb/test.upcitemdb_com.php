<?php

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

$ini->read_ini( null, "../../upcitemdb.ini" );

var_dump( $_SESSION );

require_once( 'class.upcitemdb.php' );
$search = new search_upcitemdb();
$search->register_with_eventloop();
$isbn = new upcitemdb( $argv[1] );
	//$isbn->build_interestedin();
$isbn->register_with_eventloop();
var_dump( $isbn->tell_eventloop( $isbn, 'SEEK_UPC', $argv[1] ) );
//var_dump( $isbn->run() );

