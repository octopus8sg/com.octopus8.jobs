<?php

use CRM_Jobs_ExtensionUtil as E;

class CRM_Jobs_Page_JobsDashboard extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Job and Applications Dashboard'));

        // Alarm Rules
        $jobSql = "SELECT COUNT(d.id)
                           from civicrm_ssc_job d";
        $jobCount = CRM_Core_DAO::singleValueQuery($jobSql);
        $this->assign('jobCount', $jobCount);

        // Alert Rules
        $appSql = "SELECT COUNT(d.id)
                           from civicrm_ssc_application d";
        $appCount = CRM_Core_DAO::singleValueQuery($appSql);
        $this->assign('appCount', $appCount);
//        CRM_Core_Error::debug_var('dashboard_sql', $sql);


        $role_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_option_value s
        INNER JOIN civicrm_option_group gs
                   ON s.option_group_id = gs.id
                       AND gs.name = 'ssc_job_role' 
    where s.is_active = TRUE";
        $role_count = CRM_Core_DAO::singleValueQuery($role_sql);
        $this->assign('roleCount', $role_count);
//        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);

        $location_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_option_value s
        INNER JOIN civicrm_option_group gs
                   ON s.option_group_id = gs.id
                       AND gs.name = 'ssc_job_location' 
    where s.is_active = TRUE";
        $location_count = CRM_Core_DAO::singleValueQuery($location_sql);
        $this->assign('locationCount', $location_count);
//        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);

