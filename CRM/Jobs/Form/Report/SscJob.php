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
class CRM_Jobs_Form_Report_SscJob extends CRM_Report_Form
{

    protected $_summary = NULL;

    protected $_softFrom = NULL;

    protected $noDisplayContributionOrSoftColumn = FALSE;

    protected $_exposeContactID = FALSE;

    protected $_customGroupExtends = [
        'SscJob',
//        'Contact',
//        'Individual',
        'Organisation',
    ];

    public function customDataFrom($joinsForFiltersOnly = FALSE)
    {
        if (empty($this->_customGroupExtends)) {
            return;
        }
        $mapper = CRM_Core_BAO_CustomQuery::$extendsMap;
        $mapper['SscJob'] = 'civicrm_o8_job';
        $mapper['SscApplication'] = 'civicrm_o8_application';
        //CRM-18276 GROUP_CONCAT could be used with singleValueQuery and then exploded,
        //but by default that truncates to 1024 characters, which causes errors with installs with lots of custom field sets
        $customTables = [];
        $customTablesDAO = CRM_Core_DAO::executeQuery("SELECT table_name FROM civicrm_custom_group");
        while ($customTablesDAO->fetch()) {
            $customTables[] = $customTablesDAO->table_name;
        }

        foreach ($this->_columns as $table => $prop) {
            if (in_array($table, $customTables)) {
                $extendsTable = $mapper[$prop['extends']];
//        CRM_Core_Error::debug_var('mapper', $mapper);
//        CRM_Core_Error::debug_var('prop', $prop);
//        CRM_Core_Error::debug_var('extendsTable', $extendsTable);
//
                // Check field is required for rendering the report.
                if ((!$this->isFieldSelected($prop)) || ($joinsForFiltersOnly && !$this->isFieldFiltered($prop))) {
                    continue;
                }
                $baseJoin = CRM_Utils_Array::value($prop['extends'], $this->_customGroupExtendsJoin, "{$this->_aliases[$extendsTable]}.id");

                $customJoin = is_array($this->_customGroupJoin) ? $this->_customGroupJoin[$table] : $this->_customGroupJoin;
                $this->_from .= "
{$customJoin} {$table} {$this->_aliases[$table]} ON {$this->_aliases[$table]}.entity_id = {$baseJoin}";
                // handle for ContactReference
                if (array_key_exists('fields', $prop)) {
                    foreach ($prop['fields'] as $fieldName => $field) {
                        if (CRM_Utils_Array::value('dataType', $field) ==
                            'ContactReference'
                        ) {
                            $columnName = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_CustomField', CRM_Core_BAO_CustomField::getKeyID($fieldName), 'column_name');
                            $this->_from .= "
LEFT JOIN civicrm_contact {$field['alias']} ON {$field['alias']}.id = {$this->_aliases[$table]}.{$columnName} ";
                        }
                    }
                }
            }
        }
    }

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
        $this->_columns =
//            array_merge(


