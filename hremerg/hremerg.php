<?php
/*
+--------------------------------------------------------------------+
| CiviHR version 1.2                                                 |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2013                                |
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

require_once __DIR__ . DIRECTORY_SEPARATOR . 'hremerg.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function hremerg_civicrm_config(&$config) {
  _hremerg_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function hremerg_civicrm_xmlMenu(&$files) {
  _hremerg_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function hremerg_civicrm_install() {
  return _hremerg_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function hremerg_civicrm_uninstall() {
  return _hremerg_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function hremerg_civicrm_enable() {
  return _hremerg_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function hremerg_civicrm_disable() {
  return _hremerg_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function hremerg_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _hremerg_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function hremerg_civicrm_managed(&$entities) {
  return _hremerg_civix_civicrm_managed($entities);
}

/**
 * @param string $formName
 * @param CRM_Core_Form $form
 */
function hremerg_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Contact_Form_Relationship' && empty($form->_caseId)) {
    if ($form->elementExists('relationship_type_id') && $form->_contactType == 'Individual') {
      $relationshipType = civicrm_api3('relationship_type', 'get', array('name_a_b' => 'Emergency Contact'));
      $select = $form->getElement('relationship_type_id');
      $select->freeze();
      $select->setLabel('');
      $form->getElement('related_contact_id')->setLabel('');
      if ($form->getAction() & CRM_Core_Action::ADD && !empty($relationshipType['id'])) {
        $form->setDefaults(array('relationship_type_id' => $relationshipType['id'] . '_a_b'));
      }
    }
  }
}
