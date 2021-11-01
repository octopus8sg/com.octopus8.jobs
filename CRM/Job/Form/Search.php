<?php

use CRM_Job_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Job_Form_Search extends CRM_Core_Form {

    protected $formValues;

    protected $pageId = false;

    protected $offset = 0;

    protected $limit = false;

    public $count = 0;

    public $rows = [];


    public function preProcess() {
        parent::preProcess();


        $this->formValues = $this->getSubmitValues();
        $this->setTitle(E::ts('Search Jobs'));

        $this->limit = CRM_Utils_Request::retrieveValue('crmRowCount', 'Positive', 50);
        $this->pageId = CRM_Utils_Request::retrieveValue('crmPID', 'Positive', 1);
        if ($this->limit !== false) {
            $this->offset = ($this->pageId - 1) * $this->limit;
        }
        $this->query();
        $this->assign('entities', $this->rows);

        $pagerParams = [];
        $pagerParams['total'] = 0;
        $pagerParams['status'] =E::ts('%%StatusMessage%%');
        $pagerParams['csvString'] = NULL;
        $pagerParams['rowCount'] =  50;
        $pagerParams['buttonTop'] = 'PagerTopButton';
        $pagerParams['buttonBottom'] = 'PagerBottomButton';
        $pagerParams['total'] = $this->count;
        $pagerParams['pageID'] = $this->pageId;
        $this->pager = new CRM_Utils_Pager($pagerParams);
        $this->assign('pager', $this->pager);
    }


    public function buildQuickForm() {
        parent::buildQuickForm();

        $this->add('text', 'title', E::ts('Title'), array('class' => 'huge'));
        $this->addEntityRef('contact_id', E::ts('Contact'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));

        $this->addButtons(array(
            array(
                'type' => 'refresh',
                'name' => E::ts('Search'),
                'isDefault' => TRUE,
            ),
        ));
    }

    public function postProcess() {
        parent::postProcess();
    }

    /**
     * Runs the query
     *
     * @throws \CRM_Core_Exception
     */
    protected function query() {
        $sql = "
    SELECT SQL_CALC_FOUND_ROWS
      `civicrm_job`.`id`,
      `civicrm_job`.`title`,
      `civicrm_job`.`contact_id`
    FROM `civicrm_job`
    WHERE 1";
        if (isset($this->formValues['title']) && !empty($this->formValues['title'])) {
            $sql .= " AND `civicrm_job`.`title` LIKE '%".$this->formValues['title']."%'";
        }
        if (isset($this->formValues['contact_id']) && is_array($this->formValues['contact_id']) && count($this->formValues['contact_id'])) {
            $sql  .= " AND `civicrm_job`.`contact_id` IN (".implode(", ", $this->formValues['contact_id']).")";
        }

        if ($this->limit !== false) {
            $sql .= " LIMIT {$this->offset}, {$this->limit}";
        }
        $dao = CRM_Core_DAO::executeQuery($sql);
        $this->count = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $this->rows = array();
        while($dao->fetch()) {
            $row = [
                'id' => $dao->id,
                'contact_id' => $dao->contact_id,
                'title' => $dao->title,
            ];
            if (!empty($row['contact_id'])) {
                $row['contact'] = '<a href="'.CRM_Utils_System::url('civicrm/contact/view', ['reset' => 1, 'cid' => $dao->contact_id]).'">'.CRM_Contact_BAO_Contact::displayName($dao->contact_id).'</a>';
            }
            $this->rows[] = $row;
        }
    }

    public function getJobsAjax()
    {

//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
//        CRM_Core_Error::debug_var('contact', $contactId);

//start and end date
        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);


        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

//todo
        $location_id = CRM_Utils_Request::retrieveValue('location_id', 'Positive', null);
//        CRM_Core_Error::debug_var('device_type_id', $location_id);

        $status_id = CRM_Utils_Request::retrieveValue('status_id', 'Positive', null);
////        CRM_Core_Error::debug_var('sensor_id', $status_id);

        $role_id = CRM_Utils_Request::retrieveValue('role_id', 'Positive', null);
////        CRM_Core_Error::debug_var('sensor_id', $role_id);
//
        $dateselect_to = CRM_Utils_Request::retrieveValue('dateselect_to', 'String', null);
        try {
            $dateselectto = new DateTime($dateselect_to);
        } catch (Exception $e) {
            $dateselect_to = null;
        }
//        CRM_Core_Error::debug_var('dateselect_to', $dateselect_to);

        $dateselect_from = CRM_Utils_Request::retrieveValue('dateselect_from', 'String', null);
        try {
            $dateselectfrom = new DateTime($dateselect_from);
        } catch (Exception $e) {
            $dateselect_from = null;
        }
//        CRM_Core_Error::debug_var('dateselect_from', $dateselect_from);

        $sortMapper = [
            0 => 'id',
            1 => 'title',
            2 => 'role',
            3 => 'location',
            4 => 'application_count',
            5 => 'created_date',
            6 => 'job_status',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

// SQL_CALC_FOUND_ROWS
        $selectsql = "
SELECT  SQL_CALC_FOUND_ROWS
    j.id,
    count(a.id) application_count,
    j.title,
    r.label role,                            
    l.label location,                            
    j.created_date,
    s.label job_status
FROM civicrm_job j LEFT JOIN civicrm_job_application a on a.job_id = j.id
                              INNER JOIN civicrm_option_value s on  j.status_id = s.value
                              INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'job_status'
                              INNER JOIN civicrm_option_value l on  j.location_id = l.value
                              INNER JOIN civicrm_option_group gl on l.option_group_id = gl.id and gl.name = 'job_location'
                              INNER JOIN civicrm_option_value r on  j.role_id = r.value
                              INNER JOIN civicrm_option_group gr on r.option_group_id = gr.id and gr.name = 'job_role'
";
        $wheresql = " where 1 = 1";
        $groupsql = " group by j.id, j.title, s.label, l.label, r.label, j.created_date";
        $ordersql = " ORDER BY j.id desc";
        if (isset($contactId)) {
            $wheresql .= " AND j.`contact_id` = " . $contactId . " ";
        }


        if (isset($location_id)) {
            if ($location_id > 0) {
                $wheresql .= " AND j.`location_id` = " . $location_id . " ";
            }
        }

        if (isset($status_id)) {
            if ($status_id > 0) {
                $wheresql .= " AND j.`status_id` = " . $status_id . " ";
            }
        }

        if (isset($role_id)) {
            if ($role_id > 0) {
                $wheresql .= " AND j.`role_id` = " . $role_id . " ";
            }
        }

        $month_ago = strtotime("-1 month", time());
        $date_month_ago = date("Y-m-d H:i:s", $month_ago);

        $today = strtotime("+1 day", time());
        $date_today = date("Y-m-d H:i:s", $today);

        if (isset($dateselect_from)) {
            if ($dateselect_from != null) {
                if ($dateselect_from != '') {
                    $wheresql .= " AND j.`created_date` >= '" . $dateselect_from . "' ";
                }
            }
        }


        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $_to = strtotime("+1 day", strtotime($dateselect_to));
                    $date_to = date("Y-m-d H:i:s", $_to);
                    $wheresql .= " AND j.`created_date` <= '" . $date_to . "' ";
                } else {
                    $wheresql .= " AND j.`created_date` <= '" . $date_today . "' ";
                }
            } else {
                $wheresql .= " AND j.`created_date` <= '" . $date_today . "' ";
            }
        } else {
            $wheresql .= " AND j.`created_date` <= '" . $date_today . "' ";
        }
