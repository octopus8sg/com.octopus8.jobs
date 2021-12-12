<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
  [
    'name' => 'CRM_Jobs_Form_Report_EmployeeReport',
    'entity' => 'ReportTemplate',
    'params' => [
      'version' => 3,
      'label' => 'EmployeeReport',
      'description' => 'EmployeeReport (com.octopus8.jobs)',
      'class_name' => 'CRM_Jobs_Form_Report_EmployeeReport',
      'report_url' => 'com.octopus8.jobs/employeereport',
      'component' => '',
    ],
  ],
];
