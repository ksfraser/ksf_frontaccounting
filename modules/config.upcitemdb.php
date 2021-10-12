<?php

$configArray[] = array( 'ModuleName' => 'upcitemdb',
                        'loadFile' => 'upcitemdb/class.upcitemdb.php',
                        'loadpriority' => 10,
                        'className' => 'upcitemdb',
                        'objectName' => 'upcitemdb',   //For multi classes within a module calling each other
                        'tablename' => 'upcitemdb',     //Check to see if the table exists?
                        );

?>
