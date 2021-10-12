<?

//Converting to use DOM

require_once( 'extract_start_end.php' );
require_once( 'chaptersData.php' );

/*
class chaptersData 
{
	var $UPC;
	var $Title;
	var $Genre;
	var $Media;
	var $Year;
	var $IMDBNumber;
	var $ASIN;
	var $chaptersURL;
	var $image;
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
	var $fieldsfound;
	function __construct( $upc )
	{
		$this->UPC = $upc;
		$this->fieldsfound = array();
		return;
	}
 	function getChapters2details( $details = array() )
        {
		//echo "getChapters2details\n"; 
		var_dump( $this->fieldsfound );
		foreach( $this->fieldsfound as $field )
		{
			//echo "Field " . $field . "\n";
			if( !isset( $details[$field] ) )
                        {
                                $details[$field] = $this->$field;
                        }
                        else if( strlen( $details[$field] < 2 ) )
                        {
                                $details[$field] = $this->$field;
                        }
                }
		//var_dump( $details );
                return $details;
        }
}
*/

class getChaptersItem extends chaptersData
{ 
	var $html;
	function getChaptersItem($upc)
	{
		$this->UPC = $upc;
		$this->fieldsfound[] = "UPC";
		$this->downloadChapters( $upc );
	
		/* pecl tidy can't find libtidy
		$tidy = new tidy();
		$tidy->parseString( $this->html );
		$tidy->cleanRepair();
		*/
	
		$this->extractChapters();
		return;
	}
	
