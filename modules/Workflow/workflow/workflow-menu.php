<?php

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

//Above can be represented by Place -arc-> transition -arc-> place
//Each transition can have a trigger of the following types: (known as transition_trigger in the tables)
//	User
//	Automatic
//	Time based
//	Message based (external event)
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


/*20130111 KF split out... */
class WorkflowMenu
{
	//Create the table of outstanding items for the user to action
	//function Display() { return;
	function Display() { 
	//	return '<div class="workflow">WORKFLOW ' . $_SERVER['PHP_SELF'] . '</div><br />'; 
		$table = $this->Menu();
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
