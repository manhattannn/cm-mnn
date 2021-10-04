<?php
/*
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC. All rights reserved.                        |
 |                                                                    |
 | This work is published under the GNU AGPLv3 license with some      |
 | permitted exceptions and without any warranty. For full license    |
 | and copyright information, see https://civicrm.org/licensing       |
 +--------------------------------------------------------------------+
 */

namespace Civi\Api4\Query;

/**
 * Sql function
 */
class SqlFunctionGROUP_CONCAT extends SqlFunction {

  public $supportsExpansion = TRUE;

  protected static $category = self::CATEGORY_AGGREGATE;

  protected static $params = [
    [
      'prefix' => ['', 'DISTINCT', 'ALL'],
      'expr' => 1,
      'must_be' => ['SqlField', 'sqlFunction'],
      'optional' => FALSE,
    ],
    [
      'prefix' => ['ORDER BY'],
      'expr' => 1,
      'suffix' => ['', 'ASC', 'DESC'],
      'must_be' => ['SqlField'],
      'optional' => TRUE,
    ],
    [
      'prefix' => ['SEPARATOR'],
      'expr' => 1,
      'must_be' => ['SqlString'],
      'optional' => TRUE,
      // @see self::formatOutput()
      'api_default' => [
        'expr' => ['"' . \CRM_Core_DAO::VALUE_SEPARATOR . '"'],
      ],
    ],
  ];

  /**
   * Reformat result as array if using default separator
   *
   * @see \Civi\Api4\Utils\FormattingUtil::formatOutputValues
   * @param string $value
   * @param string $dataType
   * @return string|array
   */
  public function formatOutputValue($value, &$dataType) {
    $exprArgs = $this->getArgs();
    // By default, values are split into an array and formatted according to the field's dataType
    if (!$exprArgs[2]['prefix']) {
      $value = explode(\CRM_Core_DAO::VALUE_SEPARATOR, $value);
      // If the first expression is another sqlFunction then unset $dataType to preserve raw string
      if ($exprArgs[0]['expr'][0] instanceof SqlFunction) {
        $dataType = NULL;
      }
    }
    // If using custom separator, unset $dataType to preserve raw string
    else {
      $dataType = NULL;
    }
    return $value;
  }

  /**
   * @return string
   */
  public static function getTitle(): string {
    return ts('List');
  }

}
