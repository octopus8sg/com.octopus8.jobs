{crmScope extensionKey='com.socialservicesconnect.jobs'}
<div class="crm-content-block">
    <div class="action-link">
        <a class="button add-job" href="{crmURL p="civicrm/job/form" q="reset=1&action=add" }&cid={$contactId}">
            <i class="crm-i fa-plus-circle">&nbsp;</i>
            {ts}Add Job{/ts}
        </a>
    </div>
    <div class="clear"></div>
    {include file="CRM/Job/Form/EmployerJobFilter.tpl"}
    <div class="clear"></div>
    <div class="crm-results-block">
        <div class="crm-search-results">
            {include file="CRM/common/enableDisableApi.tpl"}
            {include file="CRM/common/jsortable.tpl"}
            <table class="selector selector-employer-jobs row-highlight pagerDisplay" id="employerJobs" name="employerJobs">
                <thead class="sticky">
                <tr>
                    <th id="sortable" scope="col">
                        {ts}ID{/ts}
                    </th>
                    <th scope="col">
                        {ts}Job Title{/ts}
                    </th>
                    <th scope="col">
                        {ts}Role{/ts}
                    </th>
                    <th scope="col">
                        {ts}Location{/ts}
                    </th>
                    <th scope="col">
                        {ts}Applications Count{/ts}
                    </th>
                    <th scope="col">
                        {ts}Date Created{/ts}
                    </th>
                    <th scope="col">
                        {ts}Status{/ts}
                    </th>
                    <th id="nosort">&nbsp;Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
{crmScript ext=com.socialservicesconnect.jobs file=js/employerjobs.js}
{/crmScope}