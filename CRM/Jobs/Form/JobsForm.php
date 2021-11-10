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

    public function getDefaultEntity()
    {
        return 'SscJob';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_ssc_job';
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
        $this->_contactId = $contactId;
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
        /*
        if (!empty($_POST['hidden_custom'])) {
            $role_id = $this->getSubmitValue('role_id');
            CRM_Custom_Form_CustomData::preProcess($this, null, $role_id, 1, 'Job', $this->getEntityId());
            CRM_Custom_Form_CustomData::buildQuickForm($this);
            CRM_Custom_Form_CustomData::setDefaultValues($this);
        }
        */
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

            $roles = CRM_Core_OptionGroup::values('ssc_job_role');
            $this->add('select', 'role_id', E::ts('Role'),
                $roles, TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/ssc_job_role']);
            $locations = CRM_Core_OptionGroup::values('ssc_job_location');
            $this->add('select', 'location_id', E::ts('Location'),
                $locations, TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/ssc_job_location']);
            $statuses = CRM_Core_OptionGroup::values('ssc_job_status');
            $this->add('select', 'status_id', E::ts('Status'),
                $statuses, TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/ssc_job_status']);

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
            $defaults['employee_id'] = $this->_contactId;
        }
        if (empty($defaults['role_id'])) {
            $defaults['role_id'] = CRM_Core_OptionGroup::getDefaultValue('ssc_job_role');
        }
        if (empty($defaults['location_id'])) {
            $defaults['location_id'] = CRM_Core_OptionGroup::getDefaultValue('ssc_job_location');
        }
        if (empty($defaults['status_id'])) {
            $defaults['status_id'] = CRM_Core_OptionGroup::getDefaultValue('ssc_job_status');
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

        if ($this->_action == CRM_Core_Action::VIEW) {
            $values = $this->controller->exportValues();
//            CRM_Core_Error::debug_var('values', $values);

            if (isset($values['employee_id'])) {
                $action = 'create';
                $params['created_id'] = $session->get('userID');
                $params['created_date'] = date('YmdHis');
                $params['contact_id'] = $values['employee_id'];
                $params['ssc_job_id'] = $values['job_id'];
                try {
                    civicrm_api4('SscApplication', $action, ['values' => $params]);
                } catch (Exception $exception) {
                    CRM_Core_Error::debug_var('error', $exception->getMessage());
                    return;
                }
            }
            return;
        }
        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('SscJob', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Job'), E::ts('Job'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }
            $params['title'] = $values['title'];
            $params['description'] = $values['description'];
            $params['contact_id'] = $values['contact_id'];
            $params['created_id'] = $session->get('userID');
            $params['created_date'] = date('YmdHis');
            //added pseudoconstants

            $params['role_id'] = $values['role_id'];
            $params['location_id'] = $values['location_id'];
            $params['status_id'] = $values['status_id'];
//            CRM_Core_Error::debug_var('params', $params);
//            CRM_Core_Error::debug_var('values', $values);
            civicrm_api4('SscJob', $action, ['values' => $params]);

            //Custom Fields
            /*
                        $evalues = CRM_Utils_Request::exportValues();
                        $gevalues = $values;
                        $groupTree = $this->get_template_vars('groupTree');
            //    CRM_Core_Error::debug_var('formName_postPro', $formName);
            //    CRM_Core_Error::debug_var('form', $form);
            //            CRM_Core_Error::debug_var('groupTree', $groupTree);

                        foreach ($groupTree as $id => $group) {
                            $tableName = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomGroup', $id, 'table_name');
            //                CRM_Core_Error::debug_var('group', $group);
                            foreach ($group['fields'] as $field) {
            //    CRM_Core_Error::debug_var('field', $field);
                                $entityId = $this->getEntityId();
                                if ($entityId) {
                                    if ($field['html_type'] != 'eSignature') {
                                        $serialize = CRM_Core_BAO_CustomField::isSerialized($field);
                                        //esignature is added by itself
                                        $fieldId = $field['id'];
                                        $elementName = $field['element_name'];
                                        $elementValue = $gevalues[$elementName];
            //                            CRM_Core_Error::debug_var('field', $field);
            //                            CRM_Core_Error::debug_var('serialize', $serialize);
            //                            CRM_Core_Error::debug_var('elementm', $elementName);
            //                            CRM_Core_Error::debug_var('elementv', $elementValue);
                                        $v = $elementValue;
                                        if ($serialize) {
                                            $v = ($v && $field['html_type'] === 'Checkbox') ? array_keys($v) : $v;
                                            $v = $v ? CRM_Utils_Array::implodePadded($v) : NULL;
                                        }
                                        $elementValue = $v;
                                        if ($field['html_type'] == 'File') {
                                            if (isset($elementValue)) {
                                                $groupID = $id;
                                                // store the file in d/b
                                                $fileParams = ['upload_date' => date('YmdHis')];
                                                if ($groupTree[$groupID]['fields'][$fieldId]['customValue']['fid']) {
                                                    $fileParams['id'] = $groupTree[$groupID]['fields'][$fieldId]['customValue']['fid'];
                                                }
                                                if (!empty($v)) {
                                                    $fileParams['uri'] = $v['name'];
                                                    $fileParams['mime_type'] = $v['type'];
                                                    CRM_Core_BAO_File::filePostProcess(
                                                        $v['name'],
                                                        $groupTree[$groupID]['fields'][$fieldId]['customValue']['fid'],
                                                        $tableName,
                                                        $entityId,
                                                        FALSE,
                                                        TRUE,
                                                        $fileParams,
                                                        'custom_' . $fieldId,
                                                        $v['type']
                                                    );
                                                }
                                                $defaults = [];
                                                $paramsFile = [
                                                    'entity_table' => $tableName,
                                                    'entity_id' => $entityId,
                                                ];
                                                $returnProperties = ['file_id'];
                                                $attachements = \CRM_Core_BAO_File::getEntityFile($tableName, $entityId);
                                                $cmr = CRM_Core_DAO::commonRetrieve('CRM_Core_DAO_EntityFile',
                                                    $paramsFile,
                                                    $defaults,
                                                    $returnProperties
                                                );
                                                $attachement = end($attachements);
            //                                    CRM_Core_Error::debug_var('defaults', $defaults);
            //                                    CRM_Core_Error::debug_var('attachements', $attachements);
            //                                    CRM_Core_Error::debug_var('attachement', $attachement);

                                                $fid = $attachement['fileID'];
                                                $field_name = 'custom_' . $fieldId;
                                                try {
                                                    $result = civicrm_api3('CustomValue', 'create', [
                                                        'entity_id' => $entityId,
                                                        'custom_' . $fieldId => $fid,
                                                        'field_id' => $fid
                                                    ]);
            //                                        CRM_Core_Error::debug_var('result', $result);

                                                } catch (CiviCRM_API3_Exception $e) {
            //                                        CRM_Core_Error::debug_var('eresult', $e->getMessage());
                                                }
                                            }
                                        } elseif ($field['html_type'] != 'Select Date') {
                                            if (isset($elementValue)) {
                                                $result = civicrm_api3('CustomValue', 'create', [
                                                    'entity_id' => $entityId,
                                                    'custom_' . $fieldId => $elementValue,
                                                ]);
                                            }
                                        } elseif ($field['html_type'] == 'Select Date') {
                                            $date = CRM_Utils_Date::processDate($v);
                                            $result = civicrm_api3('CustomValue', 'create', [
                                                'entity_id' => $entityId,
                                                'custom_' . $fieldId => $date,
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
            */

        }
        parent::postProcess();
    }
}
