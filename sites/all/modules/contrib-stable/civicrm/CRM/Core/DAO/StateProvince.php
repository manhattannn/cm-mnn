<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 *
 * Generated from xml/schema/CRM/Core/StateProvince.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:66bbfa3f81cb6baec8d7175f5f32718a)
 */

/**
 * Database access object for the StateProvince entity.
 */
class CRM_Core_DAO_StateProvince extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_state_province';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = FALSE;

  /**
   * State/Province ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * Name of State/Province
   *
   * @var string
   */
  public $name;

  /**
   * 2-4 Character Abbreviation of State/Province
   *
   * @var string
   */
  public $abbreviation;

  /**
   * ID of Country that State/Province belong
   *
   * @var int unsigned
   */
  public $country_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_state_province';
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'country_id', 'civicrm_country', 'id');
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
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('State ID'),
          'description' => ts('State/Province ID'),
          'required' => TRUE,
          'table_name' => 'civicrm_state_province',
          'entity' => 'StateProvince',
          'bao' => 'CRM_Core_DAO_StateProvince',
          'localizable' => 0,
        ],
        'name' => [
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('State'),
          'description' => ts('Name of State/Province'),
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'import' => TRUE,
          'where' => 'civicrm_state_province.name',
          'headerPattern' => '/state|prov(ince)?/i',
          'dataPattern' => '/[A-Z]{2}/',
          'export' => TRUE,
          'table_name' => 'civicrm_state_province',
          'entity' => 'StateProvince',
          'bao' => 'CRM_Core_DAO_StateProvince',
          'localizable' => 0,
        ],
        'abbreviation' => [
          'name' => 'abbreviation',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('State Abbreviation'),
          'description' => ts('2-4 Character Abbreviation of State/Province'),
          'maxlength' => 4,
          'size' => CRM_Utils_Type::FOUR,
          'table_name' => 'civicrm_state_province',
          'entity' => 'StateProvince',
          'bao' => 'CRM_Core_DAO_StateProvince',
          'localizable' => 0,
        ],
        'country_id' => [
          'name' => 'country_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Country'),
          'description' => ts('ID of Country that State/Province belong'),
          'required' => TRUE,
          'table_name' => 'civicrm_state_province',
          'entity' => 'StateProvince',
          'bao' => 'CRM_Core_DAO_StateProvince',
          'localizable' => 0,
          'FKClassName' => 'CRM_Core_DAO_Country',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'state_province', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'state_province', $prefix, []);
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
      'UI_name_country_id' => [
        'name' => 'UI_name_country_id',
        'field' => [
          0 => 'name',
          1 => 'country_id',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_state_province::1::name::country_id',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
