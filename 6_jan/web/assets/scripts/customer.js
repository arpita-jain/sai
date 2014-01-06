var CustomerTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#customer_table').dataTable({
                "bRetrieve": true,
                "bDestroy": true,
                "aaSorting": [[2, "desc"]],
                "aLengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 20,
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
            jQuery('#customer_table .group-checkable').change(function() {
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
            jQuery('#customer_table_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#customer_table_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();
jQuery(document).ready(function() {
    CustomerTable.init();
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
    oTable = $('#customer_table').dataTable();
});

// for view customer information  //
function viewCustomer(id) {    
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/viewCustomer',
        data: {
            'id': id
        },
        success: function(data){                        
            if (data.success === 1) {
                var status = "";
                if (data.record.is_actived)
                {
                    status = "Activated";
                } else {
                    status = "Deactivated";
                }
                $("#viewData").empty();
                $("#viewData").append("<tr><td>Total-ticket</td><td>"+(data.record.order_items) + "</td></tr>");
                $("#viewData").append("<tr><td>Total-price</td><td>" + data.record.order_amount + "</td></tr>");
                $("#viewData").append("<tr><td>First name</td><td>" + data.record.firstname + "</td></tr>");
                $("#viewData").append("<tr><td>Last name</td><td>" + data.record.lastname + "</td></tr>");                
                $("#viewData").append("<tr><td>Mobile</td><td>" + data.record.mobile + "</td></tr>");                
                $("#viewData").append("<tr><td>Email</td><td>" + data.record.email + "</td></tr>");       
                $("#viewData").append("<tr><td>Address</td><td>" + data.record.city + "</td></tr>");
                $("#viewData").append("<tr><td>Created At</td><td>" + data.record.created_date + "</td></tr>");              
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#viewAdmin').modal('show');
        }
    });
}

function updateCustomer(id)
{
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/CustomerInfo',
        data: {
            'id': id
        },
        success: function(data) {
            if (data.success === 1) {
                $("#upd_firstname").val(data.record.firstname);
                $("#upd_lastname").val(data.record.lastname);
                $("#upd_mobile").val(data.record.mobile);
                $("#upd_email").val(data.record.email);               
                $("#upd_housenumber").val(data.record.housenumber);
                $("#upd_street").val(data.record.street);
                $("#upd_city").val(data.record.city);
                $("#upd_county").val(data.record.county);
                $("#upd_country").val(data.record.country);
                $("#upd_postcode").val(data.record.postcode);               
                $("#upd_id").val(data.record.id);
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#updateAdmin').modal('show');
        }
    });
}

function editCustomer()
{   
    if (validateUpdatedInputs())
    {
        var firstname = $("#upd_firstname").val();
        var lastname = $("#upd_lastname").val();
        var mobile = $("#upd_mobile").val();
        var email = $("#upd_email").val();
        var housenumber = $("#upd_housenumber").val();    
        var street = $("#upd_street").val();    
        var city = $("#upd_city").val();    
        var county = $("#upd_county").val();    
        var country = $("#upd_country").val();    
        var postcode = $("#upd_postcode").val();    
        var id = $("#upd_id").val();
        
        $.ajax({
            type: 'post',
            dataType: 'json',
            acync: false,
            url: site_path + 'admin_ajax/editCustomer',
            data: {
                'firstname': firstname,
                'lastname': lastname,
                'mobile': mobile,
                'email': email,
                'housenumber': housenumber,                   
                'street': street,                   
                'city': city,                   
                'county': county,                   
                'country': country,                   
                'postcode': postcode,                   
                'id': id
            },
            success: function(data) {
                if (data.success == 1) {
                    uncheckall();

                    var tr = $("#" + id).parent().parent();
                    $(tr).addClass("success");
                    var x = $(tr).find("input:checkbox");
                    $(x).prop("checked", true);

                    var anSelected = fnGetSelected(oTable);
                    
                    $(tr).removeClass("success");
                    $(x).prop("checked", false);
                    location.reload();
                } else {
                    bootbox.alert(data.error + " !");
                }
            },
            complete: function() {
                $('#updateAdmin').modal('hide');
            }
        });
       
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




