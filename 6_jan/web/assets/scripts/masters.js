var UserTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#users_table').dataTable({
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
                        "fnClick": delete_users
                    }
                    ,
                    {
                        "sExtends": "text",
                        "sButtonText": "<i class='icon-user'></i> Add User",
                        "fnClick": add_user
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
            jQuery('#users_table .group-checkable').change(function() {
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
            jQuery('#users_table_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#users_table_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();
jQuery(document).ready(function() {
    UserTable.init();
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
    oTable = $('#users_table').dataTable();
});


function delete_users()
{
    var anSelected = fnGetSelected(oTable);
    if (anSelected.length)
    {
        bootbox.confirm("Do you really want to delete this record(s) ?", function(result) {
            if (result)
            {
                deleteAdmins();
            }
        });
    } else {
        bootbox.alert("Please select at least one record !");
    }
}

function viewAdmin(id) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/viewMaster',
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
                $("#viewData").append("<tr><td>User Name</td><td>" + data.record.username + "</td></tr>");
                $("#viewData").append("<tr><td>Frist Name</td><td>" + data.record.first_name + "</td></tr>");
                $("#viewData").append("<tr><td>Last Name</td><td>" + data.record.last_name + "</td></tr>");
                $("#viewData").append("<tr><td>Mobile</td><td>" + data.record.mobile + "</td></tr>");
                $("#viewData").append("<tr><td>Email</td><td>" + data.record.email + "</td></tr>");
                $("#viewData").append("<tr><td>Password</td><td>" + data.record.password + "</td></tr>");
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

function updateAdmin(id)
{
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/viewMaster',
        data: {
            'id': id
        },
        success: function(data) {
            if (data.success === 1) {
                $("#upd_username").val(data.record.username);
                $("#upd_firstname").val(data.record.first_name);
                $("#upd_lastname").val(data.record.last_name);
                $("#upd_mobile").val(data.record.mobile);
                $("#upd_email").val(data.record.email);
                $("#upd_password").val(data.record.password);
                $("#upd_confirm_password").val(data.record.password);
                $("#upd_address").val(data.record.address);
                $("#upd_id").val(data.record.id);
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#updateAdmin').modal('show');
        }
    });
//    var row_id = host_list_table.fnGetPosition($(row)[0]);
//    host_list_table.fnUpdate(data.hosts[x], row_id);
}
function deleteAdmins()
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
        url: site_path + 'admin_ajax/delMasters',
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
                UserTable.init();
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#myModal').modal('hide');
        }
    });
}


function add_user()
{
    $("input[type='text']").val("");
    $("input[type='password']").val("");
    $('#myModal').modal("show");
}

function editAdmin()
{
    if(!updusernamesize())
        return false;
    if (validateUpdatedInputs())
    {
        var username = $("#upd_username").val();
        var firstname = $("#upd_firstname").val();
        var lastname = $("#upd_lastname").val();
        var mobile = $("#upd_mobile").val();
        var email = $("#upd_email").val();
        var address = $("#upd_address").val();
        var password = $("#upd_password").val();
        var confirm_password = $("#upd_confirm_password").val();
        var id = $("#upd_id").val();
        if(password==confirm_password) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                acync: false,
                url: site_path + 'admin_ajax/editMaster',
                data: {
                    'firstname': firstname,
                    'lastname': lastname,
                    'mobile': mobile,
                    'email': email,
                    'address': address,
                    'password': password,
                    'username': username,
                    'id': id
                },
                success: function(data) {
                    if (data.success!="") {
                        uncheckall();
                        var tr = $("#" + id).parent().parent();
                        $(tr).addClass("success");
                        var x = $(tr).find("input:checkbox");
                        $(x).prop("checked", true);
                        var anSelected = fnGetSelected(oTable);                       
                        $(tr).removeClass("success");
                        $(x).prop("checked", false);
                        $('#updateAdmin').modal('hide');
                        location.reload();
                    } else {
                        bootbox.alert("Username already exits,please enter another username");                     
                        $("#upd_username").css("border", "1px solid red"); 
                        $('#updateAdmin').modal('show');
                    }
                }
            });
        }else{
            bootbox.alert("Please fil correct password");
            $("#upd_password").css("border", "1px solid red");
            $("#upd_confirm_password").css("border", "1px solid red");
        }
    } else {
        bootbox.alert("Please fill all fields with valid inputs");
    }
}

function addnewuser()
{
    if(!usernamesize())
        return false;
    if (validateInputs())
    {
        var username = $("#username").val();
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var mobile = $("#mobile").val();
        var email = $("#email").val();
        var address = $("#address").val();
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        if(password == confirm_password){
            $.ajax({
                type: 'post',
                dataType: 'json',
                acync: false,
                url: site_path + 'admin_ajax/addMaster',
                data: {
                    'firstname': firstname,
                    'lastname': lastname,
                    'mobile': mobile,
                    'email': email,
                    'password': password,
                    'username': username,
                    'address': address
                },
                success: function(data) {
                    if (data.success != "") { 
                        location.reload();
                        $('#myModal').modal('hide');
                    } else {
                        $("#myModal").modal("show");
                        bootbox.alert("Username already exits,please enter another username");                     
                        $("#username").css("border", "1px solid red"); 
                    }
                }
            });
        }else{
            bootbox.alert("Please fil correct password");
            $("#password").css("border", "1px solid red");
            $("#confirm_password").css("border", "1px solid red");
        }
    } else {
        bootbox.alert("Please fill all fields with valid inputs");
    }
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

function validateInputs()
{
    var ack = 0;
    $(".required").each(function() {
        if ($(this).val() == "")
        {
            ack = 0;
            $(this).css("border", "1px solid red");
            return false;
        }
        else {
            if ($(this).attr("id") == "email")
            {
                if (!validateEmail($(this).val()))
                {
                    ack = 0;
                    $(this).css("border", "1px solid red");
                    return false;
                }
            }

            if ($(this).attr("id") == "mobile")
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
            UserTable.init();
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
    jQuery("#users_table .checkboxes").each(function() {
        var tr = $(this).parent().parent();       
        $(this).prop('checked', false);
        $(tr).removeClass("success");    
    });
}

function set_masterstatus(id){
    if($("#status_"+id).hasClass("icon-ok-sign text-success")){
        $("#status_"+id).removeClass("icon-ok-sign text-success");
        $("#status_"+id).addClass("icon-minus-sign text-error");
        var status = 0;
    }else if($("#status_"+id).hasClass("icon-minus-sign text-error")){
        $("#status_"+id).removeClass("icon-minus-sign text-error");
        $("#status_"+id).addClass("icon-ok-sign text-success ");
        var status = 1;
    }
    
    $.ajax({
        type: 'post',
        dataType: 'text',
        acync: false,
        url: site_path + 'admin_ajax/setuserstatus',
        data: {
            'id':id,
            'status':status
        },
        success: function(data) {          
        }
            
    });
}
