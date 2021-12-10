insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,created_id)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 1, 1, 1, NOW(),civicrm_contact.id from civicrm_contact where contact_type = "Organization";
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,created_id)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 2, 2, 2, NOW(),civicrm_contact.id from civicrm_contact where contact_type = "Organization";
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,created_id)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 3, 3, 3, NOW(),civicrm_contact.id from civicrm_contact where contact_type = "Organization";
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,created_id)
select civicrm_contact.id, concat(civicrm_contact.display_name, " JOB"), 1, 2, 3, NOW(),civicrm_contact.id from civicrm_contact where contact_type = "Organization";
