<?php 
//This file was generated by calling php C:\PROGRA~1\APACHE~1\Apache2\htdocs\pos\generator.php statemachine 

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: index.php");
  exit;
}

require_once('stateworkitem.class.inc.php');
class stateworkitem extends generictable{
          private $observers;
         function __constructor()
         {
         $this->querytablename = 'stateworkitem';
         $this->fieldspec['case_id']['metadata_id'] = '2871';
         $this->fieldspec['case_id']['table_name'] = 'stateworkitem';
         $this->fieldspec['case_id']['column_name'] = 'case_id';
         $this->fieldspec['case_id']['pretty_name'] = ' ';
         $this->fieldspec['case_id']['abstract_data_type'] = 'int';
         $this->fieldspec['case_id']['db_data_type'] = 'int';
         $this->fieldspec['case_id']['field_null'] = 'YES';
         $this->fieldspec['case_id']['field_key'] = ' ';
         $this->fieldspec['case_id']['extra_sql'] = ' ';
         $this->fieldspec['case_id']['html_form_type'] = 'fddl';
         $this->fieldspec['case_id']['html_form_options'] = ' ';
         $this->fieldspec['case_id']['html_form_explanation'] = ' ';
         $this->fieldspec['case_id']['help_text'] = ' ';
         $this->fieldspec['case_id']['mandatory_p'] = 'N';
         $this->fieldspec['case_id']['sort_key'] = '0';
         $this->fieldspec['case_id']['form_sort_key'] = '0';
         $this->fieldspec['case_id']['form_number'] = '1';
         $this->fieldspec['case_id']['default_value'] = ' ';
         $this->fieldspec['case_id']['field_toupper'] = 'NO';
         $this->fieldspec['case_id']['validationprocname'] = ' ';
         $this->fieldspec['case_id']['c_size'] = '10';
         $this->fieldspec['case_id']['prikey'] = 'Y';
         $this->fieldspec['case_id']['noedit'] = 'Y';
         $this->fieldspec['case_id']['nodisplay'] = 'N';
         $this->fieldspec['case_id']['c_unsigned'] = 'Y';
         $this->fieldspec['case_id']['c_zerofill'] = 'N';
         $this->fieldspec['case_id']['c_auto_increment'] = 'N';
         $this->fieldspec['case_id']['foreign_table'] = 'statecase';
         $this->fieldspec['case_id']['foreign_key'] = 'case_id';
         $this->fieldspec['case_id']['application'] = 'statemachine';
         $this->fieldspec['case_id']['issearchable'] = '1';
         $this->fieldspec['case_id']['preinserttrigger'] = ' ';
         $this->fieldspec['case_id']['postinserttrigger'] = ' ';
         $this->fieldspec['case_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['case_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['case_id']['predeletetrigger'] = '';
         $this->fieldspec['case_id']['postdeletetrigger'] = '';
         $this->fieldspec['workitem_id']['metadata_id'] = '2872';
         $this->fieldspec['workitem_id']['table_name'] = 'stateworkitem';
         $this->fieldspec['workitem_id']['column_name'] = 'workitem_id';
         $this->fieldspec['workitem_id']['pretty_name'] = ' ';
         $this->fieldspec['workitem_id']['abstract_data_type'] = 'smallint';
         $this->fieldspec['workitem_id']['db_data_type'] = 'smallint';
         $this->fieldspec['workitem_id']['field_null'] = 'YES';
         $this->fieldspec['workitem_id']['field_key'] = ' ';
         $this->fieldspec['workitem_id']['extra_sql'] = ' ';
         $this->fieldspec['workitem_id']['html_form_type'] = 'smallint';
         $this->fieldspec['workitem_id']['html_form_options'] = ' ';
         $this->fieldspec['workitem_id']['html_form_explanation'] = ' ';
         $this->fieldspec['workitem_id']['help_text'] = ' ';
         $this->fieldspec['workitem_id']['mandatory_p'] = 'N';
         $this->fieldspec['workitem_id']['sort_key'] = '0';
         $this->fieldspec['workitem_id']['form_sort_key'] = '0';
         $this->fieldspec['workitem_id']['form_number'] = '1';
         $this->fieldspec['workitem_id']['default_value'] = ' ';
         $this->fieldspec['workitem_id']['field_toupper'] = 'NO';
         $this->fieldspec['workitem_id']['validationprocname'] = ' ';
         $this->fieldspec['workitem_id']['c_size'] = '5';
         $this->fieldspec['workitem_id']['prikey'] = 'Y';
         $this->fieldspec['workitem_id']['noedit'] = 'Y';
         $this->fieldspec['workitem_id']['nodisplay'] = 'N';
         $this->fieldspec['workitem_id']['c_unsigned'] = 'Y';
         $this->fieldspec['workitem_id']['c_zerofill'] = 'N';
         $this->fieldspec['workitem_id']['c_auto_increment'] = 'N';
         $this->fieldspec['workitem_id']['foreign_table'] = ' ';
         $this->fieldspec['workitem_id']['foreign_key'] = ' ';
         $this->fieldspec['workitem_id']['application'] = 'statemachine';
         $this->fieldspec['workitem_id']['issearchable'] = '1';
         $this->fieldspec['workitem_id']['preinserttrigger'] = ' ';
         $this->fieldspec['workitem_id']['postinserttrigger'] = ' ';
         $this->fieldspec['workitem_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['workitem_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['workitem_id']['predeletetrigger'] = '';
         $this->fieldspec['workitem_id']['postdeletetrigger'] = '';
         $this->fieldspec['workflow_id']['metadata_id'] = '2873';
         $this->fieldspec['workflow_id']['table_name'] = 'stateworkitem';
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
         $this->fieldspec['workflow_id']['c_size'] = '6';
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
         $this->fieldspec['transition_id']['metadata_id'] = '2874';
         $this->fieldspec['transition_id']['table_name'] = 'stateworkitem';
         $this->fieldspec['transition_id']['column_name'] = 'transition_id';
         $this->fieldspec['transition_id']['pretty_name'] = ' ';
         $this->fieldspec['transition_id']['abstract_data_type'] = 'smallint';
         $this->fieldspec['transition_id']['db_data_type'] = 'smallint';
         $this->fieldspec['transition_id']['field_null'] = 'YES';
         $this->fieldspec['transition_id']['field_key'] = ' ';
         $this->fieldspec['transition_id']['extra_sql'] = ' ';
         $this->fieldspec['transition_id']['html_form_type'] = 'fddl';
         $this->fieldspec['transition_id']['html_form_options'] = '<fk><field>transition_name</field></fk>';
         $this->fieldspec['transition_id']['html_form_explanation'] = ' ';
         $this->fieldspec['transition_id']['help_text'] = ' ';
         $this->fieldspec['transition_id']['mandatory_p'] = 'N';
         $this->fieldspec['transition_id']['sort_key'] = '0';
         $this->fieldspec['transition_id']['form_sort_key'] = '0';
         $this->fieldspec['transition_id']['form_number'] = '1';
         $this->fieldspec['transition_id']['default_value'] = ' ';
         $this->fieldspec['transition_id']['field_toupper'] = 'NO';
         $this->fieldspec['transition_id']['validationprocname'] = ' ';
         $this->fieldspec['transition_id']['c_size'] = '5';
         $this->fieldspec['transition_id']['prikey'] = 'N';
         $this->fieldspec['transition_id']['noedit'] = 'N';
         $this->fieldspec['transition_id']['nodisplay'] = 'N';
         $this->fieldspec['transition_id']['c_unsigned'] = 'Y';
         $this->fieldspec['transition_id']['c_zerofill'] = 'N';
         $this->fieldspec['transition_id']['c_auto_increment'] = 'N';
         $this->fieldspec['transition_id']['foreign_table'] = 'statetransition';
         $this->fieldspec['transition_id']['foreign_key'] = 'transition_id';
         $this->fieldspec['transition_id']['application'] = 'statemachine';
         $this->fieldspec['transition_id']['issearchable'] = '1';
         $this->fieldspec['transition_id']['preinserttrigger'] = ' ';
         $this->fieldspec['transition_id']['postinserttrigger'] = ' ';
         $this->fieldspec['transition_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['transition_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['transition_id']['predeletetrigger'] = '';
         $this->fieldspec['transition_id']['postdeletetrigger'] = '';
         $this->fieldspec['transition_trigger']['metadata_id'] = '2875';
         $this->fieldspec['transition_trigger']['table_name'] = 'stateworkitem';
         $this->fieldspec['transition_trigger']['column_name'] = 'transition_trigger';
         $this->fieldspec['transition_trigger']['pretty_name'] = ' ';
         $this->fieldspec['transition_trigger']['abstract_data_type'] = 'varchar';
         $this->fieldspec['transition_trigger']['db_data_type'] = 'varchar';
         $this->fieldspec['transition_trigger']['field_null'] = 'YES';
         $this->fieldspec['transition_trigger']['field_key'] = ' ';
         $this->fieldspec['transition_trigger']['extra_sql'] = ' ';
         $this->fieldspec['transition_trigger']['html_form_type'] = 'varchar';
         $this->fieldspec['transition_trigger']['html_form_options'] = ' ';
         $this->fieldspec['transition_trigger']['html_form_explanation'] = ' ';
         $this->fieldspec['transition_trigger']['help_text'] = ' ';
         $this->fieldspec['transition_trigger']['mandatory_p'] = 'N';
         $this->fieldspec['transition_trigger']['sort_key'] = '0';
         $this->fieldspec['transition_trigger']['form_sort_key'] = '0';
         $this->fieldspec['transition_trigger']['form_number'] = '1';
         $this->fieldspec['transition_trigger']['default_value'] = ' ';
         $this->fieldspec['transition_trigger']['field_toupper'] = 'NO';
         $this->fieldspec['transition_trigger']['validationprocname'] = ' ';
         $this->fieldspec['transition_trigger']['c_size'] = '4';
         $this->fieldspec['transition_trigger']['prikey'] = 'N';
         $this->fieldspec['transition_trigger']['noedit'] = 'N';
         $this->fieldspec['transition_trigger']['nodisplay'] = 'N';
         $this->fieldspec['transition_trigger']['c_unsigned'] = 'N';
         $this->fieldspec['transition_trigger']['c_zerofill'] = 'N';
         $this->fieldspec['transition_trigger']['c_auto_increment'] = 'N';
         $this->fieldspec['transition_trigger']['foreign_table'] = ' ';
         $this->fieldspec['transition_trigger']['foreign_key'] = ' ';
         $this->fieldspec['transition_trigger']['application'] = 'statemachine';
         $this->fieldspec['transition_trigger']['issearchable'] = '1';
         $this->fieldspec['transition_trigger']['preinserttrigger'] = ' ';
         $this->fieldspec['transition_trigger']['postinserttrigger'] = ' ';
         $this->fieldspec['transition_trigger']['preupdatetrigger'] = ' ';
         $this->fieldspec['transition_trigger']['postupdatetrigger'] = ' ';
         $this->fieldspec['transition_trigger']['predeletetrigger'] = '';
         $this->fieldspec['transition_trigger']['postdeletetrigger'] = '';
         $this->fieldspec['task_id']['metadata_id'] = '2876';
         $this->fieldspec['task_id']['table_name'] = 'stateworkitem';
         $this->fieldspec['task_id']['column_name'] = 'task_id';
         $this->fieldspec['task_id']['pretty_name'] = ' ';
         $this->fieldspec['task_id']['abstract_data_type'] = 'varchar';
         $this->fieldspec['task_id']['db_data_type'] = 'varchar';
         $this->fieldspec['task_id']['field_null'] = 'YES';
         $this->fieldspec['task_id']['field_key'] = ' ';
         $this->fieldspec['task_id']['extra_sql'] = ' ';
         $this->fieldspec['task_id']['html_form_type'] = 'varchar';
         $this->fieldspec['task_id']['html_form_options'] = ' ';
         $this->fieldspec['task_id']['html_form_explanation'] = ' ';
         $this->fieldspec['task_id']['help_text'] = ' ';
         $this->fieldspec['task_id']['mandatory_p'] = 'N';
         $this->fieldspec['task_id']['sort_key'] = '0';
         $this->fieldspec['task_id']['form_sort_key'] = '0';
         $this->fieldspec['task_id']['form_number'] = '1';
         $this->fieldspec['task_id']['default_value'] = ' ';
         $this->fieldspec['task_id']['field_toupper'] = 'NO';
         $this->fieldspec['task_id']['validationprocname'] = ' ';
         $this->fieldspec['task_id']['c_size'] = '40';
         $this->fieldspec['task_id']['prikey'] = 'N';
         $this->fieldspec['task_id']['noedit'] = 'N';
         $this->fieldspec['task_id']['nodisplay'] = 'N';
         $this->fieldspec['task_id']['c_unsigned'] = 'N';
         $this->fieldspec['task_id']['c_zerofill'] = 'N';
         $this->fieldspec['task_id']['c_auto_increment'] = 'N';
         $this->fieldspec['task_id']['foreign_table'] = ' ';
         $this->fieldspec['task_id']['foreign_key'] = ' ';
         $this->fieldspec['task_id']['application'] = 'statemachine';
         $this->fieldspec['task_id']['issearchable'] = '1';
         $this->fieldspec['task_id']['preinserttrigger'] = ' ';
         $this->fieldspec['task_id']['postinserttrigger'] = ' ';
         $this->fieldspec['task_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['task_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['task_id']['predeletetrigger'] = '';
         $this->fieldspec['task_id']['postdeletetrigger'] = '';
         $this->fieldspec['context']['metadata_id'] = '2877';
         $this->fieldspec['context']['table_name'] = 'stateworkitem';
         $this->fieldspec['context']['column_name'] = 'context';
         $this->fieldspec['context']['pretty_name'] = ' ';
         $this->fieldspec['context']['abstract_data_type'] = 'varchar';
         $this->fieldspec['context']['db_data_type'] = 'varchar';
         $this->fieldspec['context']['field_null'] = 'YES';
         $this->fieldspec['context']['field_key'] = ' ';
         $this->fieldspec['context']['extra_sql'] = ' ';
         $this->fieldspec['context']['html_form_type'] = 'varchar';
         $this->fieldspec['context']['html_form_options'] = ' ';
         $this->fieldspec['context']['html_form_explanation'] = ' ';
         $this->fieldspec['context']['help_text'] = ' ';
         $this->fieldspec['context']['mandatory_p'] = 'N';
         $this->fieldspec['context']['sort_key'] = '0';
         $this->fieldspec['context']['form_sort_key'] = '0';
         $this->fieldspec['context']['form_number'] = '1';
         $this->fieldspec['context']['default_value'] = ' ';
         $this->fieldspec['context']['field_toupper'] = 'NO';
         $this->fieldspec['context']['validationprocname'] = ' ';
         $this->fieldspec['context']['c_size'] = '255';
         $this->fieldspec['context']['prikey'] = 'N';
         $this->fieldspec['context']['noedit'] = 'N';
         $this->fieldspec['context']['nodisplay'] = 'N';
         $this->fieldspec['context']['c_unsigned'] = 'N';
         $this->fieldspec['context']['c_zerofill'] = 'N';
         $this->fieldspec['context']['c_auto_increment'] = 'N';
         $this->fieldspec['context']['foreign_table'] = ' ';
         $this->fieldspec['context']['foreign_key'] = ' ';
         $this->fieldspec['context']['application'] = 'statemachine';
         $this->fieldspec['context']['issearchable'] = '1';
         $this->fieldspec['context']['preinserttrigger'] = ' ';
         $this->fieldspec['context']['postinserttrigger'] = ' ';
         $this->fieldspec['context']['preupdatetrigger'] = ' ';
         $this->fieldspec['context']['postupdatetrigger'] = ' ';
         $this->fieldspec['context']['predeletetrigger'] = '';
         $this->fieldspec['context']['postdeletetrigger'] = '';
         $this->fieldspec['workitem_status']['metadata_id'] = '2878';
         $this->fieldspec['workitem_status']['table_name'] = 'stateworkitem';
         $this->fieldspec['workitem_status']['column_name'] = 'workitem_status';
         $this->fieldspec['workitem_status']['pretty_name'] = ' ';
         $this->fieldspec['workitem_status']['abstract_data_type'] = 'char';
         $this->fieldspec['workitem_status']['db_data_type'] = 'char';
         $this->fieldspec['workitem_status']['field_null'] = 'YES';
         $this->fieldspec['workitem_status']['field_key'] = ' ';
         $this->fieldspec['workitem_status']['extra_sql'] = ' ';
         $this->fieldspec['workitem_status']['html_form_type'] = 'char';
         $this->fieldspec['workitem_status']['html_form_options'] = ' ';
         $this->fieldspec['workitem_status']['html_form_explanation'] = ' ';
         $this->fieldspec['workitem_status']['help_text'] = ' ';
         $this->fieldspec['workitem_status']['mandatory_p'] = 'N';
         $this->fieldspec['workitem_status']['sort_key'] = '0';
         $this->fieldspec['workitem_status']['form_sort_key'] = '0';
         $this->fieldspec['workitem_status']['form_number'] = '1';
         $this->fieldspec['workitem_status']['default_value'] = ' ';
         $this->fieldspec['workitem_status']['field_toupper'] = 'NO';
         $this->fieldspec['workitem_status']['validationprocname'] = ' ';
         $this->fieldspec['workitem_status']['c_size'] = '2';
         $this->fieldspec['workitem_status']['prikey'] = 'N';
         $this->fieldspec['workitem_status']['noedit'] = 'N';
         $this->fieldspec['workitem_status']['nodisplay'] = 'N';
         $this->fieldspec['workitem_status']['c_unsigned'] = 'N';
         $this->fieldspec['workitem_status']['c_zerofill'] = 'N';
         $this->fieldspec['workitem_status']['c_auto_increment'] = 'N';
         $this->fieldspec['workitem_status']['foreign_table'] = ' ';
         $this->fieldspec['workitem_status']['foreign_key'] = ' ';
         $this->fieldspec['workitem_status']['application'] = 'statemachine';
         $this->fieldspec['workitem_status']['issearchable'] = '1';
         $this->fieldspec['workitem_status']['preinserttrigger'] = ' ';
         $this->fieldspec['workitem_status']['postinserttrigger'] = ' ';
         $this->fieldspec['workitem_status']['preupdatetrigger'] = ' ';
         $this->fieldspec['workitem_status']['postupdatetrigger'] = ' ';
         $this->fieldspec['workitem_status']['predeletetrigger'] = '';
         $this->fieldspec['workitem_status']['postdeletetrigger'] = '';
         $this->fieldspec['enabled_date']['metadata_id'] = '2879';
         $this->fieldspec['enabled_date']['table_name'] = 'stateworkitem';
         $this->fieldspec['enabled_date']['column_name'] = 'enabled_date';
         $this->fieldspec['enabled_date']['pretty_name'] = ' ';
         $this->fieldspec['enabled_date']['abstract_data_type'] = 'datetime';
         $this->fieldspec['enabled_date']['db_data_type'] = 'datetime';
         $this->fieldspec['enabled_date']['field_null'] = 'NO';
         $this->fieldspec['enabled_date']['field_key'] = ' ';
         $this->fieldspec['enabled_date']['extra_sql'] = ' ';
         $this->fieldspec['enabled_date']['html_form_type'] = 'datetime';
         $this->fieldspec['enabled_date']['html_form_options'] = ' ';
         $this->fieldspec['enabled_date']['html_form_explanation'] = ' ';
         $this->fieldspec['enabled_date']['help_text'] = ' ';
         $this->fieldspec['enabled_date']['mandatory_p'] = 'N';
         $this->fieldspec['enabled_date']['sort_key'] = '0';
         $this->fieldspec['enabled_date']['form_sort_key'] = '0';
         $this->fieldspec['enabled_date']['form_number'] = '1';
         $this->fieldspec['enabled_date']['default_value'] = ' ';
         $this->fieldspec['enabled_date']['field_toupper'] = 'NO';
         $this->fieldspec['enabled_date']['validationprocname'] = ' ';
         $this->fieldspec['enabled_date']['c_size'] = '';
         $this->fieldspec['enabled_date']['prikey'] = 'N';
         $this->fieldspec['enabled_date']['noedit'] = 'N';
         $this->fieldspec['enabled_date']['nodisplay'] = 'N';
         $this->fieldspec['enabled_date']['c_unsigned'] = 'N';
         $this->fieldspec['enabled_date']['c_zerofill'] = 'N';
         $this->fieldspec['enabled_date']['c_auto_increment'] = 'N';
         $this->fieldspec['enabled_date']['foreign_table'] = ' ';
         $this->fieldspec['enabled_date']['foreign_key'] = ' ';
         $this->fieldspec['enabled_date']['application'] = 'statemachine';
         $this->fieldspec['enabled_date']['issearchable'] = '1';
         $this->fieldspec['enabled_date']['preinserttrigger'] = ' ';
         $this->fieldspec['enabled_date']['postinserttrigger'] = ' ';
         $this->fieldspec['enabled_date']['preupdatetrigger'] = ' ';
         $this->fieldspec['enabled_date']['postupdatetrigger'] = ' ';
         $this->fieldspec['enabled_date']['predeletetrigger'] = '';
         $this->fieldspec['enabled_date']['postdeletetrigger'] = '';
         $this->fieldspec['cancelled_date']['metadata_id'] = '2880';
         $this->fieldspec['cancelled_date']['table_name'] = 'stateworkitem';
         $this->fieldspec['cancelled_date']['column_name'] = 'cancelled_date';
         $this->fieldspec['cancelled_date']['pretty_name'] = ' ';
         $this->fieldspec['cancelled_date']['abstract_data_type'] = 'datetime';
         $this->fieldspec['cancelled_date']['db_data_type'] = 'datetime';
         $this->fieldspec['cancelled_date']['field_null'] = 'NO';
         $this->fieldspec['cancelled_date']['field_key'] = ' ';
         $this->fieldspec['cancelled_date']['extra_sql'] = ' ';
         $this->fieldspec['cancelled_date']['html_form_type'] = 'datetime';
         $this->fieldspec['cancelled_date']['html_form_options'] = ' ';
         $this->fieldspec['cancelled_date']['html_form_explanation'] = ' ';
         $this->fieldspec['cancelled_date']['help_text'] = ' ';
         $this->fieldspec['cancelled_date']['mandatory_p'] = 'N';
         $this->fieldspec['cancelled_date']['sort_key'] = '0';
         $this->fieldspec['cancelled_date']['form_sort_key'] = '0';
         $this->fieldspec['cancelled_date']['form_number'] = '1';
         $this->fieldspec['cancelled_date']['default_value'] = ' ';
         $this->fieldspec['cancelled_date']['field_toupper'] = 'NO';
         $this->fieldspec['cancelled_date']['validationprocname'] = ' ';
         $this->fieldspec['cancelled_date']['c_size'] = '';
         $this->fieldspec['cancelled_date']['prikey'] = 'N';
         $this->fieldspec['cancelled_date']['noedit'] = 'N';
         $this->fieldspec['cancelled_date']['nodisplay'] = 'N';
         $this->fieldspec['cancelled_date']['c_unsigned'] = 'N';
         $this->fieldspec['cancelled_date']['c_zerofill'] = 'N';
         $this->fieldspec['cancelled_date']['c_auto_increment'] = 'N';
         $this->fieldspec['cancelled_date']['foreign_table'] = ' ';
         $this->fieldspec['cancelled_date']['foreign_key'] = ' ';
         $this->fieldspec['cancelled_date']['application'] = 'statemachine';
         $this->fieldspec['cancelled_date']['issearchable'] = '1';
         $this->fieldspec['cancelled_date']['preinserttrigger'] = ' ';
         $this->fieldspec['cancelled_date']['postinserttrigger'] = ' ';
         $this->fieldspec['cancelled_date']['preupdatetrigger'] = ' ';
         $this->fieldspec['cancelled_date']['postupdatetrigger'] = ' ';
         $this->fieldspec['cancelled_date']['predeletetrigger'] = '';
         $this->fieldspec['cancelled_date']['postdeletetrigger'] = '';
         $this->fieldspec['finished_date']['metadata_id'] = '2881';
         $this->fieldspec['finished_date']['table_name'] = 'stateworkitem';
         $this->fieldspec['finished_date']['column_name'] = 'finished_date';
         $this->fieldspec['finished_date']['pretty_name'] = ' ';
         $this->fieldspec['finished_date']['abstract_data_type'] = 'datetime';
         $this->fieldspec['finished_date']['db_data_type'] = 'datetime';
         $this->fieldspec['finished_date']['field_null'] = 'NO';
         $this->fieldspec['finished_date']['field_key'] = ' ';
         $this->fieldspec['finished_date']['extra_sql'] = ' ';
         $this->fieldspec['finished_date']['html_form_type'] = 'datetime';
         $this->fieldspec['finished_date']['html_form_options'] = ' ';
         $this->fieldspec['finished_date']['html_form_explanation'] = ' ';
         $this->fieldspec['finished_date']['help_text'] = ' ';
         $this->fieldspec['finished_date']['mandatory_p'] = 'N';
         $this->fieldspec['finished_date']['sort_key'] = '0';
         $this->fieldspec['finished_date']['form_sort_key'] = '0';
         $this->fieldspec['finished_date']['form_number'] = '1';
         $this->fieldspec['finished_date']['default_value'] = ' ';
         $this->fieldspec['finished_date']['field_toupper'] = 'NO';
         $this->fieldspec['finished_date']['validationprocname'] = ' ';
         $this->fieldspec['finished_date']['c_size'] = '';
         $this->fieldspec['finished_date']['prikey'] = 'N';
         $this->fieldspec['finished_date']['noedit'] = 'N';
         $this->fieldspec['finished_date']['nodisplay'] = 'N';
         $this->fieldspec['finished_date']['c_unsigned'] = 'N';
         $this->fieldspec['finished_date']['c_zerofill'] = 'N';
         $this->fieldspec['finished_date']['c_auto_increment'] = 'N';
         $this->fieldspec['finished_date']['foreign_table'] = ' ';
         $this->fieldspec['finished_date']['foreign_key'] = ' ';
         $this->fieldspec['finished_date']['application'] = 'statemachine';
         $this->fieldspec['finished_date']['issearchable'] = '1';
         $this->fieldspec['finished_date']['preinserttrigger'] = ' ';
         $this->fieldspec['finished_date']['postinserttrigger'] = ' ';
         $this->fieldspec['finished_date']['preupdatetrigger'] = ' ';
         $this->fieldspec['finished_date']['postupdatetrigger'] = ' ';
         $this->fieldspec['finished_date']['predeletetrigger'] = '';
         $this->fieldspec['finished_date']['postdeletetrigger'] = '';
         $this->fieldspec['deadline']['metadata_id'] = '2882';
         $this->fieldspec['deadline']['table_name'] = 'stateworkitem';
         $this->fieldspec['deadline']['column_name'] = 'deadline';
         $this->fieldspec['deadline']['pretty_name'] = ' ';
         $this->fieldspec['deadline']['abstract_data_type'] = 'datetime';
         $this->fieldspec['deadline']['db_data_type'] = 'datetime';
         $this->fieldspec['deadline']['field_null'] = 'NO';
         $this->fieldspec['deadline']['field_key'] = ' ';
         $this->fieldspec['deadline']['extra_sql'] = ' ';
         $this->fieldspec['deadline']['html_form_type'] = 'datetime';
         $this->fieldspec['deadline']['html_form_options'] = ' ';
         $this->fieldspec['deadline']['html_form_explanation'] = ' ';
         $this->fieldspec['deadline']['help_text'] = ' ';
         $this->fieldspec['deadline']['mandatory_p'] = 'N';
         $this->fieldspec['deadline']['sort_key'] = '0';
         $this->fieldspec['deadline']['form_sort_key'] = '0';
         $this->fieldspec['deadline']['form_number'] = '1';
         $this->fieldspec['deadline']['default_value'] = ' ';
         $this->fieldspec['deadline']['field_toupper'] = 'NO';
         $this->fieldspec['deadline']['validationprocname'] = ' ';
         $this->fieldspec['deadline']['c_size'] = '';
         $this->fieldspec['deadline']['prikey'] = 'N';
         $this->fieldspec['deadline']['noedit'] = 'N';
         $this->fieldspec['deadline']['nodisplay'] = 'N';
         $this->fieldspec['deadline']['c_unsigned'] = 'N';
         $this->fieldspec['deadline']['c_zerofill'] = 'N';
         $this->fieldspec['deadline']['c_auto_increment'] = 'N';
         $this->fieldspec['deadline']['foreign_table'] = ' ';
         $this->fieldspec['deadline']['foreign_key'] = ' ';
         $this->fieldspec['deadline']['application'] = 'statemachine';
         $this->fieldspec['deadline']['issearchable'] = '1';
         $this->fieldspec['deadline']['preinserttrigger'] = ' ';
         $this->fieldspec['deadline']['postinserttrigger'] = ' ';
         $this->fieldspec['deadline']['preupdatetrigger'] = ' ';
         $this->fieldspec['deadline']['postupdatetrigger'] = ' ';
         $this->fieldspec['deadline']['predeletetrigger'] = '';
         $this->fieldspec['deadline']['postdeletetrigger'] = '';
         $this->fieldspec['role_id']['metadata_id'] = '2883';
         $this->fieldspec['role_id']['table_name'] = 'stateworkitem';
         $this->fieldspec['role_id']['column_name'] = 'role_id';
         $this->fieldspec['role_id']['pretty_name'] = ' ';
         $this->fieldspec['role_id']['abstract_data_type'] = 'varchar';
         $this->fieldspec['role_id']['db_data_type'] = 'varchar';
         $this->fieldspec['role_id']['field_null'] = 'NO';
         $this->fieldspec['role_id']['field_key'] = ' ';
         $this->fieldspec['role_id']['extra_sql'] = ' ';
         $this->fieldspec['role_id']['html_form_type'] = 'fddl';
         $this->fieldspec['role_id']['html_form_options'] = '<fk><field>roledescription</field></fk>';
         $this->fieldspec['role_id']['html_form_explanation'] = ' ';
         $this->fieldspec['role_id']['help_text'] = ' ';
         $this->fieldspec['role_id']['mandatory_p'] = 'N';
         $this->fieldspec['role_id']['sort_key'] = '0';
         $this->fieldspec['role_id']['form_sort_key'] = '0';
         $this->fieldspec['role_id']['form_number'] = '1';
         $this->fieldspec['role_id']['default_value'] = ' ';
         $this->fieldspec['role_id']['field_toupper'] = 'NO';
         $this->fieldspec['role_id']['validationprocname'] = ' ';
         $this->fieldspec['role_id']['c_size'] = '16';
         $this->fieldspec['role_id']['prikey'] = 'N';
         $this->fieldspec['role_id']['noedit'] = 'N';
         $this->fieldspec['role_id']['nodisplay'] = 'N';
         $this->fieldspec['role_id']['c_unsigned'] = 'N';
         $this->fieldspec['role_id']['c_zerofill'] = 'N';
         $this->fieldspec['role_id']['c_auto_increment'] = 'N';
         $this->fieldspec['role_id']['foreign_table'] = 'roles';
         $this->fieldspec['role_id']['foreign_key'] = 'roles_id';
         $this->fieldspec['role_id']['application'] = 'statemachine';
         $this->fieldspec['role_id']['issearchable'] = '1';
         $this->fieldspec['role_id']['preinserttrigger'] = ' ';
         $this->fieldspec['role_id']['postinserttrigger'] = ' ';
         $this->fieldspec['role_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['role_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['role_id']['predeletetrigger'] = '';
         $this->fieldspec['role_id']['postdeletetrigger'] = '';
         $this->fieldspec['user_id']['metadata_id'] = '2884';
         $this->fieldspec['user_id']['table_name'] = 'stateworkitem';
         $this->fieldspec['user_id']['column_name'] = 'user_id';
         $this->fieldspec['user_id']['pretty_name'] = ' ';
         $this->fieldspec['user_id']['abstract_data_type'] = 'varchar';
         $this->fieldspec['user_id']['db_data_type'] = 'varchar';
         $this->fieldspec['user_id']['field_null'] = 'NO';
         $this->fieldspec['user_id']['field_key'] = ' ';
         $this->fieldspec['user_id']['extra_sql'] = ' ';
         $this->fieldspec['user_id']['html_form_type'] = 'varchar';
         $this->fieldspec['user_id']['html_form_options'] = ' ';
         $this->fieldspec['user_id']['html_form_explanation'] = ' ';
         $this->fieldspec['user_id']['help_text'] = ' ';
         $this->fieldspec['user_id']['mandatory_p'] = 'N';
         $this->fieldspec['user_id']['sort_key'] = '0';
         $this->fieldspec['user_id']['form_sort_key'] = '0';
         $this->fieldspec['user_id']['form_number'] = '1';
         $this->fieldspec['user_id']['default_value'] = ' ';
         $this->fieldspec['user_id']['field_toupper'] = 'NO';
         $this->fieldspec['user_id']['validationprocname'] = ' ';
         $this->fieldspec['user_id']['c_size'] = '16';
         $this->fieldspec['user_id']['prikey'] = 'N';
         $this->fieldspec['user_id']['noedit'] = 'N';
         $this->fieldspec['user_id']['nodisplay'] = 'N';
         $this->fieldspec['user_id']['c_unsigned'] = 'N';
         $this->fieldspec['user_id']['c_zerofill'] = 'N';
         $this->fieldspec['user_id']['c_auto_increment'] = 'N';
         $this->fieldspec['user_id']['foreign_table'] = ' ';
         $this->fieldspec['user_id']['foreign_key'] = ' ';
         $this->fieldspec['user_id']['application'] = 'statemachine';
         $this->fieldspec['user_id']['issearchable'] = '1';
         $this->fieldspec['user_id']['preinserttrigger'] = ' ';
         $this->fieldspec['user_id']['postinserttrigger'] = ' ';
         $this->fieldspec['user_id']['preupdatetrigger'] = ' ';
         $this->fieldspec['user_id']['postupdatetrigger'] = ' ';
         $this->fieldspec['user_id']['predeletetrigger'] = '';
         $this->fieldspec['user_id']['postdeletetrigger'] = '';
         $this->fieldlist = array('case_id', 'workitem_id', 'workflow_id', 'transition_id', 'transition_trigger', 'task_id', 'context', 'workitem_status', 'enabled_date', 'cancelled_date', 'finished_date', 'deadline', 'role_id', 'user_id');
         $this->searchlist = array('case_id', 'workitem_id', 'workflow_id', 'transition_id', 'transition_trigger', 'task_id', 'context', 'workitem_status', 'enabled_date', 'cancelled_date', 'finished_date', 'deadline', 'role_id', 'user_id');
	         return SUCCESS;
         }
         function stateworkitem()
         { //For older php which doesn't have constructor
              return $this->__constructor();
         }
         function Push()
         {
	         $_SESSION['stateworkitem'] = serialize($this);
	         return SUCCESS;
         }
         function Pop()
         {
                 //Can't do this in self - this is how to do it outside
	       //  $this = unserialize($_SESSION['stateworkitem']);
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
         function Setuser_id($value)
         {
                  $this->fieldspec['user_id']['VALUE'] = $value;
	          return SUCCESS;
         }
         function Getuser_id()
         {
                    return $this->fieldspec['user_id']['VALUE'];
         }
         function Validateuser_id()
         {
         }
} /* class stateworkitem */
