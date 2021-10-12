<?php

/*20130111 KF
	taking workflow, and removing out the workflow menu items.  Make it more separate
TODO:	actually split them...
*/

//This module is to control the workflow of tasks
//A task can trigger a workflow if it is a CRUD process on a table
//Simply viewing a table (Select/view/list) will not trigger a work flow.
//The purpose of human intervention in the workflow will 
//be to select something or update a record, not just look.  If a review is
//needed in the workflow, put an approved field in the data table 
//so there is something to record that fact, and trigger the review
//
//Uses a PETRI network of places, transitions (arcs).
//

//Typical layout of a task:
//Start -> Action 1 -> { Case -> Action }* ->  End
//An Action can split into multiple cases
//Multiple Cases can be a precondition before an action is active
//Each action may be available to only certain roles

//Above can be represented by Place -arc-> transition -arc-> place.  TRANSITION is a function.
//Each transition can have a trigger of the following types: (known as transition_trigger in the tables)
//	User
//	Automatic
//	Time based
//	Message based (external event)
//	AUTO
//Each transition may have 2 types of inward and 2 outward arcs:
//	AND split
//	OR split
//	AND join
//	OR join
//	combinations of AND and OR.  Best modeled by creating extra auto transitions.

//Workflow tables:
//action
//	id
//	application
//	action
//	description
//	includefile
//arc
//		workflow_id
//				transition_id
//			place_id
//	direction
//	arc_type
//	precondition
//case
//								case_id
//		workflow_id
//	context
//	case_status
//	start_date
//	end_date
//flowrole
//	roles_id
//		workflow_id
//machine
//	id
//	application
//	currentstate
//	nextstate
//	action	
//							trigger (user, auto, mail, xtrn)
//	description
//	table
//place
//		workflow_id
//			place_id
//	place_type
//	place_name
//	place_description
//									idtasks
//token
//		workflow_id
//			place_id
//	context
//	token_status
//transition
//		workflow_id
//				transition_id
//	transition_name
//	transition_desc
//							transition_trigger (user, auto, mail, xtrn)
//	time_limit
//					task_id
//						role_id
//workflow
//		workflow_id
//	workflow_name
//	workflow_desc
//					start_task_id
//	is_valid
//	workflow_errors
//	start_date
//	end_date
//workitem
//	workitem_id
//								case_id
//		workflow_id
//				transition_id
//							transition_trigger (user, auto, mail, xtrn)
//					task_id
//	context
//	workitem_status
//	enabled_date
//	cancelled_date
//	finished_date
//	deadline
//						role_id
//	user_id


/* 20130111 KF Moved to own file
class WorkflowMenu
{
	//Create the table of outstanding items for the user to action
	//function Display() { return;
	function Display() { 
		return '<div class="workflow">WORKFLOW ' . $_SERVER['PHP_SELF'] . '</div><br />'; }
}
*/
require_once( 'workflow-menu.php' ); //Called in controller.php

