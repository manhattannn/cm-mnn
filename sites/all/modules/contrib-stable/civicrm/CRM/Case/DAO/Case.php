<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 *
 * Generated from xml/schema/CRM/Case/Case.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:c5896e4b577b32d8a2c62d3cba65119d)
 */

/**
 * Database access object for the Case entity.
 */
class CRM_Case_DAO_Case extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_case';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique Case ID
   *
   * @var int
   */
  public $id;

  /**
   * FK to civicrm_case_type.id
   *
   * @var int
   */
  public $case_type_id;

  /**
   * Short name of the case.
   *
   * @var string
   */
  public $subject;

  /**
   * Date on which given case starts.
   *
   * @var date
   */
  public $start_date;

  /**
   * Date on which given case ends.
   *
   * @var date
   */
  public $end_date;

  /**
   * Details about the meeting (agenda, notes, etc).
   *
   * @var text
   */
  public $details;

  /**
   * Id of case status.
   *
   * @var int
   */
  public $status_id;

  /**
   * @var bool
   */
  public $is_deleted;

  /**
   * When was the case was created.
   *
   * @var timestamp
   */
  public $created_date;

  /**
   * When was the case (or closely related entity) was created or modified or deleted.
   *
   * @var timestamp
   */
  public $modified_date;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_case';
    parent::__construct();
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'case_type_id', 'civicrm_case_type', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'case_id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Case ID'),
          'description' => ts('Unique Case ID'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_case.id',
          'export' => TRUE,
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
        ],
        'case_type_id' => [
          'name' => 'case_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Case Type'),
          'description' => ts('FK to civicrm_case_type.id'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_case.case_type_id',
          'export' => FALSE,
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
          'FKClassName' => 'CRM_Case_DAO_CaseType',
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_case_type',
            'keyColumn' => 'id',
            'labelColumn' => 'title',
          ],
        ],
        'case_subject' => [
          'name' => 'subject',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Case Subject'),
          'description' => ts('Short name of the case.'),
          'maxlength' => 128,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_case.subject',
          'export' => TRUE,
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'case_start_date' => [
          'name' => 'start_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Case Start Date'),
          'description' => ts('Date on which given case starts.'),
          'import' => TRUE,
          'where' => 'civicrm_case.start_date',
          'export' => TRUE,
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDateTime',
          ],
        ],
        'case_end_date' => [
          'name' => 'end_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Case End Date'),
          'description' => ts('Date on which given case ends.'),
          'import' => TRUE,
          'where' => 'civicrm_case.end_date',
          'export' => TRUE,
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDateTime',
          ],
        ],
        'details' => [
          'name' => 'details',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Details'),
          'description' => ts('Details about the meeting (agenda, notes, etc).'),
          'rows' => 8,
          'cols' => 60,
          'where' => 'civicrm_case.details',
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
        ],
        'case_status_id' => [
          'name' => 'status_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Case Status'),
          'description' => ts('Id of case status.'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_case.status_id',
          'export' => FALSE,
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'case_status',
            'optionEditPath' => 'civicrm/admin/options/case_status',
          ],
        ],
        'case_deleted' => [
          'name' => 'is_deleted',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Case is in the Trash'),
          'import' => TRUE,
          'where' => 'civicrm_case.is_deleted',
          'export' => TRUE,
          'default' => '0',
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
        ],
        'case_created_date' => [
          'name' => 'created_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => ts('Created Date'),
          'description' => ts('When was the case was created.'),
          'required' => FALSE,
          'where' => 'civicrm_case.created_date',
          'export' => TRUE,
          'default' => 'NULL',
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
        ],
        'case_modified_date' => [
          'name' => 'modified_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => ts('Modified Date'),
          'description' => ts('When was the case (or closely related entity) was created or modified or deleted.'),
          'required' => FALSE,
          'where' => 'civicrm_case.modified_date',
          'export' => TRUE,
          'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
          'table_name' => 'civicrm_case',
          'entity' => 'Case',
          'bao' => 'CRM_Case_BAO_Case',
          'localizable' => 0,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'case', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'case', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [
      'index_case_type_id' => [
        'name' => 'index_case_type_id',
        'field' => [
          0 => 'case_type_id',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_case::0::case_type_id',
      ],
      'index_is_deleted' => [
        'name' => 'index_is_deleted',
        'field' => [
          0 => 'is_deleted',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_case::0::is_deleted',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