            //            $this->getColumns('Contact', [
//                'order_bys_defaults' => ['sort_name' => 'ASC '],
//                'fields' => ['sort_name'],
//                'fields_defaults' => ['sort_name'],
//                'fields_excluded' => ['id'],
//                'filters' => ['sort_name'],
//                'fields_required' => ['id'],
//                'filters_defaults' => ['is_deleted' => 0],
//                'no_field_disambiguation' => TRUE,
//            ]),
            [
                'civicrm_o8_job' => [
                    'dao' => 'CRM_Jobs_DAO_SscJob',
                    'fields' => [
                        'ssc_job_id' => [
                            'name' => 'id',
                            'title' => ts('Job ID'),
                            'no_display' => FALSE,
                            'required' => TRUE,
                        ],
                        'title' => [
                            'title' => ts('Title'),
                            'default' => TRUE,
                        ],
                        'description' => [
                            'title' => ts('Description'),
                            'default' => TRUE,
                        ],
                        'role_id' => [
                            'title' => ts('Role'),
                            'default' => TRUE,
                        ],
                        'location_id' => [
                            'title' => ts('Location'),
                            'default' => TRUE,
                        ],
//                        'is_active' => [
//                            'title' => ts('Position Open?'),
//                            'default' => TRUE,
//                        ],
                        'contact_id' => [
//                            'type' => 'Contact',
//                            'required' => TRUE,
                            'order_bys_defaults' => ['sort_name' => 'ASC '],
                            'fields_defaults' => ['sort_name'],
                            'name' => 'contact_id',
                            'title' => ts('Employer'),
                            'default' => TRUE,
                        ],
                        'created_date' => ['type' => CRM_Utils_Type::T_INT,
//                            'required' => TRUE,
                            'name' => 'created_date',
                            'title' => ts('Job Created Date'),
                            'default' => TRUE,
                        ],
                        'due_date' => ['type' => CRM_Utils_Type::T_INT,
//                            'required' => TRUE,
                            'name' => 'due_date',
                            'title' => ts('Job Closed'),
                            'default' => TRUE,
                        ],
                        'created_id' => [
//                            'type' => 'Contact',
//                            'required' => TRUE,
                            'order_bys_defaults' => ['sort_name' => 'ASC '],
                            'fields_defaults' => ['sort_name'],
                            'name' => 'created_id',
                            'title' => ts('Job Created By'),
                            'default' => TRUE,
                        ],
                        'modified_date' => ['type' => CRM_Utils_Type::T_INT,
//                            'required' => TRUE,
                            'name' => 'modified_date',
                            'title' => ts('Job Modified Date'),
                            'default' => TRUE,
                        ],
                        'modified_id' => [
//                            'type' => 'Contact',
//                            'required' => TRUE,
                            'name' => 'modified_id',
                            'order_bys_defaults' => ['sort_name' => 'ASC '],
                            'fields_defaults' => ['sort_name'],
                            'title' => ts('Job Modified By'),
                            'default' => TRUE,
                        ],

//                        'sensor_value' => [
//                            'title' => ts('Value'),
////                            'required' => TRUE,
//                            'default' => TRUE,
//                        ],
                    ],
                    'filters' => [
                        'title' => [
                            'operator' => 'like',
                            'title' => ts('Job Title')],
                        'description' => [
                            'operator' => 'like',
                            'title' => ts('Job Description')],
                        'due_date' => [
                            'operatorType' => CRM_Report_Form::OP_DATE,
                            'title' => ts('Job Closed')],
                        'created_date' => [
                            'operatorType' => CRM_Report_Form::OP_DATE,
                            'title' => ts('Job Created Date')],
                        'modified_date' => [
                            'operatorType' => CRM_Report_Form::OP_DATE,
                            'title' => ts('Job Modified Date')],
                        'role_id' => [
                            'title' => ts('Role'),
                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
                            'options' => CRM_Core_PseudoConstant::get('CRM_Jobs_DAO_SscJob', 'role_id'),
                        ],                        
                        'location_id' => [
                            'title' => ts('Location'),
                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
                            'options' => CRM_Core_PseudoConstant::get('CRM_Jobs_DAO_SscJob', 'location_id'),
                        ],                        
//                        'is_active' => [
//                            'title' => ts('Position Open?'),
//                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//                            'options' => [1 => 'Open', 0 => 'Closed'],
//                        ],
                    ],
                    'order_bys' => [
                        'id' => ['title' => ts('Job ID')],
                        'title' => ['title' => ts('Job Title')],
                        'description' => ['title' => ts('Job Description')],
                        'role_id' => ['title' => ts('Role')],
                        'location_id' => ['title' => ts('Location')],
                        'due_date' => ['title' => ts('Job Closed')],
                        'created_date' => ['title' => ts('Job Created Date')],
//                        'created_id' => ['title' => ts('Job Created By')],
                        'modified_date' => ['title' => ts('Job Modified Date')],
//                        'modified_id' => ['title' => ts('Job Modified By')],
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
                'civicrm_contact' => [
                    'dao' => 'CRM_Contact_DAO_Contact',
                    'fields' => [
//                        'organization_name' => [
//                            'title' => ts('Employer Name'),
//                            'required' => TRUE,
//                            'no_repeat' => TRUE,
//                        ],
//                        'id' => [
//                            'no_display' => TRUE,
//                            'required' => TRUE,
//                        ],
                    ],
                    'filters' => [
                        'organization_name' => [
                            'title' => ts('Employer Name'),
                            'operatorType' => CRM_Report_Form::OP_STRING,
                        ],
                    ],
//                    'grouping' => 'contact-fields',
                    'order_bys' => array(
                        'organization_name' => array(
                            'title' => ts('Employer Name'),
                            'required' => TRUE,
                        ),
                    ),
                ],
                'civicrm_email' => [
                    'dao' => 'CRM_Core_DAO_Email',
                    'fields' => [
                        'email' => [
                            'title' => ts('Employer Email'),
                            'default' => TRUE,
                        ],
                    ],
                    'grouping' => 'contact-fields',
                ],
                'civicrm_created_user' => array(
                    'dao' => 'CRM_Contact_DAO_Contact',
                    'fields' => array(
//                        'created_user_id' => array(
//                            'name' => 'id',
//                            'title' => ts('Created User ID'),
//                            'no_display' => TRUE,
//                            'required' => TRUE,
//                        ),
                        'created_name' => array(
                            'name' => 'display_name',
                            'title' => ts('Created User Name'),
                            'no_display' => TRUE,
                        ),
                    ),
                    'filters' => array_merge
                    (
//                        $this->getBasicContactFilters(),
                        [
                            'created_name' => ['name' => 'display_name',
                                'title' => ts('Created User Name')],
//                            'source' => ['title' => ts('Modified User Source')],
//                            'id' => ['title' => ts('Modified User ID')],
//                            'gender_id' => ['title' => ts('Created User Gender')],
//                            'birth_date' => ['title' => ts('Created User Birth Date')],
                        ]),
                    'grouping' => 'contact-fields',
                    'order_bys' => array(
                        'display_name' => array(
                            'title' => ts('Created User Name'),
                            'required' => TRUE,
                        ),
                    ),
                ),
                'civicrm_modified_user' => array(
                    'dao' => 'CRM_Contact_DAO_Contact',
                    'fields' => array(
//                        'modified_user_id' => array(
//                            'name' => 'id',
//                            'title' => ts('Modified User ID'),
//                            'no_display' => TRUE,
//                            'required' => TRUE,
//                        ),
                        'modified_name' => array(
                            'name' => 'display_name',
                            'title' => ts('Modified User Name'),
                            'required' => TRUE,
                            'no_display' => TRUE,
                            'no_repeat' => TRUE,
                        ),
                    ),
                    'filters' => array_merge
                    (
//                        $this->getBasicContactFilters(),
                        [
                            'sort_name' => ['name' => 'display_name',
                                'title' => ts('Modified User Name')],
//                            'source' => ['title' => ts('Modified User Source')],
//                            'id' => ['title' => ts('Modified User ID')],
//                            'gender_id' => ['title' => ts('Modified User Gender')],
//                            'birth_date' => ['title' => ts('Modified User Birth Date')],
                        ]),
                    'grouping' => 'contact-fields',
                    'order_bys' => array(
                        'modified_name' => array(
                            'title' => ts('Modified User Name'),
                            'required' => TRUE,
                        ),
                    ),
                ),

            ]
//      $this->getColumns('Address')
//        )
        ;
        // The tests test for this variation of the sort_name field. Don't argue with the tests :-).
//        $this->_columns['civicrm_contact']['fields']['sort_name']['title'] = ts('Employer Name');
//        CRM_Core_Error::debug_var('columns', $this->_columns);
        $this->_groupFilter = TRUE;
        $this->_tagFilter = TRUE;
        parent::__construct();
    }

    /**
     * Set the FROM clause for the report.
     */
    public function from()
    {
        $this->setFromBase('civicrm_o8_job');
// todo joins
        $this->_from .= "
        INNER JOIN civicrm_contact {$this->_aliases['civicrm_contact']}
        ON {$this->_aliases['civicrm_contact']}.id = {$this->_aliases['civicrm_o8_job']}.contact_id
        LEFT JOIN civicrm_contact {$this->_aliases['civicrm_created_user']}
        ON {$this->_aliases['civicrm_created_user']}.id = {$this->_aliases['civicrm_o8_job']}.created_id
        LEFT JOIN civicrm_contact {$this->_aliases['civicrm_modified_user']}
        ON {$this->_aliases['civicrm_modified_user']}.id = {$this->_aliases['civicrm_o8_job']}.modified_id
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

//        .entity_id = .id;
//        CRM_Core_Error::debug_var('sql', $sql);
        $checked_sql = str_replace(".entity_id = .id", ".entity_id = o8_job_civireport.id", $sql);
//        CRM_Core_Error::debug_var('checked_sql', $checked_sql);
//        CRM_Core_Error::debug_var('aliases', $this->_aliases);

        //        .entity_id = .id
        $this->createTemporaryTable('civireport_contribution_detail_temp1', $checked_sql);
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
//            CRM_Core_Error::debug_var('rows', $rows);
        foreach ($rows as $rowNum => $row) {
//            CRM_Core_Error::debug_var('rowNum', $rowNum);
//            CRM_Core_Error::debug_var('row_before', $row);
////            if (!$rows[$rowNum]['civicrm_o8_job_is_active']) {
//                $rows[$rowNum]['civicrm_o8_job_is_active'] = intval($rows[$rowNum]['civicrm_o8_job_is_active']);
////            }

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

            if ($val = CRM_Utils_Array::value('civicrm_o8_job_contact_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);

                $rows[$rowNum]['civicrm_o8_job_contact_id']
                    = $this->getContactLink($val);
            }
            if ($val = CRM_Utils_Array::value('civicrm_o8_job_created_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);

                $rows[$rowNum]['civicrm_o8_job_created_id']
                    = $this->getContactLink($val);
            }
            if ($val = CRM_Utils_Array::value('civicrm_o8_job_modified_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);

                $rows[$rowNum]['civicrm_o8_job_modified_id']
                    = $this->getContactLink($val);
            }
            if ($val = CRM_Utils_Array::value('civicrm_o8_job_role_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                $val = intval($val);
                $rows[$rowNum]['civicrm_o8_job_role_id']
                    = CRM_Core_PseudoConstant::getLabel("CRM_Jobs_BAO_SscJob", "role_id", $val);
            }
            if ($val = CRM_Utils_Array::value('civicrm_o8_job_location_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                $val = intval($val);
                $rows[$rowNum]['civicrm_o8_job_location_id']
                    = CRM_Core_PseudoConstant::getLabel("CRM_Jobs_BAO_SscJob", "location_id", $val);
            }
            if ($val = CRM_Utils_Array::value('civicrm_o8_job_description', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                if (strlen($val) > 1) {
                    $val = trim(strip_tags($val));
                    $words = preg_split("/[\s]+/", $val);
                    if (sizeof($words) > 5) {
                        $val = implode(' ', array_slice($words, 0, 5)) . "...";
                    }
                }
//                $val =
                $rows[$rowNum]['civicrm_o8_job_description']
                    = $val;
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
     * Generate the from clause as it relates to the soft credits.
     */
    public function getContactLink($contactId)
    {
        $contact = "Not set";
        if (!empty($contactId)) {
            $contact = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                    ['reset' => 1, 'cid' => $contactId]) . '">' .
                CRM_Contact_BAO_Contact::displayName($contactId) . '</a>';

        }
        return $contact;

    }

    public function getFrozenHtml($string)
    {
        $value = htmlspecialchars($string);
        $html = nl2br($value) . "\n";
        return $html;
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
