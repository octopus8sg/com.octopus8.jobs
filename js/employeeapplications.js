CRM.$(function ($) {

    $("a.add-application").click(function (event) {
        event.preventDefault();
        var href = $(this).attr('href');
        // alert(href);
        var $el = CRM.loadForm(href, {
            dialog: {width: '50%', height: '50%'}
        }).on('crmFormSuccess', function () {
            var hm_tab = $('.selector-employee-applications');
            var hm_table = hm_tab.DataTable();
            hm_table.draw();
        });
    });


    var applications_sourceUrl = CRM.vars.source_url['employee_application_sourceUrl'];
    $(document).ready(function () {

        //Reset Table, add Filter and Search Possibility
        //devices datatable
        var applications_tab = $('.selector-employee-applications');
        var applications_table = applications_tab.DataTable();
        var applications_dtsettings = applications_table.settings().init();
        applications_dtsettings.bFilter = true;
        //turn on search
        applications_dtsettings.fnDrawCallback = function(oSettings){
            // $("a.view-job").css('background','red');
            $("a.view-application").click(function (event) {
                event.preventDefault();
                var href = $(this).attr('href');
                // alert(href);
                var $el = CRM.loadForm(href, {
                    dialog: {width: '50%', height: '50%'}
                }).on('crmFormSuccess', function () {
                    var hm_tab = $('.selector-employee-applications');
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
                    var hm_tab = $('.selector-employee-applications');
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
                "value": $('#employee_application_dateselect_from').val()
            });
            aoData.push({
                "name": "dateselect_to",
                "value": $('#employee_application_dateselect_to').val()
            });
            aoData.push({
                "name": "role_id",
                "value": $('#employee_application_role_id').val()
            });
            aoData.push({
                "name":
                    "status_id",
                "value":
                    $('#employee_application_status_id').val()
            });
            // var jischecked = $('#employee_application_job_is_active').prop("checked");
            // // alert(jischecked);
            // aoData.push({
            //     "name":
            //         "job_is_active",
            //     "value":
            //     jischecked
            // });
            var ischecked = $('#employee_application_is_active').prop("checked");
            // alert(ischecked);
            aoData.push({
                "name":
                    "is_active",
                "value":
                ischecked
            });
            aoData.push({
                "name":
                    "location_id",
                "value":
                    $('#application_location_id').val()
            });

            aoData.push({
                "name":
                    "location_id",
                "value":
                    $('#employee_application_location_id').val()
            });
            aoData.push({
                "name":
                    "employer_ids",
                "value":
                    $('#employee_application_contact_id').val()
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
        $('.employee-application-filter :input').change(function () {
            new_applications_table.draw();
        });

    });


});