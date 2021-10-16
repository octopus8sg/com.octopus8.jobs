<?php

use CRM_Job_ExtensionUtil as E;

class CRM_Job_Page_ContactTab extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Job'));
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
        $myEntities = \Civi\Api4\Job::get()
//            ->selectRowCount()
//            some strange error prevents array retrieval
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
//        CRM_Core_Error::debug_var('myEntities', $myEntities);
        $rows = array();
        foreach ($myEntities as $myEntity) {
            $row = $myEntity;
            if (!empty($row['contact_id'])) {
                $row['contact'] = '<a href="' . CRM_Utils_System::url('civicrm/contact/view', ['reset' => 1, 'cid' => $row['contact_id']]) . '">' . CRM_Contact_BAO_Contact::displayName($row['contact_id']) . '</a>';
            }
            $rows[] = $row;
        }
        $this->assign('contactId', $contactId);
        $this->assign('rows', $rows);

        // Set the user context
        $session = CRM_Core_Session::singleton();
        $userContext = CRM_Utils_System::url('civicrm/contact/view', 'cid=' . $contactId . '&selectedChild=contact_job&reset=1');
        $session->pushUserContext($userContext);

        parent::run();
    }

}
