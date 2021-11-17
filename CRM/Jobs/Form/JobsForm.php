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

    protected $_myentity;

    protected $_contactId;

    protected $_contactType;

    protected $_isEmployee;

    protected $_isEmployer;

    protected $_employeeId;

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

        $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);

        $this->assign('action', $this->_action);

        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE);

        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);
        if (!$contactId) {
            $session = CRM_Core_Session::singleton();
            $contactId = $session->get('userID');
        }

        $employeeId = CRM_Utils_Request::retrieve('employeeid', 'Positive', $this, FALSE);

        $this->_contactId = $contactId;
        if ($employeeId) {
            $this->_employeeId = $employeeId;
        } else {
            $this->_employeeId = $contactId;
        }
        $contact = $myentity = null;

        CRM_Utils_System::setTitle('Add Job');

        if ($this->_id) {
            if ($this->_action == CRM_Core_Action::UPDATE) {
                CRM_Utils_System::setTitle('Edit Job');
            }
            if ($this->_action == CRM_Core_Action::VIEW) {
                CRM_Utils_System::setTitle('View Job');
            }

            $entities = civicrm_api4('SscJob', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            if (!empty($entities)) {
                $this->_myentity = $entities[0];
                $myentity = $this->_myentity;
            }
            $this->assign('myentity', $this->_myentity);

            $session = CRM_Core_Session::singleton();
            $session->replaceUserContext(CRM_Utils_System::url('civicrm/job/form', ['id' => $this->getEntityId(), 'action' => 'view']));
        }

        if ($myentity) {
            $employerId = $myentity->contact_id;
            $contactId = $this->_contactId;
            if ($employerId != $contactId) {
                $contact = \Civi\Api4\Contact::get(0)
                    ->addWhere('id', '=', $contactId)
                    ->execute()->single();
                $contactType = $contact['contact_type'];
                $this->_contactType = $contactType;
                $employees = array("Individual",
                    "Student",
                    "Parent",
                    "Staff",
                );
                if (in_array($contactType, $employees)) {
                    $this->_isEmployee = true;
                    $this->_isEmployer = false;
                } else {
                    $this->_isEmployer = true;
                    $this->_isEmployee = false;
                }
            }

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
//        CRM_Core_Error::debug_var('subType', $role_id);
//        CRM_Core_Error::debug_var('entityId', $this->_id);
//        CRM_Core_Error::debug_var('entityId', $this);
        try {
            if ($role_id) {
                if (!empty($_POST['hidden_custom'])) {
                    $this->applyCustomData('SscJob', $role_id, $this->_id);
                }
            }

        } catch (Exception $error) {
            CRM_Core_Error::debug_var('errir', $error);

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
//        CRM_Core_Error::debug_var('formbefore', $this);
        CRM_Custom_Form_CustomData::preProcess($this, NULL, $subType, 1, $type, $entityId);
//        CRM_Core_Error::debug_var('formafter', $this);
        if ($this->_action != CRM_Core_Action::VIEW) {
            CRM_Custom_Form_CustomData::buildQuickForm($this);
        }

    }

    public function buildQuickForm()
    {

        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
        if ($this->_action != CRM_Core_Action::DELETE) {

            if (($this->_contactId) AND ($this->_action != CRM_Core_Action::ADD)) {
                $this->addEntityRef('contact_id', E::ts('Employer'), [], TRUE)->freeze();
            } else {
                $this->addEntityRef('contact_id', E::ts('Employer'), [], TRUE);
            }
            $this->add('text', 'title', E::ts('Title'), ['class' => 'huge'], FALSE);

            $this->add('wysiwyg', 'description', E::ts('Description'), [], FALSE);
            //todo add pseudoconstants

            $roles = CRM_Core_OptionGroup::values('o8_job_role');
            $this->add('select', 'role_id', E::ts('Role'),
                $roles, TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/o8_job_role']);
            $locations = CRM_Core_OptionGroup::values('o8_job_location');
            $this->add('select', 'location_id', E::ts('Location'),
                $locations, TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/o8_job_location']);
            $statuses = CRM_Core_OptionGroup::values('o8_job_status');
            $this->add('select', 'status_id', E::ts('Status'),
                $statuses, TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/o8_job_status']);

            if ($this->_action == CRM_Core_Action::VIEW) {
                if ($this->_myentity->contact_id != $this->_contactId) {
                    if ($this->_isEmployee) {
                        $this->add('hidden', 'employee_id');
                        $this->addButtons([

                            [
                                'type' => 'upload',
                                'name' => E::ts('Apply'),
                                'isDefault' => FALSE,
                            ],
//                            [
//                                'type' => 'submit',
//                                'name' => E::ts('Delete'),
//                                'formaction' => 'delete',
//                                'isDefault' => FALSE,
//                            ],
                            [
                                'type' => 'cancel',
                                'name' => E::ts('Close'),
                                'isDefault' => TRUE,
                            ],
                        ]);
                    }
                } else {
                    $this->addButtons([
                        [
                            'type' => 'upload',
                            'name' => E::ts('Close'),
                            'isDefault' => TRUE,
                        ],
                    ]);

                }
            } else {
                $this->addButtons([
                    [
                        'type' => 'upload',
                        'name' => E::ts('Submit'),
                        'isDefault' => TRUE,
                    ],
                    ['type' => 'cancel', 'name' => E::ts('Cancel')]
                ]);
            }
        } else {
            $this->addButtons([
                ['type' => 'submit', 'name' => E::ts('Delete'), 'isDefault' => TRUE],
                ['type' => 'cancel', 'name' => E::ts('Cancel')]
            ]);
        }
        if ($this->_action == CRM_Core_Action::VIEW) {
            $this->add('text', 'job_id', E::ts('ID'), ['class' => 'huge'], FALSE);
            $this->add('datepicker', 'created_date', E::ts('Created Time'), ['class' => 'huge'], FALSE);
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

        if ($this->_myentity) {
            $defaults = $this->_myentity;
            $defaults['job_id'] = $defaults['id'];
            $defaults['employee_id'] = $this->_employeeId;
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
//        if ($this->_contactId) {
//            $defaults['contact_id'] = $this->_contactId;
//        }
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

        $session = CRM_Core_Session::singleton();
        $employeeId = CRM_Utils_Request::retrieve('employee_id', 'Positive');
//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);
        if ($this->_action == CRM_Core_Action::VIEW) {

            // makes application for the job
            $params = [];
            $jobId = CRM_Utils_Request::retrieve('id', 'Positive');
//            CRM_Core_Error::debug_var('values', $values);
            $employeeId = CRM_Utils_Request::retrieve('employee_id', 'Positive');
            $createdUserId = $session->get('userID');
            if (!$employeeId) {
                $employeeId = $createdUserId;
            }
            $action = 'create';
            $params['created_id'] = $createdUserId;
            $params['created_date'] = date('YmdHis');
            $params['contact_id'] = $employeeId;
            $params['o8_job_id'] = $jobId;
            try {
                civicrm_api4('SscApplication', $action, ['values' => $params]);
                // makes application for the job
            } catch (Exception $exception) {
                CRM_Core_Error::debug_var('error', $exception->getMessage());
                return;
            }
            return;
        } elseif ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('SscJob', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Job'), E::ts('Job'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
                $params['modified_id'] = $session->get('userID');
                $params['modified_date'] = date('YmdHis');

            }else{
                $params['created_id'] = $session->get('userID');
                $params['modified_date'] = NULL;
                $params['created_date'] = date('YmdHis');
            }
            $params['title'] = $values['title'];
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
            $saver = (array)civicrm_api4('SscJob', $action, ['values' => $params]);
//            CRM_Core_Error::debug_var('saver', $saver);
        }
        parent::postProcess();
    }
}