CRM.$(function ($) {

    // $("a.add-application").click(function (event) {
    //     event.preventDefault();
    //     var href = $(this).attr('href');
    //     // alert(href);
    //     var $el = CRM.loadForm(href, {
    //         dialog: {width: '50%', height: '50%'}
    //     }).on('crmFormSuccess', function () {
    //         var hm_tab = $('.selector-applications');
    //         var hm_table = hm_tab.DataTable();
    //         hm_table.draw();
    //     });
    // });
    //

    var applications_sourceUrl = CRM.vars.source_url['application_sourceUrl'];
    $(document).ready(function () {
        // alert(applications_sourceUrl);
        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var applications_tab = $('.selector-applications');
        var applications_table = applications_tab.DataTable();
        var applications_dtsettings = applications_table.settings().init();
        applications_dtsettings.bFilter = true;
        //turn on search
        applications_dtsettings.fnInitComplete = function(oSettings, json){
            // $("a.view-job").css('background','red');
            $("a.view-application").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-applications');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            // $("a.update-job").css('background','blue');
            $("a.update-application").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-applications');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            $("a.add-application").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-applications');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        applications_dtsettings.fnDrawCallback = function(oSettings){
            // $("a.view-job").css('background','red');
            $("a.view-application").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-applications');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            // $("a.update-job").css('background','blue');
            $("a.update-application").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-applications');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
            $("a.add-application").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-applications');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        applications_dtsettings.sDom = '<"crm-datatable-pager-top"lp>Brt<"crm-datatable-pager-bottom"ip>';
        //turn of search field
        applications_dtsettings.sAjaxSource = applications_sourceUrl;
        applications_dtsettings.Buttons = ["csv", "pdf", "copy"];
        applications_dtsettings.fnServerData = function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": "dateselect_from",
                "value": $('#application_dateselect_from').val()
            });
            aoData.push({
                "name": "dateselect_to",
                "value": $('#application_dateselect_to').val()
            });
            aoData.push({
                "name": "role_id",
                "value": $('#application_role_id').val()
            });
            aoData.push({
                "name":
                    "app_status_id",
                "value":
                    $('#application_status_id').val()
            });
            aoData.push({
                "name":
                    "job_status_id",
                "value":
                    $('#application_job_status_id').val()
            });
            aoData.push({
                "name":
                    "location_id",
                "value":
                    $('#application_location_id').val()
            });
            aoData.push({
                "name":
                    "employer_ids",
                "value":
                    $('#application_job_contact_id').val()
            });
            aoData.push({
                "name":
                    "employee_ids",
                "value":
                    $('#application_contact_id').val()
            });
            aoData.push({
                "name":
                    "application_id",
                "value":
                    $('#application_id').val()
            });
            aoData.push({
                "name":
                    "application_job_id",
                "value":
                    $('#application_job_id').val()
            });


            $.ajax({
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        };
        applications_table.destroy();
        var new_applications_table = applications_tab.DataTable(applications_dtsettings);
        //End Reset Table
        $('.application-filter :input').change(function () {
            // alert("I'm here!");

            new_applications_table.draw();
        });

    });


});