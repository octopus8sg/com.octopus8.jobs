<?php

use CRM_Jobs_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Jobs_Upgrader extends CRM_Jobs_Upgrader_Base
{

    // By convention, functions that look like "function upgrade_NNNN()" are
    // upgrade tasks. They are executed in order (like Drupal's hook_update_N).

    /**
     * Example: Run an external SQL script when the module is installed.
     *
     * public function install() {
     * $this->executeSqlFile('sql/myinstall.sql');
     * }
     */
    public function install()
    {
        // Create custom value option for custom fields
        // Create the job_role, job_location, job_status option groups
//        first uninstall
        $this->uninstall();

        // todo Create custom value option for custom fields

        try {
            civicrm_api3('OptionValue', 'create', [
                'option_group_id' => "cg_extend_objects",
                'label' => E::ts('Jobs'),
                'value' => 'SscJob',
                'name' => 'civicrm_o8_job',
                'description' => 'CRM_Jobs_PseudoConstant::jobRole;',
            ]);

        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'o8_job_role', 'title' => E::ts('Role')]);
            $typeOptionGroupId = $typeOptionGroupId['id'];
            civicrm_api3('OptionValue', 'create',
                ['value' => 1,
                    'is_default' => '1',
                    'name' => 'manager',
                    'label' => E::ts('Manager'),
                    'option_group_id' => $typeOptionGroupId
                ]);
            civicrm_api3('OptionValue', 'create',
                ['value' => 2,
                    'name' => 'ceo',
                    'label' => E::ts('CEO'),
                    'option_group_id' => $typeOptionGroupId
                ]);
            civicrm_api3('OptionValue', 'create',
                ['value' => 3,
                    'name' => 'cto',
                    'label' => E::ts('CTO'),
                    'option_group_id' => $typeOptionGroupId
                ]);
            civicrm_api3('OptionValue', 'create',
                ['value' => 4,
                    'name' => 'accountant',
                    'label' => E::ts('Accountant'),
                    'option_group_id' => $typeOptionGroupId
                ]);
            civicrm_api3('OptionValue', 'create',
                ['value' => 5,
                    'name' => 'lawyer',
                    'label' => E::ts('Lawyer'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {

            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'o8_job_location', 'title' => E::ts('Location')]);
            $typeOptionGroupId = $typeOptionGroupId['id'];
            civicrm_api3('OptionValue', 'create',
                ['value' => 1,
                    'is_default' => '1',
                    'name' => 'remote',
                    'label' => E::ts('Remote'),
                    'option_group_id' => $typeOptionGroupId
                ]);
            civicrm_api3('OptionValue', 'create',
                ['value' => 2,
                    'name' => 'on-site',
                    'label' => E::ts('On-Site'),
                    'option_group_id' => $typeOptionGroupId
                ]);
            civicrm_api3('OptionValue', 'create',
                ['value' => 3,
                    'name' => 'home-based',
                    'label' => E::ts('Home-Based'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'o8_job_status', 'title' => E::ts('Status')]);
            $typeOptionGroupId = $typeOptionGroupId['id'];
            civicrm_api3('OptionValue', 'create',
                ['value' => 1,
                    'is_default' => '1',
                    'name' => 'new',
                    'label' => E::ts('New'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => 2,
                    'name' => 'applied',
                    'label' => E::ts('Applied'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => 3,
                    'name' => 'withdrawn',
                    'label' => E::ts('Withdrawn'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'o8_application_status', 'title' => E::ts('Status')]);
            $typeOptionGroupId = $typeOptionGroupId['id'];
            civicrm_api3('OptionValue', 'create',
                ['value' => CRM_Jobs_BAO_SscApplication::NOTSHORTLISTED,
                    'is_default' => '1',
                    'name' => 'not_shortlisted',
                    'label' => E::ts('Not Shortlisted'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => CRM_Jobs_BAO_SscApplication::SHORTLISTED,
                    'name' => 'shortlisted',
                    'label' => E::ts('Shortlisted'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => CRM_Jobs_BAO_SscApplication::SELECTED,
                    'name' => 'selected',
                    'label' => E::ts('Selected'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => CRM_Jobs_BAO_SscApplication::REJECTED,
                    'name' => 'rejected',
                    'label' => E::ts('Rejected'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => CRM_Jobs_BAO_SscApplication::WITHDRAWN,
                    'name' => 'withdrawn',
                    'label' => E::ts('Withdrawn'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $this->executeSqlFile('sql/samplejobs.sql');
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $this->executeSqlFile('sql/sampleapps.sql');
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        $this->createCustomFieldsAndOptions();
    }

    /**
     * Example: Work with entities usually not available during the install step.
     *
     * This method can be used for any post-install tasks. For example, if a step
     * of your installation depends on accessing an entity that is itself
     * created during the installation (e.g., a setting or a managed entity), do
     * so here to avoid order of operation problems.
     */
    // public function postInstall() {
    //  $customFieldId = civicrm_api3('CustomField', 'getvalue', array(
    //    'return' => array("id"),
    //    'name' => "customFieldCreatedViaManagedHook",
    //  ));
    //  civicrm_api3('Setting', 'create', array(
    //    'myWeirdFieldSetting' => array('id' => $customFieldId, 'weirdness' => 1),
    //  ));
    // }

    /**
     * Example: Run an external SQL script when the module is uninstalled.
     */
    // public function uninstall() {
    //  $this->executeSqlFile('sql/myuninstall.sql');
    // }
    public function uninstall()
    {
        try {
            $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'o8_job_role']);
            $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
            foreach ($optionValues['values'] as $optionValue) {
                civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
            }
            civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'o8_job_location']);
            $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
            foreach ($optionValues['values'] as $optionValue) {
                civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
            }
            civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'o8_job_status']);
            $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
            foreach ($optionValues['values'] as $optionValue) {
                civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
            }
            civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'o8_application_status']);
            $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
            foreach ($optionValues['values'] as $optionValue) {
                civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
            }
            civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
//      todo custom fields for jobs
        try {
            $customGroups = civicrm_api3('CustomGroup', 'get', [
                'extends' => 'Jobs',
                'options' => ['limit' => 0],
            ]);
            foreach ($customGroups['values'] as $customGroup) {
                $customFields = civicrm_api3('CustomField', 'get', [
                    'custom_group_id' => $customGroup['id'],
                    'options' => ['limit' => 0],
                ]);
                foreach ($customFields['values'] as $customField) {
                    civicrm_api3('CustomField', 'delete', ['id' => $customField['id']]);
                }
                civicrm_api3('CustomGroup', 'delete', ['id' => $customGroup['id']]);
            }
            // Remove our entity from the cg_extend_objects option group.
            $cgExtendOptionId = civicrm_api3('OptionValue', 'getvalue', [
                'option_group_id' => "cg_extend_objects",
                'value' => 'Jobs',
                'return' => 'id',
            ]);
            civicrm_api3('OptionValue', 'delete', ['id' => $cgExtendOptionId]);
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
    }

    public function createCustomFieldsAndOptions()
    {
        $jcfields = $ecfields = $eecfields = $econfigs = $jconfigs = [];
        $econfigs = json_decode(file_get_contents(
            E::path('js/employerOptions.json')
        ), true);
        $ecfields = json_decode(file_get_contents(
            E::path('js/employerCustomFields.json')
        ), true);
        $eecfields = json_decode(file_get_contents(
            E::path('js/employeeCustomFields.json')
        ), true);
        $jcfields = json_decode(file_get_contents(
            E::path('js/jobsCustomFields.json')
        ), true);
        $jconfigs = json_decode(file_get_contents(
            E::path('js/jobsOptions.json')
        ), true);
//    $result0 = deleteCustomFieldByName('SKILLS');
//    $result0 = deleteCustomFieldByName('o8_skills');
//        CRM_Core_Error::debug_var('eecfields', $eecfields);
//        CRM_Core_Error::debug_var('econfigs', $econfigs);
//        CRM_Core_Error::debug_var('jcfields', $jcfields);
        createEmployerFields($econfigs, $ecfields);
        createJobFields($jconfigs, $jcfields);
        createEmployeeFields($eecfields);
    }

    /**
     * Example: Run a simple query when a module is enabled.
     */
    // public function enable() {
    //  CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 1 WHERE bar = "whiz"');
    // }

    /**
     * Example: Run a simple query when a module is disabled.
     */
    // public function disable() {
    //   CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 0 WHERE bar = "whiz"');
    // }

    /**
     * Example: Run a couple simple queries.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4200() {
    //   $this->ctx->log->info('Applying update 4200');
    //   CRM_Core_DAO::executeQuery('UPDATE foo SET bar = "whiz"');
    //   CRM_Core_DAO::executeQuery('DELETE FROM bang WHERE willy = wonka(2)');
    //   return TRUE;
    // }


    /**
     * Example: Run an external SQL script.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4201() {
    //   $this->ctx->log->info('Applying update 4201');
    //   // this path is relative to the extension base dir
    //   $this->executeSqlFile('sql/upgrade_4201.sql');
    //   return TRUE;
    // }


    /**
     * Example: Run a slow upgrade process by breaking it up into smaller chunk.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4202() {
    //   $this->ctx->log->info('Planning update 4202'); // PEAR Log interface

    //   $this->addTask(E::ts('Process first step'), 'processPart1', $arg1, $arg2);
    //   $this->addTask(E::ts('Process second step'), 'processPart2', $arg3, $arg4);
    //   $this->addTask(E::ts('Process second step'), 'processPart3', $arg5);
    //   return TRUE;
    // }
    // public function processPart1($arg1, $arg2) { sleep(10); return TRUE; }
    // public function processPart2($arg3, $arg4) { sleep(10); return TRUE; }
    // public function processPart3($arg5) { sleep(10); return TRUE; }

    /**
     * Example: Run an upgrade with a query that touches many (potentially
     * millions) of records by breaking it up into smaller chunks.
     *
     * @return TRUE on success
     * @throws Exception
     */
    // public function upgrade_4203() {
    //   $this->ctx->log->info('Planning update 4203'); // PEAR Log interface

    //   $minId = CRM_Core_DAO::singleValueQuery('SELECT coalesce(min(id),0) FROM civicrm_contribution');
    //   $maxId = CRM_Core_DAO::singleValueQuery('SELECT coalesce(max(id),0) FROM civicrm_contribution');
    //   for ($startId = $minId; $startId <= $maxId; $startId += self::BATCH_SIZE) {
    //     $endId = $startId + self::BATCH_SIZE - 1;
    //     $title = E::ts('Upgrade Batch (%1 => %2)', array(
    //       1 => $startId,
    //       2 => $endId,
    //     ));
    //     $sql = '
    //       UPDATE civicrm_contribution SET foobar = whiz(wonky()+wanker)
    //       WHERE id BETWEEN %1 and %2
    //     ';
    //     $params = array(
    //       1 => array($startId, 'Integer'),
    //       2 => array($endId, 'Integer'),
    //     );
    //     $this->addTask($title, 'executeSql', $sql, $params);
    //   }
    //   return TRUE;
    // }

}


/**
 * @param $jconfigs
 * @param $jcfields
 * @throws CiviCRM_API3_Exception
 */
function createJobFields($jconfigs, $jcfields)
{
    $group_code = "spd_o8_job";
    $hasgroup = civicrm_api3('CustomGroup', 'get', [
        'return' => ["id"],
        'name' => $group_code,
    ]);
    $create_custom_group = TRUE;
    if (isset($hasgroup['id'])) {
        $create_custom_group = FALSE;
        $group_id = $hasgroup['id'];
    }
    if ($create_custom_group) {
        $grouparray = [
//            'debug' => 1,
            'title' => "Jobs Custom Fields",
            'extends' => "SscJob",
            'name' => $group_code,
            'collapse_display' => 0,
        ];
        $newgroup = civicrm_api3('CustomGroup', 'create', $grouparray);
        $group_id = $newgroup['id'];
    } else {
//        echo 'Jobs will not be created';
    }
    $customvaluepositions = 0;
    foreach ($jconfigs as $config) {
//        CRM_Core_Error::debug_var('config', $config);
        $code = $config['_id']['$oid'];
        if (isset($config['configType'])) {
            $name = $config['configType'];
            $name = trim($name);
        } else {
            $name = $code;
        }

        //        $result0 = deleteCustomFieldByName($code);
//        $result1 = deleteCustomFieldByLabel($name);
        $option_values = [];
        if (isset($config['option_values'])) {
            $option_values = $config['option_values'];
        }
        $option_values = array_map('trim', $option_values);
        $option_values_id = addOptionsToOptionValuesByCode($code, $option_values, $name);
        //        CRM_Core_Error::debug_var('option_values_id', $option_values_id);
//        CRM_Core_Error::debug_var('name', $name);
//        CRM_Core_Error::debug_var('code', $code);
        if ($name == 'AUDIENCE' OR $name == 'SKILL') {
            $customfield = [
                'custom_group_id' => $group_id,
                'name' => $code,
                'weight' => $customvaluepositions,
                'label' => $name,
                'serialize' => 1,
                'option_group_id' => $option_values_id,
                'html_type' => "Select",
            ];
//            CRM_Core_Error::debug_var('optionsarray'.$code, $optionsarray);
            $result = getCustomFieldByCode($code, $customfield);
//            CRM_Core_Error::debug_var('result'.$code, $result);
            $customvaluepositions = $customvaluepositions + 1;
        }
    }
//    CRM_Core_Error::debug_var('cfields', $jcfields);

    foreach ($jcfields as $customf) {
//        CRM_Core_Error::debug_var('fecustom'.$customf['name'], $customf);
        $type = $customf['fieldType'];
        $position = $customvaluepositions + $customf['position'];
        $name = $customf['name'];
        $name = trim($name);
        $option_values = $customf['option_values'];
        $option_values = array_map('trim', $option_values);
        $code = $customf['code']['$oid'];
        $option_group_id = addOptionsToOptionValuesByCode($code, $option_values, $name);

        if ($type == "TEXT" AND sizeof($option_values) == 0) {
            try {
                //            CRM_Core_Error::debug_var('result1'.$code, $result1);
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => "Memo",
                    'html_type' => "TextArea",
                    'option_values' => null,
                ];
                $result = getCustomFieldByCode($code, $customfield);
                //            CRM_Core_Error::debug_var('optionsarray'.$code, $optionsarray);
                //            CRM_Core_Error::debug_var('result'.$code, $result);

            } catch (ErrorException $e) {
            }
        } elseif ($type == "DROPDOWN" OR sizeof($option_values) > 0) {
            try {
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'serialize' => 1,
                    'option_group_id' => $option_group_id,
                    'html_type' => "Select",
                ];
                $result = getCustomFieldByCode($code, $customfield);
            } catch (ErrorException $e) {
            }
        } elseif ($type == "DATE") {
            try {
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => "Date",
                    'html_type' => "Select Date",
                ];
                $result = getCustomFieldByCode($code, $customfield);
            } catch
            (ErrorException $e) {
            }
        }
    }
    return;
}


/**
 * @param $econfigs
 * @param $ecfields
 * @throws CiviCRM_API3_Exception
 */
function createEmployerFields($econfigs, $ecfields)
{
//    CRM_Core_Error::debug_var('econfigs', $econfigs);

    $group_code = "spd_o8_employer";
    $hasgroup = civicrm_api3('CustomGroup', 'get', [
        'return' => ["id"],
        'name' => $group_code,
    ]);

    $create_custom_group = TRUE;
    if (isset($hasgroup['id'])) {
        $create_custom_group = FALSE;
        $group_id = $hasgroup['id'];
    }
    if ($create_custom_group) {
        $newgroup = civicrm_api3('CustomGroup', 'create', [
//            'debug' => 1,
            'title' => "Employer Custom Fields",
            'extends' => "Organization",
            'name' => $group_code,
            'collapse_display' => 0,
        ]);
        $group_id = $newgroup['id'];
    } else {
//        echo 'Organisations will not be created';
    }
    $customvaluepositions = 0;
    foreach ($econfigs as $config) {
        $name = $config['configType'];
        $name = trim($name);
        $code = $config['_id']['$oid'];
//        $result0 = deleteCustomFieldByName($code);
//        $result0 = deleteCustomFieldByLabel($code);
        if (isset($config['option_values'])) {
            $option_values = $config['option_values'];
            if (sizeof($option_values) > 0) {
                $option_values = array_map('trim', $option_values);
                $option_group_id = addOptionsToOptionValuesByCode($code, $option_values, $name);
            }
        }
        if (in_array($name, ['TYPE', 'INDUSTRY'])) {
            $customfield = array(
                'custom_group_id' => $group_id,
                'serialize' => 1,
                'name' => $code,
                'weight' => $customvaluepositions,
                'label' => $name,
                'option_group_id' => $option_group_id,
                'html_type' => "Select",
            );
            $result = getCustomFieldByCode($code, $customfield);
            if ($result > 0) {
                $customvaluepositions = $customvaluepositions + 1;
            }
        }
    }
    foreach ($ecfields as $customf) {
//        CRM_Core_Error::debug_var('fecustom'.$customf['name'], $customf);
        $type = $customf['fieldType'];
        $position = $customvaluepositions + $customf['position'];
        $name = $customf['name'];
        $name = trim($name);
        $option_values = $customf['option_values'];
        $option_values = array_map('trim', $option_values);
        $code = $customf['code']['$oid'];
        $option_group_id = addOptionsToOptionValuesByCode($code, $option_values, $name);

        if ($type == "TEXT" AND sizeof($option_values) == 0) {
            try {
                //            CRM_Core_Error::debug_var('result1'.$code, $result1);
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => "Memo",
                    'html_type' => "TextArea",
                    'option_values' => null,
                ];
                $result = getCustomFieldByCode($code, $customfield);
                //            CRM_Core_Error::debug_var('optionsarray'.$code, $optionsarray);
                //            CRM_Core_Error::debug_var('result'.$code, $result);

            } catch (ErrorException $e) {
            }
        } elseif ($type == "DROPDOWN" OR sizeof($option_values) > 0) {
            try {
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => 'alphanumeric',
                    'serialize' => 1,
                    'option_group_id' => $option_group_id,
                    'html_type' => "Select",
                ];
                $result = getCustomFieldByCode($code, $customfield);
            } catch (ErrorException $e) {
            }
        } elseif ($type == "DATE") {
            try {
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => "Date",
                    'html_type' => "Select Date",
                ];
                $result = getCustomFieldByCode($code, $customfield);
            } catch
            (ErrorException $e) {
            }
        }
    }
    return;

}


