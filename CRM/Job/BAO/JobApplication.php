<?php
use CRM_Job_ExtensionUtil as E;

class CRM_Job_BAO_JobApplication extends CRM_Job_DAO_JobApplication {

  /**
   * Create a new JobApplication based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Job_DAO_JobApplication|NULL
   *
  public static function create($params) {
    $className = 'CRM_Job_DAO_JobApplication';
    $entityName = 'JobApplication';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
