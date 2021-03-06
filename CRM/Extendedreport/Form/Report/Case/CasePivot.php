<?php

class CRM_Extendedreport_Form_Report_Case_CasePivot extends CRM_Extendedreport_Form_Report_ExtendedReport {
  protected $_baseTable = 'civicrm_case';
  protected $skipACL = FALSE;
  protected $_skipACLContactDeletedClause = TRUE;
  protected $_customGroupAggregates = true;
  protected $_aggregatesIncludeNULL = TRUE;
  protected $_aggregatesAddTotal = TRUE;
  protected $_aggregatesAddPercentage = TRUE;
  protected $_rollup = 'WITH ROLLUP';
  public $_drilldownReport = array();
  protected $_potentialCriteria = array(
  );

  function __construct() {
    $this->_customGroupExtended['civicrm_case'] = array(
      'extends' => array('Case'),
      'filters' => TRUE,
      'title'  => ts('Case'),
    );

    $this->_columns = $this->getColumns('Case', array(
      'fields' => false,)
    )
    + $this->getColumns('Contact', array());
    $this->_columns['civicrm_case']['fields']['id']['required'] = true;
    $this->_columns['civicrm_contact']['fields']['id']['required'] = true;
 //  $this->_columns['civicrm_case']['fields']['id']['alter_display'] = 'alterCaseID';
    $this->_columns['civicrm_case']['fields']['id']['title'] = 'Case';
    $this->_columns['civicrm_contact']['fields']['gender_id']['no_display'] = true;
    $this->_columns['civicrm_contact']['fields']['gender_id']['title'] = 'Gender';
    $this->_columns['civicrm_contact']['fields']['gender_id']['alter_display'] = 'alterGenderID';
    $this->_columns['civicrm_case']['fields']['case_status_id']['title'] = ts('Case Status');
    $this->_columns['civicrm_case']['fields']['case_status_id']['options'] = CRM_Case_BAO_Case::buildOptions('status_id');
    $this->_columns['civicrm_contact']['fields']['case_status_id']['no_display'] = true;
    $this->_columns['civicrm_case']['fields']['case_status_id']['name'] = 'status_id';
    $this->_columns['civicrm_case']['filters']['case_is_deleted']['default'] = 0;


    $this->_aggregateRowFields  = array(
      'case_civireport:id' => 'Case',
      'case_civireport:case_status_id' => 'Case Status',
      'civicrm_contact_civireport:gender_id' => 'Gender',
    );
    $this->_aggregateColumnHeaderFields  = array(
      'civicrm_contact_civireport:gender_id' => 'Gender',
      'case_civireport:case_status_id' => 'Case Status',
    );
    $this->_tagFilter = TRUE;
    $this->_groupFilter = TRUE;
    parent::__construct();
  }

  function fromClauses( ) {
    return array(
      'contact_from_case',
    );
  }
}
