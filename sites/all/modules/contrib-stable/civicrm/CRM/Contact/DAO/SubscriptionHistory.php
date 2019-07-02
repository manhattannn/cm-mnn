<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 *
 * Generated from xml/schema/CRM/Contact/SubscriptionHistory.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:8051a666011690a9dfb14d91a013a3e0)
 */

/**
 * Database access object for the SubscriptionHistory entity.
 */
class CRM_Contact_DAO_SubscriptionHistory extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_subscription_history';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Internal Id
   *
   * @var int unsigned
   */
  public $id;

  /**
   * Contact Id
   *
   * @var int unsigned
   */
  public $contact_id;

  /**
   * Group Id
   *
   * @var int unsigned
   */
  public $group_id;

  /**
   * Date of the (un)subscription
   *
   * @var timestamp
   */
  public $date;

  /**
   * How the (un)subscription was triggered
   *
   * @var string
   */
  public $method;

  /**
   * The state of the contact within the group
   *
   * @var string
   */
  public $status;

  /**
   * IP address or other tracking info
   *
   * @var string
   */
  public $tracking;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_subscription_history';
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contact_id', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'group_id', 'civicrm_group', 'id');
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
          'title' => ts('Group Membership History ID'),
          'description' => ts('Internal Id'),
          'required' => TRUE,
          'table_name' => 'civicrm_subscription_history',
          'entity' => 'SubscriptionHistory',
          'bao' => 'CRM_Contact_BAO_SubscriptionHistory',
          'localizable' => 0,
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact ID'),
          'description' => ts('Contact Id'),
          'required' => TRUE,
          'table_name' => 'civicrm_subscription_history',
          'entity' => 'SubscriptionHistory',
          'bao' => 'CRM_Contact_BAO_SubscriptionHistory',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
        ],
        'group_id' => [
          'name' => 'group_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Group'),
          'description' => ts('Group Id'),
          'table_name' => 'civicrm_subscription_history',
          'entity' => 'SubscriptionHistory',
          'bao' => 'CRM_Contact_BAO_SubscriptionHistory',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Group',
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_group',
            'keyColumn' => 'id',
            'labelColumn' => 'title',
          ]
        ],
        'date' => [
          'name' => 'date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => ts('Group Membership Action Date'),
          'description' => ts('Date of the (un)subscription'),
          'required' => TRUE,
          'default' => 'CURRENT_TIMESTAMP',
          'table_name' => 'civicrm_subscription_history',
          'entity' => 'SubscriptionHistory',
          'bao' => 'CRM_Contact_BAO_SubscriptionHistory',
          'localizable' => 0,
        ],
        'method' => [
          'name' => 'method',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Group Membership Action'),
          'description' => ts('How the (un)subscription was triggered'),
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'table_name' => 'civicrm_subscription_history',
          'entity' => 'SubscriptionHistory',
          'bao' => 'CRM_Contact_BAO_SubscriptionHistory',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'callback' => 'CRM_Core_SelectValues::getSubscriptionHistoryMethods',
          ]
        ],
        'status' => [
          'name' => 'status',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Group Membership Status'),
          'description' => ts('The state of the contact within the group'),
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'table_name' => 'civicrm_subscription_history',
          'entity' => 'SubscriptionHistory',
          'bao' => 'CRM_Contact_BAO_SubscriptionHistory',
          'localizable' => 0,
          'pseudoconstant' => [
            'callback' => 'CRM_Core_SelectValues::groupContactStatus',
          ]
        ],
        'tracking' => [
          'name' => 'tracking',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Group Membership Tracking'),
          'description' => ts('IP address or other tracking info'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'table_name' => 'civicrm_subscription_history',
          'entity' => 'SubscriptionHistory',
          'bao' => 'CRM_Contact_BAO_SubscriptionHistory',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'subscription_history', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'subscription_history', $prefix, []);
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
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
