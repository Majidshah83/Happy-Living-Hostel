$(document).ready(function(){

    /* --------------- Start => BUSINESS RULES --------------- */

    /*
    
    ::::: Addresses :::::

        => address_1, address_2, address_3 [ maxlength: 200 ]
        => postcode [ maxlength: 12 ]
        => town/city, county [ maxlength: 100 ]

    ::::: Contact Details / Login Details :::::

        => first_name, last_name [ maxlength: 100 ]
        => contact_no, mobile_no, fax [ maxlength: 16 ]
        => email_address, email [ maxlength: 100 ]
        => password [ minlength: 8, maxlength: 20 ]

    ::::: All Titles :::::

        => pharmacy_name, business_name, title, service_title, post_title, etc... [ maxlength: 200 ]
        => reg_no, nhs_no, gphc, emergency_no, etc... [ maxlength: 50 ]

    ::::: Meta Data :::::

        => meta_title [ maxlength: 200 ]
        => meta_keywords [ maxlength: 200 ]
        => meta_description [ maxlength: 300 ]
    
    ::::: External Url :::::

        => external_url [ maxlength: 300 ]

    ::::: Url Slug :::::

        => url_slug, slug [ maxlength: 400 ]

    ::::: FA Icon :::::

        => fa_icon [ maxlength: 20 ]

    */

    /* ---------------- End => BUSINESS RULES ---------------- */

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////// START => DEFINE CUSTOM VALIDATORS /////////////////////////////////////////////

    // (1) => Alphanumeric
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[\w ]+$/i.test(value);
    }, "Letters, numbers only please");

    // (2) => Email Address
    $.validator.addMethod("validate_email", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
    }, 'Please enter a valid email address.');

    // (3) => Mobile Number
    jQuery.validator.addMethod("validate_mobile_number", function(value, element) {
        return this.optional( element ) || /^[0-9+']*$/.test( value );
    }, 'Please enter a valid contact number.');

    //////////////////////////////////// NEW METHODS ////////////////////////////////////

    // validate_titles
    jQuery.validator.addMethod("validate_titles", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-+,.#&?()']*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -+,.#&?()'");

    // validate_metatitles_titles
    jQuery.validator.addMethod("validate_meta_titles", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-+,.#&?()£|/']*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -+,.#&?()£|/'");

    // validate_password
    jQuery.validator.addMethod("validate_password", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-()]*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -()");

    // validate_grade
    jQuery.validator.addMethod("validate_grade", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-+_,.#&?%/()']*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -+_.#&?%/()'");

    // validate_textareas
    jQuery.validator.addMethod("validate_textareas", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-().,]*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -().,");

    // combined_address
    jQuery.validator.addMethod("combined_address", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-().,']*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -().,'");

    // validate_url_slug
    jQuery.validator.addMethod("validate_url_slug", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-]*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -");

    $.validator.addMethod("max_len", function (value, element, len){
        return value == "" || value.length <= len;
     });

    // pharmacy_validate_titles
    jQuery.validator.addMethod("pharmacy_validate_titles", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-(),]*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -()'");

     // pharmacy_validate_description
     jQuery.validator.addMethod("pharmacy_validate_description", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9\s-(),]*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -()'");

    // pharmacy_contact_numbers
     jQuery.validator.addMethod("pharmacy_contact_numbers", function(value, element) {
        return this.optional( element ) || /^[0-9\s-()+ ]*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -()'");
    
      // pharmacy_validate_social_media_urls
      jQuery.validator.addMethod("pharmacy_validate_social_media_urls", function(value, element){
        return this.optional( element ) || /^[a-zA-Z0-9\s-()/:,.]*$/.test(value);
    }, "Allowed characters are: Alphanumeric and special character -()'");


    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      }, 'File size must be less than {0} bytes');
  

    ///////////////////////////////////////////// END => DEFINE CUSTOM VALIDATORS /////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $('.common-crud-form').on('submit', function(){
    
        var crud_name = $('.common-crud-form').find('#crud_name').val();
        var is_valid = validate_form(crud_name);

        //alert(is_valid);

        if(is_valid == false){
            
            // mc_notify_crud('danger', 'Please fix form errors.');

        } else {

            mc_submit_crud();

        } // if(is_valid == false)

    }); // submit => form.common-crud-form
    // Login Page Validate Event

}); // $(document).ready(function()

// Start => function validate_form(crud_name='')
function validate_form(crud_name=''){

    if(crud_name == '') return false;

    var form_class = 'common-crud-form';

    if(crud_name == 'pages'){

        return validate_pages_form(form_class);

    } else if(crud_name == 'qualifications'){

        return validate_qualifications_form(form_class);

    } else if(crud_name == 'employment_history'){

        return validate_employment_history_form(form_class);

    } else if(crud_name == 'page_sections'){

        return validate_page_sections_form(form_class);

    } else if(crud_name == 'faqs'){

        return true; // validate_faqs_form(form_class);

    } else if(crud_name == 'download'){
        
        return validate_download_form(form_class);

    } else if(crud_name == 'testimonials'){
        
        return validate_testimonials_form(form_class);

    } else if(crud_name == 'news_alerts'){
        
        return validate_news_alerts_form(form_class);

    } else if(crud_name == 'awards'){
        
        return validate_awards_form(form_class);

    } else if(crud_name == 'splash'){
        
        return validate_splash_form(form_class);

    }else if(crud_name == 'banners'){
        
        return validate_banner_form(form_class);

    } // if(crud_name == 'pages')

} // End => function validate_form(crud_name='')

// Start => function validate_pages_form(form_class='')
function validate_pages_form(form_class=''){


    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            title: {
                
                required: true,
                maxlength: 200,
                validate_titles: true

            },
            
            image: {
                // required: true,
                accept: "image/*",
                filesize: 5000000
            },

            meta_title: { maxlength: 200, validate_titles:true },
            meta_keywords: { maxlength: 200 , validate_titles:true},
            meta_description: { maxlength: 300 , validate_titles:true},

            url_slug: {

                required: true,
                maxlength: 400,
                validate_url_slug: true

            }

        },

        messages: {
            
            image: {
                
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"
            
            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_pages_form(form_class='')

// Start => function validate_qualifications_form(form_class='')
function validate_qualifications_form(form_class=''){

    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            title: {
                
                required: true,
                maxlength: 200,
                validate_titles: true

            },

            organisation: {

                required: true,
                maxlength: 200,
                validate_titles: true

            },

            from_date: {

                required: true

            },

            to_date: {

                required: true

            },

            grade: {

                maxlength: 50,
                validate_grade: true

            },

            certificate: {
                
                extension: "jpg|jpeg|png|gif|pdf|doc|docm|docx|csv|xls|xlsx",
                filesize: 5000000

            },

            comments: {

                maxlength: 700,
                validate_titles: true

            }

        },
        messages: {
            
            certificate: {
                
                extension: "Allowed file types are: jpg, jpeg, png, gif, pdf, doc, docm, docx, csv, xls, xlsx",
                filesize: "File size should be less than 5MB",
            
            },

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_qualifications_form(form_class='')

// Start => function validate_employment_history_form(form_class='')
function validate_employment_history_form(form_class=''){

    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            title: {
                
                required: true,
                maxlength: 200,
                validate_titles: true
            },

            company_name: {

                required: true,
                maxlength: 200,
                validate_titles: true

            },

            company_address: {

                maxlength: 500,
                validate_titles: true

            },

            start_date: {

                required: true

            },

            end_date: {

                required: true

            },

            responsibilities: {

                maxlength: 700,
                validate_titles: true

            },

            accomplishments_skills: {

                maxlength: 700,
                validate_titles: true

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_employment_history_form(form_class='')

// Start => function validate_page_sections_form(form_class='')
function validate_page_sections_form(form_class=''){


    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            title: {
                
                required: true,
                maxlength: 200,
                validate_titles: true

            },

            meta_title: { maxlength: 200, validate_titles:true },
            meta_keywords: { maxlength: 200 , validate_titles:true},
            meta_description: { maxlength: 300 , validate_titles:true},

            url_slug: {

                required: true,
                maxlength: 200,
                validate_url_slug: true

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_page_sections_form(form_class='')

// Start => function validate_faqs_form(form_class='')
function validate_faqs_form(form_class=''){

    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            question: {
                
                required: true
            },

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_faqs_form(form_class='')

// Start => function validate_download_form(form_class='')
function validate_download_form(form_class=''){


    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            title: {
                
                required: true,
                maxlength: 200,
                validate_titles: true

            },
            file_name: {
                
                extension: "jpg|jpeg|png|gif|pdf|doc|docm|docx|csv|xls|xlsx",
                filesize: 5000000

            },

        },

        messages: {
            
            file_name: {
                
                extension: "Allowed file types are: jpg, jpeg, png, gif, pdf, doc, docm, docx, csv, xls, xlsx",
                filesize: "File size should be less than 5MB",
            
            },
        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_download_form(form_class='')

// Start => function validate_testimonials_form(form_class='')
function validate_testimonials_form(form_class=''){


    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            full_name: {
                
                required: true,
                maxlength: 200,
                validate_titles: true

            },

            comments:{

                // maxlength: 700

            },

            image: {

                // required: true,
                accept: "image/*",
                filesize: 5000000

            },

            company_name: {
                
                maxlength: 200,
                validate_titles: true

            },

            designation: {
                
                maxlength: 200,
                validate_titles: true

            },

            url: {
                
                maxlength: 300

            },

            date: {
                
                maxlength: 50

            }

        },

        messages: {
            
            image: {
                
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_testimonials_form(form_class='')

// Start => function validate_news_alerts_form(form_class='')
function validate_news_alerts_form(form_class=''){

    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            alert_text: {
                
                required: true,
                maxlength: 300,
                validate_titles: true

            },

            url: {
                
                required: true,
                maxlength: 300,

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_news_alerts_form(form_class='')

// Start => function validate_awards_form(form_class='')
function validate_awards_form(form_class=''){


    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            title: {
                
                required: true,
                maxlength: 200,
                validate_titles: true

            },

            sub_title: {
                
                maxlength: 200,
                validate_titles: true

            },

            url: {
                
                maxlength: 300

            },

            description:{

                // maxlength: 700

            },
            
            award_image_thumbnail: {
                
                // required: true,
                accept: "image/*",
                filesize: 5000000

            },

            award_image_big: {
                
                // required: true,
                accept: "image/*",
                filesize: 5000000

            },

        },

        messages: {
            
            award_image_thumbnail: {
                
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"

            },
            
            award_image_big: {
            
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"

            },
        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_awards_form(form_class='')

// Start => function validate_splash_form(form_class='')
function validate_splash_form(form_class=''){


    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {

            title: {
                
                required: true,
                maxlength: 300,
                validate_titles: true

            },
            
            description: {

                // maxlength: 700,

            },

            image: {
             
                // required: true,
                accept: "image/*",
                filesize: 5000000

            },

            url: {
                
                required: true,
                maxlength: 300

            }

        },

        messages: {
            
            image: {
                
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"
            
            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_splash_form(form_class='')

//////////////////////////////////////////////////////////////////////////////////
/////////////////////// Start => function mc_submit_crud() ///////////////////////

function mc_submit_crud(){

    

    var data = new FormData(document.getElementById("mc-add-edit-form"));

    var form_editors_obj = $('#mc-add-edit-form').find('.mc-text-editor-element');

    if( form_editors_obj.length > 0 ){

        $.each(form_editors_obj, function(k, e){

            data.delete( $(e).attr('name') );
            var description = CKEDITOR.instances[$(e).attr('id')].getData();
            data.append($(e).attr('name'), description);

        }); // $.each(form_editors_obj, function(k, v)

    } // if( form_editors_obj.length > 0 )

    $.ajax({

        type: "POST",
        url: "/common",
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        data: data,
        beforeSend: function(result) {
     
            $(".bootstrap_loader").css("display", 'block');

            $('#crud_errors_div').addClass('d-none');
            $('#crud_errors_ul').html('');

        },
        success: function(response) {
           
            $(".bootstrap_loader").css("display", 'none');

            mc_notify('success', response.message);

            $('#crud_errors_div').addClass('d-none');
            $('#crud_errors_ul').html('');

            location.reload();

        },
        error: function(xhr, status, error) {
        
            $(".bootstrap_loader").css("display", 'none');

            $.each(xhr.responseJSON.errors, function(key, item) {
                
                // mc_notify_crud('danger', item);

                $('#crud_errors_div').removeClass('d-none');

                var new_html = '<li> '+ item +' </li>';
                $('#crud_errors_ul').append(new_html);

            });
        }

    }); // $.ajax

} // End => function mc_submit_crud()

/////////////////////// End => function mc_submit_crud() ///////////////////////
////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// Start => INDEPENDENT MODULES VALIDATION FUNCTIONS ///////////////////////

// Start => function validate_staff_profile_form(form_id='')
function validate_staff_profile_form(form_id=''){

    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
          
            first_name: {
                
                required: true,
                maxlength: 100,
                validate_titles: true

            },

            last_name: {

                required: true,
                maxlength: 100,
                validate_titles: true

            },

            gender: {

                required: true

            },

            contact_number: {

                maxlength: 16,
                validate_mobile_number: true

            },

            day: {

                required: true
            },

            month: {

                required: true
            },

            year: {

                required: true
            },

            role_id: {

                required: true

            },

            gphc_number: {

                maxlength: 50,
                validate_titles: true

            },

            speciality: {

                maxlength: 300,
                validate_titles: true

            },

            locum_work: {

                maxlength: 300,
                validate_titles: true

            },

            description: {

                // validate_titles: true

            },

            address1: {

                required: true,
                maxlength: 200,
                validate_titles: true

            },

            address2: {

                maxlength: 200,
                validate_titles: true

            },

            address3: {

                maxlength: 200,
                validate_titles: true

            },

            address_city_town: {

                required: true,
                maxlength: 100,
                validate_titles: true

            },

            country: {

                maxlength: 100,
                validate_titles: true

            },

            postcode: {

                required: true,
                maxlength: 12,
                validate_titles: true

            },

            profile_picture: {

                // required: true,
                accept: "image/*",
                filesize: 5000000

            },

            signature: {

                // required: true,
                accept: "image/*",
                filesize: 5000000

            }

        },

        messages: {

            profile_picture: {
                    
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"
            
            },

            signature: {
                    
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"
            
            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_staff_profile_form(form_id='')

// Start => function validate_add_edit_staff_form(form_id='')
function validate_add_edit_staff_form(form_id=''){

    if(form_id == '') return false;
    var validator = $('#'+form_id).validate({

        rules: {
          
            first_name: {
                
                required: true,
                maxlength: 100,
                validate_titles: true

            },

            last_name: {

                required: true,
                maxlength: 50,
                validate_titles: true

            },

            role_id: {

                required: true

            },

            responsibility_id: {

                // required: true

            },

            contact_number: {

                maxlength: 16,
                validate_mobile_number: true

            },

            email: {

                required: true,
                maxlength: 100,
                validate_email: true

            },

            password: {

                required: true,
                minlength: 8,
                maxlength: 20

            },

            password_confirmation: {

                required: true,
                equalTo: "#password",
                minlength: 8,
                maxlength: 20

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_add_edit_staff_form(form_id='')

// Start => function validate_add_edit_unarchive_staff_form(form_id='')
function validate_add_edit_unarchive_staff_form(form_id=''){

    return true;

    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
          
            role_id: {

                required: true

            },

            responsibility_id: {

                // required: true

            },

            email: {

                required: true,
                maxlength: 100,
                validate_email: true

            },

            admin_note: {

                maxlength: 700,
                validate_titles: true

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_add_edit_unarchive_staff_form(form_id='')

// Start => function validate_change_credentials_form(form_id='')
function validate_change_credentials_form(form_id=''){

    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
          
            password: {

                required: true,
                minlength: 8,
                maxlength: 20

            },

            password_confirmation: {

                required: true,
                equalTo: "#password",
                minlength: 8,
                maxlength: 20

            },

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_change_credentials_form(form_id='')

// Start => function validate_staff_profile_email_form(form_id='')
function validate_staff_profile_email_form(form_id=''){

    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
          
            email: {

                required: true,
                validate_email: true

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_staff_profile_email_form(form_id='')


// Start => function validate_login_form()
function validate_login_form(){

    var validator = $('#login-form').validate({

        rules: {
          
            email_address: {
                
                required: true,
                // max_len: 60,
                // maxlength: 18,
                validate_email: true

            },

            password: {

                required: true,
                // validate_password:true

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_login_form()


// Start => function validate_staff_add_form()
function validate_staff_add_form(){

    var validator = $('#md-add-staff-form').validate({

        rules: {
          
            first_name: {
                
                required: true,
                maxlength: 50,
                validate_titles: true

            },

            last_name: {
                
                required: true,
                maxlength: 50,
                validate_titles: true

            },

            gender: {
                
                required: true

            },

            day: {
                
                required: true

            },

            month: {
                
                required: true

            },

            year: {
                
                required: true

            },

            contact_no: {
                
                validate_titles: true

            },

            nhs_no: {
                
                validate_titles: true

            },

            address_1: {
                
                required: true,
                validate_titles: true

            },

            address_2: {
                
                validate_titles: true

            },

            address_3: {
                
                validate_titles: true

            },

            town: {
                
                required: true,
                validate_titles: true

            },

            county: {
                
                validate_titles: true

            },

            postcode: {
                
                required: true,
                validate_titles: true

            },

            email_address: {
                
                required: true,
                maxlength: 100,
                validate_email: true

            },

            password: {

                required: true,
                maxlength: 50

            },

            i_agree: {

                required: true

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_staff_add_form()

//START OF => function validate_add_edit_menu_form(form_id=''){
function validate_add_edit_menu_form(form_id=''){
    
    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
            
            title: { 

                required: true,
                maxlength: 200,
                validate_titles: true

            },

            description: {
                maxlength: 300,
                validate_titles: true
            },
            
            position_id: {

                required: true

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} //function validate_add_edit_menu_form(form_id=''){

// Start => function validate_add_edit_menu_link_form(form_id=''){
function validate_add_edit_menu_link_form(form_id=''){

    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
            
            title: { 

                required: true,
                maxlength: 200,
                validate_titles: true

            },

            reference_type: {
                required: true
            },

            service_id: {
                required: true
            },

            page_id: {
                required: true
            },

            static_page_id: {
                required: true
            },

            reference_url: {
                
                required: true,
                maxlength: 300

            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => validate_add_edit_menu_link_form(form_id='')

//START OF => function validate_add_edit_pharmacy_blog_form(form_id=''){
    function validate_add_edit_pharmacy_blog_form(form_id=''){

        if(form_id == '') return false;
        var validator = $('#'+form_id).validate({
    
            rules: {
                
                title: { required: true, maxlength: 200 , validate_titles:true},
                
                description: {

                    // required: true, maxlength: 500, pharmacy_validate_description:true

                },

                tags:{},
                
                meta_title: { maxlength: 200, validate_titles: true },
                meta_keywords: { maxlength: 200 , validate_titles: true },
                meta_description: { maxlength: 300 , validate_titles: true },
                
                slug: {

                    required: true,
                    maxlength: 400,
                    validate_url_slug: true

                },

                image: {
                    // required: true,
                    accept: "image/*",
                    filesize: 5000000
                }
    
            },
            
            messages: {
                
                image: {
                    
                    accept: "Please select a valid image.",
                    filesize: "File size should be less than 5MB"
                
                }

            },
    
            submitHandler: function(form) {
                // mc_submit_crud();
            }

        });

        return validator.form();
    
    } //function validate_add_edit_pharmacy_blog_form(form_id=''){
    //END OF => function validate_add_edit_pharmacy_blog_form(form_id=''){

//START OF => function validate_add_edit_pharmacy_category_form(form_id=''){
function validate_add_edit_pharmacy_category_form(form_id=''){


    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
            
            title: { required: true, maxlength: 200, validate_titles: true },
            description: { 

                // maxlength: 500

            },
            
            meta_title: { maxlength: 200, validate_titles: true },
            meta_keywords: { maxlength: 200 , validate_titles: true },
            meta_description: { maxlength: 300 , validate_titles: true },
            
            slug: {

                required: true,
                maxlength: 400,
                validate_url_slug: true

            },

            image: {
                // required: true,
                accept: "image/*",
                filesize: 5000000
            }

        },
        messages: {

            image: {
                
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"
            
            }

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} //function validate_add_edit_pharmacy_category_form(form_id=''){
//END OF => function validate_add_edit_pharmacy_category_form(form_id=''){

// Start => function validate_add_edit_patient_form(form_id='')
function validate_add_edit_patient_form(form_id=''){


    if(form_id == '') return false;

    var validator = $('#'+form_id).validate({

        rules: {
          
            first_name: {
                
                required: true,
                maxlength: 100,
                validate_titles: true

            },

            last_name: {

                required: true,
                maxlength: 100,
                validate_titles: true

            },

            contact_no: {

                maxlength: 16,
                validate_mobile_number: true

            },

            nhs_no: {

                maxlength: 50,
                validate_titles: true

            },

            gender: {

                required: true

            },

            day: {

                required: true
            },

            month: {

                required: true
            },

            year: {

                required: true
            },

            address_1: { required:true, maxlength: 200, validate_titles: true },
            address_2: { maxlength: 200, validate_titles: true },
            address_3: { maxlength: 200, validate_titles: true },
            town: { required:true, maxlength: 100, validate_titles: true },
            county: { maxlength: 100, validate_titles: true },
            postcode: { required:true, maxlength: 12, validate_titles: true },

            email_address: {

                required: true,
                maxlength: 100,
                validate_email: true

            },

            password: {

                required: true,
                minlength: 8,
                maxlength: 20

            },

            password_confirmation: {

                required: true,
                equalTo: "#password",
                minlength: 8,
                maxlength: 20

            },

        },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_add_edit_patient_form(form_id='')


// Start => function validate_banner_form(form_class='')
function validate_banner_form(form_class=''){


    if(form_class == '') return false;

    var validator = $('.'+form_class).validate({

        rules: {
          
            title: {
                
                required: true,
                maxlength: 200,
                validate_titles: true

            },

            reference_type: {

                required: true
            
            },

            service_id: {
                required: true
            },

            page_id: {
                required: true
            },

            static_page_id: {
                required: true
            },

            reference_url: {
                required: true
            },

            image: {
                
                // required: true,
                accept: "image/*",
                filesize: 5000000

            },

        },
        messages: {
            
            image: {
            
                accept: "Please select a valid image.",
                filesize: "File size should be less than 5MB"

            }

          },

        submitHandler: function(form) {
            // mc_submit_crud();
        }

    });

    return validator.form();

} // End => function validate_banner_form(form_class='')

// START OF => function validate_pharmacy_add_edit(){
    function validate_pharmacy_add_edit(form_id=''){

        if(form_id == '') return false;
    
        var validator = $('#'+form_id).validate({
    
            rules: {
              
                title: {
                    
                    required: true,
                    maxlength: 50,
                    validate_titles: true
    
                },
    
                intro: {
    
                    required: true,
                    maxlength: 50,
                    validate_titles: true
    
                },
    
                description: {
    
                    required:true,
                    maxlength: 700
    
                },
    
                meta_title: { maxlength: 100, pharmacy_validate_titles:true },
                meta_keywords: { maxlength: 100 , pharmacy_validate_titles:true},
                meta_description: { maxlength: 300 , pharmacy_validate_description:true},
    
                fa_icon:{
    
                },
    
                external_service_url:{
    
                }
    
            },
    
            submitHandler: function(form) {
                // mc_submit_crud();
            }
    
        });
    
        return validator.form();
    
    } //function validate_pharmacy_add_edit(){
    //END OF => function validate_pharmacy_add_edit(){

    // START OF => function validate_pharmacy_service_add_edit(){
    function validate_pharmacy_service_add_edit(form_id=''){
        
        if(form_id == '') return false;
    
        var validator = $('#'+form_id).validate({

            rules: {
              
                title: {
                    
                    required: true,
                    maxlength: 200,
                    validate_titles: true
    
                },
    
                intro: {
    
                    required: true,
                    maxlength: 400,
                    validate_titles: true
    
                },
    
                /*description: {
    
                    required:true,
                    maxlength: 700
    
                },*/

                image: {
                    
                    // required: true,
                    accept: "image/*",
                    filesize: 5000000

                },

                thumbnail: {
                    
                    // required: true,
                    accept: "image/*",
                    filesize: 5000000

                },
                
                slug: {

                    required: true,
                    maxlength: 400,
                    validate_url_slug: true

                },
    
                meta_title: { maxlength: 200, validate_meta_titles: true },
                meta_keywords: { maxlength: 200 , validate_titles: true},
                meta_description: { maxlength: 300 , validate_titles: true},
    
                fa_icon:{
                    
                    maxlength: 20,
                    validate_titles: true

                },
    
                external_service_url:{

                    maxlength: 300,
        
                }
    
            },

            messages: {
                
                image: {
                    
                    accept: "Please select a valid image.",
                    filesize: "File size should be less than 5MB"

                },

                thumbnail: {
                    
                    accept: "Please select a valid image.",
                    filesize: "File size should be less than 5MB"

                }

            },

    
            submitHandler: function(form) {
                // mc_submit_crud();
            }
    
        });
    
        return validator.form();
    
    } //function validate_pharmacy_service_add_edit(){
    //END OF => function validate_pharmacy_service_add_edit(

    // Start => function validate_pharmacy_service_settings(form_id='')
    function validate_pharmacy_service_settings(form_id=''){

        if(form_id == '') return false;

        var validator = $('#'+form_id).validate({

            rules: {
              
                customer_note: { maxlength: 700, validate_titles: true },
                
            },

            submitHandler: function(form) {
                // mc_submit_crud();
            }

        });

        return validator.form();

    } // End => function validate_pharmacy_service_settings(form_id='')

    //START OF => function headerandlogo_btn(form_id=''){
    function validate_headerandlogo_frm(form_id=''){

      
        
        if(form_id == '') return false;

        var validator = $('#'+form_id).validate({
    
            rules: {
              
                meta_title: {
                    
                    maxlength: 200,
                    validate_titles: true

                },

                meta_keywords: {

                    maxlength: 200,
                    validate_titles: true

                },

                meta_description: {

                    maxlength: 300,
                    validate_titles: true

                },

                about_us_text: {

                    // maxlength: 700

                },

                website_logo: {

                    // required: true,
                    accept: "image/*",
                    filesize: 5000000

                },

                favicon: {

                    // required: true,
                    accept: "image/*",
                    filesize: 5000000

                },

                nhs_logo: {

                    // required: true,
                    accept: "image/*",
                    filesize: 5000000

                },

                about_us_logo: {

                    // required: true,
                    accept: "image/*",
                    filesize: 5000000

                },

            },

            messages: {
                
                website_logo: {
                    
                    accept: "Please select a valid image.",
                    filesize: "File size should be less than 5MB"

                },

                favicon: {
                    
                    accept: "Please select a valid image.",
                    filesize: "File size should be less than 5MB"

                },

                nhs_logo: {
                    
                    accept: "Please select a valid image.",
                    filesize: "File size should be less than 5MB"

                },
                
                about_us_logo: {
                    
                    accept: "Please select a valid image.",
                    filesize: "File size should be less than 5MB"

                }

            },
    
            submitHandler: function(form) {
                // mc_submit_crud();
            }
    
        });
    
        return validator.form();
    
    } //function headerandlogo_btn(form_id=''){
//END OF => function headerandlogo_btn(form_id=''){
    

//START OF => function pharmacy_profile_form(form_id=''){
    function pharmacy_profile_form(form_id=''){

   

        if(form_id == '') return false;
    
        var validator = $('#'+form_id).validate({
    
            rules: {
          
                address_1: { required: true, maxlength: 200, validate_titles: true },
                address_2: { maxlength: 200, validate_titles: true },
                address_3: { maxlength: 200, validate_titles: true },
                town: { required: true, maxlength: 100, validate_titles: true },
                county: { maxlength: 100, validate_titles: true },
                postcode: { required: true, maxlength: 12, validate_titles: true },
                company_registered_in: { maxlength: 50, validate_titles: true },
                registration_number: { maxlength: 50 , validate_titles: true},
                gphc_no: { maxlength: 50 , validate_titles: true},
                si_pharmacist: { maxlength: 200, validate_titles: true },
    
            },
    
            submitHandler: function(form) {
                // mc_submit_crud();
            }
    
        });
    
        return validator.form();
    
    } //function pharmacy_profile_form(form_id=''){
    //END OF => function pharmacy_profile_form(form_id=''){
    
    //START OF => function validate_contactinfo_frm(form_id=''){
    function validate_contactinfo_frm(form_id=''){


        if(form_id == '') return false;
    
        var validator = $('#'+form_id).validate({
    
            rules: {
              
                contact_no_1: { required: true, maxlength: 16, validate_mobile_number: true },
                contact_no_2: { maxlength: 16, validate_mobile_number: true },
                
                email_address_1: { required: true, maxlength: 100, validate_email: true },
                email_address_2: { maxlength: 100, validate_email: true },
                
                fax_no: { maxlength: 16 , validate_mobile_number: true },

                emergency_no_1: { maxlength: 50 , validate_titles: true },
                emergency_no_2: { maxlength: 50 , validate_titles: true },
                emergency_no_3: { maxlength: 50 , validate_titles: true },

            },
    
            submitHandler: function(form) {
                // mc_submit_crud();
            }
    
        });
    
        return validator.form();
    
    } //function validate_contactinfo_frm(form_id=''){
    //END OF => function validate_contactinfo_frm(form_id=''){
    
    //START OF => function validate_socialmedia_form(form_id=''){
    function validate_socialmedia_form(form_id=''){

      
        if(form_id == '') return false;

        var validator = $('#'+form_id).validate({

            rules: {
              
                facebook_url: { maxlength: 300 },
                twitter_url: { maxlength: 300 },
                linkedin_url: { maxlength: 300 },
                youtube_url: { maxlength: 300 },
                instagram_url: { maxlength: 300 }
                
            },

            submitHandler: function(form) {
                // mc_submit_crud();
            }

        });

        return validator.form();

    } //function validate_socialmedia_form(form_id=''){
    //END OF => function validate_socialmedia_form(form_id=''){

    // Start => function validate_opening_hours_frm(form_id='')
    function validate_opening_hours_frm(form_id=''){

        if(form_id == '') return false;

        var validator = $('#'+form_id).validate({

            rules: {
              
                extra_info: { maxlength: 700, validate_titles: true },
                
            },

            submitHandler: function(form) {
                // mc_submit_crud();
            }

        });

        return validator.form();

    } // End => function validate_opening_hours_frm(form_id='')

    // Start => function validate_email_template_frm(form_id='')
    function validate_email_template_frm(form_id=''){

        return true;

        if(form_id == '') return false;

        var validator = $('#'+form_id).validate({

            rules: {
              
                type_name: { required: true, maxlength: 200, validate_titles: true },
                email_title: { required: true, maxlength: 200, validate_titles: true },
                email_subject: { required: true, maxlength: 200, validate_titles: true },
                // email_body: { required: true, maxlength: 1200, validate_titles: true },
                
            },

            submitHandler: function(form) {
                // mc_submit_crud();
            }

        });

        return validator.form();

    } // End => function validate_email_template_frm(form_id='')

    // Start => function validate_add_single_branch_frm(form_id='')
    function validate_add_single_branch_frm(form_id=''){


        if(form_id == '') return false;

        var validator = $('#'+form_id).validate({

            rules: {
                
                first_name: {

                    required: true,
                    maxlength: 100,
                    validate_titles: true

                },

                last_name: {

                    required: true,
                    maxlength: 100,
                    validate_titles: true

                },

                email: {

                    required: true,
                    maxlength: 100,
                    validate_email: true

                },

                password: {

                    required: true,
                    minlength: 8,
                    maxlength: 20

                },

                role_id: {

                    required: true

                },

                pharmacy_name: {

                    required: true,
                    maxlength: 200,
                    validate_titles: true

                },

                contact_no_1: {

                    maxlength: 16,
                    validate_mobile_number: true

                },

                contact_no_2: {

                    maxlength: 16,
                    validate_mobile_number: true

                },

                email_address_1: {

                    required: true,
                    maxlength: 100,
                    validate_email: true

                },

                email_address_2: {

                    maxlength: 100,
                    validate_email: true

                },

                address_1: {
                    
                    required: true,
                    maxlength: 200,
                    validate_titles: true

                },

                address_2: {
                    
                    maxlength: 200,
                    validate_titles: true

                },

                address_3: {
                    
                    maxlength: 200,
                    validate_titles: true

                },

                town: {
                    
                    required: true,
                    maxlength: 100,
                    validate_titles: true

                },

                county: {
                    
                    maxlength: 100,
                    validate_titles: true

                },

                postcode: {
                    
                    required: true,
                    maxlength: 12,
                    validate_titles: true

                }
                
            },

            submitHandler: function(form) {
                // mc_submit_crud();
            }

        });

        return validator.form();

    } // End => function validate_add_single_branch_frm(form_id='')

/////////////////////// End => INDEPENDENT MODULES VALIDATION FUNCTIONS ///////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////