<?
include_once( 'extract_start_end.php' );

class getImage extends generictable
{
	var $ch; //curl handler
	var $URL;
	var $curl_status;
	var $curl_data;
	var $fp;
        var $baseurl;
	var $upc;
	function __construct()
	{
		$controller->ObserverRegister( $this, 'NOTIFY_UPC_SET', 1 );
	}
	function get_file_contents()
	{
		$this->ch = curl_init( $this->URL );
		curl_setopt($this->ch, CURLOPT_FILE, $this->fp);
		curl_setopt($this->ch, CURLOPT_HEADER, 0);
        	$this->curl_data = curl_exec($this->ch);
		$this->curl_status = curl_getinfo($this->ch); //Status codes, etc
        	curl_close($this->ch);
	}
        function notified( $obj, $event, $msg )
        {
                if( $event == "NOTIFY_UPC_SET" )
                {
                        $this->upc = $obj->upc;
			$this->URL = 'http://www.chapters.indigo.ca/home/search/?pageSize=12&keywords=' . $this->upc;
                }
        }
	function linkNotAvailable()
	{
		link( "images/NotAvailable.jpg", "images/" . $this->upc . ".jpg" );
	}
	function initFP()
	{
		$this->fp = fopen( "images/" . $this->upc . ".jpg", "wb" );
	}
}



function downloadImage( $upc )
{
//class="searchResultProductImage" src="http://dynamic.images.indigo.ca/music/720642480625.jpg?lang=en&amp;width=180&amp;quality=85"
        $imgarraylong = extract_start_end( $data, 'searchResultProductImage"', '</a>' ); //This is an array.  In pos 0 should be the jpg of the cover
        $imgarray = extract_start_end( $imgarraylong[0], 'src="', ' ' ); //This is an array.  In pos 0 should be the jpg of the cover
	getImage( $upc, $imgarray[0] );
}


?>
