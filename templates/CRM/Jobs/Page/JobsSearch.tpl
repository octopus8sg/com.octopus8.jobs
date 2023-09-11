{crmScope extensionKey='com.octopus8.jobs'}
    <div class="crm-content-block">
        {if $permission eq 2}
            <div class="action-link">
                {*        {debug}*}

                <a class="button add-job" href="{crmURL p="civicrm/jobs/form" q="reset=1&action=add" }">
                    <i class="crm-i fa-plus-circle">&nbsp;</i>
                    {ts}Add Job{/ts}
                </a>

            </div>
        {/if}
        <div class="clear"></div>
        {include file="CRM/Jobs/Form/JobFilter.tpl"}
        <div class="clear"></div>
        <div class="crm-results-block">
            <div class="crm-search-results">
                {include file="CRM/common/enableDisableApi.tpl"}
                {include file="CRM/common/jsortable.tpl"}
                <table class="selector selector-jobs row-highlight pagerDisplay" id="Jobs" name="Jobs">
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
                            {ts}Employer{/ts}
                        </th>
                        <th scope="col">
                            {ts}Applications Count{/ts}
                        </th>
                        <th scope="col">
                            {ts}Job Created{/ts}
                        </th>
                        <th scope="col">
                            {ts}Job Closed{/ts}
                        </th>
                        <th id="nosort">&nbsp;Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
{crmScript ext=com.octopus8.jobs file=js/jobs.js}
{/crmScope}