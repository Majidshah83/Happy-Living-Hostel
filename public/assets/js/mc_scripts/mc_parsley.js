$(document).ready(function(){

	//////////////// COMMMON CUSTOM USEFUL VALIDATORS //////////////

	// Validate Title
  	$.validator.addMethod("validate_title", function(value, element) {
    
		//test user value with the regex
    	return this.optional( element ) || /^[0-9+']*$/.test( value );

  	}, "Allowed characters are: Alphanumeric and special character -&().");

  	jQuery.validator.addMethod("selectnic", function(value, element){
	    if (/^[0-9]{9}[vVxX]$/.test(value)) {
	        return false;  // FAIL validation when REGEX matches
	    } else {
	        return true;   // PASS validation otherwise
	    };
	}, "wrong nic number"); 

});

//////////////////////////////////////// START => COMMON HANDLER ////////////////////////////////////////

// Start => function validate_crud(crud_name='')
function validate_crud(crud_name='', form_id=''){

	// alert(crud_name);

	if(crud_name == 'pages'){

		validate_page_crud(crud_name, form_id);

	} // if(crud_name == 'pages')

	return '1';

} // End => function validate_crud(crud_name='')

//////////////////////////////////////// END => COMMON HANDLER //////////////////////////////////////////

//////////////////////////// START => VALIDATION RULES EVENTS FOR EACH CRUD /////////////////////////////

// Start => function validate_page_crud(crud_name='', form_id='')
function validate_page_crud(crud_name='', form_id=''){

	// Note: Individual field validation not supporting VALIDATORS FUNCTIONS
	
	/*
	var instance = $('#title').parsley({
 
		required: true

	});

	instance.validate();
	var is_valid = instance.isValid();

	console.log(is_valid);
	*/

	// JQUERY VALIDATION - NOT PARSLEY

	$('#mc-add-edit-formssss').validate({
			    
	    rules: {
	      
	      	title: {
	        	required: true
	      	},

	    },

	    submitHandler: function(form) { // for demo
	      // alert('valid form submitted'); // for demo
	      return true; // for demo
	    }

  	});
  	
} // End => function validate_page_crud(crud_name='', form_id='')

