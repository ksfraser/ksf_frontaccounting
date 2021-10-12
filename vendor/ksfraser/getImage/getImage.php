<?

include_once( 'extract_start_end.php' );


function curl_get_file_contents_k($URL, $fp)
{
        $c = curl_init($URL);
//        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); //Returns the data rather than TRUE for curl_exec
//        curl_setopt($c, CURLOPT_URL, $URL);
	curl_setopt($c, CURLOPT_FILE, $fp);
	curl_setopt($c, CURLOPT_HEADER, 0);

        $ret = curl_exec($c);
	$info = curl_getinfo($c); //Status codes, etc
        curl_close($c);
	return $ret;
}

function getImage($upc, $url)
{
	$return = false;
	if( $url == "" )
	{
		//Nothing on the search so link to NotAvailable.jpg
		link( "images/NotAvailable.jpg", "images/" . $upc . ".jpg" );
		return TRUE;
	}
	else
	{
		$fp = fopen( "images/" . $upc . ".jpg", "wb" );
		if ($fp)
		  $return = curl_get_file_contents_k( $url, $fp );
		else
		  $return = FALSE;
		if( $return === FALSE )
		{
			//error
			echo "Error trying to download image for $upc from $url\n";
		}
		else
		{
		}
	}
	return $return;
}

//This is a CHAPTERS specific function
function downloadImage( $upc )
{
        $url = 'http://www.chapters.indigo.ca/home/search/?keywords=' . $upc . '&pageSize=12';
        $data = file_get_contents( $url );
        $fp = fopen( $upc . ".chapters.data.txt", "w" );
        fwrite( $fp, $data );
        fclose( $fp );
        $imgarraylong = extract_start_end( $data, 'searchResultProductImage"', '</a>' ); //This is an array.  In pos 0 should be the jpg of the cover
        $imgarray = extract_start_end( $imgarraylong[0], 'src="', ' ' ); //This is an array.  In pos 0 should be the jpg of the cover
	getImage( $upc, $imgarray[0] );
}


?>
