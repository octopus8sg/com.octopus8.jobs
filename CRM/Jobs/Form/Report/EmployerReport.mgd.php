<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
    [
        'name' => 'CRM_Jobs_Form_Report_EmployerReport',
        'entity' => 'ReportTemplate',
        'params' => [
            'version' => 3,
            'label' => 'Employer/Job Summary Report',
            'description' => 'Employers and Jobs summary Report (com.octopus8.jobs)',
            'class_name' => 'CRM_Jobs_Form_Report_EmployerReport',
            'report_url' => 'com.octopus8.jobs/employerreport',
            'component' => '',
            'grouping' => 'Jobs',
        ],
    ],

];
