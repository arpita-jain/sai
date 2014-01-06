jQuery(function($) {
	     $('#job_posting').validate({
                          onfocusout: function(element, event) {
	       this.element(element);
	       },
	       onkeyup: false,
		 rules: {
	      
              job_category: {
		   required: true      
	       },
               job_location: {
		   required: true      
	       },
               salary: {
		   required: true      
	       },
		company: {
		   required: true      
	       },
               contact: {
		   required: true      
	       },
               job_detail: {
		   required: true      
	       }
               
              },
                messages: {
                          job_category: "Please select a category",
			  job_location:{
                          required: "Job location is required.",
                          },
			  salary:{
                          required: "Salary is required.",
                          },
                          company:{
                          required: "Company is required.",
                          },
                          contact:{
                          required : "Contact is required",
                          },
                          job_detail:{
                          required : "Job detail is required",
                          }
             }
                });
});