/**
 * @param $eeconfigs
 * @param $eecfields
 * @throws CiviCRM_API3_Exception
 */
function createEmployeeFields($eecfields)
{
//    CRM_Core_Error::debug_var('eecfields', $eecfields);

    $group_code = "spd_o8_employee";
    $hasgroup = civicrm_api3('CustomGroup', 'get', [
        'return' => ["id"],
        'name' => $group_code,
    ]);

    $create_custom_group = TRUE;
    if (isset($hasgroup['id'])) {
        $create_custom_group = FALSE;
        $group_id = $hasgroup['id'];
    }
    if ($create_custom_group) {
        $newgroup = civicrm_api3('CustomGroup', 'create', [
//            'debug' => 1,
            'title' => "Employee Custom Fields",
            'extends' => "Individual",
            'name' => $group_code,
            'collapse_display' => 0,
        ]);
        $group_id = $newgroup['id'];
    } else {
//        echo 'Organisations will not be created';
    }
    $customvaluepositions = 0;
    foreach ($eecfields as $customf) {
        $type = $customf['fieldType'];
        $position = $customvaluepositions + $customf['position'];
        $code = $customf['_id']['$oid'];
        if (isset($customf['name'])) {
            $name = $customf['name'];
            $name = trim($name);
        } else {
            $name = $code;
        }

        //        $result0 = deleteCustomFieldByName($code);
//        $result1 = deleteCustomFieldByLabel($name);
        $option_values = [];
        if (isset($customf['option_values'])) {
            $option_values = $customf['option_values'];
        }
        $option_values = array_map('trim', $option_values);
//        CRM_Core_Error::debug_var('optionvalues' . $customf['name'], $option_values);
        try {
            $option_group_id = addOptionsToOptionValuesByCode($code, $option_values, $name);
        } catch (ErrorException $e) {
            CRM_Core_Error::debug_var('error' . $code, $e->getMessage());
        }
//        CRM_Core_Error::debug_var('2fecustom' . $customf['name'], $customf);

        if ($type == "TEXT" AND sizeof($option_values) == 0) {
            try {
                //            CRM_Core_Error::debug_var('result1'.$code, $result1);
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => "Memo",
                    'html_type' => "TextArea",
                    'option_values' => null,
                    'is_searchable' => 1
                ];
                $result = getCustomFieldByCode($code, $customfield);
                //            CRM_Core_Error::debug_var('optionsarray'.$code, $optionsarray);
//                CRM_Core_Error::debug_var('result' . $code, $result);

            } catch (ErrorException $e) {
                CRM_Core_Error::debug_var('error' . $code, $e->getMessage());
            }
        } elseif ($type == "DROPDOWN" OR sizeof($option_values) > 0) {
            try {
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => 'alphanumeric',
                    'serialize' => 1,
                    'option_group_id' => $option_group_id,
                    'html_type' => "Select",
                    'is_searchable' => 1
                ];
                $result = getCustomFieldByCode($code, $customfield);
            } catch (ErrorException $e) {
                CRM_Core_Error::debug_var('error' . $code, $e->getMessage());
            }
        } elseif ($type == "DATE") {
            try {
                $customfield = [
                    'custom_group_id' => $group_id,
                    'name' => $code,
                    'weight' => $position,
                    'label' => $name,
                    'data_type' => "Date",
                    'html_type' => "Select Date",
                    'is_searchable' => 1
                ];
                $result = getCustomFieldByCode($code, $customfield);
            } catch
            (ErrorException $e) {
                CRM_Core_Error::debug_var('error' . $code, $e->getMessage());
            }
        }
    }
    return;

}

