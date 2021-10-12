<?php

//http://isbndb.com/api/v2/docs

class getISBN 
{
	var $details;
	function getISBN( $isbn )
	{
		//CueCats start with .C
		if( strncmp( $isbn, ".C", 2 ) == 0)
		{
			//Need to convert
		}
		if( strlen( $isbn ) > 13)
		{
			//Scan included the price scan code
			$isbn = substr( $isbn, 0, 13 );
		}
		$url="http://isbndb.com/api/books.xml?access_key=HZEAG6KT&index1=isbn&value1=" . $isbn; 
		if (!($fp = fopen($url, "r")))
		{
			echo "couldn't open URL $url";
		}
		$contents = fread($fp, 1000000);
		fclose($fp);
		$xml = new SimpleXMLElement($contents);
//var_dump( $xml );		
		$details = array();
		foreach ($xml->xpath('//BookData') as $book)
		{
//			var_dump( $book );
	
			$this->details['Title'] = (string)$book->Title;
			$this->details['author'] = (string)$book->AuthorsText;
			$this->details['publisher'] = (string)$book->PublisherText['publisher_id'];
			$this->details['TitleLong'] = (string)$book->TitleLong;
			$this->details['Summary'] = (string)$book->Summary;
			$this->details['Notes'] = (string)$book->Notes;
			$this->details['URLs'] = (string)$book->UrlsText;
			$this->details['isbn'] = (string)$book['isbn'];
			$this->details['isbn13'] = (string)$book['isbn13'];
	
		}
		return;
	}
	function getISBN2details( $details )
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

//TESTING
//$isbn = new getISBN( $argv[1] );
//var_dump( $isbn->details );
?>	
