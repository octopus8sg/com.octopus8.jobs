{crmScope extensionKey='com.socialservicesconnect.jobs'}
    <div class="jobs-tab view-content">
        <div id="secondaryTabContainer1" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            {include file="CRM/common/TabSelected.tpl" defaultTab="data" tabContainer="#secondaryTabContainer1"}

            <ul class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
                <li id="tab_data1" class="crm-tab-button ui-corner-all ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active">
                    <a href="#data-subtab1" title="{ts}Jobs{/ts}">
                        {ts}Jobs{/ts} <em>{$jobCount}</em>
                    </a>
                </li>
            </ul>

            <div id="data-subtab1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                {include file="CRM/Jobs/Page/Tabs/EmployerJobs.tpl"}
            </div>
            <div class="clear"></div>
        </div>
    </div>

{literal}
    <script type="text/javascript">
        CRM.$(function($) {
            $('input.hasDatepicker')
                .crmDatepicker({
                    format: "yy-mm-dd",
                    altFormat: "yy-mm-dd",
                    dateFormat: "yy-mm-dd"
                });

        });
    </script>
{/literal}
{/crmScope}