var datacounter = 0;
var idsx = new Object();
function checkEventDate(dateobj)
{
    if ($(dateobj).is(':checked'))
    {
        idsx[datacounter] = $(dateobj).attr("id");
        datacounter++;
    } else {
        datacounter--;
    }
    var x = 0;
    var dateData = new Object();
    for (var i = 0; i < datacounter; i++)
    {
        if (idsx[i] != undefined || idsx[i] != null)
        {
            dateData[x] = idsx[i];
            x++;
        }
    }
    if (x)
    {
        idsx = dateData;
        datacounter = x;
    }
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'kiosk/addFiltersByDate',
        data: {
            'eventdate': dateData
        }
         
    });
}
var datacountery = 0;
var idsy = new Object();

//For checkboxes selection on events
function checkEvent(eventobj)
{
   if ($(eventobj).is(':checked'))
    {
        idsy[datacountery] = $(eventobj).attr("id");
        datacountery++;
    } else {
        datacountery--;
    }
    var y = 0;
    var eventData = new Object();
    for (var i = 0; i < datacountery; i++)
    {
        if (idsy[i] != undefined || idsy[i] != null)
        {
            eventData[y] = idsy[i];
            y++;
        }
    }
    if (y)
    {
        idsy = eventData;
        datacountery = y;
    }
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'kiosk/addFiltersByEvent',
        data: {
            'eventId': eventData
        }
    });
}

var datacounterz = 0;
var idsz = new Object();

//For checkboxes selection on Venues
function checkVenue(venueobj)
{
  if ($(venueobj).is(':checked'))
    {
        idsz[datacounterz] = $(venueobj).attr("id");
        datacounterz++;
    } else {
        datacounterz--;
    }
    var z = 0;
    var venueData = new Object();
    for (var i = 0; i < datacounterz; i++)
    {
        if (idsz[i] != undefined || idsz[i] != null)
        {
            venueData[z] = idsz[i];
            z++;
        }
    }
    if (z)
    {
        idsz = venueData;
        datacounterz = z;
    }
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'kiosk/addFiltersByVenue',
        data: {
            'venueId': venueData
        }
    });
}

var datacountert = 0;
var idst = new Object();

//For checkboxes selection on ticket for add to cart
function checkTicket(ticketobj)
{
    
  if ($(ticketobj).is(':checked'))
    {
        idst[datacountert] = $(ticketobj).attr("id");
        datacountert++;
    } else {
        datacountert--;
    }
    var t = 0;
    var ticketData = new Object();
    for (var i = 0; i < datacountert; i++)
    {
        if (idst[i] != undefined || idst[i] != null)
        {
            ticketData[t] = idst[i];
            t++;
        }
    }
    if (t)
    {
        idst = ticketData;
        datacountert = t;
    }
    $.ajax({
        type: 'post',
        dataType: 'json',
        async: false,
        url: site_path + 'kiosk/addTicketToBasket',
        data: {
            'ticketId': ticketData
        }
    });
}
