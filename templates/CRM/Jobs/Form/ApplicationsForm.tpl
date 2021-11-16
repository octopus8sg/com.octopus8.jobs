{crmScope extensionKey='com.socialservicesconnect.jobs'}
{if $action eq 8}
    {* Are you sure to delete form *}
    <h3>{ts}Delete Job Application?{/ts}</h3>
    <div class="crm-block crm-form-block">
        <div class="crm-section">{ts 1=$myentity.id}Are you sure you wish to delete the job with ID #<b>%1</b>?{/ts}
        </div>
    </div>
    <div class="crm-submit-buttons">
        {include file="CRM/common/formButtons.tpl" location="bottom"}
    </div>
{else}
    <div class="crm-block crm-form-block">
        <div class="crm-section">
            <div class="label">{$form.app_id.label}</div>
            <div class="content">{$form.app_id.html}</div>
            <div class="clear"></div>
        </div>

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
            <div class="label">{$form.title.label}</div>
            <div class="content">{$form.title.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.employer_id.label}</div>
            <div class="content">{$form.employer_id.html}</div>
            <div class="clear"></div>
        </div>


        <div class="crm-section">
            <div class="label">{$form.o8_job_status_id.label}</div>
            <div class="content">{$form.o8_job_status_id.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.o8_job_role_id.label}</div>
            <div class="content">{$form.o8_job_role_id.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.o8_job_location_id.label}</div>
            <div class="content">{$form.o8_job_location_id.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.job_created_date.label}</div>
            <div class="content">{$form.job_created_date.html}</div>
            <div class="clear"></div>
        </div>

        <div class="crm-section">
            <div class="label">{$form.status_id.label}</div>
            <div class="content">{$form.status_id.html}</div>
            <div class="clear"></div>
        </div>


        <div class="crm-section">
            <div class="label">{$form.created_date.label}</div>
            <div class="content">{$form.created_date.html}</div>
            <div class="clear"></div>
        </div>
        {* Add the line below: *}

        {*    {include file="CRM/common/customDataBlock.tpl" customDataType='Job' entityID=$id}*}

        <div class="crm-submit-buttons">
            {include file="CRM/common/formButtons.tpl" location="bottom"}
        </div>

    </div>
{/if}
{/crmScope}