<?php
$configArray[] = array( 'ModuleName' => 'Workflow',
                        'loadFile' => 'Workflow/class.Workflow.php',
                        'loadpriority' => 2,
                        'className' => 'ksf_Workflow',
                        'objectName' => 'ksf_workflow',   //For multi classes within a module calling each other
                        'tablename' => 'workflow',     //Check to see if the table exists?
                        );
?>