	function downloadChapters( $upc )
	{
		$success = FALSE;
		//Note that Chapters can/will return multiple results for given query.
		$contents = "";
		//$url = 'http://www.chapters.indigo.ca/home/search/?keywords=' . $upc . '&pageSize=12';
		//$url = 'http://www.chapters.indigo.ca/dvd/item/' . $upc . '-item.html';
		      //http://www.chapters.indigo.ca/books/rule-34/9781937007669-item.html
		      //http://www.chapters.indigo.ca/usedbooks/advancedsearch/?sc=9781937007669&sf=ISBN&facetIds=&sortKey=Price&sortDirection=0
		$url = 'http://www.chapters.indigo.ca/usedbooks/advancedsearch/?sc=' . $upc . '&sf=ISBN&facetIds=&sortKey=Price&sortDirection=0';
			//This URL ^ returns a summary page of results which then links to URLs like v
			//http://www.chapters.indigo.ca/usedbooks/rule-34/grp17083585-9781937007669-rare.html?ikwid=9781937007669&ikwsec=Used+Books
		$this->chaptersURL = $url;
		$this->fieldsfound[] = "chaptersURL";
		$data = file_get_contents( $url );
		//20140127 Chapters changed their interface AGAIN
		//NOW we need to process the summary page above
		$success = $this->processSummary( $data );
		if( $success == TRUE )
		{
			$fp = fopen( "data/" . $upc . ".chapters_item.data.txt", "w" );
			fwrite( $fp, $data );
			fclose( $fp );
			$this->html = $data;
		}
		return $data;
	}
	function processSummary( $data )
	{
		return FALSE;
	}	
	function getSection( $dom, $type, $tag )
	{
	 	$sections = $dom->query("*" . "/" . $type . "[@class='" . $tag . "']");
		//var_dump( $sections );
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
	
	function extractChapters()
	{
		//var_dump( $this->html );
		//sleep( 1 );
		require_once( 'data/simple_html_dom.php' );
		$doc = new simple_html_dom();
		$doc->load( $this->html );
		//$parray = $doc->find( "p" );
		//$parray[1]->innertext = "something new"; //innertext is what is in between the tag.  outertext is the tag
		//  ->class
		//JQuery style selectors
		//  ->find("#foo")  selects id="foo"
		//  ->find(".foo")  selects class="foo"
		//  ->find("h1 a")  anchor text that is within H1
		//  ->find("img[title=himom]")  images with title himom

		//$contrib = $doc->find("p[class=major-contributor]");
		////var_dump( $contrib );
		//$specs = $doc->find("p[class=product-specs]");
		////var_dump( $specs );
		//$images = $doc->find("img",0);
		//var_dump( $images );

		//<div class="mainImage itemImageShow">^M
    		//<img src="http://dynamic.indigoimages.ca/dvd/774212001512.jpg?altimages=true&width=360&quality=85&maxheight=360&lang=en&z=109092264" alt="Haven: Season 1" class="coverscan" data-drag="{&quot;pid&quot;:&quot;77421200151&quot;,&quot;catalogue&quot;:&quot;DVD&quot;,&quot;quantity&quot;:1,&quot;minAllowed&quot;:1,&quot;dropped&quot;:null,&quot;listId&quot;:null,&quot;title&quot;:&quot;Haven: Season 1&quot;,&quot;price&quot;:&quot;49.99&quot;,&quot;omnitureRef&quot;:null,&quot;isFromSearch&quot;:false}" id="mainProductImage" />^M
		foreach( $doc->find("img") as $i )
		{
			if( strpos( $i->src, $this->UPC ) === FALSE )
			{
				//UPC not in src
			}
			else
			{
				if( strcmp ($i->id, "mainProductImage" ) == 0 )
				{
					//echo $i->src . "\n"; //contains the UPC so a link to the image
					//echo $i->class . "\n";
					//echo $i->id . "\n";
					$this->image = $i->src;
					$this->fieldsfound[] = "image";
				}
			}
		}
		foreach( $doc->find("div") as $d )
		{
			if( strcmp( $d->class, "spec-list" ) == 0 )
			{
				foreach( $d->children as $t )
				{
					//echo $t . "\n\n";
					if( strpos( $t, "Release" ) !== FALSE )
					{
						//release date
						$pos = strpos( $t->plaintext, ":" ) + 1;
						$this->releasedate = trim( substr( $t->plaintext, $pos, strlen( $t->plaintext ) - $pos ) );
						$this->fieldsfound[] = "releasedate";
					}
					else
					if( strpos( $t, "Studio" ) !== FALSE )
					{
						//Studio
						$pos = strpos( $t->plaintext, ":" ) + 1;
						$this->publisher = trim( substr( $t->plaintext, $pos, strlen( $t->plaintext ) - $pos ) );
						$this->fieldsfound[] = "publisher";
					}
				}
			}
		}
		foreach( $doc->find("title") as $tt )
		{
//<title>^M Haven: Season 1 on Dvd | chapters.indigo.ca^M </title>
			/* Chapters changed their returned values
			$pos = strpos( $tt->plaintext, "|" ) - 1;
			$mendpos = strpos( $tt->plaintext, "|" ) - 1;
			$mstartpos = strrpos( $tt->plaintext, ":" );
			$this->Media =  trim( substr( $tt->plaintext, $mstartpos + 1, $mendpos - $mstartpos ) );
			*/
			$pos = strpos( $tt->plaintext, "|" ) - 1;
			$mendpos = strpos( $tt->plaintext, "|" ) - 1;
			$mstartpos = strrpos( $tt->plaintext, "on" ) + 1;
			$this->Media =  trim( substr( $tt->plaintext, $mstartpos + 1, $mendpos - $mstartpos ) );
			$this->fieldsfound[] = "Media";

			$directorendpos = $mstartpos;
			$directorstring = substr( $tt->plaintext, 0, $directorendpos );
			$directorstartpos = strrpos( $directorstring, ":" ); 
			$this->comments .= trim( substr( $tt->plaintext, $directorstartpos + 1, $directorendpos - $directorstartpos ) ); 
			$this->fieldsfound[] = "comments";

			//$titleendpos = $directorstartpos;
			$titleendpos = $mstartpos - 2;
			$this->Title = trim( substr( $tt->plaintext, 0, $titleendpos ) ); 
			$this->fieldsfound[] = "Title";
		}
//<title>^M Haven: Season 1: : Dvd | chapters.indigo.ca^M </title>
/*
		$doc = new DOMDocument();
		$doc->loadHTML( $this->html );
		var_dump( $doc );
		sleep( 1 );
	
		/*
		$dom->preserveWhiteSpace = false;
		$element = $dom->getElementById('navigation');
		//echo $element->nodeValue;
		*/
/*
	
		$dom_xpath = new DOMXpath($doc);
		var_dump( $dom_xpath );
		sleep( 1 );
	
		$this->image = getSection( $dom_xpath, "class", "imgContainer" );
		$this->Title = getSection( $dom_xpath, "li", "productTitle" );
		$this->Comments = getSection( $dom_xpath, "span", "contributor" );
		$this->Media = getSection( $dom_xpath, "span", "format" );
		$this->format = $this->Media;
		$this->userrating = getSection( $dom_xpath, "div", "rating" );
		$this->Summary = getSection( $dom_xpath, "span", "description" );
*/
		return;
	}
	
}

//Test
/*
//var_dump( getChapters( $argv[1] ) );
$getC = new getChaptersItem( $argv[1] );
$details = $getC->getChapters2details();
$getC->html = "";
//var_dump( $getC );
//var_dump( $details );
*/
?>
