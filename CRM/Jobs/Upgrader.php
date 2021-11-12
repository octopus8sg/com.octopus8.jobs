<?php
use CRM_Jobs_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Jobs_Upgrader extends CRM_Jobs_Upgrader_Base {

  // By convention, functions that look like "function upgrade_NNNN()" are
  // upgrade tasks. They are executed in order (like Drupal's hook_update_N).

  /**
   * Example: Run an external SQL script when the module is installed.
   *
  public function install() {
    $this->executeSqlFile('sql/myinstall.sql');
  }
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
                'label' => E::ts('SscJob'),
                'value' => 'ssc_job',
                'name' => 'civicrm_ssc_job',
                'description' => 'CRM_Job_PseudoConstant::SscJobRole;',
            ]);

        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'ssc_job_role', 'title' => E::ts('Role')]);
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

            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'ssc_job_location', 'title' => E::ts('Location')]);
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
            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'ssc_job_status', 'title' => E::ts('Status')]);
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
                    'name' => 'withdrown',
                    'label' => E::ts('Withdrown'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
        } catch (\CiviCRM_API3_Exception $ex) {
            // Ignore exception.
        }
        try {
            $typeOptionGroupId = civicrm_api3('OptionGroup', 'create', ['name' => 'ssc_application_status', 'title' => E::ts('Status')]);
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
                    'name' => 'under_revision',
                    'label' => E::ts('Under Revision'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => 4,
                    'name' => 'approved',
                    'label' => E::ts('Approved'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => 5,
                    'name' => 'rejected',
                    'label' => E::ts('Rejected'),
                    'option_group_id' => $typeOptionGroupId
                ]
            );
            civicrm_api3('OptionValue', 'create',
                ['value' => 6,
                    'name' => 'withdrown',
                    'label' => E::ts('Withdrown'),
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
   public function uninstall() {
       try {
           $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'ssc_job_role']);
           $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
           foreach ($optionValues['values'] as $optionValue) {
               civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
           }
           civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
       } catch (\CiviCRM_API3_Exception $ex) {
           // Ignore exception.
       }
       try {
           $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'ssc_job_location']);
           $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
           foreach ($optionValues['values'] as $optionValue) {
               civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
           }
           civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
       } catch (\CiviCRM_API3_Exception $ex) {
           // Ignore exception.
       }
       try {
           $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'ssc_job_status']);
           $optionValues = civicrm_api3('OptionValue', 'get', ['option_group_id' => $optionGroupId, 'options' => ['limit' => 0]]);
           foreach ($optionValues['values'] as $optionValue) {
               civicrm_api3('OptionValue', 'delete', ['id' => $optionValue['id']]);
           }
           civicrm_api3('OptionGroup', 'delete', ['id' => $optionGroupId]);
       } catch (\CiviCRM_API3_Exception $ex) {
           // Ignore exception.
       }
       try {
           $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', ['return' => 'id', 'name' => 'ssc_application_status']);
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
               'extends' => 'SscJob',
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
               'value' => 'SscJob',
               'return' => 'id',
           ]);
           civicrm_api3('OptionValue', 'delete', ['id' => $cgExtendOptionId]);
       } catch (\CiviCRM_API3_Exception $ex) {
           // Ignore exception.
       }
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
