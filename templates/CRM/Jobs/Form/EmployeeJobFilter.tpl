{crmScope extensionKey='com.octopus8.jobs'}
<div class="crm-content-block">

    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
      <div class="crm-accordion-wrapper crm-expenses_search-accordion">
        <div class="crm-accordion-header crm-master-accordion-header">{ts}Filter Jobs{/ts}</div><!-- /.crm-accordion-header -->
        <div class="crm-accordion-body">
          <table class="form-layout employee-job-filter">
            <tbody>
            <tr>
              <td class="label">{$form.employee_job_contact_id.label}</td>
              <td>{$form.employee_job_contact_id.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.employee_job_location_id.label}</td>
              <td>{$form.employee_job_location_id.html}</td>
              <td class="label">{$form.employee_job_role_id.label}</td>
              <td>{$form.employee_job_role_id.html}</td>
            </tr>
            <tr>
              <td class="label">{$form.employee_job_dateselect_from.label}</td>
              <td>{$form.employee_job_dateselect_from.html}</td>
              <td class="label">{$form.employee_job_dateselect_to.label}</td>
              <td>{$form.employee_job_dateselect_to.html}</td>
            </tr>
            </tbody>
          </table>
          <div class="crm-submit-buttons">
            {include file="CRM/common/formButtons.tpl"}
          </div>
        </div><!- /.crm-accordion-body -->
      </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->
 </div>
{/crmScope}