<?php
/*
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC. All rights reserved.                        |
 |                                                                    |
 | This work is published under the GNU AGPLv3 license with some      |
 | permitted exceptions and without any warranty. For full license    |
 | and copyright information, see https://civicrm.org/licensing       |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 */
class CRM_Jobs_Form_Report_SscJob extends CRM_Report_Form {

    protected $_summary = NULL;

    protected $_softFrom = NULL;

    protected $noDisplayContributionOrSoftColumn = FALSE;

    protected $_customGroupExtends = [
        'Contact',
        'Individual',
    ];

    protected $groupConcatTested = TRUE;

    protected $isTempTableBuilt = FALSE;

    /**
     * Query mode.
     *
     * This can be 'Main' or 'SoftCredit' to denote which query we are building.
     *
     * @var string
     */
    protected $queryMode = 'Main';

    /**
     * Is this report being run on contributions as the base entity.
     *
     * The report structure is generally designed around a base entity but
     * depending on input it can be run in a sort of hybrid way that causes a lot
     * of complexity.
     *
     * If it is in isContributionsOnlyMode we can simplify.
     *
     * (arguably there should be 2 separate report templates, not one doing double duty.)
     *
     * @var bool
     */
//  protected $isContributionBaseMode = FALSE;

    /**
     * This report has been optimised for group filtering.
     *
     * @var bool
     * @see https://issues.civicrm.org/jira/browse/CRM-19170
     */
    protected $groupFilterNotOptimised = FALSE;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->_autoIncludeIndexedFieldsAsOrderBys = 1;
        $this->_columns = array_merge(
            $this->getColumns('Contact', [
                'order_bys_defaults' => ['sort_name' => 'ASC '],
                'fields_defaults' => ['sort_name'],
                'fields_excluded' => ['id'],
                'fields_required' => ['id'],
                'filters_defaults' => ['is_deleted' => 0],
                'no_field_disambiguation' => TRUE,
            ]),
            [
                'civicrm_email' => [
                    'dao' => 'CRM_Core_DAO_Email',
                    'fields' => [
                        'email' => [
                            'title' => ts('Employee Email'),
                            'default' => TRUE,
                        ],
                    ],
                    'grouping' => 'contact-fields',
                ],
//        'civicrm_line_item' => [
//          'dao' => 'CRM_Price_DAO_LineItem',
//        ],
                'civicrm_phone' => [
                    'dao' => 'CRM_Core_DAO_Phone',
                    'fields' => [
                        'phone' => [
                            'title' => ts('Employee Phone'),
                            'default' => TRUE,
                            'no_repeat' => TRUE,
                        ],
                    ],
                    'grouping' => 'contact-fields',
                ],
                'civicrm_o8_job' => [
                    'dao' => 'CRM_Jobs_DAO_SscJob',
                    'fields' => [
                        'ssc_job_id' => [
                            'name' => 'id',
                            'no_display' => TRUE,
                            'required' => TRUE,
                        ],
                        'created_date' => ['type' => CRM_Utils_Type::T_INT,
//                            'required' => TRUE,
                            'name' => 'created_date',
                            'title' => ts('Job Created Date'),
                            'default' => TRUE,
                        ],
//                        'device_id' => [
//                            'title' => ts('Device'),
////                            'required' => TRUE,
//                            'default' => TRUE,
//                        ],
//                        'sensor_id' => [
//                            'title' => ts('Sensor'),
////                            'required' => TRUE,
//                            'default' => TRUE,
//                        ],
//                        'sensor_value' => [
//                            'title' => ts('Value'),
////                            'required' => TRUE,
//                            'default' => TRUE,
//                        ],
                    ],
                    'filters' => [
                        'date' => ['operatorType' => CRM_Report_Form::OP_DATE],
                    ],
                    'order_bys' => [
                        'created_date' => ['title' => ts('Job Created Date')],
//                        'sensor_id' => ['title' => ts('Sensor')],
//                        'device_id' => ['title' => ts('Device')],
                    ],
                    'group_bys' => [
                        // фыввыфasdфыв
//                    'health_monitor_id' => [
//                      'name' => 'id',
//                      'required' => TRUE,
//                      'default' => TRUE,
//                      'title' => ts('Device Data'),
//                    ],
//                    'health_monitor_date' => [
//                      'name' => 'date',
//                      'required' => TRUE,
//                      'default' => TRUE,
//                      'title' => ts('Date'),
//                    ],
                    ],
                    'grouping' => 'contact-fields',
                ],
            ]
//      $this->getColumns('Address')
        );
        // The tests test for this variation of the sort_name field. Don't argue with the tests :-).
        $this->_columns['civicrm_contact']['fields']['sort_name']['title'] = ts('Employee Name');
        $this->_groupFilter = TRUE;
        $this->_tagFilter = TRUE;
        parent::__construct();
    }

    /**
     * Set the FROM clause for the report.
     */
    public function from()
    {
        $this->setFromBase('civicrm_contact');
// todo joins
        $this->_from .= "
        INNER JOIN civicrm_o8_job {$this->_aliases['civicrm_o8_job']}
        ON {$this->_aliases['civicrm_contact']}.id = {$this->_aliases['civicrm_o8_job']}.contact_id
        ";

        $this->appendAdditionalFromJoins();
    }

    /**
     * @param $rows
     *
     * @return array
     * @throws \CRM_Core_Exception
     */
    public function statistics(&$rows)
    {
        $statistics = parent::statistics($rows);

        return $statistics;
    }

    /**
     * Build the report query.
     *
     * @param bool $applyLimit
     *
     * @return string
     */
    public function buildQuery($applyLimit = TRUE)
    {
        return parent::buildQuery($applyLimit);
    }

    /**
     * Shared function for preliminary processing.
     *
     * This is called by the api / unit tests and the form layer and is
     * the right place to do 'initial analysis of input'.
     */
    public function beginPostProcessCommon()
    {

        // 1. use main contribution query to build temp table 1
        $sql = $this->buildQuery();
        $this->createTemporaryTable('civireport_contribution_detail_temp1', $sql);
        $this->limit();
        $this->setPager();
    }

    /**
     * Store group bys into array - so we can check elsewhere what is grouped.
     *
     * If we are generating a table of soft credits we need to group by them.
     */
