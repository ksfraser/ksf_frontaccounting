<?php

/*
*
*	This class is designed to work with Quickform2 as a datasource
*
*/

//https://www.googleapis.com/books/v1/volumes/zyTCAlFPjgYC?key=yourAPIKey  for getting a specific volume (zy...)


require_once( dirname( __FILE__ ) . '/class.Google.php' );

//$g = new googlebooks( "9781451638905" ); //star trader
//$g = new googlebooks( "9781439133446" ); //star trader
//$g = new googlebooks( "628261224722" ); //celtic music CD
$g = new search_google( "883904321095" ); //covert affairs
var_dump( $g->Google2details() );
var_dump( $g );
