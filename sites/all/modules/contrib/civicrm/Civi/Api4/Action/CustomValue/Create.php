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

namespace Civi\Api4\Action\CustomValue;

/**
 * @inheritDoc
 */
class Create extends \Civi\Api4\Generic\DAOCreateAction {
  use \Civi\Api4\Generic\Traits\CustomValueActionTrait;

}
