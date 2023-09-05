CRM.$(function ($) {

    $("a.add-job").click(function (event) {
        event.preventDefault();
        var href = $(this).attr('href');
        // alert(href);
        var $el = CRM.loadForm(href, {
            dialog: {width: '50%', height: '50%'}
        }).on('crmFormSuccess', function () {
            var hm_tab = $('.selector-jobs');
            var hm_table = hm_tab.DataTable();
            hm_table.draw();
        });
    });


    var jobs_sourceUrl = CRM.vars.source_url['job_sourceUrl'];
    $(document).ready(function () {
        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var jobs_tab = $('.selector-jobs');
        var jobs_table = jobs_tab.DataTable();
        var jobs_dtsettings = jobs_table.settings().init();
        jobs_dtsettings.bFilter = true;
        //turn on search
        jobs_dtsettings.fnInitComplete = function (oSettings, json) {
            // $("a.view-job").css('background','red');
            // $("a.view-job").click(function (event) {
            //     event.preventDefault();
            //     var href = $(this).attr('href');
            //     // alert(href);
            //     var $el = CRM.loadForm(href, {
            //         dialog: {width: '50%', height: '50%'}
            //     }).on('crmFormSuccess', function () {
            //         var hm_tab = $('.selector-jobs');
            //         var hm_table = hm_tab.DataTable();
            //         hm_table.draw();
            //     });
            // });
            // // $("a.update-job").css('background','blue');
            // $("a.update-job").click(function (event) {
            //     event.preventDefault();
            //     var href = $(this).attr('href');
            //     // alert(href);
            //     var $el = CRM.loadForm(href, {
            //         dialog: {width: '50%', height: '50%'}
            //     }).on('crmFormSuccess', function () {
            //         var hm_tab = $('.selector-jobs');
            //         var hm_table = hm_tab.DataTable();
            //         hm_table.draw();
            //     });
            // });
        };
        jobs_dtsettings.fnDrawCallback = function (oSettings) {
            // $("a.view-job").css('background','red');
            $("a.view-job").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-jobs');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            // $("a.update-job").css('background','blue');
            $("a.update-job").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-jobs');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            $("a.delete-job").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-jobs');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        jobs_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        jobs_dtsettings.sAjaxSource = jobs_sourceUrl;
        jobs_dtsettings.Buttons = ["csv", "pdf", "copy"];
        jobs_dtsettings.fnServerData = function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": "job_id",
                "value": $('#job_id').val()
            });
            aoData.push({
                "name": "dateselect_from",
                "value": $('#job_dateselect_from').val()
            });
            aoData.push({
                "name": "dateselect_to",
                "value": $('#job_dateselect_to').val()
            });
            aoData.push({
                "name": "due_dateselect_from",
                "value": $('#job_due_dateselect_from').val()
            });
            aoData.push({
                "name": "job_due_date_open",
                "value": $('#job_due_date_open').val()
            });
            aoData.push({
                "name": "due_dateselect_to",
                "value": $('#job_due_dateselect_to').val()
            });
            aoData.push({
                "name": "role_id",
                "value": $('#job_role_id').val()
            });
            // var ischecked = $('#job_is_active').prop("checked");
            // // alert(ischecked);
            // aoData.push({
            //     "name":
            //         "is_active",
            //     "value":
            //     ischecked
            // });
            aoData.push({
                "name":
                    "location_id",
                "value":
                    $('#job_location_id').val()
            });
            aoData.push({
                "name":
                    "job_contact_id",
                "value":
                    $('#job_contact_id').val()
            });


            $.ajax({
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
        $('.job-filter :input').change(function () {
            new_jobs_table.draw();
        });

        $('#job_id').keyup(function () {
            new_jobs_table.draw();
        });
    });


});