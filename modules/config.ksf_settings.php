<?php

$log_filename = date( 'Ymdhjs') . ".txt";
$configArray[] = array( 'ModuleName' => 'ksf_settings',
                        'loadFile' => 'ksf_settings/class.ksf_settings.php',
                        'loadpriority' => 1,
                        'className' => 'ksf_settings',
                        'objectName' => 'ksf_settings',   //For multi classes within a module calling each other
                        'tablename' => 'ksf_settings',     //Check to see if the table exists?
                        );
$configArray[] = array( 'ModuleName' => 'ksf_ini',
                        'loadFile' => 'ksf_settings/class.ksf_ini.php',
                        'loadpriority' => 2,
                        'className' => 'ksf_ini',
                        'objectName' => 'ksf_ini',   //For multi classes within a module calling each other
                        'tablename' => 'ksf_ini',     //Check to see if the table exists?
                        );
?>
