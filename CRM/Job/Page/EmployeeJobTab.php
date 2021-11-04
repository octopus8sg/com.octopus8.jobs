<?php

use CRM_Job_ExtensionUtil as E;

class CRM_Job_Page_EmployeeJobTab extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Employee Job Tab'));

        // Example: Assign a variable for use in a template
        $urlQry['snippet'] = 4;
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
        $urlQry['cid'] = $contactId;
        $this->assign('contactId', $contactId);
        $employee_job_source_url = CRM_Utils_System::url('civicrm/job/employeejobsajax', $urlQry, FALSE, NULL, FALSE);
        $employee_application_source_url = CRM_Utils_System::url('civicrm/job/employeeapplicationsajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['employee_job_sourceUrl'] = $employee_job_source_url;
        $sourceUrl['employee_application_sourceUrl'] = $employee_application_source_url;
        $this->assign('employee_job_sourceurl', $employee_job_source_url);
        $this->assign('useAjax', true);
//        $this->assign('sourceUrl', $employee_job_source_url);
        CRM_Core_Resources::singleton()->addVars('source_url', $sourceUrl);
        $controller_data = new CRM_Core_Controller_Simple(
            'CRM_Job_Form_CommonJobFilter',
            ts('Job Filter'),
            NULL,
            FALSE, FALSE, TRUE
        );
        $controller_data->setEmbedded(TRUE);
        $controller_data->run();
        parent::run();

    }

    public function getJobsAjax()
    {

//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = null;
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');

        $employerIds = CRM_Utils_Request::retrieve('employer_ids', 'String');
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
            4 => 'contact_id',
            5 => 'application_count',
            6 => 'created_date',
            7 => 'job_status',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

// SQL_CALC_FOUND_ROWS
        $selectsql = "
SELECT  SQL_CALC_FOUND_ROWS
    j.id,
    count(a.id) application_count,
    j.title,
    j.contact_id,
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
        $groupsql = " group by j.id, j.title, s.label, l.label, r.label, j.created_date, j.contact_id";
        $ordersql = " ORDER BY j.id desc";
        if (isset($employerIds)) {
            if ($employerIds !== null) {
                if (trim(strval($employerIds)) !== "") {
                    $wheresql .= " AND j.`contact_id` in (" . $employerIds . ") ";
                }
            }
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
                    $wheresql .= " AND j.`created_date` < '" . $date_to . "' ";
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
            if (!empty($dao->contact_id)) {
                $contact = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->contact_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->contact_id) . '</a>';
            }
            $r_apply = CRM_Utils_System::url('civicrm/application/form',
                ['action' => 'add', 'jid' => $dao->id, 'cid' => $contactId]);
            $apply = '<a target="_blank" class="action-item add-application crm-hover-button" href="' . $r_apply . '"><i class="crm-i fa-pencil"></i>&nbsp;Apply</a>';
//            $delete = '<a target="_blank" class="action-item delete-job crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$apply</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->title;
            $rows[$count][] = $dao->role;
            $rows[$count][] = $dao->location;
            $rows[$count][] = $contact;
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

    public function getApplicationsAjax()
    {

//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = null;
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');

        $employerIds = CRM_Utils_Request::retrieve('employer_ids', 'String');
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
            0 => 'app_id',
            1 => 'title',
            2 => 'role',
            3 => 'location',
            4 => 'contact_id',
            5 => 'application_count',
            6 => 'job_created_date',
            7 => 'app_created_date',
            8 => 'app_status',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

// SQL_CALC_FOUND_ROWS
        $selectsql = "
SELECT  SQL_CALC_FOUND_ROWS
    j.id job_id,
    count(a.id) application_count,
    j.title,
    j.contact_id,
    r.label role,                            
    l.label location,                            
    j.created_date job_created_date,
    ap.created_date app_created_date,
    s.label app_status,
    ap.id app_id
FROM civicrm_job j LEFT JOIN civicrm_job_application a on a.job_id = j.id
    INNER JOIN civicrm_job_application ap on ap.job_id = j.id
    INNER JOIN civicrm_option_value s on  ap.job_application_status_id = s.value
    INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'job_application_status'
    INNER JOIN civicrm_option_value l on  j.location_id = l.value
    INNER JOIN civicrm_option_group gl on l.option_group_id = gl.id and gl.name = 'job_location'
    INNER JOIN civicrm_option_value r on  j.role_id = r.value
    INNER JOIN civicrm_option_group gr on r.option_group_id = gr.id and gr.name = 'job_role'
";
        $wheresql = " where 1 = 1";
        $groupsql = " group by j.id, j.title, s.label, l.label, r.label, j.created_date, j.contact_id, app_id";
        $ordersql = " ORDER BY j.id desc";
        if (isset($employerIds)) {
            if ($employerIds !== null) {
                if (trim(strval($employerIds)) !== "") {
                    $wheresql .= " AND j.`contact_id` in (" . $employerIds . ") ";
                }
            }
        }

        if (isset($contactId)) {
            if ($contactId !== null) {
                    $wheresql .= " AND ap.`contact_id` = " . $contactId . " ";
            }
        }

        if (isset($location_id)) {
            if ($location_id > 0) {
                $wheresql .= " AND j.`location_id` = " . $location_id . " ";
            }
        }

        if (isset($status_id)) {
            if ($status_id > 0) {
                $wheresql .= " AND ap.`job_application_status_id` = " . $status_id . " ";
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
                    $wheresql .= " AND ap.`created_date` >= '" . $dateselect_from . "' ";
                }
            }
        }


        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $_to = strtotime("+1 day", strtotime($dateselect_to));
                    $date_to = date("Y-m-d H:i:s", $_to);
                    $wheresql .= " AND ap.`created_date` < '" . $date_to . "' ";
                } else {
                    $wheresql .= " AND ap.`created_date` <= '" . $date_today . "' ";
                }
            } else {
                $wheresql .= " AND ap.`created_date` <= '" . $date_today . "' ";
            }
        } else {
            $wheresql .= " AND ap.`created_date` <= '" . $date_today . "' ";
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
            if (!empty($dao->contact_id)) {
                $contact = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->contact_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->contact_id) . '</a>';
            }
            $r_view = CRM_Utils_System::url('civicrm/application/form',
                ['action' => 'view', 'id' => $dao->app_id, 'cid'=>$contactId, 'jid' => $dao->job_id]);
            $r_update = CRM_Utils_System::url('civicrm/application/form',
                ['action' => 'update', 'id' => $dao->app_id]);
            $r_delete = CRM_Utils_System::url('civicrm/application/form',
                ['action' => 'delete', 'id' => $dao->app_id]);
            $view = '<a target="_blank" class="action-item view-app crm-hover-button" href="' . $r_view . '"><i class="crm-i fa-eye"></i>&nbsp;View</a>';
//            $update = '<a target="_blank" class="action-item update-app crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
//            $delete = '<a target="_blank" class="action-item delete-job crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$view</span>";
            $rows[$count][] = $dao->app_id;
            $rows[$count][] = $dao->title;
            $rows[$count][] = $dao->role;
            $rows[$count][] = $dao->location;
            $rows[$count][] = $contact;
            $rows[$count][] = $dao->application_count;
            $rows[$count][] = $dao->job_created_date;
            $rows[$count][] = $dao->app_created_date;
            $rows[$count][] = $dao->app_status;
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
