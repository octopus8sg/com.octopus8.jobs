<?php
use CRM_Jobs_ExtensionUtil as E;

/**
 * SscJob.create API specification (optional).
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_ssc_job_create_spec(&$spec) {
  // $spec['some_parameter']['api.required'] = 1;
}

/**
 * SscJob.create API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_ssc_job_create($params) {
//    if (!isset($params['contact_id']) and isset($params['device_id'])) {
//        $devices = civicrm_api4('Device', 'get', [
//            'select' => [
//                'contact_id',
//            ],
//            'where' => [
//                ['id', '=', $params['device_id']],
//            ],
//            'limit' => 2,
//        ]);
//        if (!empty($devices)) {
//            $contact_id = $devices[0]['contact_id'];
//            $params['contact_id'] = $contact_id;
//        }
//    }
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'SscJob');
}

/**
 * SscJob.delete API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_ssc_job_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * SscJob.get API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_ssc_job_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'SscJob');
}
