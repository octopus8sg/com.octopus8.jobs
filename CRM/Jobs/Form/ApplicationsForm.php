<?php

use CRM_Jobs_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Jobs_Form_ApplicationsForm extends CRM_Core_Form
{
    protected $_id;

    protected $_myentity;

    protected $_contactId;

    protected $_jobId;

    protected $_myjob;

    public function getDefaultEntity()
    {
        return 'SscApplication';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_o8_application';
    }

    public function getEntityId()
    {
        return $this->_id;
    }

    public function getJobId()
    {
        return $this->_jobId;
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
        $jobId = null;
        $myentity = null;
        if ($this->_id) {

            CRM_Utils_System::setTitle('Edit Application');
            if ($this->_action == CRM_Core_Action::VIEW) {
                CRM_Utils_System::setTitle('View Application');
            }
            $entities = civicrm_api4('SscApplication', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            if (!empty($entities)) {
                $myentity = $entities[0];
                $this->_myentity = $myentity;
            }
            $this->assign('myentity', $myentity);
            $contactId = $myentity['contact_id'];
            $jobId = $myentity['o8_job_id'];
            $this->_jobId = $jobId;
        } else {
            $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);;
            if (!$contactId) {
                $this->freeze();
            }
            $jobId = CRM_Utils_Request::retrieve('jid', 'Positive', $this, FALSE);
            if (!$jobId) {
                $this->freeze();
            }
        }
        $this->_contactId = $contactId;
        $this->_jobId = $jobId;

        if ($jobId) {
            $jentities = civicrm_api4('SscJob', 'get', ['where' => [['id', '=', $jobId]], 'limit' => 1]);
            if (!empty($jentities)) {
                $myjob = $jentities[0];
                $this->_myjob = $myjob;
            }
        }

        CRM_Utils_System::setTitle('Add Application');
        if ($this->_action == CRM_Core_Action::VIEW) {
            CRM_Utils_System::setTitle('View Application');
        }
        if ($this->_id) {
            $session = CRM_Core_Session::singleton();
            $session->replaceUserContext(CRM_Utils_System::url('civicrm/applications/form', ['id' => $this->getEntityId(), 'action' => 'view']));
        }

//        if (!empty($_POST['hidden_custom'])) {
//            $role_id = $this->getSubmitValue('role_id');
//            CRM_Custom_Form_CustomData::preProcess($this, null, $role_id, 1, 'Job', $this->getEntityId());
//            CRM_Custom_Form_CustomData::buildQuickForm($this);
//            CRM_Custom_Form_CustomData::setDefaultValues($this);
//        }
    }


    public function buildQuickForm()
    {
        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
//        CRM_Core_Error::debug_var('myjob', $this->_myjob);
        if ($this->_action != CRM_Core_Action::DELETE) {
            if ($this->_contactId) {
                $this->addEntityRef('contact_id', E::ts('Employee'), [], TRUE)->freeze();
            } else {
                $this->addEntityRef('contact_id', E::ts('Employee'), [], TRUE);
            }
            if ($this->_jobId) {
                $this->add('text',
                    'app_id', E::ts('Application ID'), ['class' => 'huge'], FALSE)->freeze();
                $this->add('text',
                    'job_id', E::ts('Job ID'), ['class' => 'huge'], FALSE)->freeze();
                $this->add('datepicker',
                    'job_created_date', E::ts('Job Created At'), ['class' => 'huge'], FALSE)->freeze();
                $this->add('datepicker',
                    'created_date', E::ts('Application Created At'), ['class' => 'huge'], FALSE)->freeze();
                $this->add('text',
                    'title', E::ts('Job Title'), ['class' => 'huge'], FALSE)->freeze();
                $this->addEntityRef('employer_id',
                    E::ts('Employer'), [], FALSE)->freeze();
                $jstatuses = CRM_Core_OptionGroup::values('o8_job_status');
                $this->add('select', 'o8_job_status_id', E::ts('Job Status'),
                    $jstatuses, FALSE, ['class' => 'huge crm-select2',
                        'data-option-edit-path' => 'civicrm/admin/options/o8_job_status'])->freeze();
                $jlocations = CRM_Core_OptionGroup::values('o8_job_location');
                $this->add('select', 'o8_job_location_id', E::ts('Job Location'),
                    $jlocations, FALSE, ['class' => 'huge crm-select2',
                        'data-option-edit-path' => 'civicrm/admin/options/o8_job_location'])->freeze();
                $jroles = CRM_Core_OptionGroup::values('o8_job_role');
                $this->add('select', 'o8_job_role_id', E::ts('Job Role'),
                    $jroles, FALSE, ['class' => 'huge crm-select2',
                        'data-option-edit-path' => 'civicrm/admin/options/o8_job_role'])->freeze();
            } else {
//                $this->addEntityRef('job_id', E::ts('Job'), [], TRUE);
                $this->addEntityRef('job_id', E::ts('Job'), [
                    'entity' => 'Job',
                    'placeholder' => ts('- Select Job -'),
                    'select' => ['minimumInputLength' => 0],
                    'api' => ['search_field' => 'id',
                        'label_field' => 'id']
                ], TRUE);
            }
//            $this->add('text', 'title', E::ts('Title'), ['class' => 'huge'], FALSE);
            //todo add pseudoconstants

            $statuses = CRM_Core_OptionGroup::values('o8_application_status');
            $this->add('select', 'status_id', E::ts('Application Status'),
                $statuses, TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/o8_application_status']);

            if ($this->_action == CRM_Core_Action::VIEW) {
                $this->addButtons([
                    [
                        'type' => 'cancel',
                        'name' => E::ts('Close'),
                        'isDefault' => TRUE,
                    ],
                ]);
                $this->freeze();
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
        }
        if ($this->_myjob) {
            $job = $this->_myjob;
            $defaults['app_id'] = $this->_id;
            $defaults['job_id'] = $this->_jobId;

            $defaults['title'] = $job['title'];
            $defaults['o8_job_status_id'] = $job['status_id'];
            $defaults['o8_job_location_id'] = $job['location_id'];
            $defaults['o8_job_role_id'] = $job['role_id'];
            $defaults['employer_id'] = $job['contact_id'];
            $defaults['job_created_date'] = $job['created_date'];
        }

        if (empty($defaults['o8_application_status_id'])) {
            $defaults['job_application_status_id'] = CRM_Core_OptionGroup::getDefaultValue('job_application_status');
        }
        if ($this->_contactId) {
            $defaults['contact_id'] = $this->_contactId;
        }
        if ($this->_jobId) {
            $defaults['o8_job_id'] = $this->_jobId;
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
        if ($this->_action == CRM_Core_Action::VIEW) {
            return;
        }
        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('Job', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Job'), E::ts('Job'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            $session = CRM_Core_Session::singleton();
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
            $params['contact_id'] = $values['contact_id'];
            $params['job_id'] = $values['job_id'];
            //added pseudoconstants
            $params['job_application_status_id'] = $values['job_application_status_id'];
//            CRM_Core_Error::debug_var('params', $params);
//            CRM_Core_Error::debug_var('values', $values);
            civicrm_api4('JobApplication', $action, ['values' => $params]);


        }
        parent::postProcess();
    }

}
