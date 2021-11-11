<?php
use CRM_Jobs_ExtensionUtil as E;

class CRM_Jobs_Page_EmployeeTab extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
      // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
      CRM_Utils_System::setTitle(E::ts('Employee Jobs Tab'));

      // Example: Assign a variable for use in a template
      $urlQry['snippet'] = 4;
      $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
      $urlQry['cid'] = $contactId;
      $urlQry['employeeid'] = $contactId;
      $this->assign('contactId', $contactId);
      $employee_job_source_url
          = CRM_Utils_System::url('civicrm/jobs/jobsajax', $urlQry, FALSE, NULL, FALSE);
      $employee_application_source_url
          = CRM_Utils_System::url('civicrm/jobs/applicationsajax', $urlQry, FALSE, NULL, FALSE);
      $sourceUrl['employee_job_sourceUrl'] = $employee_job_source_url;
      $sourceUrl['employee_application_sourceUrl'] = $employee_application_source_url;
      $this->assign('employee_job_sourceurl', $employee_job_source_url);
      $this->assign('useAjax', true);
//        $this->assign('sourceUrl', $employee_job_source_url);
      CRM_Core_Resources::singleton()->addVars('source_url', $sourceUrl);
      $controller_data = new CRM_Core_Controller_Simple(
          'CRM_Jobs_Form_JobsCommonFilter',
          ts('Job Filter'),
          NULL,
          FALSE, FALSE, TRUE
      );
      $controller_data->setEmbedded(TRUE);
      $controller_data->run();
      parent::run();
  }

}
