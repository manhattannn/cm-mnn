<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from xml/schema/CRM/Core/PrevNextCache.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:af3cb54c291525d39547cefa9bddf11a)
 */

/**
 * Database access object for the PrevNextCache entity.
 */
class CRM_Core_DAO_PrevNextCache extends CRM_Core_DAO {
  const EXT = 'civicrm';
  const TABLE_ADDED = '3.4';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_prevnext_cache';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = FALSE;

  /**
   * @var int
   */
  public $id;

  /**
   * physical tablename for entity being joined to discount, e.g. civicrm_event
   *
   * @var string
   */
  public $entity_table;

  /**
   * FK to entity table specified in entity_table column.
   *
   * @var int
   */
  public $entity_id1;

  /**
   * FK to entity table specified in entity_table column.
   *
   * @var int
   */
  public $entity_id2;

  /**
   * Unique path name for cache element of the searched item
   *
   * @var string
   */
  public $cachekey;

  /**
   * cached snapshot of the serialized data
   *
   * @var longtext
   */
  public $data;

  /**
   * @var bool
   */
  public $is_selected;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_prevnext_cache';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? ts('Prev Next Caches') : ts('Prev Next Cache');
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
          'title' => ts('Prev Next Cache ID'),
          'required' => TRUE,
          'where' => 'civicrm_prevnext_cache.id',
          'table_name' => 'civicrm_prevnext_cache',
          'entity' => 'PrevNextCache',
          'bao' => 'CRM_Core_BAO_PrevNextCache',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => '3.4',
        ],
        'entity_table' => [
          'name' => 'entity_table',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Prev Next Entity Table'),
          'description' => ts('physical tablename for entity being joined to discount, e.g. civicrm_event'),
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'where' => 'civicrm_prevnext_cache.entity_table',
          'table_name' => 'civicrm_prevnext_cache',
          'entity' => 'PrevNextCache',
          'bao' => 'CRM_Core_BAO_PrevNextCache',
          'localizable' => 0,
          'add' => '3.4',
        ],
        'entity_id1' => [
          'name' => 'entity_id1',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Prev Next Entity ID 1'),
          'description' => ts('FK to entity table specified in entity_table column.'),
          'required' => TRUE,
          'where' => 'civicrm_prevnext_cache.entity_id1',
          'table_name' => 'civicrm_prevnext_cache',
          'entity' => 'PrevNextCache',
          'bao' => 'CRM_Core_BAO_PrevNextCache',
          'localizable' => 0,
          'add' => '3.4',
        ],
        'entity_id2' => [
          'name' => 'entity_id2',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Prev Next Entity ID 2'),
          'description' => ts('FK to entity table specified in entity_table column.'),
          'required' => FALSE,
          'where' => 'civicrm_prevnext_cache.entity_id2',
          'table_name' => 'civicrm_prevnext_cache',
          'entity' => 'PrevNextCache',
          'bao' => 'CRM_Core_BAO_PrevNextCache',
          'localizable' => 0,
          'add' => '3.4',
        ],
        'cachekey' => [
          'name' => 'cachekey',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Cache Key'),
          'description' => ts('Unique path name for cache element of the searched item'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_prevnext_cache.cachekey',
          'table_name' => 'civicrm_prevnext_cache',
          'entity' => 'PrevNextCache',
          'bao' => 'CRM_Core_BAO_PrevNextCache',
          'localizable' => 0,
          'add' => '3.4',
        ],
        'data' => [
          'name' => 'data',
          'type' => CRM_Utils_Type::T_LONGTEXT,
          'title' => ts('Prev Next Data'),
          'description' => ts('cached snapshot of the serialized data'),
          'where' => 'civicrm_prevnext_cache.data',
          'table_name' => 'civicrm_prevnext_cache',
          'entity' => 'PrevNextCache',
          'bao' => 'CRM_Core_BAO_PrevNextCache',
          'localizable' => 0,
          'serialize' => self::SERIALIZE_PHP,
          'add' => '3.4',
        ],
        'is_selected' => [
          'name' => 'is_selected',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is Selected'),
          'where' => 'civicrm_prevnext_cache.is_selected',
          'default' => '0',
          'table_name' => 'civicrm_prevnext_cache',
          'entity' => 'PrevNextCache',
          'bao' => 'CRM_Core_BAO_PrevNextCache',
          'localizable' => 0,
          'add' => '4.2',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'prevnext_cache', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'prevnext_cache', $prefix, []);
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
      'index_all' => [
        'name' => 'index_all',
        'field' => [
          0 => 'cachekey',
          1 => 'entity_id1',
          2 => 'entity_id2',
          3 => 'entity_table',
          4 => 'is_selected',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_prevnext_cache::0::cachekey::entity_id1::entity_id2::entity_table::is_selected',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
