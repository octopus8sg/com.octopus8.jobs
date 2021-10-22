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


    public function getAjax()
    {

//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
//        CRM_Core_Error::debug_var('contact', $contactId);


        $offset = CRM_Utils_Request::retrieveValue('iJobStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);

        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

        $device_type_id = CRM_Utils_Request::retrieveValue('device_type_id', 'Positive', null);
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);

        $sensor_id = CRM_Utils_Request::retrieveValue('sensor_id', 'Positive', null);
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);

        $dateselect_to = CRM_Utils_Request::retrieveValue('dateselect_to', 'String', null);
        try {
            $dateselectto = new DateTime($dateselect_to);
        } catch (Exception $e) {
            $dateselect_to = null;
        }
//        CRM_Core_Error::debug_var('dateselect_to', $dateselect_to);

        $dateselect_from = CRM_Utils_Request::retrieveValue('dateselect_from', 'String', null);
        try {
            $dateselectto = new DateTime($dateselect_from);
        } catch (Exception $e) {
            $dateselect_from = null;
        }
//        CRM_Core_Error::debug_var('dateselect_from', $dateselect_from);

        $sortMapper = [
            0 => 'id',
            1 => 'date',
            2 => 'device_type',
            3 => 'name',
            4 => 'sensor_name',
            5 => 'sensor_value',
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
    INNER JOIN civicrm_option_value dt on t.device_type_id = dt.weight
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
