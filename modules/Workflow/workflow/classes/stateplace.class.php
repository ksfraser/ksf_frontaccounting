<?php 
//This file was generated by calling php C:\PROGRA~1\APACHE~1\Apache2\htdocs\pos\generator.php statemachine 

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: index.php");
  exit;
}

require_once('stateplace.class.inc.php');
class stateplace extends generictable{
          private $observers;
         function __constructor()
         {
         $this->querytablename = 'stateplace';
         $this->fieldspec['workflow_id']['metadata_id'] = '2861';
         $this->fieldspec['workflow_id']['table_name'] = 'stateplace';
         $this->fieldspec['workflow_id']['column_name'] = 'workflow_id';
         $this->fieldspec['workflow_id']['pretty_name'] = 'Workflow Process';
         $this->fieldspec['workflow_id']['abstract_data_type'] = 'smallint';
         $this->fieldspec['workflow_id']['db_data_type'] = 'smallint';
         $this->fieldspec['workflow_id']['field_null'] = 'YES';
         $this->fieldspec['workflow_id']['field_key'] = ' ';
         $this->fieldspec['workflow_id']['extra_sql'] = ' ';
         $this->fieldspec['workflow_id']['html_form_type'] = 'fddl';
         $this->fieldspec['workflow_id']['html_form_options'] = '<fk><field>workflow_name</field></fk>';
         $this->fieldspec['workflow_id']['html_form_explanation'] = ' ';
         $this->fieldspec['workflow_id']['help_text'] = ' ';
         $this->fieldspec['workflow_id']['mandatory_p'] = 'N';
         $this->fieldspec['workflow_id']['sort_key'] = '0';
         $this->fieldspec['workflow_id']['form_sort_key'] = '0';
         $this->fieldspec['workflow_id']['form_number'] = '1';
         $this->fieldspec['workflow_id']['default_value'] = ' ';
         $this->fieldspec['workflow_id']['field_toupper'] = 'NO';
         $this->fieldspec['workflow_id']['validationprocname'] = ' ';
         $this->fieldspec['workflow_id']['c_size'] = '5';
         $this->fieldspec['workflow_id']['prikey'] = 'N';
         $this->fieldspec['workflow_id']['noedit'] = 'N';
         $this->fieldspec['workflow_id']['nodisplay'] = 'N';
         $this->fieldspec['workflow_id']['c_unsigned'] = 'Y';
         $this->fieldspec['workflow_id']['c_zerofill'] = 'N';
         $this->fieldspec['workflow_id']['c_auto_increment'] = 'N';
         $this->fieldspec['workflow_id']['foreign_table'] = 'stateworkflow';
         $this->fieldspec['workflow_id']['foreign_key'] = 'workflow_id';
         $this->fieldspec['workflow_id']['application'] = 'statemachine';
         $this->fieldspec['workflow_id']['issearchable'] = '1';
         $this->fieldspec['workflow_id']['preinserttrigger'] = ' ';
         $this->fieldspec['workflow_id']['postinserttrigger'] = ' ';
         $this->fieldspec['workflow_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['workflow_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['workflow_id']['predeletetrigger'] = '';
         $this->fieldspec['workflow_id']['postdeletetrigger'] = '';
         $this->fieldspec['place_id']['metadata_id'] = '2862';
         $this->fieldspec['place_id']['table_name'] = 'stateplace';
         $this->fieldspec['place_id']['column_name'] = 'place_id';
         $this->fieldspec['place_id']['pretty_name'] = ' ';
         $this->fieldspec['place_id']['abstract_data_type'] = 'smallint';
         $this->fieldspec['place_id']['db_data_type'] = 'smallint';
         $this->fieldspec['place_id']['field_null'] = 'YES';
         $this->fieldspec['place_id']['field_key'] = ' ';
         $this->fieldspec['place_id']['extra_sql'] = ' ';
         $this->fieldspec['place_id']['html_form_type'] = 'smallint';
         $this->fieldspec['place_id']['html_form_options'] = ' ';
         $this->fieldspec['place_id']['html_form_explanation'] = ' ';
         $this->fieldspec['place_id']['help_text'] = ' ';
         $this->fieldspec['place_id']['mandatory_p'] = 'N';
         $this->fieldspec['place_id']['sort_key'] = '0';
         $this->fieldspec['place_id']['form_sort_key'] = '0';
         $this->fieldspec['place_id']['form_number'] = '1';
         $this->fieldspec['place_id']['default_value'] = ' ';
         $this->fieldspec['place_id']['field_toupper'] = 'NO';
         $this->fieldspec['place_id']['validationprocname'] = ' ';
         $this->fieldspec['place_id']['c_size'] = '5';
         $this->fieldspec['place_id']['prikey'] = 'Y';
         $this->fieldspec['place_id']['noedit'] = 'Y';
         $this->fieldspec['place_id']['nodisplay'] = 'N';
         $this->fieldspec['place_id']['c_unsigned'] = 'Y';
         $this->fieldspec['place_id']['c_zerofill'] = 'N';
         $this->fieldspec['place_id']['c_auto_increment'] = 'N';
         $this->fieldspec['place_id']['foreign_table'] = ' ';
         $this->fieldspec['place_id']['foreign_key'] = ' ';
         $this->fieldspec['place_id']['application'] = 'statemachine';
         $this->fieldspec['place_id']['issearchable'] = '1';
         $this->fieldspec['place_id']['preinserttrigger'] = ' ';
         $this->fieldspec['place_id']['postinserttrigger'] = ' ';
         $this->fieldspec['place_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['place_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['place_id']['predeletetrigger'] = '';
         $this->fieldspec['place_id']['postdeletetrigger'] = '';
         $this->fieldspec['place_type']['metadata_id'] = '2863';
         $this->fieldspec['place_type']['table_name'] = 'stateplace';
         $this->fieldspec['place_type']['column_name'] = 'place_type';
         $this->fieldspec['place_type']['pretty_name'] = ' ';
         $this->fieldspec['place_type']['abstract_data_type'] = 'char';
         $this->fieldspec['place_type']['db_data_type'] = 'char';
         $this->fieldspec['place_type']['field_null'] = 'YES';
         $this->fieldspec['place_type']['field_key'] = ' ';
         $this->fieldspec['place_type']['extra_sql'] = ' ';
         $this->fieldspec['place_type']['html_form_type'] = 'char';
         $this->fieldspec['place_type']['html_form_options'] = ' ';
         $this->fieldspec['place_type']['html_form_explanation'] = ' ';
         $this->fieldspec['place_type']['help_text'] = ' ';
         $this->fieldspec['place_type']['mandatory_p'] = 'N';
         $this->fieldspec['place_type']['sort_key'] = '0';
         $this->fieldspec['place_type']['form_sort_key'] = '0';
         $this->fieldspec['place_type']['form_number'] = '1';
         $this->fieldspec['place_type']['default_value'] = ' ';
         $this->fieldspec['place_type']['field_toupper'] = 'NO';
         $this->fieldspec['place_type']['validationprocname'] = ' ';
         $this->fieldspec['place_type']['c_size'] = '1';
         $this->fieldspec['place_type']['prikey'] = 'N';
         $this->fieldspec['place_type']['noedit'] = 'N';
         $this->fieldspec['place_type']['nodisplay'] = 'N';
         $this->fieldspec['place_type']['c_unsigned'] = 'N';
         $this->fieldspec['place_type']['c_zerofill'] = 'N';
         $this->fieldspec['place_type']['c_auto_increment'] = 'N';
         $this->fieldspec['place_type']['foreign_table'] = ' ';
         $this->fieldspec['place_type']['foreign_key'] = ' ';
         $this->fieldspec['place_type']['application'] = 'statemachine';
         $this->fieldspec['place_type']['issearchable'] = '1';
         $this->fieldspec['place_type']['preinserttrigger'] = ' ';
         $this->fieldspec['place_type']['postinserttrigger'] = ' ';
         $this->fieldspec['place_type']['preupdatetrigger'] = ' ';
         $this->fieldspec['place_type']['postupdatetrigger'] = ' ';
         $this->fieldspec['place_type']['predeletetrigger'] = '';
         $this->fieldspec['place_type']['postdeletetrigger'] = '';
         $this->fieldspec['place_name']['metadata_id'] = '2864';
         $this->fieldspec['place_name']['table_name'] = 'stateplace';
         $this->fieldspec['place_name']['column_name'] = 'place_name';
         $this->fieldspec['place_name']['pretty_name'] = ' ';
         $this->fieldspec['place_name']['abstract_data_type'] = 'varchar';
         $this->fieldspec['place_name']['db_data_type'] = 'varchar';
         $this->fieldspec['place_name']['field_null'] = 'YES';
         $this->fieldspec['place_name']['field_key'] = ' ';
         $this->fieldspec['place_name']['extra_sql'] = ' ';
         $this->fieldspec['place_name']['html_form_type'] = 'varchar';
         $this->fieldspec['place_name']['html_form_options'] = ' ';
         $this->fieldspec['place_name']['html_form_explanation'] = ' ';
         $this->fieldspec['place_name']['help_text'] = ' ';
         $this->fieldspec['place_name']['mandatory_p'] = 'N';
         $this->fieldspec['place_name']['sort_key'] = '0';
         $this->fieldspec['place_name']['form_sort_key'] = '0';
         $this->fieldspec['place_name']['form_number'] = '1';
         $this->fieldspec['place_name']['default_value'] = ' ';
         $this->fieldspec['place_name']['field_toupper'] = 'NO';
         $this->fieldspec['place_name']['validationprocname'] = ' ';
         $this->fieldspec['place_name']['c_size'] = '80';
         $this->fieldspec['place_name']['prikey'] = 'N';
         $this->fieldspec['place_name']['noedit'] = 'N';
         $this->fieldspec['place_name']['nodisplay'] = 'N';
         $this->fieldspec['place_name']['c_unsigned'] = 'N';
         $this->fieldspec['place_name']['c_zerofill'] = 'N';
         $this->fieldspec['place_name']['c_auto_increment'] = 'N';
         $this->fieldspec['place_name']['foreign_table'] = ' ';
         $this->fieldspec['place_name']['foreign_key'] = ' ';
         $this->fieldspec['place_name']['application'] = 'statemachine';
         $this->fieldspec['place_name']['issearchable'] = '1';
         $this->fieldspec['place_name']['preinserttrigger'] = ' ';
         $this->fieldspec['place_name']['postinserttrigger'] = ' ';
         $this->fieldspec['place_name']['preupdatetrigger'] = ' ';
         $this->fieldspec['place_name']['postupdatetrigger'] = ' ';
         $this->fieldspec['place_name']['predeletetrigger'] = '';
         $this->fieldspec['place_name']['postdeletetrigger'] = '';
         $this->fieldspec['place_desc']['metadata_id'] = '2865';
         $this->fieldspec['place_desc']['table_name'] = 'stateplace';
         $this->fieldspec['place_desc']['column_name'] = 'place_desc';
         $this->fieldspec['place_desc']['pretty_name'] = ' ';
         $this->fieldspec['place_desc']['abstract_data_type'] = 'text, ';
         $this->fieldspec['place_desc']['db_data_type'] = 'text';
         $this->fieldspec['place_desc']['field_null'] = 'NO';
         $this->fieldspec['place_desc']['field_key'] = ' ';
         $this->fieldspec['place_desc']['extra_sql'] = ' ';
         $this->fieldspec['place_desc']['html_form_type'] = 'text';
         $this->fieldspec['place_desc']['html_form_options'] = ' ';
         $this->fieldspec['place_desc']['html_form_explanation'] = ' ';
         $this->fieldspec['place_desc']['help_text'] = ' ';
         $this->fieldspec['place_desc']['mandatory_p'] = 'N';
         $this->fieldspec['place_desc']['sort_key'] = '0';
         $this->fieldspec['place_desc']['form_sort_key'] = '0';
         $this->fieldspec['place_desc']['form_number'] = '1';
         $this->fieldspec['place_desc']['default_value'] = ' ';
         $this->fieldspec['place_desc']['field_toupper'] = 'NO';
         $this->fieldspec['place_desc']['validationprocname'] = ' ';
         $this->fieldspec['place_desc']['c_size'] = '';
         $this->fieldspec['place_desc']['prikey'] = 'N';
         $this->fieldspec['place_desc']['noedit'] = 'N';
         $this->fieldspec['place_desc']['nodisplay'] = 'N';
         $this->fieldspec['place_desc']['c_unsigned'] = 'N';
         $this->fieldspec['place_desc']['c_zerofill'] = 'N';
         $this->fieldspec['place_desc']['c_auto_increment'] = 'N';
         $this->fieldspec['place_desc']['foreign_table'] = ' ';
         $this->fieldspec['place_desc']['foreign_key'] = ' ';
         $this->fieldspec['place_desc']['application'] = 'statemachine';
         $this->fieldspec['place_desc']['issearchable'] = '1';
         $this->fieldspec['place_desc']['preinserttrigger'] = ' ';
         $this->fieldspec['place_desc']['postinserttrigger'] = ' ';
         $this->fieldspec['place_desc']['preupdatetrigger'] = ' ';
         $this->fieldspec['place_desc']['postupdatetrigger'] = ' ';
         $this->fieldspec['place_desc']['predeletetrigger'] = '';
         $this->fieldspec['place_desc']['postdeletetrigger'] = '';
         $this->fieldspec['created_date']['metadata_id'] = '2866';
         $this->fieldspec['created_date']['table_name'] = 'stateplace';
         $this->fieldspec['created_date']['column_name'] = 'created_date';
         $this->fieldspec['created_date']['pretty_name'] = ' ';
         $this->fieldspec['created_date']['abstract_data_type'] = 'datetime';
         $this->fieldspec['created_date']['db_data_type'] = 'datetime';
         $this->fieldspec['created_date']['field_null'] = 'YES';
         $this->fieldspec['created_date']['field_key'] = ' ';
         $this->fieldspec['created_date']['extra_sql'] = ' ';
         $this->fieldspec['created_date']['html_form_type'] = 'currentdate';
         $this->fieldspec['created_date']['html_form_options'] = ' ';
         $this->fieldspec['created_date']['html_form_explanation'] = ' ';
         $this->fieldspec['created_date']['help_text'] = ' ';
         $this->fieldspec['created_date']['mandatory_p'] = 'N';
         $this->fieldspec['created_date']['sort_key'] = '0';
         $this->fieldspec['created_date']['form_sort_key'] = '0';
         $this->fieldspec['created_date']['form_number'] = '1';
         $this->fieldspec['created_date']['default_value'] = ' ';
         $this->fieldspec['created_date']['field_toupper'] = 'NO';
         $this->fieldspec['created_date']['validationprocname'] = ' ';
         $this->fieldspec['created_date']['c_size'] = '';
         $this->fieldspec['created_date']['prikey'] = 'N';
         $this->fieldspec['created_date']['noedit'] = 'Y';
         $this->fieldspec['created_date']['nodisplay'] = 'Y';
         $this->fieldspec['created_date']['c_unsigned'] = 'N';
         $this->fieldspec['created_date']['c_zerofill'] = 'N';
         $this->fieldspec['created_date']['c_auto_increment'] = 'N';
         $this->fieldspec['created_date']['foreign_table'] = ' ';
         $this->fieldspec['created_date']['foreign_key'] = ' ';
         $this->fieldspec['created_date']['application'] = 'statemachine';
         $this->fieldspec['created_date']['issearchable'] = '1';
         $this->fieldspec['created_date']['preinserttrigger'] = ' ';
         $this->fieldspec['created_date']['postinserttrigger'] = ' ';
         $this->fieldspec['created_date']['preupdatetrigger'] = ' ';
         $this->fieldspec['created_date']['postupdatetrigger'] = ' ';
         $this->fieldspec['created_date']['predeletetrigger'] = '';
         $this->fieldspec['created_date']['postdeletetrigger'] = '';
         $this->fieldspec['created_user']['metadata_id'] = '2867';
         $this->fieldspec['created_user']['table_name'] = 'stateplace';
         $this->fieldspec['created_user']['column_name'] = 'created_user';
         $this->fieldspec['created_user']['pretty_name'] = ' ';
         $this->fieldspec['created_user']['abstract_data_type'] = 'varchar';
         $this->fieldspec['created_user']['db_data_type'] = 'varchar';
         $this->fieldspec['created_user']['field_null'] = 'NO';
         $this->fieldspec['created_user']['field_key'] = ' ';
         $this->fieldspec['created_user']['extra_sql'] = ' ';
         $this->fieldspec['created_user']['html_form_type'] = 'currentuser';
         $this->fieldspec['created_user']['html_form_options'] = '<fk><field>username</field></fk>';
         $this->fieldspec['created_user']['html_form_explanation'] = ' ';
         $this->fieldspec['created_user']['help_text'] = ' ';
         $this->fieldspec['created_user']['mandatory_p'] = 'N';
         $this->fieldspec['created_user']['sort_key'] = '0';
         $this->fieldspec['created_user']['form_sort_key'] = '0';
         $this->fieldspec['created_user']['form_number'] = '1';
         $this->fieldspec['created_user']['default_value'] = ' ';
         $this->fieldspec['created_user']['field_toupper'] = 'NO';
         $this->fieldspec['created_user']['validationprocname'] = ' ';
         $this->fieldspec['created_user']['c_size'] = '16';
         $this->fieldspec['created_user']['prikey'] = 'N';
         $this->fieldspec['created_user']['noedit'] = 'Y';
         $this->fieldspec['created_user']['nodisplay'] = 'Y';
         $this->fieldspec['created_user']['c_unsigned'] = 'N';
         $this->fieldspec['created_user']['c_zerofill'] = 'N';
         $this->fieldspec['created_user']['c_auto_increment'] = 'N';
         $this->fieldspec['created_user']['foreign_table'] = 'users';
         $this->fieldspec['created_user']['foreign_key'] = 'username';
         $this->fieldspec['created_user']['application'] = 'statemachine';
         $this->fieldspec['created_user']['issearchable'] = '1';
         $this->fieldspec['created_user']['preinserttrigger'] = ' ';
         $this->fieldspec['created_user']['postinserttrigger'] = ' ';
         $this->fieldspec['created_user']['preupdatetrigger'] = ' ';
         $this->fieldspec['created_user']['postupdatetrigger'] = ' ';
         $this->fieldspec['created_user']['predeletetrigger'] = '';
         $this->fieldspec['created_user']['postdeletetrigger'] = '';
         $this->fieldspec['revised_date']['metadata_id'] = '2868';
         $this->fieldspec['revised_date']['table_name'] = 'stateplace';
         $this->fieldspec['revised_date']['column_name'] = 'revised_date';
         $this->fieldspec['revised_date']['pretty_name'] = ' ';
         $this->fieldspec['revised_date']['abstract_data_type'] = 'datetime';
         $this->fieldspec['revised_date']['db_data_type'] = 'datetime';
         $this->fieldspec['revised_date']['field_null'] = 'NO';
         $this->fieldspec['revised_date']['field_key'] = ' ';
         $this->fieldspec['revised_date']['extra_sql'] = ' ';
         $this->fieldspec['revised_date']['html_form_type'] = 'currentdate';
         $this->fieldspec['revised_date']['html_form_options'] = ' ';
         $this->fieldspec['revised_date']['html_form_explanation'] = ' ';
         $this->fieldspec['revised_date']['help_text'] = ' ';
         $this->fieldspec['revised_date']['mandatory_p'] = 'N';
         $this->fieldspec['revised_date']['sort_key'] = '0';
         $this->fieldspec['revised_date']['form_sort_key'] = '0';
         $this->fieldspec['revised_date']['form_number'] = '1';
         $this->fieldspec['revised_date']['default_value'] = ' ';
         $this->fieldspec['revised_date']['field_toupper'] = 'NO';
         $this->fieldspec['revised_date']['validationprocname'] = ' ';
         $this->fieldspec['revised_date']['c_size'] = '';
         $this->fieldspec['revised_date']['prikey'] = 'N';
         $this->fieldspec['revised_date']['noedit'] = 'Y';
         $this->fieldspec['revised_date']['nodisplay'] = 'Y';
         $this->fieldspec['revised_date']['c_unsigned'] = 'N';
         $this->fieldspec['revised_date']['c_zerofill'] = 'N';
         $this->fieldspec['revised_date']['c_auto_increment'] = 'N';
         $this->fieldspec['revised_date']['foreign_table'] = ' ';
         $this->fieldspec['revised_date']['foreign_key'] = ' ';
         $this->fieldspec['revised_date']['application'] = 'statemachine';
         $this->fieldspec['revised_date']['issearchable'] = '1';
         $this->fieldspec['revised_date']['preinserttrigger'] = ' ';
         $this->fieldspec['revised_date']['postinserttrigger'] = ' ';
         $this->fieldspec['revised_date']['preupdatetrigger'] = ' ';
         $this->fieldspec['revised_date']['postupdatetrigger'] = ' ';
         $this->fieldspec['revised_date']['predeletetrigger'] = '';
         $this->fieldspec['revised_date']['postdeletetrigger'] = '';
         $this->fieldspec['revised_user']['metadata_id'] = '2869';
         $this->fieldspec['revised_user']['table_name'] = 'stateplace';
         $this->fieldspec['revised_user']['column_name'] = 'revised_user';
         $this->fieldspec['revised_user']['pretty_name'] = ' ';
         $this->fieldspec['revised_user']['abstract_data_type'] = 'varchar';
         $this->fieldspec['revised_user']['db_data_type'] = 'varchar';
         $this->fieldspec['revised_user']['field_null'] = 'NO';
         $this->fieldspec['revised_user']['field_key'] = ' ';
         $this->fieldspec['revised_user']['extra_sql'] = ' ';
         $this->fieldspec['revised_user']['html_form_type'] = 'currentuser';
         $this->fieldspec['revised_user']['html_form_options'] = '<fk><field>username</field></fk>';
         $this->fieldspec['revised_user']['html_form_explanation'] = ' ';
         $this->fieldspec['revised_user']['help_text'] = ' ';
         $this->fieldspec['revised_user']['mandatory_p'] = 'N';
         $this->fieldspec['revised_user']['sort_key'] = '0';
         $this->fieldspec['revised_user']['form_sort_key'] = '0';
         $this->fieldspec['revised_user']['form_number'] = '1';
         $this->fieldspec['revised_user']['default_value'] = ' ';
         $this->fieldspec['revised_user']['field_toupper'] = 'NO';
         $this->fieldspec['revised_user']['validationprocname'] = ' ';
         $this->fieldspec['revised_user']['c_size'] = '16';
         $this->fieldspec['revised_user']['prikey'] = 'N';
         $this->fieldspec['revised_user']['noedit'] = 'Y';
         $this->fieldspec['revised_user']['nodisplay'] = 'Y';
         $this->fieldspec['revised_user']['c_unsigned'] = 'N';
         $this->fieldspec['revised_user']['c_zerofill'] = 'N';
         $this->fieldspec['revised_user']['c_auto_increment'] = 'N';
         $this->fieldspec['revised_user']['foreign_table'] = 'users';
         $this->fieldspec['revised_user']['foreign_key'] = 'username';
         $this->fieldspec['revised_user']['application'] = 'statemachine';
         $this->fieldspec['revised_user']['issearchable'] = '1';
         $this->fieldspec['revised_user']['preinserttrigger'] = ' ';
         $this->fieldspec['revised_user']['postinserttrigger'] = ' ';
         $this->fieldspec['revised_user']['preupdatetrigger'] = ' ';
         $this->fieldspec['revised_user']['postupdatetrigger'] = ' ';
         $this->fieldspec['revised_user']['predeletetrigger'] = '';
         $this->fieldspec['revised_user']['postdeletetrigger'] = '';
         $this->fieldlist = array('workflow_id', 'place_id', 'place_type', 'place_name', 'place_desc', 'created_date', 'created_user', 'revised_date', 'revised_user');
         $this->searchlist = array('workflow_id', 'place_id', 'place_type', 'place_name', 'place_desc', 'created_date', 'created_user', 'revised_date', 'revised_user');
	         return SUCCESS;
         }
         function stateplace()
         { //For older php which doesn't have constructor
              return $this->__constructor();
         }
         function Push()
         {
	         $_SESSION['stateplace'] = serialize($this);
	         return SUCCESS;
         }
         function Pop()
         {
                 //Can't do this in self - this is how to do it outside
	       //  $this = unserialize($_SESSION['stateplace']);
	         return SUCCESS;
         }
         function ObserverRegister( $observer)
         {
                 $this->observers[] = $observer;
	         return SUCCESS;
         }
         function ObserverDeRegister( $observer )
         {
                 $this->observers[] = array_diff( $this->observers, array( $observer) );
	         return SUCCESS;
         }
         function ObserverNotify()
         {
                 foreach ( $this->observers as $obs ) 
                 {
                      $obs->update( $this );
                 }
	         return SUCCESS;
         }
         function Setrevised_user($value)
         {
                  $this->fieldspec['revised_user']['VALUE'] = $value;
	          return SUCCESS;
         }
         function Getrevised_user()
         {
                    return $this->fieldspec['revised_user']['VALUE'];
         }
         function Validaterevised_user()
         {
         }
} /* class stateplace */