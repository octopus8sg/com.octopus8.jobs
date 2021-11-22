<?php

use CRM_Jobs_ExtensionUtil as E;

class CRM_Jobs_Page_ApplicationsSearch extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Search Applications'));

        // Example: Assign a variable for use in a template
        $urlQry['snippet'] = 4;
//        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
//        $this->assign('contactId', $contactId);
//        $urlQry['cid'] = $contactId;
        $employeeId = CRM_Utils_Request::retrieve('employeeid', 'Positive');
        $employerId = CRM_Utils_Request::retrieve('employerid', 'Positive');
        $jobId = CRM_Utils_Request::retrieve('jobid', 'Positive');
        if ($employeeId > 0) {
            $urlQry['employeeid'] = $employeeId;
        }
        if ($employerId > 0) {
            $urlQry['employerid'] = $employerId;
        }
        if ($jobId > 0) {
            $urlQry['jobid'] = $jobId;
        }
//        CRM_Core_Error::debug_var('employerId', $employerId);
//        CRM_Core_Error::debug_var('employeeId', $employeeId);
        $app_source_url = CRM_Utils_System::url('civicrm/jobs/applicationsajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['application_sourceUrl'] = $app_source_url;
        $this->assign('useAjax', true);
        CRM_Core_Resources::singleton()->addVars('source_url', $sourceUrl);
        $controller_data = new CRM_Core_Controller_Simple(
            'CRM_Jobs_Form_JobsCommonFilter',
            ts('Job Filter'),
            NULL,
            FALSE, FALSE, TRUE
        );
        $controller_data->setEmbedded(TRUE);
        $controller_data->run();
        parent::run();
    }

    public function getApplicationsAjax()
    {

//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = null;

//        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');

        $employeeId = CRM_Utils_Request::retrieve('employeeid', 'Positive');
        $employerId = CRM_Utils_Request::retrieve('employerid', 'Positive');
        $thejobId = CRM_Utils_Request::retrieve('jobid', 'Positive');
        $is_admin = false;
        $is_employer = false;
        $is_employee = false;

        if (CRM_Core_Permission::check('administer CiviCRM')) {
            $is_admin = true;
        }
        $currentUserId = CRM_Core_Session::getLoggedInContactID();
        if ($currentUserId == $employeeId) {
            $is_employee = true;
        }
        if ($currentUserId == $employerId) {
            $is_employer = true;
        }

        $employerIds = CRM_Utils_Request::retrieveValue('employer_ids', 'String', null);
        $employeeIds = CRM_Utils_Request::retrieveValue('employee_ids', 'String', null);
        $appId = CRM_Utils_Request::retrieveValue('application_id', 'String', null);
        $jobId = CRM_Utils_Request::retrieveValue('application_job_id', 'String', null);
        $is_active = CRM_Utils_Request::retrieveValue('is_active', 'Boolean', null);
        $job_is_active = CRM_Utils_Request::retrieveValue('job_is_active', 'Boolean', null);

//        CRM_Core_Error::debug_var('job_is_active', $job_is_active);

//start and end date
        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);


        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

//todo
        $location_id = CRM_Utils_Request::retrieveValue('location_id', 'Positive', null);
//        CRM_Core_Error::debug_var('device_type_id', $location_id);

        $app_status_id = CRM_Utils_Request::retrieveValue('app_status_id', 'Positive', null);

        $job_status_id = CRM_Utils_Request::retrieveValue('job_status_id', 'Positive', null);
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
        if (!isset($employeeId)) {
            $sortMapper = [
                0 => 'app_id',
                1 => 'is_active',
                2 => 'title',
                3 => 'role',
                4 => 'location',
                5 => 'job_contact_id',
                6 => 'application_count',
                7 => 'job_created_date',
                8 => 'job_is_active',
                9 => 'app_contact_id',
                10 => 'app_created_date',
                11 => 'app_status',
            ];
        } else {
            $sortMapper = [
                0 => 'app_id',
                1 => 'is_active',
                2 => 'title',
                3 => 'role',
                4 => 'location',
                5 => 'job_contact_id',
                6 => 'job_created_date',
                7 => 'job_is_active',
                8 => 'app_created_date',
                9 => 'app_status'
            ];
        }
        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

// SQL_CALC_FOUND_ROWS
        $selectsql = "
SELECT  SQL_CALC_FOUND_ROWS
    j.id job_id,
    count(a.id) application_count,
    j.title,
    j.is_active job_is_active,
    ap.is_active,                            
    j.contact_id job_contact_id,
    r.label role,                            
    l.label location,                            
    j.created_date job_created_date,
    ap.created_date app_created_date,
    ap.contact_id app_contact_id,
    s.label app_status,
    ap.id app_id
FROM civicrm_o8_job j LEFT JOIN civicrm_o8_application a on a.o8_job_id = j.id
    INNER JOIN civicrm_o8_application ap on ap.o8_job_id = j.id
    INNER JOIN civicrm_option_value s on  ap.status_id = s.value
    INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'o8_application_status'
    INNER JOIN civicrm_option_value l on  j.location_id = l.value
    INNER JOIN civicrm_option_group gl on l.option_group_id = gl.id and gl.name = 'o8_job_location'
    INNER JOIN civicrm_option_value r on  j.role_id = r.value
    INNER JOIN civicrm_option_group gr on r.option_group_id = gr.id and gr.name = 'o8_job_role'
