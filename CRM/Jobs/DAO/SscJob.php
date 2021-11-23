<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from com.octopus8.jobs/xml/schema/CRM/Jobs/SscJob.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:691a822d4ceee5df8c75a13ca64441eb)
 */
use CRM_Jobs_ExtensionUtil as E;

/**
 * Database access object for the SscJob entity.
 */
class CRM_Jobs_DAO_SscJob extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_o8_job';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique SSC Job ID
   *
   * @var int
   */
  public $id;

  /**
   * FK to Contact
   *
   * @var int
   */
  public $contact_id;

  /**
   * @var string
   */
  public $title;

  /**
   * @var longtext
   */
  public $description;

  /**
   * @var int
   */
  public $role_id;

  /**
   * @var int
   */
  public $location_id;

  /**
   * Is the Job active or withdrawn?
   *
   * @var bool
   */
  public $is_active;

  /**
   * @var int
   */
  public $status_id;

  /**
   * Date and time the job was created
   *
   * @var timestamp
   */
  public $created_date;

  /**
   * FK to civicrm_contact, who created this application
   *
   * @var int
   */
  public $created_id;

  /**
   * Date and time the job was modified
   *
   * @var timestamp
   */
  public $modified_date;

  /**
   * FK to civicrm_contact, who modified this application
   *
   * @var int
   */
  public $modified_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_o8_job';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Ssc Jobs') : E::ts('Ssc Job');
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contact_id', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'created_id', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'modified_id', 'civicrm_contact', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('Unique SSC Job ID'),
          'required' => TRUE,
          'where' => 'civicrm_o8_job.id',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => NULL,
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Contact'),
          'where' => 'civicrm_o8_job.contact_id',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'title' => [
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Title'),
          'required' => FALSE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_o8_job.title',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'add' => NULL,
        ],
        'description' => [
          'name' => 'description',
          'type' => CRM_Utils_Type::T_LONGTEXT,
          'title' => E::ts('Description'),
          'required' => FALSE,
          'where' => 'civicrm_o8_job.description',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'html' => [
            'type' => 'RichTextEditor',
          ],
          'add' => NULL,
        ],
        'role_id' => [
          'name' => 'role_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Role'),
          'where' => 'civicrm_o8_job.role_id',
          'default' => '1',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'o8_job_role',
            'optionEditPath' => 'civicrm/admin/options/o8_job_role',
          ],
          'add' => NULL,
        ],
        'location_id' => [
          'name' => 'location_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Location'),
          'where' => 'civicrm_o8_job.location_id',
          'default' => '1',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'o8_job_location',
            'optionEditPath' => 'civicrm/admin/options/o8_job_location',
          ],
          'add' => NULL,
        ],
        'is_active' => [
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => E::ts('Is Job Open?'),
          'description' => E::ts('Is the Job Open or Closed?'),
          'required' => TRUE,
          'where' => 'civicrm_o8_job.is_active',
          'default' => '1',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'add' => NULL,
        ],
        'status_id' => [
          'name' => 'status_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Status'),
          'where' => 'civicrm_o8_job.status_id',
          'default' => '1',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'html' => [
            'type' => 'Select',
          ],
          'pseudoconstant' => [
            'optionGroupName' => 'o8_job_status',
            'optionEditPath' => 'civicrm/admin/options/o8_job_status',
          ],
          'add' => NULL,
        ],
        'created_date' => [
          'name' => 'created_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => E::ts('Job Proposal Created Date'),
          'description' => E::ts('Date and time the job was created'),
          'required' => FALSE,
          'where' => 'civicrm_o8_job.created_date',
          'default' => 'CURRENT_TIMESTAMP',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDateTime',
          ],
          'add' => NULL,
        ],
        'created_id' => [
          'name' => 'created_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Created By Contact ID'),
          'description' => E::ts('FK to civicrm_contact, who created this application'),
          'where' => 'civicrm_o8_job.created_id',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'label' => E::ts("Created By"),
          ],
          'add' => '4.4',
        ],
        'modified_date' => [
          'name' => 'modified_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => E::ts('Job Proposal Created Date'),
          'description' => E::ts('Date and time the job was modified'),
          'required' => FALSE,
          'where' => 'civicrm_o8_job.modified_date',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'html' => [
            'type' => 'Select Date',
            'formatType' => 'activityDateTime',
          ],
          'add' => NULL,
        ],
        'modified_id' => [
          'name' => 'modified_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Modified By Contact ID'),
          'description' => E::ts('FK to civicrm_contact, who modified this application'),
          'where' => 'civicrm_o8_job.modified_id',
          'table_name' => 'civicrm_o8_job',
          'entity' => 'SscJob',
          'bao' => 'CRM_Jobs_DAO_SscJob',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'label' => E::ts("Created By"),
          ],
          'add' => NULL,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'o8_job', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'o8_job', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
