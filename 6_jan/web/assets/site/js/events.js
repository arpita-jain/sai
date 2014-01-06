//For Event Detail Popup 
function viewEvent(id) {
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'kiosk/getTicketByEventId',
        data: {
            'eventId': id
        },
        success: function(data) {
            $("#viewData").empty();
            $("#viewData").append("<tr><td>Event Name</td><td>" + data.title + "</td></tr>");
            $("#viewData").append("<tr><td>Total Tickets</td><td>" + data.stockAvailable + "</td></tr>");
            $("#viewData").append("<tr><td>On</td><td>" + data.date+"," + data.day+  "</td></tr>");
            $("#viewData").append("<tr><td>Location</td><td>" + data.venue_name + "</td></tr>");
            $("#viewData").append("<tr><td>Price Per Ticket</td><td>" + data.price + "</td></tr>");
            $("#viewData").append("<tr><td>Description</td><td>" + data.description + "</td></tr>");
        },
        complete: function() {
            $('#viewEvent').modal('show');
        }
    });
}

function select_row(event){
   
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
function addtobasket(){
    
    var ids = new Object();
    var eventid = new Object();
    var venueid = new Object();
    var price = new Object();
    var i = 0;
    $(".checkboxes").each(function() {
        if ($(this).is(':checked'))
        {  
           
            eventid[i] = ($("#event_"+$(this).attr("id")).val());
            venueid[i] = ($("#venue_"+$(this).attr("id")).val());
            price[i] = ($("#price_"+$(this).attr("id")).val());
            ids[i] = $(this).attr("id");
            i++;
        }
    });
    
    
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'admin_ajax/addtobasket',
        data: {
            'ids': ids,
            'eventid': eventid,
            'venueid':venueid,
            'price':price
        },
        success: function(data) {             
            window.location.href = "basket";
        }
       
    });
    
}