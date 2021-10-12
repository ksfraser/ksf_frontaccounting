<?
 
function getIMDB($title)
{
	//This function searches by TITLE only. (s=tt)
	//Note that IMDB can/will return multiple results for given query.
	$url = 'http://www.imdb.com/find?q=' . $title . ';s=tt';
	if (!($fp = fopen($url, "r")))
	{
		echo "couldn't open URL $url";
	}
	$contents = fread($fp, 1000000);
	fclose($fp);
	echo $contents;
	return $contents;
}
?>
