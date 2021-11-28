{crmScope extensionKey='com.octopus8.jobs'}
    <div class="crm-content-block">
        <div class="clear"></div>
        {include file="CRM/Jobs/Form/ApplicationFilter.tpl"}
        <div class="clear"></div>
        <div class="crm-results-block">
            <div class="crm-search-results">
                {include file="CRM/common/enableDisableApi.tpl"}
                {include file="CRM/common/jsortable.tpl"}
                <table class="selector selector-applications row-highlight pagerDisplay" id="Applications" name="Applications">
                    <thead class="sticky">
                    <tr>
                        <th id="sortable" scope="col">
                            {ts}ID{/ts}
                        </th>
                        <th scope="col">
                            {ts}Applied/Withdrawn{/ts}
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
                            {ts}Apps Count{/ts}
                        </th>
                        <th scope="col">
                            {ts}Job Created Date{/ts}
                        </th>
                        <th scope="col">
                            {ts}Job Open/Closed{/ts}
                        </th>
                        <th scope="col">
                            {ts}Employee{/ts}
                        </th>
                        <th scope="col">
                            {ts}App Created Date{/ts}
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
{crmScript ext=com.octopus8.jobs file=js/applications.js}
{/crmScope}