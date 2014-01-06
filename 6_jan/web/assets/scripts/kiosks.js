var KioskTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#kiosks_table').dataTable({
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
                        {
                            "sExtends": "text",
                            "sButtonText": "<i class='icon-trash'></i> Delete",
                            "sMessage": 'Click delete',
                            "fnClick": delete_kiosks
                        }
                        ,
                        {
                            "sExtends": "text",
                            "sButtonText": "<i class='icon-user'></i> Add Kiosk",
                            "fnClick": add_kiosk
                        }],
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
            jQuery('#kiosks_table .group-checkable').change(function() {
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
            jQuery('#kiosks_table_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#kiosks_table_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();
jQuery(document).ready(function() {
    KioskTable.init();
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
    /* Init the table */
    oTable = $('#kiosks_table').dataTable();
});


function delete_kiosks(id)
{
    var anSelected = fnGetSelected(oTable);
    if (anSelected.length)
    {
        bootbox.confirm("Do you really want to delete this record(s) ?", function(result) {
            if (result)
            {
                deleteKiosks(id);
            }
        });
    } else {
        bootbox.alert("Please select at least one record !");
    }
}

//View Event Detail
function viewKiosk(id) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        sync: false,
        url: site_path + 'admin_ajax/viewKiosk',
        data: {
            'id': id
        },
        success: function(data) {
            if (data != '') {
                $.each(data, function(index, value) {
                    if (value.id != '') {
                        $("#viewData").empty();
                        $("#viewData").append("<tr><td>Kiosk Name</td><td>" + value.kiosk_name + "</td></tr>");
                        $("#viewData").append("<tr><td>Description</td><td>" + value.description + "</td></tr>");
                        $("#viewData").append("<tr><td>Token number</td><td>" + value.token + "</td></tr>");
                        $("#viewData").append("<tr><td>Created At</td><td>" + value.ts + "</td></tr>");
                    } else {
                        bootbox.alert(data.error + " !");
                    }
                });
            }
        },
        complete: function() {
            $('#viewKiosk').modal('show');
        },
        error: function() {
            alert("OOps something wrong");
        }
    });
}

