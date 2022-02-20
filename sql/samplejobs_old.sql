SET @MIN = NOW() - INTERVAL 1 month;
SET @MAX = NOW();

SET @WOW =  TIMESTAMPADD(SECOND, FLOOR(RAND() * TIMESTAMPDIFF(SECOND, @MIN, @MAX)), @MIN);

insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,due_date,created_id)
select civicrm_contact.id,  concat(civicrm_contact.display_name, " SAMPLE JOB"), 1, 1, 1, @WOW,(@WOW + INTERVAL 1 MONTH), civicrm_contact.id from civicrm_contact where contact_type = "Organization";
SET @WOW =  TIMESTAMPADD(SECOND, FLOOR(RAND() * TIMESTAMPDIFF(SECOND, @MIN, @MAX)), @MIN);
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,due_date,created_id)
select civicrm_contact.id,  concat(civicrm_contact.display_name, " SAMPLE JOB"), 2, 2, 2, @WOW,(@WOW + INTERVAL 1 MONTH), civicrm_contact.id from civicrm_contact where contact_type = "Organization";
SET @WOW =  TIMESTAMPADD(SECOND, FLOOR(RAND() * TIMESTAMPDIFF(SECOND, @MIN, @MAX)), @MIN);
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,due_date,created_id)
select civicrm_contact.id,  concat(civicrm_contact.display_name, " SAMPLE JOB"), 3, 3, 3, @WOW,(@WOW + INTERVAL 1 MONTH), civicrm_contact.id from civicrm_contact where contact_type = "Organization";
SET @WOW =  TIMESTAMPADD(SECOND, FLOOR(RAND() * TIMESTAMPDIFF(SECOND, @MIN, @MAX)), @MIN);
insert into civicrm_o8_job (contact_id, title, role_id, location_id, status_id, created_date,due_date,created_id)
select civicrm_contact.id,  concat(civicrm_contact.display_name, " SAMPLE JOB"), 1, 2, 3, @WOW,(@WOW + INTERVAL 1 MONTH), civicrm_contact.id from civicrm_contact where contact_type = "Organization";

