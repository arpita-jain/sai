var InvoiceTable = function() {
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            $('#invoice_table').dataTable({
                "bFilter": false,
                "bPaginate": false,
                "aaSorting": [[2, "desc"]],                
                // set the initial value               
                "sDom": "<'row'<'col-lg-2'l><'col-lg-6'T><'col-lg-4'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",                
                "oTableTools": {
                    "aButtons": [
                    "pdf",
                    {
                        "sExtends": "text",
                        "sButtonText": "<i class='icon-email'></i> email",
                        "sMessage": 'Click delete',
                        "fnClick": CustomerMail
                    }                 
                    ],
                    "sSwfPath": base_path + "assets/plugins/data-tables/TableTools/media/swf/copy_csv_xls_pdf.swf"
                }
               
            });
          

        }

    };
}();
jQuery(document).ready(function() {
    InvoiceTable.init();
    $(".DTTT_button_pdf").addClass("btn btn-default btn-lg");
    $(".dataTables_info").hide();
 
});

function CustomerMail(){
    $('#customer_email').modal('show');     
}

function SendMail(){  
    if (validateInputs())
    {
        var email = $("#email").val();
        var subject = $("#subject").val();
        var message = $("#message").val();             
        $.ajax({
            type: 'post',
            dataType: 'json',
            acync: false,
            url: site_path + 'admin_ajax/MailToCustomer',
            data: {
                'email': email,
                'subject': subject,                    
                'message': message
            },
            success: function(data) {
                bootbox.alert(data.success);
            },
            complete: function() {
                $('#customer_email').modal('hide');
            }
        });
       
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
