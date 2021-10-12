<?php
$configArray[] = array( 'ModuleName' => 'Google',
                        'loadFile' => 'Google/class.data_google.php',
                        'loadpriority' => 20,
                        'className' => 'data_Google',
                        'objectName' => 'data_Google',   //For multi classes within a module calling each other
                        'tablename' => 'Google',     //Check to see if the table exists?
                        );
?>