//        CRM_Core_Error::debug_var('wheresql', $wheresql);



        if ($sort !== NULL) {
            $ordersql = " ORDER BY {$sort} {$sortOrder}";
        }

        if ($limit !== false) {
            if ($limit !== NULL) {
                if ($offset !== false) {
                    if ($offset !== NULL) {
                        $ordersql .= " LIMIT {$offset}, {$limit}";
                    }
                }
            }
        }


//        CRM_Core_Error::debug_var('sql', $sql);
        $sql = $selectsql . $wheresql . $groupsql . $ordersql;
//        CRM_Core_Error::debug_var('search_sql', $sql);
        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        $update = "";
        $delete = "";
        while ($dao->fetch()) {
            $r_view = CRM_Utils_System::url('civicrm/job/form',
                ['action' => 'view', 'id' => $dao->id]);
            if($contactId){
                $u_action = ['action' => 'update',
                    'id' => $dao->id,
                    'cid' => $contactId];
            }else{
                $u_action = ['action' => 'update',
                    'id' => $dao->id];
            }
            $r_update = CRM_Utils_System::url('civicrm/job/form',
                $u_action);
            $r_delete = CRM_Utils_System::url('civicrm/job/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $view = '<a target="_blank" class="action-item view-job crm-hover-button" href="' . $r_view . '"><i class="crm-i fa-eye"></i>&nbsp;View</a>';
            $update = '<a target="_blank" class="action-item update-job crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
//            $delete = '<a target="_blank" class="action-item delete-job crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$view $update $delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->title;
            $rows[$count][] = $dao->role;
            $rows[$count][] = $dao->location;
            $rows[$count][] = $dao->application_count;
            $rows[$count][] = $dao->created_date;
            $rows[$count][] = $dao->job_status;
            $rows[$count][] = $action;
            $count++;
        }

        $searchRows = $rows;
        $iTotal = 0;
        if (is_countable($searchRows)) {
            $iTotal = sizeof($searchRows);
        }
        $hmdatas = [
            'data' => $searchRows,
            'recordsTotal' => $iTotal,
            'recordsFiltered' => $iFilteredTotal,
        ];
        if (!empty($_REQUEST['is_unit_test'])) {
            return $hmdatas;
        }
        CRM_Utils_JSON::output($hmdatas);
    }

}
