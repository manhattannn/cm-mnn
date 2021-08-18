<?php

class CRM_CivirulesActions_Tag_ContactTagRemove extends CRM_Civirules_Action {

  /**
   * Method processAction to execute the action
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @access public
   * @throws
   */
  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $contactId = $triggerData->getContactId();
    $actionParams = $this->getActionParameters();
    $entityTable = "civicrm_contact";
    $api4 = CRM_Civirules_Utils::isApi4Active();
    if (isset($actionParams['tag_id'])) {
      foreach ($actionParams['tag_id'] as $tagId) {
        if ($api4) {
          CRM_CivirulesActions_Tag_EntityTag::deleteApi4EntityTag($entityTable, $contactId, $tagId);
        }
        else {
          CRM_CivirulesActions_Tag_EntityTag::deleteApi3EntityTag($entityTable, $contactId, $tagId);
        }
      }
    }
  }

  /**
   * Method to return the url for additional form processing for action
   * and return false if none is needed
   *
   * @param int $ruleActionId
   * @return bool
   * @access public
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/action/tag/entitytag', 'tn=civicrm_contact&rule_action_id='
      . $ruleActionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   * @throws
   */
  public function userFriendlyConditionParams() {
    $actionParams = $this->getActionParameters();
    $labels = [];
    $tableName = "civicrm_contact";
    if (CRM_Civirules_Utils::isApi4Active()) {
      $tags = CRM_CivirulesActions_Tag_EntityTag::getApi4Tags($tableName);
    }
    else {
      $tags = CRM_CivirulesActions_Tag_EntityTag::getApi3Tags($tableName);
    }

    if (isset($actionParams['tag_id'])) {
      foreach ($actionParams['tag_id'] as $tagId) {
        if (isset($tags[$tagId])) {
          $labels[] = $tags[$tagId];
        }
      }
    }
    return "These tags will be removed from the contact:  " . implode(", ", $labels);
  }

}
