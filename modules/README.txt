Insert config.<modname>.php file to cause the autoloading of the module.

There should be an enabled/disabled field in the config table for the module.

Config File example:


$configArray[] = array( 'ModuleName' => 'modname',
			'loadFile' => 'modname/class.modulename.php',
			'loadpriority' => priority,
			'className' => 'classname',
			'objectName' => 'objectname', 	//For multi classes within a module calling each other
			'tablename' => 'tablename',	//Check to see if the table exists?
			);
