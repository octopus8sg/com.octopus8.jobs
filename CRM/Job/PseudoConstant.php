<?php

class CRM_HealthMonitor_PseudoConstant extends CRM_Core_PseudoConstant {

    public static function jobRole() {
        $constants = CRM_Core_OptionGroup::values('job_role');
        return $constants;
    }

    public static function jobLocation() {
        $constants = CRM_Core_OptionGroup::values('job_location');
        return $constants;
    }

    public static function jobStatus() {
        $constants = CRM_Core_OptionGroup::values('job_status');
        return $constants;
    }
    
}