//  protected function storeGroupByArray() {
//    if ($this->queryMode === 'SoftCredit') {
//      $this->_groupByArray = [$this->_aliases['civicrm_health_monitor_soft'] . '.id'];
//    }
//    else {
//      parent::storeGroupByArray();
//    }
//  }

    /**
     * Alter display of rows.
     *
     * Iterate through the rows retrieved via SQL and make changes for display purposes,
     * such as rendering contacts as links.
     *
     * @param array $rows
     *   Rows generated by SQL, with an array for each row.
     */
    public function alterDisplay(&$rows)
    {
        $entryFound = FALSE;
        $display_flag = $prev_cid = $cid = 0;
        foreach ($rows as $rowNum => $row) {
            CRM_Core_Error::debug_var('rows', $rows);
            CRM_Core_Error::debug_var('rowNum', $rowNum);
            CRM_Core_Error::debug_var('row', $row);

            if (!empty($this->_noRepeats) && $this->_outputMode != 'csv') {
                // don't repeat contact details if its same as the previous row
                if (array_key_exists('civicrm_contact_id', $row)) {
                    if ($cid = $row['civicrm_contact_id']) {
                        if ($rowNum == 0) {
                            $prev_cid = $cid;
                        } else {
                            if ($prev_cid == $cid) {
                                $display_flag = 1;
                                $prev_cid = $cid;
                            } else {
                                $display_flag = 0;
                                $prev_cid = $cid;
                            }
                        }

                        if ($display_flag) {
                            foreach ($row as $colName => $colVal) {
                                // Hide repeats in no-repeat columns, but not if the field's a section header
                                if (in_array($colName, $this->_noRepeats) &&
                                    !array_key_exists($colName, $this->_sections)
                                ) {
                                    unset($rows[$rowNum][$colName]);
                                }
                            }
                        }
                        $entryFound = TRUE;
                    }
                }
            }

            // convert donor sort name to link
            if (array_key_exists('civicrm_contact_sort_name', $row) &&
                !empty($rows[$rowNum]['civicrm_contact_sort_name']) &&
                array_key_exists('civicrm_contact_id', $row)
            ) {
                $url = CRM_Utils_System::url("civicrm/contact/view",
                    'reset=1&cid=' . $row['civicrm_contact_id'],
                    $this->_absoluteUrl
                );
                $rows[$rowNum]['civicrm_contact_sort_name_link'] = $url;
                $rows[$rowNum]['civicrm_contact_sort_name_hover'] = ts("View Contact Summary for this Contact.");
            }

            if ($val = CRM_Utils_Array::value('civicrm_health_monitor_sensor_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                $val = intval($val);
                $rows[$rowNum]['civicrm_health_monitor_sensor_id']
                    = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id", $val);
            }
            if ($val = CRM_Utils_Array::value('civicrm_health_monitor_date', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                $rows[$rowNum]['civicrm_health_monitor_date']
                    = $val;
            }
            if ($val = CRM_Utils_Array::value('civicrm_health_monitor_device_id', $row)) {
                $val = intval($val);
//                            CRM_Core_Error::debug_var('val', $val);
                $device_sql = "SELECT civicrm_device.name
                           from civicrm_device where civicrm_device.id = {$val}";
                $device_code = CRM_Core_DAO::singleValueQuery($device_sql);
                $rows[$rowNum]['civicrm_health_monitor_device_id']
                    = $device_code;
            }
            $lastKey = $rowNum;
        }
    }

    public function sectionTotals()
    {

        // Reports using order_bys with sections must populate $this->_selectAliases in select() method.
        if (empty($this->_selectAliases)) {
            return;
        }

        if (!empty($this->_sections)) {
            // build the query with no LIMIT clause
            $select = str_ireplace('SELECT SQL_CALC_FOUND_ROWS ', 'SELECT ', $this->_select);
            $sql = "{$select} {$this->_from} {$this->_where} {$this->_groupBy} {$this->_having} {$this->_orderBy}";

            // pull section aliases out of $this->_sections
            $sectionAliases = array_keys($this->_sections);

            $ifnulls = [];
            foreach (array_merge($sectionAliases, $this->_selectAliases) as $alias) {
                $ifnulls[] = "ifnull($alias, '') as $alias";
            }
            $this->_select = "SELECT " . implode(", ", $ifnulls);
            $this->_select = CRM_Contact_BAO_Query::appendAnyValueToSelect($ifnulls, $sectionAliases);

            /* Group (un-limited) report by all aliases and get counts. This might
             * be done more efficiently when the contents of $sql are known, ie. by
             * overriding this method in the report class.
             */

            $addtotals = '';

            if (array_search("civicrm_health_monitor_total_amount", $this->_selectAliases) !==
                FALSE
            ) {
                $addtotals = ", sum(civicrm_health_monitor_total_amount) as sumcontribs";
                $showsumcontribs = TRUE;
            }

            $query = $this->_select .
                "$addtotals, count(*) as ct from {$this->temporaryTables['civireport_contribution_detail_temp1']['name']} group by " .
                implode(", ", $sectionAliases);
            // initialize array of total counts
            $sumcontribs = $totals = [];
            $dao = CRM_Core_DAO::executeQuery($query);
            $this->addToDeveloperTab($query);
            while ($dao->fetch()) {

                // let $this->_alterDisplay translate any integer ids to human-readable values.
                $rows[0] = $dao->toArray();
                $this->alterDisplay($rows);
                $row = $rows[0];

                // add totals for all permutations of section values
                $values = [];
                $i = 1;
                $aliasCount = count($sectionAliases);
                foreach ($sectionAliases as $alias) {
                    $values[] = $row[$alias];
                    $key = implode(CRM_Core_DAO::VALUE_SEPARATOR, $values);
                    if ($i == $aliasCount) {
                        // the last alias is the lowest-level section header; use count as-is
                        $totals[$key] = $dao->ct;
                        if ($showsumcontribs) {
                            $sumcontribs[$key] = $dao->sumcontribs;
                        }
                    } else {
                        // other aliases are higher level; roll count into their total
                        $totals[$key] = (array_key_exists($key, $totals)) ? $totals[$key] + $dao->ct : $dao->ct;
                        if ($showsumcontribs) {
                            $sumcontribs[$key] = array_key_exists($key, $sumcontribs) ? $sumcontribs[$key] + $dao->sumcontribs : $dao->sumcontribs;
                        }
                    }
                }
            }
            if ($showsumcontribs) {
                $totalandsum = [];
                // ts exception to avoid having ts("%1 %2: %3")
                $title = '%1 contributions / soft-credits: %2';

                if (CRM_Utils_Array::value('contribution_or_soft_value', $this->_params) ==
                    'contributions_only'
                ) {
                    $title = '%1 contributions: %2';
                } elseif (CRM_Utils_Array::value('contribution_or_soft_value', $this->_params) ==
                    'soft_credits_only'
                ) {
                    $title = '%1 soft-credits: %2';
                }
                foreach ($totals as $key => $total) {
                    $totalandsum[$key] = ts($title, [
                        1 => $total,
                        2 => CRM_Utils_Money::format($sumcontribs[$key]),
                    ]);
                }
                $this->assign('sectionTotals', $totalandsum);
            } else {
                $this->assign('sectionTotals', $totals);
            }
        }
    }

    /**
     * Generate the from clause as it relates to the soft credits.
     */
    public function softCreditFrom()
    {

        $this->appendAdditionalFromJoins();
    }

    /**
     * Append the joins that are required regardless of context.
     */
    public function appendAdditionalFromJoins()
    {
        $this->joinPhoneFromContact();
        $this->joinAddressFromContact();
        $this->joinEmailFromContact();

    }



}
