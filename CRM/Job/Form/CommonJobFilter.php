<?php

use CRM_Job_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Job_Form_CommonJobFilter extends CRM_Core_Form
{
    public function buildQuickForm()
    {

        // add hm job search filters

        // location + + +
        // role
        // job status
        // application status
        // employee
        // employer
        $this->add('text', 'application_id', ts('App ID'), ['size' => 28, 'maxlength' => 28]);
        $this->addRule('application_id', ts('Please enter a valid ID.'), 'numeric', null, "client");

        $this->add('text', 'application_job_id', ts('Job ID or Title'), ['size' => 28, 'maxlength' => 128]);
        $this->addRule('application_job_id', ts('Please enter a valid ID.'), 'numeric', null, "client");

        $locations = CRM_Core_OptionGroup::values('job_location');
        // for job location filter
        // general job search

        $this->add('select', 'job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);
        // general application search
        $this->add('select', 'application_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);
        //employer job search
        $this->add('select', 'employer_job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        //employee job search
        $this->add('select', 'employee_job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        //employee application search
        $this->add('select', 'employee_application_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        $roles = CRM_Core_OptionGroup::values('job_role');
        // for job location filter
        //general job search
        $this->add('select', 'job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);
        //general application search
        $this->add('select', 'application_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);
        $this->add('select', 'employer_job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_application_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);

        $job_statuses = CRM_Core_OptionGroup::values('job_status');
        // for job location filter
        $this->add('select', 'job_status_id',
            E::ts('Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_status', 'placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);
        $this->add('select', 'application_job_status_id',
            E::ts('Job Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_status', 'placeholder' => ts('- Select Job Status -'),
                'select' => ['minimumInputLength' => 0]]);
        $this->add('select', 'employer_job_status_id',
            E::ts('Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_status', 'placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_job_status_id',
            E::ts('Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_status', 'placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);

        $app_statuses = CRM_Core_OptionGroup::values('job_application_status');

        $this->add('select', 'application_status_id',
            E::ts('Application Status'),
            $app_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_application_status', 'placeholder' => ts('- Select Application Status -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->add('select', 'employee_application_status_id',
            E::ts('Application Status'),
            $app_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/job_application_status', 'placeholder' => ts('- Select Application Status -'),
                'select' => ['minimumInputLength' => 0]]);

        $this->addEntityRef('job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

        $this->addEntityRef('application_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

        $this->addEntityRef('application_contact_id', E::ts('Employee'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

        $this->addEntityRef('employer_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

        $this->addEntityRef('employee_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);

        $this->addEntityRef('employee_application_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);


        $this->addDatePickerRange('job_dateselect',
            'Select Job Date',
            FALSE,
            FALSE,
            'From: ',
            'To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('application_job_dateselect',
            'Select Job Date',
            FALSE,
            FALSE,
            'From: ',
            'To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('application_dateselect',
            'Select Application Date',
            FALSE,
            FALSE,
            'From: ',
            'To: ',
            null,
            '_to',
            '_from');

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

        $this->assign('suppressForm', FALSE);

    }
}
