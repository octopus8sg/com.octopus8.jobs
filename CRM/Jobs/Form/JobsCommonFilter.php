<?php

use CRM_Jobs_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Jobs_Form_JobsCommonFilter extends CRM_Core_Form
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
        //For Search APP form

        $this->add('text', 'job_id', ts('Job ID or Title'), ['size' => 28, 'maxlength' => 128]);

        $this->add('text', 'application_id', ts('App ID'), ['size' => 28, 'maxlength' => 28]);

        $this->add('text', 'application_job_id', ts('Job ID or Title'), ['size' => 28, 'maxlength' => 128]);

        //Job Locations
        $locations = CRM_Core_OptionGroup::values('o8_job_location');

        // general job search
        $this->add('select', 'job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);
        // general application search
        $this->add('select', 'application_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);
        //employer job search
        $this->add('select', 'employer_job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        //employee job search
        $this->add('select', 'employee_job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        //employee application search
        $this->add('select', 'employee_application_job_location_id',
            E::ts('Location'),
            $locations,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_location', 'placeholder' => ts('- Select Location -'),
                'select' => ['minimumInputLength' => 0]]);

        // job role
        $roles = CRM_Core_OptionGroup::values('o8_job_role');

        //general job search
        $this->add('select', 'job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);
        //general application search
        $this->add('select', 'application_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);
        //employer job search
        $this->add('select', 'employer_job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);
        //employee job search
        $this->add('select', 'employee_job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);
        //employee application search
        $this->add('select', 'employee_application_job_role_id',
            E::ts('Role'),
            $roles,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_role', 'placeholder' => ts('- Select Role -'),
                'select' => ['minimumInputLength' => 0]]);

        //job statuses
        $job_statuses = CRM_Core_OptionGroup::values('o8_job_status');
        // general search
        $this->add('select', 'job_status_id',
            E::ts('Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_status', 'placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);
        // general app search
        $this->add('select', 'application_job_status_id',
            E::ts('Job Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_status', 'placeholder' => ts('- Select Job Status -'),
                'select' => ['minimumInputLength' => 0]]);
        //eer
        $this->add('select', 'employer_job_status_id',
            E::ts('Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_status', 'placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);
        //eee
        $this->add('select', 'employee_job_status_id',
            E::ts('Status'),
            $job_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_job_status', 'placeholder' => ts('- Select Status -'),
                'select' => ['minimumInputLength' => 0]]);
        //app statuses
        $app_statuses = CRM_Core_OptionGroup::values('o8_application_status');
        //gen app search
        $this->add('select', 'application_status_id',
            E::ts('Application Status'),
            $app_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_application_status', 'placeholder' => ts('- Select Application Status -'),
                'select' => ['minimumInputLength' => 0]]);
        //app search
        $this->add('select', 'employee_application_status_id',
            E::ts('Application Status'),
            $app_statuses,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_application_status', 'placeholder' => ts('- Select Application Status -'),
                'select' => ['minimumInputLength' => 0]]);

        //gen search
        $this->addEntityRef('job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);
        //gen app search
        $this->addEntityRef('application_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);
        //gen app search
        $this->addEntityRef('application_contact_id', E::ts('Employee'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);
        //eer search
        $this->addEntityRef('employer_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);
        //eee search
        $this->addEntityRef('employee_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);
        //eee app search
        $this->addEntityRef('employee_app_job_contact_id', E::ts('Employer'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'], false);


        $this->addDatePickerRange('job_dateselect',
            'Select Job Creation Date',
            FALSE,
            FALSE,
            'Created From: ',
            'Created To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('job_due_dateselect',
            'Job Closed',
            FALSE,
            FALSE,
            'Job Closed From: ',
            'Job Closed To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('application_job_due_dateselect',
            'Job Closed',
            FALSE,
            FALSE,
            'Job Closed From: ',
            'Job Closed To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('application_dateselect',
            'Select Application Date',
            FALSE,
            FALSE,
            'Created From: ',
            'Created To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('employer_job_dateselect',
            'Select Create Date',
            FALSE,
            FALSE,
            'Created From: ',
            'Created To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('employer_job_due_dateselect',
            'Job Closed',
            FALSE,
            FALSE,
            'Job Closed From: ',
            'Job Closed To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('employee_job_due_dateselect',
            'Job Closed',
            FALSE,
            FALSE,
            'Job Closed From: ',
            'Job Closed To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('employee_job_dateselect',
            'Select Created Date',
            FALSE,
            FALSE,
            'Created From: ',
            'Created To: ',
            null,
            '_to',
            '_from');

        $this->addDatePickerRange('employee_application_dateselect',
            'Select Date',
            FALSE,
            FALSE,
            'Applied From: ',
            'To: ',
            null,
            '_to',
            '_from');

        $this->addElement('select', 'job_due_date_open',
            ts('Job Closed') . ' ', [0 => "Closed", 1 => "Open"],
            [
                'size' => 2,
                'style' => 'min-width:250px',
                'class' => 'crm-select2 huge',
                'multiple' => TRUE,
                'placeholder' => ts('- select -'),
            ]
        );

        $this->setDefaults(array('job_due_date_open' => array(0, 1)));

        //        $this->add('advcheckbox', 'job_date_open', ts('Date Open?'))->setChecked(true);
//
//        $this->add('advcheckbox', 'job_date_closed', ts('Date Closed?'))->setChecked(true);

        $this->add('advcheckbox', 'application_is_active', ts('Applied?'))->setChecked(true);

//        $this->add('advcheckbox', 'application_job_is_active', ts('Date Closed?'))->setChecked(true);

        $this->add('advcheckbox', 'employer_job_is_active', ts('Job Closed?'))->setChecked(true);

//        $this->add('advcheckbox', 'employee_application_is_active', ts('Applied?'))->setChecked(true);

//        $this->add('advcheckbox', 'employee_application_job_is_active', ts('Date Closed?'))->setChecked(true);


        $this->assign('suppressForm', FALSE);

    }

}
