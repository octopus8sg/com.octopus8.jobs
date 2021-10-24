<?php

require_once 'job.civix.php';

// phpcs:disable
use CRM_Job_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function job_civicrm_config(&$config)
{
    _job_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function job_civicrm_xmlMenu(&$files)
{
    _job_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function job_civicrm_install()
{
    _job_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function job_civicrm_postInstall()
{
    _job_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function job_civicrm_uninstall()
{
    _job_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function job_civicrm_enable()
{
    _job_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function job_civicrm_disable()
{
    _job_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function job_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL)
{
    return _job_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function job_civicrm_managed(&$entities)
{
    _job_civix_civicrm_managed($entities);
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
function job_civicrm_caseTypes(&$caseTypes)
{
    _job_civix_civicrm_caseTypes($caseTypes);
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
function job_civicrm_angularModules(&$angularModules)
{
    _job_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function job_civicrm_alterSettingsFolders(&$metaDataFolders = NULL)
{
    _job_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function job_civicrm_entityTypes(&$entityTypes)
{
    _job_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function job_civicrm_themes(&$themes)
{
    _job_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function job_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function job_civicrm_navigationMenu(&$menu)
{
    _job_civix_insert_navigation_menu($menu, 'Search', array(
        'label' => E::ts('Search Jobs'),
        'name' => 'search_jobs',
        'url' => 'civicrm/job/search',
        'permission' => 'access CiviMail',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _job_civix_navigationMenu($menu);
}

//function job_civicrm_navigationMenu(&$menu) {
//  _job_civix_insert_navigation_menu($menu, 'Mailings', array(
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ));
//  _job_civix_navigationMenu($menu);
//}

/**
 * Implementation of hook_civicrm_tabset
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tabset
 */
function job_civicrm_tabset($path, &$tabs, $context)
{
    if ($path === 'civicrm/contact/view') {
        // add a tab to the contact summary screen
        $contactId = $context['contact_id'];
        $contact = \Civi\Api4\Contact::get(0)
            ->addWhere('id', '=', $contactId)
            ->execute()->single();
        $contactType = $contact['contact_type'];
        $url = CRM_Utils_System::url('civicrm/job/contacttab', ['cid' => $contactId]);

        $myEntities = \Civi\Api4\Job::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $employers = array("Household",
            "Organization",
            "Team",
            "Sponsor"
        );
        $employees = array("Individual",
            "Student",
            "Parent",
            "Staff",
        );
        if (in_array($contactType, $employees)) {
            $tabs[] = array(
                'id' => 'employee_job',
                'url' => $url,
                'count' => $myEntities->count(),
                'title' => E::ts('Jobs'),
                'weight' => 1000,
                'icon' => 'crm-i fa-envelope-open',
            );
            $tabs[] = array(
                'id' => 'employee_application',
                'url' => $url,
                'count' => $myEntities->count(),
                'title' => E::ts('Applications'),
                'weight' => 1001,
                'icon' => 'crm-i fa-envelope-open',
            );
        } elseif (in_array($contactType, $employers)) {
            $tabs[] = array(
                'id' => 'employeer_job',
                'url' => $url,
                'count' => $myEntities->count(),
                'title' => E::ts('Jobs'),
                'weight' => 1000,
                'icon' => 'crm-i fa-envelope-open',
            );
        }
    }
}
