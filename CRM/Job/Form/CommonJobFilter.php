<?php

use CRM_Job_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Job_Form_CommonJobFilter extends CRM_Core_Form {
    public function buildQuickForm() {

        // add hm job search filters

        // location + + +
        // role
        // job status
        // application status
        // employee
        // employer

        $locations = CRM_Core_OptionGroup::values('job_location');
        // for job location filter
        $this->add('select', 'employer_job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location','placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location','placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_application_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location','placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        $roles = CRM_Core_OptionGroup::values('job_role');
        // for job location filter
        $this->add('select', 'employer_job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role','placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role','placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_application_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role','placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);

        $statuses = CRM_Core_OptionGroup::values('job_status');
        // for job location filter
        $this->add('select', 'employer_job_status_id',
            E::ts('Status'),
            $statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_status','placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_job_status_id',
            E::ts('Status'),
            $statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_status','placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);

        $a_statuses = CRM_Core_OptionGroup::values('job_application_status');

        $this->add('select', 'employee_application_status_id',
            E::ts('Status'),
            $a_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_status','placeholder' => ts('- Select Application Status -'),
                'select' => ['minimumInputLength' => 0]]);

//        // for device filter
//        $this->add('select', 'device_device_type_id',
//            E::ts('Device Type'),
//            $device_types,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
//                'select' => ['minimumInputLength' => 0]]);
//
//        //for chart filter
//        $this->add('select', 'chart_device_type_id',
//            E::ts('Device Type'),
//            $device_types,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
//                'select' => ['minimumInputLength' => 0, 'multiple' => true]]);
//
//
//        $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');
//
//        //for data filter
//        $this->add('select', 'data_sensor_id',
//            E::ts('Sensor'),
//            $sensors,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
//                'select' => ['minimumInputLength' => 1]]);
//
//        //for chart filter
//        $this->add('select', 'chart_sensor_id',
//            E::ts('Sensor'),
//            $sensors,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
//                'select' => ['minimumInputLength' => 1]]);
//
//        //for alarm rule filter
//        $this->add('select', 'alarm_rule_sensor_id',
//            E::ts('Sensor'),
//            $sensors,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
//                'select' => ['minimumInputLength' => 1]]);
//
//        //for alarm filter
//        $this->add('select', 'alarm_sensor_id',
//            E::ts('Sensor'),
//            $sensors,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
//                'select' => ['minimumInputLength' => 1]]);
//
//        //for alert rule filter
//        $this->add('select', 'alert_rule_sensor_id',
//            E::ts('Sensor'),
//            $sensors,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
//                'select' => ['minimumInputLength' => 1]]);
//
//        //for alert rule filter
//        $this->add('select', 'alert_sensor_id',
//            E::ts('Sensor'),
//            $sensors,
//            FALSE, ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
//                'select' => ['minimumInputLength' => 1]]);
//
        // contact - for data and adressee filters
        $this->addEntityRef('employer_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

        $this->addEntityRef('employee_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

        $this->addEntityRef('employee_application_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

//        $this->addEntityRef('data_device_id', E::ts('Device'), [
//            'entity' => 'device',
//            'placeholder' => ts('- Select Device -'),
//            'select' => ['minimumInputLength' => 0],
//        ], false);
//
//        $this->addEntityRef('chart_device_id', E::ts('Device'), [
//            'entity' => 'device',
//            'placeholder' => ts('- Select Device -'),
//            'select' => ['minimumInputLength' => 0], 'multiple' => true
//        ], false);

        $this->addDatePickerRange('employer_job_dateselect',
            'Select Date',
            FALSE,
            FALSE,
            'From: ',
            'To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('employee_job_dateselect',
            'Select Date',
            FALSE,
            FALSE,
            'From: ',
            'To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('employee_application_dateselect',
            'Select Date',
            FALSE,
            FALSE,
            'From: ',
            'To: ',
            null,
            '_to',
            '_from');


//        $this->add('checkbox', 'alert_rule_civicrm', ts('CiviCRM'))->setChecked(true);
//        $this->add('checkbox', 'alert_rule_email', ts('Email'));
//        $this->add('checkbox', 'alert_rule_telegram', ts('Telegram'));
//        $this->add('checkbox', 'alert_rule_api', ts('API'));
//
//        $this->add('checkbox', 'alert_civicrm', ts('CiviCRM'))->setChecked(true);
//        $this->add('checkbox', 'alert_email', ts('Email'));
//        $this->add('checkbox', 'alert_telegram', ts('Telegram'));
//        $this->add('checkbox', 'alert_api', ts('API'));

        $this->assign('suppressForm', FALSE);
    }
}
