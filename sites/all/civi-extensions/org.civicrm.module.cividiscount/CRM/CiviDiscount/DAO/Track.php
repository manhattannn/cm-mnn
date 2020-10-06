<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 4.6                                                |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2015                                |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the GNU Affero General Public License           |
| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the GNU Affero General Public License for more details.        |
|                                                                    |
| You should have received a copy of the GNU Affero General Public   |
| License and the CiviCRM Licensing Exception along                  |
| with this program; if not, contact CiviCRM LLC                     |
| at info[AT]civicrm[DOT]org. If you have questions about the        |
| GNU Affero General Public License or the licensing of CiviCRM,     |
| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
+--------------------------------------------------------------------+
*/
/**
 * @package CiviDiscount
 */
use CRM_CiviDiscount_ExtensionUtil as E;

class CRM_CiviDiscount_DAO_Track extends CRM_Core_DAO {
  /**
   * static instance to hold the table name
   *
   * @var string
   * @static
   */
  static $_tableName = 'cividiscount_track';
  /**
   * static instance to hold the field values
   *
   * @var array
   * @static
   */
  static $_fields = NULL;
  /**
   * static instance to hold the FK relationships
   *
   * @var string
   * @static
   */
  static $_links = NULL;
  /**
   * static instance to hold the values that can
   * be imported
   *
   * @var array
   * @static
   */
  static $_import = NULL;
  /**
   * static instance to hold the values that can
   * be exported
   *
   * @var array
   * @static
   */
  static $_export = NULL;
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   * @static
   */
  static $_log = FALSE;
  /**
   * Discount Item ID
   *
   * @var int unsigned
   */
  public $id;
  /**
   * FK to Item ID of the discount code
   *
   * @var int unsigned
   */
  public $item_id;
  /**
   * FK to Contact ID for the contact that used this discount
   *
   * @var int unsigned
   */
  public $contact_id;
  /**
   * Date of discount use.
   *
   * @var datetime
   */
  public $used_date;
  /**
   * FK to contribution table.
   *
   * @var int unsigned
   */
  public $contribution_id;
  /**
   * Name of table where item being referenced is stored?
   *
   * @var string
   */
  public $entity_table;
  /**
   * Foreign key to the referenced item?
   *
   * @var int unsigned
   */
  public $entity_id;
  /**
   * Discount use description.
   *
   * @var text
   */
  public $description;

  /**
   * class constructor
   *
   * @access public
   * @return cividiscount_track
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * return foreign links
   *
   * @access public
   * @return array
   */
  public function &links() {
    if (!(self::$_links)) {
      self::$_links = [
        'item_id' => 'cividiscount_item:id',
        'contact_id' => 'civicrm_contact:id',
        'contribution_id' => 'civicrm_contribution:id',
      ];
    }
    return self::$_links;
  }

  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  public static function &fields() {
    if (!(self::$_fields)) {
      self::$_fields = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'required' => TRUE,
        ],
        'item_id' => [
          'name' => 'item_id',
          'type' => CRM_Utils_Type::T_INT,
          'FKClassName' => 'CRM_CiviDiscount_DAO_Item',
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
        ],
        'used_date' => [
          'name' => 'used_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Used Date'),
        ],
        'contribution_id' => [
          'name' => 'contribution_id',
          'type' => CRM_Utils_Type::T_INT,
          'FKClassName' => 'CRM_Contribute_DAO_Contribution',
        ],
        'entity_table' => [
          'name' => 'entity_table',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Entity Table'),
          'required' => TRUE,
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
        ],
        'entity_id' => [
          'name' => 'entity_id',
          'type' => CRM_Utils_Type::T_INT,
          'required' => TRUE,
        ],
        'description' => [
          'name' => 'description',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Description'),
        ],
      ];
    }
    return self::$_fields;
  }

  /**
   * returns the names of this table
   *
   * @access public
   * @return string
   */
  public static function getTableName() {
    return CRM_Core_DAO::getLocaleTableName(self::$_tableName);
  }

  /**
   * returns if this table needs to be logged
   *
   * @access public
   * @return boolean
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * returns the list of fields that can be imported
   *
   * @access public
   * return array
   */
  public function &import($prefix = FALSE) {
    if (!(self::$_import)) {
      self::$_import = [];
      $fields = self::fields();
      foreach ($fields as $name => $field) {
        if (CRM_Utils_Array::value('import', $field)) {
          if ($prefix) {
            self::$_import['cividiscount_track'] = &$fields[$name];
          }
          else {
            self::$_import[$name] = &$fields[$name];
          }
        }
      }
    }
    return self::$_import;
  }

  /**
   * returns the list of fields that can be exported
   *
   * @access public
   * return array
   */
  public function &export($prefix = FALSE) {
    if (!(self::$_export)) {
      self::$_export = [];
      $fields = self::fields();
      foreach ($fields as $name => $field) {
        if (CRM_Utils_Array::value('export', $field)) {
          if ($prefix) {
            self::$_export['cividiscount_track'] = &$fields[$name];
          }
          else {
            self::$_export[$name] = &$fields[$name];
          }
        }
      }
    }
    return self::$_export;
  }
}