/**
 * @param $code
 * @param array $option_values
 * @param label
 * @return array
 * @throws CiviCRM_API3_Exception
 * adds option values to options
 */
function addOptionsToOptionValuesByCode($code, array $option_values, $label = null)
{
    $optionGroupId = null;
    $optionGroupName = null;
    $optionGroupName = $code;
    $optionGroup = civicrm_api3('OptionGroup', 'get', [
        'name' => $optionGroupName,
//        'sequential' => 1,
        'return' => ["id"],
    ]);
    if (isset($optionGroup["id"])) {
        $optionGroupId = $optionGroup["id"];
    } else {
        $resultoptions = civicrm_api3('OptionGroup', 'create', [
                'name' => $code,
                'title' => E::ts($label),
//                'sequential' => 1,
                'return' => ["id"]]
        );
        $optionGroupId = $resultoptions['id'];
    }


    $value = $option_values;
    $value = array_values(array_filter($value)); // filter empty values
    $value = array_map('trim', $value);
    $valueUpdated = FALSE;
    $isValid = TRUE;
    $gid = $optionGroupId;
    foreach ($value as $option) {
        $label = $option;
        $values_cutom_field = civicrm_api3("OptionValue", "get", array(
            'sequential' => '1',
            'options' => ['limit' => 0],
            'option_group_id' => $gid
        ));
        $notexist = TRUE;
        foreach ($values_cutom_field["values"] as $key => $value_comp) {
            if ($value_comp["value"] == $option || $value_comp["label"] == $option) {
//                CRM_Core_Error::debug_var($optionGroupName . $key . 'eee' . $option . '===', $value_comp);
                $notexist = FALSE;
                break;
            }
        }
        $notexstr = "false";
        if ($notexist) $notexstr = "true";
//        CRM_Core_Error::debug_var('eee' . $option, strval($notexstr));
        if ($notexist) {
            insertValue_customfield($gid, $option, $label);
        }
    }

    return $optionGroupId;
}

