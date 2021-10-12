<?php

//Creating a Module to handle Workflow.
//Will use workflow/workflow.php

class ksf_Workflow extends controller
{
	var $workflow;
	var $setup;	//Are we setup to do workflows
	var $workflowmenu;
	function __construct()
	{
		$status = include_once( dirname( __FILE__ ) . '/workflow/workflow.php' );
		if( TRUE == $status )
		{
/*
			$this->workflow = new workflow( $table );
			$this->setup = TRUE;
			$this->ObserverNotify( "NOTIFY_WORKFLOW_SETUP", "", $this );
*/
		}
		else
		{
			$this->setup = FALSE;
			return FALSE;
		}
                $status2 = include_once( 'workflow/workflow-menu.php');
		if( TRUE == $status2 )
		{
                        $this->workflowmenu = new WorkflowMenu;
                        if( $this->workflowmenu )
			{
                         //       $page->SetItem( $workflowmenu->Menu() );
			}
		}
	}
	/*
     	* @param mixed  $msg
     	* @return boolean  True on success or false on failure.
     	* @access public
	*/
	/*@bool@*/ function doWorkflow( /* @object@ */ $caller, /*@string@*/ $msg, /*@string@*/ $priority )
	{
		if( TRUE == $this->setup )
		{
			//Can run workflow
		}
		return FALSE;
	}
	function notified( $class, $event, $msg )
	{
		return FALSE;
	}
}
