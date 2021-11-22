{crmScope extensionKey='com.octopus8.jobs'}
<div class="crm-content-block">

    <div class="crm-block crm-form-block crm-basic-criteria-form-block">
        <div class="crm-accordion-wrapper crm-expenses_search-accordion">
            <div class="crm-accordion-header crm-master-accordion-header">{ts}Filter Applications{/ts}</div>
            <!-- /.crm-accordion-header -->
            <div class="crm-accordion-body">
                <table class="form-layout application-filter">
                    <tbody>
                    <tr>
                        <td class="label">{$form.application_id.label}</td>
                        <td>{$form.application_id.html}</td>
                        <td class="label">{$form.application_job_id.label}</td>
                        <td>{$form.application_job_id.html}</td>
                    </tr>
                    <tr>
                        <td class="label">{$form.application_contact_id.label}</td>
                        <td>{$form.application_contact_id.html}</td>
                        <td class="label">{$form.application_job_contact_id.label}</td>
                        <td>{$form.application_job_contact_id.html}</td>
                    </tr>
                    <tr>
                        <td class="label">{$form.application_role_id.label}</td>
                        <td>{$form.application_role_id.html}</td>
                        <td class="label">{$form.application_location_id.label}</td>
                        <td>{$form.application_location_id.html}</td>
                    </tr>
                    <tr>
                        <td class="label">{$form.application_job_is_active.label}</td>
                        <td>{$form.application_job_is_active.html}</td>
                        <td class="label">{$form.application_is_active.label}</td>
                        <td>{$form.application_is_active.html}</td>
                    </tr>
                    <tr>
                        <td class="label">{$form.application_status_id.label}</td>
                        <td>{$form.application_status_id.html}</td>
                    </tr>
                    <tr>
                        <td class="label">{$form.application_dateselect_from.label}</td>
                        <td>{$form.application_dateselect_from.html}</td>
                        <td class="label">{$form.application_dateselect_to.label}</td>
                        <td>{$form.application_dateselect_to.html}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="crm-submit-buttons">
                    {include file="CRM/common/formButtons.tpl"}
                </div>
            </div>
            <!- /.crm-accordion-body -->
        </div><!-- /.crm-accordion-wrapper -->
    </div><!-- /.crm-form-block -->
</div>
{/crmScope}