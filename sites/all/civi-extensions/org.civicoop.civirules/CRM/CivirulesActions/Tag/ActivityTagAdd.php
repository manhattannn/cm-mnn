<?php

class CRM_CivirulesActions_Tag_ActivityTagAdd extends CRM_Civirules_Action {

  /**
   * Method processAction to execute the action
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @access public
   * @throws
   */
  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $entityId = $triggerData->getEntityId();
    $actionParams = $this->getActionParameters();
    $entityTable = "civicrm_activity";
    $api4 = CRM_Civirules_Utils::isApi4Active();
    if (isset($actionParams['tag_id'])) {
      foreach ($actionParams['tag_id'] as $tagId) {
        if ($api4) {
          CRM_CivirulesActions_Tag_EntityTag::createApi4EntityTag($entityTable, $entityId, $tagId);
        }
        else {
          CRM_CivirulesActions_Tag_EntityTag::createApi3EntityTag($entityTable, $entityId, $tagId);
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
    return CRM_Utils_System::url('civicrm/civirule/form/action/tag/entitytag', 'tn=civicrm_activity&rule_action_id='
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
    $tableName = "civicrm_activity";
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
    return "These tags will be added to the activity:  " . implode(", ", $labels);
  }

  /**
   * Validates whether this action works with the selected trigger.
   *
   * @param CRM_Civirules_Trigger $trigger
   * @param CRM_Civirules_BAO_Rule $rule
   * @return bool
   */
  public function doesWorkWithTrigger(CRM_Civirules_Trigger $trigger, CRM_Civirules_BAO_Rule $rule) {
    $entities = $trigger->getProvidedEntities();
    return isset($entities['Activity']);
  }

}
