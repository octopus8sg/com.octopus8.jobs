<?php

use CRM_Jobs_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Jobs_Form_JobsForm extends CRM_Core_Form
{

    /**
     * Form controller class
     *
     * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
     */

    protected $_id;

    protected $_sscJob;

    protected $_contactId;

    protected $_isActive;

    protected $_contactType;

    protected $_isAdmin;

    protected $_isEmployee;

    protected $_isEmployer;

    protected $_employeeId;

    protected $_employeeName;

    protected $_employerId;

    protected $_appCount;

    public function getDefaultEntity()
    {
        return 'SscJob';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_o8_job';
    }

    public function getEntityId()
    {
        return $this->_id;
    }

    /**
     * Preprocess form.
     *
     * This is called before buildForm. Any pre-processing that
     * needs to be done for buildForm should be done here.
     *
     * This is a virtual function and should be redefined if needed.
     */
    public function preProcess()
    {
        parent::preProcess();
        $can_view = CRM_Core_Permission::check(VIEW_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');
        $can_delete = CRM_Core_Permission::check(DELETE_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');
        $can_edit = CRM_Core_Permission::check(EDIT_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');
        $can_apply = CRM_Core_Permission::check(APPLY_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');

        $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);

        $this->assign('action', $this->_action);
        $id = $sscJob = null;
        $id = CRM_Utils_Request::retrieve('id', 'Positive', $this, false);
        $this->_id = $id;
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, false);
        if (!$contactId) {
            $contactId = CRM_Utils_Request::retrieve('employeeid', 'Positive', $this, false);
        }
        $this->_isAdmin = false;
        if (!$contactId) {
            $currentUserId = CRM_Core_Session::getLoggedInContactID();
            $contactId = $currentUserId;
            $this->_contactId = $contactId;
        }
        if (CRM_Core_Permission::check('administer CiviCRM')) {
            $this->_isAdmin = true;
        }

        $this->_employeeId = $this->_employerId = null;
        if ($contactId) {
            $contact = \Civi\Api4\Contact::get(false)
                ->addWhere('id', '=', $contactId)
                ->execute()
                ->single();
            $contactType = $contact['contact_type'];
            $contactName = $contact['display_name'];
            $this->_contactType = $contactType;
            $employees = array("Individual",
                "Student",
                "Parent",
                "Staff",
            );
            if (in_array($contactType, $employees)) {
                $this->_employeeId = $contactId;
                $this->_employeeName = $contactName;
            } else {
                $this->_employerId = $contactId;
            }
        }
        if ($can_apply || $this->_isAdmin) {
            $this->_employeeId = $contactId;
        }

        CRM_Utils_System::setTitle('Add Job');

        if ($id) {
            if ($this->_action == CRM_Core_Action::UPDATE) {
                CRM_Utils_System::setTitle('Edit Job');
            }
            if ($this->_action == CRM_Core_Action::VIEW) {
                CRM_Utils_System::setTitle('View Job');
            }

            $jobs = civicrm_api4('SscJob', 'get', [
                'where' => [['id', '=', $id]],
                'limit' => 1,
                'checkPermissions' => false]);

            if (!empty($jobs)) {
                $sscJob = $jobs[0];
                $this->_sscJob = $sscJob;
            }

            $this->assign('sscJob', $sscJob);

            $session = CRM_Core_Session::singleton();
            $session->replaceUserContext(CRM_Utils_System::url('civicrm/jobs/form',
                ['id' => $id,
                    'action' => 'view']));
            $applications = \Civi\Api4\SscApplication::get(false)
                ->selectRowCount()
                ->addWhere('o8_job_id', '=', $id)
                ->execute();
            $this->_appCount = $applications->count();
        }

        $isActive = false;

        if ($sscJob) {
            $now = new DateTime;
            $due_date = $sscJob['due_date'];
            $otherDate = new DateTime($due_date);
//            CRM_Core_Error::debug_var('otherDate', $otherDate);
            $now->setTime(0, 0, 0);
            $otherDate->setTime(0, 0, 0);
            if ($now <= $otherDate) {
                $isActive = true;
            }
            $this->_isActive = $isActive;
        }

        $this->assign('action', $this->_action);
        // CUSTOM FIELDS
        // when custom data is included in this page
        $role_id = $this->getSubmitValue('role_id');
        CRM_Custom_Form_CustomData::setDefaultValues($this);
        if ((!$role_id) AND !empty($this->_submitValues['role_id'])) {
            $role_id = $this->_submitValues['role_id'];
        }
        if ((!$role_id) AND !empty($this->_values['role_id'])) {
            $role_id = $this->_values['role_id'];
        }
        if (!$role_id) {
            $role_id = CRM_Core_OptionGroup::getDefaultValue('o8_job_role');
        }
        $this->set('type', 'SscJob');
        $this->set('subType', $role_id);
        $this->set('entityId', $this->_id);
        $this->assign('type', 'SscJob');
        $this->assign('subType', $role_id);
        $this->assign('entityId', $this->_id);
        try {
            if ($role_id) {
                if (!empty($_POST['hidden_custom'])) {
                    $this->applyCustomData('SscJob', $role_id, $this->_id);
                }
            }

        } catch (Exception $error) {
            CRM_Core_Error::debug_var('error', $error);
        }

    }


    /**
     * @param string $type
     *   Eg 'Contribution'.
     * @param string $subType
     * @param int $entityId
     */
    public function applyCustomData($type, $subType, $entityId)
    {
        $this->set('type', $type);
        $this->set('subType', $subType);
        $this->set('entityId', $entityId);
        CRM_Custom_Form_CustomData::preProcess($this, NULL, $subType, 1, $type, $entityId);
        if ($this->_action != CRM_Core_Action::VIEW) {
            CRM_Custom_Form_CustomData::buildQuickForm($this);
        }

    }

    public function buildQuickForm()
    {
        if($this->_isAdmin){
            $can_apply = true;
        }

        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
        if ($this->_action != CRM_Core_Action::DELETE) {
            $props = ['create' => false,
                'multiple' => false,
                'class' => 'huge',
                'api' =>
                    ['params' =>
                        ['contact_type' => 'Organization']
                    ],
                'select' => ['minimumInputLength' => 1],
            ];

            $employerField = $this->addEntityRef('contact_id', E::ts('Employer'), $props, true);
            if (!$this->_isAdmin) {
                $employerField->freeze();
            }
            if ($this->_employerId) {
                $employerField->freeze();
            }
            $this->add('text', 'title', E::ts('Title'), ['class' => 'huge'], false);
            $this->add('datepicker', 'due_date', ts('Job Closed'), [], false, ['time' => false]);
            $this->add('wysiwyg', 'description', E::ts('Description'), [], false);
            //todo add pseudoconstants

            $roles = CRM_Core_OptionGroup::values('o8_job_role');
            $this->add('select', 'role_id', E::ts('Role'),
                $roles, true, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/o8_job_role']);
            $locations = CRM_Core_OptionGroup::values('o8_job_location');
            $this->add('select', 'location_id', E::ts('Location'),
                $locations, true, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/o8_job_location']);
            $this->add('hidden', 'status_id');
            $currentUserId = CRM_Core_Session::getLoggedInContactID();

            if ($this->_action == CRM_Core_Action::VIEW) {
                if ($this->_sscJob['contact_id'] != $currentUserId) {
                    //if user is not employer
                    if ($this->_isAdmin ||
                        $this->_employeeId == $currentUserId) {
                        if ($this->_isActive) {
                            $this->add('hidden', 'employee_id');
                            $apply = "Apply";
                            if($this->_employeeId != $currentUserId){
                                $apply = "Apply for " . $this->_employeeName;
                            }
                            if ($this->_employeeId) {
                                $this->addButtons([
                                    [
                                        'type' => 'upload',
                                        'name' =>$apply,
                                        'isDefault' => false
                                    ],
                                    [
                                        'type' => 'cancel',
                                        'name' => E::ts('Close'),
                                        'isDefault' => true,
                                    ],
                                ]);
                            } else {
                                $this->addButtons([
                                    [
                                        'type' => 'cancel',
                                        'name' => E::ts('Close'),
                                        'isDefault' => true,
                                    ],
                                ]);
                            }
                        }
                    }
                } else {
                    $this->addButtons([
                        [
                            'type' => 'upload',
                            'name' => E::ts('Close'),
                            'isDefault' => true,
                        ],
                    ]);
                }
            } else {
                $this->addButtons([
                    [
                        'type' => 'upload',
                        'name' => E::ts('Submit'),
                        'isDefault' => true,
                    ],
                    ['type' => 'cancel',
                        'name' => E::ts('Cancel')]
                ]);
            }
        } else {
            $this->addButtons([
                ['type' => 'submit', 'name' => E::ts('Delete'), 'isDefault' => true],
                ['type' => 'cancel', 'name' => E::ts('Cancel')]
            ]);
        }
        if ($this->_action == CRM_Core_Action::VIEW) {
            $this->add('text', 'job_id', E::ts('ID'), ['class' => 'huge'], false);
            $this->add('static', 'app_count', E::ts('App Count'));
            $this->add('datepicker', 'created_date', E::ts('Created Time'), ['class' => 'huge'], false);
            $this->freeze();
        }
        parent::buildQuickForm();
    }

    /**
     * This virtual function is used to set the default values of various form
     * elements.
     *
     * @return array|NULL
     *   reference to the array of default values
     */
    public function setDefaultValues()
    {
        $defaults['app_count'] = "0";
        if ($this->_sscJob) {
            $defaults = $this->_sscJob;
            $defaults['job_id'] = $defaults['id'];
            if ($this->_isAdmin) {
                $defaults['app_count'] = "<a target='_blank' href='" .
                    CRM_Utils_System::url('civicrm/applications/search',
                        ['jobid' => $this->getEntityId()]) . "'>" . $this->_appCount . "</a> ";
            } elseif ($this->_isEmployer) {
                $defaults['app_count'] = "<a target='_blank' href='" .
                    CRM_Utils_System::url('civicrm/applications/search',
                        ['jobid' => $this->getEntityId(), 'employerid' => $this->_contactId]) . "'>" . $this->_appCount . "</a> ";
            }
            $defaults['employee_id'] = $this->_employeeId;
        } else {
            if (empty($defaults['contact_id'])) {
                if ($this->_employerId) {
                    $defaults['contact_id'] = $this->_employerId;
                }
            }
        }
        if (empty($defaults['role_id'])) {
            $defaults['role_id'] = CRM_Core_OptionGroup::getDefaultValue('o8_job_role');
        }
        if (empty($defaults['location_id'])) {
            $defaults['location_id'] = CRM_Core_OptionGroup::getDefaultValue('o8_job_location');
        }
        if (empty($defaults['status_id'])) {
            $defaults['status_id'] = CRM_Core_OptionGroup::getDefaultValue('o8_job_status');
        }
        return $defaults;
    }

    /**
     * @throws API_Exception
     * @throws CRM_Core_Exception
     * @throws CiviCRM_API3_Exception
     * @throws \Civi\API\Exception\NotImplementedException
     */
    public function postProcess()
    {
        $can_view = CRM_Core_Permission::check(VIEW_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');
        $can_delete = CRM_Core_Permission::check(DELETE_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');
        $can_edit = CRM_Core_Permission::check(EDIT_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');
        $can_apply = CRM_Core_Permission::check(APPLY_OCTOPUS_8_JOBS) || CRM_Core_Permission::check('administer CiviCRM');
        $session = CRM_Core_Session::singleton();
        $employeeId = CRM_Utils_Request::retrieve('employee_id', 'Positive');
//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);
        $currentUserId = CRM_Core_Session::getLoggedInContactID();
        if ($can_delete && $this->_action == CRM_Core_Action::DELETE) {
            $session = CRM_Core_Session::singleton();
            $session->replaceUserContext(CRM_Utils_System::url('civicrm/jobs/search'));
            civicrm_api4('SscApplication', 'delete', [
                'where' => [['o8_job_id', '=', $this->_id]],
                'checkPermissions' => false
            ]);
            civicrm_api4('SscJob', 'delete', [
                'where' => [['id', '=', $this->_id]],
                'checkPermissions' => false
            ]);
            CRM_Core_Session::setStatus(E::ts('Removed Job'), E::ts('Job'), 'success');
            parent::postProcess();
            return;
        }
        if (($can_edit || $can_view) && $this->_action == CRM_Core_Action::VIEW) {
//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);
            // makes application for the job
            $params = [];
            $jobId = CRM_Utils_Request::retrieve('id', 'Positive');
            $post = $_POST;
            $delete = $post['_qf_JobsForm_submit_delete'];
            if ($delete) {
                civicrm_api4('SscApplication', 'delete', [
                    'where' => [['id', '=', $this->_id]],
                    'checkPermissions' => false]);
                CRM_Core_Session::setStatus(E::ts('Removed Job'), E::ts('Job'), 'success');
            } else {
                //            CRM_Core_Error::debug_var('values', $values);
                $employeeId = CRM_Utils_Request::retrieve('employee_id', 'Positive');
                if (!$employeeId) {
                    $employeeId = $currentUserId;
                }
                $action = 'create';
                $params['created_id'] = $currentUserId;
                $params['created_date'] = date('YmdHis');
                $params['contact_id'] = $employeeId;
                $params['o8_job_id'] = $jobId;
                try {
                    civicrm_api4('SscApplication', $action, ['values' => $params,
                        'checkPermissions' => FALSE]);
                    // makes application for the job
                } catch (Exception $exception) {
                    CRM_Core_Error::debug_var('error', $exception->getMessage());
                    return;
                }
                return;
            }
        } elseif ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('SscJob', 'delete', [
                'where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Job'), E::ts('Job'), 'success');
        } else {
            $values = $this->controller->exportValues();
//            CRM_Core_Error::debug_var('values', $values);
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
                $params['modified_id'] = $currentUserId;
                $params['modified_date'] = date('YmdHis');
            } else {
                $params['created_id'] = $currentUserId;
                $params['created_date'] = date('YmdHis');
            }
            $params['title'] = $values['title'];
            $params['due_date'] = $values['due_date'];
//            $params['is_active'] = boolval($values['is_active']);
            $params['description'] = $values['description'];
            $params['contact_id'] = $values['contact_id'];
            //added pseudoconstants

            $params['role_id'] = $values['role_id'];
            $params['location_id'] = $values['location_id'];
            $params['status_id'] = $values['status_id'];
            $custom = \CRM_Core_BAO_CustomField::postProcess($values, $this->getEntityId(), $this->getDefaultEntity());
            $params['custom'] = $custom;
            //in case 'custom' disappears somewhere
            $params['bustom'] = $custom;
            //Default Way
//            CRM_Core_Error::debug_var('paramsfrom', $params);
//            CRM_Core_Error::debug_var('values', $values);
            $saver = (array)civicrm_api4('SscJob', $action, ['values' => $params,
                'checkPermissions' => FALSE]);
//            CRM_Core_Error::debug_var('saver', $saver);
        }
        parent::postProcess();
    }
}