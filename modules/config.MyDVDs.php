<?php
$configArray[] = array( 'ModuleName' => 'MyDVDs',
                        'loadFile' => 'MyDVDs/class.mydvds.php',
                        'loadpriority' => 19,
                        'className' => 'mydvds',
                        'objectName' => 'mydvds',   //For multi classes within a module calling each other
                        'tablename' => 'mydvds_Region1',     //Check to see if the table exists?
                        );
?>
