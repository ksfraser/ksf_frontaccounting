<?

require_once( 'extract_start_end.php' );
class getChapters
{	
	var $details; 
	function getChapters($upc)
	{
		//Note that Chapters can/will return multiple results for given query.
		$contents = "";
		$url = 'http://www.chapters.indigo.ca/home/search/?keywords=' . $upc . '&pageSize=12';
		$data = file_get_contents( $url );
		$fp = fopen( "data/" . $upc . ".chaptors.data.txt", "w" );
		fwrite( $fp, $data );
		fclose( $fp );
		//$ndata = strstr( $data, '"searchResultDetails"' );
		//$ndata = strstr( $data, '"searchResultsNav"' );
		$ndata = strstr( $data, '"searchResultsContainer"' );
		
		$ex1 = extract_start_end( $ndata, "href=", '"' );
		//$imgarraylong = extract_start_end( $data, 'searchResultProductImage"', '</a>' ); //This is an array.  In pos 0 should be the jpg of the cover
		$imgarraylong = extract_start_end( $data, 'imgContainer"', '</a>' ); //This is an array.  In pos 0 should be the jpg of the cover
		if( !isset( $imgarraylong[0] ))
			return;
		$imgarray = extract_start_end( $imgarraylong[0], 'src="', '?lang' ); //This is an array.  In pos 0 should be the jpg of the cover
	//<a id="ctl18_ctl07_SearchProducts_ctl00_ctl00_ItemTitle" class="searchResultTitleLink" href="http://www.chapters.indigo.ca/music/Astro-Creep-2000-Zombie-Date/720642480625-item.html?ikwid=720642480625&amp;ikwsec=Home&cookieCheck=1">MUSIC: Astro-Creep: 2000</a></h3>
		$typearray = extract_start_end( $ndata, '&s=', '&qid' ); //This is an array.  In pos 0 should be the jpg of the cover
		$detailurlarraylarge = extract_start_end( $ndata, '"searchResultTitleLink"', '</h3>' ); //This is an array.  In pos 0 should be the jpg of the cover
		if( !isset( $detailurlarraylarge[0] ))
			return;
		$titlearray = extract_start_end( $detailurlarraylarge[0], '">', '</a>' );
		$detailurlarray = extract_start_end( $detailurlarraylarge[0], 'href="', '"' ); 
		if( !isset( $detailurlarray[0] ))
			return;
		$asinarray = extract_start_end( $detailurlarray[0], "dp/", "/ref" );
		$summaryarray = extract_start_end( $ndata, 'searchResultAboutItem">', '</div>' );
		$publisherarray = extract_start_end( $data, 'searchResultItemSpecs"', '</' );
		if( !isset( $imgarray[0] ))
			return;
		$mediaarray = extract_start_end( $imgarray[0], "indigo.ca/", "/" );
	//	echo "Image";
	//	var_dump( $imgarray[0] );
	/*	echo "Title";
		var_dump( $titlearray[0] );
		echo "Type";
		var_dump( $typearray[0] );
	*/
	//	echo "Detail";
	//	var_dump( $detailurlarray[0] );
	/*
		echo "ASIN";
		var_dump( $asinarray[0] );
	*/
	//	echo "Summary";
	//	var_dump( $summaryarray[0] );
	//	echo "Publisher";
	//	var_dump( $publisherarray[0] );
		$this->details['upc'] = $upc;
		$this->details['Title'] = $titlearray[0];
		$this->details['Genre'] = "" ;
		if( !strncasecmp( $mediaarray[0], "dvd", 3 ))
			$this->details['Media'] = "DVD";
		else if( !strncasecmp( $mediaarray[0], "music", 3 ))
			$this->details['Media'] = "Audio CD";
		else 
		{
			//var_dump( $mediaarray );
		}
		$this->details['Year'] = "";
		$this->details['IMDB Number'] = "";
		//$this->details['ASIN'] = $asinarray[0];
		$this->details['Chapters Details page'] = $detailurlarray[0];
		$this->details['Cover Image'] = $imgarray[0];
		$this->details['ISBN'] = "";
		$this->details['format'] = "";
		$this->details['publisher'] = "";
		//$this->details['keywords'] = $typearray[0] . "";
		$this->details['MPAA rating'] = "";
		$this->details['Comments'] = "";
		$this->details['Summary'] = $summaryarray[0];
		$this->details['userrating'] = "3";
		$this->details['number of disks'] = "1";
		$this->details['release date'] = "";
		$this->details['location'] = "";
		//$this->details['inventory date'] = now();
		return ;
	/*
		UPC
		Title
		Genre
		Media
		Year
		IMDB Number
		ASIN
		Chapters Details page
		Cover Image
		ISBN
		format
		publisher
		keywords
		MPAA rating
		Comments
		Summary
		userrating (stars)
		number of disks
		release date
		location (inventory)
		inventory date
	*/
		//return t_extract( $ndata, 'class="n2"' );
		//return t_extract( $data, "product" );
	/*
		if (!($fp = fopen($url, "r")))
		{
			echo "couldn't open URL $url";
		}
		else
		{
			$contents = fread($fp, 100000000);
			fclose($fp);
			echo $contents;
			t_extract( $contents, '"searchresults"' );
		}
		return $contents;
	*/
	}
	
	function t_extract( $data, $anchor )
	{
	require_once( 'data/tableextractor.php' );
	
	        $array = array();
	
	        $tbl = new tableExtractor;
	        $tbl->source = $data; // Set the HTML Document
	        $tbl->anchor = $anchor; // Set an anchor that is unique and occurs before the Table
	        //$tbl->anchor = 'annualdiv'; // Set an anchor that is unique and occurs before the Table
	        $tpl->anchorWithin = true; // To use a unique anchor within the table to be retrieved
	        $d = $tbl->extractTable(); // The array
	        //var_dump( $d );
	
	        if( is_array( $d ) )
	        {
	                foreach( $d as $dkey => $dvalue )
	                {
	                        $count = 0;
	                        foreach( $dvalue as $rkey=>$value )
	                        {
	                                $count++;
	                                if( $count == 1 )
	                                {
	                                        //$key = converttags( $value );
						$key = $value;
	                                }
	                                else
	                                if( $count > 1 )
	                                {
	                                        //$array[$key][$count - 2] = str_replace( $bad, $good, $value);
	                                        $array[$key][$count - 2] = $value;
	                                }
	                        }
	                }
	      var_dump( $array );
	        }
	
	        return $array;
	}
	function getChapters2details( $details = array() )
	{
		if( !isset( $this->details ))
			return $details;
		foreach( $this->details as $col => $val )
                {
                        if( !isset( $details[$col] ) )
                        {
                                $details[$col] = $val;
                        }
                        else if( strlen( $details[$col] < 2 ) )
                        {
                                $details[$col] = $val;
                        }
                }
                return $details;
	}
}


//Test
//var_dump( getChapters( $argv[1] ) );
?>
