<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from xml/schema/CRM/Core/MessageTemplate.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:10bf11ca59e77fe7be9dfd775e5d5cd0)
 */

/**
 * Database access object for the MessageTemplate entity.
 */
class CRM_Core_DAO_MessageTemplate extends CRM_Core_DAO {
  const EXT = 'civicrm';
  const TABLE_ADDED = '1.6';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_msg_template';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = FALSE;

  /**
   * Message Template ID
   *
   * @var int
   */
  public $id;

  /**
   * Descriptive title of message
   *
   * @var string
   */
  public $msg_title;

  /**
   * Subject for email message.
   *
   * @var text
   */
  public $msg_subject;

  /**
   * Text formatted message
   *
   * @var longtext
   */
  public $msg_text;

  /**
   * HTML formatted message
   *
   * @var longtext
   */
  public $msg_html;

  /**
   * @var bool
   */
  public $is_active;

  /**
   * a pseudo-FK to civicrm_option_value
   *
   * @var int
   */
  public $workflow_id;

  /**
   * @var string
   */
  public $workflow_name;

  /**
   * is this the default message template for the workflow referenced by workflow_id?
   *
   * @var bool
   */
  public $is_default;

  /**
   * is this the reserved message template which we ship for the workflow referenced by workflow_id?
   *
   * @var bool
   */
  public $is_reserved;

  /**
   * Is this message template used for sms?
   *
   * @var bool
   */
  public $is_sms;

  /**
   * a pseudo-FK to civicrm_option_value containing PDF Page Format.
   *
   * @var int
   */
  public $pdf_format_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_msg_template';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? ts('Message Templates') : ts('Message Template');
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
          'title' => ts('Message Template ID'),
          'description' => ts('Message Template ID'),
          'required' => TRUE,
          'where' => 'civicrm_msg_template.id',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => '1.6',
        ],
        'msg_title' => [
          'name' => 'msg_title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Message Template Title'),
          'description' => ts('Descriptive title of message'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_msg_template.msg_title',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '1.6',
        ],
        'msg_subject' => [
          'name' => 'msg_subject',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Message Template Subject'),
          'description' => ts('Subject for email message.'),
          'where' => 'civicrm_msg_template.msg_subject',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '1.6',
        ],
        'msg_text' => [
          'name' => 'msg_text',
          'type' => CRM_Utils_Type::T_LONGTEXT,
          'title' => ts('Message Template Text'),
          'description' => ts('Text formatted message'),
          'where' => 'civicrm_msg_template.msg_text',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => '1.6',
        ],
        'msg_html' => [
          'name' => 'msg_html',
          'type' => CRM_Utils_Type::T_LONGTEXT,
          'title' => ts('Message Template HTML'),
          'description' => ts('HTML formatted message'),
          'where' => 'civicrm_msg_template.msg_html',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'html' => [
            'type' => 'RichTextEditor',
          ],
          'add' => '1.6',
        ],
        'is_active' => [
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is Active'),
          'where' => 'civicrm_msg_template.is_active',
          'default' => '1',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '1.6',
        ],
        'workflow_id' => [
          'name' => 'workflow_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Deprecated field for Message Template Workflow.'),
          'description' => ts('a pseudo-FK to civicrm_option_value'),
          'where' => 'civicrm_msg_template.workflow_id',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '3.1',
        ],
        'workflow_name' => [
          'name' => 'workflow_name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Message Template Workflow Name'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_msg_template.workflow_name',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '5.26',
        ],
        'is_default' => [
          'name' => 'is_default',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Message Template Is Default?'),
          'description' => ts('is this the default message template for the workflow referenced by workflow_id?'),
          'where' => 'civicrm_msg_template.is_default',
          'default' => '1',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '3.1',
        ],
        'is_reserved' => [
          'name' => 'is_reserved',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Message Template Is Reserved?'),
          'description' => ts('is this the reserved message template which we ship for the workflow referenced by workflow_id?'),
          'where' => 'civicrm_msg_template.is_reserved',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '3.1',
        ],
        'is_sms' => [
          'name' => 'is_sms',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Message Template is used for SMS?'),
          'description' => ts('Is this message template used for sms?'),
          'where' => 'civicrm_msg_template.is_sms',
          'default' => '0',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'add' => '4.5',
        ],
        'pdf_format_id' => [
          'name' => 'pdf_format_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Message Template Format'),
          'description' => ts('a pseudo-FK to civicrm_option_value containing PDF Page Format.'),
          'where' => 'civicrm_msg_template.pdf_format_id',
          'table_name' => 'civicrm_msg_template',
          'entity' => 'MessageTemplate',
          'bao' => 'CRM_Core_BAO_MessageTemplate',
          'localizable' => 0,
          'pseudoconstant' => [
            'optionGroupName' => 'pdf_format',
            'keyColumn' => 'id',
            'optionEditPath' => 'civicrm/admin/options/pdf_format',
          ],
          'add' => '3.4',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'msg_template', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'msg_template', $prefix, []);
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
