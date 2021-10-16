<?php

use CRM_Job_ExtensionUtil as E;

class CRM_Job_BAO_Job extends CRM_Job_DAO_Job
{

    /**
     * Create a new Job based on array-data
     *
     * @param array $params key-value pairs
     * @return CRM_Job_DAO_Job|NULL
     */
    public static function create($params)
    {
        $className = 'CRM_Job_DAO_Job';
        $entityName = 'Job';
        $hook = empty($params['id']) ? 'create' : 'edit';

        CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
        $instance = new $className();
        $instance->copyValues($params);
        $instance->save();
        if (!empty($params['custom']) &&
            is_array($params['custom'])
        ) {
            CRM_Core_BAO_CustomValueTable::store($params['custom'], self::$_tableName, $instance->id);
        }
        CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

        return $instance;
    }
    /*
    */

}
