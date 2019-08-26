<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 *
 * Generated from xml/schema/CRM/Core/IM.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:77c810f15f9a1a849bc8ec0af13c649c)
 */

/**
 * Database access object for the IM entity.
 */
class CRM_Core_DAO_IM extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_im';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique IM ID
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
   * IM screen name
   *
   * @var string
   */
  public $name;

  /**
   * Which IM Provider does this screen name belong to.
   *
   * @var int
   */
  public $provider_id;

  /**
   * Is this the primary IM for this contact and location.
   *
   * @var bool
   */
  public $is_primary;

  /**
   * Is this the billing?
   *
   * @var bool
   */
  public $is_billing;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_im';
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
          'title' => ts('Instant Messenger ID'),
          'description' => ts('Unique IM ID'),
          'required' => TRUE,
          'where' => 'civicrm_im.id',
          'table_name' => 'civicrm_im',
          'entity' => 'IM',
          'bao' => 'CRM_Core_BAO_IM',
          'localizable' => 0,
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('IM Contact'),
          'description' => ts('FK to Contact ID'),
          'where' => 'civicrm_im.contact_id',
          'table_name' => 'civicrm_im',
          'entity' => 'IM',
          'bao' => 'CRM_Core_BAO_IM',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
        ],
        'location_type_id' => [
          'name' => 'location_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('IM Location Type'),
          'description' => ts('Which Location does this email belong to.'),
          'where' => 'civicrm_im.location_type_id',
          'table_name' => 'civicrm_im',
          'entity' => 'IM',
          'bao' => 'CRM_Core_BAO_IM',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_location_type',
            'keyColumn' => 'id',
            'labelColumn' => 'display_name',
          ],
        ],
        'name' => [
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('IM Screen Name'),
          'description' => ts('IM screen name'),
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'import' => TRUE,
          'where' => 'civicrm_im.name',
          'headerPattern' => '/I(nstant )?M(ess.*)?|screen(\s+)?name/i',
          'dataPattern' => '/^[A-Za-z][0-9A-Za-z]{20,}$/',
          'export' => TRUE,
          'table_name' => 'civicrm_im',
          'entity' => 'IM',
          'bao' => 'CRM_Core_BAO_IM',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'provider_id' => [
          'name' => 'provider_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('IM Provider'),
          'description' => ts('Which IM Provider does this screen name belong to.'),
          'where' => 'civicrm_im.provider_id',
          'table_name' => 'civicrm_im',
          'entity' => 'IM',
          'bao' => 'CRM_Core_BAO_IM',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'instant_messenger_service',
            'optionEditPath' => 'civicrm/admin/options/instant_messenger_service',
          ],
        ],
        'is_primary' => [
          'name' => 'is_primary',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is IM Primary?'),
          'description' => ts('Is this the primary IM for this contact and location.'),
          'where' => 'civicrm_im.is_primary',
          'default' => '0',
          'table_name' => 'civicrm_im',
          'entity' => 'IM',
          'bao' => 'CRM_Core_BAO_IM',
          'localizable' => 0,
        ],
        'is_billing' => [
          'name' => 'is_billing',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is IM Billing?'),
          'description' => ts('Is this the billing?'),
          'where' => 'civicrm_im.is_billing',
          'default' => '0',
          'table_name' => 'civicrm_im',
          'entity' => 'IM',
          'bao' => 'CRM_Core_BAO_IM',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'im', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'im', $prefix, []);
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
        'sig' => 'civicrm_im::0::location_type_id',
      ],
      'UI_provider_id' => [
        'name' => 'UI_provider_id',
        'field' => [
          0 => 'provider_id',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_im::0::provider_id',
      ],
      'index_is_primary' => [
        'name' => 'index_is_primary',
        'field' => [
          0 => 'is_primary',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_im::0::is_primary',
      ],
      'index_is_billing' => [
        'name' => 'index_is_billing',
        'field' => [
          0 => 'is_billing',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_im::0::is_billing',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