class Workflow
{
	var $self;
	var $class;
	var $context;
	var $token; //Tokens are markers for workflows in progress.  They are stored in places and move through transitions.
	var $workflow_id;
	var $place_id;  //Places are inactive - think of them as in-boxes.  State in a state machine
	var $transition_id; //Transitions are active - activities performed moving between places.  Tasks out of the TASKS database used in the menu system.
	var $arc;  //An arc connects a place to a transition or vice versa.
	var $lastinsertid;
	var $tablename;
	function Workflow( $class = NULL, $tokendata = NULL )
	{
		return;
	}
	function RunWorkflow( $class = NULL, $tokendata = NULL )
	{
		//Need to register the workflow with the class so that as the table conducts activities,
		//appropriate workflow activities will also be triggered.
		//
		debug_print_backtrace();
		if ($class != NULL)
		{
			if( isset( $class->lastinsertid ))
			{
				echo __FILE__ . ":" . __LINE__ . "<br />\n";
				echo "Lastinsertid $class->lastinsertid<br />\n";
				$this->lastinsertid = $class->lastinsertid;
				$this->tablename = $class->querytablename;
				$this->class = $class;
			}
			else
			{
				echo __FILE__ . ":" . __LINE__ . "<br />\n";
				echo "Lastinsertid $class->lastinsertid<br />\n";
				//var_dump( $class );
				//no point running this if we didn't alter a row in a table somewhere
				return 0;
			}
			if ( strncasecmp( $this->tablename,  "state", 5) == 0 )
			{
				echo __FILE__ . ":" . __LINE__ . "<br />\n";
				return;
			}
		}
		else
		{
				echo __FILE__ . ":" . __LINE__ . "<br />\n";
			return; //No point if there is no class.
		}
				echo __FILE__ . ":" . __LINE__ . "<br />\n";
		if ( $tokendata != NULL )
		{
			//Came from either a post or get
			if( isset( $tokendata['context'] ))
			{
				$this->context = $tokendata['context'];
			}
			if( isset( $tokendata['wf_token'] )) //token is also used for security - anti form spoofing.
			{
				$this->token = $tokendata['wf_token'];
			}
			if( isset( $tokendata['workflow_id'] ))
			{
				$this->workflow_id = $tokendata['workflow_id'];
			}
			if( isset( $tokendata['place_id'] ))
			{
				$this->place_id = $tokendata['place_id'];
			}
			if( isset( $tokendata['transition_id'] ))
			{
				$this->transition_id = $tokendata['transition_id'];
			}
		}
		//return;
		//var_dump( $_SERVER );
		$script = $_SERVER['SCRIPT_NAME'];
		$scriptarr = explode( '/', $script );
		$scriptcount = count( $scriptarr );
		$this->self = $scriptarr[ $scriptcount - 1 ];
		//-strlen($_MY_PATH_PART)
		$this->StartWorkflow();
		$this->FireTransitions();
		return;
	}
	function StartWorkflow()
	{
		debug_print_backtrace();
		//Check for self (calling script) in list of tasks that start a workflow
		//If so, we have started a workflow.  Insert a token into that place in the statemachine.
		require_once( 'workflow/classes/stateworkflow.class.php');
		$flow = new stateworkflow;
/* 20130111 KF The statement below assumes that the script name that did the CRUD action is actually in the table
		But only the idtasks (as start_task_id) is there so we need to do a join
		$flow->where = "start_task like '%" . $this->self . "%'";
*/
		require_once( 'security/model/tasks.class.php');
		$tasks = new tasks();
		$tasks->where = "tasklink like '%" . $this->self . "%' and idtasks in (select start_task_id from stateworkflow)";
		//grab the list of start places related to this calling script.
		$tasks->Select();
		//var_dump( $flow->resultarray );
		foreach ($tasks->resultarray as $row)
		{
			$flow->where = "start_task_id='" . $row['idtasks'] . "'";
			$flow->Select();
			//If we are a start task, add a token to the right place
			$this->workflow_id = $flow->resultarray[0]['workflow_id'];
			require_once( 'workflow/classes/stateplace.class.php');
			$place = new stateplace;
			$place->where = "workflow_id = '" . $this->workflow_id . "' and place_type='S'";
			$place->Select();
			$this->place_id = $place->resultarray[0]['place_id'];
			$this->InsertToken();
			return;
		}
		return;
	}
	
