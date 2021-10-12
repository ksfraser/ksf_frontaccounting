<?

//Converting to use DOM

require_once( 'extract_start_end.php' );
class chaptersData 
{
	var $UPC;
	var $Title;
	var $Genre;
	var $Media;
	var $Year;
	var $IMDBNumber;
	var $ASIN;
	var $ChaptersDetailspage;
	var $CoverImage;
	var $ISBN;
	var $format;
	var $publisher;
	var $keywords;
	var $MPAArating;
	var $Comments;
	var $Summary;
	var $userrating;
	var $numberofdisks;
	var $releasedate;
	var $location;
	var $inventorydate;
	function __construct( $upc )
	{
		$this->UPC = $upc;
		return;
	}
}
 
function getChapters($upc)
{
	$cData = new chaptersData($upc);
	$html = downloadChapters( $upc );
/*
	$tidy = new tidy();
	$tidy->parseString( $html );
	$tidy->cleanRepair();
	extractChapters( $tidy, $cData );
*/
	extractChapters( $html, $cData );
	return $cData;
}

function downloadChapters( $upc )
{
	//Note that Chapters can/will return multiple results for given query.
	$contents = "";
	$url = 'http://www.chapters.indigo.ca/home/search/?keywords=' . $upc . '&pageSize=12';
	$data = file_get_contents( $url );
	$fp = fopen( "data/" . $upc . ".chaptors.data.txt", "w" );
	fwrite( $fp, $data );
	fclose( $fp );
	return $data;
}

function getSection( $dom, $type, $tag )
{
 	$sections = $dom->query("*" . "/" . $type . "[@class='" . $tag . "']");
	var_dump( $sections );
	//sleep( 1 );
        if( !is_null( $sections ) )
        {
                foreach( $sections as $section )
                {
                        $returnVal = $section->nodeValue;
                }
        }
	return $returnVal;
}

function extractChapters($html, $cData)
{
//	var_dump( $html );
//	sleep( 1 );
	$doc = new DOMDocument();
	$doc->loadHTML( $html );
	var_dump( $doc );
	sleep( 1 );

	/*
	$dom->preserveWhiteSpace = false;
	$element = $dom->getElementById('navigation');
	echo $element->nodeValue;
	*/

	$dom_xpath = new DOMXpath($doc);
	var_dump( $dom_xpath );
	sleep( 1 );

	$cData->CoverImage = getSection( $dom_xpath, "class", "imgContainer" );
	$cData->Title = getSection( $dom_xpath, "li", "productTitle" );
	$cData->Comments = getSection( $dom_xpath, "span", "contributor" );
	$cData->Media = getSection( $dom_xpath, "span", "format" );
	$cData->format = $cData->Media;
	$cData->userrating = getSection( $dom_xpath, "div", "rating" );
	$cData->Summary = getSection( $dom_xpath, "span", "description" );
	return $cData;
}



//Test
//var_dump( getChapters( $argv[1] ) );
 getChapters( $argv[1] );

?>
