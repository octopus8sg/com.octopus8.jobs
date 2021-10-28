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
            4 => 'date',
            5 => 'job_status',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

// SQL_CALC_FOUND_ROWS
        $sql = "
    SELECT  SQL_CALC_FOUND_ROWS
      t.id,
      t.date,
      dt.label device_type,
      t.device_id,
      s.label sensor_name,
      t.sensor_value,
      d.name
    FROM civicrm_health_monitor t INNER JOIN civicrm_device d on t.device_id = d.id
    INNER JOIN civicrm_option_value s on  t.sensor_id = s.weight
    INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'health_monitor_sensor'    
    INNER JOIN civicrm_option_value dt on t.device_type_id = dt.value
    INNER JOIN civicrm_option_group gdt on dt.option_group_id = gdt.id and gdt.name = 'health_monitor_device_type'    
    WHERE 1";


        if (isset($contactId)) {
            $sql .= " AND t.`contact_id` = " . $contactId . " ";
        }


        if (isset($device_type_id)) {
            if ($device_type_id > 0) {
                $sql .= " AND t.`device_type_id` = " . $device_type_id . " ";
            }
        }

        if (isset($sensor_id)) {
            if ($sensor_id > 0) {
                $sql .= " AND t.`sensor_id` = " . $sensor_id . " ";
            }
        }

        $month_ago = strtotime("-1 month", time());
        $date_month_ago = date("Y-m-d H:i:s", $month_ago);

        $today = strtotime("+1 day", time());
        $date_today = date("Y-m-d H:i:s", $today);

        if (isset($dateselect_from)) {
            if ($dateselect_from != null) {
                if ($dateselect_from != '') {
                    $sql .= " AND t.`date` >= '" . $dateselect_from . "' ";
                }
            }
        }


        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $sql .= " AND t.`date` <= '" . $dateselect_to . "' ";
                } else {
                    $sql .= " AND t.`date` <= '" . $date_today . "' ";
                }
            } else {
                $sql .= " AND t.`date` <= '" . $date_today . "' ";
            }
        } else {
            $sql .= " AND t.`date` <= '" . $date_today . "' ";
        }


//        CRM_Core_Error::debug_var('search_sql', $sql);


        if ($sort !== NULL) {
            $sql .= " ORDER BY {$sort} {$sortOrder}";
        } else {
            $sql = $sql . ' ORDER BY t.`date` ASC';
        }

        if ($limit !== false) {
            if ($limit !== NULL) {
                if ($offset !== false) {
                    if ($offset !== NULL) {
                        $sql .= " LIMIT {$offset}, {$limit}";
                    }
                }
            }
        }


//        CRM_Core_Error::debug_var('sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            $r_update = CRM_Utils_System::url('civicrm/healthmonitor/form',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/healthmonitor/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $update = '<a target="_blank" class="action-item crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
            $delete = '<a target="_blank" class="action-item crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$update $delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->date;
            $rows[$count][] = $dao->device_type;
            $rows[$count][] = $dao->name;
            $rows[$count][] = $dao->sensor_name;
            $rows[$count][] = $dao->sensor_value;
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
