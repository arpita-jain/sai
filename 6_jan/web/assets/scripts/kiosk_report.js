var EventsTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#kiosk_report').dataTable({
                "bRetrieve": true,
                "bDestroy": true,
                "aaSorting": [[2, "desc"]],
                "aLengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sDom": "<'row'<'col-lg-2'l><'col-lg-6'T><'col-lg-4'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "oTableTools": {
                    "aButtons": [
                    "copy",
                    "print",
                    "pdf",
                    "csv",
                    "xls",
                    ],
                        
                    "sSwfPath": base_path + "assets/plugins/data-tables/TableTools/media/swf/copy_csv_xls_pdf.swf",
                },
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ ",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0]
                }
                ]
            });
            jQuery('#kiosk_report .group-checkable').change(function() {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function() {
                    var tr = $(this).parent().parent();
                    if (checked) {
                        $(this).prop('checked', true);
                        $(tr).addClass("success");
                    } else {
                        $(this).prop('checked', false);
                        $(tr).removeClass("success");
                    }
                });
                setme();
            });
            jQuery('#kiosk_report_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#kiosk_report_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();
jQuery(document).ready(function() {
    EventsTable.init();
    $(".DTTT_button_pdf").addClass("btn-default");
    $(".DTTT_button_csv").addClass("btn-default");
    $(".DTTT_button_print").addClass("btn-default");
    $(".DTTT_button_copy").addClass("btn-default");
    $(".DTTT_button_xls").addClass("btn-default");
    $(".DTTT_button_text").addClass("btn-default");
    $(".dataTables_paginate ul").addClass("pagination");

});
var oTable;
var giRedraw = false;
$(document).ready(function() {
    /* Add a click handler to the rows - this could be used as a callback */
    /* Init the table */
    oTable = $('#kiosk_report').dataTable();
});


function select_row(event)
{
    var obj = $(event).parent().parent();
    console.log(obj);
    if ($(event).is(":checked")) {
        console.log(obj);
        $(obj).addClass("success");
    } else {
        console.log(obj);
        $(obj).removeClass("success");
    }
}



function uncheckall()
{
    jQuery("#kiosk_report .checkboxes").each(function() {
        var tr = $(this).parent().parent();        
        $(this).prop('checked', false);
        $(tr).removeClass("success");    
    });
}

function vieweventdetails(id) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/getTicketByEventId',
        data: {
            'eventId': id
        },
        success: function(data) {                       
            if (data.id) {
                var status = "";
                if (data.status==1)
                {
                    status = "Activated";
                } else {
                    status = "Deactivated";
                }
                $("#viewData").empty();
                $("#viewData").append("<tr><td>Title</td><td>" +data.title + "</td></tr>");
                $("#viewData").append("<tr><td>Decsription</td><td>" +data.description + "</td></tr>");
                $("#viewData").append("<tr><td>Venue-name</td><td>" +data. name + "</td></tr>");
                $("#viewData").append("<tr><td>Dae-time</td><td>" +data.date +"&nbsp;"+data.time + "</td></tr>");                       
                $("#viewData").append("<tr><td>Price</td><td>" +data.price + "</td></tr>");
                $("#viewData").append("<tr><td>Status</td><td>" +status + "</td></tr>");
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#viewEvents').modal('show');
        }
    });
}