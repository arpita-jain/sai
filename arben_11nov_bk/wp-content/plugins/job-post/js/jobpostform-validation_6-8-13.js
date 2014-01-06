jQuery(function($) {
	     $('#job_postingform').validate({
                          onfocusout: function(element, event) {
	       this.element(element);
	       },
	       onkeyup: false,
		 rules: {
	      
		job_title: {
		   required: true      
	       },
               job_detail: {
		   required: true      
	       },
	      job_location: {
		   required: true      
	       },
	      post_code: {
		   required: true      
	       }
              },
                messages: {
                          job_title: "Job title is required.",
                          job_type:{
                          required: "Job type is required.",
                          },
                          job_detail:{
                          required: "Job detail is required.",
                          },
			  job_location:{
                          required: "Job location is required.",
                          },
			  post_code:{
                          required: "Post code is required.",
                          }
             }
                });
});
