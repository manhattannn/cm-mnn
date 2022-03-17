<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from xml/schema/CRM/PCP/PCP.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:0d2fc92a3a801a3eb5eca71989b21557)
 */

/**
 * Database access object for the PCP entity.
 */
class CRM_PCP_DAO_PCP extends CRM_Core_DAO {
  const EXT = 'civicrm';
  const TABLE_ADDED = '2.2';
  const COMPONENT = 'CiviContribute';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_pcp';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Personal Campaign Page ID
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
   * @var int
   */
  public $status_id;

  /**
   * @var string
   */
  public $title;

  /**
   * @var text
   */
  public $intro_text;

  /**
   * @var text
   */
  public $page_text;

  /**
   * @var string
   */
  public $donate_link_text;

  /**
   * The Contribution or Event Page which triggered this pcp
   *
   * @var int
   */
  public $page_id;

  /**
   * The type of PCP this is: contribute or event
   *
   * @var string
   */
  public $page_type;

  /**
   * The pcp block that this pcp page was created from
   *
   * @var int
   */
  public $pcp_block_id;

  /**
   * @var int
   */
  public $is_thermometer;

  /**
   * @var int
   */
  public $is_honor_roll;

  /**
   * Goal amount of this Personal Campaign Page.
   *
   * @var float
   */
  public $goal_amount;

  /**
   * 3 character string, value from config setting or input via user.
   *
   * @var string
   */
  public $currency;

  /**
   * Is Personal Campaign Page enabled/active?
   *
   * @var bool
   */
  public $is_active;

  /**
   * Notify owner via email when someone donates to page?
   *
   * @var bool
   */
  public $is_notify;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_pcp';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? ts('PCPs') : ts('PCP');
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
        'pcp_id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Personal Campaign Page ID'),
          'description' => ts('Personal Campaign Page ID'),
          'required' => TRUE,
          'where' => 'civicrm_pcp.id',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => '2.2',
        ],
        'pcp_contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact ID'),
          'description' => ts('FK to Contact ID'),
          'required' => TRUE,
          'where' => 'civicrm_pcp.contact_id',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'type' => 'EntityRef',
            'label' => ts("Contact"),
          ],
          'add' => '2.2',
        ],
        'status_id' => [
          'name' => 'status_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Personal Campaign Page Status'),
          'required' => TRUE,
          'where' => 'civicrm_pcp.status_id',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'pcp_status',
            'optionEditPath' => 'civicrm/admin/options/pcp_status',
          ],
          'add' => '2.2',
        ],
        'title' => [
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Personal Campaign Page Title'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_pcp.title',
          'default' => NULL,
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => '2.2',
        ],
        'intro_text' => [
          'name' => 'intro_text',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Intro Text'),
          'where' => 'civicrm_pcp.intro_text',
          'default' => NULL,
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
            'label' => ts("Intro Text"),
          ],
          'add' => '2.2',
        ],
        'page_text' => [
          'name' => 'page_text',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Page Text'),
          'where' => 'civicrm_pcp.page_text',
          'default' => NULL,
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
            'label' => ts("Page Text"),
          ],
          'add' => '2.2',
        ],
        'donate_link_text' => [
          'name' => 'donate_link_text',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Donate Link Text'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_pcp.donate_link_text',
          'default' => NULL,
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => '2.2',
        ],
        'page_id' => [
          'name' => 'page_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contribution Page'),
          'description' => ts('The Contribution or Event Page which triggered this pcp'),
          'required' => TRUE,
          'where' => 'civicrm_pcp.page_id',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'add' => '4.1',
        ],
        'page_type' => [
          'name' => 'page_type',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('PCP Page Type'),
          'description' => ts('The type of PCP this is: contribute or event'),
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'where' => 'civicrm_pcp.page_type',
          'default' => 'contribute',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'add' => '2.2',
        ],
        'pcp_block_id' => [
          'name' => 'pcp_block_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('PCP Block'),
          'description' => ts('The pcp block that this pcp page was created from'),
          'required' => TRUE,
          'where' => 'civicrm_pcp.pcp_block_id',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'add' => '4.1',
        ],
        'is_thermometer' => [
          'name' => 'is_thermometer',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Use Thermometer?'),
          'where' => 'civicrm_pcp.is_thermometer',
          'default' => '0',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => '2.2',
        ],
        'is_honor_roll' => [
          'name' => 'is_honor_roll',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Show Honor Roll?'),
          'where' => 'civicrm_pcp.is_honor_roll',
          'default' => '0',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => '2.2',
        ],
        'goal_amount' => [
          'name' => 'goal_amount',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => ts('Goal Amount'),
          'description' => ts('Goal amount of this Personal Campaign Page.'),
          'precision' => [
            20,
            2,
          ],
          'where' => 'civicrm_pcp.goal_amount',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => '2.2',
        ],
        'currency' => [
          'name' => 'currency',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Currency'),
          'description' => ts('3 character string, value from config setting or input via user.'),
          'maxlength' => 3,
          'size' => CRM_Utils_Type::FOUR,
          'where' => 'civicrm_pcp.currency',
          'default' => NULL,
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_currency',
            'keyColumn' => 'name',
            'labelColumn' => 'full_name',
            'nameColumn' => 'name',
            'abbrColumn' => 'symbol',
          ],
          'add' => '3.2',
        ],
        'is_active' => [
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Enabled?'),
          'description' => ts('Is Personal Campaign Page enabled/active?'),
          'where' => 'civicrm_pcp.is_active',
          'default' => '0',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => '2.2',
        ],
        'is_notify' => [
          'name' => 'is_notify',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Notify Owner?'),
          'description' => ts('Notify owner via email when someone donates to page?'),
          'where' => 'civicrm_pcp.is_notify',
          'default' => '0',
          'table_name' => 'civicrm_pcp',
          'entity' => 'PCP',
          'bao' => 'CRM_PCP_BAO_PCP',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => '4.6',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'pcp', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'pcp', $prefix, []);
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
