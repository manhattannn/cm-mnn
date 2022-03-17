<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from xml/schema/CRM/Contact/Relationship.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:4d689d3ccc5aa155c858aac2f24ddfab)
 */

/**
 * Database access object for the Relationship entity.
 */
class CRM_Contact_DAO_Relationship extends CRM_Core_DAO {
  const EXT = 'civicrm';
  const TABLE_ADDED = '1.1';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_relationship';

  /**
   * Icon associated with this entity.
   *
   * @var string
   */
  public static $_icon = 'fa-handshake-o';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Paths for accessing this entity in the UI.
   *
   * @var string[]
   */
  protected static $_paths = [
    'view' => 'civicrm/contact/view/rel?action=view&reset=1&cid=[contact_id_a]&id=[id]',
    'delete' => 'civicrm/contact/view/rel?action=delete&reset=1&cid=[contact_id_a]&id=[id]',
  ];

  /**
   * Relationship ID
   *
   * @var int
   */
  public $id;

  /**
   * id of the first contact
   *
   * @var int
   */
  public $contact_id_a;

  /**
   * id of the second contact
   *
   * @var int
   */
  public $contact_id_b;

  /**
   * Type of relationship
   *
   * @var int
   */
  public $relationship_type_id;

  /**
   * date when the relationship started
   *
   * @var date
   */
  public $start_date;

  /**
   * date when the relationship ended
   *
   * @var date
   */
  public $end_date;

  /**
   * is the relationship active ?
   *
   * @var bool
   */
  public $is_active;

  /**
   * Optional verbose description for the relationship.
   *
   * @var string
   */
  public $description;

  /**
   * Permission that Contact A has to view/update Contact B
   *
   * @var int
   */
  public $is_permission_a_b;

  /**
   * Permission that Contact B has to view/update Contact A
   *
   * @var int
   */
  public $is_permission_b_a;

  /**
   * FK to civicrm_case
   *
   * @var int
   */
  public $case_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_relationship';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? ts('Relationships') : ts('Relationship');
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contact_id_a', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contact_id_b', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'relationship_type_id', 'civicrm_relationship_type', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'case_id', 'civicrm_case', 'id');
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
          'title' => ts('Relationship ID'),
          'description' => ts('Relationship ID'),
          'required' => TRUE,
          'where' => 'civicrm_relationship.id',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => '1.1',
        ],
        'contact_id_a' => [
          'name' => 'contact_id_a',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact A ID'),
          'description' => ts('id of the first contact'),
          'required' => TRUE,
          'where' => 'civicrm_relationship.contact_id_a',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'label' => ts("Contact A"),
          ],
          'add' => '1.1',
        ],
        'contact_id_b' => [
          'name' => 'contact_id_b',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact B ID'),
          'description' => ts('id of the second contact'),
          'required' => TRUE,
          'where' => 'civicrm_relationship.contact_id_b',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'type' => 'EntityRef',
            'label' => ts("Contact B"),
          ],
          'add' => '1.1',
        ],
        'relationship_type_id' => [
          'name' => 'relationship_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Relationship Type ID'),
          'description' => ts('Type of relationship'),
          'required' => TRUE,
          'where' => 'civicrm_relationship.relationship_type_id',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_RelationshipType',
          'html' => [
            'type' => 'Select',
            'label' => ts("Relationship Type"),
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_relationship_type',
            'keyColumn' => 'id',
            'labelColumn' => 'label_a_b',
            'nameColumn' => 'name_a_b',
          ],
          'add' => '1.1',
        ],
        'relationship_start_date' => [
          'name' => 'start_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Relationship Start Date'),
          'description' => ts('date when the relationship started'),
          'where' => 'civicrm_relationship.start_date',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDate',
          ],
          'add' => '1.1',
        ],
        'relationship_end_date' => [
          'name' => 'end_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Relationship End Date'),
          'description' => ts('date when the relationship ended'),
          'where' => 'civicrm_relationship.end_date',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDate',
          ],
          'add' => '1.1',
        ],
        'is_active' => [
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Relationship Is Active'),
          'description' => ts('is the relationship active ?'),
          'where' => 'civicrm_relationship.is_active',
          'default' => '1',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => '1.1',
        ],
        'description' => [
          'name' => 'description',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Relationship Description'),
          'description' => ts('Optional verbose description for the relationship.'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_relationship.description',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => '1.5',
        ],
        'is_permission_a_b' => [
          'name' => 'is_permission_a_b',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact A has Permission Over Contact B'),
          'description' => ts('Permission that Contact A has to view/update Contact B'),
          'required' => TRUE,
          'where' => 'civicrm_relationship.is_permission_a_b',
          'default' => '0',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'html' => [
            'type' => 'Radio',
          ],
          'pseudoconstant' => [
            'callback' => 'CRM_Core_SelectValues::getPermissionedRelationshipOptions',
          ],
          'add' => '2.1',
        ],
        'is_permission_b_a' => [
          'name' => 'is_permission_b_a',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact B has Permission Over Contact A'),
          'description' => ts('Permission that Contact B has to view/update Contact A'),
          'required' => TRUE,
          'where' => 'civicrm_relationship.is_permission_b_a',
          'default' => '0',
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'html' => [
            'type' => 'Radio',
          ],
          'pseudoconstant' => [
            'callback' => 'CRM_Core_SelectValues::getPermissionedRelationshipOptions',
          ],
          'add' => '2.1',
        ],
        'case_id' => [
          'name' => 'case_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Case ID'),
          'description' => ts('FK to civicrm_case'),
          'where' => 'civicrm_relationship.case_id',
          'default' => NULL,
          'table_name' => 'civicrm_relationship',
          'entity' => 'Relationship',
          'bao' => 'CRM_Contact_BAO_Relationship',
          'localizable' => 0,
          'FKClassName' => 'CRM_Case_DAO_Case',
          'component' => 'CiviCase',
          'html' => [
            'label' => ts("Case"),
          ],
          'add' => '2.2',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'relationship', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'relationship', $prefix, []);
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
