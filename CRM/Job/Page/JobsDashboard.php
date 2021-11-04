<?php

use CRM_Job_ExtensionUtil as E;

class CRM_Job_Page_JobsDashboard extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Job and Applications Dashboard'));

        // Alarm Rules
        $jobSql = "SELECT COUNT(d.id)
                           from civicrm_job d";
        $jobCount = CRM_Core_DAO::singleValueQuery($jobSql);
        $this->assign('jobCount', $jobCount);

        // Alert Rules
        $appSql = "SELECT COUNT(d.id)
                           from civicrm_job_application d";
        $appCount = CRM_Core_DAO::singleValueQuery($appSql);
        $this->assign('appCount', $appCount);
//        CRM_Core_Error::debug_var('dashboard_sql', $sql);


        $role_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_option_value s
        INNER JOIN civicrm_option_group gs
                   ON s.option_group_id = gs.id
                       AND gs.name = 'job_role' 
    where s.is_active = TRUE";
        $role_count = CRM_Core_DAO::singleValueQuery($role_sql);
        $this->assign('roleCount', $role_count);
//        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);

        $location_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_option_value s
        INNER JOIN civicrm_option_group gs
                   ON s.option_group_id = gs.id
                       AND gs.name = 'job_location' 
    where s.is_active = TRUE";
        $location_count = CRM_Core_DAO::singleValueQuery($location_sql);
        $this->assign('locationCount', $location_count);
//        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);

        $job_status_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_option_value s
        INNER JOIN civicrm_option_group gs
                   ON s.option_group_id = gs.id
                       AND gs.name = 'job_status' 
    where s.is_active = TRUE";
        $job_status_count = CRM_Core_DAO::singleValueQuery($job_status_sql);
        $this->assign('jobstatusCount', $job_status_count);
//        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);

        $app_status_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_option_value s
        INNER JOIN civicrm_option_group gs
                   ON s.option_group_id = gs.id
                       AND gs.name = 'job_application_status' 
    where s.is_active = TRUE";
        $app_status_count = CRM_Core_DAO::singleValueQuery($app_status_sql);
        $this->assign('appstatusCount', $app_status_count);
//        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);

        $last_year_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE YEAR(s.date) = (YEAR(CURDATE()) - 1)";
        $last_year_datas_Count = CRM_Core_DAO::singleValueQuery($last_year_datas_sql);
        $this->assign('last_year_datas_Count', $last_year_datas_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $this_year_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE YEAR(s.date) = YEAR(CURDATE())";
        $this_year_datas_Count = CRM_Core_DAO::singleValueQuery($this_year_datas_sql);
        $this->assign('this_year_datas_Count', $this_year_datas_Count);
//        CRM_Core_Error::debug_var('this_year_datas_Count', $this_year_datas_Count);

        $last_year_alarms_sql = "SELECT COUNT(DISTINCT a.id) FROM
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
        WHERE YEAR(s.date) = (YEAR(CURDATE()) - 1)";
        $last_year_alarms_Count = CRM_Core_DAO::singleValueQuery($last_year_alarms_sql);
        $this->assign('last_year_alarms_Count', $last_year_alarms_Count);
//        CRM_Core_Error::debug_var('last_year_alarms_Count', $last_year_alarms_Count);

        $this_year_alarms_sql = "SELECT COUNT(DISTINCT a.id) from
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
    WHERE YEAR(s.date) = YEAR(CURDATE())";
        $this_year_alarms_Count = CRM_Core_DAO::singleValueQuery($this_year_alarms_sql);
        $this->assign('this_year_alarms_Count', $this_year_alarms_Count);
//        CRM_Core_Error::debug_var('this_year_alarms_Count', $this_year_alarms_Count);

        $last_year_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE YEAR(s.date) = (YEAR(CURDATE()) - 1)
    ";
        $last_year_alerts_Count = CRM_Core_DAO::singleValueQuery($last_year_alerts_sql);
        $this->assign('last_year_alerts_Count', $last_year_alerts_Count);
//        CRM_Core_Error::debug_var('last_year_alerts_Count', $last_year_alerts_Count);

        $this_year_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE YEAR(s.date) = YEAR(CURDATE())
";
        $this_year_alerts_Count = CRM_Core_DAO::singleValueQuery($this_year_alerts_sql);
        $this->assign('this_year_alerts_Count', $this_year_alerts_Count);
//        CRM_Core_Error::debug_var('this_year_alerts_Count', $this_year_alerts_Count);

        $last_month_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE MONTH(s.date) = MONTH(CURDATE() - INTERVAL 1 MONTH)";
        $last_month_datas_Count = CRM_Core_DAO::singleValueQuery($last_month_datas_sql);
        $this->assign('last_month_datas_Count', $last_month_datas_Count);
//        CRM_Core_Error::debug_var('last_month_datas_Count', $last_month_datas_Count);

        $this_month_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE MONTH(s.date) = MONTH(CURDATE())";
        $this_month_datas_Count = CRM_Core_DAO::singleValueQuery($this_month_datas_sql);
        $this->assign('this_month_datas_Count', $this_month_datas_Count);
//        CRM_Core_Error::debug_var('this_month_datas_Count', $this_month_datas_Count);

        $last_month_alarms_sql = "SELECT COUNT(DISTINCT a.id) FROM
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
        WHERE MONTH(s.date) = MONTH(CURDATE() - INTERVAL 1 MONTH)";
        $last_month_alarms_Count = CRM_Core_DAO::singleValueQuery($last_month_alarms_sql);
        $this->assign('last_month_alarms_Count', $last_month_alarms_Count);
//        CRM_Core_Error::debug_var('last_month_alarms_Count', $last_month_alarms_Count);

        $this_month_alarms_sql = "SELECT COUNT(DISTINCT a.id) from
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
    WHERE MONTH(s.date) = MONTH(CURDATE())";
        $this_month_alarms_Count = CRM_Core_DAO::singleValueQuery($this_month_alarms_sql);
        $this->assign('this_month_alarms_Count', $this_month_alarms_Count);
//        CRM_Core_Error::debug_var('this_month_alarms_Count', $this_month_alarms_Count);

        $last_month_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE MONTH(s.date) = MONTH(CURDATE() - INTERVAL 1 MONTH)
    ";
        $last_month_alerts_Count = CRM_Core_DAO::singleValueQuery($last_month_alerts_sql);
        $this->assign('last_month_alerts_Count', $last_month_alerts_Count);
//        CRM_Core_Error::debug_var('last_month_alerts_Count', $last_month_alerts_Count);

        $this_month_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE MONTH(s.date) = MONTH(CURDATE())
";
        $this_month_alerts_Count = CRM_Core_DAO::singleValueQuery($this_month_alerts_sql);
        $this->assign('this_month_alerts_Count', $this_month_alerts_Count);
//        CRM_Core_Error::debug_var('this_month_alerts_Count', $this_month_alerts_Count);

        parent::run();
    }

}
