<?php

use CRM_Job_ExtensionUtil as E;

class CRM_Job_Page_EmployerJobTab extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Employer Job Tab'));

        // Example: Assign a variable for use in a template
        $this->assign('currentTime', date('Y-m-d H:i:s'));
        $urlQry['snippet'] = 4;
        $employer_job_source_url = CRM_Utils_System::url('civicrm/job/employerjobsajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['employer_job_sourceUrl'] = $employer_job_source_url;
        $this->assign('alert_sourcel', $employer_job_source_url);
        $this->assign('useAjax', true);
        $this->assign('sourceUrl', $employer_job_source_url);
        CRM_Core_Resources::singleton()->addVars('source_url', $sourceUrl);
        parent::run();
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
//        $device_type_id = CRM_Utils_Request::retrieveValue('device_type_id', 'Positive', null);
////        CRM_Core_Error::debug_var('device_type_id', $device_type_id);
//
//        $sensor_id = CRM_Utils_Request::retrieveValue('sensor_id', 'Positive', null);
////        CRM_Core_Error::debug_var('sensor_id', $sensor_id);
//
//        $dateselect_to = CRM_Utils_Request::retrieveValue('dateselect_to', 'String', null);
//        try {
//            $dateselectto = new DateTime($dateselect_to);
//        } catch (Exception $e) {
//            $dateselect_to = null;
//        }
////        CRM_Core_Error::debug_var('dateselect_to', $dateselect_to);
//
//        $dateselect_from = CRM_Utils_Request::retrieveValue('dateselect_from', 'String', null);
//        try {
//            $dateselectto = new DateTime($dateselect_from);
//        } catch (Exception $e) {
//            $dateselect_from = null;
//        }
////        CRM_Core_Error::debug_var('dateselect_from', $dateselect_from);

        $sortMapper = [
            0 => 'id',
            1 => 'title',
            2 => 'application_count',
            3 => 'location',
            4 => 'created_date',
            5 => 'job_status',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

// SQL_CALC_FOUND_ROWS
        $selectsql = "
SELECT  SQL_CALC_FOUND_ROWS
    j.id,
    count(a.id) application_count,
    j.title,
    l.label location,                            
    j.created_date,
    s.label job_status
FROM civicrm_job j LEFT JOIN civicrm_job_application a on a.job_id = j.id
                              INNER JOIN civicrm_option_value s on  j.status_id = s.value
                              INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'job_status'
                              INNER JOIN civicrm_option_value l on  j.location_id = l.value
                              INNER JOIN civicrm_option_group gl on l.option_group_id = gl.id and gl.name = 'job_location'
";
$wheresql = " where 1 = 1";
$groupsql = " group by j.id, j.title, s.label, l.label, j.created_date";
$ordersql = " ORDER BY j.id desc";
        if (isset($contactId)) {
            $wheresql .= " AND j.`contact_id` = " . $contactId . " ";
        }


        if (isset($device_type_id)) {
            if ($device_type_id > 0) {
                $wheresql .= " AND j.`device_type_id` = " . $device_type_id . " ";
            }
        }

        if (isset($sensor_id)) {
            if ($sensor_id > 0) {
                $wheresql .= " AND j.`sensor_id` = " . $sensor_id . " ";
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
                    $wheresql .= " AND j.`created_date` <= '" . $dateselect_to . "' ";
                } else {
                    $wheresql .= " AND j.`created_date` <= '" . $date_today . "' ";
                }
            } else {
                $wheresql .= " AND j.`created_date` <= '" . $date_today . "' ";
            }
        } else {
            $wheresql .= " AND j.`created_date` <= '" . $date_today . "' ";
        }


//        CRM_Core_Error::debug_var('search_sql', $sql);


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
        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            $r_update = CRM_Utils_System::url('civicrm/job/form',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/job/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $update = '<a target="_blank" class="action-item crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
            $delete = '<a target="_blank" class="action-item crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$update $delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->title;
            $rows[$count][] = $dao->application_count;
            $rows[$count][] = $dao->location;
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
