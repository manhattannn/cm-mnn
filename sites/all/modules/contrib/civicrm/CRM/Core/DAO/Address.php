<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 *
 * Generated from xml/schema/CRM/Core/Address.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:4e3b66ed828527539c525b2ffc71e606)
 */

/**
 * Database access object for the Address entity.
 */
class CRM_Core_DAO_Address extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_address';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique Address ID
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
   * Which Location does this address belong to.
   *
   * @var int
   */
  public $location_type_id;

  /**
   * Is this the primary address.
   *
   * @var bool
   */
  public $is_primary;

  /**
   * Is this the billing address.
   *
   * @var bool
   */
  public $is_billing;

  /**
   * Concatenation of all routable street address components (prefix, street number, street name, suffix, unit
   * number OR P.O. Box). Apps should be able to determine physical location with this data (for mapping, mail
   * delivery, etc.).
   *
   * @var string
   */
  public $street_address;

  /**
   * Numeric portion of address number on the street, e.g. For 112A Main St, the street_number = 112.
   *
   * @var int
   */
  public $street_number;

  /**
   * Non-numeric portion of address number on the street, e.g. For 112A Main St, the street_number_suffix = A
   *
   * @var string
   */
  public $street_number_suffix;

  /**
   * Directional prefix, e.g. SE Main St, SE is the prefix.
   *
   * @var string
   */
  public $street_number_predirectional;

  /**
   * Actual street name, excluding St, Dr, Rd, Ave, e.g. For 112 Main St, the street_name = Main.
   *
   * @var string
   */
  public $street_name;

  /**
   * St, Rd, Dr, etc.
   *
   * @var string
   */
  public $street_type;

  /**
   * Directional prefix, e.g. Main St S, S is the suffix.
   *
   * @var string
   */
  public $street_number_postdirectional;

  /**
   * Secondary unit designator, e.g. Apt 3 or Unit # 14, or Bldg 1200
   *
   * @var string
   */
  public $street_unit;

  /**
   * Supplemental Address Information, Line 1
   *
   * @var string
   */
  public $supplemental_address_1;

  /**
   * Supplemental Address Information, Line 2
   *
   * @var string
   */
  public $supplemental_address_2;

  /**
   * Supplemental Address Information, Line 3
   *
   * @var string
   */
  public $supplemental_address_3;

  /**
   * City, Town or Village Name.
   *
   * @var string
   */
  public $city;

  /**
   * Which County does this address belong to.
   *
   * @var int
   */
  public $county_id;

  /**
   * Which State_Province does this address belong to.
   *
   * @var int
   */
  public $state_province_id;

  /**
   * Store the suffix, like the +4 part in the USPS system.
   *
   * @var string
   */
  public $postal_code_suffix;

  /**
   * Store both US (zip5) AND international postal codes. App is responsible for country/region appropriate validation.
   *
   * @var string
   */
  public $postal_code;

  /**
   * USPS Bulk mailing code.
   *
   * @var string
   */
  public $usps_adc;

  /**
   * Which Country does this address belong to.
   *
   * @var int
   */
  public $country_id;

  /**
   * Latitude
   *
   * @var float
   */
  public $geo_code_1;

  /**
   * Longitude
   *
   * @var float
   */
  public $geo_code_2;

  /**
   * Is this a manually entered geo code
   *
   * @var bool
   */
  public $manual_geo_code;

  /**
   * Timezone expressed as a UTC offset - e.g. United States CST would be written as "UTC-6".
   *
   * @var string
   */
  public $timezone;

  /**
   * @var string
   */
  public $name;

  /**
   * FK to Address ID
   *
   * @var int
   */
  public $master_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_address';
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'county_id', 'civicrm_county', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'state_province_id', 'civicrm_state_province', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'country_id', 'civicrm_country', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'master_id', 'civicrm_address', 'id');
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
          'title' => ts('Address ID'),
          'description' => ts('Unique Address ID'),
          'required' => TRUE,
          'where' => 'civicrm_address.id',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Contact ID'),
          'description' => ts('FK to Contact ID'),
          'where' => 'civicrm_address.contact_id',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
        ],
        'location_type_id' => [
          'name' => 'location_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Address Location Type'),
          'description' => ts('Which Location does this address belong to.'),
          'where' => 'civicrm_address.location_type_id',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
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
        'is_primary' => [
          'name' => 'is_primary',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is Address Primary?'),
          'description' => ts('Is this the primary address.'),
          'where' => 'civicrm_address.is_primary',
          'default' => '0',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
        ],
        'is_billing' => [
          'name' => 'is_billing',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is Billing Address'),
          'description' => ts('Is this the billing address.'),
          'where' => 'civicrm_address.is_billing',
          'default' => '0',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
        ],
        'street_address' => [
          'name' => 'street_address',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Street Address'),
          'description' => ts('Concatenation of all routable street address components (prefix, street number, street name, suffix, unit
      number OR P.O. Box). Apps should be able to determine physical location with this data (for mapping, mail
      delivery, etc.).'),
          'maxlength' => 96,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_address.street_address',
          'headerPattern' => '/(street|address)/i',
          'dataPattern' => '/^(\d{1,5}( [0-9A-Za-z]+)+)$|^(P\.?O\.\? Box \d{1,5})$/i',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'street_number' => [
          'name' => 'street_number',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Street Number'),
          'description' => ts('Numeric portion of address number on the street, e.g. For 112A Main St, the street_number = 112.'),
          'where' => 'civicrm_address.street_number',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'street_number_suffix' => [
          'name' => 'street_number_suffix',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Street Number Suffix'),
          'description' => ts('Non-numeric portion of address number on the street, e.g. For 112A Main St, the street_number_suffix = A'),
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'where' => 'civicrm_address.street_number_suffix',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'street_number_predirectional' => [
          'name' => 'street_number_predirectional',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Street Direction Prefix'),
          'description' => ts('Directional prefix, e.g. SE Main St, SE is the prefix.'),
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'where' => 'civicrm_address.street_number_predirectional',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'street_name' => [
          'name' => 'street_name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Street Name'),
          'description' => ts('Actual street name, excluding St, Dr, Rd, Ave, e.g. For 112 Main St, the street_name = Main.'),
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'where' => 'civicrm_address.street_name',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'street_type' => [
          'name' => 'street_type',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Street Type'),
          'description' => ts('St, Rd, Dr, etc.'),
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'where' => 'civicrm_address.street_type',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'street_number_postdirectional' => [
          'name' => 'street_number_postdirectional',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Street Direction Suffix'),
          'description' => ts('Directional prefix, e.g. Main St S, S is the suffix.'),
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'where' => 'civicrm_address.street_number_postdirectional',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'street_unit' => [
          'name' => 'street_unit',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Street Unit'),
          'description' => ts('Secondary unit designator, e.g. Apt 3 or Unit # 14, or Bldg 1200'),
          'maxlength' => 16,
          'size' => CRM_Utils_Type::TWELVE,
          'where' => 'civicrm_address.street_unit',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'supplemental_address_1' => [
          'name' => 'supplemental_address_1',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Supplemental Address 1'),
          'description' => ts('Supplemental Address Information, Line 1'),
          'maxlength' => 96,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_address.supplemental_address_1',
          'headerPattern' => '/(supplemental(\s)?)?address(\s\d+)?/i',
          'dataPattern' => '/unit|ap(ar)?t(ment)?\s(\d|\w)+/i',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'supplemental_address_2' => [
          'name' => 'supplemental_address_2',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Supplemental Address 2'),
          'description' => ts('Supplemental Address Information, Line 2'),
          'maxlength' => 96,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_address.supplemental_address_2',
          'headerPattern' => '/(supplemental(\s)?)?address(\s\d+)?/i',
          'dataPattern' => '/unit|ap(ar)?t(ment)?\s(\d|\w)+/i',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'supplemental_address_3' => [
          'name' => 'supplemental_address_3',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Supplemental Address 3'),
          'description' => ts('Supplemental Address Information, Line 3'),
          'maxlength' => 96,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_address.supplemental_address_3',
          'headerPattern' => '/(supplemental(\s)?)?address(\s\d+)?/i',
          'dataPattern' => '/unit|ap(ar)?t(ment)?\s(\d|\w)+/i',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'city' => [
          'name' => 'city',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('City'),
          'description' => ts('City, Town or Village Name.'),
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'import' => TRUE,
          'where' => 'civicrm_address.city',
          'headerPattern' => '/city/i',
          'dataPattern' => '/^[A-Za-z]+(\.?)(\s?[A-Za-z]+){0,2}$/',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'county_id' => [
          'name' => 'county_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('County'),
          'description' => ts('Which County does this address belong to.'),
          'where' => 'civicrm_address.county_id',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'FKClassName' => 'CRM_Core_DAO_County',
          'html' => [
            'type' => 'ChainSelect',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_county',
            'keyColumn' => 'id',
            'labelColumn' => 'name',
          ],
        ],
        'state_province_id' => [
          'name' => 'state_province_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('State/Province'),
          'description' => ts('Which State_Province does this address belong to.'),
          'where' => 'civicrm_address.state_province_id',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'localize_context' => 'province',
          'FKClassName' => 'CRM_Core_DAO_StateProvince',
          'html' => [
            'type' => 'ChainSelect',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_state_province',
            'keyColumn' => 'id',
            'labelColumn' => 'name',
          ],
        ],
        'postal_code_suffix' => [
          'name' => 'postal_code_suffix',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Postal Code Suffix'),
          'description' => ts('Store the suffix, like the +4 part in the USPS system.'),
          'maxlength' => 12,
          'size' => 3,
          'import' => TRUE,
          'where' => 'civicrm_address.postal_code_suffix',
          'headerPattern' => '/p(ostal)\sc(ode)\ss(uffix)/i',
          'dataPattern' => '/\d?\d{4}(-\d{4})?/',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'postal_code' => [
          'name' => 'postal_code',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Postal Code'),
          'description' => ts('Store both US (zip5) AND international postal codes. App is responsible for country/region appropriate validation.'),
          'maxlength' => 64,
          'size' => 6,
          'import' => TRUE,
          'where' => 'civicrm_address.postal_code',
          'headerPattern' => '/postal|zip/i',
          'dataPattern' => '/\d?\d{4}(-\d{4})?/',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'usps_adc' => [
          'name' => 'usps_adc',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('USPS Code'),
          'description' => ts('USPS Bulk mailing code.'),
          'maxlength' => 32,
          'size' => CRM_Utils_Type::MEDIUM,
          'where' => 'civicrm_address.usps_adc',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
        ],
        'country_id' => [
          'name' => 'country_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Country'),
          'description' => ts('Which Country does this address belong to.'),
          'where' => 'civicrm_address.country_id',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'localize_context' => 'country',
          'FKClassName' => 'CRM_Core_DAO_Country',
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_country',
            'keyColumn' => 'id',
            'labelColumn' => 'name',
            'nameColumn' => 'iso_code',
            'abbrColumn' => 'iso_code',
          ],
        ],
        'geo_code_1' => [
          'name' => 'geo_code_1',
          'type' => CRM_Utils_Type::T_FLOAT,
          'title' => ts('Latitude'),
          'description' => ts('Latitude'),
          'import' => TRUE,
          'where' => 'civicrm_address.geo_code_1',
          'headerPattern' => '/geo/i',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'geo_code_2' => [
          'name' => 'geo_code_2',
          'type' => CRM_Utils_Type::T_FLOAT,
          'title' => ts('Longitude'),
          'description' => ts('Longitude'),
          'import' => TRUE,
          'where' => 'civicrm_address.geo_code_2',
          'headerPattern' => '/geo/i',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'manual_geo_code' => [
          'name' => 'manual_geo_code',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Is Manually Geocoded'),
          'description' => ts('Is this a manually entered geo code'),
          'where' => 'civicrm_address.manual_geo_code',
          'export' => TRUE,
          'default' => '0',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
        ],
        'timezone' => [
          'name' => 'timezone',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Timezone'),
          'description' => ts('Timezone expressed as a UTC offset - e.g. United States CST would be written as "UTC-6".'),
          'maxlength' => 8,
          'size' => CRM_Utils_Type::EIGHT,
          'where' => 'civicrm_address.timezone',
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'address_name' => [
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Address Name'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'import' => TRUE,
          'where' => 'civicrm_address.name',
          'headerPattern' => '/^location|(l(ocation\s)?name)$/i',
          'dataPattern' => '/^\w+$/',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
        ],
        'master_id' => [
          'name' => 'master_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Master Address Belongs To'),
          'description' => ts('FK to Address ID'),
          'import' => TRUE,
          'where' => 'civicrm_address.master_id',
          'export' => TRUE,
          'table_name' => 'civicrm_address',
          'entity' => 'Address',
          'bao' => 'CRM_Core_BAO_Address',
          'localizable' => 0,
          'FKClassName' => 'CRM_Core_DAO_Address',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'address', $prefix, [
      'CRM_Core_DAO_County',
      'CRM_Core_DAO_StateProvince',
      'CRM_Core_DAO_Country',
    ]);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'address', $prefix, [
      'CRM_Core_DAO_County',
      'CRM_Core_DAO_StateProvince',
      'CRM_Core_DAO_Country',
    ]);
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
        'sig' => 'civicrm_address::0::location_type_id',
      ],
      'index_is_primary' => [
        'name' => 'index_is_primary',
        'field' => [
          0 => 'is_primary',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_address::0::is_primary',
      ],
      'index_is_billing' => [
        'name' => 'index_is_billing',
        'field' => [
          0 => 'is_billing',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_address::0::is_billing',
      ],
      'index_street_name' => [
        'name' => 'index_street_name',
        'field' => [
          0 => 'street_name',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_address::0::street_name',
      ],
      'index_city' => [
        'name' => 'index_city',
        'field' => [
          0 => 'city',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_address::0::city',
      ],
      'index_geo_code_1_geo_code_2' => [
        'name' => 'index_geo_code_1_geo_code_2',
        'field' => [
          0 => 'geo_code_1',
          1 => 'geo_code_2',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_address::0::geo_code_1::geo_code_2',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
