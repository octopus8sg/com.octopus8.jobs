insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 1, 1, 1, '2021-10-01' from civicrm_contact where contact_type = "Organization";
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 2, 2, 2, '2021-10-02' from civicrm_contact where contact_type = "Organization";
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 3, 3, 3, '2021-10-03' from civicrm_contact where contact_type = "Organization";
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 1, 2, 3, '2021-10-04' from civicrm_contact where contact_type = "Organization";
