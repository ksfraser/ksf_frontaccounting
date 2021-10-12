<?php

/*
 *      This idea is when a different part of the app inserts a record
 *      into the Master table, we would then post the data to Wordpress
 *      Watches for:
 *              NOTIFY_MASTER_INSERT
 *
 *      Should also figure out how to update a wordpress page so that
 *      udpates to the Master table are also updated to Wordpress
 *
 *      Triggers:
 *              NOTIFY_WORDPRESS_IMAGE_UPLOADED
 *              NOTIFY_WORDPRESS_POST
 */


$configArray[] = array( 'ModuleName' => 'Wordpress',
                        'loadFile' => 'Wordpress/class.wordpress.php',
                        'loadpriority' => 2,
                        'className' => 'post2wordpress',
                        'objectName' => 'post2wordpress',   //For multi classes within a module calling each other
                        'tablename' => 'master',     //Check to see if the table exists?
                        );
?>
