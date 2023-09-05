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
            'label' => 'Applicants Report',
            'description' => 'Applicants Report (com.octopus8.jobs)',
            'class_name' => 'CRM_Jobs_Form_Report_EmployeeReport',
            'report_url' => 'com.octopus8.jobs/employeereport',
            'component' => '',
            'grouping' => 'Jobs',
        ],
    ],
];

/*
 * $this->_columns = array_merge(
            [
//                'civicrm_contact_applicant' => [
//                'dao' => 'CRM_Contact_DAO_Contact',
//                'fields' => [
//                    'display_name' => [
//                        'title' => ts('Applicant Name'),
//                        'required' => TRUE,
//                        'no_repeat' => TRUE,
//                    ],
//                    'id' => [
//                        'no_display' => TRUE,
//                        'required' => TRUE,
//                    ],
//                    'contact_type' => [
//                        'title' => ts('Applicant Type'),
//                    ],
//                    'contact_sub_type' => [
//                        'title' => ts('Applicant Subtype'),
//                    ],
//                ],
//                'order_bys' => [
//                    'display_name' => [
//                        'title' => ts('Applicant Name'),
//                    ],
//                    'employee_id' => [
//                        'name' => 'id',
//                        'title' => ts('Applicant ID'),
//                    ],
//                ],
//                'filters' => [
//                    'display_name' => [
//                        'title' => ts('Applicant Name'),
//                    ],
//                    'is_deleted' => [
//                        'default' => 0,
//                        'title' => ts('Is Applicant Deleted?'),
//                        'type' => CRM_Utils_Type::T_BOOLEAN,
//                    ],
//                ],
//                'grouping' => 'applicant-fields',
//            ],
//                'civicrm_email' => [
//                    'dao' => 'CRM_Core_DAO_Email',
//                    'fields' => [
//                        'email' => [
//                            'title' => ts('Employer Email'),
//                            'default' => TRUE,
//                            'no_repeat' => TRUE,
//                        ],
//                    ],
//                    'grouping' => 'applicant-fields',
//                ],
//                'civicrm_phone' => [
//                    'dao' => 'CRM_Core_DAO_Phone',
//                    'fields' => [
//                        'phone' => [
//                            'title' => ts('Applicant\'s Phone'),
//                            'default' => FALSE,
//                            'no_repeat' => TRUE,
//                        ],
//                    ],
//                    'grouping' => 'applicant-fields',
//                ],
//                'civicrm_contact_organization' => [
//                    'dao' => 'CRM_Contact_DAO_Contact',
//                    'fields' => [
//                        'organization_name' => [
//                            'title' => ts('Organization Name'),
//                            'required' => TRUE,
//                            'no_repeat' => TRUE,
//                        ],
//                        'id' => [
//                            'no_display' => TRUE,
//                            'required' => TRUE,
//                        ],
//                    ],
//                    'order_bys' => [
//                        'organization_name' => [
//                            'title' => ts('Organization Name'),
//                        ],
//                        'organization_id' => [
//                            'name' => 'id',
//                            'title' => ts('Organization ID'),
//                        ],
//                    ],
//                    'filters' => [
//                        'organization_name' => [
//                            'title' => ts('Organization Name'),
//                        ],
//                        'is_deleted' => [
//                            'default' => 0,
//                            'title' => ts('Is Organization Deleted?'),
//                            'type' => CRM_Utils_Type::T_BOOLEAN,
//                        ],
//                    ],
//                    'grouping' => 'organization-fields',
//                ],
                'civicrm_o8_application' => [
                    'dao' => 'CRM_Jobs_DAO_Application',
                    'fields' => [
                        'ssc_app_id' => [
                            'name' => 'id',
                            'title' => ts('App ID'),
                            'no_display' => FALSE,
                            'required' => TRUE,
                        ],
                        'status_id' => [
                            'title' => ts('App Status'),
                            'default' => TRUE,
                        ],
                        'is_active' => [
                            'title' => ts('Applied'),
                            'default' => TRUE,
                        ],
                        'created_date' => ['type' => CRM_Utils_Type::T_INT,
//                            'required' => TRUE,
                            'name' => 'created_date',
                            'title' => ts('Applied Date'),
                            'default' => TRUE,
                        ],
                    ],
                    'filters' => [
                        'created_date' => [
                            'operatorType' => CRM_Report_Form::OP_DATE,
                            'title' => ts('App Created Date')],
                        'status_id' => [
                            'title' => ts('Status'),
                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
                            'options' => CRM_Core_PseudoConstant::get('CRM_Jobs_DAO_SscApplication', 'status_id'),
                        ],
                        'is_active' => [
                            'title' => ts('Location'),
                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
                            'options' => [0 => 'Withdrown', 1 => 'Applied'],
                        ],
                    ],
                    'order_bys' => [
                        'status_id' => ['title' => ts('Status')],
                        'is_active' => ['title' => ts('Applied')],
                        'created_date' => ['title' => ts('Created Date')],
                    ],
                    'grouping' => 'app-fields',
                ],
//                'civicrm_o8_job' => [
//                    'dao' => 'CRM_Jobs_DAO_SscJob',
//                    'fields' => [
//                        'ssc_job_id' => [
//                            'name' => 'id',
//                            'title' => ts('Job ID'),
//                            'no_display' => FALSE,
//                            'required' => TRUE,
//                        ],
//                        'title' => [
//                            'title' => ts('Title'),
//                            'default' => TRUE,
//                        ],
//                        'description' => [
//                            'title' => ts('Description'),
//                            'default' => FALSE,
//                        ],
//                        'role_id' => [
//                            'title' => ts('Role'),
//                            'default' => TRUE,
//                        ],
//                        'location_id' => [
//                            'title' => ts('Location'),
//                            'default' => TRUE,
//                        ],
//                        'created_date' => ['type' => CRM_Utils_Type::T_INT,
////                            'required' => TRUE,
//                            'name' => 'created_date',
//                            'title' => ts('Job Created Date'),
//                            'default' => TRUE,
//                        ],
//                        'due_date' => ['type' => CRM_Utils_Type::T_INT,
////                            'required' => TRUE,
//                            'name' => 'due_date',
//                            'title' => ts('Job Closed'),
//                            'default' => TRUE,
//                        ],
//                    ],
//                    'filters' => [
//                        'title' => [
//                            'operator' => 'like',
//                            'title' => ts('Job Title')],
//                        'description' => [
//                            'operator' => 'like',
//                            'title' => ts('Job Description')],
//                        'created_date' => [
//                            'operatorType' => CRM_Report_Form::OP_DATE,
//                            'title' => ts('Created Date')],
//                        'due_date' => [
//                            'operatorType' => CRM_Report_Form::OP_DATE,
//                            'title' => ts('Job Closed')],
//                        'role_id' => [
//                            'title' => ts('Role'),
//                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//                            'options' => CRM_Core_PseudoConstant::get('CRM_Jobs_DAO_SscJob', 'role_id'),
//                        ],
//                        'location_id' => [
//                            'title' => ts('Location'),
//                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//                            'options' => CRM_Core_PseudoConstant::get('CRM_Jobs_DAO_SscJob', 'location_id'),
//                        ],
//                    ],
//                    'order_bys' => [
//                        'id' => ['title' => ts('Job ID')],
//                        'title' => ['title' => ts('Job Title')],
//                        'description' => ['title' => ts('Job Description')],
//                        'role_id' => ['title' => ts('Role')],
//                        'location_id' => ['title' => ts('Location')],
//                        'created_date' => ['title' => ts('Created Date')],
//                        'due_date' => ['title' => ts('Job Closed')],
//                    ],
//                    'grouping' => 'contact-fields',
//                ],
                'civicrm_contact' => [
                    'dao' => 'CRM_Contact_DAO_Contact',
                    'fields' => [
                        'id' => [
                            'no_display' => TRUE,
                            'required' => TRUE,
                            'alias' => 'contact_civireport'
                        ],
                    ],
                ],
            ]
//            $this->getColumns('Address')
        );
 */