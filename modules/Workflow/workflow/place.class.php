<?php 

//Typical layout of a task:
//Start -> Action 1 -> { Case -> Action }* ->  End
//An Action can split into multiple cases
//Multiple Cases can be a precondition before an action is active
//Each action may be available to only certain roles

//Above can be represented by Place -arc-> transition -arc-> place
//Each transition can have a trigger of the following types: (known as transition_trigger in the tables)
//      User
//      Automatic
//      Time based
//      Message based (external event)
//      AUTO
//Each transition may have 2 types of inward and 2 outward arcs:
//      AND split
//      OR split
//      AND join
//      OR join
//      combinations of AND and OR.  Best modeled by creating extra auto transitions.


//ARC table links the place and the transition action
class place 
{
	var $idworkflow;
	var $id;
	var $type;
	var $name;
	var $description;

         function __constructor()
         {
         }
	function set_idworkflow( $val )
	{
		$this->idworkflow = $val;
		return;
	}
	function get_idworkflow()
	{
		return $this->idworkflow;
	}
	function set_id( $val )
	{
		$this->id = $val;
		return;
	}
	function get_id()
	{
		return $this->id;
	}
	function set_type( $val )
	{
		$this->type = $val;
		return;
	}
	function get_type()
	{
		return $this->type;
	}
	function set_name( $val )
	{
		$this->name = $val;
		return;
	}
	function get_name()
	{
		return $this->name;
	}
	function set_description( $val )
	{
		$this->description = $val;
		return;
	}
	function get_description()
	{
		return $this->description;
	}
} /* class place */
