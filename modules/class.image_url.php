<?php

require_once( 'class.file_download.php' );
class image_url extends file_download 
{
	protected $imageurl;
	function __construct( $imageurl = "" ) 
	{ 
                parent::__construct();
		$this->imageurl = $imageurl;
		if( strlen( $imageurl ) > 5 )
	 		$this->download_url( $this, $imageurl );
		else
	 		$this->download_url( $this, "" );
                $this->set( 'endpoint',  '' );
                $this->set( 'key', "" );
		$this->set( 'queryval', "" );
	}
	function build_interestedin()
	{
		//We don't want to reset our filename etc.
	}
}

