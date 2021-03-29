<?php
/**
 * Class for CiviRules adding an activity to the system
 *
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license AGPL-3.0
 */

class CRM_CivirulesActions_Activity_Add extends CRM_CivirulesActions_Generic_Api {

  // Store a list of api params passed to action
  protected $apiParams = [];

  // Store the triggering activity id
  protected $activityId;

  // Store a list of new assigned contacts
  protected $asignedContacts = [];

  /**
   * Returns an array with parameters used for processing an action
   *
   * @param array $params
   * @param object CRM_Civirules_TriggerData_TriggerData $triggerData
   * @return array $params
   * @access protected
   */
  protected function alterApiParameters($params, CRM_Civirules_TriggerData_TriggerData $triggerData) {
    
    // Store params
    $this->apiParams = $params;

    $action_params = $this->getActionParameters();
    
    //this function could be overridden in subclasses to alter parameters to meet certain criteraia
    $params['target_contact_id'] = $triggerData->getContactId();
    $params['activity_type_id'] = $action_params['activity_type_id'];
    $params['status_id'] = $action_params['status_id'];
    $params['subject'] = $action_params['subject'];

    if (!empty($action_params['assignee_contact_id'])) {
      $assignee = array();
      if (is_array($action_params['assignee_contact_id'])) {
        foreach($action_params['assignee_contact_id'] as $contact_id) {
          if($contact_id) {
            $assignee[] = $contact_id;
          }
        }
      } else {
        $assignee[] = $action_params['assignee_contact_id'];
      }
      if (count($assignee)) {
        $params['assignee_contact_id'] = $action_params['assignee_contact_id'];
      } else {
        $params['assignee_contact_id'] = '';
      }

      // Store the assigned contacts to send a notification email
      if (!empty($params['assignee_contact_id'])) {
        $this->asignedContacts = (array)$params['assignee_contact_id'];
      }
    }

    // issue #127: no activity date time if set to null
    if ($action_params['activity_date_time'] == 'null') {
      unset($params['activity_date_time']);
    } else {
      if (!empty($action_params['activity_date_time'])) {
        $delayClass = unserialize($action_params['activity_date_time']);
        if ($delayClass instanceof CRM_Civirules_Delay_Delay) {
          $activityDate = $delayClass->delayTo(new DateTime(), $triggerData);
          if ($activityDate instanceof DateTime) {
            $params['activity_date_time'] = $activityDate->format('Ymd His');
          }
        }
      }
    }

    // Issue #152: when a rule is trigger from a public page then source contact id
    // is empty and that in turn creates a fatal error.
    // So the solution is to check whether we have a logged in user and if not use
    // the contact from the trigger as the source contact.
    if (CRM_Core_Session::getLoggedInContactID()) {
      $params['source_contact_id'] = CRM_Core_Session::getLoggedInContactID();
    } else {
      $params['source_contact_id'] = $triggerData->getContactId();
    }
    return $params;
  }

  /**
   * Process the action
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @access public
   */
  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    
    // Process the action, may throw Exceptions
    parent::processAction($triggerData);

    // Check if we need to send any emails
    if (!empty($this->apiParams['send_email']) && !empty($this->activityId) && !empty($this->asignedContacts)) {
      foreach ($this->asignedContacts as $contactId) {
        
        $contact = civicrm_api3('Contact', 'getsingle', ['id' => $contactId]);
        
        // check contact has an email
        if (empty($contact['email']))
          continue;
        
        CRM_Case_BAO_Case::sendActivityCopy(NULL, $this->activityId, [$contact['email'] => $contact], NULL, NULL);
      }
    }
  }

  /**
   * Executes the action
   * Overrided to save new activity id
   *
   * This method could be overridden if needed
   *
   * @param $entity
   * @param $action
   * @param $parameters
   * @access protected
   * @throws Exception on api error
   */
  protected function executeApiAction($entity, $action, $parameters) {
    try {
      $activity = civicrm_api3($entity, $action, $parameters);
      $this->activityId = $activity['id'];
    } catch (Exception $e) {
      $formattedParams = '';
      foreach($parameters as $key => $param) {
        if (strlen($formattedParams)) {
          $formattedParams .= ', ';
        }
        $formattedParams .= "{$key}=\"$param\"";
      }
      $message = "Civirules api action exception: {$e->getMessage()}. API call: {$entity}.{$action} with params: {$formattedParams}";
      \Civi::log()->error($message);
      throw new Exception($message);
    }
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a action
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleActionId
   * @return bool|string
   * @access public
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/action/activity', 'rule_action_id='.$ruleActionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   * @throws \CiviCRM_API3_Exception
   */
  public function userFriendlyConditionParams() {
    $return = '';
    $params = $this->getActionParameters();
    if (!empty($params['activity_type_id'])) {
      $type = civicrm_api3('OptionValue', 'getvalue', array(
        'return' => 'label',
        'option_group_id' => 'activity_type',
        'value' => $params['activity_type_id']));
      $return .= ts("Type: %1", array(1 => $type));
    }
    if (!empty($params['status_id'])) {
      $status = civicrm_api3('OptionValue', 'getvalue', array(
        'return' => 'label',
        'option_group_id' => 'activity_status',
        'value' => $params['status_id']));
      $return .= "<br>";
      $return .= ts("Status: %1", array(1 => $status));
    }
    $subject = $params['subject'];
    if (!empty($subject)) {
      $return .= "<br>";
      $return .= ts("Subject: %1", array(1 => $subject));
    }
    if (!empty($params['assignee_contact_id'])) {
      if (!is_array($params['assignee_contact_id'])) {
        $params['assignee_contact_id'] = array($params['assignee_contact_id']);
      }
      $assignees = '';
      foreach($params['assignee_contact_id'] as $cid) {
        try {
          $assignee = civicrm_api3('Contact', 'getvalue', array('return' => 'display_name', 'id' => $cid));
          if ($assignee) {
            if (strlen($assignees)) {
              $assignees .= ', ';
            }
            $assignees .= $assignee;
          }
        } catch (Exception $e) {
          //do nothing
        }
      }

      $return .= '<br>';
      $return .= ts("Assignee(s): %1", array(1 => $assignees));
      
    }

    if (!empty($params['activity_date_time'])) {
      if ($params['activity_date_time'] != 'null') {
        $delayClass = unserialize(($params['activity_date_time']));
        if ($delayClass instanceof CRM_Civirules_Delay_Delay) {
          $return .= '<br>'.ts('Activity date time').': '.$delayClass->getDelayExplanation();
        }
      }
    }

    if (!empty($params['send_email'])) {
      $return .= '<br>'.ts('Send notification');
    }

    return $return;
  }

  /**
   * Method to set the api entity
   *
   * @return string
   * @access protected
   */
  protected function getApiEntity() {
    return 'Activity';
  }

  /**
   * Method to set the api action
   *
   * @return string
   * @access protected
   */
  protected function getApiAction() {
    return 'create';
  }

}
