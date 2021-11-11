<?php
use CRM_Jobs_ExtensionUtil as E;

class CRM_Jobs_Page_EmployerTab extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
      CRM_Utils_System::setTitle(E::ts('Employer Job Tab'));
      // Example: Assign a variable for use in a template
      $urlQry['snippet'] = 4;
      $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
      $this->assign('contactId', $contactId);
      $urlQry['cid'] = $contactId;
      $urlQry['employerid'] = $contactId;
      $job_source_url = CRM_Utils_System::url('civicrm/jobs/jobsajax', $urlQry, FALSE, NULL, FALSE);
      $sourceUrl['employer_job_sourceUrl'] = $job_source_url;
      $this->assign('alert_sourcel', $job_source_url);
      $this->assign('useAjax', true);
      $this->assign('sourceUrl', $job_source_url);
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
