{crmScope extensionKey='com.socialservicesconnect.jobs'}
    <div class="crm-content-block">
        <div class="clear"></div>
        {include file="CRM/Job/Form/EmployeeJobFilter.tpl"}
        <div class="clear"></div>
        <div class="crm-results-block">
            <div class="crm-search-results">
                {include file="CRM/common/enableDisableApi.tpl"}
                {include file="CRM/common/jsortable.tpl"}
                <table class="selector selector-devices row-highlight pagerDisplay" id="employeeJobs" name="employeeJobs">
                    <thead class="sticky">
                    <tr>
                        <th id="sortable" scope="col">
                            {ts}ID{/ts}
                        </th>
                        <th scope="col">
                            {ts}Job Title{/ts}
                        </th>
                        <th scope="col">
                            {ts}Employer{/ts}
                        </th>
                        <th scope="col">
                            {ts}Location{/ts}
                        </th>
                        <th scope="col">
                            {ts}Date Created{/ts}
                        </th>
                        <th scope="col">
                            {ts}Job Status{/ts}
                        </th>
                        <th id="nosort">&nbsp;Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
{crmScript ext=com.socialservicesconnect.jobs file=js/employeejobs.js}
{/crmScope}