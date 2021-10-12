<?php
require 'Structures/DataGrid.php';
require_once 'HTML/Table.php';

// Instantiate the DataGrid
$datagrid =& new Structures_DataGrid();
$datagrid2 =& new Structures_DataGrid();

// Setup your database connection
$dboptions = array('dsn' => 'mysql://kalliuser:kallipass@defiant.silverdart.no-ip.org/kalli');

// Bind a basic SQL statement as datasource
//$test = $datagrid->bind('SELECT * FROM kallimachos', $dboptions);
$test = $datagrid->bind('SELECT * FROM movies', $dboptions);

// Print binding error if any
if (PEAR::isError($test)) {
    echo $test->getMessage(); 
}

//$xmloptions = array( 	'xpath' => '/methodResponse/params/param/value/struct/member',
$xmloptions = array( 	'xpath' => '/methodResponse/params/param/value/struct',
//$xmloptions = array( 	'xpath' => '/methodResponse/params/param/value',
//$xmloptions = array( 	'xpath' => '/methodResponse/',
                     	'path' => '/methodResponse/params/',
	//		'namespaces' => '',
			'fieldAttribute' => 'value',
			'labelAttribute' => 'name' 
		);

$urloptions = array();

/*
  http://webservices.amazon.com/onca/xml?
  Service=AWSECommerceService
  &Operation=ItemLookup
  &ResponseGroup=Large
  &SearchIndex=All
  &IdType=UPC
  &ItemId=635753490879
  &AWSAccessKeyId=[Your_AWSAccessKeyID]
  &AssociateTag=[Your_AssociateTag]
  &Timestamp=[YYYY-MM-DDThh:mm:ssZ]
  &Signature=[Request_Signature]
*/
//This returns an XML
/*
<Item>
  <ASIN>B004U9USEA</ASIN>
  <DetailPageURL>
    http://www.amazon.com/Samsung-GT-P1010CWAXAR-Galaxy-Tab-Wi-Fi/dp/B004U9USEA%3FAWSAccessKeyId%3D[Your_AWSAccessKeyId]%26tag%3D[Your_AssociateTag]%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3DB004U9USEA
  </DetailPageURL>
  <SalesRank>6</SalesRank>
  <ItemAttributes>
    <Binding>Personal Computers</Binding>
    <Brand>Samsung</Brand>
    <Color>Black/White</Color>
    <CPUManufacturer>Intel</CPUManufacturer>
    <CPUSpeed Units="GHz">2.1</CPUSpeed>
    <CPUType>Intel Pentium 4</CPUType>
    <DisplaySize Units="inches">10.1</DisplaySize>
    <EAN>0635753490879</EAN>
    <Feature>Android Froyo (2.2); CPU: 1GHz A8 Cortex Processor;</Feature>
    <Feature>Battery: Li-Polymer, 4000mAh</Feature>
    <Feature>Memory: 16GB Internal Memory; Up to 32GB Expandable Memory (microSD)</Feature>
    <Feature>WiFi: 802.11 a/b/g/n; USB 2.0; Bluetooth 2.1 Connectivity</Feature>
    <Feature>Audio: MP3, OGG, AAC, AMR-NB, AMR-WB, WMA, FLAC, WAV, MID, AC3, RTTTL/RTX, OTA, i-Melody, SP-MIDI</Feature>
    <Feature>Display: 7.0" WSVGA Display; 600 x 1024 Pixel Display Resolution; 3.54" x 6.05" Display Size; 16M TFT Display Technology</Feature>
    <Feature>Video: Codec: Mpeg4, H.264, H.263, Divx/XviD Format: 3gp(mp4), wmv(asf), avi(divx), mkv, flv</Feature>
    <HardDiskSize Units="GB">1</HardDiskSize>
    <ListPrice>
      <Amount>36999</Amount>
      <CurrencyCode>USD</CurrencyCode>
      <FormattedPrice>$369.99</FormattedPrice>
    </ListPrice>
    <Manufacturer>Samsung IT</Manufacturer>
    <Model>GT-P1010CWAXAR</Model>
    <MPN>GT-P1010CWAXAR</MPN>
    <Title>Samsung Galaxy Tab (Wi-Fi)</Title>
    <UPC>635753490879</UPC>
  </ItemAttributes>
</Item>
*/



//$test = $datagrid2->bind('043396115408.xml', $xmloptions, 'XML');
$html = file_get_contents('http://www.amazon.ca/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=628261224722');
$test = $datagrid2->bind( $html, $urloptions, 'RSS');

// Print binding error if any
if (PEAR::isError($test)) {
    echo $test->getMessage(); 
}


// Define columns
/*$datagrid->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
$datagrid->addColumn(new Structures_DataGrid_Column('Name', null, 'lname', array('width' => '40%'), null, 'printFullName()'));
$datagrid->addColumn(new Structures_DataGrid_Column('Username', 'username', 'username', array('width' => '20%')));
$datagrid->addColumn(new Structures_DataGrid_Column('Role', null, null, array('width' => '20%'), null, 'printRoleSelector()'));
$datagrid->addColumn(new Structures_DataGrid_Column('Edit', null, null, array('width' => '20%'), null, 'printEditLink()'));
*/

// Define the Look and Feel
$tableAttribs = array(
    'width' => '100%',
    'cellspacing' => '0',
    'cellpadding' => '4',
    'class' => 'datagrid'
);
$headerAttribs = array(
    'bgcolor' => '#CCCCCC'
);
$evenRowAttribs = array(
    'bgcolor' => '#FFFFFF'
);
$oddRowAttribs = array(
    'bgcolor' => '#EEEEEE'
);
$rendererOptions = array(
    'sortIconASC' => '&uArr;',
    'sortIconDESC' => '&dArr;'
);

// Create a HTML_Table
$table = new HTML_Table($tableAttribs);
$tableHeader =& $table->getHeader();
$tableBody =& $table->getBody();

// Ask the DataGrid to fill the HTML_Table with data, using rendering options
$test = $datagrid->fill($table, $rendererOptions);
if (PEAR::isError($test)) {
    echo $test->getMessage(); 
}


// Set attributes for the header row
$tableHeader->setRowAttributes(0, $headerAttribs);

// Set alternating row attributes
$tableBody->altRowAttributes(0, $evenRowAttribs, $oddRowAttribs, true);

// Output table and paging links
//******************************echo $table->toHtml();

// Print the DataGrid with the default renderer (HTML Table)
//$test = $datagrid->render('CSV');
//$test = $datagrid->render('Console');

// Print rendering error if any
//if (PEAR::isError($test)) {
//    echo $test->getMessage(); 
//}
$test = $datagrid2->render('Console');
//$test = $datagrid2->render('CSV');

// Print rendering error if any
if (PEAR::isError($test)) {
    echo $test->getMessage(); 
}
//var_dump( $test);
?> 
