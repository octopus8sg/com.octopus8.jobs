<h3>{ts}Summary Static Data{/ts} {*{help id="id-member-intro"}*}</h3>

<table class="report">
    <tr class="columnheader-dark">
        <th scope="col">JOBS</th>
        <th scope="col">APPLICATIONS</th>
        <th scope="col">EMPLOYERS</th>
        <th scope="col">ROLES</th>
        <th scope="col">LOCATIONS</th>
    </tr>

    <tr>
        <td align="right"><a target="_blank" href="{crmURL p='civicrm/jobs/search'}">{$jobCount}</a></td>
        <td align="right"><a target="_blank" href="{crmURL p='civicrm/jobs/search'}">{$appCount}</a></td>
        <td align="right">{$empersCount}</td>
        <td align="right"><a target="_blank"
                             href="{crmURL p='civicrm/admin/options/ssc_job_role'}&reset=1&action=browse">{$roleCount}</a>
        </td>
        <td align="right"><a target="_blank"
                             href="{crmURL p='civicrm/admin/options/ssc_job_location'}&reset=1&action=browse">{$locationCount}</a>
        </td>
    </tr>
</table>
<div class="spacer"></div>
<h3>{ts}Summary Transactional Data{/ts} {*{help id="id-member-intro"}*}</h3>

<table class="report">
    <tr class="columnheader-dark">
        <th scope="col"></th>
        <th scope="col">LAST YEAR</th>
        <th scope="col">THIS YEAR</th>
        <th scope="col">LAST MONTH</th>
        <th scope="col">THIS MONTH</th>
        <th scope="col">LAST WEEK</th>
        <th scope="col">THIS WEEK</th>
    </tr>

    <tr>
        <td font-size14pt label><strong>TOTAL JOBS</strong></td>
        <td align="right">{$last_year_jobs_Count}</td>
        <td align="right">{$this_year_jobs_Count}</td>
        <td align="right">{$last_month_jobs_Count}</td>
        <td align="right">{$this_month_jobs_Count}</td>
        <td align="right">{$last_week_jobs_Count}</td>
        <td align="right">{$this_week_jobs_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>TOTAL APPLICATIONS</strong></td>
        <td align="right">{$last_year_apps_Count}</td>
        <td align="right">{$this_year_apps_Count}</td>
        <td align="right">{$last_month_apps_Count}</td>
        <td align="right">{$this_month_apps_Count}</td>
        <td align="right">{$last_week_apps_Count}</td>
        <td align="right">{$this_week_apps_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>EMPLOYERS*</strong></td>
        <td align="right">{$last_year_empers_Count}</td>
        <td align="right">{$this_year_empers_Count}</td>
        <td align="right">{$last_month_empers_Count}</td>
        <td align="right">{$this_month_empers_Count}</td>
        <td align="right">{$last_week_empers_Count}</td>
        <td align="right">{$this_week_empers_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>EMPLOYEES**</strong></td>
        <td align="right">{$last_year_empees_Count}</td>
        <td align="right">{$this_year_empees_Count}</td>
        <td align="right">{$last_month_empees_Count}</td>
        <td align="right">{$this_month_empees_Count}</td>
        <td align="right">{$last_week_empees_Count}</td>
        <td align="right">{$this_week_empees_Count}</td>
    </tr>
    <tr>
        <td colspan="7">* Contacts created jobs in the given period of time</td>
    </tr>
    <tr>
        <td colspan="7">** Contacts applied for jobs in the given period of time</td>
    </tr>
</table>