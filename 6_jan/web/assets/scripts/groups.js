var GroupTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#group_table').dataTable({
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
                            "fnClick": delete_groups
                        }
                        ,
                        {
                            "sExtends": "text",
                            "sButtonText": "<i class='icon-user'></i> Add Group",
                            "fnClick": add_group
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
            jQuery('#group_table .group-checkable').change(function() {
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
            jQuery('#group_table_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#group_table_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();
jQuery(document).ready(function() {
    GroupTable.init();
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
    oTable = $('#group_table').dataTable();
});


function delete_groups()
{
    var anSelected = fnGetSelected(oTable);
    if (anSelected.length)
    {
        bootbox.confirm("Do you really want to delete this record(s) ?", function(result) {
            if (result)
            {
                deleteGroups();
            }
        });
    } else {
        bootbox.alert("Please select at least one record !");
    }
}

//View Event Detail
function viewGroup(id) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        sync: false,
        url: site_path + 'admin_ajax/viewGroup',
        data: {
            'id': id
        },
        success: function(data) {
            if (data != '') {
                $.each(data, function(index, value) {
                    if (value.id != '') {
                        $("#viewData").empty();
                        $("#viewData").append("<tr><td>Group Name</td><td>" + value.group_name + "</td></tr>");
                        $("#viewData").append("<tr><td>Supervisor Name</td><td>" + value.username + "</td></tr>");
                        $("#viewData").append("<tr><td>Description</td><td>" + value.description + "</td></tr>");
                        $("#viewData").append("<tr><td>Location</td><td>" + value.location + "</td></tr>");
                        $("#viewData").append("<tr><td>Created On</td><td>" + value.date + "</td></tr>");
                    } else {
                        bootbox.alert(data.error + " !");
                    }
                });
            }
        },
        complete: function() {
            $('#viewGroup').modal('show');
        },
        error: function() {
            bootbox.alert("OOps something wrong");
        }
    });
}

function updateGroup(id)
{
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/viewGroup',
        data: {
            'id': id
        },
        success: function(data) {
            $.each(data, function(index, value) {
                if (value.id != '') {
                    $("#upd_group_name").val(value.group_name);
                    $("#upd_supervisor").val(value.username);
                    $("#upd_description").val(value.description);
                    $("#upd_location").val(value.location);
                    $("#upd_id").val(id);
                    $("#upd_supervisor").val(value.super_id);
                } else {
                    bootbox.alert(data.error + " !");
                }


            });
        },
        complete: function() {
            $('#updateGroup').modal('show');
        }
    });

}


function deleteGroups()
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
        url: site_path + 'admin_ajax/delGroup',
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
                GroupTable.init();
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#myModal').modal('hide');
        }
    });
}



function add_group()
{
    $("input[type='text']").val("");
    $("input[type='password']").val("");
    $('#myModal').modal("show");
}

$("#myModal #add_group").click(function() {
    if (validateInputs("#myModal"))
    {
        var group_name = $("#group_name").val();
        var supervisor = $("#supervisor").val();
        var description = $("#description").val();
        var location = $("#location").val();
        $.ajax({
            type: 'post',
            dataType: 'json',
            acync: false,
            url: site_path + 'admin_ajax/addGroup',
            data: {
                'group_name': group_name,
                'supervisor': supervisor,
                'description': description,
                'location': location
            },
            success: function(data) {
                if (data.success != "") {
                    window.location.href = '';
                    $('#myModal').modal('hide');
                } else {
                    $('#myModal').modal('hide');
                    boootbox.alert("Sorry something wend wrong , please try again !!")
                }
            }
        });
    }

});

function editGroup()
{
    var group_name = $("#upd_group_name").val();
    var supervisor = $("#upd_supervisor").val();
    var description = $("#upd_description").val();
    var location = $("#upd_location").val();
    var upd_id = $("#upd_id").val();

    $.ajax({
        type: 'post',
        dataType: 'json',
        acync: false,
        url: site_path + 'admin_ajax/editGroup',
        data: {
            'upd_id': upd_id,
            'group_name': group_name,
            'supervisor': supervisor,
            'description': description,
            'location': location
        },
        success: function(data) {
            if (data.success != "") {
                window.location.href = '';
                $('#myModal').modal('hide');
            } else {
                $('#myModal').modal('hide');
                boootbox.alert("Sorry something wend wrong , please try again !!")
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
            if ($(this).attr("id") == "upd_email")
            {
                if (!validateEmail($(this).val()))
                {
                    ack = 0;
                    $(this).css("border", "1px solid red");
                    return false;
                }
            }

            if ($(this).attr("id") == "upd_mobile")
            {
                if ($(this).val().length != 10)
                {
                    ack = 0;
                    $(this).css("border", "1px solid red");
                    return false;
                }
            }
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
            GroupTable.init();
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
    jQuery("#group_table .checkboxes").each(function() {
        var tr = $(this).parent().parent();
        $(this).prop('checked', false);
        $(tr).removeClass("success");
    });
}
function set_kioskgroupsstatus(id) {
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
        dataType: 'text',
        acync: false,
        url: site_path + 'admin_ajax/setgroupstatus',
        data: {
            'id': id,
            'status': status
        },
        success: function(data) {
        }

    });
}

function delete_groups(id)
{
    var anSelected = fnGetSelected(oTable);
    if (anSelected.length)
    {
        bootbox.confirm("Do you really want to delete this record(s) ?", function(result) {
            if (result)
            {
                deleteGroups(id);
            }
        });
    } else {
        bootbox.alert("Please select at least one record !");
    }
}

function deleteGroups(id)
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
        url: site_path + 'admin_ajax/delGroup',
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
                GroupTable.init();
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#myModal').modal('hide');
        }
    });
}