/**
 * @param $code
 * @param $customfield
 * ['group_id',
 * 'code',
 *
 * ]
 * @return int
 * new or present custom field id
 * @throws CiviCRM_API3_Exception
 */
function getCustomFieldByCode($code, $customfield)
{
    $result = civicrm_api3('CustomField', 'get', [
//        'return' => ["id"],
        'name' => $code,
    ]);

    if (isset($result["id"])) {
        $mycustomfield = $result["values"][$result["id"]];
        $serialize = $mycustomfield["serialize"];
        if($serialize == "0"){$serialize = "";}
//        if($mycustomfield["is_searchable"] == "0"){
//        try {
//            $result = civicrm_api3('CustomField', 'get', [
//                'name' => $code,
//                'api.CustomField.update' => [
//                    "is_searchable" => "1",
//                    "serialize" => $serialize],
//            ]);
//        } catch (ErrorException $e) {
//
//        }
//        }
        if (isset($customfield['option_group_id'])) {
            try {
                $result = civicrm_api3('CustomField', 'get', [
                    'name' => $code,
                    'api.CustomField.update' => [
                        "option_group_id" => $customfield['option_group_id'],
                        "serialize" => $serialize,
                        ],
                ]);
            } catch
            (ErrorException $e) {

            }
        }
        return $result['id'];
    } else {
        $customfield["is_searchable"] = "1";
        $result = civicrm_api3('CustomField', 'create', $customfield);
        return $result['id'];
    }
}

function insertValue_customfield($gid, $value, $label)
{
    $params = array(
        'label' => $label,
//            'value' => $value,
        'option_group_id' => $gid,
    );
    $result = civicrm_api3("OptionValue", "create", $params);
}