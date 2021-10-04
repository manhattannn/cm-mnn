<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from xml/schema/CRM/Activity/Activity.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:3724c8dbc64bff361edd263e78780dbe)
 */

/**
 * Database access object for the Activity entity.
 */
class CRM_Activity_DAO_Activity extends CRM_Core_DAO {
  const EXT = 'civicrm';
  const TABLE_ADDED = '1.1';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_activity';

  /**
   * Icon associated with this entity.
   *
   * @var string
   */
  public static $_icon = 'fa-tasks';

  /**
   * Field to show when displaying a record.
   *
   * @var string
   */
  public static $_labelField = 'subject';

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
    'add' => 'civicrm/activity?reset=1&action=add&context=standalone',
    'view' => 'civicrm/activity?reset=1&action=view&id=[id]',
    'update' => 'civicrm/activity/add?reset=1&action=update&id=[id]',
    'delete' => 'civicrm/activity?reset=1&action=delete&id=[id]',
  ];

  /**
   * Unique  Other Activity ID
   *
   * @var int
   */
  public $id;

  /**
   * Artificial FK to original transaction (e.g. contribution) IF it is not an Activity. Table can be figured out through activity_type_id, and further through component registry.
   *
   * @var int
   */
  public $source_record_id;

  /**
   * FK to civicrm_option_value.id, that has to be valid, registered activity type.
   *
   * @var int
   */
  public $activity_type_id;

  /**
   * The subject/purpose/short description of the activity.
   *
   * @var string
   */
  public $subject;

  /**
   * Date and time this activity is scheduled to occur. Formerly named scheduled_date_time.
   *
   * @var datetime
   */
  public $activity_date_time;

  /**
   * Planned or actual duration of activity expressed in minutes. Conglomerate of former duration_hours and duration_minutes.
   *
   * @var int
   */
  public $duration;

  /**
   * Location of the activity (optional, open text).
   *
   * @var string
   */
  public $location;

  /**
   * Phone ID of the number called (optional - used if an existing phone number is selected).
   *
   * @var int
   */
  public $phone_id;

  /**
   * Phone number in case the number does not exist in the civicrm_phone table.
   *
   * @var string
   */
  public $phone_number;

  /**
   * Details about the activity (agenda, notes, etc).
   *
   * @var longtext
   */
  public $details;

  /**
   * ID of the status this activity is currently in. Foreign key to civicrm_option_value.
   *
   * @var int
   */
  public $status_id;

  /**
   * ID of the priority given to this activity. Foreign key to civicrm_option_value.
   *
   * @var int
   */
  public $priority_id;

  /**
   * Parent meeting ID (if this is a follow-up item). This is not currently implemented
   *
   * @var int
   */
  public $parent_id;

  /**
   * @var bool
   */
  public $is_test;

  /**
   * Activity Medium, Implicit FK to civicrm_option_value where option_group = encounter_medium.
   *
   * @var int
   */
  public $medium_id;

  /**
   * @var bool
   */
  public $is_auto;

  /**
   * FK to Relationship ID
   *
   * @var int
   */
  public $relationship_id;

  /**
   * @var bool
   */
  public $is_current_revision;

  /**
   * Activity ID of the first activity record in versioning chain.
   *
   * @var int
   */
  public $original_id;

  /**
   * Currently being used to store result id for survey activity, FK to option value.
   *
   * @var string
   */
  public $result;

  /**
   * @var bool
   */
  public $is_deleted;

  /**
   * The campaign for which this activity has been triggered.
   *
   * @var int
   */
  public $campaign_id;

  /**
   * Assign a specific level of engagement to this activity. Used for tracking constituents in ladder of engagement.
   *
   * @var int
   */
  public $engagement_level;

  /**
   * @var int
   */
  public $weight;

  /**
   * Activity marked as favorite.
   *
   * @var bool
   */
  public $is_star;

  /**
   * When was the activity was created.
   *
   * @var timestamp
   */
  public $created_date;

  /**
   * When was the activity (or closely related entity) was created or modified or deleted.
   *
   * @var timestamp
   */
  public $modified_date;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_activity';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? ts('Activities') : ts('Activity');
  }

  /**
   * Returns user-friendly description of this entity.
   *
   * @return string
   */
  public static function getEntityDescription() {
    return ts('Past or future actions concerning one or more contacts.');
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'phone_id', 'civicrm_phone', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'parent_id', 'civicrm_activity', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'relationship_id', 'civicrm_relationship', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'original_id', 'civicrm_activity', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'campaign_id', 'civicrm_campaign', 'id');
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
        'activity_id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Activity ID'),
          'description' => ts('Unique  Other Activity ID'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_activity.id',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => '1.1',
        ],
        'source_record_id' => [
          'name' => 'source_record_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Source Record'),
          'description' => ts('Artificial FK to original transaction (e.g. contribution) IF it is not an Activity. Table can be figured out through activity_type_id, and further through component registry.'),
          'where' => 'civicrm_activity.source_record_id',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'readonly' => TRUE,
          'add' => '2.0',
        ],
        'activity_type_id' => [
          'name' => 'activity_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Activity Type ID'),
          'description' => ts('FK to civicrm_option_value.id, that has to be valid, registered activity type.'),
          'required' => TRUE,
          'import' => TRUE,
          'where' => 'civicrm_activity.activity_type_id',
          'headerPattern' => '/(activity.)?type(.id$)/i',
          'export' => TRUE,
          'default' => '1',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
            'label' => ts("Activity Type"),
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'activity_type',
            'optionEditPath' => 'civicrm/admin/options/activity_type',
          ],
          'add' => '1.1',
        ],
        'activity_subject' => [
          'name' => 'subject',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Subject'),
          'description' => ts('The subject/purpose/short description of the activity.'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_activity.subject',
          'headerPattern' => '/(activity.)?subject/i',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => '1.1',
        ],
        'activity_date_time' => [
          'name' => 'activity_date_time',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Activity Date'),
          'description' => ts('Date and time this activity is scheduled to occur. Formerly named scheduled_date_time.'),
          'required' => FALSE,
          'import' => TRUE,
          'where' => 'civicrm_activity.activity_date_time',
          'headerPattern' => '/(activity.)?date(.time$)?/i',
          'export' => TRUE,
          'default' => 'CURRENT_TIMESTAMP',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDateTime',
          ],
          'add' => '2.0',
        ],
        'activity_duration' => [
          'name' => 'duration',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Duration'),
          'description' => ts('Planned or actual duration of activity expressed in minutes. Conglomerate of former duration_hours and duration_minutes.'),
          'import' => TRUE,
          'where' => 'civicrm_activity.duration',
          'headerPattern' => '/(activity.)?duration(s)?$/i',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'add' => '2.0',
        ],
        'activity_location' => [
          'name' => 'location',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Location'),
          'description' => ts('Location of the activity (optional, open text).'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_activity.location',
          'headerPattern' => '/(activity.)?location$/i',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => '1.1',
        ],
        'phone_id' => [
          'name' => 'phone_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Phone ID (called)'),
          'description' => ts('Phone ID of the number called (optional - used if an existing phone number is selected).'),
          'where' => 'civicrm_activity.phone_id',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'FKClassName' => 'CRM_Core_DAO_Phone',
          'html' => [
            'type' => 'EntityRef',
            'label' => ts("Phone (called)"),
          ],
          'add' => '2.0',
        ],
        'phone_number' => [
          'name' => 'phone_number',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Phone (called) Number'),
          'description' => ts('Phone number in case the number does not exist in the civicrm_phone table.'),
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'where' => 'civicrm_activity.phone_number',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => '2.0',
        ],
        'activity_details' => [
          'name' => 'details',
          'type' => CRM_Utils_Type::T_LONGTEXT,
          'title' => ts('Details'),
          'description' => ts('Details about the activity (agenda, notes, etc).'),
          'import' => TRUE,
          'where' => 'civicrm_activity.details',
          'headerPattern' => '/(activity.)?detail(s)?$/i',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'RichTextEditor',
          ],
          'add' => '1.1',
        ],
        'activity_status_id' => [
          'name' => 'status_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Activity Status'),
          'description' => ts('ID of the status this activity is currently in. Foreign key to civicrm_option_value.'),
          'import' => TRUE,
          'where' => 'civicrm_activity.status_id',
          'headerPattern' => '/(activity.)?status(.label$)?/i',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'activity_status',
            'optionEditPath' => 'civicrm/admin/options/activity_status',
          ],
          'add' => '2.0',
        ],
        'priority_id' => [
          'name' => 'priority_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Priority'),
          'description' => ts('ID of the priority given to this activity. Foreign key to civicrm_option_value.'),
          'import' => TRUE,
          'where' => 'civicrm_activity.priority_id',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'priority',
            'optionEditPath' => 'civicrm/admin/options/priority',
          ],
          'add' => '2.0',
        ],
        'parent_id' => [
          'name' => 'parent_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Parent Activity ID'),
          'description' => ts('Parent meeting ID (if this is a follow-up item). This is not currently implemented'),
          'where' => 'civicrm_activity.parent_id',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'FKClassName' => 'CRM_Activity_DAO_Activity',
          'html' => [
            'label' => ts("Parent Activity"),
          ],
          'readonly' => TRUE,
          'add' => '1.1',
        ],
        'activity_is_test' => [
          'name' => 'is_test',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Test'),
          'import' => TRUE,
          'where' => 'civicrm_activity.is_test',
          'headerPattern' => '/(is.)?test(.activity)?/i',
          'export' => TRUE,
          'default' => '0',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => '2.0',
        ],
        'activity_medium_id' => [
          'name' => 'medium_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Activity Medium'),
          'description' => ts('Activity Medium, Implicit FK to civicrm_option_value where option_group = encounter_medium.'),
          'where' => 'civicrm_activity.medium_id',
          'default' => 'NULL',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'encounter_medium',
            'optionEditPath' => 'civicrm/admin/options/encounter_medium',
          ],
          'add' => '2.2',
        ],
        'is_auto' => [
          'name' => 'is_auto',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Auto'),
          'where' => 'civicrm_activity.is_auto',
          'default' => '0',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'add' => '2.2',
        ],
        'relationship_id' => [
          'name' => 'relationship_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Relationship ID'),
          'description' => ts('FK to Relationship ID'),
          'where' => 'civicrm_activity.relationship_id',
          'default' => 'NULL',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Relationship',
          'html' => [
            'label' => ts("Relationship"),
          ],
          'add' => '2.2',
        ],
        'is_current_revision' => [
          'name' => 'is_current_revision',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is this activity a current revision in versioning chain?'),
          'import' => TRUE,
          'where' => 'civicrm_activity.is_current_revision',
          'headerPattern' => '/(is.)?(current.)?(revision|version(ing)?)/i',
          'export' => TRUE,
          'default' => '1',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'add' => '2.2',
        ],
        'original_id' => [
          'name' => 'original_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Original Activity ID'),
          'description' => ts('Activity ID of the first activity record in versioning chain.'),
          'where' => 'civicrm_activity.original_id',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'FKClassName' => 'CRM_Activity_DAO_Activity',
          'html' => [
            'label' => ts("Original Activity"),
          ],
          'readonly' => TRUE,
          'add' => '2.2',
        ],
        'activity_result' => [
          'name' => 'result',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Result'),
          'description' => ts('Currently being used to store result id for survey activity, FK to option value.'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_activity.result',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'add' => '3.3',
        ],
        'activity_is_deleted' => [
          'name' => 'is_deleted',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Activity is in the Trash'),
          'import' => TRUE,
          'where' => 'civicrm_activity.is_deleted',
          'headerPattern' => '/(activity.)?(trash|deleted)/i',
          'export' => TRUE,
          'default' => '0',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => '2.2',
        ],
        'activity_campaign_id' => [
          'name' => 'campaign_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Campaign ID'),
          'description' => ts('The campaign for which this activity has been triggered.'),
          'import' => TRUE,
          'where' => 'civicrm_activity.campaign_id',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'FKClassName' => 'CRM_Campaign_DAO_Campaign',
          'component' => 'CiviCampaign',
          'html' => [
            'type' => 'EntityRef',
            'label' => ts("Campaign"),
          ],
          'add' => '3.4',
        ],
        'activity_engagement_level' => [
          'name' => 'engagement_level',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Engagement Index'),
          'description' => ts('Assign a specific level of engagement to this activity. Used for tracking constituents in ladder of engagement.'),
          'import' => TRUE,
          'where' => 'civicrm_activity.engagement_level',
          'export' => TRUE,
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'engagement_index',
            'optionEditPath' => 'civicrm/admin/options/engagement_index',
          ],
          'add' => '3.4',
        ],
        'weight' => [
          'name' => 'weight',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Order'),
          'where' => 'civicrm_activity.weight',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'add' => '4.1',
        ],
        'is_star' => [
          'name' => 'is_star',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is Starred'),
          'description' => ts('Activity marked as favorite.'),
          'import' => TRUE,
          'where' => 'civicrm_activity.is_star',
          'headerPattern' => '/(activity.)?(star|favorite)/i',
          'export' => TRUE,
          'default' => '0',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'type' => 'Checkbox',
          ],
          'add' => '4.7',
        ],
        'activity_created_date' => [
          'name' => 'created_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => ts('Created Date'),
          'description' => ts('When was the activity was created.'),
          'required' => FALSE,
          'where' => 'civicrm_activity.created_date',
          'export' => TRUE,
          'default' => 'CURRENT_TIMESTAMP',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'label' => ts("Created Date"),
          ],
          'add' => '4.7',
        ],
        'activity_modified_date' => [
          'name' => 'modified_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => ts('Modified Date'),
          'description' => ts('When was the activity (or closely related entity) was created or modified or deleted.'),
          'required' => FALSE,
          'where' => 'civicrm_activity.modified_date',
          'export' => TRUE,
          'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
          'table_name' => 'civicrm_activity',
          'entity' => 'Activity',
          'bao' => 'CRM_Activity_BAO_Activity',
          'localizable' => 0,
          'html' => [
            'label' => ts("Modified Date"),
          ],
          'readonly' => TRUE,
          'add' => '4.7',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'activity', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'activity', $prefix, []);
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
      'UI_source_record_id' => [
        'name' => 'UI_source_record_id',
        'field' => [
          0 => 'source_record_id',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_activity::0::source_record_id',
      ],
      'UI_activity_type_id' => [
        'name' => 'UI_activity_type_id',
        'field' => [
          0 => 'activity_type_id',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_activity::0::activity_type_id',
      ],
      'index_activity_date_time' => [
        'name' => 'index_activity_date_time',
        'field' => [
          0 => 'activity_date_time',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_activity::0::activity_date_time',
      ],
      'index_status_id' => [
        'name' => 'index_status_id',
        'field' => [
          0 => 'status_id',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_activity::0::status_id',
      ],
      'index_is_current_revision' => [
        'name' => 'index_is_current_revision',
        'field' => [
          0 => 'is_current_revision',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_activity::0::is_current_revision',
      ],
      'index_is_deleted' => [
        'name' => 'index_is_deleted',
        'field' => [
          0 => 'is_deleted',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_activity::0::is_deleted',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
