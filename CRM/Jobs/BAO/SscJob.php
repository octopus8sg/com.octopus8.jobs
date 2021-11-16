<?php

use CRM_Jobs_ExtensionUtil as E;

class CRM_Jobs_BAO_SscJob extends CRM_Jobs_DAO_SscJob
{

    /**
     * Create a new SscJob based on array-data
     *
     * @param array $params key-value pairs
     * @return CRM_Jobs_DAO_SscJob|NULL
     *
     * public static function create($params) {
     * $className = 'CRM_Jobs_DAO_SscJob';
     * $entityName = 'SscJob';
     * $hook = empty($params['id']) ? 'create' : 'edit';
     *
     * CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
     * $instance = new $className();
     * $instance->copyValues($params);
     * $instance->save();
     * CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);
     *
     * return $instance;
     * } */
    public static function create($params)
    {
        CRM_Core_Error::debug_var('paramsto', $params);
        $className = 'CRM_Jobs_DAO_SscJob';
        $entityName = 'SscJob';
        $hook = empty($params['id']) ? 'create' : 'edit';

        CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
        $instance = new $className();
        $instance->copyValues($params);
        $instance->save();
        $custom = $params['custom'];
        if (!$custom) {
            //if custom is down somewhere
            $custom = $params['bustom'];
        }

        if (!empty($custom) &&
            is_array($custom)
        ) {
            CRM_Core_Error::debug_var('custom', $custom);

            CRM_Core_BAO_CustomValueTable::store($custom, self::$_tableName, $instance->id);
        }
        CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

        return $instance;
    }
}
