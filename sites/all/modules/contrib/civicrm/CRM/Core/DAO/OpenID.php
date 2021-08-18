<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from xml/schema/CRM/Core/OpenID.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:6547ff2f60e61de44f3ca5a866c1df6a)
 */

/**
 * Database access object for the OpenID entity.
 */
class CRM_Core_DAO_OpenID extends CRM_Core_DAO {
  const EXT = 'civicrm';
  const TABLE_ADDED = '2.0';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_openid';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = FALSE;

  /**
   * Unique OpenID ID
   *
   * @var int
   */
  public $id;

  /**
   * FK to Contact ID
   *
   * @var int
   */
  public $contact_id;

  /**
   * Which Location does this email belong to.
   *
   * @var int
   */
  public $location_type_id;

  /**
   * the OpenID (or OpenID-style http://username.domain/) unique identifier for this contact mainly used for logging in to CiviCRM
   *
   * @var string
   */
  public $openid;

  /**
   * Whether or not this user is allowed to login
   *
   * @var bool
   */
  public $allowed_to_login;

  /**
   * Is this the primary email for this contact and location.
   *
   * @var bool
   */
  public $is_primary;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_openid';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? ts('Open IDs') : ts('Open ID');
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
          'title' => ts('Open ID identifier'),
          'description' => ts('Unique OpenID ID'),
          'required' => TRUE,
          'where' => 'civicrm_openid.id',
          'table_name' => 'civicrm_openid',
          'entity' => 'OpenID',
          'bao' => 'CRM_Core_BAO_OpenID',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => '2.0',
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact ID'),
          'description' => ts('FK to Contact ID'),
          'where' => 'civicrm_openid.contact_id',
          'table_name' => 'civicrm_openid',
          'entity' => 'OpenID',
          'bao' => 'CRM_Core_BAO_OpenID',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'label' => ts("Contact"),
          ],
          'add' => '2.0',
        ],
        'location_type_id' => [
          'name' => 'location_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('OpenID Location Type'),
          'description' => ts('Which Location does this email belong to.'),
          'where' => 'civicrm_openid.location_type_id',
          'table_name' => 'civicrm_openid',
          'entity' => 'OpenID',
          'bao' => 'CRM_Core_BAO_OpenID',
          'localizable' => 0,
          'pseudoconstant' => [
            'table' => 'civicrm_location_type',
            'keyColumn' => 'id',
            'labelColumn' => 'display_name',
          ],
          'add' => '2.0',
        ],
        'openid' => [
          'name' => 'openid',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('OpenID'),
          'description' => ts('the OpenID (or OpenID-style http://username.domain/) unique identifier for this contact mainly used for logging in to CiviCRM'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_openid.openid',
          'headerPattern' => '/^Open.?ID|u(niq\w*)?.?ID/i',
          'dataPattern' => '/^[\w\/\:\.]+$/',
          'export' => TRUE,
          'rule' => 'url',
          'table_name' => 'civicrm_openid',
          'entity' => 'OpenID',
          'bao' => 'CRM_Core_BAO_OpenID',
          'localizable' => 0,
          'add' => '2.0',
        ],
        'allowed_to_login' => [
          'name' => 'allowed_to_login',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Allowed to login?'),
          'description' => ts('Whether or not this user is allowed to login'),
          'required' => TRUE,
          'where' => 'civicrm_openid.allowed_to_login',
          'default' => '0',
          'table_name' => 'civicrm_openid',
          'entity' => 'OpenID',
          'bao' => 'CRM_Core_BAO_OpenID',
          'localizable' => 0,
          'add' => '2.0',
        ],
        'is_primary' => [
          'name' => 'is_primary',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Primary ID'),
          'description' => ts('Is this the primary email for this contact and location.'),
          'where' => 'civicrm_openid.is_primary',
          'default' => '0',
          'table_name' => 'civicrm_openid',
          'entity' => 'OpenID',
          'bao' => 'CRM_Core_BAO_OpenID',
          'localizable' => 0,
          'html' => [
            'type' => 'Radio',
          ],
          'add' => '2.0',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'openid', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'openid', $prefix, []);
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
      'index_location_type' => [
        'name' => 'index_location_type',
        'field' => [
          0 => 'location_type_id',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_openid::0::location_type_id',
      ],
      'UI_openid' => [
        'name' => 'UI_openid',
        'field' => [
          0 => 'openid',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_openid::1::openid',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