//        $job_status_sql = "SELECT COUNT(DISTINCT s.id) from
//    civicrm_option_value s
//        INNER JOIN civicrm_option_group gs
//                   ON s.option_group_id = gs.id
//                       AND gs.name = 'job_status'
//    where s.is_active = TRUE";
//        $job_status_count = CRM_Core_DAO::singleValueQuery($job_status_sql);
//        $this->assign('jobstatusCount', $job_status_count);
////        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);
//
//        $app_status_sql = "SELECT COUNT(DISTINCT s.id) from
//    civicrm_option_value s
//        INNER JOIN civicrm_option_group gs
//                   ON s.option_group_id = gs.id
//                       AND gs.name = 'job_application_status'
//    where s.is_active = TRUE";
//        $app_status_count = CRM_Core_DAO::singleValueQuery($app_status_sql);
//        $this->assign('appstatusCount', $app_status_count);
////        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);


        $emper_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_job s";
        $empers_Count = CRM_Core_DAO::singleValueQuery($emper_sql);
        $this->assign('empersCount', $empers_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $empee_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_application s";
        $empees_Count = CRM_Core_DAO::singleValueQuery($empee_sql);
        $this->assign('empeesCount', $empees_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $last_year_emper_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_job s
    WHERE YEAR(s.created_date) = (YEAR(CURDATE()) - 1)";
        $last_year_empers_Count = CRM_Core_DAO::singleValueQuery($last_year_emper_sql);
        $this->assign('last_year_empers_Count', $last_year_empers_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $this_year_emper_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_job s
    WHERE YEAR(s.created_date) = YEAR(CURDATE())";
        $this_year_emper_Count = CRM_Core_DAO::singleValueQuery($this_year_emper_sql);
        $this->assign('this_year_empers_Count', $this_year_emper_Count);
//        CRM_Core_Error::debug_var('this_year_datas_Count', $this_year_datas_Count);

        $last_month_emper_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_job s
    WHERE MONTH(s.created_date) = (MONTH(CURDATE()) - 1)";
        $last_month_empers_Count = CRM_Core_DAO::singleValueQuery($last_month_emper_sql);
        $this->assign('last_month_empers_Count', $last_month_empers_Count);
//        CRM_Core_Error::debug_var('last_month_datas_Count', $last_month_datas_Count);

        $this_month_emper_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_job s
    WHERE MONTH(s.created_date) = MONTH(CURDATE())";
        $this_month_emper_Count = CRM_Core_DAO::singleValueQuery($this_month_emper_sql);
        $this->assign('this_month_empers_Count', $this_month_emper_Count);
//        CRM_Core_Error::debug_var('this_month_datas_Count', $this_month_datas_Count);


        $last_week_emper_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_job s
    WHERE WEEK(s.created_date) = (WEEK(CURDATE()) - 1)";
        $last_week_empers_Count = CRM_Core_DAO::singleValueQuery($last_week_emper_sql);
        $this->assign('last_week_empers_Count', $last_week_empers_Count);
//        CRM_Core_Error::debug_var('last_week_datas_Count', $last_week_datas_Count);

        $this_week_emper_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_job s
    WHERE WEEK(s.created_date) = WEEK(CURDATE())";
        $this_week_emper_Count = CRM_Core_DAO::singleValueQuery($this_week_emper_sql);
        $this->assign('this_week_empers_Count', $this_week_emper_Count);
//        CRM_Core_Error::debug_var('this_week_datas_Count', $this_week_datas_Count);


        $last_year_app_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_application s
    WHERE YEAR(s.created_date) = (YEAR(CURDATE()) - 1)";
        $last_year_apps_Count = CRM_Core_DAO::singleValueQuery($last_year_app_sql);
        $this->assign('last_year_apps_Count', $last_year_apps_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $this_year_app_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_application s
    WHERE YEAR(s.created_date) = YEAR(CURDATE())";
        $this_year_app_Count = CRM_Core_DAO::singleValueQuery($this_year_app_sql);
        $this->assign('this_year_apps_Count', $this_year_app_Count);
//        CRM_Core_Error::debug_var('this_year_datas_Count', $this_year_datas_Count);

        $last_month_app_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_application s
    WHERE MONTH(s.created_date) = (MONTH(CURDATE()) - 1)";
        $last_month_apps_Count = CRM_Core_DAO::singleValueQuery($last_month_app_sql);
        $this->assign('last_month_apps_Count', $last_month_apps_Count);
//        CRM_Core_Error::debug_var('last_month_datas_Count', $last_month_datas_Count);

        $this_month_app_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_application s
    WHERE MONTH(s.created_date) = MONTH(CURDATE())";
        $this_month_app_Count = CRM_Core_DAO::singleValueQuery($this_month_app_sql);
        $this->assign('this_month_apps_Count', $this_month_app_Count);
//        CRM_Core_Error::debug_var('this_month_datas_Count', $this_month_datas_Count);

        $last_week_app_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_application s
    WHERE WEEK(s.created_date) = (WEEK(CURDATE()) - 1)";
        $last_week_apps_Count = CRM_Core_DAO::singleValueQuery($last_week_app_sql);
        $this->assign('last_week_apps_Count', $last_week_apps_Count);
//        CRM_Core_Error::debug_var('last_week_datas_Count', $last_week_datas_Count);

        $this_week_app_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_application s
    WHERE WEEK(s.created_date) = WEEK(CURDATE())";
        $this_week_app_Count = CRM_Core_DAO::singleValueQuery($this_week_app_sql);
        $this->assign('this_week_apps_Count', $this_week_app_Count);
//        CRM_Core_Error::debug_var('this_week_datas_Count', $this_week_datas_Count);

        $last_year_job_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_job s
    WHERE YEAR(s.created_date) = (YEAR(CURDATE()) - 1)";
        $last_year_jobs_Count = CRM_Core_DAO::singleValueQuery($last_year_job_sql);
        $this->assign('last_year_jobs_Count', $last_year_jobs_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $this_year_job_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_job s
    WHERE YEAR(s.created_date) = YEAR(CURDATE())";
        $this_year_job_Count = CRM_Core_DAO::singleValueQuery($this_year_job_sql);
        $this->assign('this_year_jobs_Count', $this_year_job_Count);
//        CRM_Core_Error::debug_var('this_year_datas_Count', $this_year_datas_Count);

        $last_month_job_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_job s
    WHERE MONTH(s.created_date) = (MONTH(CURDATE()) - 1)";
        $last_month_jobs_Count = CRM_Core_DAO::singleValueQuery($last_month_job_sql);
        $this->assign('last_month_jobs_Count', $last_month_jobs_Count);
//        CRM_Core_Error::debug_var('last_month_datas_Count', $last_month_datas_Count);

        $this_month_job_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_job s
    WHERE MONTH(s.created_date) = MONTH(CURDATE())";
        $this_month_job_Count = CRM_Core_DAO::singleValueQuery($this_month_job_sql);
        $this->assign('this_month_jobs_Count', $this_month_job_Count);
//        CRM_Core_Error::debug_var('this_month_datas_Count', $this_month_datas_Count);

        $last_week_job_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_job s
    WHERE WEEK(s.created_date) = (WEEK(CURDATE()) - 1)";
        $last_week_jobs_Count = CRM_Core_DAO::singleValueQuery($last_week_job_sql);
        $this->assign('last_week_jobs_Count', $last_week_jobs_Count);
//        CRM_Core_Error::debug_var('last_week_datas_Count', $last_week_datas_Count);

        $this_week_job_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_ssc_job s
    WHERE WEEK(s.created_date) = WEEK(CURDATE())";
        $this_week_job_Count = CRM_Core_DAO::singleValueQuery($this_week_job_sql);
        $this->assign('this_week_jobs_Count', $this_week_job_Count);
//        CRM_Core_Error::debug_var('this_week_datas_Count', $this_week_datas_Count);


        $last_year_empee_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_application s
    WHERE YEAR(s.created_date) = (YEAR(CURDATE()) - 1)";
        $last_year_empees_Count = CRM_Core_DAO::singleValueQuery($last_year_empee_sql);
        $this->assign('last_year_empees_Count', $last_year_empees_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $this_year_empee_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_application s
    WHERE YEAR(s.created_date) = YEAR(CURDATE())";
        $this_year_empees_Count = CRM_Core_DAO::singleValueQuery($this_year_empee_sql);
        $this->assign('this_year_empees_Count', $this_year_empees_Count);
//        CRM_Core_Error::debug_var('this_year_datas_Count', $this_year_datas_Count);

        $last_month_empee_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_application s
    WHERE MONTH(s.created_date) = (MONTH(CURDATE()) - 1)";
        $last_month_empees_Count = CRM_Core_DAO::singleValueQuery($last_month_empee_sql);
        $this->assign('last_month_empees_Count', $last_month_empees_Count);
//        CRM_Core_Error::debug_var('last_month_datas_Count', $last_month_datas_Count);

        $this_month_empee_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_application s
    WHERE MONTH(s.created_date) = MONTH(CURDATE())";
        $this_month_empees_Count = CRM_Core_DAO::singleValueQuery($this_month_empee_sql);
        $this->assign('this_month_empees_Count', $this_month_empees_Count);
//        CRM_Core_Error::debug_var('this_month_datas_Count', $this_month_datas_Count);

        $last_week_empee_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_application s
    WHERE WEEK(s.created_date) = (WEEK(CURDATE()) - 1)";
        $last_week_empees_Count = CRM_Core_DAO::singleValueQuery($last_week_empee_sql);
        $this->assign('last_week_empees_Count', $last_week_empees_Count);
//        CRM_Core_Error::debug_var('last_week_datas_Count', $last_week_datas_Count);

        $this_week_empee_sql = "SELECT COUNT(DISTINCT s.contact_id) from
    civicrm_ssc_application s
    WHERE WEEK(s.created_date) = WEEK(CURDATE())";
        $this_week_empees_Count = CRM_Core_DAO::singleValueQuery($this_week_empee_sql);
        $this->assign('this_week_empees_Count', $this_week_empees_Count);
//        CRM_Core_Error::debug_var('this_week_datas_Count', $this_week_datas_Count);


        parent::run();
    }

}