function editKiosk(id)
{
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/viewKiosk',
        data: {
            'id': id
        },
        success: function(data) {
            $.each(data, function(index, value) {
                if (value.id != '') {
                    $("#upd_kiosk_name").val(value.kiosk_name);
                    $("#upd_description").val(value.description);
                    $("#upd_id").val(id);
                } else {
                    bootbox.alert(data.error + " !");
                }
            });
        },
        complete: function() {
            $('#updateKiosk').modal('show');
        }
    });

}
function deleteKiosks()
{
    var ids = new Object();
    var i = 0;
    $(".checkboxes").each(function() {
        if ($(this).is(':checked'))
        {
            ids[i] = $(this).attr("id");
        }
        i++;
    });
    $.ajax({
        type: 'post',
        dataType: 'json',
        sync: false,
        url: site_path + 'admin_ajax/delKiosks',
        data: {
            'ids': ids
        },
        success: function(data) {
            if (data.success != "") {
                var anSelected = fnGetSelected(oTable);
                for (var i = 0; i < anSelected.length; i++)
                {
                    oTable.fnDeleteRow(anSelected[i]);
                }
                KioskTable.init();
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#myModal').modal('hide');
        }
    });
}



function add_kiosk()
{
    $('#myModal').modal("show");
}

//$("#myModal #add_kiosk").click(function() {
//    if (validateInputs("#myModal"))
//    {
//        var kiosk_name = $("#kiosk_name").val();
//        var description = $("#description").val();
//        $.ajax({
//            type: 'post',
//            dataType: 'json',
//            sync: false,
//            url: site_path + 'admin_ajax/addKiosk',
//            data: {
//                'kiosk_name': kiosk_name,
//                'description': description
//            },
//            success: function(data) {
//                if (data.success != "") {
//                    location.reload();
//                } else {
//                    bootbox.alert("Sorry somthing went wrong please try again");
//                }
//            },
//            complete: function() {
//                $('#myModal').modal("hide");
//            }
//        });
//    }
//
//});

function updateKiosk()
{
    var kiosk_name = $("#upd_kiosk_name").val();
    var description = $("#upd_description").val();
    var upd_id = $("#upd_id").val();

    $.ajax({
        type: 'post',
        dataType: 'json',
        sync: false,
        url: site_path + 'admin_ajax/updateKiosk',
        data: {
            'upd_id': upd_id,
            'kiosk_name': kiosk_name,
            'description': description
        },
        success: function(data) {
            if (data.success != "") {
                location.reload();
            }
        }
    });


}


function validateUpdatedInputs()
{
    var ack = 0;
    $(".upd_required").each(function() {
        if ($(this).val() == "")
        {
            ack = 0;
            $(this).css("border", "1px solid red");
            return false;
        }
        else {
            $(this).css("border", "1px solid green");
            ack = 1;
        }
    });
    return ack;
}

function validateInputs(container)
{
    var ack = 0;
    $(container + " .required").each(function() {
        if ($(this).val() == "")
        {
            ack = 0;
            $(this).css("border", "1px solid red");
            return false;
        }
        else {

            $(this).css("border", "1px solid green");
            ack = 1;
        }
    });
    return ack;
}

function deleterow(evt)
{

    var tr = $(evt).parent().parent();
    $(tr).addClass("success");
    var x = $(tr).find("input:checkbox");
    $(x).prop("checked", true);
    var id = $(x).attr("id");
    bootbox.confirm("Do you really want to delete this record ?", function(result) {
        if (result)
        {
            var anSelected = fnGetSelected(oTable);
            for (var i = 0; i < anSelected.length; i++)
            {
                oTable.fnDeleteRow(anSelected[i]);
            }
            KioskTable.init();
        } else {
            $(tr).removeClass("success");
            $(x).prop("checked", false);
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
    $.ajax({
        type: 'post',
        dataType: 'json',
        acync: false,
        url: site_path + 'admin_ajax/AsignedSupervisor',
        data: {
            'Id': event
        }
    });
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
    jQuery("#kiosk_table .checkboxes").each(function() {
        var tr = $(this).parent().parent();
        $(this).prop('checked', false);
        $(tr).removeClass("success");
    });
}
function set_kioskstatus(id) {
    if ($("#status_" + id).hasClass("icon-ok-sign text-success")) {
        $("#status_" + id).removeClass("icon-ok-sign text-success");
        $("#status_" + id).addClass("icon-minus-sign text-error");
        var status = 0;
    } else if ($("#status_" + id).hasClass("icon-minus-sign text-error")) {
        $("#status_" + id).removeClass("icon-minus-sign text-error");
        $("#status_" + id).addClass("icon-ok-sign text-success ");
        var status = 1;
    }

    $.ajax({
        type: 'post',
        dataType: 'json',
        acync: false,
        url: site_path + 'admin_ajax/setkioskstatus', 
        data: {
            'id': id,
            'status': status
        },
        success: function(data) {
        }

    });
}

function delete_kiosks(id)
{
    var anSelected = fnGetSelected(oTable);
    if (anSelected.length)
    {
        bootbox.confirm("Do you really want to delete this record(s) ?", function(result) {
            if (result)
            {
                deleteKiosks(id);
            }
        });
    } else {
        bootbox.alert("Please select at least one record !");
    }
}

function deleteKiosks(id)
{
    var ids = new Object();
    var i = 0;
    $(".checkboxes").each(function() {
        if ($(this).is(':checked'))
        {
            ids[i] = $(this).attr("id");
        }
        i++;
    });
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/delKiosks',
        data: {
            'ids': ids
        },
        success: function(data) {
            if (data.success != "") {
                var anSelected = fnGetSelected(oTable);
                for (var i = 0; i < anSelected.length; i++)
                {
                    oTable.fnDeleteRow(anSelected[i]);
                }
                KioskTable.init();
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#myModal').modal('hide');
        }
    });
}