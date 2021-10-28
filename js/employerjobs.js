CRM.$(function ($) {

    $("a.add-job").click(function( event ) {
        event.preventDefault();
        var href = $(this).attr('href');
        // alert(href);
        var $el =CRM.loadForm(href, {
            dialog: {width: '50%', height: '50%'}
        }).on('crmFormSuccess', function() {
            var hm_tab = $('.selector-jobs');
            var hm_table = hm_tab.DataTable();
            hm_table.draw();
        });
    });


    var jobs_sourceUrl = CRM.vars.source_url['employer_job_sourceUrl'];

    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var jobs_tab = $('.selector-employer-jobs');
        var jobs_table = jobs_tab.DataTable();
        var jobs_dtsettings = jobs_table.settings().init();
        jobs_dtsettings.bFilter = true;
        //turn on search

        jobs_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        jobs_dtsettings.sAjaxSource = jobs_sourceUrl;
        jobs_dtsettings.Buttons = ["csv", "pdf", "copy"];
        jobs_dtsettings.fnServerData = function ( sSource, aoData, fnCallback ) {
            aoData.push({ "name": "job_role_id", "value": $('#job_job_role_id').val() });
            $.ajax( {
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        jobs_table.destroy();
        var new_jobs_table = jobs_tab.DataTable(jobs_dtsettings);
        //End Reset Table
        $('.job-filter :input').change(function(){
            new_jobs_table.draw();
        });

    });


});