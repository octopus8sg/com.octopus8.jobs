{crmScope extensionKey='com.octopus8.jobs'}
    <div class="crm-content-block">
        <div class="clear"></div>
        {include file="CRM/Jobs/Form/EmployeeApplicationFilter.tpl"}
        <div class="clear"></div>
        <div class="crm-results-block">
            <div class="crm-search-results">
                {include file="CRM/common/enableDisableApi.tpl"}
                {include file="CRM/common/jsortable.tpl"}
                <table class="selector selector-employee-applications row-highlight pagerDisplay" id="employeeApplications" name="employeeApplications">
                    <thead class="sticky">
                    <tr>
                        <th id="sortable" scope="col">
                            {ts}ID{/ts}
                        </th>
                        <th scope="col">
                            {ts}Active App?{/ts}
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
                            {ts}Date Created{/ts}
                        </th>
                        <th scope="col">
                            {ts}Active Job?{/ts}
                        </th>
                        <th scope="col">
                            {ts}Date Applied{/ts}
                        </th>
                        <th scope="col">
                            {ts}Application Status{/ts}
                        </th>
                        <th id="nosort">&nbsp;Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
{crmScript ext=com.octopus8.jobs file=js/employeeapplications.js}
{/crmScope}