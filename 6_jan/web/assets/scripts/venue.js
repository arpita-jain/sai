var VenueTable = function() {
    return {
//main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#venue_table').dataTable({
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
            jQuery('#venue_table .group-checkable').change(function() {
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
            jQuery('#venue_table_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#venue_table_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();
jQuery(document).ready(function() {
    VenueTable.init();
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
    oTable = $('#venue_table').dataTable();
});




function viewAdmin(id) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/viewVenue',
        data: {
            'id': id
        },
        success: function(data) {
            if (data.success === 1) {
                var status = "";
                if (data.record.is_actived)
                {
                    status = "Activated";
                } else {
                    status = "Deactivated";
                }
                $("#viewData").empty();
                $("#viewData").append("<tr><td>Frist Name</td><td>" + data.record.first_name + "</td></tr>");
                $("#viewData").append("<tr><td>Last Name</td><td>" + data.record.last_name + "</td></tr>");
                $("#viewData").append("<tr><td>Mobile</td><td>" + data.record.mobile + "</td></tr>");
                $("#viewData").append("<tr><td>Email</td><td>" + data.record.email + "</td></tr>");
                $("#viewData").append("<tr><td>Address</td><td>" + data.record.address + "</td></tr>");
                $("#viewData").append("<tr><td>Created At</td><td>" + data.record.created_at + "</td></tr>");
                $("#viewData").append("<tr><td>Status</td><td>" + status + "</td></tr>");
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#viewAdmin').modal('show');
        }
    });
}

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

/* Get the rows which are currently selected */
function fnGetSelected(oTableLocal)
{
    var aReturn = new Array();
    var aTrs = oTableLocal.fnGetNodes();
    for (var i = 0; i < aTrs.length; i++)
    {
        if ($(aTrs[i]).hasClass('success'))
        {
            aReturn.push(aTrs[i]);
        }
    }
    return aReturn;
}

function uncheckall()
{
    jQuery("#venue_table .checkboxes").each(function() {
        var tr = $(this).parent().parent();
        $(this).prop('checked', false);
        $(tr).removeClass("success");
    });
}