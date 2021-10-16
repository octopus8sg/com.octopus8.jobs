{crmScope extensionKey='com.socialservicesconnect.job'}
    <div class="crm-content-block">
        <div class="action-link">
            <a class="button" href="{crmURL p="civicrm/job/form" q="reset=1&action=add" }">
                <i class="crm-i fa-plus-circle">&nbsp;</i>
                {ts}Add my entity{/ts}
            </a>
        </div>

        <div class="clear"></div>

        <div class="crm-results-block">
            {include file="CRM/common/pager.tpl" location="top"}

            <div class="crm-search-results">
                <table class="selector row-highlight">
                    <thead class="sticky">
                    <tr>
                        <th scope="col">
                            {ts}ID{/ts}
                        </th>
                        <th scope="col">
                            {ts}Contact{/ts}
                        </th>
                        <th scope="col">
                            {ts}Title{/ts}
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    {foreach from=$rows item=row}
                        <tr>
                            <td>{$row.id}</td>
                            <td>{$row.contact}</td>
                            <td>{$row.title}</td>
                            <td class="right nowrap">
                  <span>
                    <a class="action-item crm-hover-button" href="{crmURL p='civicrm/myentity/form' q="id=`$row.id`&action=update"}"><i class="crm-i fa-pencil"></i>&nbsp;{ts}Edit{/ts}</a>
                    <a class="action-item crm-hover-button" href="{crmURL p='civicrm/myentity/form' q="id=`$row.id`&action=delete"}"><i class="crm-i fa-trash"></i>&nbsp;{ts}Delete{/ts}</a>
                  </span>
                            </td>
                        </tr>
                    {/foreach}
                </table>

            </div>

            {include file="CRM/common/pager.tpl" location="bottom"}
        </div>
    </div>
{/crmScope}