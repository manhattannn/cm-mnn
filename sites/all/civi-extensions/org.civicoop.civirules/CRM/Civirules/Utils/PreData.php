<?php

class CRM_Civirules_Utils_PreData {

  /**
   * Data set in pre and used for compare which field is changed
   *
   * @var array $preData
   */
  protected static $preData = array();

  /**
   * Method pre to store the entity data before the data in the database is changed
   * for the edit operation
   *
   * @param string $op
   * @param string $objectName
   * @param int $objectId
   * @param array $params
   * @param string $eventID
   */
  public static function pre($op, $objectName, $objectId, $params, $eventID) {
    // Do not trigger when objectName is empty. See issue #19
    if (empty($objectName)) {
      return;
    }
    $nonPreEntities = array('GroupContact', 'EntityTag', 'ActionLog');
    if ($op != 'edit' || in_array($objectName, $nonPreEntities)) {
      return;
    }
    // Don't execute this if no rules exist for this entity.
    $rules = CRM_Civirules_BAO_Rule::findRulesByObjectNameAndOp($objectName, $op);
    if (empty($rules)) {
      return;
    }

    /**
     * Not every object in CiviCRM sets the object id in the pre hook
     * But we need this to fetch the current data state from the database.
     * So we check if the ID is in the params array and if so we use that id
     * for fetching the data
     *
     */
    $id = $objectId;
    if (empty($id) && isset($params['id']) && !empty($params['id'])) {
      $id = $params['id'];
    }

    if (empty($id)) {
      return;
    }

    //retrieve data as it is currently in the database
    $entity = CRM_Civirules_Utils_ObjectName::convertToEntity($objectName);
    if (!$entity) {
      return;
    }
    try {
      $data = civicrm_api3($entity, 'getsingle', array('id' => $id));
    } catch (Exception $e) {
      return;
    }
    // add custom data fields
    try {
      $customData = civicrm_api3('CustomValue', 'get', array(
        'sequential' => 1,
        'entity_id' => $id,
        'entity_table' => ucfirst($entity),
      ));
    } catch (Exception $e ) {
      $customData = array();
    }
    if ( empty($customData['is_error']) && ! empty($customData['count']) ) {
      foreach ($customData['values'] as $customField ) {
        $data['custom_' . $customField['id']] = $customField['latest'];
      }

    }
    self::setPreData($entity, $id, $data, $eventID);
  }

  /**
   * Retrieve the original data when the customPre hook is called.
   *
   * @param $op
   * @param $groupID
   * @param $entityID
   * @param $params
   * @param $eventID
   */
  public static function customPre($op, $groupID, $entityID, $params, $eventID=1) {
    // We use api version 3 here as there is no api v4 for the CustomValue table.
    $entity = civicrm_api3('CustomGroup', 'getvalue', ['id' => $groupID, 'return' => 'extends']);
    $data = array();
    try {
      $data = civicrm_api3($entity, 'getsingle', array('id' => $entityID));
    } catch (Exception $e) {
      // Do nothing.
    }
    $customDataApiResult = civicrm_api3('CustomValue', 'get', ['entity_id' => $entityID, 'entity_table' => $entity]);
    foreach($customDataApiResult['values'] as $customField) {
      $data['custom_' . $customField['id']] = $customField['latest'];
    }
    self::setPreData($entity, $entityID, $data, $eventID);
  }

  /**
   * Method to set the pre operation data
   *
   * @param string $entity
   * @param int $entityId
   * @param array $data
   * @access protected
   * @static
   */
  protected static function setPreData($entity, $entityId, $data, $eventID) {
    self::$preData[$entity][$entityId][$eventID] = $data;
  }

  /**
   * Method to get the pre operation data
   *
   * @param string $entity
   * @param int $entityId
   * @return array
   * @access protected
   * @static
   */
  public static function getPreData($entity, $entityId, $eventID) {
    if (isset(self::$preData[$entity][$entityId][$eventID])) {
      return self::$preData[$entity][$entityId][$eventID];
    }
    return array();
  }

}
