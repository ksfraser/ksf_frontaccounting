<?php


/*********************************************************
*
*       20110114 KF
*       Mydvds program downloads a complete DVD database
*       from the net.  Search its list
*| DVD Title       | text    | YES  |     | NULL    |       |
*| Studio          | text    | YES  |     | NULL    |       |
*| Released        | text    | YES  |     | NULL    |       |
*| Status          | text    | YES  |     | NULL    |       |
*| Sound           | text    | YES  |     | NULL    |       |
*| Versions        | text    | YES  |     | NULL    |       |
*| Price           | text    | YES  |     | NULL    |       |
*| Rating          | text    | YES  |     | NULL    |       |
*| Year            | text    | YES  |     | NULL    |       |
*| Genre           | text    | YES  |     | NULL    |       |
*| Aspect          | text    | YES  |     | NULL    |       |
*| UPC             | text    | YES  |     | NULL    |       |
*| DVD ReleaseDate | text    | YES  |     | NULL    |       |
*| ID              | int(11) | NO   | PRI |         |       |
*| Timestamp
*
**********************************************************/

function getMydvds( $UPC )
{
//Return an array of data
	require 'Structures/DataGrid.php';
	require_once 'HTML/Table.php';

	// Instantiate the DataGrid
	$datagrid =& new Structures_DataGrid(10);

	// Setup your database connection
	$dboptions = array('dsn' => 'mysql://kalliuser:kallipass@defiant.silverdart.no-ip.org/kalli');

	// Bind a basic SQL statement as datasource
	$test = $datagrid->bind("SELECT * FROM mydvds_Region1 where UPC = '$UPC'", $dboptions);

	// Print binding error if any
	if (PEAR::isError($test)) {
	    echo $test->getMessage(); 
	}



	// Print the DataGrid with the default renderer (HTML Table)
	//$test = $datagrid->render('CSV');
	//$test = $datagrid->render('Excel');
	//$test = $datagrid->render('Console');
	// Print rendering error if any
	if (PEAR::isError($test)) {
	    echo $test->getMessage(); 
	}

	//var_dump( $datagrid->recordSet[0] );
	if( isset( $datagrid->recordSet[0] ))
	{
		return $datagrid->recordSet[0];
	}
	else
	{
		$arr = array();
		return $arr;
	}
}

function MyDVD2details( $details, $mydvds )
{
		if( isset( $mydvds['DVD_Title'] ))
			$details['Title'] = $mydvds['DVD Title'];
                if( isset( $mydvds['Genre'] ))
			$details['Genre'] = $mydvds['Genre'];
                if( isset( $mydvds['Released'] ))
			$details['year'] = $mydvds['Released'];
                if( isset( $mydvds['UPC'] ))
			$details['isbn'] = $mydvds['UPC'];
                if( isset( $mydvds['Studio'] ))
			$details['publisher'] = $mydvds['Studio'];
                if( isset( $mydvds['Rating'] ))
			$details['mpaarating'] = $mydvds['Rating'];
                if( isset( $mydvds['DVD_ReleaseDate'] ))
			$details['releasedate'] = $mydvds['DVD ReleaseDate'];
	return $details;
}


//Testing
//var_dump( getMydvds( $argv[1] ) );
?> 