	function InsertToken()
	{
		if( strlen( $this->tablename ) > 1  AND $this->lastinsertid > 0 )
		{
			require_once( 'workflow/classes/statetoken.class.php');
			$token = new statetoken;
			$insert['workflow_id'] = $this->workflow_id;
			$insert['place_id'] = $this->place_id;
			$insert['tableindex'] = $this->lastinsertid;
			$insert['tablename'] = $this->tablename;

			$this->context = $this->lastinsertid;
			$token->Insert( $insert );
			$this->token = $token->lastinsertid;
		}
		return;
	}
	function CreateCase( $workflow_id )
	{
		//Create a new entry in CASE
		require_once( 'workflow/classes/statecase.class.php');
		$case = new statecase;
		$caseupdate['workflow_id'] = $workflow_id;
		$caseupdate['context'] = $this->class->lastinsertid;
		$caseupdate['case_status'] = 'O'; //Open
		$caseupdate['created_user'] = $_SERVER['PHP_AUTH_USER'];
		$caseupdate['start_date'] = date( "Y-m-d" );
		$caseupdate['created_date'] = date( "Y-m-d" );
		//$case->Update( $caseupdate );
		$case->Insert( $caseupdate );
		return;
	}
	function CreateToken( $workflow_id )
	{
		//Put a token in the start place
/*
		require_once( 'workflow/classes/stateplace.class.php');
		$place = new stateplace;
		$placeupdate['workflow_id'] = $workflow_id;
		$placeupdate['place_type'] = 'S'; //Start
		$placeupdate['created_user'] = $_SERVER['PHP_AUTH_USER'];
		$placeupdate['start_date'] = date( "Y-m-d" );
		$placeupdate['created_date'] = date( "Y-m-d" );
		$place->Insert( $placeupdate );
*/
		return;

	}
	function FireTransitions()
	{
		//Are we a token in a place?
		//Arcs connect places to transitions AND transitions to places
		require_once( 'workflow/classes/statearc.class.php');
		$arc = new statearc;
		//Find the place to transition arc
		$arc->where = "workflow_id='" . $this->workflow_id . "' and place_id ='" . $this->place_id . "' and direction='pt'";
		$arc->Select();
		//Determine transition - could be multiple transitions (arcs) out
		$links = "";
		foreach ($arc->resultarray as $key=>$value)
		{
			$this->transition_id = $value['transition_id'];
			//this (arc) gives us a precondition, type, transition id
			require_once( 'workflow/classes/statetransition.class.php');
			$transition = new statetransition;
			$transition->where = "transition_id = '" . $this->transition_id . "'";
			$transition->Select();
			//The transition gives us the task id
			//require_once( 'security/tasks.class.php');
			//require_once( MODELDIR . '/tasks.class.php');
			$task = new tasks;
			$task->where = "idtasks = '" . $transition->resultarray[0]['task_id'] . "'";
			$task->Select();
			//User intermediate tasks should mostly be update tasks
			$PATH = $task->resultarray[0]['tasklink'];
			$description = $task->resultarray[0]['taskdescription'];

			//Fire any AUTO transitions
			if ( strncmp( $transition->resultarray[0]['transition_trigger'], 'AUTO', 4 ) == 0 )
			{
				$ret = 0;
				include_once( APPDIR . "/" . $PATH ); //assume file has the class declared so that something launches
				//If the classname is set, create the class
				if( strlen( $transition->resultarray[0]['classname'] ) > 1 )
				{
					echo __FILE__ . ":" . __LINE__ . " lastinsertid " . $this->lastinsertid . "<br />\n";
					$trans = new $transition->resultarray[0]['classname']( $this->lastinsertid );
					//If the functionname is set, run that function
					if( strlen( $transition->resultarray[0]['functionname'] ) > 1 )
					{
						$func = $transition->resultarray[0]['functionname'];
						echo __FILE__ . ":" . __LINE__ . " Calling " . $func . "<br />\n";
						
						$ret = $trans->$func();
					}
					else if( is_object( $trans ) )
					{
						//assuming __construct ran successfully
						$ret = 1;
					}
					else
					{
						$ret = 0;
					}
				}
				//If the function succeeded, run the next arc
				if( $ret == 1 )
				{
					//Consume current token and fire transitions
					$this->ConsumeToken();
					$arc->where = "workflow_id='" . $this->workflow_id . "' and transition_id ='" . $this->transition_id . "' and direction='tp'";
					$arc->Select();
					foreach( $arc->resultarray as $row )
					{
						if( isset( $row['place_id'] ) )
						{
							$this->place_id = $row['place_id'];
	        					//create new token(s)
							//unless we are inserting data into the next step, these 2 fields will be blank
                					$this->lastinsertid = $trans->lastinsertid;
                					$this->tablename = $trans->querytablename;

						}
					}
				}
			}

			/*
			if ( strncmp( $value['type'], 'USER', 4 ) == 0 )
			{
			*/
			$links .= "<a href='" . $PATH . "'>Next step - " . $description . "</a><br />";
			/*
			}
			else
			{
				//
			}
			*/
		}
		//Consume current token and fire transitions
		//$this->ConsumeToken();
	        //create new token(s)

		$_SESSION['workflowlinks'] = $links;
		return;
	}
	function ConsumeToken()
	{
		$tokenupdate['statetoken_id'] = $this->token;
		$tokenupdate['status'] = 'C';
		require_once( 'workflow/classes/statetoken.class.php');
		$token = new statetoken;
		$token->Update( $tokenupdate );
		return;
	}
	function Menu()
	{
		//include_once( 'workflow/local.php');

		//Add the Process Starts that are available to this person's role
		$query = "select stateworkflow.*, users.roles_id, users.username, stateflowrole.workflow_id, tasks.* from stateworkflow  join stateflowrole  on stateflowrole.workflow_id = stateworkflow.workflow_id join users on users.roles_id = stateflowrole.roles_id join tasks on tasks.idtasks = stateworkflow.start_task_id where users.username = '" . $_SERVER['PHP_AUTH_USER'] . "'";
		$db = Local_DB();
		$db->SetQuery($query);
		$db->Query();
		$db->ResultToRows();
		//var_dump($db->resultrows);
		$menutable = new Menu( "workflow" );
		$choices = array();
		foreach( $db->resultrows as $index=>$row)
		{
			//var_dump($row);
			//echo "<br />TASK " . $row['taskdescription'] . "::" . $row['tasklink'] . "::" . $row['taskparent'] . "<br />";
			if (! in_array(  $row['workflow_name'], $choices  ) )
			{
				$mc = new MenuCell( $row['workflow_name'] );
				$menutable->SetItem( $mc );
				$submenu[$row['workflow_name']] = $mc;
				$choices[] = $row['workflow_name'];
			}
/* The ../ is a kludge dependant on the view scripts living in APPDIR/model */
/*20130110 KF missing APPDIR makes the link fail
			//$mchoice = new MenuChoice( "workflow", "../" . $row['tasklink'], $row['workflow_desc'] );
*/
			//$_SERVER['DOCUMENT_ROOT']
			if( basename( dirname( $_SERVER['SCRIPT_NAME'] )) == "model" )
				$mchoice = new MenuChoice( "workflow", "../" . $row['tasklink'], $row['workflow_desc'] );
			else
				$mchoice = new MenuChoice( "workflow", $row['tasklink'], $row['workflow_desc'] );
			//$mchoice = new MenuChoice( "workflow", APPDIR . "/" . $row['start_task'], $row['workflow_desc'] );
			//$mc->SetOption( $mchoice );
			$submenu[$row['workflow_name']]->SetOption( $mchoice );
		}

		//Now add the workflow processes (places) that have tokens waiting for someone of this role

		/*  
		select 	*
		from 		statetoken,
		stateworkflow,
		stateflowrole,
		users,
		stateplace
		where 		users.username = 'kevin'
		and users.roles_id = stateflowrole.roles_id
		and stateflowrole.workflow_id = stateworkflow.workflow_id
		and stateplace.place_id = statetoken.place_id
		and stateworkflow.workflow_id = statetoken.workflow_id
		and stateworkflow.is_valid='Y' 
		and statetoken.token_status='A'
		and idstateflowrole=users.roles_id
		and now() between stateworkflow.start_date and stateworkflow.end_date
		*/

		$db->SetQuery( "select 	* from 	statetoken, stateworkflow, stateflowrole, users, stateplace where users.username = '" . $_SERVER['PHP_AUTH_USER'] . "' and users.roles_id = stateflowrole.roles_id and stateflowrole.workflow_id = stateworkflow.workflow_id and stateplace.place_id = statetoken.place_id and stateworkflow.workflow_id = statetoken.workflow_id  and stateworkflow.is_valid='Y' and statetoken.token_status='A' and idstateflowrole=users.roles_id and now() between stateworkflow.start_date and stateworkflow.end_date");	
		$db->Query();
		$db->ResultToRows();
		foreach( $db->resultrows as $index=>$row)
		{
			if (! in_array(  $row['workflow_name'], $choices  ) )
			{
				$mc = new MenuCell( $row['workflow_name'] );
				$menutable->SetItem( $mc );
				$submenu[$row['workflow_name']] = $mc;
				$choices[] = $row['workflow_name'];
			}

		//	$mchoice = new MenuChoice( "workflow", APPDIR . "/" . $row['start_task'], $row['place_desc'] );
			if ( isset( $row['context'] ))
			{
				$mchoice = new MenuChoice( "workflow", $row['start_task'] . "?context=" . $row['context'] . "&workflow_id=" . $row['workflow_id'] . "&place_id=" . $row['place_id'], $row['place_desc'] );
				//$mchoice = new MenuChoice( "workflow", APPDIR . "/" . $row['start_task'] . "?context=" . $row['context'] . "&workflow_id=" . $row['workflow_id'] . "&place_id=" . $row['place_id'], $row['place_desc'] );
				$submenu[$row['workflow_name']]->SetOption( $mchoice );
			}
		}


		if (isset( $smarty ))
		{
			$smarty->assign('workflow', "");
		}
		return $menutable;
	}
				
}
?>
