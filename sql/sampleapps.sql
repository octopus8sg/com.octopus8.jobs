insert into civicrm_job_application (job_id, job_application_status_id, contact_id, created_date)
SELECT civicrm_job.id, 1, c.id, "2021-10-01"
FROM civicrm_job
         join (select civicrm_contact.id
               from civicrm_contact
               where civicrm_contact.contact_type = "Individual"
                 and civicrm_contact.id < 25
               ORDER BY RAND ( )
               limit 3) as c;

insert into civicrm_job_application (job_id, job_application_status_id, contact_id, created_date)
SELECT civicrm_job.id, 2, c.id, "2021-10-02"
FROM civicrm_job
         join (select civicrm_contact.id
               from civicrm_contact
               where civicrm_contact.contact_type = "Individual"
                 and civicrm_contact.id > 25
               ORDER BY RAND ( )
               limit 3) as c;

insert into civicrm_job_application (job_id, job_application_status_id, contact_id, created_date)
SELECT civicrm_job.id, 3, c.id, "2021-10-03"
FROM civicrm_job
         join (select civicrm_contact.id
               from civicrm_contact
               where civicrm_contact.contact_type = "Individual"
                 and civicrm_contact.id > 50
               ORDER BY RAND ( )
               limit 3) as c;

