<?php

/*
 *      This idea is when a different part of the app inserts a record
 *      into the Master table, we would then post the data to Session_Data
 *      Watches for:
 *              NOTIFY_MASTER_INSERT
 *
 *      Should also figure out how to update a session_data page so that
 *      udpates to the Master table are also updated to Session_Data
 *
 *      Triggers:
 *              NOTIFY_WORDPRESS_IMAGE_UPLOADED
 *              NOTIFY_WORDPRESS_POST
 */


$configArray[] = array( 'ModuleName' => 'Session_Data',
                        'loadFile' => 'Session_Data/class.post2session_data.php',
                        'loadpriority' => 2,
                        'className' => 'post2session_data',
                        'objectName' => 'post2session_data',   //For multi classes within a module calling each other
                        'tablename' => 'master',     //Check to see if the table exists?
                        );
$configArray[] = array( 'ModuleName' => 'Session_Data',
                        'loadFile' => 'Session_Data/class.Session_Data.php',
                        'loadpriority' => 9,
                        'className' => 'Session_Data',
                        'objectName' => 'session_data',   //For multi classes within a module calling each other
                        'tablename' => 'master',     //Check to see if the table exists?
                        );
?>
