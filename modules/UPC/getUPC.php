<?php
require 'Structures/DataGrid.php';
require_once 'HTML/Table.php';

// Instantiate the DataGrid
//$datagrid =& new Structures_DataGrid(10);
$datagrid =& new Structures_DataGrid();

// Setup your database connection
$dboptions = array('dsn' => 'mysql://kalliuser:kallipass@defiant.silverdart.no-ip.org/kalli');

// Bind a basic SQL statement as datasource
$test = $datagrid->bind('SELECT * FROM movies', $dboptions);

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
    'sortIconDESC' => '&dArr;',
    'delta' => '5'
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
//echo $table->toHtml();

// Print the DataGrid with the default renderer (HTML Table)
//$test = $datagrid->render('CSV');
$test = $datagrid->render('Excel');
//$test = $datagrid->render('Console');
//**HTML Sort Form is mostly useless without HTMLTable as well ************/
/*
$test = $datagrid->render('HTMLSortForm');
$test = $datagrid->render('HTMLTable');
$test = $datagrid->render('Pager');
*/
//$test = $datagrid->render('XML');
/******XML User interface Language *********************
*
*	Per the pacakge notes, need to set up XML
*	similar to HTML setup above, as the renderer
*	only creates a listbox.
*
********************************************************/
/*
header( 'content type: application/vnd.mozilla.xul+xml' );
echo '<xml version="1.0" ?>\n';
echo '<window title="mywin">\n';
$test = $datagrid->render('XUL');
echo '</window>';
*/


// Print rendering error if any
if (PEAR::isError($test)) {
    echo $test->getMessage(); 
}

?> 
