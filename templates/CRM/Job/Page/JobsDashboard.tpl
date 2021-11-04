<h3>{ts}Summary Static Data{/ts} {*{help id="id-member-intro"}*}</h3>

<table class="report">
    <tr class="columnheader-dark">
        <th scope="col">JOBS</th>
        <th scope="col">APPLICATIONS</th>
        <th scope="col">ROLES</th>
        <th scope="col">LOCATIONS</th>
        <th scope="col">JOB STATUSES</th>
        <th scope="col">APPLICATION STATUSES</th>
    </tr>

    <tr>
        <td align="right">{$jobCount}</td>
        <td align="right">{$appCount}</td>
        <td align="right">{$roleCount}</td>
        <td align="right">{$locationCount}</td>
        <td align="right">{$jobstatusCount}</td>
        <td align="right">{$appstatusCount}</td>
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
    </tr>

    <tr>
        <td font-size14pt label><strong>TOTAL JOBS</strong></td>
        <td align="right">1{$last_year_jobs_Count}</td>
        <td align="right">2{$this_year_jobs_Count}</td>
        <td align="right">3{$last_month_jobs_Count}</td>
        <td align="right">4{$this_month_jobs_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>TOTAL APPLICATIONS</strong></td>
        <td align="right">5{$last_year_apps_Count}</td>
        <td align="right">6{$this_year_apps_Count}</td>
        <td align="right">7{$last_month_apps_Count}</td>
        <td align="right">8{$this_month_apps_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>EMPLOYERS*</strong></td>
        <td align="right">9{$last_year_empers_Count}</td>
        <td align="right">8{$this_year_empers_Count}</td>
        <td align="right">7{$last_month_empers_Count}</td>
        <td align="right">6{$this_month_empers_Count}</td>
    </tr>
    <tr>
        <td font-size14pt label><strong>EMPLOYEES**</strong></td>
        <td align="right">5{$last_year_empees_Count}</td>
        <td align="right">4{$this_year_empees_Count}</td>
        <td align="right">3{$last_month_empees_Count}</td>
        <td align="right">2{$this_month_empees_Count}</td>
    </tr>
    <tr>
        <td colspan="5">* Contacts created jobs in the given period of time</td>
    </tr>
    <tr>
        <td colspan="5">** Contacts applied for jobs in the given period of time</td>
    </tr>
</table>