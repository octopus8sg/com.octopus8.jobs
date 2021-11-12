<?php

class CRM_Jobs_PseudoConstant extends CRM_Core_PseudoConstant {

    public static function jobRole() {
        $constants = CRM_Core_OptionGroup::values('ssc_job_role');
        return $constants;
    }

    public static function jobLocation() {
        $constants = CRM_Core_OptionGroup::values('ssc_job_location');
        return $constants;
    }

    public static function jobStatus() {
        $constants = CRM_Core_OptionGroup::values('ssc_job_status');
        return $constants;
    }

    public static function appStatus() {
        $constants = CRM_Core_OptionGroup::values('ssc_application_status');
        return $constants;
    }

}