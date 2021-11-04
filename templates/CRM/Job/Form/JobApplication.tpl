{crmScope extensionKey='com.socialservicesconnect.jobs'}
{if $action eq 8}
  {* Are you sure to delete form *}
  <h3>{ts}Delete Job Application?{/ts}</h3>
  <div class="crm-block crm-form-block">
    <div class="crm-section">{ts 1=$myentity.id}Are you sure you wish to delete the job with ID # <b>%1</b>?{/ts}</div>
  </div>

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
{else}

  <div class="crm-block crm-form-block">

    <div class="crm-section">
      <div class="label">{$form.contact_id.label}</div>
      <div class="content">{$form.contact_id.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.job_id.label}</div>
      <div class="content">{$form.job_id.html}</div>
      <div class="clear"></div>
    </div>

    <div class="crm-section">
      <div class="label">{$form.job_application_status_id.label}</div>
      <div class="content">{$form.job_application_status_id.html}</div>
      <div class="clear"></div>
    </div>
    {* Add the line below: *}

{*    {include file="CRM/common/customDataBlock.tpl" customDataType='Job' entityID=$id}*}

    <div class="crm-submit-buttons">
      {include file="CRM/common/formButtons.tpl" location="bottom"}
    </div>

  </div>
{/if}
  {* At the bottom of the file add the following lines: *}
{literal}
  <!--script type="text/javascript">
    CRM.$(function($) {
      function updateCustomData() {
        var subRole = '{/literal}{$role_id}{literal}';
        if ($('#role_id').length) {
          subRole = $('#role_id').val();
        }
        CRM.buildCustomData('Job', subRole, false, false, false, false, false, {/literal}{$cid}{literal});
      }
      if ($('#role_id').length) {
        $('#role_id').on('change', updateCustomData);
      }
      updateCustomData();
    });
  </script-->
{/literal}
{/crmScope}