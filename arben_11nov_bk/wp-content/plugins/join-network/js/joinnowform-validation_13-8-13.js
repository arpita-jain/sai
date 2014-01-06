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
               company_name: {
		   required: true      
	       },
               address1: {
		   required: true      
	       },
               city: {
		   required: true      
	       },
               post_code: {
		   required: true ,
                  
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
               }
	//       mobile:
	//       {
	//	number:true
	//       },
	//       phone:
	//       {
	//	number:true
	//       }
               
                },
                messages: {
                          first_name: "first name is required.",
                          last_name:{
                          required: "last name is required."
                          },
                          company_name:{
                          required: "Company name is required."
                          },
                          address1:{
                          required: "Address is required.",
                          },
                          city:{
                          required: "City is required.",
                          },
                          post_code:{
                          required: "Post code is required.",
                          },
                          email_address:{
                          required: "Email is required.",
                          },
                          Confirm_Email:{
                          required: "Confirm Email is required.",
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
                           pwd:{
                               required: "Password is required.",         
                          }
                 }
                  });
});