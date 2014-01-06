var TicketsTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#tickets_table').dataTable({
                "bRetrieve": true,
                "bDestroy": true,
                "aaSorting": [[2, "desc"]],
                "aLengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 10,
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
                            "sButtonText": "<i class='icon-shopping-cart'></i> Add To Basket",
                            "sMessage": 'Click delete',
                            "fnClick": add_basket
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
            jQuery('#tickets_table .group-checkable').change(function() {
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
            jQuery('#tickets_table_wrapper .dataTables_filter input').addClass("input-sm"); // modify table search input
            jQuery('#tickets_table input').addClass("input-sm"); // modify table search input
            jQuery('#tickets_table_wrapper .dataTables_length select').addClass("form-control input-sm"); // modify table per page dropdown

        }

    };
}();
jQuery(document).ready(function() {
    TicketsTable.init();
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
        oTable = $('#tickets_table').dataTable();
	/* Start for multi calumn searching in by gv*/
	$("thead input").keyup( function () {
	/* Filter on the column (the index) of this element */
	oTable.fnFilter( this.value, $("thead input").index(this) );
	} );

	$("thead input").each( function (i) { 
		asInitVals[i] = this.value;
	} );
	/* END for multi calumn searching in by gv*/
});


function add_basket()
{
    var anSelected = fnGetSelected(oTable);
    if (anSelected.length)
    {
        addtobasket();
    } else {
        bootbox.alert("Please select at least one ticket !");
    }
}


function Selltouser(id) {
    $('#user_tickets').modal('show');
}

function addtobasket() {
    var ids = new Object();
    var eventid = new Object();
    var venueid = new Object();
    var price = new Object();
    var i = 0;

    var rows = oTable.fnGetNodes();
    for (var i = 0; i < rows.length; i++)
    {
        var box = $(rows[i]).find('input[type=checkbox]');
        if (box.is(':checked'))
        {
            eventid[i] = ($("#event_" + box.attr("id")).val());
            venueid[i] = ($("#venue_" + box.attr("id")).val());
            price[i] = ($("#price_" + box.attr("id")).val());
            ids[i] = box.attr("id");
            i++;
        }
    }
    $.ajax({
        type: 'post',
        dataType: 'json',
        sync: false,
        url: site_path + 'admin_ajax/addtobasket',
        data: {
            'ids': ids,
            'eventid': eventid,
            'venueid': venueid,
            'price': price
        },
        success: function(data) {
            window.location.href = "basket";
        },
        beforeSend: function() {
            $('#waitModel').modal({
                keyboard: false,
                backdrop: false
            })
        },
        complete: function() {
            window.location.href = "basket";
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
    jQuery("#tickets_table .checkboxes").each(function() {
        var tr = $(this).parent().parent();
        $(this).prop('checked', false);
        $(tr).removeClass("success");

    });
}

//View Event Detail
function viewDetail(id) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        sync: false,
        url: site_path + 'admin_ajax/ViewDetail',
        data: {
            'eventId': id
        },
        success: function(data) {
            if (data.id != '') {
                $("#viewData").empty();
                $("#viewData").append("<tr><td>Event Name</td><td>" + data.title + "</td></tr>");
                $("#viewData").append("<tr><td>Location</td><td>" + data.venue_name + "</td></tr>");
                $("#viewData").append("<tr><td>Price</td><td>" + data.price + "</td></tr>");
                $("#viewData").append("<tr><td>On</td><td>" + data.date + "&nbsp;" + data.time + "</td></tr>");
                $("#viewData").append("<tr><td>Description</td><td>" + data.description + "</td></tr>");
            } else {
                bootbox.alert(data.error + " !");
            }
        },
        complete: function() {
            $('#viewDetail').modal('show');
        },
        error: function() {
            alert("OOps somtingwent worknogn");
        }
    });
}