";
        $wheresql = " where 1 = 2 ";
        if ($is_admin) {
            $wheresql = " where 1 = 1 ";
            if ($employeeId) {
                $wheresql = " where ap.contact_id = " . $employeeId . " ";
            }
            if ($employerId) {
                $wheresql = " where j.contact_id = " . $employerId . " ";
            }
        }
        if ($is_employee) {
            $wheresql = " where ap.contact_id = " . $employeeId . " ";
        }
        if ($is_employer) {
            $wheresql = " where j.contact_id = " . $employerId . " ";
        }
        $groupsql = " group by j.id, j.is_active, ap.is_active, j.title, s.label, l.label, r.label, j.created_date, j.contact_id, app_id";
        $ordersql = " ORDER BY app_id desc";
        if (isset($employerIds)) {
            if ($employerIds !== null) {
                if (trim(strval($employerIds)) !== "") {
                    $wheresql .= " AND j.`contact_id` in (" . $employerIds . ") ";
                }
            }
        }

        if (isset($employeeIds)) {
            if ($employeeIds !== null) {
                if (trim(strval($employeeIds)) !== "") {
                    $wheresql .= " AND ap.`contact_id` in (" . $employeeIds . ") ";
                }
            }
        }

        if (isset($contactId)) {
            if ($contactId !== null) {
                $wheresql .= " AND ap.`contact_id` = " . $contactId . " ";
            }
        }

        if (isset($employeeId)) {
            if ($employeeId !== null) {
                $wheresql .= " AND ap.`contact_id` = " . $employeeId . " ";
            }
        }

        if (isset($appId)) {
            if ($appId !== null) {
                if ($appId !== "") {

                    $wheresql .= " AND ap.`id` = " . intval($appId) . " ";
                }
            }
        }

        if (isset($jobId)) {
            if ($jobId !== null) {
                if ($jobId !== "") {
                    $wheresql .= " AND (j.`id` = " . intval($jobId) . " OR  j.`title` like '%" . strval($jobId) . "%')";
                }
            }
        }

        if (isset($thejobId)) {
            if ($thejobId !== null) {
                if ($thejobId > 0) {
                    $wheresql .= " AND j.`id` = " . $thejobId . " ";
                }
            }
        }

        if (isset($location_id)) {
            if ($location_id > 0) {
                $wheresql .= " AND j.`location_id` = " . $location_id . " ";
            }
        }

        if (isset($app_status_id)) {
            if ($app_status_id > 0) {
                $wheresql .= " AND ap.`status_id` = " . $app_status_id . " ";
            }
        }

        if (isset($job_status_id)) {
            if ($job_status_id > 0) {
                $wheresql .= " AND j.`status_id` = " . $job_status_id . " ";
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
        if (isset($is_active)) {
            $wheresql .= " AND ap.`is_active` = " . strval($is_active) . " ";
        }
        if (isset($job_is_active)) {
            $wheresql .= " AND j.`is_active` = " . strval($job_is_active) . " ";
        }

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
            if (!empty($dao->job_contact_id)) {
                $job_contact = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->job_contact_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->job_contact_id) . '</a>';
            }
            if (!empty($dao->app_contact_id)) {
                $app_contact = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->app_contact_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->app_contact_id) . '</a>';
            }
            $is_active_view = "No";
//                    CRM_Core_Error::debug_var('isactive?', $dao->is_active);
            if ($dao->is_active > 0) {
                $is_active_view = "Yes";
            }
            $jis_active_view = "No";
//                    CRM_Core_Error::debug_var('isactive?', $dao->is_active);
            if ($dao->job_is_active > 0) {
                $jis_active_view = "Yes";
            }

            $r_view = CRM_Utils_System::url('civicrm/applications/form',
                ['action' => 'view', 'id' => $dao->app_id]);
            $r_update = CRM_Utils_System::url('civicrm/applications/form',
                ['action' => 'update', 'id' => $dao->app_id]);
            $r_delete = CRM_Utils_System::url('civicrm/applications/form',
                ['action' => 'delete', 'id' => $dao->app_id]);
            $view = '<a target="_blank" class="action-item view-application crm-hover-button" href="' . $r_view . '"><i class="crm-i fa-eye"></i>&nbsp;View</a>';
            $update = '<a target="_blank" class="action-item update-application crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
//            $delete = '<a target="_blank" class="action-item delete-application crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$view</span>";
            $rows[$count][] = $dao->app_id;
            $rows[$count][] = $is_active_view;
            $rows[$count][] = $dao->title;
            $rows[$count][] = $dao->role;
            $rows[$count][] = $dao->location;
            $rows[$count][] = $job_contact;
            if (!isset($employeeId)) {
                $rows[$count][] = $dao->application_count;
            }
            $rows[$count][] = $dao->job_created_date;
            $rows[$count][] = $jis_active_view;
            if (!isset($employeeId)) {
                $rows[$count][] = $app_contact;
            }
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
