<?php

const VIEW_OCTOPUS_8_JOBS = 'view octopus8 jobs';
const DELETE_OCTOPUS_8_JOBS = 'delete octopus8 jobs';
const EDIT_OCTOPUS_8_JOBS = 'edit octopus8 jobs';
require_once 'jobs.civix.php';

// phpcs:disable
use CRM_Jobs_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function jobs_civicrm_config(&$config)
{
    _jobs_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function jobs_civicrm_xmlMenu(&$files)
{
    _jobs_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function jobs_civicrm_install()
{
    _jobs_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function jobs_civicrm_postInstall()
{
    _jobs_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function jobs_civicrm_uninstall()
{
    _jobs_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function jobs_civicrm_enable()
{
    _jobs_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function jobs_civicrm_disable()
{
    _jobs_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function jobs_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL)
{
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
function jobs_civicrm_managed(&$entities)
{
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
function jobs_civicrm_caseTypes(&$caseTypes)
{
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
function jobs_civicrm_angularModules(&$angularModules)
{
    _jobs_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function jobs_civicrm_alterSettingsFolders(&$metaDataFolders = NULL)
{
    _jobs_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function jobs_civicrm_entityTypes(&$entityTypes)
{
    _jobs_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function jobs_civicrm_themes(&$themes)
{
    _jobs_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
function jobs_civicrm_preProcess($formName, &$form)
{
    try {
        if ($formName == 'CRM_Jobs_Form_JobsForm') {
            _jobs_add_grouptree($form);
//        _esignature_debug($form);
        }
        if ($formName == 'CRM_Custom_Form_CustomDataByType') {
            _jobs_add_grouptree($form);
//        _esignature_debug($form);
        }
        if ($formName == 'CRM_Custom_Form_Group') {
            _jobs_add_grouptree($form);
//        _esignature_debug($form);
        }

    } catch (Exception $e) {

    }
}

/**
 * Implementation of hook_civicrm_permission
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_permission/
 */
function jobs_civicrm_permission(&$permissions)
{
    $permissions[VIEW_OCTOPUS_8_JOBS] = E::ts('Octopus8 Jobs: View Jobs/Applications');
    $permissions[EDIT_OCTOPUS_8_JOBS] = E::ts('Octopus8 Jobs: Edit/Create Jobs/Applications');
    $permissions[DELETE_OCTOPUS_8_JOBS] = E::ts('Octopus8 Jobs: Delete Jobs/Applications');
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function jobs_civicrm_navigationMenu(&$menu)
{
    $can_view = CRM_Core_Permission::check(VIEW_OCTOPUS_8_JOBS);
    $can_delete = CRM_Core_Permission::check(DELETE_OCTOPUS_8_JOBS);
    $can_edit = CRM_Core_Permission::check(EDIT_OCTOPUS_8_JOBS);
    if ($can_edit || $can_delete || $can_view) {
//    $currentUserId = CRM_Core_Session::getLoggedInContactID();

        _jobs_civix_insert_navigation_menu($menu, '', array(
            'label' => E::ts('Jobs'),
            'name' => 'jobs',
            'icon' => 'crm-i fa-briefcase',
            'url' => 'civicrm/jobs',
            'permission' => VIEW_OCTOPUS_8_JOBS,
            'navID' => 10,
            'operator' => 'OR',
            'separator' => 0,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Dashboard'),
            'name' => 'jobs_dashboard',
            'url' => VIEW_OCTOPUS_8_JOBS,
            'permission' => 'access CiviCRM',
            'operator' => 'OR',
            'separator' => 0,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Find Jobs'),
            'name' => 'search_jobs',
            'url' => 'civicrm/jobs/search',
            'permission' => VIEW_OCTOPUS_8_JOBS,
            'operator' => 'OR',
            'separator' => 0,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Add Job'),
            'name' => 'add_job',
            'url' => 'civicrm/jobs/form?reset=1&action=add',
            'permission' => EDIT_OCTOPUS_8_JOBS,
            'operator' => 'OR',
            'separator' => 0,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Find Applications'),
            'name' => 'search_application',
            'url' => 'civicrm/applications/search',
            'permission' => VIEW_OCTOPUS_8_JOBS,
            'operator' => 'OR',
            'separator' => 0,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Import Jobs'),
            'name' => 'import_jobs',
            'url' => 'civicrm/csvimporter/import?entity=SscJob',
            'permission' => EDIT_OCTOPUS_8_JOBS,
            'operator' => 'OR',
            'separator' => 2,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Import Applications'),
            'name' => 'import_applications',
            'url' => 'civicrm/csvimporter/import?entity=SscJob',
            'permission' => EDIT_OCTOPUS_8_JOBS,
            'operator' => 'OR',
            'separator' => 0,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Job Reports'),
            'name' => 'job_reports',
            'url' => CRM_Utils_System::url('civicrm/report/list', ['grp' => 'jobs', 'reset' => 1]),
            'permission' => VIEW_OCTOPUS_8_JOBS,
            'operator' => 'OR',
            'separator' => 2,
        ));
        _jobs_civix_navigationMenu($menu);
        _jobs_civix_insert_navigation_menu($menu, 'jobs', array(
            'label' => E::ts('Run a Function'),
            'name' => 'run_a_fun',
            'url' => 'civicrm/jobs/runafun',
            'permission' => 'administer CiviCRM',
            'operator' => 'OR',
            'separator' => 2,
        ));
        _jobs_civix_navigationMenu($menu);
    }
}

/**
 * @param $form
 * @param $groupTree
 * @throws API_Exception
 * @throws CRM_Core_Exception
 */
function _jobs_add_grouptree(&$form)
{
    $groupTree = [];
    $type = $form->_type;
    $subType = CRM_Utils_Request::retrieve('subType', 'String');
    $subName = CRM_Utils_Request::retrieve('subName', 'String');
    $groupCount = CRM_Utils_Request::retrieve('cgcount', 'Positive');
    $entityId = CRM_Utils_Request::retrieve('entityID', 'Positive');
    $contactID = CRM_Utils_Request::retrieve('cid', 'Positive');
    $groupID = CRM_Utils_Request::retrieve('groupID', 'Positive');
    $onlySubtype = CRM_Utils_Request::retrieve('onlySubtype', 'Boolean');
    $action = CRM_Utils_Request::retrieve('action', 'Alphanumeric');
    $contactTypes = CRM_Contact_BAO_ContactType::contactTypeInfo();
    if (!is_array($subType) && strstr($subType, CRM_Core_DAO::VALUE_SEPARATOR)) {
        $subType = str_replace(CRM_Core_DAO::VALUE_SEPARATOR, ',', trim($subType, CRM_Core_DAO::VALUE_SEPARATOR));
    }
    $singleRecord = NULL;
    if (!empty($form->_groupCount) && !empty($form->_multiRecordDisplay) && $form->_multiRecordDisplay == 'single') {
        $singleRecord = $form->_groupCount;
    }
    $mode = CRM_Utils_Request::retrieve('mode', 'String', $form);
    // when a new record is being added for multivalued custom fields.
    if (isset($form->_groupCount) && $form->_groupCount == 0 && $mode == 'add' &&
        !empty($form->_multiRecordDisplay) && $form->_multiRecordDisplay == 'single') {
        $singleRecord = 'new';
    }
    $options = [$form->_type,
        NULL,
        $entityId,
        $groupID,
        $subType,
        $form->_subName,
        TRUE,
        $onlySubtype,
        FALSE,
        null,
        $singleRecord];

    $groupTree = CRM_Core_BAO_CustomGroup::getTree(...$options);
//    CRM_Core_Error::debug_var('gr0', $groupTree);
    $groupTree = CRM_Core_BAO_CustomGroup::formatGroupTree($groupTree, 1, $form);
//    CRM_Core_Error::debug_var('gr1', $groupTree);
    $form->assign('eSignature_groupTree', $groupTree);
    if ($groupTree) {
        foreach ($groupTree as $id => $group) {
            if (isset($group['fields'])) {
                foreach ($group['fields'] as $field) {
                    $required = $field['is_required'] ?? NULL;
                    if ($field['html_type'] == 'eSignature') {
                        $fieldId = $field['id'];
                        $elementName = $field['element_name'];
//                        $signatures[] = $elementName;
                        _jobs_addQuickFormSignatureElement($form, $elementName, $fieldId, $required);
                        if ($form->getAction() == CRM_Core_Action::VIEW) {
                            $form->getElement($elementName)->freeze();
                        }
                    }
                }
            }
        }
    }
}

/**
 * Add a custom field to an existing form.
 *
 * @param CRM_Core_Form $qf
 *   Form object (reference).
 * @param string $elementName
 *   Name of the custom field.
 * @param int $fieldId
 * @param bool $useRequired
 *   True if required else false.
 * @param bool $search
 *   True if used for search else false.
 * @param string $label
 *   Label for custom field.
 * @return \HTML_QuickForm_Element|null
 * @throws \CiviCRM_API3_Exception
 */
function _jobs_addQuickFormSignatureElement(
    $qf, $elementName, $fieldId, $useRequired = TRUE, $search = FALSE, $label = NULL
)
{
    $field = CRM_Core_BAO_CustomField::getFieldObject($fieldId);
    $element = NULL;
//    CRM_Core_Error::debug_var('field_before_add', $field);
    if (!isset($label)) {
        $label = $field->label;
    }

    // DAO stores attributes as a string, but it's hard to manipulate and
    // CRM_Core_Form::add() wants them as an array.
    $fieldAttributes = CRM_Core_BAO_CustomField::attributesFromString($field->attributes);

    // Custom field HTML should indicate group+field name
    $groupName = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomGroup', $field->custom_group_id);
    $fieldAttributes['data-crm-custom'] = $groupName . ':' . $field->name;
    $fieldAttributes['class'] = "eSignature" . $fieldId;
    // at some point in time we might want to split the below into small functions
    //element name for profile edit differs?
    $element = $qf->add('text', $elementName, $label,
        $fieldAttributes,
        $useRequired && !$search
    );
    CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'CRM/Esignaturecustomfield/Page/ElSignature.tpl',
    ));

    if ($field->is_view && !$search) {
        $qf->freeze($elementName);
    }
//    CRM_Core_Error::debug_var('element_after_add', $element);

    return $element;

}


/**
 * Implementation of hook_civicrm_tabset
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tabset
 */
function jobs_civicrm_tabset($path, &$tabs, $context)
{
    $can_view = CRM_Core_Permission::check(VIEW_OCTOPUS_8_JOBS);
    $can_delete = CRM_Core_Permission::check(DELETE_OCTOPUS_8_JOBS);
    $can_edit = CRM_Core_Permission::check(EDIT_OCTOPUS_8_JOBS);
    if ($can_edit || $can_delete || $can_view) {
        if ($path === 'civicrm/contact/view') {
            // add a tab to the contact summary screen
            $contactId = $context['contact_id'];
            $contact = \Civi\Api4\Contact::get(FALSE)
                ->addWhere('id', '=', $contactId)
                ->execute()->single();
            $contactType = $contact['contact_type'];
            $employeesurl = CRM_Utils_System::url('civicrm/jobs/employeetab', ['cid' => $contactId]);
            $employersurl = CRM_Utils_System::url('civicrm/jobs/employertab', ['cid' => $contactId]);

            $employeeEntities = \Civi\Api4\SscApplication::get(FALSE)
                ->selectRowCount()
                ->addWhere('contact_id', '=', $contactId)
                ->execute();
            $employerEntities = \Civi\Api4\SscJob::get(FALSE)
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
                    'url' => $employeesurl,
                    'count' => $employeeEntities->count(),
                    'title' => E::ts('Jobs'),
                    'weight' => 1000,
                    'icon' => 'crm-i fa-briefcase',
                );
            } elseif (in_array($contactType, $employers)) {
                $tabs[] = array(
                    'id' => 'employeer_job',
                    'url' => $employersurl,
                    'count' => $employerEntities->count(),
                    'title' => E::ts('Jobs'),
                    'weight' => 1000,
                    'icon' => 'crm-i fa-briefcase',
                );
            }
        }
    }
}