<?php

require_once 'jobs.civix.php';
// phpcs:disable
use CRM_Jobs_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function jobs_civicrm_config(&$config) {
  _jobs_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function jobs_civicrm_xmlMenu(&$files) {
  _jobs_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function jobs_civicrm_install() {
  _jobs_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function jobs_civicrm_postInstall() {
  _jobs_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function jobs_civicrm_uninstall() {
  _jobs_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function jobs_civicrm_enable() {
  _jobs_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function jobs_civicrm_disable() {
  _jobs_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function jobs_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _jobs_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function jobs_civicrm_managed(&$entities) {
  _jobs_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function jobs_civicrm_caseTypes(&$caseTypes) {
  _jobs_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function jobs_civicrm_angularModules(&$angularModules) {
  _jobs_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function jobs_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _jobs_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function jobs_civicrm_entityTypes(&$entityTypes) {
  _jobs_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function jobs_civicrm_themes(&$themes) {
  _jobs_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function jobs_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function jobs_civicrm_navigationMenu(&$menu) {
    if (! CRM_Core_Permission::check('administer CiviCRM')) {
        CRM_Core_Session::setStatus('', ts('Insufficient permission'), 'error');
        return;
    }
//    $currentUserId = CRM_Core_Session::getLoggedInContactID();

    _jobs_civix_insert_navigation_menu($menu, '', array(
        'label' => E::ts('Jobs'),
        'name' => 'jobs',
        'icon' => 'crm-i fa-briefcase',
        'url' => 'civicrm/jobs',
        'permission' => 'access CiviCRM',
        'navID' => 10,
        'operator' => 'OR',
        'separator' => 0,
    ));
    _jobs_civix_navigationMenu($menu);
    _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
        'label' => E::ts('Dashboard'),
        'name' => 'jobs_dashboard',
        'url' => 'civicrm/jobs',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _jobs_civix_navigationMenu($menu);
    _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
        'label' => E::ts('Find Jobs'),
        'name' => 'search_jobs',
        'url' => 'civicrm/jobs/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _jobs_civix_navigationMenu($menu);
    _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
        'label' => E::ts('Add Job'),
        'name' => 'add_job',
        'url' => 'civicrm/jobs/form?reset=1&action=add',
        'permission' => 'administer CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _jobs_civix_navigationMenu($menu);
    _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
        'label' => E::ts('Find Applications'),
        'name' => 'search_application',
        'url' => 'civicrm/applications/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
  _jobs_civix_navigationMenu($menu);
}
