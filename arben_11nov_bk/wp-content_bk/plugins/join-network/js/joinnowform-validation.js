jQuery(function($) {
	     $('#join-form').validate({	       
	       onfocusout: function(element, event) {
	       this.element(element);
	       },
	       onkeyup: false,
		 rules: {
	      
		first_name: {
		   required: true      
	       },
 	       
	       last_name: {
		   required: true      
	       },
               address1: {
		   required: true      
	       },
               city: {
		   required: true      
	       },
              email_address: {
		   required: true,
                   email:true
                   },
               Confirm_Email: {
		   required: true,
                   email:true,
                   equalTo: '#email_address'
	       },
	       select_password: {
                        required: true,
                        minlength:6,
                        maxlength:10
			      },
	       Confirm_Password: {
                        required: true,
                        minlength:6,
                        maxlength:10,
                        equalTo: "#select_password"
	       },
               agree_option: {
                        required: true
               },
	       mobile:
	       {
		required: true,
                minlength:10,
		maxlength:20,
		number:true
	       },
	       phone:
	       {		
		minlength:6,
                maxlength:20,
		number:true
	       }
               
                },
                messages: {
                          first_name: "first name is required.",
                          last_name:{
                          required: "last name is required."
                          },
                          address1:{
                          required: "Address is required.",
                          },
                          city:{
                          required: "City is required.",
                          },
                          mobile:{
                          required: "Mobile no is required.",
                          },
                          email_address:{
                          required: "Email is required.",
                          },
                          Confirm_Email:{
                          required: "Email is required.",
                          },
                          select_password:{
                          required: "Password is required.",
                          },
                          Confirm_Password:{
                          required: " Confirm Password is required.",
                          }
                          
             }
                
             });
             
             /****** validations for login *********/
               $('#login_form').validate({	       
	       onfocusout: function(element, event) {
	       this.element(element);
	       },
	       onkeyup: false,
		 rules: {
                           log: {
		   required: true      
	       },
	       pwd: {
		   required: true      
	       }
                 }, messages: {
                          log:{
                               required: "Username is required.",          
                          },
                           log:{
                               required: "Username is required.",          
                          }
                 }
                  });
});
