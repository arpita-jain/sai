function get_stock(id) {
    var err = 0;
    var actuallStock = "";
    var textVal = "";
    actuallStock = parseInt($("#actuall_stock_" + id).val());
    textVal = parseInt($("#user_ticket_" + id).val());

    if (textVal == "" && textVal == 0) {
        textVal = ($("#user_ticket_" + id).val(1));
        bootbox.alert("!! Please fill ticket quantity..");

    }

    if (actuallStock < textVal) {
        bootbox.alert("!!Sorry tickets are not avaliable..");
        
    }else{
        updatequantity(id);
    }

}


function updatequantity(id){
    var quantity = ($("#user_ticket_" + id).val()); 
    if(quantity){
        
        $.ajax({
            type: 'post',
            dataType: 'json',
            acync: false,
            url: site_path + 'admin_ajax/updatequantity',
            data: {               
                'quantity': quantity,
                'ticket_id': id
            },
            success: function(data) {
                
            }
        });
        
    }
}

function add_basket()
{
    $('#user_tickets').modal('show');

}


function addnewcustomer(ticketId, eventId, venueId, price)
{
    var textVal = parseInt($("#user_ticket_" + id).val());

    if (textVal != "" && textVal != 0) {
        if (validateInputs())
        {
            ticketId = ticketId.split(',');
            var tickets = new Object();
            for (i = 0; i < ticketId.length; i++)
            {
                var id = ticketId[i];
                var user_ticket = $("#quantity_" + id).val();
                tickets[i] = user_ticket;

            }
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            var mobile = $("#mobile").val();
            var email = $("#email").val();
            var houseNumber = $("#houseNumber").val();
            var street = $("#street").val();
            var city = $("#city").val();
            var country = $("#country").val();
            var postcode = $("#postcode").val();
            $.ajax({
                type: 'post',
                dataType: 'json',
                acync: false,
                url: site_path + 'admin_ajax/addcustomer',
                data: {
                    'firstname': firstname,
                    'lastname': lastname,
                    'mobile': mobile,
                    'email': email,
                    'ticketid': ticketId,
                    'ticketValue': tickets,
                    'eventid': eventId,
                    'venueid': venueId,
                    'price': price,
                    'houseNumber': houseNumber,
                    'street': street,
                    'city': city,
                    'county': county,
                    'country': country,
                    'postcode': postcode
                },
                success: function(data) {

                    if (data.success != "") {
                        $('#user_tickets').modal('hide');
                        window.location.href = "invoice?id=" + data;
                    } else {
                        bootbox.alert(data.error + " !");
                    }
                },
                complete: function() {
                    $('#user_tickets').modal('hide');
                }
            });
        }
    } else { 
        alert("wrong");
    }

}

function validateInputs()
{
    var ack = 0;
    $(".required").each(function() {
        if ($(this).val() == "")
        {
            ack = 0;
            $(this).css("border", "1px solid red");
            $(this).focus();
            return false;
        }
        else {
            if ($(this).attr("id") == "email")
            {
                if (!validateEmail($(this).val()))
                {
                    ack = 0;
                    $(this).css("border", "1px solid red");
                    $(this).focus();
                    return false;
                }
            }

            if ($(this).attr("id") == "mobile")
            {
                if ($(this).val().length != 10)
                {
                    ack = 0;
                    $(this).css("border", "1px solid red");
                    $(this).focus();
                    return false;
                }
            }
            $(this).css("border", "1px solid green");
            ack = 1;
        }
    });
    if (ack)
    {
        return true;
    } else {
        return false;
    }
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
            BasketTable.init();
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
    jQuery("#basket_table .checkboxes").each(function() {
        var tr = $(this).parent().parent();
        $(this).prop('checked', false);
        $(tr).removeClass("success");
    });
}