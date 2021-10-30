CRM.$(function ($) {

    $("a.add-job").click(function (event) {
        event.preventDefault();
        var href = $(this).attr('href');
        // alert(href);
        var $el = CRM.loadForm(href, {
            dialog: {width: '50%', height: '50%'}
        }).on('crmFormSuccess', function () {
            var hm_tab = $('.selector-employer-applications');
            var hm_table = hm_tab.DataTable();
            hm_table.draw();
        });
    });


    var applications_sourceUrl = CRM.vars.source_url['employer_application_sourceUrl'];
    $(document).ready(function () {



        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var applications_tab = $('.selector-employer-applications');
        var applications_table = applications_tab.DataTable();
        var applications_dtsettings = applications_table.settings().init();
        applications_dtsettings.bFilter = true;
        //turn on search
        applications_dtsettings.fnInitComplete = function(oSettings, json){
            // $("a.view-job").css('background','red');
            $("a.view-job").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-employer-applications');
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
                    var hm_tab = $('.selector-employer-applications');
                    var hm_table = hm_tab.DataTable();
                    hm_table.draw();
                });
            });
        };
        applications_dtsettings.fnDrawCallback = function(oSettings){
            // $("a.view-job").css('background','red');
            $("a.view-job").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-employer-applications');
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
                    var hm_tab = $('.selector-employer-applications');
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
                "value": $('#employer_application_dateselect_from').val()
            });
            aoData.push({
                "name": "dateselect_to",
                "value": $('#employer_application_dateselect_to').val()
            });
            aoData.push({
                "name": "role_id",
                "value": $('#employer_application_role_id').val()
            });
            aoData.push({
                "name":
                    "status_id",
                "value":
                    $('#employer_application_status_id').val()
            });
            aoData.push({
                "name":
                    "location_id",
                "value":
                    $('#employer_application_location_id').val()
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
        $('.employer-job-filter :input').change(function () {
            new_applications_table.draw();
        });

    });


});